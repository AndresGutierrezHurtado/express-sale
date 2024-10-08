import React from "react";
import { Link } from "react-router-dom";
import { TbLogin2 as LoginIcon } from "react-icons/tb";
import { FaArrowUpFromBracket as RegisterIcon } from "react-icons/fa6";
import { useValidateform } from "../../hooks/useValidateForm";

export default function Login() {
    const handleSubmit = (event) => {
        event.preventDefault();

        let data = Object.fromEntries(new FormData(event.target));

        const response = useValidateform(data, "login-form");

        if (response.success) {
            data = response.data;
        }
    };

    return (
        <section className="hero bg-base-100 min-h-screen w-full">
            <div className="fixed inset-0 overflow-hidden">
                <div className="absolute bg-purple-700 h-[120%] md:h-[140vh] w-[100%] lg:left-[-50%] rounded-full top-[-10%] lg:top-1/2 transform -translate-y-1/2"></div>
            </div>
            <div className="hero-content flex-col lg:flex-row lg:[&>*]:w-1/2 [&>*]:w-full max-w-[1200px] w-full px-3 gap-10">
                <div className="text-center lg:text-left text-base-100 space-y-2">
                    <h1 className="text-3xl lg:text-4xl font-bold">
                        ¿No tienes cuenta aún?
                    </h1>
                    <p className="pb-5">
                        Si no te has creado tu cuenta puedes registrar en el
                        siguiente botón.
                    </p>
                    <Link
                        to="/register"
                        className="btn btn-ghost border border-white"
                    >
                        <RegisterIcon />
                        Registrate
                    </Link>
                </div>

                <div className="card bg-base-100 w-full max-w-[500px] shrink-0 shadow-2xl">
                    <form className="card-body" onSubmit={handleSubmit}>
                        <div className="form-control text-center">
                            <figure className="size-[120px] mx-auto">
                                <img
                                    src="/logo.png"
                                    alt="logo express sale"
                                    className="object-contain w-full h-full"
                                />
                            </figure>
                            <h2 className="text-2xl font-bold">
                                Inicia sesión
                            </h2>
                            <p>
                                Ingresa tus credenciales para poder acceder a
                                todas las funcionalidades.
                            </p>
                        </div>
                        <div className="form-control">
                            <label className="label">
                                <span className="label-text font-medium after:content-['*'] after:ml-0.5 after:text-red-500">
                                    Correo Electronico:
                                </span>
                            </label>
                            <input
                                placeholder="ejemplo@gmail.com"
                                className="input focus:input-primary input-bordered focus:outline-0"
                                name="usuario_correo"
                            />
                        </div>
                        <div className="form-control">
                            <label className="label">
                                <span className="label-text font-medium after:content-['*'] after:ml-0.5 after:text-red-500">
                                    Contraseña:
                                </span>
                            </label>
                            <input
                                type="password"
                                placeholder="******"
                                className="input focus:input-primary input-bordered focus:outline-0"
                                name="usuario_contra"
                            />
                        </div>
                        <label className="label">
                            <span className="label-text-alt">
                                ¿Olvidaste tu contraseña?,{" "}
                                <Link to="/reset-password" className="link">
                                    Click Aquí
                                </Link>
                            </span>
                        </label>
                        <div className="form-control mt-2">
                            <button className="btn btn-primary group relative text-purple-300 hover:bg-purple-800 hover:text-purple-100">
                                <span className="absolute left-3 top-1/2 transform -translate-y-1/2 text-purple-300 group-hover:text-purple-100">
                                    <LoginIcon size={20} />
                                </span>
                                Iniciar sesión
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    );
}
