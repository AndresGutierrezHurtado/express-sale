import express from "express";
import cors from "cors";
import "dotenv/config";
import session from "express-session";
import conn from "./config/database.js";
import SequelizeStore from "connect-session-sequelize";

// Routes
import userRoutes from "./routes/user.routes.js";
import productRoutes from "./routes/product.routes.js";
import ratingRoutes from "./routes/rating.routes.js";
import orderRoutes from "./routes/order.routes.js";

// Models
import * as models from "./models/relations.js";

// Config
const SequelizeSessionStore = SequelizeStore(session.Store);
const sessionStore = new SequelizeSessionStore({
    db: conn,
    table: "Session",
});
conn.sync();

const app = express();
app.use(express.json());
app.use(cors());
app.use(
    session({
        secret: process.env.JWT_SECRET,
        resave: true,
        saveUninitialized: true,
        store: sessionStore,
        cookie: {
            maxAge: 60000,
            secure: false,
        },
    })
);
app.use(async (req, res, next) => {
    if (req.session.usuario_id) {
        console.log("Usuario logueado");
        req.session.user = await models.User.findByPk(req.session.usuario_id);
    }
    next();
});

// Routes
app.use("/api/v2", userRoutes);
app.use("/api/v2", productRoutes);
app.use("/api/v2", ratingRoutes);
app.use("/api/v2", orderRoutes);

app.listen(process.env.PORT, () =>
    console.log(`Server listening on port http://localhost:${process.env.PORT}/`)
);
