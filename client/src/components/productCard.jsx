import { Link } from "react-router-dom";
// Components
import RateModal from "./rateModal";

// Icons
import { UserIcon, StarIcon, PlusIcon, CartAddIcon } from "./icons";

// Contexts
import { useAuthContext } from "@contexts/authContext";
import { usePostData } from "../hooks/useFetchData";

export default function Product({ product, reloadProducts }) {
    const { userSession, authMiddlewareAlert } = useAuthContext();

    const handleCartAdd = async () => {
        const response = await usePostData("/carts", {
            product_id: product.product_id,
        })
    }

    return (
        <>
            <article className={`flex flex-col md:flex-row gap-5 p-5 rounded-xl shadow-lg border border-black/10 ${product.product_quantity == 0 ? "bg-zinc-200" : "bg-white"}`}>
                <Link
                    to={`/product/${product.product_id}`}
                    className="w-full min-w-[140px] max-w-[240px] aspect-square rounded-lg overflow-hidden bg-white mx-auto relative"
                >
                    <img
                        src={product.product_image_url}
                        alt={`Imagen del producto ${product.product_name}`}
                        className="object-contain h-full w-full"
                    />
                    {product.product_quantity == 0 && (
                        <div className="absolute inset-0 bg-black/50 flex items-center justify-center">
                            <p className="text-white font-bold text-3xl uppercase">Agotado</p>
                        </div>
                    )}
                </Link>
                <div className="grow flex flex-col justify-center gap-1 h-[initial]">
                    <div>
                        <div className="flex justify-between items-center w-full ">
                            <h2 className="text-2xl md:text-3xl font-bold leading-none">
                                {product.product_name}
                            </h2>
                            <p className="text-gray-600/90 font-medium">
                                {new Intl.DateTimeFormat("es-CO").format(
                                    new Date(product.product_date)
                                )}
                            </p>
                        </div>
                        {product.user && (
                            <Link
                                to={`/worker/${product.user.user_id}`}
                                className="text-gray-500/80 font-semibold italic text-sm hover:underline tooltip tooltip-bottom"
                                data-tip="Ir al perfil del vendedor"
                            >
                                @publicado por {product.user.user_alias}
                            </Link>
                        )}
                    </div>

                    <p className="grow text-pretty line-clamp-3">{product.product_description}</p>

                    <div className="space-y-2">
                        <div className="w-full flex items-center justify-between">
                            <p className="text-xl lg:text-2xl font-bold">
                                {parseInt(product.product_price).toLocaleString("es-CO")} COP
                            </p>
                            <div className="flex items-center gap-2">
                                <div className="[&>*]:leading-none flex flex-col justify-center items-end gap-0.5">
                                    <p className="flex items-center text-lg">
                                        <StarIcon size={16} color="#7e22ce" className="mr-0.5" />{" "}
                                        {product.average_rating}
                                    </p>
                                    <p className="flex items-center text-[12px] text-gray-600">
                                        ({product.ratings_count}{" "}
                                        <UserIcon size={12} className="ml-1" />)
                                    </p>
                                </div>
                                <button
                                    onClick={() => {
                                        if (userSession) {
                                            document
                                                .getElementById(
                                                    `product-modal-${product.product_id}`
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
                        <button
                            className="btn btn-sm min-h-none h-auto py-3 btn-primary group relative text-purple-300 hover:bg-purple-800 hover:text-purple-100 w-full text-sm leading-none"
                            disabled={product.product_quantity == 0}
                            onClick={() => {
                                if (userSession) {
                                    handleCartAdd();
                                } else {
                                    authMiddlewareAlert();
                                }
                            }}
                            data-id={product.product_id}
                        >
                            <span className="absolute left-3 top-1/2 transform -translate-y-1/2 text-purple-300 group-hover:text-purple-100 group-disabled:text-zinc-400">
                                <CartAddIcon size={17} />
                            </span>
                            Añadir al carrito
                        </button>
                    </div>
                </div>
            </article>

            {/* Modal producto */}
            <RateModal id={product.product_id} reload={reloadProducts} type="product" />
        </>
    );
}
