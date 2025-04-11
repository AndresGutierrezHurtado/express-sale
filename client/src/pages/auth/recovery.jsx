import React from "react";

// Hooks
import { useValidateform } from "@hooks/useValidateForm";
import { usePostData } from "@hooks/useFetchData";
import Swal from "sweetalert2";

export default function Recovery() {
    const handleResetPasswordSubmit = async (event) => {
        event.preventDefault();

        const data = Object.fromEntries(new FormData(event.target));
        const validation = useValidateform(data, "recovery-form");

        if (validation.success) {
            const response = await usePostData("/recoveries", data);

            if (response.success) {
                event.target.reset();

                Swal.fire({
                    icon: "success",
                    title: "Acción exitosa",
                    text: "Se envio un correo para reestablecer tu contraseña",
                }).then(() => {
                    window.location.href = "/login";
                    return;
                });
            }
        }
    };

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
                                <form onSubmit={handleResetPasswordSubmit}>
                                    <div className="form-control">
                                        <label className="label">
                                            <span className="label-text font-semibold after:content-['*'] after:text-red-500 after:ml-0.5">
                                                Correo:
                                            </span>
                                        </label>
                                        <input
                                            name="user_email"
                                            placeholder="ejemplo@gmail.com"
                                            className="input input-bordered input-sm focus:outline-0 focus:border-primary"
                                        />
                                    </div>
                                    <div className="form-control mt-6">
                                        <button className="btn btn-primary">
                                            Reestablecer contraseña
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </article>
                </section>
            </main>
        </>
    );
}
