import express from "express";
import cors from "cors";
import "dotenv/config";

// Routes
import userRoutes from "./routes/user.routes.js";
import productRoutes from "./routes/product.routes.js";
import ratingRoutes from "./routes/rating.routes.js";
import orderRoutes from "./routes/order.routes.js";

// Config
const app = express();
app.use(express.json());
app.use(cors());

// Routes
app.use("/api", userRoutes);
app.use("/api", productRoutes);
app.use("/api", ratingRoutes);
app.use("/api", orderRoutes);

app.listen(process.env.PORT, () =>
    console.log(`Server listening on port http://localhost:${process.env.PORT}/`)
);
