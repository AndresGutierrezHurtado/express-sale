import { defineConfig } from "vite";
import react from "@vitejs/plugin-react";
import path from "path";

// https://vitejs.dev/config/
export default defineConfig({
    resolve: {
        alias: {
            "@components": path.resolve(__dirname, "./src/components"),
            "@contexts": path.resolve(__dirname, "./src/contexts"),
            "@hooks": path.resolve(__dirname, "./src/hooks"),
            "@layouts": path.resolve(__dirname, "./src/layouts"),
            "@middlewares": path.resolve(__dirname, "./src/middlewares"),
            "@pages": path.resolve(__dirname, "./src/pages"),
        },
    },
    plugins: [react()],
});
