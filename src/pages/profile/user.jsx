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
} from "@components/icons.jsx";
import { UserEditModal } from "@components/profile/userEditModal.jsx";
import ContentLoading from "@components/contentLoading.jsx";

// Contexts
import { useAuthContext } from "@contexts/authContext.jsx";

// Hooks
import { useGetData } from "@hooks/useFetchData.js";

export default function UserProfile() {
    const { id } = useParams();
    const { userSession, loading } = useAuthContext();

    const {
        loading: loadingUser,
        data: user,
        reload: reloadUser,
    } = !loading && useGetData(`/users/${id || userSession.usuario_id}`);

    const {
        loading: loadingOrders,
        data: orders,
        reload: reloadOrders,
    } = useGetData(`/users/${id || userSession.usuario_id}/orders`);

    if ((loadingUser, loadingRatings, loadingOrders)) return <ContentLoading />;

    return (
        <>
            <section className="w-full px-3">
                <div className="w-full max-w-[1200px] mx-auto py-5 space-y-5">
                    <h3 className="text-4xl font-extrabold">
                        {user.usuario_id == userSession.usuario_id
                            ? "Mi perfil"
                            : "Perfil de usuario"}
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
                                <img src={user.usuario_imagen_url} />
                            </div>
                        </div>
                        <article className="flex flex-col justify-between gap-2 h-[initial] w-full">
                            <div className="w-full">
                                <div className="flex justify-between items-center w-full">
                                    <h3 className="text-3xl font-bold">
                                        {user.usuario_nombre} {user.usuario_apellido}
                                    </h3>
                                    <p className="text-sm text-gray-600">
                                        Cuenta creada en el{" "}
                                        {new Date(user.usuario_creacion).toLocaleDateString()}
                                    </p>
                                </div>
                                <p className="text-lg italic text-gray-600">
                                    @{user.usuario_alias} ({user.role ? user.role.rol_nombre : ""})
                                </p>
                            </div>
                            <p className="text-lg grow">
                                {user.worker ? user.worker.trabajador_descripcion : ""}
                            </p>
                            <span className="flex flex-wrap items-center gap-4 [&_svg]:fill-gray-600 text-gray-600 w-full overflow-hidden">
                                {user.worker && (
                                    <>
                                        <Link to={`/worker/${user.usuario_id}`}>
                                            <div
                                                data-tip={`Perfil de ${user.role.rol_nombre}`}
                                                className="tooltip tooltip-bottom flex badge badge-sm gap-1 h-auto py-1 px-5 duration-300 hover:scale-[1.06]"
                                            >
                                                <UserIcon size={11} />
                                                Ver perfil
                                            </div>
                                        </Link>
                                        <div
                                            data-tip={`Calificaciones recibidas como ${user.role.rol_nombre}`}
                                            className="tooltip tooltip-bottom flex badge badge-sm gap-1 h-auto py-1 px-5 duration-300 hover:scale-[1.06]"
                                        >
                                            <StarIcon size={12} />
                                            {user.calificacion_cantidad} Calificaciones
                                        </div>
                                    </>
                                )}

                                <Link to={`mailto:${user.usuario_correo}`} target="_blank">
                                    <div
                                        data-tip="Correo electronico de contacto"
                                        className="tooltip tooltip-bottom flex badge badge-sm gap-1 h-auto py-1 px-5 duration-300 hover:scale-[1.06]"
                                    >
                                        <EmailIcon size={14} />
                                        {user.usuario_correo}
                                    </div>
                                </Link>
                                {user.usuario_telefono && (
                                    <div
                                        data-tip="Numero de contacto"
                                        className="tooltip tooltip-bottom flex badge badge-sm gap-1 h-auto py-1 px-5 duration-300 hover:scale-[1.06]"
                                    >
                                        <PhoneIcon size={14} />
                                        {user.usuario_telefono}
                                    </div>
                                )}
                                <div
                                    data-tip="Cantidad total de compras hechas"
                                    className="tooltip tooltip-bottom flex badge badge-sm gap-1 h-auto py-1 px-5 duration-300 hover:scale-[1.06]"
                                >
                                    <BoxesStackedIcon size={14} />
                                    {orders && orders.length} compras hechas
                                </div>
                            </span>
                            <div className="flex flex-col sm:flex-row gap-4 items-center py-1">
                                {userSession.rol_id == 2 && (
                                    <Link
                                        to={`/worker/products/${user.usuario_id}`}
                                        className="btn btn-sm min-h-none h-auto py-2.5 px-10 btn-primary group relative text-purple-300 hover:bg-purple-800 hover:text-purple-100"
                                    >
                                        <span className="absolute left-3 top-1/2 transform -translate-y-1/2 text-purple-300 group-hover:text-purple-100">
                                            <BoxesStackedIcon size={14} />
                                        </span>
                                        Productos
                                    </Link>
                                )}
                                {userSession.rol_id == 3 && (
                                    <Link
                                        to={`/worker/routes/${user.usuario_id}`}
                                        className="btn btn-sm min-h-none h-auto py-2.5 px-10 btn-primary group relative text-purple-300 hover:bg-purple-800 hover:text-purple-100"
                                    >
                                        <span className="absolute left-3 top-1/2 transform -translate-y-1/2 text-purple-300 group-hover:text-purple-100">
                                            +
                                        </span>
                                        Rutas
                                    </Link>
                                )}
                                {userSession.rol_id == 4 && (
                                    <Link
                                        to={`/admin/users`}
                                        className="btn btn-sm min-h-none h-auto py-2.5 px-10 btn-primary group relative text-purple-300 hover:bg-purple-800 hover:text-purple-100"
                                    >
                                        <span className="absolute left-3 top-1/2 transform -translate-y-1/2 text-purple-300 group-hover:text-purple-100">
                                            +
                                        </span>
                                        Administrador
                                    </Link>
                                )}
                                {userSession.rol_id !== 4 && userSession.rol_id !== 1 && (
                                    <Link
                                        to={`/worker/stats/${user.usuario_id}`}
                                        className="btn btn-sm min-h-none h-auto py-2.5 px-10 relative bg-gray-200 hover:bg-gray-200 text-gray-500 hover:text-gray-600"
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
            {/* <section className="w-full px-3">
                <div className="w-full max-w-[1200px] mx-auto py-10">
                    <div className="space-y-5">
                        <h3 className="text-4xl font-extrabold">
                            {user.usuario_id == userSession.usuario_id
                                ? "Mis compras"
                                : "Compras del usuario"}
                        </h3>
                        <div className=" shadow-lg rounded-lg border bg-white overflow-hidden divide-y divide-gray-200 px-5 py-3 ">
                                <table className="table">
                                    <thead>
                                        <tr>
                                            <th className="text-center">Fecha</th>
                                            <th className="text-center">Productos</th>
                                            <th className="text-center">Precio</th>
                                            <th className="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {orders.map((order) => (
                                            <tr key={order.order_id}>
                                                <td className="text-center">
                                                    {order.pedido_id}
                                                </td>
                                                <td className="text-center">
                                                    {order.pedido_fecha}
                                                </td>
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                        </div>
                    </div>
                </div>
            </section> */}
            <UserEditModal user={user} reload={reloadUser} />
        </>
    );
}
