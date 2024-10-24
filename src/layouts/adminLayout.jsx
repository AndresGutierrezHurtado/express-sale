import React from "react";
import { Link, Outlet, useNavigate } from "react-router-dom";

// Contexts
import { useAuthContext } from "@contexts/authContext.jsx";

export default function AdminLayout() {
    const navigate = useNavigate();
    const { userSession, handleLogout } = useAuthContext();
    if (userSession.rol_id !== 4) navigate("/");
    return (
        <>
            <div className="drawer drawer-open">
                <input
                    id="my-drawer"
                    type="checkbox"
                    className="drawer-toggle"
                    defaultChecked
                />
                <div className="drawer-side">
                    <label
                        htmlFor="my-drawer"
                        aria-label="close sidebar"
                        className="drawer-overlay"
                    ></label>
                    <ul className="menu bg-base-200 text-base-content min-h-full w-80 p-4">
                        <li>
                            <Link to="/users/admin">Usuarios</Link>
                        </li>
                        <li>
                            <Link to="/users/products">Productos</Link>
                        </li>
                    </ul>
                </div>
                <main className="drawer-content">
                    <header className="p-3" data-theme="dark">
                        <nav className="flex justify-between items-center w-full">
                            <div className="flex gap-4">
                                <button className="btn btn-circle btn-sm btn-ghost">
                                    O
                                </button>
                                <form action="" className="flex gap-2">
                                    <input
                                        name=""
                                        className="input input-bordered input-sm rounded-full"
                                        data-theme="light"
                                    />
                                    <button className="btn btn-circle btn-sm btn-ghost">
                                        O
                                    </button>
                                </form>
                            </div>
                            <div>
                                <div className="dropdown dropdown-end">
                                    <div
                                        tabIndex="0"
                                        role="button"
                                        className="btn btn-ghost btn-circle avatar"
                                    >
                                        <div className="w-8 rounded-full">
                                            <img
                                                alt="Tailwind CSS Navbar component"
                                                src={
                                                    userSession
                                                        ? userSession.usuario_imagen_url
                                                        : "/images/users/default.jpg"
                                                }
                                            />
                                        </div>
                                    </div>
                                    <ul
                                        tabIndex="0"
                                        className="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 p-2 shadow"
                                        data-theme="light"
                                    >
                                        {userSession ? (
                                            <>
                                                <li>
                                                    <Link to="/profile/user/">
                                                        Perfil
                                                    </Link>
                                                </li>
                                                <li onClick={handleLogout}>
                                                    <a>Cerrar sesión</a>
                                                </li>
                                            </>
                                        ) : (
                                            <>
                                                <li>
                                                    <Link to="/login">
                                                        Iniciar sesión
                                                    </Link>
                                                </li>
                                                <li>
                                                    <Link to="/register">
                                                        Registrarse
                                                    </Link>
                                                </li>
                                            </>
                                        )}
                                    </ul>
                                </div>
                            </div>
                        </nav>
                    </header>
                    <p></p>
                    <div>
                        <table></table>
                        <nav></nav>
                    </div>
                    <footer></footer>
                </main>
            </div>
        </>
    );
}
