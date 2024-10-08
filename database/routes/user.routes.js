require("dotenv").config();
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
    res.json({
        success: true,
        message: "Usuario creado correctamente.",
        data: user,
    });
});

// Read
router.get("/users", async (req, res) => {
    const users = await models.User.findAll({
        include: ["role", "worker"],
    });
    res.json({
        success: true,
        message: "Usuarios obtenidos correctamente.",
        data: users,
    });
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
    res.json({
        success: true,
        message: "Usuario obtenido correctamente.",
        data: user,
    });
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
    res.json({
        success: true,
        message: "Usuario actualizado correctamente.",
        data: user,
    });
});

// Delete
router.delete("/users/:id", async (req, res) => {
    const user = await models.User.destroy({
        where: {
            usuario_id: req.params.id,
        },
    });
    res.json({
        success: true,
        message: "Usuario eliminado correctamente.",
        data: user,
    });
});

// Auth
router.post("/user/auth", async (req, res) => {
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
            .status(401)
            .json({ success: false, message: "Contraseña incorrecta" });
    }

    const token = jwt.sign({ id: user.usuario_id }, process.env.JWT_SECRET, {
        expiresIn: "1h",
    });

    res.status(200).cookie("authToken", token, { httpOnly: true }).json({
        success: true,
        message: "Autenticado correctamente.",
        data: { token },
    });
});

// Verify
router.get("/user/session", async (req, res) => {
    if (req.session.user) {
        const userSession = await models.User.findByPk(req.session.user.id, {
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

        res.status(200).json({ success: true, data: userSession });
    } else {
        res.status(401).json({ success: false, message: "No autorizado" });
    }
});

// Logout
router.get("/user/logout", (req, res) => {
    res.status(200).clearCookie("authToken").json({ success: true });
});

module.exports = router;
