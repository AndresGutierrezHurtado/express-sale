import React from "react";

// Hooks
import { useValidateform } from "@hooks/useValidateForm.js";
import { usePostData } from "@hooks/useFetchData.js";
import { useConvertImage } from "@hooks/useConvertImage.js";

export default function ProductCreateModal({ reload }) {
    const handleSubmit = async (event) => {
        event.preventDefault();

        const data = Object.fromEntries(new FormData(event.target));
        const validation = useValidateform(data, "create-product-form");

        if (validation.success) {
            const response = await usePostData("/products", {
                product: {
                    product_name: data.product_name,
                    product_price: data.product_price,
                    product_description: data.product_description,
                    product_quantity: data.product_quantity,
                    product_status: data.product_status,
                    category_id: data.category_id,
                },
                producto_imagen:
                    data.producto_imagen.size > 0
                        ? await useConvertImage(data.producto_imagen)
                        : null,
            });
            if (response.success) {
                reload();
                event.target.reset();
                document.getElementById("product-create-modal").close();
            }
        }
    };

    return (
        <>
            <dialog id="product-create-modal" className="modal">
                <div className="modal-box">
                    <form method="dialog">
                        <button className="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">
                            ✕
                        </button>
                    </form>
                    <h2 className="text-2xl font-bold tracking-tight">Crea un producto nuevo:</h2>
                    <form onSubmit={handleSubmit} className="gap-2">
                        <div className="form-control">
                            <label className="label">
                                <span className="label-text font-semibold after:content-['*'] after:ml-0.5 after:text-red-500">
                                    Nombre:
                                </span>
                            </label>
                            <input
                                name="product_name"
                                placeholder="Ingresa el nombre del producto"
                                className="input input-bordered input-sm focus:input-primary focus:outline-0"
                            />
                        </div>
                        <div className="form-control">
                            <label className="label">
                                <span className="label-text font-semibold after:content-['*'] after:ml-0.5 after:text-red-500">
                                    Precio:
                                </span>
                            </label>
                            <input
                                name="product_price"
                                placeholder="Ingresa el precio del producto"
                                className="input input-bordered input-sm focus:input-primary focus:outline-0"
                            />
                        </div>
                        <div className="form-control">
                            <label className="label">
                                <span className="label-text font-semibold after:content-['*'] after:ml-0.5 after:text-red-500">
                                    Descripcion:
                                </span>
                            </label>
                            <textarea
                                name="product_description"
                                placeholder="Ingresa la descripcion del producto"
                                className="textarea textarea-bordered textarea-sm focus:textarea-primary focus:outline-0 h-32 resize-none"
                            ></textarea>
                        </div>
                        <div className="form-control">
                            <label className="label">
                                <span className="label-text font-semibold after:content-['*'] after:ml-0.5 after:text-red-500">
                                    Categoria:
                                </span>
                            </label>
                            <select
                                name="category_id"
                                className="select select-sm select-bordered focus:outline-0 focus:select-primary"
                                defaultValue="4"
                            >
                                <option value="1">Moda</option>
                                <option value="2">Comida</option>
                                <option value="3">Tecnologia</option>
                                <option value="4">Otros</option>
                            </select>
                        </div>
                        <div className="form-control">
                            <label className="label">
                                <span className="label-text font-semibold after:content-['*'] after:ml-0.5 after:text-red-500">
                                    Cantidad:
                                </span>
                            </label>
                            <input
                                name="product_quantity"
                                placeholder="Ingresa la cantidad del producto"
                                className="input input-bordered input-sm focus:input-primary focus:outline-0"
                            />
                        </div>
                        <div className="form-group">
                            <label className="label">
                                <span className="label-text font-semibold">Imagen:</span>
                            </label>
                            <input
                                name="producto_imagen"
                                type="file"
                                className="file-input file-input-bordered file-input-sm focus:input-primary focus:outline-0 w-full"
                            />
                        </div>
                        <div className="form-control">
                            <label className="label">
                                <span className="label-text font-semibold after:content-['*'] after:ml-0.5 after:text-red-500">
                                    Estado:
                                </span>
                            </label>
                            <select
                                name="product_status"
                                className="select select-sm select-bordered focus:outline-0 focus:select-primary"
                                defaultValue="privado"
                            >
                                <option value="publico">Público</option>
                                <option value="privado">Privado</option>
                            </select>
                        </div>
                        <div className="form-control pt-5">
                            <button type="submit" className="btn btn-sm btn-primary w-full">
                                Crear producto
                            </button>
                        </div>
                    </form>
                </div>
                <form method="dialog" className="modal-backdrop bg-black/30">
                    <button>close</button>
                </form>
            </dialog>
        </>
    );
}
