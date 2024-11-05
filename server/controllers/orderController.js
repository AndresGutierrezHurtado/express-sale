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

    static payuCallback = async (req, res) => {
        const t = await sequelize.transaction();
        const extraInfo = { ...JSON.parse(req.query.extra1), ...JSON.parse(req.query.extra2) };
        try {
            if (req.query.polResponseCode !== "1" || req.query.lapResponseCode !== "APPROVED") {
                throw new Error("No se pudo realizar el pago");
            }

            const order = await models.Order.create({
                pedido_id: crypto.randomUUID(),
                usuario_id: req.session.user.usuario_id,
            });

            const paymentDetails = await models.PaymentDetails.create({
                pago_id: crypto.randomUUID(),
                pedido_id: order.pedido_id,
                pago_metodo: req.query.polPaymentMethodType,
                pago_valor: req.query.TX_VALUE,
                comprador_nombre: extraInfo.payerFullname,
                comprador_correo: req.query.buyerEmail,
                comprador_tipo_documento: extraInfo.payerDocumentType,
                comprador_numero_documento: extraInfo.payerDocument,
                comprador_telefono: extraInfo.payerPhone,
            });

            const shippingDetails = await models.ShippingDetails.create({
                envio_id: crypto.randomUUID(),
                pedido_id: order.pedido_id,
                envio_direccion: extraInfo.shippingAddress,
                envio_coordenadas: extraInfo.shippingCoordinates,
                envio_metodo: req.query.polShippingMethod,
                envio_valor: 7500,
                envio_mensaje: extraInfo.payerMessage,
            });

            const carts = await models.Cart.findAll({
                where: { usuario_id: req.session.user.usuario_id },
                include: [{ model: models.Product, as: "product" }],
            });

            const cart = carts.map((cart) => {
                return{
                    pedido_id: order.pedido_id,
                    producto_id: cart.producto_id,
                    producto_cantidad: cart.producto_cantidad,
                    producto_precio: cart.product.producto_precio,
                }
            })

            const orderProducts = await models.OrderProduct.bulkCreate(cart, { transaction: t });

            await t.commit();
            res.redirect(`${process.env.VITE_URL}/order/${order.pedido_id}`);
        } catch (error) {
            await t.rollback();
            res.status(500).json({
                success: false,
                message: error.message,
                data: null,
            });
        }
    };
}
