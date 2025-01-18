import React from "react";
import { Link, useParams } from "react-router-dom";
import Swal from "sweetalert2";

// Hooks
import { useGetData, usePutData } from "@hooks/useFetchData.js";
import { useGenerateReceipt } from "@hooks/useGenerateReceipt";

// Components
import ContentLoading from "@components/contentLoading.jsx";
import { EyeIcon, CircleCheckIcon, ArrowLeftIcon, ReceiptIcon } from "@components/icons.jsx";

// Contexts
import { useAuthContext } from "@contexts/authContext.jsx";

export default function Order() {
    const { id } = useParams();
    const { data: order, loading: orderLoading, reload: reloadOrder } = useGetData(`/orders/${id}`);
    const { userSession } = useAuthContext();

    const handleMarkAsReceived = () => {
        Swal.fire({
            icon: "info",
            title: "Marcar como recibido",
            text: "Dale a continuar si quieres marcar el pedido como recibido",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            cancelButtonText: "Cancelar",
            confirmButtonText: "Continuar",
        }).then(async (result) => {
            if (result.isConfirmed) {
                const response = await usePutData(`/orders/${id}`, {
                    order: {
                        pedido_estado: "recibido",
                    },
                    delivery: {
                        trabajador_saldo:
                            parseInt(order.shippingDetails.worker.trabajador_saldo) +
                            parseInt(order.shippingDetails.envio_valor),
                    },
                    delivery_id: order.shippingDetails.trabajador_id,
                });
                if (response.success) {
                    reloadOrder();
                }
            }
        });
    };

    if (orderLoading) return <ContentLoading />;
    return (
        <section className="w-full px-3">
            <div className="w-full min-h-screen flex items-center justify-center py-10">
                <div className="card bg-white border border-gray-100 shadow-lg rounded-lg w-full max-w-2xl">
                    <div className="card-body space-y-4">
                        <h2 className="text-4xl font-extrabold tracking-tight">
                            Detalles del pedido:
                        </h2>
                        <div className="space-y-4">
                            <div className="flex flex-col md:flex-row [&>div]:grow gap-5">
                                <article className="[&>div]:text-sm">
                                    <h2 className="text-xl font-bold">Comprador:</h2>
                                    <div className="flex gap-2">
                                        <span className="font-medium">Nombre:</span>
                                        <p>{order.paymentDetails.comprador_nombre}</p>
                                    </div>
                                    <div className="flex gap-2">
                                        <span className="font-medium">Correo<span className="hidden md:inline-flex ml-1">Electrónico</span>:</span>
                                        <p>{order.paymentDetails.comprador_correo}</p>
                                    </div>
                                    <div className="flex gap-2">
                                        <span className="font-medium">Teléfono:</span>
                                        <p>{order.paymentDetails.comprador_telefono}</p>
                                    </div>
                                </article>
                                <article className="[&>div]:text-sm">
                                    <h2 className="text-xl font-bold">Compra:</h2>
                                    <div className="flex gap-2">
                                        <span className="font-medium">Método de pago:</span>
                                        <p>{order.paymentDetails.pago_metodo}</p>
                                    </div>

                                    <div className="flex gap-2">
                                        <span className="font-medium">Total:</span>
                                        <p>
                                            {parseInt(
                                                order.paymentDetails.pago_valor
                                            ).toLocaleString("es-CO")}{" "}
                                            COP
                                        </p>
                                    </div>

                                    <div className="flex gap-2">
                                        <span className="font-medium">Repartidor:</span>
                                        {order.shippingDetails.trabajador_id ? (
                                            <Link
                                                to={`/worker/${order.shippingDetails.worker.user.user_id}`}
                                                className="hover"
                                            >
                                                {`${order.shippingDetails.worker.user.usuario_nombre} ${order.shippingDetails.worker.user.usuario_apellido}` ||
                                                    "Pendiente"}
                                            </Link>
                                        ) : (
                                            <p>Pendiente</p>
                                        )}
                                    </div>
                                </article>
                            </div>

                            <button
                                onClick={() => useGenerateReceipt(order, userSession)}
                                className="btn w-full btn-sm relative"
                            >
                                <span className="absolute left-3 top-1/2 -translate-y-1/2">
                                    <ReceiptIcon size={17} />
                                </span>
                                Ver factura
                            </button>
                        </div>
                        <hr />
                        <div className="space-y-5">
                            <h3 className="text-xl font-bold capitalize">
                                {order.orderProducts.length} producto
                                {order.orderProducts.length > 1 && "s"}
                            </h3>
                            <div className="space-y-2">
                                {order.orderProducts.map((product) => (
                                    <div
                                        key={product.product_id}
                                        className="card border rounded-lg"
                                    >
                                        <article className="card-body p-4 flex-col sm:flex-row gap-2 [&_p]:grow-0">
                                            <Link
                                                to={`/product/${product.product_id}`}
                                                className="size-[130px] mx-auto sm:mx-0"
                                            >
                                                <img
                                                    src={product.product.product_image_url}
                                                    alt={`Imagen del producto ${product.product.product_name}`}
                                                    className="w-full h-full object-contain"
                                                />
                                            </Link>
                                            <div className="grow flex flex-col gap-1">
                                                <div className="grow">
                                                    <div className="flex justify-between items-center w-full">
                                                        <h2 className="text-xl font-bold tracking-tight">
                                                            {product.product.product_name}
                                                        </h2>
                                                        <Link
                                                            to={`/product/${product.product_id}`}
                                                            data-tip="Ver perfil del producto"
                                                            className="tooltip tooltip-left"
                                                        >
                                                            <button className="btn btn-sm btn-primary w-fit">
                                                                <EyeIcon size={20} />
                                                            </button>
                                                        </Link>
                                                    </div>
                                                    <p>cantidad: {product.product_quantity}</p>
                                                </div>
                                                <span className="flex flex-col sm:flex-row justify-between items-center w-full">
                                                    <p>
                                                        Precio:{" "}
                                                        {parseInt(
                                                            product.product_price
                                                        ).toLocaleString("es-CO")}{" "}
                                                        COP
                                                    </p>
                                                    <p>
                                                        Total:{" "}
                                                        {parseInt(
                                                            product.product_price *
                                                                product.product_quantity
                                                        ).toLocaleString("es-CO")}{" "}
                                                        COP
                                                    </p>
                                                </span>
                                            </div>
                                        </article>
                                    </div>
                                ))}
                            </div>
                        </div>
                        <hr />
                        <div className="flex flex-col gap-2">
                            {order.pedido_estado == "entregado" && (
                                <button
                                    onClick={handleMarkAsReceived}
                                    className="btn w-full btn-sm btn-success text-white relative"
                                >
                                    <span className="absolute left-3 top-1/2 -translate-y-1/2">
                                        <CircleCheckIcon size={17} />
                                    </span>
                                    Marcar como recibido
                                </button>
                            )}
                            <Link to={`/profile/user/${order.user_id}`}>
                                <button className="btn w-full btn-sm relative">
                                    <span className="absolute left-3 top-1/2 -translate-y-1/2">
                                        <ArrowLeftIcon size={17} />
                                    </span>
                                    Volver
                                </button>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    );
}
