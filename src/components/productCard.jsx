import { Link } from "react-router-dom";
// Components
import RateModal from "./rateModal";

// Icons
import { UserIcon, StarIcon, PlusIcon, CartAddIcon } from "./icons";

// Contexts
import { useAuthContext } from "@contexts/authContext";

export default function Product({ product }) {
    const { userSession, authMiddlewareAlert } = useAuthContext();

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
                        {product.user && (
                            <Link
                                to={`/worker/${product.user.usuario_id}`}
                                className="text-gray-500/80 font-semibold italic text-sm hover:underline tooltip tooltip-bottom"
                                data-tip="Ir al perfil del vendedor"
                            >
                                @publicado por {product.user.usuario_alias}
                            </Link>
                        )}
                    </div>

                    <p className="grow text-pretty line-clamp-3">
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
            <RateModal id={product.producto_id} type="product" />
        </>
    );
}
