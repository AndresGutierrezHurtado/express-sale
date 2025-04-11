import React from "react";
import { Link } from "react-router-dom";
import Swal from "sweetalert2";

// Components
import ContentLoading from "@components/contentLoading.jsx";
import { TrashIcon, PlusIcon, MinusIcon } from "@components/icons.jsx";

// Hooks
import { useDeleteData, useGetData, usePutData } from "@hooks/useFetchData.js";

// Contexts
import { useAuthContext } from "@contexts/authContext.jsx";

export default function Cart() {
    const { userSession, loading: loadingUserSession } = useAuthContext();
    const {
        data: carts,
        loading: loadingCarts,
        reload: reloadCarts,
    } = useGetData(`/users/${userSession.user_id}/carts`);

    const handleCartUpdate = async (id, quantity) => {
        const response = await usePutData(`/carts/${id}`, { product_quantity: quantity });
        if (response.success) {
            reloadCarts();
        }
    };

    const handleCartDelete = async (event) => {
        const { id } = event.target.dataset;
        Swal.fire({
            icon: "warning",
            title: "¿Estas seguro?",
            text: "Dale a continuar si quieres eliminar el producto",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            cancelButtonText: "Cancelar",
            confirmButtonText: "Continuar",
        }).then(async (result) => {
            if (result.isConfirmed) {
                const response = await useDeleteData(`/carts/${id}`);
                if (response.success) {
                    reloadCarts();
                }
            }
        });
    };

    const handleEmptyCart = async () => {
        Swal.fire({
            icon: "warning",
            title: "¿Estas seguro?",
            text: "Dale a continuar si quieres vaciar el carrito",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            cancelButtonText: "Cancelar",
            confirmButtonText: "Continuar",
        }).then(async (result) => {
            if (result.isConfirmed) {
                const response = await useDeleteData(
                    `/users/${userSession.user_id}/carts/empty`
                );
                if (response.success) {
                    reloadCarts();
                }
            }
        });
    };

    const subTotal = carts?.reduce(
        (acc, cart) => acc + cart.product.product_price * cart.product_quantity,
        0
    );

    if (loadingCarts) return <ContentLoading />;
    return (
        <>
            <section className="w-full px-3">
                <div className="w-full max-w-[1200px] mx-auto py-10">
                    <div className="space-y-5">
                        <h2 className="text-3xl font-extrabold text-center">Carrito de compras</h2>
                        <div className="flex flex-col md:flex-row gap-10">
                            <div className="grow space-y-5">
                                {carts.length === 0 && (
                                    <h2 className="text-xl font-bold py-8">
                                        Tu carrito de compras esta vacio...
                                    </h2>
                                )}
                                {carts.map((cart) => (
                                    <article
                                        key={cart.cart_id}
                                        className="bg-white p-8 w-full shadow-xl rounded-xl border"
                                    >
                                        <div className="flex flex-col md:flex-row gap-5">
                                            <Link
                                                to={`/product/${cart.product_id}`}
                                                className="size-[160px]"
                                            >
                                                <img
                                                    src={cart.product.product_image_url}
                                                    alt={`Imagen del producto ${cart.product.product_name}`}
                                                    className="object-contain h-full w-full"
                                                />
                                            </Link>
                                            <div className="grow h-[initial]">
                                                <div className="flex flex-col sm:flex-row w-full h-full">
                                                    <div className="grow h-full flex flex-col justify-between">
                                                        <div className="grow">
                                                            <h2 className="text-3xl font-bold">
                                                                {cart.product.product_name}
                                                            </h2>
                                                            <p className="text-lg font-bold">
                                                                {parseInt(
                                                                    cart.product.product_price
                                                                ).toLocaleString("es-CO")}{" "}
                                                                COP
                                                            </p>
                                                            <p className="text-sm font-semibold text-gray-600">
                                                                Cant: {cart.product_quantity}
                                                            </p>
                                                        </div>
                                                        <span className="flex gap-4 items-center justify-start">
                                                            <button
                                                                className="btn btn-sm tooltip tooltip-top"
                                                                data-tip="Disminuir la cantidad del producto (min 1)"
                                                                onClick={() =>
                                                                    handleCartUpdate(
                                                                        cart.cart_id,
                                                                        cart.product_quantity - 1
                                                                    )
                                                                }
                                                                disabled={
                                                                    cart.product_quantity === 1
                                                                }
                                                            >
                                                                <MinusIcon size={12} />
                                                            </button>
                                                            <p className="text-xl font-medium">
                                                                {cart.product_quantity}
                                                            </p>
                                                            <button
                                                                className="btn btn-sm tooltip tooltip-top"
                                                                data-tip={`Aumentar la cantidad del producto (max ${cart.product.product_quantity})`}
                                                                onClick={() =>
                                                                    handleCartUpdate(
                                                                        cart.cart_id,
                                                                        cart.product_quantity + 1
                                                                    )
                                                                }
                                                                disabled={
                                                                    cart.product_quantity ===
                                                                    cart.product.product_quantity
                                                                }
                                                            >
                                                                <PlusIcon />
                                                            </button>
                                                        </span>
                                                    </div>
                                                    <div className="text-end flex flex-col justify-between items-start sm:items-end h-full">
                                                        <p className="text-2xl font-bold">
                                                            {parseInt(
                                                                cart.product.product_price *
                                                                    cart.product_quantity
                                                            ).toLocaleString("es-CO")}{" "}
                                                            COP
                                                        </p>
                                                        <button
                                                            className="tooltip tooltip-left btn btn-sm bg-red-600 hover:bg-red-700 text-red-400 hover:text-red-300"
                                                            data-tip="Eliminar el producto del carrito"
                                                            data-id={cart.cart_id}
                                                            onClick={handleCartDelete}
                                                        >
                                                            <TrashIcon size={17} />
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                ))}
                            </div>
                            <div className="w-full max-w-[300px] p-8 space-y-5 bg-white border shadow-xl rounded-xl h-fit">
                                <div className="[&_div]:flex [&_div]:gap-5 [&_div]:justify-between [&_div]:items-center [&_div]:w-full">
                                    <div>
                                        <h2 className="text-2xl font-bold">Resumen:</h2>
                                    </div>
                                    <div>
                                        <label className="label-text font-semibold">
                                            Subtotal:
                                        </label>
                                        <p>{parseInt(subTotal).toLocaleString("es-CO")}</p>
                                    </div>
                                    <div>
                                        <label className="label-text font-semibold">IVA:</label>
                                        <p>0% (0.00)</p>
                                    </div>
                                    <div>
                                        <label className="label-text font-semibold">Envío:</label>
                                        <p>Pendiente</p>
                                    </div>
                                    <div>
                                        <label className="label-text font-semibold">Total:</label>
                                        <p>{parseInt(subTotal).toLocaleString("es-CO")}</p>
                                    </div>
                                    <div className="form-control pt-5">
                                        <Link
                                            to="/payform"
                                            className="btn btn-primary btn-sm w-full"
                                        >
                                            Pagar
                                        </Link>
                                        <button
                                            onClick={handleEmptyCart}
                                            className="btn btn-sm w-full"
                                        >
                                            Vaciar carrito
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </>
    );
}
