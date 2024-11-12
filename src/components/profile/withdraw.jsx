import React from "react";

import { BillIcon } from "../icons.jsx";

export default function Withdraw() {
    return (
        <>
            <article className="card bg-white border shadow-lg border-gray-100 w-full max-w-lg mx-auto">
                <div className="card-body gap-5">
                    <div className="text-center">
                        <p className="text-gray-600">Saldo actual</p>
                        <div className="text-5xl font-extrabold">1000 COP</div>
                        <div className="text-sm text-gray-600">5 retiros disponibles</div>
                        <div className="divider"></div>
                        <div className="space-y-2">
                            <p>
                                <span
                                    className="font-bold text-violet-600 hover:underline cursor-pointer"
                                    onClick={() =>
                                        document.getElementById("history-modal").showModal()
                                    }
                                >
                                    Ver historial de retiros
                                </span>
                                , <br /> Se actualiza cada 2 minutos aproximadamente
                            </p>
                            <div>
                                <button
                                    onClick={() =>
                                        document.getElementById("withdraw-modal").showModal()
                                    }
                                    className="btn btn-success text-white rounded-full px-10"
                                >
                                    <BillIcon size={20} />
                                    Retirar ahora
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </article>

            {/* Withdraws Modal History */}
            <dialog id="history-modal" className="modal">
                <div className="modal-box">
                    <h3 className="font-bold text-lg">Historial Ingresos/Retiros</h3>
                    <p className="py-4">presiona la tecla ESC o haz clic fuera del modal</p>
                    <table className="table border">
                        <thead className="bg-gray-200">
                            <tr>
                                <th>Fecha</th>
                                <th>Monto</th>
                                <th>Tipo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>2023-01-01, 10:00 PM</td>
                                <td>500 COP</td>
                                <td>Ingreso</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <form method="dialog" className="modal-backdrop">
                    <button>close</button>
                </form>
            </dialog>

            {/* Withdraw Modal */}
            <dialog id="withdraw-modal" className="modal">
                <div className="modal-box space-y-4">
                    <div>
                        <h3 className="font-bold text-lg">Retirar:</h3>
                        <p className="text-pretty">
                            Ingresa la cantidad de dinero deseada que no supere el monto de tu
                            cuenta
                        </p>
                    </div>
                    <form>
                        <div className="form-control">
                            <label className="label">
                                <span className="label-text font-semibold after:content-['*'] after:text-red-500 after:ml-0.5">
                                    Monto a retirar:
                                </span>
                            </label>
                            <input
                                type="number"
                                placeholder={`Monto a retirar (min: 10.000, max: 10.000.000)`}
                                className="input input-bordered focus:outline-0 focus:input-primary"
                            />
                        </div>
                        <div className="modal-action">
                            <button type="button" className="btn btn-primary w-full btn-sm">
                                Retirar
                            </button>
                        </div>
                    </form>
                </div>
                <form method="dialog" className="modal-backdrop">
                    <button>close</button>
                </form>
            </dialog>
        </>
    );
}
