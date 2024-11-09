import React from "react";

// Hooks
import { useParams } from "react-router-dom";
import { useGetData } from "@hooks/useFetchData";

// Components
import ContentLoading from "@components/contentLoading.jsx";
import { GoogleMapsIcon, WazeIcon, CircleCheckIcon } from "@components/icons.jsx";

export default function Delivery() {
    const { id } = useParams();
    const { data: order, loading: orderLoading } = useGetData(`/orders/${id}`);

    if (orderLoading) return <ContentLoading />;

    const {
        pedido_id,
        pedido_fecha,
        pedido_estado,
        orderProducts,
        shippingDetails,
        paymentDetails,
    } = order;

    const totalAmount = orderProducts.reduce(
        (total, item) => total + item.producto_precio * item.producto_cantidad,
        0
    );

    // GETDISTANCE =>    var origin1 = new google.maps.LatLng(55.930385, -3.118425);
    // var origin2 = 'Greenwich, England';
    // var destinationA = 'Stockholm, Sweden';
    // var destinationB = new google.maps.LatLng(50.087692, 14.421150);

    // var service = new google.maps.DistanceMatrixService();
    // service.getDistanceMatrix(
    //   {
    //     origins: [origin1, origin2],
    //     destinations: [destinationA, destinationB],
    //     travelMode: 'DRIVING',
    //     transitOptions: TransitOptions,
    //     drivingOptions: DrivingOptions,
    //     unitSystem: UnitSystem,
    //     avoidHighways: Boolean,
    //     avoidTolls: Boolean,
    //   }, callback);

    // function callback(response, status) {
    //   // See Parsing the Results for
    //   // the basics of a callback function.
    // }

    return (
        <section className="w-full px-3">
            <div className="w-full max-w-[1200px] mx-auto py-10">
                <div className="card bg-white border gap-5">
                    <div className="card-body flex flex-col gap-7">
                        <div className="flex flex-col md:flex-row gap-10">
                            <article className="space-y-4">
                                <h1 className="text-4xl font-extrabold tracking-tight">
                                    Detalles del Pedido:
                                </h1>

                                {/* Información del Comprador */}
                                <div className="text-lg">
                                    <p>
                                        <strong>Nombre:</strong> {order.user.usuario_nombre}{" "}
                                        {order.user.usuario_apellido}
                                    </p>
                                    <p>
                                        <strong>Email:</strong> {paymentDetails.comprador_correo}
                                    </p>
                                    <p>
                                        <strong>Teléfono:</strong>{" "}
                                        {paymentDetails.comprador_telefono}
                                    </p>
                                    <p>
                                        <strong>Dirección:</strong>{" "}
                                        {shippingDetails.envio_direccion}
                                    </p>
                                    <p>
                                        <strong>Mensaje:</strong> {shippingDetails.envio_mensaje}
                                    </p>
                                </div>
                            </article>

                            <article className="space-y-4">
                                <h1 className="text-4xl font-extrabold tracking-tight">
                                    Tiendas/Vendedores:
                                </h1>
                                <div className="text-lg">
                                    {orderProducts.map((item, index) => (
                                        <div key={item.producto_id}>
                                            <p>
                                                {index + 1}.{item.product.user.usuario_nombre}{" "}
                                                {item.product.user.usuario_apellido}{" "}
                                                <span className="text-sm text-gray-600">
                                                    (
                                                    {item.product.user.usuario_direccion ||
                                                        "Dirección desconocida"}
                                                    )
                                                </span>
                                            </p>
                                        </div>
                                    ))}
                                </div>
                            </article>
                        </div>

                        <hr />
                        {/* Mapa */}
                        <div className="space-y-5">
                            <></>
                            <div className="flex flex-col gap-3 items-center justify-center">
                                <button className="btn btn-sm w-full max-w-lg">
                                    <GoogleMapsIcon size={18} />
                                    Ver ruta en Google Maps
                                </button>
                                <button className="btn btn-sm w-full max-w-lg">
                                    <WazeIcon size={19} />
                                    Ver ruta en Waze
                                </button>
                            </div>
                        </div>
                        <hr />
                        <div className="flex items-center justify-center">
                            <button className="btn btn-sm btn-success text-white w-full max-w-lg">
                                <CircleCheckIcon />
                                Marcar como terminado
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    );
}
