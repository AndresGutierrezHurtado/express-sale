import * as models from "../models/relations.js";
import sequelize from "../config/database.js";
import { Op } from "sequelize";
import crypto from "crypto";

export default class OrderController {
    static createOrder = (req, res) => {
        const t = sequelize.transaction();
        try {
            const order = models.Order.create({
                pedido_id: crypto.randomUUID(),
                usuario_id: req.session.user.id,
            });

            t.commit();

            res.status(200).json({
                success: true,
                message: "Orden creada correctamente",
                data: order,
            });
        } catch (error) {
            t.rollback();
            res.status(500).json({
                success: false,
                message: error.message,
                data: null,
            });
        }
    };

    static updateOrder = (req, res) => {};

    static getOrder = (req, res) => {
        try {
            const order = models.Order.findByPk(req.params.id, {
                include: [
                    { model: models.OrderProduct, as: "orderProducts" },
                    { model: models.ShippingDetails, as: "shippingDetails" },
                    { model: models.PaymentDetails, as: "paymentDetails" },
                ],
            });
            res.status(200).json({
                success: false,
                message: "Orden encontrada correctamente",
                data: order,
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
