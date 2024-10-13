export default function ProductsFilters({ searchParams, updateParam }) {
    return (
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
                        <select
                            onChange={(event) =>
                                updateParam("category", event.target.value)
                            }
                            className="select select-bordered rounded w-full focus:outline-0 focus:select-primary"
                        >
                            <option value="">Todos</option>
                            <option value="1">Moda</option>
                            <option value="2">Comida</option>
                            <option value="3">Tecnologia</option>
                            <option value="4">Otros</option>
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
                                onChange={() => {
                                    updateParam("min", 0);
                                    updateParam("max", 45000);
                                }}
                            />
                            <span>Hasta $45.000</span>
                        </label>
                        <label className="flex items-center gap-2">
                            <input
                                type="radio"
                                name="product-price"
                                className="radio radio-primary radio-xs"
                                onChange={() => {
                                    updateParam("min", 45000);
                                    updateParam("max", 100000);
                                }}
                            />
                            <span>$65.000 - $100.000</span>
                        </label>
                        <label className="flex items-center gap-2">
                            <input
                                type="radio"
                                name="product-price"
                                className="radio radio-primary radio-xs"
                                onChange={() => {
                                    updateParam("min", 100000);
                                    updateParam("max", "");
                                }}
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
                                <input
                                    placeholder="$0.00"
                                    type="number"
                                    min="0"
                                    className="input input-bordered input-sm rounded grow focus:outline-0 focus:input-primary"
                                    onChange={(event) =>
                                        updateParam("min", event.target.value)
                                    }
                                    defaultValue={searchParams.get("min") || ""}
                                />
                            </label>
                        </div>

                        <div className="flex gap-2 items-end">
                            <label className="form-control w-full">
                                <div className="label">
                                    <span className="label-text text-sm font-semibold">
                                        Precio máximo:
                                    </span>
                                </div>
                                <input
                                    placeholder="$1'000.000"
                                    type="number"
                                    min="0"
                                    className="input input-bordered input-sm rounded grow focus:outline-0 focus:input-primary"
                                    onChange={(event) =>
                                        updateParam("max", event.target.value)
                                    }
                                    defaultValue={searchParams.get("max") || ""}
                                />
                            </label>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    );
}
