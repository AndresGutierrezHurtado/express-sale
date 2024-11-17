import React, { useState } from "react";

// Components
import ContentLoading from "../contentLoading";
import { SellerGraphic } from "./graphic";
import Withdraw from "./withdraw";
import { BillIcon, BoxesStackedIcon, StarIcon, UserIcon } from "../icons";

// Hooks
import { useGetData } from "@hooks/useFetchData";

export default function SellerStats({ user, reloadUser }) {
    const [graphicData, setGraphicData] = useState("all");
    const [currentMonth, setCurrentMonth] = useState(null);
    const [year, setYear] = useState("2024");

    const { data: pendingOrders, loading: pendingOrdersLoading, reload: reloadPendingOrders } = useGetData(`/orders?pedido_estado=pendiente&usuario_id=${user.usuario_id}`);

    console.log(pendingOrders);
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

    if (pendingOrdersLoading) return <ContentLoading />;
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
                                    <option value="sales">Número de ventas</option>
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
                                            Número de productos vendidos
                                        </div>
                                        {currentMonth ? (
                                            <>
                                                <div className="stat-value">{currentMonth.sales}</div>
                                                <div className="stat-desc">
                                                En el mes {currentMonth.monthToText} del año {currentMonth.year}
                                                </div>
                                            </>
                                        ) : (
                                            <>
                                                <div className="stat-value">Pendiente</div>
                                                <div className="stat-desc">
                                                    Dale clic a un mes para ver su valor
                                                </div>
                                            </>
                                        )}
                                    </div>
                                </div>
                                <div className="stats bg-transparent">
                                    <div className="stat ">
                                        <div className="stat-title">Dinero en ventas</div>
                                        {currentMonth ? (
                                            <>
                                                <div className="stat-value">{currentMonth.money.toLocaleString("es-CO")} COP</div>
                                                <div className="stat-desc">
                                                    En el mes {currentMonth.monthToText} del año {currentMonth.year}
                                                </div>
                                            </>
                                        ) : (
                                            <>
                                                <div className="stat-value">Pendiente</div>
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
                <Withdraw user={user} reloadUser={reloadUser} />
            </div>
            <div>
                
            <div className="flex flex-wrap gap-5">
                        <article className="min-w-[170px] w-fit p-4 flex flex-row items-center gap-4 card bg-base-100 stat text-center shadow-lg">
                            <div>
                                <UserIcon size={40} />
                            </div>
                            <div className="flex-grow">
                                <div className="stat-value text-xl">
                                    {user.calificacion_cantidad}
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
                                    {user.calificacion_promedio}
                                </div>
                                <div className="text-gray-500 leading-none">
                                    Calificacion promedio
                                </div>
                            </div>
                        </article>
                        <article className="min-w-[170px] w-fit p-4 flex flex-row items-center gap-4 card bg-base-100 stat text-center shadow-lg">
                            <div>
                                <BoxesStackedIcon size={40} />
                            </div>
                            <div className="flex-grow">
                                <div className="stat-value text-xl">
                                    {console.log(user)}
                                    {user.ventas_cantidad}
                                </div>
                                <div className="text-gray-500 leading-none">
                                    Productos vendidos
                                </div>
                            </div>
                        </article>
                        <article className="min-w-[170px] w-fit p-4 flex flex-row items-center gap-4 card bg-base-100 stat text-center shadow-lg">
                            <div>
                                <BillIcon size={40} />
                            </div>
                            <div className="flex-grow">
                                <div className="stat-value text-xl">
                                    {parseInt(user.ventas_dinero).toLocaleString("es-CO")} COP
                                </div>
                                <div className="text-gray-500 leading-none">Dinero hecho</div>
                            </div>
                        </article>
                    </div>
            </div>
        </main>
    );
}
