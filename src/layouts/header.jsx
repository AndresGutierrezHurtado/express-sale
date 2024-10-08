import { Link } from "react-router-dom";
import { IoSearch as Search, IoMenu as Menu } from "react-icons/io5";
import { MdOutlineShoppingBag as ShoppingBag } from "react-icons/md";

// Contexts
import { useAuthContext } from "../context/authContext";

export default function Header() {
    const { userSession } = useAuthContext();
    return (
        <div className="drawer">
            <input id="my-drawer-3" type="checkbox" className="drawer-toggle" />
            <div className="drawer-content flex flex-col">
                {/* Navbar */}
                <div className="w-full max-w-[1200px] mx-auto bg-base-100">
                    <div className="navbar">
                        <div className="flex-none lg:hidden">
                            <label
                                htmlFor="my-drawer-3"
                                aria-label="open sidebar"
                                className="btn btn-square btn-ghost"
                            >
                                <Menu size={23} />
                            </label>
                        </div>
                        <div className="navbar-start">
                            <Link to="/" className="btn btn-ghost text-xl">
                                <img
                                    src="/logo.png"
                                    alt="logo express sale"
                                    className="object-contain w-full h-full"
                                />
                            </Link>
                        </div>
                        <div className="navbar-center hidden lg:flex text-purple-700">
                            <ul className="menu menu-horizontal px-1 text-[1.05rem]">
                                <li>
                                    <Link to="/">Inicio</Link>
                                </li>
                                <li>
                                    <Link to="/products">Productos</Link>
                                </li>
                                <li>
                                    <Link to="/#contact">Contacto</Link>
                                </li>
                            </ul>
                        </div>
                        <div className="navbar-end gap-2 [&_svg]:text-purple-700">
                            <button className="btn btn-ghost btn-circle">
                                <Search size={25} />
                            </button>
                            <div className="dropdown dropdown-end">
                                <div
                                    tabIndex="0"
                                    role="button"
                                    className="btn btn-ghost btn-circle avatar"
                                >
                                    <div className="w-10 rounded-full">
                                        <img
                                            alt="Tailwind CSS Navbar component"
                                            src={userSession ? userSession.usuario_imagen_url : "/images/users/default.jpg"}
                                        />
                                    </div>
                                </div>
                                <ul
                                    tabIndex="0"
                                    className="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 p-2 shadow"
                                >
                                    {
                                        userSession ? (
                                            <>
                                                <li>
                                                    <Link to="/user/profile">Perfil</Link>
                                                </li>
                                                <li>
                                                    <a>Cerrar sesión</a>
                                                </li>
                                            </>

                                        ) : (
                                            <>
                                                <li>
                                                    <Link to="/login">Iniciar sesión</Link>
                                                </li>
                                                <li>
                                                    <Link to="/register">Registrarse</Link>
                                                </li>
                                            </>

                                        )
                                    }
                                </ul>
                            </div>
                            <button className="btn btn-ghost btn-circle">
                                <ShoppingBag size={27} />
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div className="drawer-side">
                <label
                    htmlFor="my-drawer-3"
                    aria-label="close sidebar"
                    className="drawer-overlay"
                ></label>
                <ul className="menu bg-base-200 min-h-full w-80 p-4">
                    {/* Sidebar content here */}
                    <li>
                        <Link to="/">Inicio</Link>
                    </li>
                    <li>
                        <Link to="/products">Productos</Link>
                    </li>
                    <li>
                        <Link to="/#contact">Contacto</Link>
                    </li>
                </ul>
            </div>
        </div>
    );
}
