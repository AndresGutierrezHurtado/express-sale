import React from "react";

export default function DeliveryStats({ user }) {
    return (
        <main className="h-full w-full p-10">
            <div className="flex flex-col md:flex-row gap-10">
                <div className="card bg-white border shadow border-gray-100">
                    <div className="card-body gap-10">
                        <article>
                            <h2 className="text-4xl font-extrabold tracking-tight ">
                                Estadísticas de {user.usuario_nombre.split(" ")[0]}{" "}
                                {user.usuario_apellido.split(" ")[0]}:{" "}
                            </h2>
                            <div className="flex gap-5">
                                <p>
                                    Selecciona el año para ver las estadísticas de envios de cada
                                    mes.
                                </p>
                                <select
                                    defaultValue={"0"}
                                    className="select select-bordered select-sm w=full focus:outline-0 focus:select-primary"
                                >
                                    <option value="0" disabled>
                                        Año
                                    </option>
                                    <option value={new Date().getFullYear()}>
                                        {new Date().getFullYear()}
                                    </option>
                                    <option value={new Date().getFullYear() - 1}>
                                        {new Date().getFullYear() - 1}
                                    </option>
                                    <option value={new Date().getFullYear() - 2}>
                                        {new Date().getFullYear() - 2}
                                    </option>
                                    <option value={new Date().getFullYear() - 3}>
                                        {new Date().getFullYear() - 3}
                                    </option>
                                </select>
                            </div>
                        </article>
                        <article>
                            <canvas className="skeleton h-[300px] w-full"></canvas>
                            <div className="flex">
                                <div className="w-full">Numero Ventas</div>
                                <div className="w-full">Dinero Ventas</div>
                            </div>
                        </article>
                    </div>
                </div>
                <div>
                    <h2>retirar</h2>
                    <button>Retirar</button>
                </div>
            </div>
            <div>
                <div className="card"></div>
                <div className="card"></div>
                <div className="card"></div>
            </div>
        </main>
    );
}
