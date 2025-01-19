import React, { useState } from "react";

// Components
import ContentLoading from "../contentLoading";
import { SellerGraphic } from "./graphic";
import Withdraw from "./withdraw";
import { BillIcon, BoxesStackedIcon, StarIcon, UserIcon } from "../icons";

// Hooks
import { useGetData } from "@hooks/useFetchData";
import { Link } from "react-router-dom";

export default function SellerStats({ user, reloadUser }) {
    const [graphicData, setGraphicData] = useState("all");
    const [currentMonth, setCurrentMonth] = useState(null);
    const [year, setYear] = useState("2024");

    const {
        data: pendingOrders,
        loading: pendingOrdersLoading,
        reload: reloadPendingOrders,
    } = useGetData(`/orders?order_status=pendiente,enviando&user_id=${user.user_id}`);

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
        <main className="h-full w-full p-10 space-y-10 overflow-y-scroll">
            <div className="flex flex-col xl:flex-row gap-10">
                <div className="flex flex-col gap-10 w-full max-w-[800px]">
                    <div className="card bg-white border shadow-lg border-gray-100 w-full">
                        <div className="card-body gap-5">
                            <article className="space-y-2">
                                <h2 className="text-2xl md:text-4xl font-extrabold tracking-tight ">
                                    Estadísticas de {user.user_name.split(" ")[0]}{" "}
                                    {user.user_lastname.split(" ")[0]}:{" "}
                                </h2>
                                <div className="flex flex-col md:flex-row items-center gap-5">
                                    <p className="leading-tight text-sm">
                                        Selecciona el año para ver las estadísticas de ventas de
                                        cada mes.
                                    </p>
                                    <div className="flex flex-col md:flex-row gap-5">
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
                                </div>
                            </article>
                            <article>
                                <SellerGraphic
                                    data={yearSales}
                                    graphicData={graphicData}
                                    setCurrentMonth={setCurrentMonth}
                                />
                                <div className="flex flex-col lg:flex-row gap-5 md:gap-2 [&>*]:grow text-center">
                                    <div className="stats overflow-visible bg-transparent">
                                        <div className="stat p-0 md:py-4 md:px-6">
                                            <div className="stat-title text-wrap">
                                                Número de productos vendidos
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
                                            <div className="stat-title text-wrap">
                                                Dinero en ventas
                                            </div>
                                            {currentMonth ? (
                                                <>
                                                    <div className="stat-value text-xl md:text-4xl">
                                                        {currentMonth.money.toLocaleString("es-CO")}{" "}
                                                        COP
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
                        <section className="flex flex-wrap gap-5">
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
                                    <BoxesStackedIcon size={40} />
                                </div>
                                <div className="flex-grow">
                                    <div className="stat-value text-xl">{user.ventas_cantidad}</div>
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
                        </section>

                        <section className="space-y-5">
                            <h2 className="text-3xl font-extrabold">Pedidos pendientes:</h2>
                            <div className="w-full overflow-x-auto border">
                                <table className="table border w-full">
                                    <thead className="bg-gray-200">
                                        <tr>
                                            <th>Pedido</th>
                                            <th>Fecha</th>
                                            <th>Productos</th>
                                            <th>Destinatario</th>
                                            <th>Domiciliario</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {pendingOrders.length === 0 && (
                                            <tr>
                                                <td colSpan={6}>
                                                    No tienes ningun pedido pendiente...
                                                </td>
                                            </tr>
                                        )}
                                        {pendingOrders.map((order) => (
                                            <tr key={order.order_id}>
                                                <td>{order.order_id.split("-")[1]}</td>
                                                <td>
                                                    {new Date(order.order_date).toLocaleString(
                                                        "es-CO"
                                                    )}
                                                </td>
                                                <td>
                                                    {order.orderProducts.map((product) => (
                                                        <p key={product.product_id}>
                                                            - {product.product.product_name}
                                                        </p>
                                                    ))}
                                                </td>
                                                <td>{`${order.user.user_name} ${order.user.user_lastname}`}</td>
                                                <td>{`${
                                                    order.shippingDetails.worker?.user
                                                        .user_name || "No asignado"
                                                } ${
                                                    order.shippingDetails.worker?.user
                                                        .user_lastname || ""
                                                }`}</td>
                                                <td>{order.order_status}</td>
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            </div>
                        </section>
                    </div>
                </div>
                <div className="flex flex-col items-center gap-10 w-full">
                    <Withdraw user={user} reloadUser={reloadUser} />
                    <div className="space-y-3 w-full max-w-[500px]">
                        <h2 className="text-3xl font-extrabold">Productos más vendidos:</h2>
                        <div className="space-y-4">
                            {user.worker.most_selled_products.length === 0 && (
                                <p className="text-center font-bold text-2xl text-gray-500">
                                    No hay productos vendidos...
                                </p>
                            )}
                            {user.worker.most_selled_products.map((product, index) => (
                                <div key={product.product_id} className="flex flex-wrap items-center gap-5">
                                    <h2 className="text-4xl font-bold mx-auto">{index + 1}</h2>
                                    <div className="card bg-white border border-gray-100 w-full max-w-[400px] shadow-lg">
                                        <div className="card-body flex-row flex-wrap items-center">
                                            <figure className="size-[100px] flex-none">
                                                <img
                                                    src={product.product_image_url}
                                                    alt={`Imagen del producto ${product.product_name}`}
                                                    className="object-contain h-full w-full"
                                                />
                                            </figure>
                                            <div className="grow flex flex-col gap-4">
                                                <div className="grow">
                                                    <h2 className="text-xl md:text-2xl font-bold tracking-tight">
                                                        {product.product_name}
                                                    </h2>
                                                    <p>{product.total_ventas} ventas</p>
                                                </div>
                                                <div className="h-initial flex items-start gap-2">
                                                    <Link
                                                        to={`/product/${product.product_id}`}
                                                        className="btn btn-sm btn-primary"
                                                    >
                                                        Ver perfil
                                                    </Link>
                                                    <Link
                                                        to={`/profile/product/${product.product_id}`}
                                                        className="btn btn-sm btn-primary"
                                                    >
                                                        Editar
                                                    </Link>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>
                </div>
            </div>
        </main>
    );
}
