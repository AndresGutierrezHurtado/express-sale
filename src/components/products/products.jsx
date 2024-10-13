import { useEffect, useState } from "react";
import { useLocation, useSearchParams } from "react-router-dom";

// Components
import Product from "../product";
import ProductsFilters from "./filters";
import Pagination from "../pagination";

// Hooks
import { useGetData } from "../../hooks/useFetchData";

export default function ProductsContent() {
    const [products, setProducts] = useState(null);
    const [loading, setLoading] = useState(true);
    const [searchParams, setSearchParams] = useSearchParams();
    const location = useLocation();

    const getProducts = async () => {
        const getParams = searchParams.toString();
        const response = await useGetData(`/api/products?${getParams}`);
        if (response) {
            setLoading(false);
            setProducts(response.data);
        }
    };

    useEffect(() => {
        getProducts();
    }, [location]);

    const ProductsList =
        products &&
        products.rows.map((product) => {
            return <Product product={product} key={product.producto_id} />;
        });

    const updateParam = (key, value) => {
        const newSearchParams = new URLSearchParams(searchParams);
        newSearchParams.set(key, value);
        setSearchParams(newSearchParams);
    };

    if (loading) return <div>Cargando...</div>;

    return (
        <>
            <section className="w-full px-3">
                <div className="w-full max-w-[1200px] mx-auto pt-10">
                    <div className="w-full flex flex-col md:flex-row gap-2 items-center justify-between">
                        <div>
                            <h1 className="text-2xl md:text-4xl font-extrabold">
                                Todos los productos
                            </h1>
                            <p className="text-lg text-gray-600/90 font-medium">
                                {products.count} resultados
                            </p>
                        </div>
                        <div>
                            Ordenar por:
                            <span>
                                <select
                                    name="sort"
                                    className="select select-sm select-ghost focus:outline-0 focus:border-0"
                                    onChange={(event) =>
                                        updateParam("sort", event.target.value)
                                    }
                                >
                                    <option value="">Destacados</option>
                                    <option value="producto_precio:asc">
                                        Menor precio
                                    </option>
                                    <option value="producto_precio:desc">
                                        Mayor precio
                                    </option>
                                    <option value="producto_fecha:desc">
                                        Nuevos
                                    </option>
                                </select>
                            </span>
                        </div>
                    </div>
                </div>
            </section>
            <section className="w-full px-3">
                <div className="w-full max-w-[1200px] mx-auto py-10">
                    <div className="flex flex-col md:flex-row items-center md:items-start gap-10">
                        <ProductsFilters
                            updateParam={updateParam}
                            searchParams={searchParams}
                            setSearchParams={setSearchParams}
                        />
                        <div className="space-y-8 w-full">
                            {ProductsList}
                            <div className="w-full bg-white rounded-lg border border-black/10 py-2 px-5 shadow-lg flex items-center justify-between">
                                <Pagination
                                    data={products}
                                    updateParam={updateParam}
                                    searchParams={searchParams}
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </>
    );
}
