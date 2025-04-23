import React from "react";
import { Link, useNavigate } from "react-router-dom";

// Components
import {
    LoginIcon,
    RegisterIcon,
    GitHubIcon,
    GoogleIcon,
    FacebookIcon,
} from "../../components/icons";

// Hooks
import { useValidateform } from "../../hooks/useValidateForm";
import { usePostData } from "../../hooks/useFetchData";

export default function Register() {
    const navigate = useNavigate();

    const handleSubmit = async (event) => {
        event.preventDefault();

        const data = Object.fromEntries(new FormData(event.target));
        const validation = useValidateform(data, "register-form");

        if (validation.success) {
            const response = await usePostData("/users", { user: data });

            if (response.success) {
                event.target.reset();
                navigate("/login");
            }
        }
    };

    return (
        <section className="hero bg-base-100 min-h-screen w-full">
            <div className="fixed inset-0 overflow-hidden">
                <div className="absolute bg-purple-700 h-[120%] md:h-[140vh] w-[100%] lg:right-[-50%] rounded-full top-[-10%] lg:top-1/2 transform -translate-y-1/2"></div>
            </div>
            <div className="hero-content flex-col lg:flex-row-reverse lg:[&>*]:w-1/2 [&>*]:w-full max-w-[1200px] w-full px-3 gap-10">
                <div className="text-center lg:text-right text-base-100 space-y-2">
                    <h1 className="text-3xl lg:text-4xl font-bold">¿Ya tienes una cuenta?</h1>
                    <p className="pb-5">
                        Si ya tienes una cuenta puedes iniciar sesión en el siguiente botón.
                    </p>
                    <Link to="/login" className="btn btn-ghost border border-white">
                        <LoginIcon />
                        Inicia sesión
                    </Link>
                </div>

                <div className="card bg-base-100 w-full max-w-[500px] shrink-0 shadow-2xl">
                    <form className="card-body" onSubmit={handleSubmit}>
                        <div className="form-control text-center">
                            <Link to="/">
                                <figure className="size-[120px] mx-auto">
                                    <img
                                        src="/logo.png"
                                        alt="logo express sale"
                                        className="object-contain w-full h-full"
                                    />
                                </figure>
                            </Link>
                            <h2 className="text-2xl font-bold">Regístrate</h2>
                            <p>Crea una nueva cuenta para ser parte de nuestra comunidad.</p>
                        </div>
                        <fieldset className="w-full fieldset">
                            <label className="fieldset-label text-sm after:content-['*'] after:text-red-500">
                                Nombres:
                            </label>
                            <input
                                placeholder="Ingresa tus nombres"
                                className="w-full input focus:input-primary input-bordered focus:outline-0"
                                name="user_name"
                            />
                        </fieldset>
                        <fieldset className="w-full fieldset">
                            <label className="fieldset-label text-sm after:content-['*'] after:text-red-500">
                                Apellidos:
                            </label>
                            <input
                                placeholder="Ingresa tus apellidos"
                                className="w-full input focus:input-primary input-bordered focus:outline-0"
                                name="user_lastname"
                            />
                        </fieldset>
                        <fieldset className="w-full fieldset">
                            <label className="fieldset-label text-sm after:content-['*'] after:text-red-500">
                                Usuario:
                            </label>
                            <input
                                placeholder="Ingresa un alias único"
                                className="w-full input focus:input-primary input-bordered focus:outline-0"
                                name="user_alias"
                            />
                        </fieldset>
                        <fieldset className="w-full fieldset">
                            <label className="fieldset-label text-sm after:content-['*'] after:text-red-500">
                                Correo Electronico:
                            </label>
                            <input
                                placeholder="ejemplo@gmail.com"
                                className="w-full input focus:input-primary input-bordered focus:outline-0"
                                name="user_email"
                            />
                        </fieldset>
                        <fieldset className="w-full fieldset">
                            <label className="fieldset-label text-sm after:content-['*'] after:text-red-500">
                                Rol
                            </label>
                            <select
                                className="w-full select select-bordered focus:outline-0 focus:input-primary text-gray-600"
                                name="role_id"
                            >
                                <option value="">-- Seleccionar --</option>
                                <option value="1">Usuario</option>
                                <option value="2">Vendedor</option>
                                <option value="3">Domiciliario</option>
                            </select>
                        </fieldset>
                        <fieldset className="w-full fieldset">
                            <label className="fieldset-label text-sm after:content-['*'] after:text-red-500">
                                Contraseña:
                            </label>
                            <input
                                type="password"
                                placeholder="******"
                                className="w-full input focus:input-primary input-bordered focus:outline-0"
                                name="user_password"
                            />
                        </fieldset>
                        <fieldset className="fieldset mt-6">
                            <button className="btn btn-primary group relative text-purple-300 hover:bg-purple-800 hover:text-purple-100">
                                <span className="absolute left-3 top-1/2 transform -translate-y-1/2 text-purple-300 group-hover:text-purple-100">
                                    <RegisterIcon size={15} />
                                </span>
                                Regístrate
                            </button>
                        </fieldset>
                        <div className="divider">OR</div>
                        <div className="w-full flex flex-col gap-4">
                            <Link
                                to={import.meta.env.VITE_API_URL + "/auth/google"}
                                type="button"
                                className="btn bg-gray-300 hover:bg-gray-200 text-gray-600 hover:text-gray-700"
                            >
                                <GoogleIcon size={15} />
                                Continua con Google
                            </Link>
                            <Link
                                to={import.meta.env.VITE_API_URL + "/auth/github"}
                                type="button"
                                className="btn bg-gray-700 hover:bg-gray-800 text-gray-300 hover:text-gray-200"
                            >
                                <GitHubIcon size={16} />
                                Continua con GitHub
                            </Link>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    );
}
