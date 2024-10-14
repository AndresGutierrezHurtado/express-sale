const router = require("express").Router();

const conn = require("../config/connection");
// Models
const models = require("../models/relations");

// create
router.post("/ratings/users/:id", async (req, res) => {
    const t = await conn.transaction();
    try {
        const rating = await models.Rating.create({
            calificacion_id: crypto.randomUUID(),
            calificacion_comentario: req.body.calificacion_comentario,
            calificacion_imagen_url: req.body.calificacion_imagen_url || "",
            calificacion: req.body.calificacion,
            usuario_id: req.session.user.id,
        });

        const userRatings = await models.UsersCalifications.create({
            calificacion_id: rating.calificacion_id,
            usuario_id: req.params.id,
        });

        await t.commit();
        res.status(200).json({
            success: true,
            message: "Calificación creada correctamente.",
            data: rating,
        });
    } catch (error) {
        await t.rollback();
        res.status(404).json({
            success: false,
            message: error.message,
        });
    }
});

router.post("/ratings/products/:id", async (req, res) => {
    const t = await conn.transaction();
    try {
        const rating = await models.Rating.create({
            calificacion_id: crypto.randomUUID(),
            calificacion_comentario: req.body.calificacion_comentario,
            calificacion_imagen_url: req.body.calificacion_imagen_url || "",
            calificacion: req.body.calificacion,
            usuario_id: req.session.user.id,
        });

        const productRatings = await models.ProductsCalifications.create({
            calificacion_id: rating.calificacion_id,
            producto_id: req.params.id,
        });

        await t.commit();
        res.status(200).json({
            success: true,
            message: "Calificación creada correctamente.",
            data: rating,
        });
    } catch (error) {
        res.status(404).json({
            success: false,
            message: error.message,
        });
    }
});

module.exports = router;
