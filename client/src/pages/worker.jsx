import { useState, useEffect } from "react";
import { useParams, useSearchParams } from "react-router-dom";

// Hooks
import { useGetData } from "@hooks/useFetchData";

// Components
import { EyeIcon, PlusIcon, StarIcon, UserIcon } from "@components/icons.jsx";
import { Calification } from "@components/calification.jsx";
import Product from "@components/productCard.jsx";
import ContentLoading from "@components/contentLoading.jsx";
import RateModal from "@components/rateModal.jsx";
import Pagination from "@components/pagination.jsx";
import { StarsRating } from "../components/starsRating";

export default function Worker() {
    const { id } = useParams();
    const [searchParams, setSearchParams] = useSearchParams();
    const {
        loading: loadingSeller,
        data: seller,
        reload: reloadSeller,
    } = useGetData(`/users/${id}`);
    const {
        loading: loadingProducts,
        data: products,
        reload: reloadProducts,
    } = useGetData(`/users/${id}/products`);
    const {
        loading: loadingRatings,
        data: ratings,
        reload: reloadRatings,
    } = useGetData(`/users/${id}/ratings`);

    const reload = () => {
        reloadSeller();
        reloadProducts();
        reloadRatings();
    };

    const updateParam = (key, value) => {
        const newSearchParams = new URLSearchParams(searchParams);
        newSearchParams.set(key, value);
        setSearchParams(newSearchParams);
    };

    const handleShowRatings = () => {
        document.getElementById("ratings-list").classList.toggle("hidden");
    };

    if (loadingSeller || loadingProducts || loadingRatings) return <ContentLoading />;
    return (
        <>
            <section className="w-full px-3">
                <div className="w-full max-w-[1200px] mx-auto py-10">
                    <div className={`flex flex-col md:flex-row gap-10 ${seller.role_id == 3 && "items-center justify-center"}`}>
                        <div className={"w-full max-w-[500px] flex flex-col gap-5"}>
                            <article className="card bg-base-100 shadow-xl border">
                                <div className="card-body flex flex-col gap-4">
                                    <div className="flex flex-col md:flex-row gap-5">
                                        <figure className="w-full max-w-[140px] aspect-square rounded-lg">
                                            <img
                                                src={seller.user_image_url}
                                                alt={`Imagen del ${seller.role.role_name} ${seller.user_alias}`}
                                                className="object-cover w-full h-full"
                                            />
                                        </figure>
                                        <div className="grow space-y-2 h-[initial] flex flex-col">
                                            <div>
                                                <h2 className="text-xl font-bold">
                                                    {seller.user_name}{" "}
                                                    {seller.user_lastname}
                                                </h2>
                                                <p className="text-gray-600/90 text-sm italic">
                                                    @{seller.user_alias} (
                                                    {seller.role.role_name})
                                                </p>
                                                <p className="text-gray-600/90 text-sm leading-none">
                                                    {seller.role_id == 2
                                                        ? `${seller.ventas_cantidad} productos vendidos.`
                                                        : seller.role_id == 3 && `${seller.envios_cantidad} envios hechos.`}
                                                </p>
                                            </div>
                                            <p className="text-pretty text-lg grow">
                                                {seller.worker.worker_description}
                                            </p>
                                        </div>
                                    </div>
                                    <div className="flex flex-col gap-4">
                                        <div className="grow flex flex-col sm:flex-row items-center justify-center gap-5">
                                            <div className="flex flex-col items-center justify-center w-fit text-gray-600 space-y-1">
                                                <h2 className="font-semibold text-4xl text-center">
                                                    {seller.average_rating}
                                                </h2>
                                                <StarsRating
                                                    rating={parseFloat(
                                                        seller.average_rating
                                                    )}
                                                />
                                                <p className="text-sm flex gap-1 items-center">
                                                    {ratings.length}
                                                    <UserIcon size={12} />
                                                </p>
                                            </div>
                                            <div className="w-full">
                                                <div className="flex items-center gap-2">
                                                    5
                                                    <progress
                                                        className="progress progress-primary w-full"
                                                        value={
                                                            (ratings.filter(
                                                                (rating) => rating.calificacion == 5
                                                            ).length /
                                                                ratings.length) *
                                                                100 || 0
                                                        }
                                                        max="100"
                                                    ></progress>
                                                </div>
                                                <div className="flex items-center gap-2">
                                                    4
                                                    <progress
                                                        className="progress progress-primary w-full"
                                                        value={
                                                            (ratings.filter(
                                                                (rating) => rating.calificacion == 4
                                                            ).length /
                                                                ratings.length) *
                                                                100 || 0
                                                        }
                                                        max="100"
                                                    ></progress>
                                                </div>
                                                <div className="flex items-center gap-2">
                                                    3
                                                    <progress
                                                        className="progress progress-primary w-full"
                                                        value={
                                                            (ratings.filter(
                                                                (rating) => rating.calificacion == 3
                                                            ).length /
                                                                ratings.length) *
                                                                100 || 0
                                                        }
                                                        max="100"
                                                    ></progress>
                                                </div>
                                                <div className="flex items-center gap-2">
                                                    2
                                                    <progress
                                                        className="progress progress-primary w-full"
                                                        value={
                                                            (ratings.filter(
                                                                (rating) => rating.calificacion == 2
                                                            ).length /
                                                                ratings.length) *
                                                                100 || 0
                                                        }
                                                        max="100"
                                                    ></progress>
                                                </div>
                                                <div className="flex items-center gap-2">
                                                    1
                                                    <progress
                                                        className="progress progress-primary w-full"
                                                        value={
                                                            (ratings.filter(
                                                                (rating) => rating.calificacion == 1
                                                            ).length /
                                                                ratings.length) *
                                                                100 || 0
                                                        }
                                                        max="100"
                                                    ></progress>
                                                </div>
                                            </div>
                                        </div>
                                        <div className="flex flex-col md:flex-row gap-2">
                                            <button
                                                onClick={() => {
                                                    document
                                                        .getElementById(
                                                            "user-modal-" + seller.user_id
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
                                            <button
                                                onClick={handleShowRatings}
                                                className="btn btn-sm min-h-none h-auto py-3 px-9 btn-primary group relative text-purple-300 hover:bg-purple-800 hover:text-purple-100 grow"
                                            >
                                                <span className="absolute left-3 top-1/2 transform -translate-y-1/2 text-purple-300 group-hover:text-purple-100">
                                                    <EyeIcon size={20} />
                                                </span>
                                                Ver calificaciones
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </article>
                            <div
                                id="ratings-list"
                                className="card bg-base-100 shadow-xl border hidden"
                            >
                                <div className="card-body space-y-5">
                                    <h2 className="text-3xl font-extrabold text-gray-800">
                                        Comentarios:
                                    </h2>
                                    <div className="space-y-4">
                                        {ratings.length < 1 && (
                                            <h2 className="text-lg font-semibold">
                                                No hay calificaciones...
                                            </h2>
                                        )}
                                        {ratings.map((rating) => {
                                            return (
                                                <Calification
                                                    rating={rating}
                                                    key={rating.rating_id}
                                                    reload={reload}
                                                />
                                            );
                                        })}
                                    </div>
                                </div>
                            </div>
                        </div>
                        {seller.role_id == 2 && (
                            <div className="space-y-4">
                                <h2 className="font-bold text-4xl">Productos: </h2>
                                <div className="space-y-8">
                                    {products.rows.map((product) => (
                                        <Product
                                            key={product.product_id}
                                            product={product}
                                            reloadProducts={reload}
                                        />
                                    ))}
                                </div>
                                <span className="flex justify-between items-center w-full">
                                    <Pagination
                                        data={products}
                                        updateParam={updateParam}
                                        searchParams={searchParams}
                                    />
                                </span>
                            </div>
                        )}
                    </div>
                </div>
            </section>
            <RateModal id={seller.user_id} reload={reload} type="user" />
        </>
    );
}
