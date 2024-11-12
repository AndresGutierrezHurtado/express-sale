import React, { useEffect } from "react";
import Swal from "sweetalert2";
import { useNavigate } from "react-router-dom";

// Hooks
import { useGetData } from "@hooks/useFetchData.js";

// Components
import ContentLoading from "@components/contentLoading.jsx";
import OrderCard from "@components/orderCard";

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

    if (loadingOrders) return <ContentLoading />;
    return (
        <section className="w-full px-3">
            <div className="w-full max-w-[1200px] mx-auto py-10">
                <div className="space-y-5">
                    <h2 className="text-center text-2xl sm:text-4xl font-extrabold tracking-tight">
                        Pedidos
                    </h2>
                    {orders.length == 0 && (
                        <p className="text-center text-xl font-semibold">
                            No tienes ningun pedido pendiente...
                        </p>
                    )}
                    <div className="grid grid-cols-[repeat(auto-fill,minmax(300px,1fr))] gap-5">
                        {orders.map((order) => (
                            <OrderCard key={order.pedido_id} order={order} />
                        ))}
                    </div>
                </div>
            </div>
        </section>
    );
}
