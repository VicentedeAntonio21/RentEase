import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('input[type="file"]').forEach((input) => {
        input.addEventListener('change', () => {
            const label = input.closest('label');
            const textSpan = label?.querySelector('span');
            if (textSpan && input.files.length > 0) {
                textSpan.textContent = input.files.length === 1
                    ? input.files[0].name
                    : `${input.files.length} files selected`;
            }
        });
    });
});