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

            const response = await usePutData(`/products/${product.product_id}`, {
                product: {
                    product_name: data.product_name,
                    product_price: data.product_price,
                    product_description: data.product_description,
                    product_quantity: data.product_quantity,
                    product_status: data.product_status,
                    category_id: data.category_id,
                },
                product_image:
                    data.product_image.size > 0
                        ? await useConvertImage(data.product_image)
                        : null,
                product_medias: base64Files,
            }).then(() => reloadProduct());

            if (response.success) reloadProduct();
        }
    };

    const handleDeleteMultimedia = async (event) => {
        event.preventDefault();

        const { media_id } = Object.fromEntries(new FormData(event.target));
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
                const response = await useDeleteData(`/medias/${media_id}`);
                if (response.success) reloadProduct();
            }
        });
    };

    if (loadingProduct) return <ContentLoading />;
    return (
        <section className="w-full px-3">
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
                                            src={product.product_image_url}
                                            alt={`Imagen del producto ${product.product_name}`}
                                            className="object-contain h-full w-full"
                                        />
                                    </figure>
                                </div>
                                <div className="flex w-full items-center justify-between">
                                    <h2 className="text-2xl font-bold">
                                        {product.product_name}
                                    </h2>
                                    <p className="grow-0 flex gap-1 items-center">
                                        <StarIcon />
                                        {product.average_rating}
                                    </p>
                                </div>
                                <p>{product.product_description}</p>
                                <p className="text-lg font-bold">
                                    {parseFloat(product.product_price).toLocaleString("es-CO")}{" "}
                                    COP
                                </p>
                                <Link
                                    to={`/product/${product.product_id}`}
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
                                    {product.medias.length === 0 && (
                                        <p className="text-gray-600">
                                            No se encontraron multimedias...
                                        </p>
                                    )}
                                    {product.medias.map((multimedia) => (
                                        <figure
                                            key={multimedia.media_id}
                                            className="w-full aspect-[16/9] rounded-lg aspect-square mx-auto relative group hover:cursor-pointer bg-gray-500 overflow-hidden"
                                        >
                                            <img
                                                src={multimedia.media_url}
                                                alt={`Imagen del producto ${product.product_name}`}
                                                className="object-contain h-full w-full group-hover:blur-[1px] group-hover:bg-black group-hover:scale-105 duration-300"
                                            />
                                            <div className="absolute bottom-2 right-2">
                                                <form onSubmit={handleDeleteMultimedia}>
                                                    <input
                                                        type="hidden"
                                                        name="media_id"
                                                        value={multimedia.media_id}
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
                                            defaultValue={product.product_name}
                                            name="product_name"
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
                                            defaultValue={product.product_price}
                                            name="product_price"
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
                                            defaultValue={product.product_quantity}
                                            name="product_quantity"
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
                                            defaultValue={product.product_description}
                                            name="product_description"
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
                                            name="product_image"
                                        />
                                    </div>
                                    <div className="form-control">
                                        <label className="label">
                                            <span className="label-text font-semibold">
                                                Multimedia: <span className="text-gray-500">(máximo {5 - product.medias.length})</span>
                                            </span>
                                        </label>
                                        <input
                                            type="file"
                                            multiple
                                            max={5 - product.medias.length}
                                            onChange={(event) => {
                                                if (event.target.files.length > (5 - product.medias.length)) {
                                                    Swal.fire({
                                                        icon: "error",
                                                        title: "Oops...",
                                                        text: `Solo se pueden subir ${5 - product.medias.length} multimedias`,
                                                    })
                                                    event.target.value = null;
                                                    return;
                                                }
                                            }}
                                            accept="image/*"
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
                                            name="product_status"
                                            className="select select-bordered select-sm w-full focus:select-primary focus:outline-0"
                                            defaultValue={product.product_status}
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
                                            name="category_id"
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
