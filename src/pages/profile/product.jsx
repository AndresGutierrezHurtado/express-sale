import { useState, useEffect } from "react";
import { useParams } from "react-router-dom";

// Hooks
import { useGetData } from "@hooks/useFetchData";

// Components
import ContentLoading from "@components/contentLoading";

export default function ProductProfile() {
    const { id } = useParams();
    const {
        data: product,
        loading: loadingProduct,
        reload: reloadProduct,
    } = useGetData(`/products/${id}`);

    console.log(product);
    if (loadingProduct) return <ContentLoading />;
    return (
        <section className="w-full">
            <div className="w-full max-w-[1200px] mx-auto py-10">
                <form className="flex flex-col md:flex-row gap-5">
                    <div className="card bg-white shadow-xl border">
                        <div className="card-body w-full">
                            <h2>Vista previa</h2>
                            <div className="mx-auto">
                                <figure className="w-full max-w-[300px] aspect-square">
                                    <img
                                        src={product.producto_imagen_url}
                                        alt={`Imagen del producto ${product.producto_titulo}`}
                                        className="object-contain h-full w-full"
                                    />
                                </figure>
                            </div>
                            <div className="flex w-full justify-between">
                                <h2>{product.producto_nombre}</h2>
                                <p className="grow-0">{product.calificacion_promedio}</p>
                            </div>
                            <p>{product.producto_descripcion}</p>
                            <p>{parseFloat(product.producto_precio).toLocaleString("es-CO")} COP</p>
                        </div>
                    </div>
                    <div className="grow">
                        <div className="card bg-white shadow-xl border">
                            <div className="card-body">
                                <h2>Comentarios</h2>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    );
}
