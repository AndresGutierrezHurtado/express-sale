import React from "react";
import Swal from "sweetalert2";

// Components
import { CircleCheckIcon, GoogleMapsIcon } from "./icons.jsx";

// Contexts
import { useAuthContext } from "@contexts/authContext.jsx";

// Hooks
import { Link, useNavigate } from "react-router-dom";
import { usePutData } from "@hooks/useFetchData";
import { useGetUserLocation, useMapsApiLoader, useShortestPath } from "@hooks/useMaps";

export default function OrderCard({ order }) {
    const { userSession } = useAuthContext();
    const navigate = useNavigate();
    const userLocation = useGetUserLocation();
    const isLoaded = useMapsApiLoader();

    const addresses = order.orderProducts.map(
        (OrderProduct) => OrderProduct.product.user.usuario_direccion
    );

    const { loaded, route, distance } = useShortestPath(addresses, order.shippingDetails.envio_coordenadas, isLoaded, userLocation);

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
                const { href, price } = event.target.dataset;
                const response = await usePutData(`/orders/${order.pedido_id}`, {
                    order: {
                        pedido_estado: "enviando",
                    },
                    shippingDetails: {
                        trabajador_id: userSession.worker.trabajador_id,
                        envio_valor: distance > 10 ? distance * 1300 : 7500,
                    },
                });
                if (response.success) {
                    navigate(`/delivery/${order.pedido_id}`);
                }
            }
        });
    };

    if (!loaded) return <div className="skeleton w-full max-w-xl rounded"></div>;
    return (
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
                            <p>{`${order.user.usuario_nombre} ${order.user.usuario_apellido}`}</p>
                        </div>
                        <div className="flex gap-2">
                            <span className="font-medium">Distancia:</span>
                            <p>{`${distance} km`}</p>
                        </div>
                        <div className="flex gap-2">
                            <span className="font-medium">Pago:</span>
                            <p>
                                {`${parseInt(distance > 10 ? distance * 1300 : 7500).toLocaleString(
                                    "es-CO"
                                )} COP`}
                            </p>
                        </div>
                        <div className="flex gap-2">
                            <span className="font-medium">Mensaje:</span>
                            <p>{`${order.shippingDetails.envio_mensaje}`}</p>
                        </div>
                    </div>

                    <Link
                        target="_blank"
                        to={`https://www.google.com/maps/dir/${userLocation.lat},${
                            userLocation.lng
                        }/${route.map((point) => point.lat + "," + point.lng).join("/")}`}
                        className="btn btn-sm w-full relative"
                    >
                        <span className="absolute top-1/2 -translate-y-1/2 left-3">
                            <GoogleMapsIcon size={17} />
                        </span>
                        Ver ruta en Google Maps
                    </Link>
                    <button
                        onClick={handleSelectOrder}
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
    );
}
