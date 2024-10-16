import { useState, useEffect } from "react";
import { useParams } from "react-router-dom";

// Hooks
import { useGetData } from "../hooks/useFetchData";

// Components
import ContentLoading from "../components/contentLoading";
import { EyeIcon, PlusIcon, StarIcon, UserIcon } from "../components/icons";
import RateModal from "../components/rateModal";

export default function Worker() {
    const [seller, setSeller] = useState(null);
    const { id } = useParams();

    const getSeller = async () => {
        const user = await useGetData(`/api/users/${id}`);
        if (user) {
            setSeller(user.data);
        }
    };

    useEffect(() => {
        getSeller();
    }, []);

    if (!seller) return <ContentLoading />;

    return (
        <>
            <section className="w-full px-3">
                <div className="w-full max-w-[1200px] mx-auto py-10">
                    <div className="flex flex-col md:flex-row gap-2">
                        <div className="w-full max-w-[500px]">
                            <article className="card bg-base-100 shadow-xl border">
                                <div className="card-body flex flex-col gap-4">
                                    <div className="flex flex-col md:flex-row gap-5">
                                        <figure className="w-full max-w-[140px] aspect-square rounded-lg">
                                            <img
                                                src={seller.usuario_imagen_url}
                                                alt={`Imagen del ${seller.role.rol_nombre} ${seller.usuario_alias}`}
                                                className="object-cover w-full h-full"
                                            />
                                        </figure>
                                        <div className="grow space-y-2 h-[initial] flex flex-col">
                                            <div>
                                                <h2 className="text-xl font-bold">
                                                    {seller.usuario_nombre}{" "}
                                                    {seller.usuario_apellido}
                                                </h2>
                                                <p className="text-gray-600/90 text-sm italic">
                                                    @{seller.usuario_alias} (
                                                    {seller.role.rol_nombre})
                                                </p>
                                            </div>
                                            <p className="text-pretty text-lg grow">
                                                {
                                                    seller.worker
                                                        .trabajador_descripcion
                                                }
                                            </p>
                                        </div>
                                    </div>
                                    <div className="flex flex-col gap-4">
                                        <div className="grow flex items-center justify-center gap-5">
                                            <div className="flex flex-col items-center justify-center w-fit text-gray-600 space-y-1">
                                                <h2 className="font-semibold text-4xl text-center">
                                                    {seller.calificacion_promedio}
                                                </h2>
                                                <span className="flex gap-1">
                                                    <StarIcon size={15} />
                                                    <StarIcon size={15} />
                                                    <StarIcon size={15} />
                                                    <StarIcon size={15} />
                                                    <StarIcon size={15} />
                                                </span>
                                                <p className="text-sm flex gap-1 items-center">
                                                    {seller.ratings.length}
                                                    <UserIcon size={12} />
                                                </p>
                                            </div>
                                            <div className="w-full">
                                                <div className="w-full flex items-center gap-2">
                                                    <p>5</p>
                                                    <div className="w-full h-[7px] bg-gray-300/90 rounded-full overflow-hidden">
                                                        <div
                                                            style={{
                                                                width: `${(seller.ratings.filter(
                                                                    (rating) =>
                                                                        rating.calificacion ==
                                                                        5
                                                                ).length /
                                                                    seller
                                                                        .ratings
                                                                        .length) *
                                                                    100 || 0
                                                                    }%`,
                                                            }}
                                                            className="bg-purple-700 h-full rounded-full"
                                                        ></div>
                                                    </div>
                                                </div>
                                                <div className="w-full flex items-center gap-2">
                                                    <p>4</p>
                                                    <div className="w-full h-[7px] bg-gray-300/90 rounded-full overflow-hidden">
                                                        <div
                                                            style={{
                                                                width: `${(seller.ratings.filter(
                                                                    (rating) =>
                                                                        rating.calificacion ==
                                                                        4
                                                                ).length /
                                                                    seller
                                                                        .ratings
                                                                        .length) *
                                                                    100
                                                                    }%`,
                                                            }}
                                                            className="bg-purple-700 h-full rounded-full"
                                                        ></div>
                                                    </div>
                                                </div>
                                                <div className="w-full flex items-center gap-2">
                                                    <p>3</p>
                                                    <div className="w-full h-[7px] bg-gray-300/90 rounded-full overflow-hidden">
                                                        <div
                                                            style={{
                                                                width: `${(seller.ratings.filter(
                                                                    (rating) =>
                                                                        rating.calificacion ==
                                                                        3
                                                                ).length /
                                                                    seller
                                                                        .ratings
                                                                        .length) *
                                                                    100 || 0
                                                                    }%`,
                                                            }}
                                                            className="bg-purple-700 h-full rounded-full"
                                                        ></div>
                                                    </div>
                                                </div>
                                                <div className="w-full flex items-center gap-2">
                                                    <p>2</p>
                                                    <div className="w-full h-[7px] bg-gray-300/90 rounded-full overflow-hidden">
                                                        <div
                                                            style={{
                                                                width: `${(seller.ratings.filter(
                                                                    (rating) =>
                                                                        rating.calificacion ==
                                                                        2
                                                                ).length /
                                                                    seller
                                                                        .ratings
                                                                        .length) *
                                                                    100 || 0
                                                                    }%`,
                                                            }}
                                                            className="bg-purple-700 h-full rounded-full"
                                                        ></div>
                                                    </div>
                                                </div>
                                                <div className="w-full flex items-center gap-2">
                                                    <p>1</p>
                                                    <div className="w-full h-[7px] bg-gray-300/90 rounded-full overflow-hidden">
                                                        <div
                                                            style={{
                                                                width: `${(seller.ratings.filter(
                                                                    (rating) =>
                                                                        rating.calificacion ==
                                                                        1
                                                                ).length /
                                                                    seller
                                                                        .ratings
                                                                        .length) *
                                                                    100 || 0
                                                                    }%`,
                                                            }}
                                                            className="bg-purple-700 h-full rounded-full"
                                                        ></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div className="flex gap-2">
                                            <button
                                                onClick={() => {
                                                    document
                                                        .getElementById(
                                                            "user-modal-" +
                                                            seller.usuario_id
                                                        )
                                                        .showModal();
                                                }}
                                                className="btn btn-sm min-h-none h-auto py-3 px-9 btn-primary group relative text-purple-300 hover:bg-purple-800 hover:text-purple-100"
                                            >
                                                <span className="absolute left-3 top-1/2 transform -translate-y-1/2 text-purple-300 group-hover:text-purple-100">
                                                    <PlusIcon size={15} />
                                                </span>
                                                Calificar
                                            </button>
                                            <button className="btn btn-sm min-h-none h-auto py-3 px-9 btn-primary group relative text-purple-300 hover:bg-purple-800 hover:text-purple-100 grow">
                                                <span className="absolute left-3 top-1/2 transform -translate-y-1/2 text-purple-300 group-hover:text-purple-100">
                                                    <EyeIcon size={20} />
                                                </span>
                                                Ver calificaciones
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </article>
                            <div className="card bg-base-100 shadow-xl">

                                <div className="card-body space-y-5">
                                    <h2>Comentarios</h2>
                                    <div>
                                        {
                                            seller.ratings.map(rating => {
                                                return (
                                                    <article key={rating.calificacion_id} className="flex flex-col">
                                                        <div>
                                                            <div className="flex justify-between items-center w-full">
                                                                <div className="flex gap-2 items-center">
                                                                    <figure className="w-10 aspect-square rounded-full overflow-hidden">
                                                                        <img src={rating.calificator.usuario_imagen_url} alt={`Imagen del calificador ${rating.calificator.usuario_alias}`} className="object-cover h-full w-full" />
                                                                    </figure>
                                                                    <div className="flex flex-col gap-1">
                                                                        <h4 className="font-medium">
                                                                            {rating.calificator.usuario_alias}
                                                                        </h4>
                                                                        <span className="flex gap-1">
                                                                            <StarIcon size={13} />
                                                                            <StarIcon size={13} />
                                                                            <StarIcon size={13} />
                                                                            <StarIcon size={13} />
                                                                            <StarIcon size={13} />
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div className="btn btn-circle btn-ghost btn-sm">
                                                                    :
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div className="grow">
                                                            <p>
                                                                {rating.calificacion_comentario}
                                                            </p>
                                                        </div>
                                                    </article>
                                                );
                                            })
                                        }
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h2></h2>
                            <div></div>
                        </div>
                    </div>
                </div>
            </section>
            <RateModal id={seller.usuario_id} type="user" />
        </>
    );
}
