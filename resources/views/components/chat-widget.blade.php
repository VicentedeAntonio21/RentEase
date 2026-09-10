<div
    x-data="{
        open: false,
        loading: false,
        input: '',
        messages: [
            { role: 'assistant', content: 'Hi! I\'m the RentEase assistant. Ask me anything about browsing listings, applying for a unit, or listing your property.' }
        ],
        async send() {
            const text = this.input.trim();
            if (!text || this.loading) return;

            this.messages.push({ role: 'user', content: text });
            this.input = '';
            this.loading = true;

            this.$nextTick(() => this.scrollToBottom());

            try {
                const history = this.messages.slice(0, -1).slice(-10);

                const res = await fetch('{{ route('chat.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                    },
                    body: JSON.stringify({ message: text, history }),
                });

                const data = await res.json();
                this.messages.push({ role: 'assistant', content: data.reply });
            } catch (e) {
                this.messages.push({ role: 'assistant', content: 'Sorry, something went wrong. Please try again.' });
            } finally {
                this.loading = false;
                this.$nextTick(() => this.scrollToBottom());
            }
        },
        scrollToBottom() {
            const el = this.$refs.scrollArea;
            if (el) el.scrollTop = el.scrollHeight;
        }
    }"
    class="fixed bottom-6 right-6 z-50"
>
    <!-- Chat bubble button -->
    <button
        @click="open = !open"
        class="w-14 h-14 rounded-full bg-primary text-white shadow-lg flex items-center justify-center hover:bg-primary-dark transition-transform hover:scale-105"
    >
        <i class="text-2xl" :class="open ? 'ri-close-line' : 'ri-chat-3-line'"></i>
    </button>

    <!-- Chat window -->
    <div
        x-show="open"
        x-cloak
        x-transition
        class="absolute bottom-20 right-0 w-80 sm:w-96 bg-white dark:bg-[#252B3E] rounded-2xl shadow-xl border border-gray-100 dark:border-white/5 flex flex-col overflow-hidden"
        style="height: 480px;"
    >
        <!-- Header -->
        <div class="bg-primary text-white p-4 flex items-center gap-3">
            <span class="w-9 h-9 rounded-full bg-white/20 flex items-center justify-center">
                <i class="ri-robot-2-line"></i>
            </span>
            <div>
                <p class="font-heading font-semibold text-sm">RentEase Assistant</p>
                <p class="text-xs text-white/70">Ask me anything</p>
            </div>
        </div>

        <!-- Messages -->
        <div x-ref="scrollArea" class="flex-1 overflow-y-auto p-4 space-y-3">
            <template x-for="(msg, index) in messages" :key="index">
                <div :class="msg.role === 'user' ? 'flex justify-end' : 'flex justify-start'">
                    <div
                        :class="msg.role === 'user'
                            ? 'bg-primary text-white rounded-2xl rounded-br-sm'
                            : 'bg-gray-100 dark:bg-white/10 text-gray-700 dark:text-gray-200 rounded-2xl rounded-bl-sm'"
                        class="px-4 py-2 text-sm max-w-[85%]"
                        x-text="msg.content"
                    ></div>
                </div>
            </template>

            <div x-show="loading" class="flex justify-start">
                <div class="bg-gray-100 dark:bg-white/10 rounded-2xl rounded-bl-sm px-4 py-2 flex gap-1">
                    <span class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0ms"></span>
                    <span class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 150ms"></span>
                    <span class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 300ms"></span>
                </div>
            </div>
        </div>

        <!-- Input -->
        <form @submit.prevent="send()" class="p-3 border-t border-gray-100 dark:border-white/5 flex gap-2">
            <input
                x-model="input"
                type="text"
                placeholder="Type a message..."
                :disabled="loading"
                class="flex-1 rounded-lg border-gray-200 dark:border-white/10 dark:bg-[#1E2235] dark:text-white text-sm focus:ring-primary focus:border-primary"
            >
            <button
                type="submit"
                :disabled="loading || !input.trim()"
                class="w-9 h-9 flex items-center justify-center rounded-lg bg-primary text-white hover:bg-primary-dark disabled:opacity-40"
            >
                <i class="ri-send-plane-fill"></i>
            </button>
        </form>
    </div>
</div>