import React from "react";
import { Link, useSearchParams } from "react-router-dom";
import Swal from "sweetalert2";

// Hooks
import { useGetData, useDeleteData } from "@hooks/useFetchData";

// Components
import ContentLoading from "@components/contentLoading.jsx";
import Pagination from "@components/pagination";
import { TrashIcon, PencilIcon } from "@components/icons";

export default function ProductsAdmin() {
    const [searchParams, setSearchParams] = useSearchParams();

    const updateParam = (key, value) => {
        const newSearchParams = new URLSearchParams(searchParams);
        newSearchParams.set(key, value);
        setSearchParams(newSearchParams);
    };

    const {
        data: products,
        loading: loadingProducts,
        reload: reloadProducts,
    } = useGetData(`/products?${searchParams.toString()}`);

    const handleDeleteProduct = (id, name) => {
        Swal.fire({
            icon: "warning",
            title: `¿Estás Seguro de eliminar el producto ${name}`,
            text: "Esta acción será irrevertible.",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, Eliminar",
        }).then(async (result) => {
            if (result.isConfirmed) {
                const response = await useDeleteData(`/products/${id}`);
                if (response.success) {
                    reloadProducts();
                }
            }
        });
    };

    if (loadingProducts) return <ContentLoading />;

    return (
        <article className="card bg-white max-w-[1000px] shadow-xl mx-auto my-10">
            <div className="card-body">
                <div className="overflow-auto">
                    <table className="table border">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th>Categoria</th>
                                <th>Precio</th>
                                <th>Stock</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            {products.rows.map((product) => (
                                <tr key={product.product_id}>
                                    <td>{product.product_id}</td>
                                    <td>{product.product_name}</td>
                                    <td className="capitalize">
                                        {product.category.category_name}
                                    </td>
                                    <td>
                                        {parseFloat(product.product_price).toLocaleString(
                                            "es-CO"
                                        )}{" "}
                                        COP
                                    </td>
                                    <td>{product.product_quantity}</td>
                                    <td className="flex gap-2">
                                        <Link
                                            to={`/profile/product/${product.product_id}`}
                                            className="btn btn-sm min-h-none h-auto py-2.5 pl-8 relative bg-gray-200 hover:bg-gray-200 text-gray-500 hover:text-gray-600"
                                        >
                                            <span className="absolute left-3 top-1/2 transform -translate-y-1/2">
                                                <PencilIcon />
                                            </span>
                                            Editar
                                        </Link>
                                        <button
                                            onClick={() =>
                                                handleDeleteProduct(
                                                    product.product_id,
                                                    product.product_name
                                                )
                                            }
                                            className="btn btn-sm min-h-none h-auto py-2.5 pl-8 relative bg-red-600 hover:bg-red-700 text-red-300 hover:text-red-200"
                                        >
                                            <span className="absolute left-3 top-1/2 transform -translate-y-1/2">
                                                <TrashIcon />
                                            </span>
                                            Eliminar
                                        </button>
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
                <nav className="flex flex-col md:flex-row justify-between">
                    <Pagination
                        data={products}
                        updateParam={updateParam}
                        searchParams={searchParams}
                    />
                </nav>
            </div>
        </article>
    );
}
