import React from "react";
import { useNavigate, useParams } from "react-router-dom";

// Components
import ContentLoading from "@components/contentLoading";

// Hooks
import { useGetData, usePutData } from "@hooks/useFetchData";
import { useValidateform } from "@hooks/useValidateForm";
import Swal from "sweetalert2";

export default function ResetPassword() {
    const { token } = useParams();
    const navigate = useNavigate();

    const { data: validatedToken, loading: validatedTokenLoading } = useGetData(
        `/recoveries/${token}`
    );
    
    console.log(validatedToken);

    const handleResetPasswordSubmit = async (event) => {
        event.preventDefault();

        const data = Object.fromEntries(new FormData(event.target));
        const validation = useValidateform(data, "reset-password-form");

        if (validation.success) {
            const response = await usePutData(`/recoveries/${token}`, {
                ...data,
                usuario_id: validatedToken.usuario_id,
            });

            if (response.success) {
                event.target.reset();

                Swal.fire({
                    icon: "success",
                    title: "Acción exitosa",
                    text: "Se reestableció correctamente tu contraseña",
                }).then(() => {
                    navigate("/login");
                });
            }
        }
    };

    if (validatedTokenLoading) return <ContentLoading />;
    if (!validatedToken) {
        Swal.fire({
            icon: "error",
            title: "Acción fallida",
            text: "El token no es valido o ya caducó.",
        }).then(() => {
            navigate("/login");
        })
    }
    return (
        <>
            <main className="w-full px-3 bg-purple-100 min-h-screen">
                <section className="w-full max-w-[1200px] mx-auto py-10">
                    <article className="flex flex-col items-center justify-center w-full gap-6">
                        <figure className="size-[200px] drop-shadow-[0_15px_30px_rgb(126_34_206)]">
                            <img
                                src="/logo.png"
                                alt="Logo Express Sale"
                                className="object-contain h-full w-full"
                            />
                        </figure>
                        <div className="card bg-white shadow-xl border border-gray-100 w-full max-w-[700px]">
                            <div className="card-body">
                                <div>
                                    <h2 className="text-4xl font-extrabold tracking-tight">
                                        Recupera tu cuenta:
                                    </h2>
                                    <p>Ingresa tu correo para reestablecer tu contraseña</p>
                                </div>
                                <form onSubmit={handleResetPasswordSubmit} className="space-y-3">
                                    <div className="form-control w-full">
                                        <label className="label">
                                            <span className="label-text font-semibold after:content-['*'] after:text-red-500 after:ml-0.5">
                                                Contraseña:
                                            </span>
                                        </label>
                                        <input
                                            placeholder="Ingresa tu contraseño"
                                            name="usuario_contra"
                                            type="password"
                                            className="input input-bordered input-sm rounded w-full focus:outline-0 focus:input-primary"
                                        />
                                    </div>
                                    <div className="form-control w-full">
                                        <label className="label">
                                            <span className="label-text font-semibold after:content-['*'] after:text-red-500 after:ml-0.5">
                                                Confirmar Contraseña:
                                            </span>
                                        </label>
                                        <input
                                            placeholder="Ingresa tu contraseño"
                                            name="usuario_contra_confirm"
                                            type="password"
                                            className="input input-bordered input-sm rounded w-full focus:outline-0 focus:input-primary"
                                        />
                                    </div>
                                    <button type="submit" className="btn btn-primary w-full">
                                        Recuperar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </article>
                </section>
            </main>
        </>
    );
}
