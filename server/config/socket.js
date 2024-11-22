import { Server } from "socket.io";

let io;

export const initSocket = (httpServer) => {
    io = new Server(httpServer, {
        cors: {
            origin: process.env.VITE_API_URL,
            methods: ["GET", "POST"],
        },
    });

    io.on("connection", (socket) => {
        console.log("User connected");

        socket.on("disconnect", () => {
            console.log("User disconnected");
        });
    });

    console.log("Socket initialized");
    return io;
}

export const getSocket = () => {
    if (!io) {
        throw new Error("Socket not initialized");
    }
    return io;
}
