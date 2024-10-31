import { Link, useLocation } from "react-router-dom";

// Contexts
import { useAuthContext } from "@contexts/authContext";

// Icons
import {
    EmailIcon,
    HomeIcon,
    MenuIcon,
    SearchIcon,
    ShopIcon,
    ShoppingBagIcon,
} from "@components/icons";

export default function Header() {
    const { pathname, hash } = useLocation();
    const { userSession, handleLogout } = useAuthContext();

    document.addEventListener("scroll", () => {
        if (document.querySelector(".navbar") === null) return;
        if (window.scrollY > 0) document.querySelector(".navbar").classList.add("bg-black/10");
        else document.querySelector(".navbar").classList.remove("bg-black/10");
    });

    return (
        <>
            <div className="drawer sticky top-0 z-50">
                <input id="drawer-toggle" type="checkbox" className="drawer-toggle" />
                <div className="drawer-content flex flex-col">
                    {/* Navbar */}
                    <header className="w-full px-3">
                        <section className="w-full max-w-[1200px] mx-auto py-3">
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
                                    <button
                                        className="btn btn-ghost btn-circle"
                                        onClick={() =>
                                            document.getElementById("search-modal").show()
                                        }
                                    >
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
                                                            : "/images/default.jpg"
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
                                                        <Link to="/profile/user/">Perfil</Link>
                                                    </li>
                                                    <li onClick={handleLogout}>
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
                                            )}
                                        </ul>
                                    </div>
                                    <button className="btn btn-ghost btn-circle">
                                        <ShoppingBagIcon size={25} />
                                    </button>
                                </div>
                            </div>
                        </section>
                    </header>
                </div>
                <div className="drawer-side">
                    <label
                        htmlFor="drawer-toggle"
                        aria-label="close sidebar"
                        className="drawer-overlay"
                    ></label>
                    <ul className="menu bg-base-200 min-h-full w-80 p-4 flex flex-col">
                        {/* Sidebar content here */}
                        <div className="grow">
                            <li>
                                <Link to="/">
                                    <HomeIcon />
                                    Inicio
                                </Link>
                            </li>
                            <li>
                                <Link to="/products">
                                    <ShopIcon />
                                    Productos
                                </Link>
                            </li>
                            <li>
                                <Link to="/#contact">
                                    <EmailIcon />
                                    Contacto
                                </Link>
                            </li>
                        </div>
                        <label htmlFor="drawer-toggle">
                            <li>
                                <a>
                                    <span>✕</span>
                                    Cerrar
                                </a>
                            </li>
                        </label>
                    </ul>
                </div>
            </div>
            <dialog id="search-modal" className="modal flex items-start justify-center py-12">
                <div className="modal-box w-full max-w-[800px] shadow-none bg-transparent">
                    <div className="w-full flex flex-col gap-5">
                        <div className="flex gap-5">
                            <form
                                method="get"
                                action="/products"
                                className="w-full flex items-center justify-between"
                            >
                                <label
                                    htmlFor="search-modal"
                                    className="w-full input rounded flex items-center justify-bewteen"
                                >
                                    <button type="submit" className="btn btn-sm btn-ghost">
                                        <SearchIcon />
                                    </button>
                                    <input
                                        id="search-modal"
                                        name="search"
                                        placeholder="Buscar productos..."
                                        className="input input-sm input-ghost focus:border-0 grow"
                                    />
                                    <p className="font-medium text-sm">
                                        Search by{" "}
                                        <span className="text-purple-700">Andrés Gutiérrez</span>
                                    </p>
                                </label>
                            </form>
                            <div className="modal-action m-0">
                                <form method="dialog">
                                    <button className="btn bg-white/70 backdrop-blur-sm text-black font-semibold text-lg">
                                        Esc
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div className="w-full bg-white/70 backdrop-blur-sm text-black font-semibold p-8 rounded-lg space-y-5">
                            <h2 className="text-xl font-bold tracking-tight text-gray-500">
                                Busquedas populares:
                            </h2>
                            <div className="flex flex-wrap gap-2">
                                {["xbox", "iphone", "zapatillas"].map((category) => (
                                    <Link
                                        key={category}
                                        to={`/products?search=${category}`}
                                        className="badge badge-ghost badge-lg px-5 py-1 bg-white/70"
                                    >
                                        {category}
                                    </Link>
                                ))}
                            </div>
                        </div>
                    </div>
                </div>
                <form
                    method="dialog"
                    className="modal-backdrop fixed inset-0 backdrop-blur-sm bg-black/30"
                >
                    <button>close</button>
                </form>
            </dialog>
        </>
    );
}
