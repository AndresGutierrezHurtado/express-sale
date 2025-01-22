// Hooks
import { usePostData } from "../hooks/useFetchData";
import { useValidateform } from "../hooks/useValidateForm";

export default function RateModal({ id, type, reload }) {
    const handleRatingSubmit = async (event) => {
        event.preventDefault();

        const data = Object.fromEntries(new FormData(event.target));
        const validation = useValidateform(data, "rate-form");

        if (validation.success) {
            const endpoint =
                type === "product" ? `/ratings/products/${id}` : `/ratings/users/${id}`;
            const response = await usePostData(endpoint, { rating: data });

            if (response.success) {
                event.target.closest("dialog").close();
                reload();
            }
        }
    };

    return (
        <dialog
            id={`${type === "product" ? "product" : "user"}-modal-${id}`}
            className="modal"
            style={{ marginTop: "0px" }}
        >
            <div className="modal-box rounded-lg">
                <div className="modal-action m-0">
                    <form method="dialog">
                        <button className="btn btn-sm btn-circle btn-ghost absolute right-3 top-3">
                            ✕
                        </button>
                    </form>
                </div>
                <h3 className="text-xl font-bold">
                    Calificar {type === "product" ? "el producto" : "el usuario"}:
                </h3>
                <p>
                    {type === "product"
                        ? "Ten en cuenta la calidad del producto y su fidelidad a la imagen de referencia"
                        : "Ten en cuenta la calidad de sus productos, atención al cliente y rapidez de entrega"}
                </p>

                <form
                    encType="multipart/form-data"
                    className="fetch-form space-y-2"
                    onSubmit={handleRatingSubmit}
                >
                    <label className="form-control w-full">
                        <div className="label">
                            <span className="label-text font-medium text-gray-700">Mensaje:</span>
                        </div>
                        <textarea
                            placeholder="Ingresa un comentario sobre el producto."
                            id="rating_comment"
                            name="rating_comment"
                            className="textarea textarea-bordered h-24 resize-none focus:outline-0 focus:border-violet-600 rounded"
                        ></textarea>
                    </label>

                    <label className="form-control w-full">
                        <div className="label">
                            <span className="label-text font-medium text-gray-700">Imagen:</span>
                        </div>
                        <input
                            type="file"
                            name="rating_image"
                            id="rating_image"
                            className="w-full text-sm text-slate-500 hover:file:bg-violet-100 file:duration-300 file:cursor-pointer file:bg-violet-50 file:text-violet-700 file:font-semibold file:rounded-xl file:border-0 file:p-1 file:px-3"
                        />
                    </label>

                    <div className="rating flex justify-center gap-2 py-3">
                        <input
                            type="radio"
                            name="rating_value"
                            value="1"
                            className="mask mask-star-2 bg-violet-600"
                            defaultChecked
                        />
                        <input
                            type="radio"
                            name="rating_value"
                            value="2"
                            className="mask mask-star-2 bg-violet-600"
                        />
                        <input
                            type="radio"
                            name="rating_value"
                            value="3"
                            className="mask mask-star-2 bg-violet-600"
                        />
                        <input
                            type="radio"
                            name="rating_value"
                            value="4"
                            className="mask mask-star-2 bg-violet-600"
                        />
                        <input
                            type="radio"
                            name="rating_value"
                            value="5"
                            className="mask mask-star-2 bg-violet-600"
                        />
                    </div>
                    <button
                        type="submit"
                        className="w-full bg-violet-600 font-bold duration-300 hover:bg-violet-800 text-white py-2 px-4 rounded-lg"
                    >
                        Calificar
                    </button>
                </form>
            </div>
            <form method="dialog" className="modal-backdrop bg-black/50">
                <button className="cursor-auto">close</button>
            </form>
        </dialog>
    );
}
