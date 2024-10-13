const router = require("express").Router();
const crypto = require("crypto");
const conn = require("../config/connection");

// Models
const models = require("../models/relations");

// create
router.post("/products", async (req, res) => {
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
});

// read
router.get("/products", async (req, res) => {
    const products = await models.Product.findAndCountAll({
        where: { producto_estado: "publico" },
        limit: 5,
        offset: req.query.page ? (req.query.page - 1) * 5 : 0,
        include: [
            "category",
            { model: models.User, as: "user", include: ["worker"] },
            {
                model: models.Rating,
                as: "ratings",
                through: { attributes: [] },
            },
        ],
        attributes: {
            include: [
                [
                    conn.literal(`(
                        SELECT COALESCE(ROUND(AVG(calificaciones.calificacion), 2), 0)
                        FROM calificaciones
                        INNER JOIN calificaciones_productos ON calificaciones.calificacion_id = calificaciones_productos.calificacion_id
                        WHERE calificaciones_productos.producto_id = Product.producto_id
                    )`),
                    "calificacion_promedio",
                ],
            ],
        },
        order: [["producto_id", "ASC"]],
    });

    res.status(200).json({
        success: true,
        message: "Productos obtenidos correctamente",
        data: products,
    });
});

router.get("/products/:id", async (req, res) => {
    const product = await models.Product.findByPk(req.params.id, {
        attributes: {
            include: [
                [
                    conn.literal(`(
                        SELECT COALESCE(ROUND(AVG(calificaciones.calificacion), 2),0)
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
            {
                model: models.Rating,
                as: "ratings",
                through: { attributes: [] },
            },
        ],
    });
    res.status(200).json({
        success: true,
        message: "Producto obtenido correctamente",
        data: product,
    });
});

// update
router.put("/products/:id", async (req, res) => {
    const product = await models.Product.update(req.body, {
        where: {
            producto_id: req.params.id,
        },
    });
    res.status(200).json({
        success: true,
        message: "Producto actualizado correctamente",
        data: product,
    });
});

// delete
router.delete("/products/:id", async (req, res) => {
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
});

module.exports = router;
