import { Router } from "express";
import UserController from "../controllers/userController.js";

const userRoutes = Router();

/**
 * @swagger
 * /users:
 *   post:
 *     summary: Agregar un nuevo usuario
 *     tags:
 *       - Usuarios
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
 *                     type: number
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
 *       200:
 *         description: Usuario creado exitosamente
 *         content:
 *           application/json:
 *             schema:
 *               type: object
 *               properties:
 *                 success:
 *                   type: boolean
 *                   example: true
 *                 message:
 *                   type: string
 *                   example: "Usuario creado exitosamente"
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
 *                       type: number
 *                     user_address:
 *                       type: string
 *                     user_image_url:
 *                       type: string
 *                     created_at:
 *                       type: string
 *                     updated_at:
 *                       type: string
 *       500:
 *         description: Error al crear el usuario
 *         content:
 *           application/json:
 *             schema:
 *               type: object
 *               properties:
 *                 success:
 *                   type: boolean
 *                   example: false
 *                 message:
 *                   type: string
 *                   example: "Error al crear el usuario"
 *                 data:
 *                   type: object
 */
userRoutes.post("/users", UserController.createUser);

/**
 * @swagger
 * /users:
 *   get:
 *     summary: Obtener lista de usuarios
 *     tags:
 *       - Usuarios
 *     parameters:
 *       - in: query
 *         name: search
 *         schema:
 *           type: string
 *         description: Criterio de búsqueda por nombre, alias o email
 *       - in: query
 *         name: sort
 *         schema:
 *           type: string
 *         description: Ordenar por campo (e.g., user_name, user_email)
 *       - in: query
 *         name: limit
 *         schema:
 *           type: integer
 *         description: Número de usuarios a devolver
 *       - in: query
 *         name: page
 *         schema:
 *           type: integer
 *         description: Número de página para paginación
 *     responses:
 *       200:
 *         description: lista de usuarios
 *         content:
 *           application/json:
 *             schema:
 *               type: array
 *               items:
 *                 type: object
 *                 properties:
 *                   user_id:
 *                     type: string
 *                   user_name:
 *                     type: string
 *                   user_lastname:
 *                     type: string
 *                   user_alias:
 *                     type: string
 *                   user_email:
 *                     type: string
 *                   user_phone:
 *                     type: number
 *                   user_address:
 *                     type: string
 *                   user_image_url:
 *                     type: string
 *                   created_at:
 *                     type: string
 *                   updated_at:
 *                     type: string
 *                   worker:
 *                     type: object
 *                     properties:
 *                       worker_id:
 *                         type: string
 *                       worker_description:
 *                         type: string
 *                       worker_balance:
 *                         type: number
 *                   role:
 *                     type: object
 *                     properties:
 *                       role_id:
 *                         type: integer
 *                       role_name:
 *                         type: string
 *       500:
 *         description: Error al obtener la lista de usuarios
 *         content:
 *           application/json:
 *             schema:
 *               type: object
 *               properties:
 *                 success:
 *                   type: boolean
 *                   example: false
 *                 message:
 *                   type: string
 *                   example: "Error al obtener la lista de usuarios"
 */
userRoutes.get("/users", UserController.getUsers);

/**
 * @swagger
 * /users/{id}:
 *   get:
 *     summary: Obtener un usuario por su ID
 *     tags:
 *       - Usuarios
 *     parameters:
 *       - in: path
 *         name: id
 *         schema:
 *           type: string
 *         required: true
 *         description: ID del usuario
 *     responses:
 *       200:
 *         description: Usuario obtenido correctamente
 *         content:
 *           application/json:
 *             schema:
 *               type: object
 *               properties:
 *                 user_id:
 *                   type: string
 *                 user_name:
 *                   type: string
 *                 user_lastname:
 *                   type: string
 *                 user_alias:
 *                   type: string
 *                 user_email:
 *                   type: string
 *                 user_phone:
 *                   type: number
 *                 user_address:
 *                   type: string
 *                 user_image_url:
 *                   type: string
 *                 created_at:
 *                   type: string
 *                 updated_at:
 *                   type: string
 *                 worker:
 *                   type: object
 *                   properties:
 *                     worker_id:
 *                       type: string
 *                     worker_description:
 *                       type: string
 *                     worker_balance:
 *                       type: number
 *                 role:
 *                   type: object
 *                   properties:
 *                     role_id:
 *                       type: integer
 *                     role_name:
 *                       type: string
 *       404:
 *         description: Usuario no encontrado
 *         content:
 *           application/json:
 *             schema:
 *               type: object
 *               properties:
 *                 success:
 *                   type: boolean
 *                   example: false
 *                 message:
 *                   type: string
 *                   example: "Usuario no encontrado"
 *                 data:
 *                   type: object
 *                   properties: {}
 *       500:
 *         description: Error al obtener el usuario
 *         content:
 *           application/json:
 *             schema:
 *               type: object
 *               properties:
 *                 success:
 *                   type: boolean
 *                   example: false
 *                 message:
 *                   type: string
 *                   example: "Error al obtener el usuario"
 *                 data:
 *                   type: object
 */
userRoutes.get("/users/:id", UserController.getUser);

