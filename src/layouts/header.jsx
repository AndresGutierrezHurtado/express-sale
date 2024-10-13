import { Link, useLocation } from "react-router-dom";

// Contexts
import { useAuthContext } from "../context/authContext";

// Icons
import { MenuIcon, SearchIcon, ShoppingBagIcon } from "../components/icons";

export default function Header() {
    const { pathname, hash } = useLocation();
    const { userSession, handleLogout } = useAuthContext();

    document.addEventListener("scroll", () => {
        if (document.querySelector(".navbar") === null) return;
        if (window.scrollY > 0)
            document.querySelector(".navbar").classList.add("bg-black/10");
        else document.querySelector(".navbar").classList.remove("bg-black/10");
    });

    return (
        <div className="drawer sticky top-0 z-50">
            <input
                id="drawer-toggle"
                type="checkbox"
                className="drawer-toggle"
            />
            <div className="drawer-content flex flex-col">
                {/* Navbar */}
                <div className="w-full px-3">
                    <div className="w-full max-w-[1200px] mx-auto py-3">
                        <div className="navbar rounded-full backdrop-blur-sm duration-300 py-[2px] px-3 md:px-7 min-h-[50px]">
                            <div className="flex-none lg:hidden">
                                <label
                                    htmlFor="drawer-toggle"
                                    aria-label="open sidebar"
                                    className="btn btn-square btn-ghost"
                                >
                                    <MenuIcon size={23} />
                                </label>
                            </div>
                            <div className="navbar-start">
                                <Link
                                    to="/"
                                    className="btn btn-sm h-auto min-h-auto btn-ghost p-1 text-xl"
                                >
                                    <img
                                        src="/logo.png"
                                        alt="logo express sale"
                                        className="object-contain w-full h-[35px]"
                                    />
                                </Link>
                            </div>
                            <div className="navbar-center hidden lg:flex text-purple-700">
                                <ul className="flex items-center gap-5 px-1 text-[1.05rem]">
                                    <li
                                        className={`font-medium duration-300 ${
                                            pathname + hash === "/"
                                                ? "border-b-2 border-purple-700"
                                                : "hover:scale-[1.1]"
                                        }`}
                                    >
                                        <Link to="/">Inicio</Link>
                                    </li>
                                    <li
                                        className={`font-medium duration-300 ${
                                            pathname + hash === "/products"
                                                ? "border-b-2 border-purple-700"
                                                : "hover:scale-[1.1]"
                                        }`}
                                    >
                                        <Link to="/products">Productos</Link>
                                    </li>
                                    <li
                                        className={`font-medium duration-300 ${
                                            pathname + hash === "/#contact"
                                                ? "border-b-2 border-purple-700"
                                                : "hover:scale-[1.1]"
                                        }`}
                                    >
                                        <Link to="/#contact">Contacto</Link>
                                    </li>
                                </ul>
                            </div>
                            <div className="navbar-end [&_svg]:text-purple-700">
                                <button className="btn btn-ghost btn-circle">
                                    <SearchIcon size={23} />
                                </button>
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
                                <button className="btn btn-ghost btn-circle">
                                    <ShoppingBagIcon size={25} />
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div className="drawer-side">
                <label
                    htmlFor="drawer-toggle"
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
