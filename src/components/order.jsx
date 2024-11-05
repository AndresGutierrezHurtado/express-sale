import React from "react";
import { Link } from "react-router-dom";

export function Order({ order }) {
    return (
        <div className="card bg-white border border-gray-100 shadow-lg [&_p]:grow-0 max-w-lg">
            <div className="card-body">
                <div className="flex justify-between items-center w-full">
                    <h2 className="text-2xl font-bold tracking-tight">Pedido No° {order.pedido_id.split("-")[1]}</h2>
                    <p className="text-gray-600 text-sm font-medium">{new Date(order.pedido_fecha).toLocaleString()}</p>
                </div>
                <div className="flex justify-between items-center w-full text-lg capitalize">
                    <p>{order.orderProducts.length} producto{order.orderProducts.length > 1 && "s"}</p>
                    <p>{parseInt(order.paymentDetails.pago_valor).toLocaleString("es-CO")} COP</p>
                </div>
                <div className="flex justify-between items-center w-full">
                    <Link to={`/order/${order.pedido_id}`} className="btn btn-outline btn-sm w-fit">Ver detalles</Link>
                    <p className="text-purple-700 font-semibold text-lg capitalize">{order.pedido_estado}</p>
                </div>
            </div>
        </div>
    );
}
