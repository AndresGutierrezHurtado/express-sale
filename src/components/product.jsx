import { Link } from "react-router-dom";

// Icons
import { UserIcon, StarIcon, PlusIcon, CartAddIcon } from "./icons";

// Contexts
import { useAuthContext } from "../context/authContext";

// Hooks
import { useValidateform } from "../hooks/useValidateForm";
import { usePostData } from "../hooks/useFetchData";

export default function Product({ product }) {
    const { userSession, authMiddlewareAlert } = useAuthContext();

    const handleRatingSubmit = (event) => {
        event.preventDefault();

        const data = Object.fromEntries(new FormData(event.target));
        const validation = useValidateform(data, "rate-product-form");

        if (validation.success) {
            const response = usePostData(`/api/ratings/products/${product.producto_id}`, data);

            if (response.success) {
                event.target.reset();
            }
        }
    };

    return (
        <>
            <article className="flex flex-col md:flex-row gap-5 bg-white p-5 rounded-xl shadow-lg border border-black/10">
                <Link
                    to={`/product/${product.producto_id}`}
                    className="w-full min-w-[140px] max-w-[240px] aspect-square rounded-lg overflow-hidden bg-white mx-auto"
                >
                    <img
                        src={product.producto_imagen_url}
                        alt={`Imagen del producto ${product.producto_nombre}`}
                        className="object-contain h-full w-full"
                    />
                </Link>
                <div className="grow flex flex-col justify-center gap-1 h-[initial]">
                    <div>
                        <div className="flex justify-between items-center w-full ">
                            <h2 className="text-2xl md:text-3xl font-bold leading-none">
                                {product.producto_nombre}
                            </h2>
                            <p className="text-gray-600/90 font-medium">
                                {new Intl.DateTimeFormat("es-CO").format(
                                    new Date(product.producto_fecha)
                                )}
                            </p>
                        </div>
                        <p
                            data-tip="Ir al perfil del vendedor"
                            className="text-gray-500/80 font-semibold italic text-sm hover:underline tooltip tooltip-bottom"
                        >
                            Publicado por{" "}
                            <Link to={`/worker/${product.user.usuario_id}`}>
                                @{product.user.usuario_alias}
                            </Link>
                        </p>
                    </div>

                    <p className="grow text-pretty">
                        {product.producto_descripcion}
                    </p>

                    <div className="space-y-2">
                        <div className="w-full flex items-center justify-between">
                            <p className="text-xl lg:text-2xl font-bold">
                                {parseInt(
                                    product.producto_precio
                                ).toLocaleString("es-CO")}{" "}
                                COP
                            </p>
                            <div className="flex items-center gap-2">
                                <div className="gap-0 [&>*]:leading-none flex flex-col justify-center items-end gap-[2px]">
                                    <p className="flex items-center text-lg">
                                        <StarIcon
                                            size={16}
                                            className="mr-0.5"
                                        />{" "}
                                        {product.calificacion_promedio}
                                    </p>
                                    <p className="flex items-center text-[12px] text-gray-600">
                                        ({product.ratings.length}{" "}
                                        <UserIcon size={12} className="ml-1" />)
                                    </p>
                                </div>
                                <button
                                    onClick={() => {
                                        if (userSession) {
                                            document
                                                .getElementById(
                                                    `product-modal-${product.producto_id}`
                                                )
                                                .show();
                                        } else {
                                            authMiddlewareAlert();
                                        }
                                    }}
                                    data-tip="Agregar una calificación"
                                    className="tooltip tooltip-left btn btn-sm min-h-none h-auto py-3 btn-primary group relative text-purple-300 hover:bg-purple-800 hover:text-purple-100 min-w-none w-fit"
                                >
                                    <PlusIcon />
                                </button>
                            </div>
                        </div>
                        <button className="btn btn-sm min-h-none h-auto py-3 btn-primary group relative text-purple-300 hover:bg-purple-800 hover:text-purple-100 w-full">
                            <span className="absolute left-3 top-1/2 transform -translate-y-1/2 text-purple-300 group-hover:text-purple-100">
                                <CartAddIcon size={17} />
                            </span>
                            Añadir al carrito
                        </button>
                    </div>
                </div>
            </article>

            {/* Modal producto */}
            <dialog
                id={`product-modal-${product.producto_id}`}
                className="modal"
                style={{ marginTop: "0px" }}
            >
                <div className="modal-box rounded-lg">
                    <div className="modal-action m-0">
                        <form method="dialog">
                            <button className="btn btn-sm btn-circle btn-ghost absolute right-3 top-3">
                                ✕
                            </button>
                        </form>
                    </div>
                    <h3 className="text-xl font-bold">Calificar producto:</h3>
                    <p>
                        Ten en cuenta la calidad del producto y tiempo de envío.
                    </p>

                    <form
                        encType="multipart/form-data"
                        className="fetch-form space-y-2"
                        onSubmit={handleRatingSubmit}
                    >
                        <input
                            type="hidden"
                            name="producto_id"
                            defaultValue={product.producto_id}
                        />

                        <label className="form-control w-full">
                            <div className="label">
                                <span className="label-text font-medium text-gray-700">
                                    Mensaje:
                                </span>
                            </div>
                            <textarea
                                placeholder="Ingresa un comentario sobre el producto."
                                id="calificacion_comentario"
                                name="calificacion_comentario"
                                className="textarea textarea-bordered h-24 resize-none focus:outline-0 focus:border-violet-600 rounded"
                            ></textarea>
                        </label>

                        <label className="form-control w-full">
                            <div className="label">
                                <span className="label-text font-medium text-gray-700">
                                    Imagen:
                                </span>
                            </div>
                            <input
                                type="file"
                                name="calificacion_imagen"
                                id="calificacion_imagen"
                                className="w-full text-sm text-slate-500 hover:file:bg-violet-100 file:duration-300 file:cursor-pointer file:bg-violet-50 file:text-violet-700 file:font-semibold file:rounded-xl file:border-0 file:p-1 file:px-3"
                            />
                        </label>

                        <div className="rating flex justify-center gap-2 py-3">
                            <input
                                type="radio"
                                name="calificacion"
                                value="1"
                                className="mask mask-star-2 bg-violet-600"
                                defaultChecked
                            />
                            <input
                                type="radio"
                                name="calificacion"
                                value="2"
                                className="mask mask-star-2 bg-violet-600"
                            />
                            <input
                                type="radio"
                                name="calificacion"
                                value="3"
                                className="mask mask-star-2 bg-violet-600"
                            />
                            <input
                                type="radio"
                                name="calificacion"
                                value="4"
                                className="mask mask-star-2 bg-violet-600"
                            />
                            <input
                                type="radio"
                                name="calificacion"
                                value="5"
                                className="mask mask-star-2 bg-violet-600"
                            />
                        </div>
                        <button
                            type="submit"
                            className="w-full bg-violet-600 font-bold duration-300 hover:bg-violet-800 text-white py-2 px-4 rounded-lg"
                        >
                            Calificar
                        </button>
                    </form>
                </div>
                <form method="dialog" className="modal-backdrop bg-black/50">
                    <button className="cursor-auto">close</button>
                </form>
            </dialog>
        </>
    );
}
