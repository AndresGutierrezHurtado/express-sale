import React, { useState } from "react";

import { SellerGraphic } from "./graphic";
import Withdraw from "./withdraw";

export default function SellerStats({ user }) {
    const [graphicData, setGraphicData] = useState("all");
    const [currentMonth, setCurrentMonth] = useState(null);
    const [year, setYear] = useState("2024");

    const yearSales = [];
    for (let i = 1; i <= 12; i++) {
        let infoMes =
            user.worker.ventas_mensuales.find(
                (el) => el.mes == i && el.anio == (year ? year : new Date().getFullYear())
            ) || null;
        yearSales.push({
            month: i,
            monthToText: new Date(0, i - 1).toLocaleString("es", { month: "long" }),
            money: infoMes ? parseInt(infoMes.dinero_ventas) : 0,
            sales: infoMes ? infoMes.total_productos : 0,
            year: infoMes ? infoMes.anio : parseInt(year),
        });
    }

    return (
        <main className="h-full w-full p-10 space-y-10">
            <div className="flex flex-col md:flex-row gap-10">
                <div className="card bg-white border shadow-lg border-gray-100 w-full max-w-[750px]">
                    <div className="card-body gap-5">
                        <article className="space-y-2">
                            <h2 className="text-4xl font-extrabold tracking-tight ">
                                Estadísticas de {user.usuario_nombre.split(" ")[0]}{" "}
                                {user.usuario_apellido.split(" ")[0]}:{" "}
                            </h2>
                            <div className="flex items-center gap-5">
                                <p className="leading-tight text-sm">
                                    Selecciona el año para ver las estadísticas de ventas de cada
                                    mes.
                                </p>
                                <select
                                    value={graphicData}
                                    onChange={(event) => setGraphicData(event.target.value)}
                                    className="select select-bordered select-sm w=full focus:outline-0 focus:select-primary"
                                >
                                    <option value="all">Todo</option>
                                    <option value="money">Dinero recaudado</option>
                                    <option value="sales">Numero de ventas</option>
                                </select>
                                <select
                                    value={year}
                                    onChange={(event) => setYear(event.target.value)}
                                    className="select select-bordered select-sm w=full focus:outline-0 focus:select-primary"
                                >
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
                            <SellerGraphic
                                data={yearSales}
                                graphicData={graphicData}
                                setCurrentMonth={setCurrentMonth}
                            />
                            <div className="flex [&>*]:grow text-center">
                                <div className="stats bg-transparent">
                                    <div className="stat">
                                        <div className="stat-title">
                                            Numero de ventas realizadas
                                        </div>
                                        <div className="stat-value">
                                            {currentMonth ? currentMonth.sales : "Pendiente"}
                                        </div>
                                        <div className="stat-desc">
                                            {currentMonth
                                                ? `En el mes ${currentMonth.monthToText} del año ${currentMonth.year}`
                                                : "Pendiente"}
                                        </div>
                                    </div>
                                </div>
                                <div className="stats bg-transparent">
                                    <div className="stat ">
                                        <div className="stat-title">Dinero en envíos</div>
                                        <div className="stat-value">
                                            {currentMonth
                                                ? currentMonth.money.toLocaleString("es-CO")
                                                : "Pendiente"}
                                        </div>
                                        <div className="stat-desc">
                                            {currentMonth
                                                ? `En el mes ${currentMonth.monthToText} del año ${currentMonth.year}`
                                                : "Pendiente"}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
                <Withdraw user={user} />
            </div>
        </main>
    );
}
