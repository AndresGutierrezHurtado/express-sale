import { useState, useEffect } from "react";
import { useParams } from "react-router-dom";
import { useGetData } from "../../hooks/useFetchData";

export default function ProductProfile() {
    const { id } = useParams();
    const { data: product, loading: loadingProduct, reload: reloadProduct } = useGetData(`/products/${id}`);

    console.log(product)
    if (!loadingProduct) return <div>Cargando...</div>;
    return(
        <></>
    );
}