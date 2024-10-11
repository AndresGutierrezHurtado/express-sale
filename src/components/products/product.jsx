import { Link } from "react-router-dom";

// Icons
import { UserIcon, StarIcon, PlusIcon, CartAddIcon } from "../icons";

export default function Product({ product }) {
    return (
        <article className="flex flex-col md:flex-row gap-5 bg-white p-5 rounded-xl shadow-lg border border-black/10">
            <figure className="w-full max-w-[240px] aspect-square rounded-lg overflow-hidden bg-white">
                <img
                    src={product.producto_imagen_url}
                    alt={`Imagen del producto ${product.producto_nombre}`}
                    className="object-contain h-full w-full"
                />
            </figure>
            <div className="grow flex flex-col justify-center gap-1 h-[initial]">
                <div>
                    <h2 className="text-2xl font-bold">
                        {product.producto_nombre}
                    </h2>
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
                        <p className="text-2xl font-bold">
                            {parseInt(product.producto_precio).toLocaleString(
                                "es-CO"
                            )}{" "}
                            COP
                        </p>
                        <div className="flex items-center gap-2">
                            <div className="gap-0 [&>*]:leading-none flex flex-col justify-center items-end gap-[2px]">
                                <p className="flex items-center text-lg">
                                    <StarIcon size={16} className="mr-0.5" />{" "}
                                    5.0
                                </p>
                                <p className="flex items-center text-[12px] text-gray-600">
                                    ({product.ratings.length}{" "}
                                    <UserIcon size={12} className="ml-1" />)
                                </p>
                            </div>
                            <button
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
    );
}
