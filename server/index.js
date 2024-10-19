import express from "express";
import cors from "cors";
import "dotenv/config";

// Routes
import userRoutes from "./routes/user.routes.js";
import productRoutes from "./routes/product.routes.js";

// Config
const app = express();
app.use(express.json());
app.use(cors());

// Routes
app.use("/api", userRoutes);
app.use("/api", productRoutes);

app.listen(process.env.PORT, () =>
    console.log(`Server listening on port http://localhost:${process.env.PORT}/`)
);
