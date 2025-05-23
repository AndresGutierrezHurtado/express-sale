import Swal from "sweetalert2";

// Components
import { DotsIcon, FlagIcon, PencilIcon, StarIcon, TrashIcon } from "./icons.jsx";
import { StarsRating } from "./starsRating.jsx";

// Contexts
import { useAuthContext } from "../contexts/authContext.jsx";

// Hooks
import { useDeleteData, usePutData } from "../hooks/useFetchData.js";
import { useValidateform } from "../hooks/useValidateForm.js";

export function Calification({ rating, reload }) {
    const { userSession } = useAuthContext();

    const handleReport = () => {
        Swal.fire({
            icon: "warning",
            title: "¿Estás seguro?",
            text: "Dale a continuar si quieres reportar el elemento",
            showCancelButton: true,
            cancelButtonText: "Cancelar",
            confirmButtonText: "Continuar",
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
        }).then(async (result) => {
            if (result.isConfirmed) {
                setTimeout(() => {
                    Swal.fire({
                        icon: "info",
                        title: "Acción exitosa",
                        text: "El elemento fue reportado correctamente",
                        timer: 2000,
                    });
                }, 1000);
            }
        });
    };

    const handleDelete = (id) => {
        Swal.fire({
            icon: "warning",
            title: "¿Estás seguro?",
            text: "Dale a continuar si quieres eliminar el elemento, esta acción será irrevertible",
            showCancelButton: true,
            cancelButtonText: "Cancelar",
            confirmButtonText: "Continuar",
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
        }).then(async (result) => {
            if (result.isConfirmed) {
                const response = await useDeleteData(`/ratings/${id}`);
                reload();
            }
        });
    };

    const handleUpdate = async (event) => {
        event.preventDefault();

        const data = Object.fromEntries(new FormData(event.target));
        const validation = useValidateform(data, "rate-form");

        if (validation.success) {
            const response = await usePutData(`/ratings/${rating.rating_id}`, { rating: data });
            if (response.success) {
                event.target.closest("dialog").close();
                reload();
            }
        }
    };

    return (
        <>
            <article className="flex flex-col gap-2">
                <div className="flex justify-between items-center w-full">
                    <div className="flex gap-2 items-center">
                        <figure className="w-10 aspect-square rounded-full overflow-hidden">
                            <img
                                src={rating.calificator.user_image_url}
                                alt={`Imagen del calificador ${rating.calificator.user_alias}`}
                                className="object-cover h-full w-full"
                            />
                        </figure>
                        <div className="flex flex-col gap-1">
                            <h4 className="font-medium">{rating.calificator.user_alias}</h4>
                            <StarsRating rating={parseInt(rating.rating_value)} />
                        </div>
                    </div>
                    <div className="dropdown dropdown-end">
                        <div tabIndex="0" role="button" className="btn btn-circle btn-ghost btn-sm">
                            <DotsIcon />
                        </div>
                        <ul
                            tabIndex="0"
                            className="dropdown-content menu bg-base-100 rounded-box z-[1] w-52 p-2 shadow [&>li>a]:flex [&>li>a]:justify-between [&>li>a]:items-center"
                        >
                            <li>
                                <a onClick={handleReport} className="text-red-500">
                                    Reportar
                                    <FlagIcon />
                                </a>
                            </li>
                            {userSession &&
                                (rating.user_id == userSession.user_id ||
                                    userSession.role_id == 4) && (
                                    <>
                                        <li>
                                            <a
                                                onClick={() =>
                                                    document
                                                        .getElementById(
                                                            `rating-edit-${rating.rating_id}`
                                                        )
                                                        .show()
                                                }
                                            >
                                                Editar
                                                <PencilIcon size={16} />
                                            </a>
                                        </li>
                                        <li>
                                            <a
                                                onClick={() => handleDelete(rating.rating_id)}
                                                className="text-red-500"
                                            >
                                                Eliminar
                                                <TrashIcon />
                                            </a>
                                        </li>
                                    </>
                                )}
                        </ul>
                    </div>
                </div>
                <div className="grow">
                    <p>{rating.rating_comment}</p>
                </div>
            </article>
            <dialog id={`rating-edit-${rating.rating_id}`} className="modal mt-[0_!important]">
                <div className="modal-box">
                    <form method="dialog">
                        <button className="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">
                            ✕
                        </button>
                    </form>
                    <h3 className="font-bold text-lg">Actualizar la calificacion:</h3>
                    <form
                        encType="multipart/form-data"
                        className="space-y-2"
                        onSubmit={handleUpdate}
                    >
                        <label className="form-control w-full">
                            <div className="label">
                                <span className="label-text font-medium text-gray-700">
                                    Mensaje:
                                </span>
                            </div>
                            <textarea
                                placeholder="Ingresa un comentario sobre el producto."
                                id="rating_comment"
                                name="rating_comment"
                                className="textarea textarea-bordered h-24 resize-none focus:outline-0 focus:border-violet-600 rounded"
                                defaultValue={rating.rating_comment}
                            ></textarea>
                        </label>

                        <label className="form-control w-full">
                            <div className="label">
                                <span className="label-text font-medium text-gray-700">
                                    Imagen:
                                </span>
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
                                defaultChecked={rating.rating_value == 1}
                            />
                            <input
                                type="radio"
                                name="rating_value"
                                value="2"
                                className="mask mask-star-2 bg-violet-600"
                                defaultChecked={rating.rating_value == 2}
                            />
                            <input
                                type="radio"
                                name="rating_value"
                                value="3"
                                className="mask mask-star-2 bg-violet-600"
                                defaultChecked={rating.rating_value == 3}
                            />
                            <input
                                type="radio"
                                name="rating_value"
                                value="4"
                                className="mask mask-star-2 bg-violet-600"
                                defaultChecked={rating.rating_value == 4}
                            />
                            <input
                                type="radio"
                                name="rating_value"
                                value="5"
                                className="mask mask-star-2 bg-violet-600"
                                defaultChecked={rating.rating_value == 5}
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
                    <button>close</button>
                </form>
            </dialog>
        </>
    );
}
