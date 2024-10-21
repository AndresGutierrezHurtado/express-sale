import { useState, useEffect } from "react";
import { Link, useParams } from "react-router-dom";

// Hooks
import { useGetData } from "@hooks/useFetchData";

// Components
import { CartAddIcon, StarIcon, UserIcon } from "@components/icons.jsx";
import ContentLoading from "@components/contentLoading.jsx";

export default function Product() {
    const { id } = useParams();
    const {
        loading: loadingProduct,
        data: product,
        reload: reloadProduct,
    } = useGetData(`/products/${id}`);

    if (loadingProduct) return <ContentLoading />;
    return (
        <>
            <section className="w-full px-3">
                <div className="w-full max-w-[1200px] mx-auto py-10">
                    <div className="flex flex-col border bg-white rounded-lg divide-y">
                        <span className="breadcrumbs text-sm capitalize px-5">
                            <ul>
                                <li>
                                    <Link to="/products">Productos</Link>
                                </li>
                                <li>
                                    <Link
                                        to={`/products?category=${product.categoria_id}`}
                                    >
                                        {product.category.categoria_nombre}
                                    </Link>
                                </li>
                                <li>
                                    <a className="text-purple-700 ">
                                        {product.producto_nombre}
                                    </a>
                                </li>
                            </ul>
                        </span>
                        <div className="flex gap-10 p-5 w-full">
                            <div className="flex flex-none">
                                <figure className="w-[320px] flex-none aspect-square border">
                                    <img
                                        src={product.producto_imagen_url}
                                        alt={`Imagen del producto ${product.producto_nombre}`}
                                        className="object-contain h-full w-full"
                                    />
                                </figure>
                                <div className="h-[initial] p-1 border max-w-[100px] flex-none">
                                    <img
                                        src={product.producto_imagen_url}
                                        alt={`Imagen del producto ${product.producto_nombre}`}
                                        className="border border-purple-700"
                                    />
                                    {product.media.forEach((media) => {
                                        if (media.media_type === "image") {
                                            return (
                                                <img
                                                    src={media.media_url}
                                                    alt={`Imagen del producto ${product.producto_nombre}`}
                                                    className="object-contain h-full w-full"
                                                />
                                            );
                                        } else {
                                            return (
                                                <video
                                                    src={media.media_url}
                                                    alt={`Video del producto ${product.producto_nombre}`}
                                                    className="object-contain h-full w-full"
                                                />
                                            );
                                        }
                                    })}
                                </div>
                            </div>
                            <article className="w-full flex flex-col h-[initial]">
                                <div className="w-full">
                                    <div className="flex justify-between items-center w-full">
                                        <h2 className="text-4xl md:text-3xl font-bold leading-none">
                                            {product.producto_nombre}
                                        </h2>
                                        <p className="text-gray-600/90 font-medium">
                                            {new Intl.DateTimeFormat(
                                                "es-CO"
                                            ).format(
                                                new Date(product.producto_fecha)
                                            )}
                                        </p>
                                    </div>
                                    {product.user && (
                                        <Link
                                            to={`/worker/${product.user.usuario_id}`}
                                            className="text-gray-500/80 font-semibold italic text-sm hover:underline tooltip tooltip-bottom"
                                            data-tip="Ir al perfil del vendedor"
                                        >
                                            @publicado por{" "}
                                            {product.user.usuario_alias}
                                        </Link>
                                    )}
                                </div>
                                <p className="grow">
                                    {product.producto_descripcion}
                                </p>
                                <div className="space-y-3">
                                    <span className="flex justify-between items-center">
                                        <p>
                                            {product.producto_cantidad}{" "}
                                            Disponibles
                                        </p>
                                        <div className="flex items-center gap-2">
                                            <p className="flex items-center">
                                                {product.calificacion_promedio}
                                                <StarIcon />
                                            </p>
                                            <span className="flex items-center">
                                            ({parseInt(product.calificacion_cantidad)}
                                                <UserIcon />)
                                            </span>
                                        </div>
                                    </span>

                                    <button className="btn btn-sm min-h-none h-auto py-3 btn-primary group relative text-purple-300 hover:bg-purple-800 hover:text-purple-100 w-full">
                                        <span className="absolute left-3 top-1/2 transform -translate-y-1/2 text-purple-300 group-hover:text-purple-100">
                                            <CartAddIcon size={17} />
                                        </span>
                                        Añadir al carrito
                                    </button>
                                </div>
                            </article>
                        </div>
                    </div>
                </div>
            </section>
        </>
    );
}
