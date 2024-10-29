import { Router } from "express";
import UserController from "../controllers/userController.js";

import passport from "passport";
import { Strategy as GoogleStrategy } from "passport-google-oauth20";

import * as models from "../models/relations.js";

passport.serializeUser((user, done) => {
    done(null, user.usuario_id);
});

passport.deserializeUser(async (id, done) => {
    try {
        const user = await models.User.findOne({ where: { usuario_id: id } });
        done(null, user);
    } catch (error) {
        done(error, null);
    }
});

passport.use(
    new GoogleStrategy(
        {
            clientID: process.env.GOOGLE_CLIENT_ID,
            clientSecret: process.env.GOOGLE_CLIENT_SECRET,
            callbackURL: process.env.VITE_API_URL + process.env.GOOGLE_REDIRECT_URI,
            scope: ["profile", "email"],
        },
        async function (accessToken, refreshToken, profile, cb) {
            let user = await models.User.findOne({ where: { usuario_correo: profile._json.email } });

            if (user) return cb(null, user);

            // Create new user
            let newUser = models.User.create({
                usuario_id: crypto.randomUUID(),
                usuario_nombre: profile._json.given_name,
                usuario_apellido: profile._json.family_name,
                usuario_correo: profile._json.email,
                usuario_alias:
                    profile._json.given_name.split(" ")[0] +
                    "_" +
                    profile._json.family_name.split(" ")[0],
                usuario_contra: profile._json.sub,
                usuario_imagen_url: profile._json.picture,
                rol_id: 1,
            });

            return cb(null, newUser);
        }
    )
);

const userRoutes = Router();

userRoutes.post("/users", UserController.createUser);
userRoutes.get("/users", UserController.getUsers);
userRoutes.get("/users/:id", UserController.getUser);
userRoutes.put("/users/:id", UserController.updateUser);
userRoutes.delete("/users/:id", UserController.deleteUser);
userRoutes.get("/users/:id/products", UserController.getUserProducts);
userRoutes.get("/users/:id/orders", UserController.getUserOrders);
userRoutes.get("/users/:id/ratings", UserController.getUserRatings);

// Auth
userRoutes.get("/user/session", UserController.verifyUserSession);
userRoutes.post("/user/auth", UserController.authUser);
userRoutes.post("/user/logout", UserController.logoutUser);

// Google Auth
userRoutes.get(
    "/user/auth/google",
    passport.authenticate("google", { scope: ["profile", "email"] })
);

userRoutes.get(
    "/user/auth/google/callback",
    passport.authenticate("google", {
        failureRedirect: `${process.env.VITE_URL}/login?error=true`,
    }),
    (req, res) => {
        req.session.usuario_id = req.user.usuario_id;
        req.session.user = req.user;
        res.redirect(process.env.VITE_URL);
    }
);


export default userRoutes;
