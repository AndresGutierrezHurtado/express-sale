import * as models from "../models/relations.js";
import sequelize from "../config/database.js";
import bcrypt from "bcrypt";
import jwt from "jsonwebtoken";
import crypto from "crypto";

export default class UserController {
    static createUser = async (req, res) => {
        try {
            const t = await sequelize.transaction();

            const user = await models.User.create({
                usuario_id: crypto.randomUUID(),
                usuario_nombre: req.body.usuario_nombre,
                usuario_apellido: req.body.usuario_apellido,
                usuario_correo: req.body.usuario_correo,
                usuario_alias: req.body.usuario_alias,
                usuario_contra: bcrypt.hashSync(req.body.usuario_contra, 10),
                rol_id: req.body.rol_id,
            });

            if (user.rol_id == 2 || user.rol_id == 3) {
                const worker = await models.Worker.create({
                    trabajador_id: crypto.randomUUID(),
                    usuario_id: user.usuario_id,
                });
            }

            await t.commit();

            res.status(200).json({
                success: true,
                message: "Usuario creado correctamente.",
                data: user,
            });
        } catch (error) {
            t.rollback();

            // verificar si es que el correo/usuario ya existe
            if (error.name === "SequelizeUniqueConstraintError") {
                return res.status(500).json({
                    success: false,
                    message: "El correo/alias ya existe.",
                });
            } else {
                res.status(500).json({
                    success: false,
                    message: error.message,
                });
            }
        }
    };

    static authUser = async (req, res) => {
        try {
            const { usuario_correo, usuario_contra } = req.body;

            const user = await models.User.findOne({
                where: { usuario_correo: usuario_correo },
            });

            if (!user) {
                return res
                    .status(401)
                    .json({ success: false, message: "Usuario no encontrado" });
            }

            if (!bcrypt.compareSync(usuario_contra, user.usuario_contra)) {
                return res
                    .status(200)
                    .json({ success: false, message: "Contraseña incorrecta" });
            }

            const token = jwt.sign(
                { id: user.usuario_id },
                process.env.JWT_SECRET,
                {
                    expiresIn: "1h",
                }
            );

            res.status(200)
                .cookie("authToken", token, { httpOnly: true })
                .json({
                    success: true,
                    message: "Autenticado correctamente.",
                    data: { token },
                });
        } catch (error) {
            res.status(500).json({
                success: false,
                message: error.message,
                data: null,
            });
        }
    };

    static verifyUserSession = async (req, res) => {
        try {
            if (!req.session.user) {
                res.status(200).json({
                    success: false,
                    message: "No autorizado",
                    data: null,
                });
                return;
            }

            const userSession = await models.User.findByPk(
                req.session.user.id,
                {
                    include: ["role", "worker"],
                }
            );

            res.status(200).json({
                success: true,
                message: "El usuario esta autenticado",
                data: userSession,
            });
        } catch (error) {
            res.status(500).json({
                success: false,
                message: error.message,
                data: null,
            });
        }
    };

    static logoutUser = (req, res) => {
        try {
            res.status(200)
                .clearCookie("authToken")
                .json({
                    success: true,
                    message: "Sesión cerrada correctamente",
                    data: null,
                });
        } catch (error) {
            res.status(500).json({
                success: false,
                message: error.message,
                data: null,
            });
        }
    };

    static updateUser = async (req, res) => {
        // validation
        let userData = req.body.user;
        let workerData = req.body.worker;

        if (userData && userData.usuario_contra) {
            userData.usuario_contra = bcrypt.hashSync(
                userData.usuario_contra,
                10
            );
        }

        try {
            const t = await sequelize.transaction();

            // data updating
            if (userData) {
                const user = await models.User.update(userData, {
                    where: { usuario_id: req.params.id },
                });
            }
            if (workerData) {
                const worker = await models.Worker.update(workerData, {
                    where: { usuario_id: req.params.id },
                });
            }

            await t.commit();

            res.status(200).json({
                success: true,
                message: "Usuario actualizado correctamente.",
            });
        } catch (error) {
            await t.rollback();
            if (error.name == "SequelizeUniqueConstraintError") {
                console.error(error.errors);
                res.status(500).json({
                    success: false,
                    message:
                        "El campo " +
                        error.errors[0].value +
                        " ya lo tiene otro usuario.",
                });
            } else {
                res.status(500).json({
                    success: false,
                    message: error.message,
                });
            }
        }
    };

