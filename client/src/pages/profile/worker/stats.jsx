import React, { useEffect } from "react";
import { useParams } from "react-router-dom";
import io from "socket.io-client";

// Hooks
import { useGetData } from "@hooks/useFetchData.js";

// Components
import ContentLoading from "@components/contentLoading.jsx";
import DeliveryStats from "@components/profile/DeliveryStats.jsx";
import SellerStats from "@components/profile/sellerStats.jsx";
import { toast } from "react-toastify";

export default function WorkerStats() {
    const { id } = useParams();
    const { data: user, loading: userLoading, reload: reloadUser } = useGetData(`/users/${id}`);
    const socket = io(import.meta.env.VITE_API_DOMAIN);

    useEffect(() => {
        socket.on("sale", (data) => {
            if ( data.filter((item) => item.user_id == user.user_id).length == 0 ) return;

            toast.success("Venta realizada", {
                theme: "colored",
                position: "bottom-right",
                autoClose: 8000,
                pauseOnHover: false,
            });
            reloadUser();
        });

        return () => {
            socket.off("sale");
        };
    });

    if (userLoading) return <ContentLoading />;
    if (user.role_id == 2) return <SellerStats user={user} reloadUser={reloadUser} />;
    if (user.role_id == 3) return <DeliveryStats user={user} reloadUser={reloadUser} />;
    return <h1>Hubo un errror</h1>;
}
