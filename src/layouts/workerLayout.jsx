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
                <div className="drawer-content bg-gray-200 p-4 pl-0 h-screen overflow-y-hidden">
                    <main className="w-full h-full bg-white rounded-xl h-full overflow-y-auto">
                        <Outlet user={user} />
                    </main>
                </div>
                <div className="drawer-side">
                    <label
                        htmlFor="my-drawer-2"
                        aria-label="close sidebar"
                        className="drawer-overlay"
                    ></label>
                    <ul className="menu bg-gray-200 text-base-content min-h-full w-[100px] md:w-80 p-4 flex flex-col gap-5">
                        {/* Sidebar content here */}
                        <div className="md:px-4 py-1 flex flex-col items-center justify-center">
                            <Link to="/" className="w-12 md:w-24 aspect-square">
                                <img
                                    src="/logo.png"
                                    alt="Logo Express Sale"
                                    className="w-full h-full object-contain"
                                />
                            </Link>
                            <h2 className="text-2xl font-bold tracking-tight hidden md:block">
                                Menu de {user.usuario_nombre}
                            </h2>
                        </div>
                        <div className="grow space-y-2 w-fit md:w-full mx-auto">
                            <li className="w-fit md:w-full">
                                <Link to={`/worker/stats/${id}`}>
                                    <StatsIcon />
                                    <span className="hidden md:block">Estadísticas</span>
                                </Link>
                            </li>
                            {user.rol_id == 2 ? (
                                <li className="w-fit md:w-full">
                                    <Link to={`/worker/products/${id}`}>
                                        <BoxesStackedIcon />
                                        <span className="hidden md:block">Productos</span>
                                    </Link>
                                </li>
                            ) : (
                                <li className="w-fit w-full">
                                    <Link to={`/worker/deliveries/${id}`}>
                                        <StatsIcon />
                                        <span className="hidden md:block">Envios</span>
                                    </Link>
                                </li>
                            )}
                        </div>
                        <div className="px-4 py-1 flex flex-col space-y-3">
                            {user.rol_id == 2 && (
                                <button
                                    onClick={() =>
                                        document.getElementById("product-create-modal").show()
                                    }
                                    className="btn btn-sm w-fit pl-5 md:w-full relative btn-primary mx-auto"
                                >
                                    <span className="absolute left-3 top-2">+</span>
                                    <span className="hidden md:block">Crear producto</span>
                                </button>
                            )}
                            <Link to={`/profile/user/${id}`} className="w-full">
                                <article
                                    className="w-fit md:w-full flex p-3 gap-3 bg-gray-100 rounded-lg tooltip tooltip-top text-start"
                                    data-tip="Ir al perfil"
                                >
                                    <figure className="w-8 md:w-12 aspect-square rounded-full overflow-hidden flex-none">
                                        <img
                                            src={user.usuario_imagen_url}
                                            alt="imagen de perfil del usuario"
                                            className="w-full h-full object-cover"
                                        />
                                    </figure>
                                    <div className="leading-none hidden md:block">
                                        <h2 className="font-semibold tracking-tight">
                                            {user.usuario_nombre} {user.usuario_apellido}
                                        </h2>
                                        <p className="text-sm text-gray-600 font-semibold">
                                            {user.role.rol_nombre}
                                        </p>
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
