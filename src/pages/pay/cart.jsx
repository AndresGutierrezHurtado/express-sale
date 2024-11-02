import React from "react";

import { TrashIcon, PlusIcon, MinusIcon } from "@components/icons";

export default function Cart() {
    return (
        <>
            <section className="w-full px-3">
                <div className="w-full max-w-[1200px] mx-auto py-10">
                    <div className="space-y-5">
                        <h2 className="text-3xl font-extrabold text-center">Carrito de compras</h2>
                        <div className="flex gap-10">
                            <div className="grow">
                                <article className="bg-white p-8 w-full shadow-xl rounded-xl border">
                                    <div className="flex gap-5">
                                        <figure className="size-[160px]">
                                            <img
                                                src="https://res.cloudinary.com/dyuh7jesr/image/upload/v1730360610/express-sale/products/09fd4c7b-cd37-4e6d-a7f6-ae8f93734005.jpg"
                                                alt="Imagen producto"
                                                className="object-contain h-full w-full"
                                            />
                                        </figure>
                                        <div className="grow h-[initial]">
                                            <div className="flex w-full h-full">
                                                <div className="grow h-full flex flex-col justify-between">
                                                    <div className="grow">
                                                        <h2 className="text-3xl font-bold">
                                                            Producto
                                                        </h2>
                                                        <p className="text-lg font-bold">
                                                            10.000 COP
                                                        </p>
                                                        <p className="text-sm font-semibold text-gray-600">
                                                            Cant: 1
                                                        </p>
                                                    </div>
                                                    <span className="flex gap-4 items-center justify-start">
                                                        <button
                                                            className="btn btn-sm tooltip tooltip-top"
                                                            data-tip="Disminuir la cantidad del producto"
                                                        >
                                                            <MinusIcon size={12} />
                                                        </button>
                                                        <p className="text-xl">4</p>
                                                        <button
                                                            className="btn btn-sm tooltip tooltip-top"
                                                            data-tip="Aumentar la cantidad del producto"
                                                        >
                                                            <PlusIcon />
                                                        </button>
                                                    </span>
                                                </div>
                                                <div className="text-end flex flex-col justify-between items-end h-full">
                                                    <p className="text-2xl font-bold">40.000</p>
                                                    <button
                                                        className="tooltip tooltip-left btn btn-sm bg-red-600 hover:bg-red-700 text-red-400 hover:text-red-300"
                                                        data-tip="Eliminar el producto del carrito"
                                                    >
                                                        <TrashIcon size={17} />
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            </div>
                            <div className="w-full max-w-[300px] p-8 space-y-5 bg-white border shadow-xl rounded-xl">
                                <div className="[&_div]:flex [&_div]:gap-5 [&_div]:justify-between [&_div]:w-full">
                                    <div>
                                        <h2 className="text-2xl font-bold">Resumen:</h2>
                                    </div>
                                    <div>
                                        <label>Subtotal</label>
                                        <p>30.000</p>
                                    </div>
                                    <div>
                                        <label>Iva</label>
                                        <p>30.000</p>
                                    </div>
                                    <div>
                                        <label>Total</label>
                                        <p>30.000</p>
                                    </div>
                                    <div className="form-group pt-5">
                                        <button className="btn btn-primary btn-sm w-full">
                                            Pagar
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
