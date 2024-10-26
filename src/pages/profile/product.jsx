import { useState, useEffect } from "react";
import { useParams, Link } from "react-router-dom";

// Hooks
import { useGetData, usePutData } from "@hooks/useFetchData.js";
import { useValidateform } from "@hooks/useValidateForm.js";

// Components
import ContentLoading from "@components/contentLoading.jsx";
import { RegisterIcon, StarIcon, UserIcon } from "@components/icons.jsx";

export default function ProductProfile() {
    const { id } = useParams();
    const {
        data: product,
        loading: loadingProduct,
        reload: reloadProduct,
    } = useGetData(`/products/${id}`);

    const handleUpdateProductSubmit = (event) => {
        event.preventDefault();

        const data = Object.fromEntries(new FormData(event.target));
        const validation = useValidateform(data, "update-product-form");

        // if (validation.success) {
        //     const response = usePutData(`/products/${product.producto_id}`, data);
        //     if (response.success) reloadProduct();
        // }
    };

    if (loadingProduct) return <ContentLoading />;
    return (
        <section className="w-full">
            <div className="w-full max-w-[1200px] mx-auto py-10">
                <article className="flex flex-col md:flex-row gap-5">
                    <div className="card bg-white shadow-xl border h-fit">
                        <div className="card-body w-full max-w-[450px] h-fit">
                            <h2 className="text-3xl font-extrabold tracking-tight">Vista previa</h2>
                            <div className="mx-auto">
                                <figure className="w-full max-w-[300px] aspect-square">
                                    <img
                                        src={product.producto_imagen_url}
                                        alt={`Imagen del producto ${product.producto_titulo}`}
                                        className="object-contain h-full w-full"
                                    />
                                </figure>
                            </div>
                            <div className="flex w-full items-center justify-between">
                                <h2 className="text-2xl font-bold">{product.producto_nombre}</h2>
                                <p className="grow-0 flex gap-1 items-center">
                                    <StarIcon />
                                    {product.calificacion_promedio}
                                </p>
                            </div>
                            <p>{product.producto_descripcion}</p>
                            <p className="text-lg font-bold">
                                {parseFloat(product.producto_precio).toLocaleString("es-CO")} COP
                            </p>
                            <Link
                                to={`/product/${product.producto_id}`}
                                className="btn btn-sm min-h-none h-auto py-3 btn-primary group relative text-purple-300 hover:bg-purple-800 hover:text-purple-100 w-full"
                            >
                                <span className="absolute left-3 top-1/2 transform -translate-y-1/2 text-purple-300 group-hover:text-purple-100">
                                    <UserIcon size={13} />
                                </span>
                                Ver perfil
                            </Link>
                        </div>
                    </div>
                    <div className="grow flex-1">
                        <div className="card bg-white shadow-xl border">
                            <div className="card-body">
                                <h2 className="text-3xl font-extrabold tracking-tight">Editar</h2>
                                <form className="space-y-4" onSubmit={handleUpdateProductSubmit}>
                                    <div className="form-control">
                                        <label className="label">
                                            <span className="label-text font-semibold after:content-['*'] after:ml-0.5 after:text-red-500">
                                                Nombre:
                                            </span>
                                        </label>
                                        <input
                                            className="input input-sm input-bordered w-full focus:input-primary focus:outline-0 rounded"
                                            defaultValue={product.producto_nombre}
                                            name="producto_nombre"
                                        />
                                    </div>
                                    <div className="form-control">
                                        <label className="label">
                                            <span className="label-text font-semibold after:content-['*'] after:ml-0.5 after:text-red-500">
                                                Precio:
                                            </span>
                                        </label>
                                        <input
                                            className="input input-sm input-bordered w-full focus:input-primary focus:outline-0 rounded"
                                            defaultValue={product.producto_precio}
                                            name="producto_precio"
                                        />
                                    </div>
                                    <div className="form-control">
                                        <label className="label">
                                            <span className="label-text font-semibold after:content-['*'] after:ml-0.5 after:text-red-500">
                                                Descripción:
                                            </span>
                                        </label>
                                        <textarea
                                            className="textarea textarea-bordered resize-none h-32 textarea-sm w-full focus:input-primary focus:outline-0 rounded leading-[1.5]"
                                            defaultValue={product.producto_descripcion}
                                            name="producto_descripcion"
                                        />
                                    </div>
                                    <div className="form-control">
                                        <label className="label">
                                            <span className="label-text font-semibold">
                                                Imagen:
                                            </span>
                                        </label>
                                        <input
                                            type="file"
                                            className="file-input file-input-bordered file-input-sm w-full focus:input-primary focus:outline-0 rounded"
                                            accept=".jpg, .jpeg, .png"
                                            name="producto_imagen_url"
                                        />
                                    </div>
                                    <div className="form-control">
                                        <label className="label">
                                            <span className="label-text font-semibold after:content-['(máximo_5)'] after:ml-1.5 after:text-gray-500">
                                                Multimedia:
                                            </span>
                                        </label>
                                        <input
                                            type="file"
                                            multiple={true}
                                            max={5}
                                            className="file-input file-input-bordered file-input-sm w-full focus:input-primary focus:outline-0 rounded"
                                            accept=".jpg, .jpeg, .png"
                                            name="[multimedias]"
                                        />
                                    </div>

                                    <button
                                        type="submit"
                                        className="btn btn-sm min-h-none h-auto py-3 btn-primary group relative text-purple-300 hover:bg-purple-800 hover:text-purple-100 w-full"
                                    >
                                        <span className="absolute left-3 top-1/2 transform -translate-y-1/2 text-purple-300 group-hover:text-purple-100">
                                            <RegisterIcon size={13} />
                                        </span>
                                        Subir
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </section>
    );
}
