import * as models from "../models/relations.js";
import sequelize from "../config/database.js";
import { Op } from "sequelize";

export default class ProductController {
    static createProduct = async (req, res) => {
        try {
            const product = await models.Product.create({
                producto_id: crypto.randomUUID(),
                producto_nombre: req.body.producto_nombre,
                producto_descripcion: req.body.producto_descripcion,
                producto_cantidad: req.body.producto_cantidad,
                producto_precio: req.body.producto_precio,
                producto_estado: req.body.producto_estado,
                usuario_id: req.body.usuario_id,
                categoria_id: req.body.categoria_id,
            });
            res.status(200).json({
                success: true,
                message: "Producto creado correctamente",
                data: product,
            });
        } catch (error) {
            res.status(404).json({
                success: false,
                message: error.message,
            });
        }
    };

    static updateProudct = async (req, res) => {
        try {
            const product = await models.Product.update(
                {
                    producto_nombre: req.body.producto_nombre,
                    producto_descripcion: req.body.producto_descripcion,
                    producto_cantidad: req.body.producto_cantidad,
                    producto_precio: req.body.producto_precio,
                    producto_estado: req.body.producto_estado,
                    categoria_id: req.body.categoria_id,
                },
                {
                    where: {
                        producto_id: req.params.id,
                    },
                }
            );
            res.status(200).json({
                success: true,
                message: "Producto actualizado correctamente",
                data: product,
            });
        } catch (error) {
            res.status(404).json({
                success: false,
                message: error.message,
            });
        }
    };

    static updateProductImage = async (image) => {
        // sharp image
        // save image in cdn
        // save image url in database
    };

    static deleteProduct = async (req, res) => {
        try {
            const product = await models.Product.destroy({
                where: {
                    producto_id: req.params.id,
                },
            });
            res.status(200).json({
                success: true,
                message: "Producto eliminado correctamente",
                data: product,
            });
        } catch (error) {
            res.status(404).json({
                success: false,
                message: error.message,
            });
        }
    };

    static getProducts = async (req, res) => {
        try {
            const products = await models.Product.findAndCountAll({
                where: {
                    [Op.and]: [
                        {
                            producto_estado: "publico",
                        },
                        {
                            [Op.or]: [
                                {
                                    producto_nombre: {
                                        [Op.like]: `%${
                                            req.query.search || ""
                                        }%`,
                                    },
                                },
                                {
                                    producto_descripcion: {
                                        [Op.like]: `%${
                                            req.query.search || ""
                                        }%`,
                                    },
                                },
                            ],
                        },
                        {
                            producto_precio: {
                                [Op.gte]: req.query.min || 0,
                            },
                        },
                        {
                            producto_precio: {
                                [Op.lte]: req.query.max || 9999999999,
                            },
                        },
                        {
                            categoria_id: {
                                [Op.in]: req.query.category
                                    ? [req.query.category]
                                    : [1, 2, 3, 4],
                            },
                        },
                    ],
                },
                limit: parseInt(req.query.limit || 5),
                offset: req.query.page ? (req.query.page - 1) * 5 : 0,
                distinct: true,
                include: [
                    "category",
                    {
                        model: models.User,
                        as: "user",
                    },
                ],
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
                order: [
                    [
                        req.query.sort
                            ? req.query.sort.split(":")[0]
                            : sequelize.literal("`calificacion_promedio`"),
                        req.query.sort ? req.query.sort.split(":")[1] : "DESC",
                    ],
                ],
            });

            res.status(200).json({
                success: true,
                message: "Listado de productos.",
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

    static getProduct = async (req, res) => {
        try {
            const product = await models.Product.findByPk(req.params.id, {
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
                include: [
                    "category",
                    { model: models.User, as: "user", include: ["worker"] },
                ],
            });

            res.status(200).json({
                success: true,
                message: "Listado de productos.",
                data: product,
            });
        } catch (error) {
            res.status(500).json({
                success: false,
                message: error.message,
                data: null,
            });
        }
    };

    static getProductRatings = async (req, res) => {
        try {
            const { ratings } = await models.Product.findByPk(req.params.id, {
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
                message: "Listado de productos.",
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
