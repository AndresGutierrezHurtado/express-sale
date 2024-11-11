import React from "react";
import { useParams } from "react-router-dom";

// Hooks
import { useGetData } from "@hooks/useFetchData.js";

// Components
import ContentLoading from "@components/contentLoading.jsx";
import DeliveryStats from "@components/profile/DeliveryStats.jsx";
import SellerStats from "@components/profile/sellerStats.jsx";

export default function WorkerStats() {
    const { id } = useParams();
    const { data: user, loading: userLoading } = useGetData(`/users/${id}`);

    if (userLoading) return <ContentLoading />;
    if (user.rol_id == 2) return <SellerStats user={user} />;
    if (user.rol_id == 3) return <DeliveryStats user={user} />;
    return <h1>Hubo un errror</h1>;
}
