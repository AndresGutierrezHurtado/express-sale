import { useState, useEffect } from "react";
import { useParams } from "react-router-dom";

// Hooks
import { useGetData } from "@hooks/useFetchData";

// Components
import { EyeIcon, PlusIcon, StarIcon, UserIcon } from "@components/icons.jsx";
import { Calification } from "@components/calification.jsx";
import Product from "@components/productCard.jsx";
import ContentLoading from "@components/contentLoading.jsx";
import RateModal from "@components/rateModal.jsx";

export default function Worker() {
    const [seller, setSeller] = useState(null);
    const [loading, setLoading] = useState(true);
    const { id } = useParams();

    const getSeller = async () => {
        if (!loading) return null;
        const user = await useGetData(`/api/users/${id}`);
        setLoading(false);
        if (user.success) {
            setSeller(user.data);
        }
    };

    useEffect(() => {
        getSeller();
    }, [loading]);

    if (!seller) return <ContentLoading />;

    return (
        <>
            <section className="w-full px-3">
                <div className="w-full max-w-[1200px] mx-auto py-10">
                    <div className="flex flex-col md:flex-row gap-10">
                        <div className="w-full max-w-[500px] space-y-5">
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
                                        <div className="grow flex flex-col sm:flex-row items-center justify-center gap-5">
                                            <div className="flex flex-col items-center justify-center w-fit text-gray-600 space-y-1">
                                                <h2 className="font-semibold text-4xl text-center">
                                                    {
                                                        seller.calificacion_promedio
                                                    }
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
                                                                width: `${
                                                                    (seller.ratings.filter(
                                                                        (
                                                                            rating
                                                                        ) =>
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
                                                                width: `${
                                                                    (seller.ratings.filter(
                                                                        (
                                                                            rating
                                                                        ) =>
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
                                                                width: `${
                                                                    (seller.ratings.filter(
                                                                        (
                                                                            rating
                                                                        ) =>
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
                                                                width: `${
                                                                    (seller.ratings.filter(
                                                                        (
                                                                            rating
                                                                        ) =>
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
                                                                width: `${
                                                                    (seller.ratings.filter(
                                                                        (
                                                                            rating
                                                                        ) =>
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
                                        <div className="flex flex-col md:flex-row gap-2">
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
                            <div className="card bg-base-100 shadow-xl border">
                                <div className="card-body space-y-5">
                                    <h2 className="text-3xl font-extrabold text-gray-800">
                                        Comentarios:
                                    </h2>
                                    <div className="space-y-4">
                                        {seller.ratings.length < 1 && (
                                            <h2 className="text-lg font-semibold">
                                                No hay calificaciones...
                                            </h2>
                                        )}
                                        {seller.ratings.map((rating) => {
                                            return (
                                                <Calification
                                                    rating={rating}
                                                    key={rating.calificacion_id}
                                                    setLoading={setLoading}
                                                />
                                            );
                                        })}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div className="space-y-4">
                            <h2 className="font-bold text-4xl">Productos: </h2>
                            <div className="space-y-8">
                                {seller.products.map((product) => (
                                    <Product
                                        key={product.producto_id}
                                        product={product}
                                    />
                                ))}
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <RateModal id={seller.usuario_id} type="user" />
        </>
    );
}
