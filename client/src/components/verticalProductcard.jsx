import { Link } from "react-router-dom";

// Components
import RateModal from "./rateModal";

// Icons
import { StarIcon, PlusIcon, CartAddIcon, UserIcon } from "./icons";

// Hooks
import { usePostData } from "../hooks/useFetchData";

// Contexts
import { useAuthContext } from "@contexts/authContext";

export function VerticalProductCard({ product, reloadProducts }) {
    const { userSession, authMiddlewareAlert } = useAuthContext();

    const handleCartAdd = async () => {
        const response = await usePostData("/carts", {
            product_id: product.product_id,
        });
    };

    return (
        <>
            <div className="card bg-white shadow-xl border w-full sm:min-w-[350px] max-w-[350px] tilt">
                <div className="card-body">
                    <Link to={`/product/${product.product_id}`}>
                        <figure className="w-full h-[200px] rounded-lg overflow-hidden">
                            <img
                                src={product.product_image_url}
                                alt={`Imagen del producto ${product.product_image_url}`}
                                className="object-contain h-full w-full"
                            />
                        </figure>
                    </Link>
                    <div className="text-left leading-none">
                        <div className="flex items-center justify-between w-full">
                            <h3 className="text-2xl font-bold tracking-tight truncate grow w-full">
                                {product.product_name}
                            </h3>
                            <div className="flex flex-col items-end">
                                <p className="flex text-lg items-center leading-none">
                                    <StarIcon />
                                    {Number.parseFloat(product.average_rating).toFixed(1)}
                                </p>
                                <span className="flex items-center text-gray-600 text-sm">
                                    ({parseInt(product.ratings_count)}
                                    <UserIcon size={11} />)
                                </span>
                            </div>
                        </div>
                        <Link
                            to={`/worker/${product.user.user_id}`}
                            className="text-gray-500/80 font-semibold italic text-sm hover:underline tooltip tooltip-bottom"
                            data-tip="Ir al perfil del vendedor"
                        >
                            @publicado por {product.user.usuario_alias}
                        </Link>
                    </div>
                    <p className="line-clamp-3">{product.product_description}</p>
                    <div className="w-full flex items-center justify-between">
                        <p className="text-sm font-medium text-gray-700">
                            {product.product_quantity} disponibles
                        </p>
                        <button
                            onClick={() => {
                                if (userSession) {
                                    document
                                        .getElementById(`product-modal-${product.product_id}`)
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
                    <button
                        onClick={() => {
                            if (userSession) {
                                handleCartAdd();
                            } else {
                                authMiddlewareAlert();
                            }
                        }}
                        className="btn btn-sm min-h-none h-auto py-3 btn-primary group relative text-purple-300 hover:bg-purple-800 hover:text-purple-100 w-full"
                    >
                        <span className="absolute left-3 top-1/2 transform -translate-y-1/2 text-purple-300 group-hover:text-purple-100">
                            <CartAddIcon size={17} />
                        </span>
                        Añadir al carrito
                    </button>
                </div>
            </div>

            {/* Modal producto */}
            <RateModal id={product.product_id} reload={reloadProducts} type="product" />
        </>
    );
}
