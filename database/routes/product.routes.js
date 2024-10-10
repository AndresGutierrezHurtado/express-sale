const router = require("express").Router();
const crypto = require("crypto");

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
        })
    }
});

// read
router.get("/products", async (req, res) => {
    const products = await models.Product.findAll({
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
        message: "Productos obtenidos correctamente",
        data: products,
    });
});

router.get("/products/:id", async (req, res) => {
    const product = await models.Product.findByPk(req.params.id, {
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
