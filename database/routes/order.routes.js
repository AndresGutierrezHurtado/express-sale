const router = require("express").Router();

// Models
const models = require("../models/relations");

// read
router.get("/orders", async (req, res) => {
    const orders = await models.Order.findAll({
        include: [
            { model: models.PaymentDetails, as: "paymentDetails" },
            { model: models.User, as: "user" },
            {
                model: models.ShippingDetails,
                as: "shippingDetails",
                include: {
                    model: models.Worker,
                    as: "worker",
                    include: { model: User, as: "user" },
                },
            },
            { model: models.OrderProduct, as: "orderProducts" },
        ],
    });

    res.status(200).json({
        success: true,
        message: "Pedidos obtenidos correctamente.",
        data: orders,
    });
});

router.get("/orders/:id", async (req, res) => {
    const orders = await models.Order.findOne({
        where: { pedido_id: req.params.id },
        include: [
            { model: models.PaymentDetails, as: "paymentDetails" },
            { model: models.User, as: "user" },
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
        message: "Pedidos obtenidos correctamente.",
        data: orders,
    });
});

module.exports = router;
