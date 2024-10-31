import { Link, Outlet, useParams } from "react-router-dom";

// Hooks
import { useGetData } from "@hooks/useFetchData.js";

// Components
import ContentLoading from "@components/contentLoading.jsx";
import { BoxesStackedIcon, StatsIcon, ArrowLeftIcon } from "@components/icons.jsx";

export default function WorkerLayout() {
    const { id } = useParams();
    const { data: user, loading: userLoading, reload: reloadUser } = useGetData(`/users/${id}`);

    if (userLoading) return <ContentLoading />;
    return (
        <>
            <div className="drawer drawer-open">
                <input id="my-drawer-2" type="checkbox" className="drawer-toggle" defaultChecked />
                <div className="drawer-content bg-base-100 p-2 pl-0">
                    <main className="w-full h-full bg-white rounded-xl">
                        <Outlet />
                    </main>
                </div>
                <div className="drawer-side">
                    <label
                        htmlFor="my-drawer-2"
                        aria-label="close sidebar"
                        className="drawer-overlay"
                    ></label>
                    <ul className="menu bg-base-100 text-base-content min-h-full w-80 p-4 flex flex-col">
                        {/* Sidebar content here */}
                        <div className="px-4 py-1">
                            <h2 className="text-2xl font-bold tracking-tight">Menu de {user.usuario_nombre}</h2>
                        </div>
                        <div className="grow">
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
                        <div className="px-4 py-1 flex flex-col">
                            <Link to={`/profile/user/${id}`} className="btn btn-sm btn-wide relative">
                                <span className="absolute left-3 top-2">
                                    <ArrowLeftIcon />   
                                </span>
                                Volver
                            </Link>
                        </div>
                    </ul>
                </div>
            </div>
        </>
    );
}
