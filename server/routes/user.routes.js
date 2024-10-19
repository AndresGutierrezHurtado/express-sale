import { Router } from "express";
import UserController from "../controllers/userController.js";

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
userRoutes.get("/user/session", UserController.verifyUserSession);
userRoutes.get("/user/logout", UserController.logoutUser);

export default userRoutes;
