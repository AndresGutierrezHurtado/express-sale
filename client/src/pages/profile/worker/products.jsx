import React from "react";
import { useParams, useSearchParams, Link } from "react-router-dom";
import { TrashIcon, PencilIcon } from "@components/icons.jsx";
import Swal from "sweetalert2";

// Hooks
import { useGetData, useDeleteData } from "@hooks/useFetchData.js";

// Components
import ContentLoading from "@components/contentLoading.jsx";
import Pagination from "@components/pagination.jsx";

export default function WorkerProducts() {
    const { id } = useParams();
    const [searchParams, setSearchParams] = useSearchParams();
    const { data: user, loading: userLoading, reload: reloadUser } = useGetData(`/users/${id}`);
    const {
        data: products,
        loading: productsLoading,
        reload: reloadProducts,
    } = useGetData(`/users/${id}/products?${searchParams.toString()}`);

    const updateParam = (param, value) => {
        const newSearchParams = new URLSearchParams(searchParams);
        newSearchParams.set(param, value);
        setSearchParams(newSearchParams);
    };

    const handleDeleteProduct = (id, name) => {
        Swal.fire({
            icon: "warning",
            title: `¿Estás Seguro de eliminar el producto ${name}`,
            text: "Esta acción es irrevertible",
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

    if (userLoading || productsLoading) return <ContentLoading />;
    return (
        <>
            <section className="w-full min-h-full p-5 flex justify-center items-center py-10">
                <article className="card bg-white shadow-xl border w-full max-w-5xl mx-auto">
                    <div className="card-body space-y-4">
                        <h2 className="text-2xl md:text-4xl font-extrabold tracking-tight">
                            Lista de productos de {user.user_name}
                        </h2>
                        <div className="w-full space-y-2">
                            <div className="w-full overflow-x-auto">
                                <table className="table border">
                                    <thead className="bg-gray-100">
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
                                                    {parseInt(
                                                        product.product_price
                                                    ).toLocaleString()}{" "}
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
                            <span className="flex justify-between items-center w-full">
                                <Pagination
                                    data={products}
                                    updateParam={updateParam}
                                    searchParams={searchParams}
                                />
                            </span>
                        </div>
                    </div>
                </article>
            </section>
        </>
    );
}
