import React from "react";
import { Link, useParams } from "react-router-dom";

// Hooks
import { useGetData } from "@hooks/useFetchData.js";

// Components
import ContentLoading from "@components/contentLoading.jsx";

export default function Order() {
    const { id } = useParams();
    const { data: order, loading: orderLoading } = useGetData(`/orders/${id}`);

    console.log(order);
    if (orderLoading) return <ContentLoading />;
    return (
        <>
            <div className="w-full min-h-screen flex items-center justify-center">
                <div className="card bg-white border border-gray-100 shadow-lg rounded-lg w-full max-w-xl">
                    <div className="card-body space-y-4">
                        <h2 className="text-4xl font-extrabold tracking-tight">
                            Detalles del pedido:
                        </h2>
                        <div>
                            <p>info...</p>
                            <button className="btn w-full btn-sm">Ver Factura</button>
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
                                        key={product.producto_id}
                                        className="card border rounded-lg"
                                    >
                                        <article className="card-body p-4 flex-row gap-2 [&_p]:grow-0">
                                            <figure className="size-[130px]">
                                                <img
                                                    src={product.product.producto_imagen_url}
                                                    alt={`Imagen del producto ${product.product.producto_nombre}`}
                                                    className="w-full h-full object-contain"
                                                />
                                            </figure>
                                            <div className="grow flex flex-col gap-1">
                                                <div className="grow">
                                                    <h2 className="text-xl font-bold tracking-tight">
                                                        {product.product.producto_nombre}
                                                    </h2>
                                                    <p>cantidad: {product.producto_cantidad}</p>
                                                </div>
                                                <span className="flex justify-between items-center w-full">
                                                    <p>
                                                        Precio:{" "}
                                                        {parseInt(
                                                            product.producto_precio
                                                        ).toLocaleString("es-CO")}{" "}
                                                        COP
                                                    </p>
                                                    <p>
                                                        Total:{" "}
                                                        {parseInt(
                                                            product.producto_precio *
                                                                product.producto_cantidad
                                                        ).toLocaleString("es-CO")}{" "}
                                                        COP
                                                    </p>
                                                </span>
                                                <div>
                                                    <Link
                                                        to={`/product/${product.producto_id}`}
                                                        className="btn btn-sm btn-primary w-full"
                                                    >
                                                        Ver perfil
                                                    </Link>
                                                </div>
                                            </div>
                                        </article>
                                    </div>
                                ))}
                            </div>
                        </div>
                        <hr />
                        <div className="space-y-2">
                            <button className="btn w-full btn-sm btn-primary">Marcar como recibido</button>
                            <Link to={`/profile/user/${order.usuario_id}`} className="btn w-full btn-sm">Volver</Link>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}
