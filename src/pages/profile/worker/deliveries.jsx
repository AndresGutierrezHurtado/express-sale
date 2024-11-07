import React, { useEffect } from "react";
import Swal from "sweetalert2";
import { useNavigate } from "react-router-dom";

// Hooks
import { useGetData, usePutData } from "@hooks/useFetchData.js";

// Components
import ContentLoading from "@components/contentLoading.jsx";
import { CircleCheckIcon } from "@components/icons.jsx";

// Contexts
import { useAuthContext } from "@contexts/authContext.jsx";

export default function WorkerDeliveries() {
    const navigate = useNavigate();
    const { data: orders, loading: loadingOrders } = useGetData(`/orders?pedido_estado=pendiente`);
    const { userSession } = useAuthContext();

    useEffect(() => {
        if (userSession.domiciliario_domicilio) {
            Swal.fire({
                icon: "info",
                title: "Domicilio asignado",
                text: "No puedes realizar pedidos si ya tienes un domicilio asignado",
            });
            navigate(`/delivery/${userSession.domiciliario_domicilio}`);
        }
    });

    const handleSelectOrder = (event) => {
        Swal.fire({
            icon: "info",
            title: "¿Deseas aceptar el pedido?",
            text: "Si lo aceptas, no podrás hacer otro envio hasta que termines este pedido",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            cancelButtonText: "Cancelar",
            confirmButtonText: "Continuar",
        }).then(async (result) => {
            if (result.isConfirmed) {
                const { id, href, price, status = "enviando" } = event.target.dataset;
                const response = await usePutData(`/orders/${id}`, {
                    order: {
                        pedido_estado: status,
                    },
                    shippingDetails: {
                        trabajador_id: userSession.worker.trabajador_id,
                        envio_valor: price,
                    },
                });
                if (response.success) {
                    navigate(href);
                }
            }
        });
    };

    if (loadingOrders) return <ContentLoading />;
    return (
        <section className="w-full px-3">
            <div className="w-full max-w-[1200px] mx-auto py-10">
                <div className="space-y-5">
                    <h2 className="text-center text-2xl sm:text-4xl font-extrabold tracking-tight">
                        Pedidos
                    </h2>
                    <div className="grid grid-cols-[repeat(auto-fill,minmax(300px,1fr))] gap-5">
                        {orders.map((order) => (
                            <div
                                key={order.pedido_id}
                                className="card bg-white border w-full max-w-xl mx-auto shadow-xl"
                            >
                                <div className="card-body space-y-4 p-5">
                                    <h2 className="text-xl font-bold">Detalles del pedido:</h2>
                                    <div className="space-y-4 mt-[0_!important]">
                                        <div className="flex flex-col text-sm">
                                            <div className="flex gap-2">
                                                <span className="font-medium">Comprador:</span>
                                                <p>
                                                    {`${order.user.usuario_nombre} ${order.user.usuario_apellido}`}
                                                </p>
                                            </div>
                                            <div className="flex gap-2">
                                                <span className="font-medium">Distancia:</span>
                                                <p>{`5 Km`}</p>
                                            </div>
                                            <div className="flex gap-2">
                                                <span className="font-medium">Pago:</span>
                                                <p>
                                                    {`${parseInt(
                                                        order.paymentDetails.pago_valor
                                                    ).toLocaleString("es-CO")} COP`}
                                                </p>
                                            </div>
                                            <div className="flex gap-2">
                                                <span className="font-medium">Mensaje:</span>
                                                <p>{`${order.shippingDetails.envio_mensaje}`}</p>
                                            </div>
                                        </div>
                                        <button
                                            onClick={handleSelectOrder}
                                            data-id={order.pedido_id}
                                            data-href={`/delivery/${order.pedido_id}`}
                                            data-price={7500}
                                            className="btn btn-success btn-sm text-white w-full relative"
                                        >
                                            <span className="absolute top-1/2 -translate-y-1/2 left-3">
                                                <CircleCheckIcon />
                                            </span>
                                            Realizar pedido
                                        </button>
                                    </div>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            </div>
        </section>
    );
}
