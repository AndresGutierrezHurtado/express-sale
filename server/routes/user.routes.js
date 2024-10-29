import { Router } from "express";
import UserController from "../controllers/userController.js";

import passport from "passport";
import { Strategy as GoogleStrategy } from "passport-google-oauth20";

import * as models from "../models/relations.js";

passport.use(
    new GoogleStrategy(
        {
            clientID: process.env.GOOGLE_CLIENT_ID,
            clientSecret: process.env.GOOGLE_CLIENT_SECRET,
            callbackURL: process.env.VITE_API_URL + process.env.GOOGLE_REDIRECT_URI,
        },
        function (accessToken, refreshToken, profile, cb) {
            console.log(accessToken, refreshToken, profile, cb);
            // models.User.findOrCreate(
            //     {
            //         usuario_id: profile.id,
            //         usuario_correo: profile.email,
            //         rol_id: 1,
            //         usuario_alias: profile.displayName,
            //     },
            //     function (err, user) {
            //         return cb(err, user);
            //     }
            // );
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
userRoutes.get("/user/auth/google", passport.authenticate("google", { scope: ["profile"] }));
userRoutes.get(
    "/user/auth/google/callback",
    passport.authenticate("google", { failureRedirect: "/login" }),
    function (req, res) {
        res.redirect("/");
    }
);

export default userRoutes;
