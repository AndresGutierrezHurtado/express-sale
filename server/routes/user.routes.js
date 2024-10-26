import { Router } from "express";
import UserController from "../controllers/userController.js";

import passport from "passport";
import { Strategy as GoogleStrategy } from "passport-google-oauth20";
import { Strategy as FacebookStrategy } from "passport-facebook";

import * as models from "../models/relations.js";

passport.use(
    new GoogleStrategy(
        {
            clientID: "GOOGLE_CLIENT_ID",
            clientSecret: "GOOGLE_CLIENT_SECRET",
            callbackURL: "/user/auth/google/callback",
        },
        function (accessToken, refreshToken, profile, cb) {
            models.User.findOrCreate(
                {
                    usuario_id: profile.id,
                    usuario_correo: profile.email,
                    rol_id: 1,
                    usuario_alias: profile.displayName,
                },
                function (err, user) {
                    return cb(err, user);
                }
            );
        }
    )
);

passport.use(
    new FacebookStrategy(
        {
            clientID: "FACEBOOK_APP_ID",
            clientSecret: "FACEBOOK_APP_SECRET",
            callbackURL: "user/auth/facebook/callback",
        },
        function (accessToken, refreshToken, profile, cb) {
            User.findOrCreate({ facebookId: profile.id }, function (err, user) {
                return cb(err, user);
            });
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
userRoutes.post("/user/auth", UserController.authUser);
userRoutes.post("/user/auth/login", UserController.authFacebookUser);
userRoutes.post("/user/auth/google", UserController.authGoogleUser);
userRoutes.post("/user/auth/google/callback", UserController.googleCallback);
userRoutes.post("/user/auth/facebook", UserController.authUser);

userRoutes.get("/user/session", UserController.verifyUserSession);
userRoutes.post("/user/logout", UserController.logoutUser);

export default userRoutes;
