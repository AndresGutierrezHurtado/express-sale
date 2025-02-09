import { Router } from "express";
import UserController from "../controllers/userController.js";

const userRoutes = Router();
/**
 * @swagger
 * /users:
 *   post:
 *     summary: Agregar un nuevo usuario
 *     tags:
 *       - Users
 *     requestBody:
 *       required: true
 *       content:
 *         application/json:
 *           schema:
 *             type: object
 *             properties:
 *               user:
 *                 type: object
 *                 properties:
 *                   user_name:
 *                     type: string
 *                     example: John Doe
 *                   user_lastname:
 *                     type: string
 *                     example: Doe
 *                   user_alias:
 *                     type: string
 *                     example: johndoe
 *                   user_email:
 *                     type: string
 *                     example: johndoe@example.com
 *                   user_phone:
 *                     type: string
 *                     example: 1234567890
 *                   user_address:
 *                     type: string
 *                     example: 123 Main St, Anytown, USA 12345
 *                   user_image:
 *                     type: string
 *                     format: binary
 *                 required:
 *                   - user_name
 *                   - user_lastname
 *                   - user_alias
 *                   - user_email
 *                   - user_phone
 *                   - user_address
 *     responses:
 *       201:
 *         description: User created successfully
 *         content:
 *           application/json:
 *             schema:
 *               type: object
 *               properties:
 *                 success:
 *                   type: boolean
 *                 message:
 *                   type: string
 *                 data:
 *                   type: object
 *                   properties:
 *                     user_id:
 *                       type: string
 *                     user_name:
 *                       type: string
 *                     user_lastname:
 *                       type: string
 *                     user_alias:
 *                       type: string
 *                     user_email:
 *                       type: string
 *                     user_phone:
 *                       type: string
 *                     user_address:
 *                       type: string
 *                     user_image_url:
 *                       type: string
 *                     created_at:
 *                       type: string
 *                     updated_at:
 *                       type: string
 *       500:
 *         description: Error creating user
 *         content:
 *           application/json:
 *             schema:
 *               type: object
 *               properties:
 *                 success:
 *                   type: boolean
 *                 message:
 *                   type: string
 */
userRoutes.post("/users", UserController.createUser);
userRoutes.get("/users", UserController.getUsers);
userRoutes.get("/users/:id", UserController.getUser);
userRoutes.put("/users/:id", UserController.updateUser);
userRoutes.delete("/users/:id", UserController.deleteUser);

// Extra info
userRoutes.get("/users/:id/products", UserController.getUserProducts);
userRoutes.get("/users/:id/orders", UserController.getUserOrders);
userRoutes.get("/users/:id/ratings", UserController.getUserRatings);
userRoutes.post("/feedback", UserController.createUserFeedback);

// Withdrawals
userRoutes.get("/users/:id/withdrawals", UserController.getUserWithdrawals);
userRoutes.post("/withdrawals", UserController.createUserWithdrawal);

// Cart
userRoutes.get("/users/:id/carts", UserController.getUserCart);
userRoutes.post("/carts", UserController.createUserCart);
userRoutes.put("/carts/:id", UserController.updateUserCart);
userRoutes.delete("/carts/:id", UserController.deleteUserCart);
userRoutes.delete("/carts/empty", UserController.emptyUserCart);

// Recovery
userRoutes.post("/recoveries", UserController.createRecovery);
userRoutes.get("/recoveries/:token", UserController.getRecovery);
userRoutes.put("/recoveries/:token", UserController.updateRecovery);

export default userRoutes;
