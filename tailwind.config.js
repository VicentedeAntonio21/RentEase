import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: "class",
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Inter", ...defaultTheme.fontFamily.sans],
                heading: ["Poppins", ...defaultTheme.fontFamily.sans],
            },
            fontSize: {
                sm: ["0.9rem", { lineHeight: "1.4rem" }], // was 0.875rem
                base: ["1rem", { lineHeight: "1.6rem" }],
                lg: ["1.15rem", { lineHeight: "1.7rem" }], // was 1.125rem
                xl: ["1.3rem", { lineHeight: "1.8rem" }], // was 1.25rem
                "2xl": ["1.6rem", { lineHeight: "2.1rem" }], // was 1.5rem
            },
            colors: {
                primary: {
                    DEFAULT: "#556EE6",
                    dark: "#4458C9",
                    light: "#EEF1FD",
                },
                sidebar: {
                    DEFAULT: "#2A3042",
                    hover: "#32394E",
                },
                success: "#34C38F",
                warning: "#F1B44C",
                danger: "#F46A6A",
            },
        },
    },

    plugins: [forms],
};
