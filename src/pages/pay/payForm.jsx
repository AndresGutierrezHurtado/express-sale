import React from "react";

// Components
import { RegisterIcon } from "@components/icons.jsx";

export default function PayForm() {
    const handleSubmit = (event) => {
        event.preventDefault();

        const data = Object.fromEntries(new FormData(event.target));
        console.log(data);
    };
    return (
        <>
            <section className="w-full px-3">
                <div className="w-full max-w-[1200px] mx-auto py-10">
                    <div className="card bg-white border shadow-xl max-w-xl mx-auto">
                        <div className="card-body">
                            <h2 className="text-4xl font-extrabold tracking-tight">
                                Formulario de pago:
                            </h2>
                            <p>
                                Llena la siguiente información obligatoria para proceder con el pago
                                de tu pedido mediante{" "}
                                <a
                                    href="https://colombia.payu.com/"
                                    target="_blank"
                                    className="text-primary font-semibold underline"
                                >
                                    Payu
                                </a>
                            </p>
                            <form onSubmit={handleSubmit} method="POST" action={import.meta.env.VITE_PAYU_REQUEST_URI} className="flex flex-col space-y-4">
                                <div className="form-control">
                                    <label className="label">
                                        <span className="label-text font-semibold after:content-['*'] after:ml-1 after:text-red-500">
                                            Nombre Completo:
                                        </span>
                                    </label>
                                    <input
                                        name="buyerFullName"
                                        placeholder="ejemplo@gmail.com"
                                        className="input input-bordered input-sm focus:outline-0 focus:input-primary"
                                    />
                                </div>
                                <div className="form-control">
                                    <label className="label">
                                        <span className="label-text font-semibold after:content-['*'] after:ml-1 after:text-red-500">
                                            Nombre Completo:
                                        </span>
                                    </label>
                                    <input
                                        name="buyerFullName"
                                        placeholder="ejemplo@gmail.com"
                                        className="input input-bordered input-sm focus:outline-0 focus:input-primary"
                                    />
                                </div>
                                <div className="form-control">
                                    <button type="submit" className="btn btn-primary btn-sm w-full mx-auto relative">
                                        <span className="absolute left-3 top-2">
                                            <RegisterIcon />
                                        </span>
                                        Ir al pago
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </>
    );
}
