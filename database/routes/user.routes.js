const router = require("express").Router();
const jwt = require("jsonwebtoken");
const crypto = require("crypto");
const bcrypt = require("bcrypt");

// Models
const models = require("../models/relations");

// Create
router.post("/users", async (req, res) => {
    const user = await models.User.create({
        usuario_id: crypto.randomUUID(),
        usuario_nombre: req.body.usuario_nombre,
        usuario_apellido: req.body.usuario_apellido,
        usuario_correo: req.body.usuario_correo,
        usuario_alias: req.body.usuario_alias,
        usuario_contra: bcrypt.hashSync(req.body.usuario_contra, 10),
        rol_id: req.body.rol_id,
    });
    res.json(user);
});

// Read
router.get("/users", async (req, res) => {
    const users = await models.User.findAll({
        include: ["role", "worker"],
    });
    res.json(users);
});

router.get("/users/:id", async (req, res) => {
    const user = await models.User.findByPk(req.params.id, {
        include: [
            "role",
            "worker",
            {
                model: models.Order,
                as: "orders",
                include: [
                    { model: models.PaymentDetails, as: "paymentDetails" },
                    { model: models.ShippingDetails, as: "shippingDetails" },
                    { model: models.OrderProduct, as: "orderProducts" },
                ],
            },
            {
                model: models.Rating,
                as: "ratings",
                through: { attributes: [] },
            },
        ],
    });
    res.json(user);
});

// Update
router.put("/users/:id", async (req, res) => {
    const user = await models.User.update(
        {
            ...req.body,
            usuario_contra: bcrypt.hashSync(req.body.usuario_contra, 10),
        },
        {
        where: {
            usuario_id: req.params.id,
        },
        }
    );
    res.json(user);
});

// Delete
router.delete("/users/:id", async (req, res) => {
    const user = await User.destroy({
        where: {
            usuario_id: req.params.id,
        },
    });
    res.json(user);
});

// Auth
router.post("/auth", async (req, res) => {
    const { usuario_correo, usuario_contra } = req.body;

    const user = await User.findOne({
        where: { usuario_correo: usuario_correo },
    });

    if (!user) {
        return res
            .status(401)
            .json({ success: false, message: "Usuario no encontrado" });
    }

    const hashedPassword = crypto
        .createHash("md5")
        .update(usuario_contra)
        .digest("hex");

    if (user.usuario_contra !== hashedPassword) {
        return res
            .status(401)
            .json({ success: false, message: "Contraseña incorrecta" });
    }

    const token = jwt.sign({ ...user }, process.env.JWT_SECRET, {
        expiresIn: "1h",
    });

    res.status(200).json({ success: true, token });
});

module.exports = router;
