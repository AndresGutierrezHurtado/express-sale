import { useState, useEffect } from "react";
import { useGetData } from "../hooks/useFetchData";
import { useParams } from "react-router-dom";

export default function Worker() {
    const [seller, setSeller] = useState(null);
    const { id } = useParams();

    console.log(seller);

    const getSeller = async () => {
        const user = await useGetData(`/api/users/${id}`);
        if (user) {
            setSeller(user.data);
        }
    };

    useEffect(() => {
        getSeller();
    }, []);

    if (!seller) return <div>Cargando...</div>;

    return <></>;
}
