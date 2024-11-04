import React, { useEffect } from "react";
import { MD5 } from "crypto-js";

// Components
import { RegisterIcon } from "@components/icons.jsx";
import { FormMap } from "@components/map.jsx";
import ContentLoading from "@components/contentLoading.jsx";

// Contexts
import { useAuthContext } from "@contexts/authContext.jsx";

// Hooks
import { useGetData } from "@hooks/useFetchData.js";
import { useValidateform } from "@hooks/useValidateForm.js";

export default function PayForm() {
    const { userSession } = useAuthContext();

    const { data: carts, loading: loadingCarts } = useGetData(
        `/users/${userSession.usuario_id}/carts`
    );

    const handleSubmit = (event) => {
        event.preventDefault();

        const data = Object.fromEntries(new FormData(event.target));
        const validation = useValidateform(data, "pay-form");

        if (validation.success) {
            event.target.submit();
        }
    };

    // PayU config
    const amount = carts && carts.reduce((total, cart) => total + cart.producto_cantidad * cart.product.producto_precio, 0);
    const referenceCode = `compra-${userSession.usuario_id}-${Date.now()}`;
    const signature = MD5(`${import.meta.env.VITE_PAYU_API_KEY}~${import.meta.env.VITE_PAYU_MERCHANT_ID}~${referenceCode}~${amount}~COP`).toString();

    if (loadingCarts) return <ContentLoading />;

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
                            <form
                                onSubmit={handleSubmit}
                                method="POST"
                                action={import.meta.env.VITE_PAYU_REQUEST_URI}
                                className="flex flex-col space-y-4"
                            >
                                <input
                                    name="merchantId"
                                    type="hidden"
                                    value={import.meta.env.VITE_PAYU_MERCHANT_ID}
                                />
                                <input
                                    name="accountId"
                                    type="hidden"
                                    value={import.meta.env.VITE_PAYU_ACCOUNT_ID}
                                />
                                <input name="description" type="hidden" value={`Compra de ${carts.length} productos`} />
                                <input name="referenceCode" type="hidden" value={`${referenceCode}`} />
                                <input name="amount" type="hidden" value={amount} />
                                <input name="tax" type="hidden" value="0" />
                                <input name="taxReturnBase" type="hidden" value="0" />
                                <input name="currency" type="hidden" value="COP" />
                                <input name="shippingCity" type="hidden" value="Bogotá" />
                                <input name="shippingCountry" type="hidden" value="CO" />
                                <input
                                    name="signature"
                                    type="hidden"
                                    value={signature}
                                />
                                <input name="test" type="hidden" value={import.meta.env.VITE_PAYU_TEST_MODE} />
                                <input
                                    name="responseUrl"
                                    type="hidden"
                                    value={`${import.meta.env.VITE_URL}/pay/callback`}
                                />
                                <div className="form-control">
                                    <label className="label">
                                        <span className="label-text font-semibold after:content-['*'] after:ml-1 after:text-red-500">
                                            Nombre Completo:
                                        </span>
                                    </label>
                                    <input
                                        name="buyerFullName"
                                        placeholder="Ingresa todos tus nombres y apellidos"
                                        className="input input-bordered input-sm focus:outline-0 focus:input-primary"
                                        defaultValue={`${userSession.usuario_nombre} ${userSession.usuario_apellido}`}
                                    />
                                </div>

                                <div className="form-control">
                                    <label className="label">
                                        <span className="label-text font-semibold after:content-['*'] after:ml-1 after:text-red-500">
                                            Correo Electrónico:
                                        </span>
                                    </label>
                                    <input
                                        name="buyerEmail"
                                        placeholder="ejemplo@gmail.com"
                                        className="input input-bordered input-sm focus:outline-0 focus:input-primary"
                                        defaultValue={userSession.usuario_correo}
                                    />
                                </div>

                                <div className="form-control">
                                    <label className="label">
                                        <span className="label-text font-semibold after:content-['*'] after:ml-1 after:text-red-500">
                                            Numero Telefónico:
                                        </span>
                                    </label>
                                    <input
                                        name="payerPhone"
                                        placeholder="Ingresa tu telefono de contacto"
                                        className="input input-bordered input-sm focus:outline-0 focus:input-primary"
                                        defaultValue={userSession.usuario_telefono}
                                    />
                                </div>

                                <div className="form-group w-full flex flex-col md:flex-row gap-5">
                                    <div className="form-control w-full md:w-fit">
                                        <label className="label">
                                            <span className="label-text font-semibold after:content-['*'] after:ml-1 after:text-red-500">
                                                Tipo de documento:
                                            </span>
                                        </label>
                                        <select
                                            name="payerDocumentType"
                                            className="select select-bordered select-sm focus:outline-0 focus:select-primary"
                                        >
                                            <option value="CC">Cédula de Ciudadanía</option>
                                            <option value="CE">Cédula de Extranjería</option>
                                            <option value="TI">Tarjeta de Identidad</option>
                                            <option value="PPN">Pasaporte</option>
                                            <option value="NIT">
                                                Número de Identificación Tributaria
                                            </option>
                                            <option value="SSN">Social Security Number</option>
                                            <option value="EIN">
                                                Employer Identification Number
                                            </option>
                                        </select>
                                    </div>
                                    <div className="form-control w-full">
                                        <label className="label">
                                            <span className="label-text font-semibold after:content-['*'] after:ml-1 after:text-red-500">
                                                Número de documento:
                                            </span>
                                        </label>
                                        <input
                                            name="payerDocument"
                                            placeholder="Ingresa tu documento"
                                            className="input input-bordered input-sm focus:outline-0 focus:input-primary"
                                        />
                                    </div>
                                </div>

                                <FormMap />

                                <div className="form-control">
                                    <button
                                        type="submit"
                                        className="btn btn-primary btn-sm w-full mx-auto relative"
                                    >
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
