import { useState, useEffect } from "react";
import { useParams, Link } from "react-router-dom";

// Hooks
import { useGetData, usePutData, useDeleteData } from "@hooks/useFetchData.js";
import { useValidateform } from "@hooks/useValidateForm.js";
import { useConvertImage } from "@hooks/useConvertImage.js";

// Components
import ContentLoading from "@components/contentLoading.jsx";
import { RegisterIcon, StarIcon, UserIcon, TrashIcon } from "@components/icons.jsx";
import Swal from "sweetalert2";

export default function ProductProfile() {
    const { id } = useParams();
    const {
        data: product,
        loading: loadingProduct,
        reload: reloadProduct,
    } = useGetData(`/products/${id}`);

    const handleUpdateProductSubmit = async (event) => {
        event.preventDefault();

        const data = Object.fromEntries(new FormData(event.target));
        const validation = useValidateform(data, "update-product-form");

        if (validation.success) {
            const files = Array.from(event.target.elements.multimedias.files);
            const base64Files = await Promise.all(files.map((file) => useConvertImage(file)));

            const response = await usePutData(`/products/${product.producto_id}`, {
                product: {
                    producto_nombre: data.producto_nombre,
                    producto_precio: data.producto_precio,
                    producto_descripcion: data.producto_descripcion,
                    producto_cantidad: data.producto_cantidad,
                    producto_estado: data.producto_estado,
                    categoria_id: data.categoria_id,
                },
                producto_imagen:
                    data.producto_imagen.size > 0
                        ? await useConvertImage(data.producto_imagen)
                        : null,
                multimedias: base64Files,
            });
            if (response.success) reloadProduct();
        }
    };

    const handleDeleteMultimedia = async (event) => {
        event.preventDefault();

        const { multimedia_id } = Object.fromEntries(new FormData(event.target));
        Swal.fire({
            icon: "warning",
            title: "¿Estas seguro?",
            text: "Dale a continuar si quieres eliminar la multimedia",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            cancelButtonText: "Cancelar",
            confirmButtonText: "Continuar",
        }).then(async (result) => {
            if (result.isConfirmed) {
                const response = await useDeleteData(`/multimedias/${multimedia_id}`);
                if (response.success) reloadProduct();
            }
        });
    };

    if (loadingProduct) return <ContentLoading />;
    return (
        <section className="w-full">
            <div className="w-full max-w-[1200px] mx-auto py-10">
                <article className="flex flex-col md:flex-row gap-5">
                    {/* Parte de vista previa */}
                    <div className="w-full max-w-[450px]">
                        <div className="card bg-white shadow-xl border h-fit w-full">
                            <div className="card-body h-fit">
                                <h2 className="text-3xl font-extrabold tracking-tight">
                                    Vista previa
                                </h2>
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
                                    <h2 className="text-2xl font-bold">
                                        {product.producto_nombre}
                                    </h2>
                                    <p className="grow-0 flex gap-1 items-center">
                                        <StarIcon />
                                        {product.calificacion_promedio}
                                    </p>
                                </div>
                                <p>{product.producto_descripcion}</p>
                                <p className="text-lg font-bold">
                                    {parseFloat(product.producto_precio).toLocaleString("es-CO")}{" "}
                                    COP
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

                        <div className="card bg-white shadow-xl border mt-5">
                            <div className="card-body w-full max-w-[450px] h-fit">
                                <h2 className="text-3xl font-extrabold tracking-tight">
                                    Multimedias:
                                </h2>
                                <div className="flex flex-col gap-2">
                                    {product.media.map((multimedia) => (
                                        <figure
                                            key={multimedia.multimedia_id}
                                            className="w-full aspect-[16/9] rounded-lg aspect-square mx-auto relative group hover:cursor-pointer bg-gray-500 overflow-hidden"
                                        >
                                            <img
                                                src={multimedia.multimedia_url}
                                                alt={`Imagen del producto ${product.producto_titulo}`}
                                                className="object-contain h-full w-full group-hover:blur-[1px] group-hover:bg-black group-hover:scale-105 duration-300"
                                            />
                                            <div className="absolute bottom-2 right-2">
                                                <form onSubmit={handleDeleteMultimedia}>
                                                    <input
                                                        type="hidden"
                                                        name="multimedia_id"
                                                        value={multimedia.multimedia_id}
                                                    />
                                                    <button
                                                        type="submit"
                                                        className="btn btn-error btn-sm bg-right text-white tooltip tooltip-left"
                                                        data-tip="Eliminar multimedia"
                                                    >
                                                        <TrashIcon />
                                                    </button>
                                                </form>
                                            </div>
                                        </figure>
                                    ))}
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* Parte de edición */}
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
                                                Cantidad:
                                            </span>
                                        </label>
                                        <input
                                            className="input input-sm input-bordered w-full focus:input-primary focus:outline-0 rounded"
                                            defaultValue={product.producto_cantidad}
                                            name="producto_cantidad"
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
                                            name="producto_imagen"
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
                                            multiple
                                            max="5"
                                            accept=".jpg, .jpeg, .png"
                                            name="multimedias"
                                            className="file-input file-input-bordered file-input-sm w-full focus:input-primary focus:outline-0 rounded"
                                        />
                                    </div>
                                    <div className="form-control">
                                        <label className="label">
                                            <span className="label-text font-semibold">
                                                Estado:
                                            </span>
                                        </label>
                                        <select
                                            name="producto_estado"
                                            className="select select-bordered select-sm w-full focus:select-primary focus:outline-0"
                                        >
                                            <option value="publico">Publico</option>
                                            <option value="privado">Privado</option>
                                        </select>
                                    </div>
                                    <div className="form-control">
                                        <label className="label">
                                            <span className="label-text font-semibold">
                                                Categoria:
                                            </span>
                                        </label>
                                        <select
                                            name="categoria_id"
                                            className="select select-bordered select-sm w-full focus:select-primary focus:outline-0"
                                        >
                                            <option value="1">Moda</option>
                                            <option value="2">Comida</option>
                                            <option value="3">Tecnologia</option>
                                            <option value="4">Otros</option>
                                        </select>
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
