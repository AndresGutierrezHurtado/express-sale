import React, { useEffect, useState } from "react";

// Components
import { TruckIcon, BillIcon, StarIcon, UserIcon } from "@components/icons.jsx";
import { DeliveryGraphic } from "@components/profile/graphic.jsx";
import Withdraw from "./withdraw";

export default function DeliveryStats({ user, reloadUser }) {
    const [graphicData, setGraphicData] = useState("all");
    const [currentMonth, setCurrentMonth] = useState(null);
    const [year, setYear] = useState("2024");

    const yearSales = [];
    for (let i = 1; i <= 12; i++) {
        let infoMes =
            user.worker.envios_mensuales.find(
                (el) => el.mes == i && el.anio == (year ? year : new Date().getFullYear())
            ) || null;
        yearSales.push({
            month: i,
            monthToText: new Date(0, i - 1).toLocaleString("es", { month: "long" }),
            money: infoMes ? parseInt(infoMes.dinero_envios) : 0,
            sales: infoMes ? infoMes.total_envios : 0,
            year: infoMes ? infoMes.anio : parseInt(year),
        });
    }

    return (
        <main className="h-full w-full p-10 space-y-10 overflow-y-scroll">
            <div className="flex flex-col md:flex-row gap-10">
                <div className="card bg-white border shadow-lg border-gray-100 w-full max-w-[750px]">
                    <div className="card-body gap-5">
                        <article className="space-y-2">
                            <h2 className="text-2xl md:text-4xl font-extrabold tracking-tight ">
                                Estadísticas de {user.user_name.split(" ")[0]}{" "}
                                {user.user_lastname.split(" ")[0]}:{" "}
                            </h2>
                            <div className="flex flex-col md:flex-row items-center gap-5">
                                <p className="leading-tight text-sm">
                                    Selecciona el año para ver las estadísticas de envios de cada
                                    mes.
                                </p>
                                <div className="flex flex-col lg:flex-row gap-5">
                                    <select
                                        value={graphicData}
                                        onChange={(event) => setGraphicData(event.target.value)}
                                        className="select select-bordered select-sm w=full focus:outline-0 focus:select-primary"
                                    >
                                        <option value="all">Todo</option>
                                        <option value="money">Dinero recaudado</option>
                                        <option value="sales">Número de envíos</option>
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
                            </div>
                        </article>
                        <article>
                            <DeliveryGraphic
                                data={yearSales}
                                graphicData={graphicData}
                                setCurrentMonth={setCurrentMonth}
                            />
                            <div className="flex flex-col md:flex-row gap-5 md:gap-2 [&>*]:grow text-center">
                                <div className="stats overflow-visible bg-transparent">
                                    <div className="stat p-0 md:py-4 md:px-6">
                                        <div className="stat-title text-wrap">
                                            Número de envíos realizados
                                        </div>
                                        {currentMonth ? (
                                            <>
                                                <div className="stat-value text-xl md:text-4xl">
                                                    {currentMonth.sales}
                                                </div>
                                                <div className="stat-desc">
                                                    En el mes {currentMonth.monthToText} del año{" "}
                                                    {currentMonth.year}
                                                </div>
                                            </>
                                        ) : (
                                            <>
                                                <div className="stat-value text-xl md:text-4xl">
                                                    Pendiente
                                                </div>
                                                <div className="stat-desc">
                                                    Dale clic a un mes para ver su valor
                                                </div>
                                            </>
                                        )}
                                    </div>
                                </div>
                                <div className="stats overflow-visible bg-transparent">
                                    <div className="stat p-0 md:py-4 md:px-6">
                                        <div className="stat-title text-wrap">Dinero en envíos</div>
                                        {currentMonth ? (
                                            <>
                                                <div className="stat-value text-xl md:text-4xl">
                                                    {currentMonth.money.toLocaleString("es-CO")} COP
                                                </div>
                                                <div className="stat-desc">
                                                    En el mes {currentMonth.monthToText} del año{" "}
                                                    {currentMonth.year}
                                                </div>
                                            </>
                                        ) : (
                                            <>
                                                <div className="stat-value text-xl md:text-4xl">Pendiente</div>
                                                <div className="stat-desc">
                                                    Dale clic a un mes para ver suvalor
                                                </div>
                                            </>
                                        )}
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
                <div className="space-y-10">
                    <Withdraw user={user} reloadUser={reloadUser} />
                    <div className="flex flex-wrap gap-5">
                        <article className="min-w-[170px] w-fit p-4 flex flex-row items-center gap-4 card bg-base-100 stat text-center shadow-lg">
                            <div>
                                <UserIcon size={40} />
                            </div>
                            <div className="flex-grow">
                                <div className="stat-value text-xl">
                                    {user.ratings_count}
                                </div>
                                <div className="text-gray-500 leading-none">Calificaciones</div>
                            </div>
                        </article>
                        <article className="min-w-[170px] w-fit p-4 flex flex-row items-center gap-4 card bg-base-100 stat text-center shadow-lg">
                            <div>
                                <StarIcon size={40} />
                            </div>
                            <div className="flex-grow">
                                <div className="stat-value text-xl">
                                    {user.average_rating}
                                </div>
                                <div className="text-gray-500 leading-none">
                                    Calificacion promedio
                                </div>
                            </div>
                        </article>
                        <article className="min-w-[170px] w-fit p-4 flex flex-row items-center gap-4 card bg-base-100 stat text-center shadow-lg">
                            <div>
                                <TruckIcon size={40} />
                            </div>
                            <div className="flex-grow">
                                <div className="stat-value text-xl">{user.envios_cantidad}</div>
                                <div className="text-gray-500 leading-none">
                                    Domicilios realizados
                                </div>
                            </div>
                        </article>
                        <article className="min-w-[170px] w-fit p-4 flex flex-row items-center gap-4 card bg-base-100 stat text-center shadow-lg">
                            <div>
                                <BillIcon size={40} />
                            </div>
                            <div className="flex-grow">
                                <div className="stat-value text-xl">
                                    {parseInt(user.envios_dinero).toLocaleString("es-CO")} COP
                                </div>
                                <div className="text-gray-500 leading-none">Dinero hecho</div>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </main>
    );
}
