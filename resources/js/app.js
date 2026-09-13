import "./bootstrap";
import Alpine from "alpinejs";

window.Alpine = Alpine;

window.validators = {
    email(value) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
    },
    phonePH(value) {
        // Matches 09XXXXXXXXX or +639XXXXXXXXX
        return /^(09\d{9}|\+639\d{9})$/.test(value.replace(/\s|-/g, ""));
    },
    passwordStrength(value) {
        let score = 0;
        if (value.length >= 8) score++;
        if (/[A-Z]/.test(value)) score++;
        if (/[0-9]/.test(value)) score++;
        if (/[^A-Za-z0-9]/.test(value)) score++;
        return score; // 0-4
    },
};

document.addEventListener("alpine:init", () => {
    Alpine.store("lightbox", {
        open: false,
        images: [],
        index: 0,
        show(images, index = 0) {
            this.images = images;
            this.index = index;
            this.open = true;
        },
        close() {
            this.open = false;
        },
        next() {
            this.index = (this.index + 1) % this.images.length;
        },
        prev() {
            this.index =
                (this.index - 1 + this.images.length) % this.images.length;
        },
    });
});

Alpine.start();

document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll('input[type="file"]').forEach((input) => {
        input.addEventListener("change", () => {
            const label = input.closest("label");
            const textSpan = label?.querySelector("span");
            if (textSpan && input.files.length > 0) {
                textSpan.textContent =
                    input.files.length === 1
                        ? input.files[0].name
                        : `${input.files.length} files selected`;
            }
        });
    });
});
