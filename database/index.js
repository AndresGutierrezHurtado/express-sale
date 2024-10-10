require("dotenv").config();
const express = require("express");
const app = express();
const jwt = require("jsonwebtoken");
const cors = require("cors");
const cookieParser = require("cookie-parser");

// Config
app.use(express.json());
app.use(cors({
    origin: process.env.VITE_URL,
    credentials: true
}));
app.use(cookieParser());

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
const userRoutes = require("./routes/user.routes");
const productRoutes = require("./routes/product.routes");
const orderRoutes = require("./routes/order.routes");

app.use("/api", userRoutes);
app.use("/api", productRoutes);
app.use("/api", orderRoutes);

// Start server
const port = process.env.PORT;
app.listen(port, () => {
    console.info(`Server listening on port ${port}`);
});
