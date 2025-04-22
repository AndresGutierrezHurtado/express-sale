import { Link } from "react-router-dom";

// Components
import RateModal from "./rateModal";

// Icons
import { StarIcon, PlusIcon, CartAddIcon, } from "./icons";

// Hooks
import { usePostData } from "../hooks/useFetchData";

// Contexts
import { useAuthContext } from "@contexts/authContext";

import React from "react";

export function VerticalProductCard({ product, reloadProduct }) {
    const { userSession, authMiddlewareAlert } = useAuthContext();

    const handleCartAdd = async () => {
        const response = await usePostData("/carts", {
            product_id: product.product_id,
        });
    };

    return (
        <>
            <article className="bg-white/80 border border-base-300 rounded-lg shadow-lg p-5 space-y-5">
                <Link
                    to={"/product/" + product.product_id}
                    className="block w-full max-h-[200px] aspect-square rounded-lg overflow-hidden"
                >
                    <img
                        src={product.product_image_url}
                        alt={`Imagen del producto ${product.product_name}`}
                        className="object-contain h-full w-full"
                    />
                </Link>
                <div className="space-y-2">
                    <div>
                        <div className="w-full">
                            <h3 className="w-full text-2xl font-bold tracking-tight truncate">
                                {product.product_name}
                            </h3>
                        </div>
                        <Link
                            to={`/worker/${product.user.user_id}`}
                            className="text-base-content/50 font-semibold italic text-sm hover:underline tooltip tooltip-bottom"
                            data-tip="Ir al perfil del vendedor"
                        >
                            publicado por @{product.user.user_alias}
                        </Link>
                    </div>
                    <p className="text-pretty line-clamp-2 text-base-content/70 leading-tight">
                        {product.product_description}
                    </p>
                    <div className="mt-4 flex items-center justify-between w-full gap-2">
                        <p className="text-xl font-bold text-base-content/70 truncate">
                            COP {parseInt(product.product_price).toLocaleString("es-CO")}
                        </p>
                        <div className="flex flex-row items-center justify-between h-fit">
                            <p className="text-sm text-base-content/80 truncate">
                                {product.product_quantity} unidades
                            </p>
                            <div className="divider divider-horizontal mx-1"></div>
                            <div className="flex items-center justify-end gap-1">
                                <StarIcon color="#7e22ce" />
                                <span>{product.average_rating}</span>
                                <button className="btn btn-xs btn-primary ml-2">
                                    <PlusIcon />
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="w-full space-y-2">
                    <button className="btn w-full btn-primary relative">
                        <span className="absolute left-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                            <CartAddIcon />
                        </span>
                        Añadir al carrito
                    </button>
                </div>
            </article>

            <RateModal id={product.product_id} reload={reloadProduct} type="product" />
        </>
    );
}

// export function VerticalProductCard({ product, reloadProducts }) {
//     const { userSession, authMiddlewareAlert } = useAuthContext();

//     const handleCartAdd = async () => {
//         const response = await usePostData("/carts", {
//             product_id: product.product_id,
//         });
//     };

//     return (
//         <>
//             <div
//                 className={`card bg-white shadow-xl border w-full sm:min-w-[350px] max-w-[350px] tilt ${
//                     product.product_quantity == 0 ? "bg-zinc-200" : "bg-white"
//                 }`}
//             >
//                 <div className="card-body">
//                     <Link
//                         to={`/product/${product.product_id}`}
//                         className="relative rounded-lg overflow-hidden"
//                     >
//                         <figure className="w-full h-[200px] rounded-lg overflow-hidden">
//                             <img
//                                 src={product.product_image_url}
//                                 alt={`Imagen del producto ${product.product_image_url}`}
//                                 className="object-contain h-full w-full"
//                             />
//                         </figure>
//                         {product.product_quantity == 0 && (
//                             <div className="absolute inset-0 bg-black/50 flex items-center justify-center">
//                                 <p className="text-white font-bold text-3xl uppercase text-center">
//                                     Agotado
//                                 </p>
//                             </div>
//                         )}
//                     </Link>
//                     <div className="text-left leading-none">
//                         <div className="flex items-center justify-between w-full">
//                             <h3 className="text-2xl font-bold tracking-tight truncate grow w-full">
//                                 {product.product_name}
//                             </h3>
//                             <div className="flex flex-col items-end">
//                                 <p className="flex text-lg items-center leading-none">
//                                     <StarIcon />
//                                     {Number.parseFloat(
//                                         product.average_rating
//                                     ).toFixed(1)}
//                                 </p>
//                                 <span className="flex items-center text-gray-600 text-sm">
//                                     ({parseInt(product.ratings_count)}
//                                     <UserIcon size={11} />)
//                                 </span>
//                             </div>
//                         </div>
//                         <Link
//                             to={`/worker/${product.user.user_id}`}
//                             className="text-gray-500/80 font-semibold italic text-sm hover:underline tooltip tooltip-bottom"
//                             data-tip="Ir al perfil del vendedor"
//                         >
//                             @publicado por {product.user.user_alias}
//                         </Link>
//                     </div>
//                     <p className="line-clamp-3">
//                         {product.product_description}
//                     </p>
//                     <div className="w-full flex items-center justify-between">
//                         <p className="text-sm font-medium text-gray-700">
//                             {product.product_quantity} disponibles
//                         </p>
//                         <button
//                             onClick={() => {
//                                 if (userSession) {
//                                     document
//                                         .getElementById(
//                                             `product-modal-${product.product_id}`
//                                         )
//                                         .show();
//                                 } else {
//                                     authMiddlewareAlert();
//                                 }
//                             }}
//                             data-tip="Agregar una calificación"
//                             className="tooltip tooltip-left btn btn-sm min-h-none h-auto py-3 btn-primary group relative text-purple-300 hover:bg-purple-800 hover:text-purple-100 min-w-none w-fit"
//                         >
//                             <PlusIcon />
//                         </button>
//                     </div>
//                     <button
//                         onClick={() => {
//                             if (userSession) {
//                                 handleCartAdd();
//                             } else {
//                                 authMiddlewareAlert();
//                             }
//                         }}
//                         disabled={product.product_quantity == 0}
//                         className="btn btn-sm min-h-none h-auto py-3 btn-primary group relative text-purple-300 hover:bg-purple-800 hover:text-purple-100 w-full"
//                     >
//                         <span className="absolute left-3 top-1/2 transform -translate-y-1/2 text-purple-300 group-hover:text-purple-100 group-disabled:text-zinc-400 cursor-notallowed">
//                             <CartAddIcon size={17} />
//                         </span>
//                         Añadir al carrito
//                     </button>
//                 </div>
//             </div>

//             {/* Modal producto */}
//         </>
//     );
// }
