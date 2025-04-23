import React from "react";
import { Link, useNavigate, useParams } from "react-router-dom";

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

    const handleResetPasswordSubmit = async (event) => {
        event.preventDefault();

        const data = Object.fromEntries(new FormData(event.target));
        const validation = useValidateform(data, "reset-password-form");

        if (validation.success) {
            const response = await usePutData(`/recoveries/${token}`, {
                ...data,
                user_id: validatedToken.user_id,
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
        });
    }
    return (
        <>
            <main className="w-full px-3 bg-purple-100 min-h-screen">
                <section className="w-full max-w-[1200px] mx-auto py-10">
                    <article className="flex flex-col items-center justify-center w-full gap-6">
                        <Link
                            to="/"
                            className="size-[200px] drop-shadow-[0_15px_30px_rgb(126_34_206)]"
                        >
                            <img
                                src="/logo.png"
                                alt="Logo Express Sale"
                                className="object-contain h-full w-full"
                            />
                        </Link>
                        <div className="card bg-white shadow-xl border border-gray-100 w-full max-w-[700px]">
                            <div className="card-body">
                                <div>
                                    <h2 className="text-4xl font-extrabold tracking-tight">
                                        Cambia tu contraseño:
                                    </h2>
                                    <p>Ingresa tu nueva contraseño dos veces</p>
                                </div>
                                <form onSubmit={handleResetPasswordSubmit} className="space-y-3">
                                    <fieldset className="w-full fieldset">
                                        <label className="fieldset-label">Contraseña:</label>
                                        <input
                                            placeholder="Ingresa tu contraseño"
                                            name="user_password"
                                            type="password"
                                            className="w-full input input-bordered input-sm rounded focus:outline-0 focus:input-primary"
                                        />
                                    </fieldset>
                                    <fieldset className="w-full fieldset">
                                        <label className="fieldset-label">
                                            Confirmar Contraseña:
                                        </label>
                                        <input
                                            placeholder="Ingresa tu contraseño"
                                            name="user_password_confirm"
                                            type="password"
                                            className="w-full input input-bordered input-sm rounded focus:outline-0 focus:input-primary"
                                        />
                                    </fieldset>
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
