import { useEffect, useState } from "react";
import { Link } from "react-router-dom";

// Components
import Loading from "../components/loading";

// Hooks
import { useGetData } from "../hooks/useFetchData";

// Icons
import { CartAddIcon, PlusIcon, StarIcon, UserIcon } from "../components/icons";

export default function Products() {
    const [products, setProducts] = useState(null);
    const [loading, setLoading] = useState(true);

    const getProducts = async () => {
        const response = await useGetData("/api/products");
        if (response) {
            setLoading(false);
            setProducts(response.data);
        }
    };

    useEffect(() => {
        getProducts();
    }, []);

    if (loading) return <Loading />;

    return (
        <>
            <section className="w-full">
                <div className="w-full max-w-[1200px] mx-auto pt-10">
                    <div className="w-full flex items-center justify-between">
                        <div>
                            <h1 className="text-4xl font-extrabold">
                                Todos los productos
                            </h1>
                            <p className="text-lg text-gray-600/90 font-medium">
                                {products.length} resultados
                            </p>
                        </div>
                        <div>
                            Ordenar por:
                            <span>
                                <select
                                    name=""
                                    className="select select-sm  select-ghost focus:outline-0 focus:border-0"
                                >
                                    <option value="">Destacados</option>
                                    <option value="">Menor precio</option>
                                    <option value="">Mayor precio</option>
                                    <option value="">Nuevos</option>
                                </select>
                            </span>
                        </div>
                    </div>
                </div>
            </section>
            <section className="w-full">
                <div className="w-full max-w-[1200px] mx-auto py-10">
                    <div className="flex gap-10">
                        <div className="card bg-base-100 shadow-xl w-full max-w-[350px] h-fit">
                            <div className="card-body">
                                <h2>Filtros:</h2>
                            </div>
                        </div>
                        <div className="space-y-10 w-full">
                            <ProductsContent products={products} />
                        </div>
                    </div>
                </div>
            </section>
        </>
    );
}

function ProductsContent({ products }) {
    const ProductsList = products.map((product) => {
        return (
            <article
                key={product.producto_id}
                className="flex flex-col md:flex-row gap-5"
            >
                <figure className="w-full max-w-[240px] aspect-square rounded-lg overflow-hidden bg-white">
                    <img
                        src={product.producto_imagen_url}
                        alt={`Imagen del producto ${product.producto_nombre}`}
                        className="object-contain h-full w-full"
                    />
                </figure>
                <div className="grow flex flex-col justify-center gap-1 h-[initial]">
                    <div>
                        <h2 className="text-3xl font-bold">
                            {product.producto_nombre}
                        </h2>
                        <p className="text-gray-500/80 font-semibold italic text-sm hover:underline">
                            publicado por{" "}
                            <Link to={`/worker/${product.user.usuario_id}`}>
                                @{product.user.usuario_alias}
                            </Link>
                        </p>
                    </div>

                    <p className="grow text-pretty">{product.producto_descripcion}</p>

                    <div className="space-y-2">
                        <div className="w-full flex items-center justify-between">
                            <p className="text-2xl font-bold">
                                {parseInt(
                                    product.producto_precio
                                ).toLocaleString("es-CO")}{" "}
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
                                <button className="btn btn-sm min-h-none h-auto py-3 btn-primary group relative text-purple-300 hover:bg-purple-800 hover:text-purple-100 min-w-none w-fit">
                                    <PlusIcon />
                                </button>
                            </div>
                        </div>
                        <button className="btn btn-sm min-h-none h-auto py-3 btn-primary group relative text-purple-300 hover:bg-purple-800 hover:text-purple-100 w-full">
                            <span className="absolute left-3 top-1/2 transform -translate-y-1/2 text-purple-300 group-hover:text-purple-100">
                                <CartAddIcon size={17} />
                            </span>
                            Iniciar sesión
                        </button>
                    </div>
                </div>
            </article>
        );
    });

    return <>{ProductsList}</>;
}
