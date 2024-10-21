import express from "express";
import cors from "cors";
import "dotenv/config";
import cookieParser from "cookie-parser";
import jwt from "jsonwebtoken";

// Routes
import userRoutes from "./routes/user.routes.js";
import productRoutes from "./routes/product.routes.js";
import ratingRoutes from "./routes/rating.routes.js";
import orderRoutes from "./routes/order.routes.js";

// Config
const app = express();
app.use(express.json());
app.use(
    cors({
        origin: process.env.VITE_URL,
        credentials: true,
    })
);
app.use(cookieParser());

// Middleware
app.use((req, res, next) => {
    req.session = { user: null };

    const token = req.cookies.authToken;
    if (!token) return next();

    try {
        const data = jwt.verify(token, process.env.JWT_SECRET);
        req.session.user = data;
    } catch (error) {
        console.error(error);
    }

    next();
});

// Routes
app.use("/api/v2", userRoutes);
app.use("/api/v2", productRoutes);
app.use("/api/v2", ratingRoutes);
app.use("/api/v2", orderRoutes);

app.listen(process.env.PORT, () =>
    console.log(
        `Server listening on port http://localhost:${process.env.PORT}/`
    )
);