/**
 * @swagger
 * /users/{id}:
 *   put:
 *     summary: Actualizar información de un usuario
 *     tags:
 *       - Usuarios
 *     parameters:
 *       - in: path
 *         name: id
 *         required: true
 *         schema:
 *           type: string
 *         description: Identificador único del usuario
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
 *                   user_lastname:
 *                     type: string
 *                   user_alias:
 *                     type: string
 *                   user_email:
 *                     type: string
 *                   user_phone:
 *                     type: number
 *                   user_address:
 *                     type: string
 *                   user_password:
 *                     type: string
 *                   role_id:
 *                     type: integer
 *               worker:
 *                 type: object
 *                 properties:
 *                   worker_description:
 *                     type: string
 *                   worker_balance:
 *                     type: number
 *               user_image:
 *                 type: string
 *                 format: byte
 *                 example: "base64encodedimage"
 *     responses:
 *       200:
 *         description: Usuario actualizado correctamente
 *         content:
 *           application/json:
 *             schema:
 *               type: object
 *               properties:
 *                 success:
 *                   type: boolean
 *                   example: true
 *                 message:
 *                   type: string
 *                   example: "Usuario actualizado correctamente"
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
 *                       type: number
 *                     user_address:
 *                       type: string
 *                     user_image_url:
 *                       type: string
 *                     role_id:
 *                       type: integer
 *                     role:
 *                       type: object
 *                       properties:
 *                         role_id:
 *                           type: integer
 *                         role_name:
 *                           type: string
 *       404:
 *         description: Usuario no encontrado
 *         content:
 *           application/json:
 *             schema:
 *               type: object
 *               properties:
 *                 success:
 *                   type: boolean
 *                   example: false
 *                 message:
 *                   type: string
 *                   example: "Usuario no encontrado"
 *                 data:
 *                   type: object
 *                   properties: {}
 *       500:
 *         description: Error al actualizar el usuario
 *         content:
 *           application/json:
 *             schema:
 *               type: object
 *               properties:
 *                 success:
 *                   type: boolean
 *                   example: false
 *                 message:
 *                   type: string
 *                   example: "Error al actualizar el usuario"
 *                 data:
 *                   type: object
 *                   properties: {}
 */
userRoutes.put("/users/:id", UserController.updateUser);

/**
 * @swagger
 * /users/{id}:
 *   delete:
 *     summary: Eliminar un usuario por su ID
 *     tags:
 *       - Usuarios
 *     parameters:
 *       - in: path
 *         name: id
 *         required: true
 *         schema:
 *           type: string
 *         description: Identificador único del usuario
 *     responses:
 *       200:
 *         description: Usuario eliminado correctamente
 *         content:
 *           application/json:
 *             schema:
 *               type: object
 *               properties:
 *                 success:
 *                   type: boolean
 *                   example: true
 *                 message:
 *                   type: string
 *                   example: "Usuario eliminado correctamente"
 *       404:
 *         description: Usuario no encontrado
 *         content:
 *           application/json:
 *             schema:
 *               type: object
 *               properties:
 *                 success:
 *                   type: boolean
 *                   example: false
 *                 message:
 *                   type: string
 *                   example: "Usuario no encontrado"
 *                 data:
 *                   type: object
 *                   properties: {}
 *       500:
 *         description: Error al eliminar el usuario
 *         content:
 *           application/json:
 *             schema:
 *               type: object
 *               properties:
 *                 success:
 *                   type: boolean
 *                   example: false
 *                 message:
 *                   type: string
 *                   example: "Error al eliminar el usuario"
 *                 data:
 *                   type: object
 *                   properties: {}
 */
userRoutes.delete("/users/:id", UserController.deleteUser);

// Extra info

/**
 * @swagger
 * /users/{id}/products:
 *   get:
 *     summary: Obtener productos de un usuario
 *     tags:
 *       - Usuarios
 *     parameters:
 *       - in: path
 *         name: id
 *         required: true
 *         schema:
 *           type: string
 *         description: Identificador único del usuario
 *       - in: query
 *         name: search
 *         schema:
 *           type: string
 *         description: Criterio de búsqueda por nombre, alias o email
 *       - in: query
 *         name: sort
 *         schema:
 *           type: string
 *           example: user_name:asc
 *         description: Ordenar por campo, el primer argumento es el campo y el segundo es el orden (asc o desc) separados por dos puntos
 *       - in: query
 *         name: limit
 *         schema:
 *           type: integer
 *           example: 10
 *         description: Número de usuarios a devolver
 *       - in: query
 *         name: page
 *         schema:
 *           type: integer
 *           example: 1
 *         description: Número de página para paginación
 *     responses:
 *       200:
 *         description: Productos obtenidos correctamente
 *         content:
 *           application/json:
 *             schema:
 *               type: object
 *               properties:
 *                 success:
 *                   type: boolean
 *                   example: true
 *                 message:
 *                   type: string
 *                   example: "Productos obtenidos correctamente"
 *                 data:
 *                   type: array
 *                   items:
 *                     type: object
 *                     properties:
 *                       product_id:
 *                         type: string
 *                       product_name:
 *                         type: string
 *                       product_description:
 *                         type: string
 *                       product_price:
 *                         type: number
 *                       product_image_url:
 *                         type: string
 *                       product_date:
 *                         type: string
 *                       product_quantity:
 *                         type: number
 *                       category_id:
 *                         type: number
 *                       category:
 *                         type: object
 *                         properties:
 *                           category_id:
 *                             type: number
 *                           category_name:
 *                             type: string
 *       500:
 *         description: Error al obtener los productos
 *         content:
 *           application/json:
 *             schema:
 *               type: object
 *               properties:
 *                 success:
 *                   type: boolean
 *                   example: false
 *                 message:
 *                   type: string
 *                   example: "Error al obtener los productos"
 *                 data:
 *                   type: object
 *                   properties: {}
 */
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