    static updateUserImage = async (userId, image) => {
        // sharp image
        // Save image in a cdn
        // update image in database
    };

    static deleteUser = async (req, res) => {
        try {
            await models.User.destroy({ where: { usuario_id: req.params.id } });
            res.status(200).json({
                success: true,
                message: "Usuario eliminado correctamente.",
            });
        } catch (error) {
            res.status(500).json({
                success: false,
                message: error.message,
            });
        }
    };

    static getUsers = async (req, res) => {
        try {
            const users = await models.User.findAll({
                include: ["role", "worker"],
            });
            res.status(200).json({
                success: true,
                message: "Usuarios obtenidos correctamente.",
                data: users,
            });
        } catch (error) {
            res.status(500).json({
                success: false,
                message: error.message,
                data: null,
            });
        }
    };

    static getUser = async (req, res) => {
        try {
            const user = await models.User.findByPk(req.params.id, {
                attributes: {
                    include: [
                        [
                            sequelize.literal(`(
                                SELECT COALESCE(ROUND(AVG(calificaciones.calificacion), 2),0)
                                FROM calificaciones
                                INNER JOIN calificaciones_usuarios ON calificaciones.calificacion_id = calificaciones_usuarios.calificacion_id
                                WHERE calificaciones_usuarios.usuario_id = User.usuario_id
                            )`),
                            "calificacion_promedio",
                        ],
                    ],
                },
                include: ["role", "worker"],
            });
            res.status(200).json({
                success: true,
                message: "Usuario obtenido correctamente.",
                data: user,
            });
        } catch (error) {
            res.status(500).json({
                success: false,
                message: error.message,
                data: null,
            });
        }
    };

    static getUserProducts = async (req, res) => {
        try {
            const products = await models.Product.findAll({
                where: { usuario_id: req.params.id },
                attributes: {
                    include: [
                        [
                            sequelize.literal(`(
                                SELECT COALESCE(ROUND(AVG(calificaciones.calificacion), 2), 0)
                                FROM calificaciones
                                INNER JOIN calificaciones_productos ON calificaciones.calificacion_id = calificaciones_productos.calificacion_id
                                WHERE calificaciones_productos.producto_id = Product.producto_id
                            )`),
                            "calificacion_promedio",
                        ],
                    ],
                },
            });
            res.status(200).json({
                success: true,
                message: "Productos obtenidos correctamente.",
                data: products,
            });
        } catch (error) {
            res.status(500).json({
                success: false,
                message: error.message,
                data: null,
            });
        }
    };

    static getUserOrders = async (req, res) => {
        try {
            const orders = await models.Order.findAll({
                where: { usuario_id: req.params.id },
                include: [
                    { model: models.PaymentDetails, as: "paymentDetails" },
                    {
                        model: models.ShippingDetails,
                        as: "shippingDetails",
                        include: {
                            model: models.Worker,
                            as: "worker",
                            include: { model: models.User, as: "user" },
                        },
                    },
                    { model: models.OrderProduct, as: "orderProducts" },
                ],
            });
            res.status(200).json({
                success: true,
                message: "Ordenes obtenidas correctamente.",
                data: orders,
            });
        } catch (error) {
            res.status(500).json({
                success: false,
                message: error.message,
                data: null,
            });
        }
    };

    static getUserRatings = async (req, res) => {
        try {
            const { ratings } = await models.User.findByPk(req.params.id, {
                include: [
                    {
                        model: models.Rating,
                        as: "ratings",
                        through: { attributes: [] },
                        include: [{ model: models.User, as: "calificator" }],
                    },
                ],
            });

            res.status(200).json({
                success: true,
                message: "Calificaciones obtenidas correctamente.",
                data: ratings,
            });
        } catch (error) {
            res.status(500).json({
                success: false,
                message: error.message,
                data: null,
            });
        }
    };
}
