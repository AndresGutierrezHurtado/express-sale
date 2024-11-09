import React from "react";
import { useParams } from "react-router-dom";

// Hooks
import { useGetData } from "@hooks/useFetchData";

export default function Delivery() {
    const { id } = useParams();

    const { data: order, loading: orderLoading } = useGetData(`/orders/${id}`);

    /**
     * se debe mostrar la persona, el mensaje uqe dejo, los productos y ubicacion y precio de cada uno
     * y se debe mostrar el mapa y el boton de abrirlo en google o waze
     */

    if (orderLoading) return <ContentLoading />;
    return (
        <section className="w-full px-3">
            <div className="w-full max-w-[1200px] mx-auto py-10">
                <div className="card bg-white border">
                    <div className="card-body">
                        <h1 className="text-5xl font-extrabold tracking-tight">Envio:</h1>
                    </div>
                </div>
            </div>
        </section>
    );
}
