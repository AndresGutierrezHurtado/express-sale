import { useEffect, useState } from "react";
import { useGetData } from "../hooks/useFetchData";
import Loading from "../components/loading";

export default function Products() {
    const [products, setProducts] = useState(null);
    const [loading, setLoading] = useState(true);

    const getProducts = async () => {
        const response = await useGetData("/api/products");
        if (response) {
            setLoading(false)
            setProducts(response.data);
        }
    }

    useEffect(() => {
        getProducts();
    }, []);

    if (loading) return <Loading />;

    return (
        <>
            <section className="w-full">
                <div className="w-full max-w-[1200px] mx-auto py-10">
                    <div className="w-full flex items-center justify-between">
                        <div>
                            <h1 className="text-3xl font-extrabold">Todos los productos</h1>
                            <p className="text-lg text-gray-600/90 font-medium">{products.length} resultados</p>
                        </div>
                        <div>
                            Ordenar por:
                            <span>
                                <select name="" className="select select-sm  select-ghost focus:outline-0 focus:border-0">
                                    <option value="">Destacados</option>
                                </select>
                            </span>
                        </div>
                    </div>
                </div>
            </section>
            <section className="w-full">
                <div className="w-full max-w-[1200px] mx-auto">
                    <div className="flex">
                        <div class="card bg-base-100 shadow-xl w-full max-w-[600px]">
                            <div class="card-body">
                                <h2>Filtros:</h2>
                            </div>
                        </div>
                        <div className="space-y-5 w-full">
                            <ProductsContent products={products} />
                        </div>
                    </div>
                </div >
            </section>
        </>
    );
}

function ProductsContent({ products }) {
    console.log()
    const ProductsList = products.map(product => {
        return (
            <article>

                <div className="flex-1">
                    <h2>{product.producto_nombre}</h2>
                    <p>{product.user.usuario_alias}</p>
                    <p>{product.producto_descripcion}</p>
                    <p>{product.producto_precio}</p>
                    <button className="btn btn-sm min-h-none h-auto py-2 btn-primary group relative text-purple-300 hover:bg-purple-800 hover:text-purple-100 w-full">
                        <span className="absolute left-3 top-1/2 transform -translate-y-1/2 text-purple-300 group-hover:text-purple-100">
                            +
                        </span>
                        Iniciar sesión
                    </button>
                </div>
            </article>
        )
    });

    return (
        <>
            {ProductsList}
        </>
    );
}