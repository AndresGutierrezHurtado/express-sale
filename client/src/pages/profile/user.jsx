import React, { useState } from "react";
import { useParams, Link } from "react-router-dom";

// Components
import {
    PencilIcon,
    UserIcon,
    StarIcon,
    EmailIcon,
    PhoneIcon,
    BoxesStackedIcon,
    StatsIcon,
    TruckIcon,
} from "@components/icons.jsx";
import { UserEditModal } from "@components/profile/userEditModal.jsx";
import { Order } from "@components/order.jsx";
import ContentLoading from "@components/contentLoading.jsx";

// Contexts
import { useAuthContext } from "@contexts/authContext.jsx";

// Hooks
import { useGetData } from "@hooks/useFetchData.js";

export default function UserProfile() {
    const { id } = useParams();
    const { userSession, loading } = useAuthContext();
    const [ordersType, setOrdersType] = useState(null);

    const {
        loading: loadingUser,
        data: user,
        reload: reloadUser,
    } = !loading && useGetData(`/users/${id || userSession.user_id}`);

    const {
        loading: loadingOrders,
        data: orders,
        reload: reloadOrders,
    } = useGetData(`/users/${id || userSession.user_id}/orders`);

    if (loadingUser || loadingOrders) return <ContentLoading />;
    return (
        <>
            <section className="w-full px-3">
                <div className="w-full max-w-[1200px] mx-auto py-5 space-y-5">
                    <h3 className="text-4xl font-extrabold">
                        {user.user_id == userSession.user_id ? "Mi perfil" : "Perfil de usuario"}
                    </h3>
                    <div className="flex flex-col md:flex-row gap-5">
                        <div className="avatar relative mx-auto md:m-0">
                            <div
                                onClick={() => document.getElementById("user-edit-modal").show()}
                                className="bg-white absolute bottom-[7%] right-[7%] p-[2px] border-0 w-8 rounded-full aspect-square cursor-pointer hover:scale-110 duration-300"
                            >
                                <div className="w-full h-full bg-purple-700 rounded-full [&_svg]:fill-white flex items-center justify-center">
                                    <PencilIcon size={20} />
                                </div>
                            </div>

                            <div className="w-[230px] rounded-full">
                                <img src={user.user_image_url} />
                            </div>
                        </div>
                        <article className="flex flex-col justify-between gap-2 h-[initial] w-full">
                            <div className="w-full">
                                <div className="flex flex-col sm:flex-row justify-between items-start sm:items-center w-full">
                                    <h3 className="text-2xl md:text-3xl font-bold">
                                        {user.user_name} {user.user_lastname}
                                    </h3>
                                    <p className="text-sm text-gray-600">
                                        Cuenta creada en el{" "}
                                        {new Date(user.user_date).toLocaleDateString()}{" "}
                                        <span className="hidden lg:inline">
                                            a las {new Date(user.user_date).toLocaleTimeString()}
                                        </span>
                                    </p>
                                </div>
                                <p className="text-lg italic text-gray-600">
                                    @{user.user_alias} ({user.role ? user.role.role_name : ""})
                                </p>
                            </div>
                            <p className="text-lg grow">
                                {user.worker ? user.worker.worker_description : ""}
                            </p>
                            <span className="flex flex-wrap items-center gap-2 [&_svg]:fill-gray-600 text-gray-600 w-full">
                                {user.worker && (
                                    <>
                                        <Link to={`/worker/${user.user_id}`}>
                                            <div
                                                data-tip={`Perfil de ${user.role.role_name}`}
                                                className="tooltip tooltip-bottom flex badge badge-sm gap-1 h-auto py-1 px-5 duration-300 cursor-pointer"
                                            >
                                                <UserIcon size={11} />
                                                Ver perfil
                                            </div>
                                        </Link>
                                        <div
                                            data-tip={`Calificaciones recibidas como ${user.role.role_name}`}
                                            className="tooltip tooltip-bottom flex badge badge-sm gap-1 h-auto py-1 px-5 duration-300 cursor-pointer"
                                        >
                                            <StarIcon size={12} />
                                            {user.ratings_count} Calificaciones
                                        </div>
                                    </>
                                )}

                                <Link to={`mailto:${user.user_email}`} target="_blank">
                                    <div
                                        data-tip="Correo electronico de contacto"
                                        className="tooltip tooltip-bottom flex badge badge-sm gap-1 h-auto py-1 px-5 duration-300 cursor-pointer"
                                    >
                                        <EmailIcon size={14} />
                                        {user.user_email}
                                    </div>
                                </Link>
                                {user.user_phone && (
                                    <div
                                        data-tip="Número de contacto"
                                        className="tooltip tooltip-bottom flex badge badge-sm gap-1 h-auto py-1 px-5 duration-300 cursor-pointer"
                                    >
                                        <PhoneIcon size={14} />
                                        {user.user_phone}
                                    </div>
                                )}
                                <div
                                    data-tip="Cantidad total de compras hechas"
                                    className="tooltip tooltip-bottom flex badge badge-sm gap-1 h-auto py-1 px-5 duration-300 cursor-pointer"
                                >
                                    <BoxesStackedIcon size={14} />
                                    {orders && orders.length} compras hechas
                                </div>
                            </span>
                            <div className="flex flex-col sm:flex-row gap-4 items-center py-1">
                                {userSession.role_id == 2 && (
                                    <Link
                                        to={`/worker/products/${user.user_id}`}
                                        className="btn btn-primary pl-10 pr-5 relative group text-purple-300 hover:bg-purple-800 hover:text-purple-100"
                                    >
                                        <span className="absolute left-3 top-1/2 transform -translate-y-1/2 text-purple-300 group-hover:text-purple-100">
                                            <BoxesStackedIcon size={14} />
                                        </span>
                                        Productos
                                    </Link>
                                )}
                                {userSession.role_id == 3 && (
                                    <Link
                                        to={`/worker/deliveries/${user.user_id}`}
                                        className="btn btn-primary pl-10 pr-5 relative group text-purple-300 hover:bg-purple-800 hover:text-purple-100"
                                    >
                                        <span className="absolute left-3 top-1/2 transform -translate-y-1/2 text-purple-300 group-hover:text-purple-100">
                                            <TruckIcon />
                                        </span>
                                        Rutas
                                    </Link>
                                )}
                                {userSession.role_id == 4 && (
                                    <Link
                                        to={`/admin/users`}
                                        className="btn btn-primary pl-10 pr-5 relative group text-purple-300 hover:bg-purple-800 hover:text-purple-100"
                                    >
                                        <span className="absolute left-3 top-1/2 transform -translate-y-1/2 text-purple-300 group-hover:text-purple-100">
                                            +
                                        </span>
                                        Administrador
                                    </Link>
                                )}
                                {userSession.role_id !== 4 && userSession.role_id !== 1 && (
                                    <Link
                                        to={`/worker/stats/${user.user_id}`}
                                        className="btn pl-10 pr-5 relative group text-gray-500 hover:text-gray-600 bg-gray-200"
                                    >
                                        <span className="absolute left-3 top-1/2 transform -translate-y-1/2">
                                            <StatsIcon size={15} />
                                        </span>
                                        Estadísticas
                                    </Link>
                                )}
                            </div>
                        </article>
                    </div>
                </div>
            </section>
            <section className="w-full px-3">
                <div className="w-full max-w-[1200px] mx-auto py-10">
                    <div className="space-y-5">
                        <h3 className="text-4xl font-extrabold tracking-tight">
                            {user.user_id == userSession.user_id
                                ? "Mis compras"
                                : "Compras del usuario"}
                        </h3>

                        <div className="flex flex-wrap gap-5 [&>div]:cursor-pointer">
                            <div
                                onClick={() => setOrdersType(null)}
                                className={`badge badge-lg ${!ordersType && "badge-primary"}`}
                            >
                                Todas
                            </div>
                            <div
                                onClick={() => setOrdersType("pendiente")}
                                className={`badge badge-lg ${
                                    ordersType == "pendiente" && "badge-primary"
                                }`}
                            >
                                Pendientes
                            </div>
                            <div
                                onClick={() => setOrdersType("enviando")}
                                className={`badge badge-lg ${
                                    ordersType == "enviando" && "badge-primary"
                                }`}
                            >
                                Enviando
                            </div>
                            <div
                                onClick={() => setOrdersType("entregado")}
                                className={`badge badge-lg ${
                                    ordersType == "entregado" && "badge-primary"
                                }`}
                            >
                                Entregadas
                            </div>
                            <div
                                onClick={() => setOrdersType("recibido")}
                                className={`badge badge-lg ${
                                    ordersType == "recibido" && "badge-primary"
                                }`}
                            >
                                Recibidas
                            </div>
                        </div>

                        <div className="grid grid-cols-[repeat(auto-fit,minmax(300px,1fr))] gap-5">
                            {orders.length == 0 && (
                                <h2 className="text-xl font-semibold tracking-tight">
                                    No hay pedidos...
                                </h2>
                            )}
                            {ordersType
                                ? orders
                                      .filter((order) => order.order_status == ordersType)
                                      .map((order) => {
                                          return <Order order={order} key={order.order_id} />;
                                      })
                                : orders.map((order) => {
                                      return <Order order={order} key={order.order_id} />;
                                  })}
                        </div>
                    </div>
                </div>
            </section>
            <UserEditModal user={user} reload={reloadUser} />
        </>
    );
}
