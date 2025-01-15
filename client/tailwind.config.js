/** @type {import('tailwindcss').Config} */
export default {
    content: ["./index.html", "./src/**/*.{js,ts,jsx,tsx}"],
    theme: {
        extend: {},
    },
    plugins: [require("daisyui")],
    daisyui: {
        themes: [
            {
                express: {
                    primary: "#7e22ce",
                    "primary-content": "#fff",
                    "base-100": "#f9fafb",
                    "base-content": "#030712",
                },
            },
            "light",
            "dark",
        ],
    },
};
