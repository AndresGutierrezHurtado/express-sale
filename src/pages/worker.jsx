import { useState, useEffect } from "react";
import { useParams } from "react-router-dom";

// Hooks
import { useGetData } from "../hooks/useFetchData";

// Components
import ContentLoading from "../components/contentLoading";
import { StarIcon } from "../components/icons";

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
                                        <div className="flex flex-col items-center justify-center w-fit text-gray-500">
                                            <StarIcon size={50} />
                                            <h2 className="font-semibold text-xl text-center">
                                                {seller.calificacion_promedio}
                                            </h2>
                                        </div>
                                        <div>
                                            <p>
                                                1:{" "}
                                                {
                                                    seller.ratings.filter(
                                                        (rating) =>
                                                            rating.calificacion ===
                                                            1
                                                    ).length
                                                }
                                            </p>
                                            <p>
                                                2:{" "}
                                                {
                                                    seller.ratings.filter(
                                                        (rating) =>
                                                            rating.calificacion ===
                                                            2
                                                    ).length
                                                }
                                            </p>
                                            <p>
                                                3:{" "}
                                                {
                                                    seller.ratings.filter(
                                                        (rating) =>
                                                            rating.calificacion ===
                                                            3
                                                    ).length
                                                }
                                            </p>
                                            <p>
                                                4:{" "}
                                                {
                                                    seller.ratings.filter(
                                                        (rating) =>
                                                            rating.calificacion ===
                                                            4
                                                    ).length
                                                }
                                            </p>
                                            <p>
                                                5:{" "}
                                                {
                                                    seller.ratings.filter(
                                                        (rating) =>
                                                            rating.calificacion ===
                                                            5
                                                    ).length
                                                }
                                            </p>
                                        </div>
                                    </div>
                                    <div className="flex gap-2">
                                        <button className="btn btn-sm min-h-none h-auto py-3 px-8 btn-primary group relative text-purple-300 hover:bg-purple-800 hover:text-purple-100">
                                            <span className="absolute left-3 top-1/2 transform -translate-y-1/2 text-purple-300 group-hover:text-purple-100">
                                                +
                                            </span>
                                            Calificar
                                        </button>
                                        <button className="btn btn-sm min-h-none h-auto py-3 btn-primary group relative text-purple-300 hover:bg-purple-800 hover:text-purple-100 grow">
                                            <span className="absolute left-3 top-1/2 transform -translate-y-1/2 text-purple-300 group-hover:text-purple-100">
                                                +
                                            </span>
                                            Ver calificaciones
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </article>
                        <div>
                            <h2>Comentarios</h2>
                        </div>
                    </div>
                    <div>
                        <h2></h2>
                        <div></div>
                    </div>
                </div>
            </div>
        </section>
    );
}
