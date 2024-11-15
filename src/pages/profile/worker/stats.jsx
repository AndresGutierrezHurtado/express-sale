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
    const { data: user, loading: userLoading, reload: reloadUser } = useGetData(`/users/${id}`);

    if (userLoading) return <ContentLoading />;
    if (user.rol_id == 2) return <SellerStats user={user} reloadUser={reloadUser} />;
    if (user.rol_id == 3) return <DeliveryStats user={user} reloadUser={reloadUser} />;
    return <h1>Hubo un errror</h1>;
}
