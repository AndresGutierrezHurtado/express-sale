import { useEffect, useState } from "react";

// Components
import Loading from "../loading";
import Product from "../product";

// Hooks
import { useGetData } from "../../hooks/useFetchData";

export default function ProductsContent() {
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

    const ProductsList =
        products &&
        products.map((product) => {
            return <Product product={product} key={product.producto_id} />;
        });

    if (loading) return <Loading />;

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
                    <div className="flex flex-col md:flex-row items-center md:items-start gap-10">
                        <div className="card bg-base-100 shadow-xl w-full max-w-[350px] h-fit">
                            <div className="card-body gap-0">
                                <h2 className="text-2xl font-bold">Filtros:</h2>
                                <form className="space-y-4">
                                    <label className="form-control w-full">
                                        <div className="label">
                                            <span className="label-text font-semibold">
                                                Categorias:
                                            </span>
                                        </div>
                                        <select className="select select-bordered w-full max-w-xs focus:outline-0 focus:select-primary">
                                            <option>Todos</option>
                                            <option>Moda</option>
                                            <option>Tecnologia</option>
                                            <option>Comida</option>
                                            <option>Otros</option>
                                        </select>
                                    </label>
                                    <div className="form-control w-full">
                                        <div className="label">
                                            <span className="label-text font-semibold">
                                                Precios:
                                            </span>
                                        </div>
                                        <label className="flex items-center gap-2">
                                            <input
                                                type="radio"
                                                name="product-price"
                                                className="radio radio-primary radio-xs"
                                            />
                                            <span>Hasta $45.000</span>
                                        </label>
                                        <label className="flex items-center gap-2">
                                            <input
                                                type="radio"
                                                name="product-price"
                                                className="radio radio-primary radio-xs"
                                            />
                                            <span>$65.000 - $100.000</span>
                                        </label>
                                        <label className="flex items-center gap-2">
                                            <input
                                                type="radio"
                                                name="product-price"
                                                className="radio radio-primary radio-xs"
                                            />
                                            <span>Más de $100.000</span>
                                        </label>
                                    </div>
                                    <div className="form-group">
                                        <div className="flex gap-2 items-end">
                                            <label className="form-control w-full">
                                                <div className="label">
                                                    <span className="label-text text-sm font-semibold">
                                                        Precio mínimo:
                                                    </span>
                                                </div>
                                                <input placeholder="$0.00" type="number" min="0" className="input input-bordered input-sm grow focus:outline-0 focus:input-primary" />
                                            </label>
                                            <button className="btn btn-primary btn-sm rounded-full" type="button">
                                                ir
                                            </button>
                                        </div>

                                        <div className="flex gap-2 items-end">
                                            <label className="form-control w-full">
                                                <div className="label">
                                                    <span className="label-text text-sm font-semibold">
                                                        Precio máximo:
                                                    </span>
                                                </div>
                                                <input placeholder="$1'000.000" type="number" min="0" className="input input-bordered input-sm grow focus:outline-0 focus:input-primary" />
                                            </label>
                                            <button className="btn btn-primary btn-sm rounded-full" type="button">
                                                ir
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div className="space-y-8 w-full">{ProductsList}</div>
                    </div>
                </div>
            </section>
        </>
    );
}
