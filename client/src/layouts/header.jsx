import React, { useEffect, useRef } from "react";
import { Link } from "react-router-dom";

// Icons
import {
    MenuIcon,
    SearchIcon,
    ShoppingBagIcon,
} from "@components/icons";

// Contexts
import { useAuthContext } from "@contexts/authContext";

export default function Header() {
    const { userSession, handleLogout } = useAuthContext();
    const headerRef = useRef(null);
    const searchModalRef = useRef(null);

    useEffect(() => {
        document.addEventListener("scroll", () => {
            if (headerRef === null) return;

            const classes = ["bg-base-200/30", "border", "shadow-lg", "px-4"];
            if (window.scrollY > 0) headerRef.current.classList.add(...classes);
            else headerRef.current.classList.remove(...classes);
        });
    }, []);

    return (
        <>
            <header className="w-full px-3 sticky top-0 z-50">
                <div className="w-full max-w-[1200px] mx-auto py-5">
                    <div
                        ref={headerRef}
                        className="navbar backdrop-blur-lg rounded-full duration-300 border-base-300"
                    >
                        <div className="navbar-start">
                            <Link to="/" className="tooltip tooltip-right" data-tip="Ir al Inicio">
                                <img
                                    src="/logo.png"
                                    alt="logo express sale"
                                    className="object-contain w-full h-[40px]"
                                />
                            </Link>
                        </div>
                        <div className="navbar-center">
                            {/* Menu */}
                            <ul className="text-xl gap-5 items-center hidden md:flex">
                                <li className="hover:text-primary hover:scale-105 duration-300 font-medium">
                                    <Link to="/">Inicio</Link>
                                </li>
                                <li className="hover:text-primary hover:scale-105 duration-300 font-medium">
                                    <Link to="/products">Productos</Link>
                                </li>
                                <li className="hover:text-primary hover:scale-105 duration-300 font-medium">
                                    <Link to="/#contact">Contacto</Link>
                                </li>
                            </ul>
                            {/* Mobile Menu */}
                            <div className="dropdown dropdown-center">
                                <div
                                    tabIndex={0}
                                    role="button"
                                    className="btn btn-ghost btn-circle md:hidden"
                                >
                                    <MenuIcon size={23} />
                                </div>
                                <ul
                                    tabIndex={0}
                                    className="menu menu-sm dropdown-content bg-base-100 rounded-box z-1 mt-3 w-52 p-2 shadow"
                                >
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
                        <div className="navbar-end gap-2">
                            {/* Search Button */}
                            <button
                                type="button"
                                onClick={() => searchModalRef.current.showModal()}
                                class="btn btn-ghost btn-circle"
                            >
                                <SearchIcon size={23} />
                            </button>
                            {/* Profile Button */}
                            <div class="dropdown dropdown-end">
                                <div
                                    tabindex="0"
                                    role="button"
                                    class="btn btn-ghost btn-circle avatar"
                                >
                                    <div class="w-10 rounded-full">
                                        <img
                                            alt="Tailwind CSS Navbar component"
                                            src={userSession?.user_image || "/images/default.jpg"}
                                        />
                                    </div>
                                </div>
                                <ul
                                    tabindex="0"
                                    class="menu menu-sm dropdown-content bg-base-100 rounded-box z-1 mt-3 w-52 p-2 shadow"
                                >
                                    {userSession ? (
                                        <>
                                            <li>
                                                <a class="justify-between">
                                                    Profile
                                                    <span class="badge">New</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a>Settings</a>
                                            </li>
                                            <li>
                                                <a>Logout</a>
                                            </li>
                                        </>
                                    ) : (
                                        <>
                                            <li>
                                                <Link to="/login">Inicio de Sesión</Link>
                                            </li>
                                            <li>
                                                <Link to="/register">Regístrate</Link>
                                            </li>
                                        </>
                                    )}
                                </ul>
                            </div>
                            {/* Cart Button */}
                            {userSession && (
                                <Link to="/cart" class="btn btn-ghost btn-circle">
                                    <ShoppingBagIcon size={25} />
                                </Link>
                            )}
                        </div>
                    </div>
                </div>
            </header>
            <HeaderSearchModal reference={searchModalRef} />
        </>
    );
}

function HeaderSearchModal({ reference }) {
    const handleSearch = (e) => {
        e.preventDefault();
        const search = e.target.search.value;
        window.location.href = `/products?search=${search}`;
        reference.current.close();
    };

    return (
        <dialog
            ref={reference}
            id="search-modal"
            className="modal flex items-start justify-center py-12"
        >
            <div className="modal-box w-full max-w-[800px] shadow-none bg-transparent">
                <div className="w-full flex flex-col gap-5">
                    <div className="flex gap-5">
                        <form
                            className="w-full flex items-center justify-between"
                            onSubmit={handleSearch}
                        >
                            <label
                                htmlFor="search-modal"
                                className="w-full flex items-center justify-bewteen input focus-within:outline-none focus-within:border focus-within:border-primary rounded overflow-hidden"
                            >
                                <button type="submit" className="btn btn-sm btn-ghost">
                                    <SearchIcon size={20} />
                                </button>
                                <input
                                    id="search-modal"
                                    name="search"
                                    placeholder="Buscar productos..."
                                    className="input input-sm input-ghost focus:border-0 focus:outline-none grow"
                                />
                                <p className="font-medium hidden sm:block text-sm">
                                    {"Search by "}
                                    <span className="text-purple-700">Andrés Gutiérrez</span>
                                </p>
                            </label>
                        </form>
                        <div className="modal-action m-[0_!important]">
                            <form method="dialog">
                                <button className="btn bg-white/70 backdrop-blur-sm text-black font-semibold text-lg">
                                    Esc
                                </button>
                            </form>
                        </div>
                    </div>
                    <div className="w-full bg-base-100 p-5 rounded-lg space-y-5">
                        <h2 className="text-xl font-bold tracking-tight text-base-content/80">
                            Busquedas populares:
                        </h2>
                        <div className="flex flex-wrap gap-2">
                            {["xbox", "iphone", "zapatillas"].map((category) => (
                                <a
                                    onClick={() => {
                                        document.getElementById("search-modal").close();
                                        navigate(`/products?search=${category}`);
                                    }}
                                    key={category}
                                    className="badge badge-ghost badge-lg px-5 py-1 cursor-pointer border border-base-300 bg-base-200/60 hover:bg-base-200 capitalize font-medium"
                                >
                                    {category}
                                </a>
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
    );
}
