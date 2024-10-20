import { useState, useEffect } from "react";
import { useLocation, useSearchParams } from "react-router-dom";

// Components
import ProductsFilters from "../components/filters.jsx";
import Product from "@components/productCard.jsx";
import ContentLoading from "@components/contentLoading.jsx";
import Pagination from "@components/pagination.jsx";

// Hooks
import { useGetData } from "@hooks/useFetchData.js";

export default function Products() {
    const [searchParams, setSearchParams] = useSearchParams();
    const { loading: loadingProducts, data: products, reload: reloadProducts } = useGetData(`/products?${searchParams.toString()}`);

    const ProductsList =
        products &&
        products.rows.map((product) => {
            return <Product product={product} reloadProducts={reloadProducts} key={product.producto_id} />;
        });

    const updateParam = (key, value) => {
        const newSearchParams = new URLSearchParams(searchParams);
        newSearchParams.set(key, value);
        setSearchParams(newSearchParams);
    };

    if (loadingProducts) return <ContentLoading />;

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
