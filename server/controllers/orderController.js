import * as models from "../models/relations.js";
import sequelize from "../config/database.js";
import { Op } from "sequelize";
import crypto from "crypto";
import UserController from "./userController.js";

export default class OrderController {
    static payuCallback = async (req, res) => {
        const t = await sequelize.transaction();
        const extraInfo = { ...JSON.parse(req.query.extra1), ...JSON.parse(req.query.extra2) };

        try {
            const payuResponse = await fetch(process.env.VITE_PAYU_TRANSACTION_REQUEST_URI, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                },
                body: JSON.stringify({
                    test: process.env.VITE_PAYU_TEST_MODE == 1 ? true : false,
                    language: "en",
                    command: "ORDER_DETAIL_BY_REFERENCE_CODE",
                    merchant: {
                        apiLogin: process.env.VITE_PAYU_API_LOGIN,
                        apiKey: process.env.VITE_PAYU_API_KEY,
                    },
                    details: {
                        referenceCode: req.query.referenceCode,
                    },
                }),
            })
                .then((res) => res.json())
                .then((data) => {
                    if (data.code !== "SUCCESS") {
                        throw new Error(data.error);
                    }
                    return data.result.payload[0];
                });

            const transactionDetailedInfo =
                payuResponse.transactions[payuResponse.transactions.length - 1];

            if (transactionDetailedInfo.transactionResponse.state !== "APPROVED") {
                throw new Error("No se pudo realizar el pago");
            }

            const order = await models.Order.create({
                pedido_id: crypto.randomUUID(),
                usuario_id: req.session.user.usuario_id,
            });

            const paymentDetails = await models.PaymentDetails.create({
                pago_id: crypto.randomUUID(),
                pedido_id: order.pedido_id,
                pago_metodo: transactionDetailedInfo.paymentMethod,
                pago_valor: transactionDetailedInfo.additionalValues.PM_PAYER_TOTAL_AMOUNT.value,
                comprador_nombre: transactionDetailedInfo.payer.fullName,
                comprador_correo: transactionDetailedInfo.payer.emailAddress,
                comprador_tipo_documento: transactionDetailedInfo.payer.dniType,
                comprador_numero_documento: transactionDetailedInfo.payer.dniNumber,
                comprador_telefono: transactionDetailedInfo.extraParameters.PAYER_TELEPHONE,
                payu_referencia: payuResponse.referenceCode,
            });

            const shippingDetails = await models.ShippingDetails.create({
                envio_id: crypto.randomUUID(),
                pedido_id: order.pedido_id,
                envio_direccion: extraInfo.shippingAddress,
                envio_coordenadas: extraInfo.shippingCoordinates,
                envio_valor: 7500,
                envio_mensaje: extraInfo.payerMessage,
            });

            const carts = await models.Cart.findAll({
                where: { usuario_id: req.session.user.usuario_id },
                include: [{ model: models.Product, as: "product" }],
            });

            const cartItems = carts.map((cart) => {
                return {
                    pedido_id: order.pedido_id,
                    producto_id: cart.producto_id,
                    producto_cantidad: cart.producto_cantidad,
                    producto_precio: cart.product.producto_precio,
                };
            });

            const orderProducts = await models.OrderProduct.bulkCreate(cartItems, {
                transaction: t,
            });

            const emptyCart = await models.Cart.destroy({
                where: { usuario_id: req.session.usuario_id },
            });

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

    static updateOrder = async (req, res) => {
        const t = await sequelize.transaction();
        try {
            if (req.body.order) {
                await models.Order.update(req.body.order, {
                    where: { pedido_id: req.params.id },
                    transaction: t,
                });
            }

            if (req.body.shippingDetails) {
                await models.ShippingDetails.update(req.body.shippingDetails, {
                    where: { pedido_id: req.params.id },
                    transaction: t,
                });
            }

            if (req.body.worker) {
                await models.Worker.update(req.body.worker, {
                    where: { usuario_id: req.session.user.usuario_id },
                    transaction: t,
                })
            }

            await t.commit();
            res.status(200).json({
                success: true,
                message: "Orden actualizada correctamente",
                data: null,
            });
        } catch (error) {
            await t.rollback();
            res.status(500).json({
                success: false,
                message: error.message,
                data: null,
            });
        }
    };

    static getOrder = async (req, res) => {
        try {
            const order = await models.Order.findByPk(req.params.id, {
                include: [
                    {
                        model: models.OrderProduct,
                        as: "orderProducts",
                        include: {
                            model: models.Product,
                            as: "product",
                            include: { model: models.User, as: "user" },
                        },
                    },
                    { model: models.ShippingDetails, as: "shippingDetails" },
                    { model: models.PaymentDetails, as: "paymentDetails" },
                    { model: models.User, as: "user" },
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

    static getOrders = async (req, res) => {
        const whereClause = {};
        if (req.query.pedido_estado) whereClause.pedido_estado = req.query.pedido_estado;
        try {
            const order = await models.Order.findAll({
                where: whereClause,
                include: [
                    { model: models.User, as: "user" },
                    {
                        model: models.OrderProduct,
                        as: "orderProducts",
                        include: {
                            model: models.Product,
                            as: "product",
                            include: { model: models.User, as: "user" },
                        },
                    },
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
