import { Link, Outlet, useParams } from "react-router-dom";
import { ToastContainer } from "react-toastify";

// Hooks
import { useGetData } from "@hooks/useFetchData.js";

// Components
import ContentLoading from "@components/contentLoading.jsx";
import { BoxesStackedIcon, StatsIcon, ArrowLeftIcon } from "@components/icons.jsx";
import ProductCreateModal from "../components/profile/productCreateModal";

export default function WorkerLayout() {
    const { id } = useParams();
    const { data: user, loading: userLoading, reload: reloadUser } = useGetData(`/users/${id}`);

    if (userLoading) return <ContentLoading />;
    return (
        <>
            <div className="drawer drawer-open">
                <input id="my-drawer-2" type="checkbox" className="drawer-toggle" defaultChecked />
                <div className="drawer-content bg-gray-200 p-4 pl-0">
                    <main className="w-full h-full bg-white rounded-xl">
                        <Outlet user={user} />
                    </main>
                </div>
                <div className="drawer-side">
                    <label
                        htmlFor="my-drawer-2"
                        aria-label="close sidebar"
                        className="drawer-overlay"
                    ></label>
                    <ul className="menu bg-gray-200 text-base-content min-h-full w-80 p-4 flex flex-col gap-5">
                        {/* Sidebar content here */}
                        <div className="px-4 py-1 flex flex-col items-center justify-center">
                            <Link to="/" className="w-24 aspect-square">
                                <img src="/logo.png" alt="Logo Express Sale" className="w-full h-full object-contain" />
                            </Link>
                            <h2 className="text-2xl font-bold tracking-tight">
                                Menu de {user.usuario_nombre}
                            </h2>
                        </div>
                        <div className="grow space-y-2">
                            <li>
                                <Link to={`/worker/stats/${id}`}>
                                    <StatsIcon />
                                    Estadísticas
                                </Link>
                            </li>
                            {user.rol_id == 2 ? (
                                <li>
                                    <Link to={`/worker/products/${id}`}>
                                        <BoxesStackedIcon />
                                        Productos
                                    </Link>
                                </li>
                            ) : (
                                <li>
                                    <Link to={`/worker/deliveries/${id}`}>
                                        <StatsIcon />
                                        Envios
                                    </Link>
                                </li>
                            )}
                        </div>
                        <div className="px-4 py-1 flex flex-col space-y-3">
                            <button
                                onClick={() =>
                                    document.getElementById("product-create-modal").show()
                                }
                                className="btn btn-sm btn-wide relative btn-primary"
                            >
                                <span className="absolute left-3 top-2">+</span>
                                Crear producto
                            </button>
                            <Link to={`/profile/user/${id}`} className="w-full">
                                <article className="w-full flex p-3 gap-3 bg-gray-100 rounded-lg tooltip tooltip-top text-start" data-tip="Ir al perfil">
                                    <figure className="w-12 aspect-square rounded-full overflow-hidden flex-none">
                                        <img
                                            src={user.usuario_imagen_url}
                                            alt="imagen de perfil del usuario"
                                            className="w-full h-full object-cover"
                                        />
                                    </figure>
                                    <div className="leading-none">
                                        <h2 className="font-semibold tracking-tight">
                                            {user.usuario_nombre} {user.usuario_apellido}
                                        </h2>
                                        <p className="text-sm text-gray-600 font-semibold">{user.role.rol_nombre}</p>
                                    </div>
                                </article>
                            </Link>
                        </div>
                    </ul>
                </div>
            </div>
            <ProductCreateModal reload={reloadUser} />
            <ToastContainer />
        </>
    );
}
