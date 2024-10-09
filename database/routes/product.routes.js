const router = require("express").Router();

// Models
const models = require("../models/relations");

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

// create
router.post("/products/:id", async (req, res) => {
    const product = await models.Product.create(req.body);
    res.stauts(200).json({
        success: true,
        message: "Producto creado correctamente",
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
