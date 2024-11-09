import React, { useEffect, useRef, useState } from "react";
import { GoogleMap, MarkerF as Marker, DirectionsRenderer } from "@react-google-maps/api";

// Hooks
import {
    useAddressAutocomplete,
    useGetUserLocation,
    useMapsApiLoader,
    useReverseGeocode,
    useShortestPath,
} from "@hooks/useMaps";

// Components
import { GoogleMapsIcon, WazeIcon } from "./icons.jsx";
import { Link } from "react-router-dom";

// Componente de Mapa para Formulario de Pago
export function FormMap() {
    const userLocation = useGetUserLocation();
    const isLoaded = useMapsApiLoader();
    if (isLoaded) useAddressAutocomplete("shippingAddress");

    const [location, setLocation] = useState(userLocation);
    const [zoom, setZoom] = useState(9);
    const mapRef = useRef(null);

    const handleMapClick = (event) => {
        const lat = event.latLng.lat();
        const lng = event.latLng.lng();
        setLocation({ lat, lng });
        useReverseGeocode(lat, lng, "shippingAddress");
        setZoom((prev) => (prev >= 19 ? prev : prev + 2));
    };

    useEffect(() => {
        setLocation(userLocation);
        useReverseGeocode(userLocation.lat, userLocation.lng, "shippingAddress");
    }, [userLocation]);

    useEffect(() => {
        if (mapRef.current && location) {
            mapRef.current.panTo(location);
        }
    }, [location]);

    if (!location) return <div className="text-red-500">Ubicación del usuario no disponible</div>;

    if (!isLoaded) return <div className="w-full h-[200px] rounded skeleton"></div>;

    return (
        <div className="form-group space-y-4">
            <div className="form-control">
                <label className="label">
                    <span className="label-text font-semibold after:content-['*'] after:ml-1 after:text-red-500">
                        Dirección:
                    </span>
                </label>
                <input
                    id="autocomplete"
                    name="shippingAddress"
                    placeholder="Ingresa tu direccion"
                    className="input input-bordered input-sm focus:outline-0 focus:input-primary"
                />
                <input type="hidden" name="shippingCoordinates" value={JSON.stringify(location)} />
            </div>
            <div className="w-full h-[200px] rounded overflow-hidden">
                <GoogleMap
                    mapContainerClassName="w-full h-full"
                    center={location}
                    zoom={zoom}
                    options={{
                        streetViewControl: false,
                        mapTypeControl: false,
                        fullscreenControl: false,
                    }}
                    onClick={handleMapClick}
                    onLoad={(map) => (mapRef.current = map)}
                >
                    <Marker
                        position={location}
                        title="Tu ubicación"
                        animation={google.maps.Animation.DROP}
                    />
                </GoogleMap>
            </div>
        </div>
    );
}

// Ejemplo de otro componente de mapa para la vista de rutas de domiciliarios
export function DeliveryRouteMap({ addresses, destination }) {
    const userLocation = useGetUserLocation();
    const isLoaded = useMapsApiLoader();

    const { loaded, route, response } = useShortestPath(
        addresses,
        JSON.parse(destination),
        isLoaded,
        userLocation
    );

    if (loaded) console.log(response);

    if (!isLoaded || !loaded)
        return (
            <div className="space-y-5">
                <div className="w-full h-[400px] rounded skeleton flex items-center justify-center text-xl font-bold">
                    {" "}
                    Cargando ruta...
                </div>

                <div className="flex flex-col gap-3 items-center justify-center">
                    <div className="skeleton h-6 w-full max-w-lg"></div>
                    <div className="skeleton h-6 w-full max-w-lg"></div>
                </div>
            </div>
        );

    return (
        <div className="space-y-5">
            <div className="w-full h-[400px] rounded overflow-hidden">
                <GoogleMap
                    mapContainerClassName="w-full h-full"
                    center={userLocation}
                    zoom={10}
                    options={{
                        streetViewControl: false,
                        mapTypeControl: false,
                        fullscreenControl: false,
                    }}
                >
                    <Marker />
                    <DirectionsRenderer directions={response} />
                </GoogleMap>
            </div>
            <div className="flex flex-col gap-3 items-center justify-center">
                <Link
                    target="_blank"
                    to={`https://www.google.com/maps/dir/${userLocation.lat},${
                        userLocation.lng
                    }/${route.map((point) => point.lat + "," + point.lng).join("/")}/${
                        destination.lat
                    },${destination.lng}`}
                    className="btn btn-sm w-full max-w-lg"
                >
                    <GoogleMapsIcon size={18} />
                    Ver ruta en Google Maps
                </Link>
                <Link
                    target="_blank"
                    to={`https://waze.com/ul?ll=${route
                        .map((point) => point.lat + "," + point.lng)
                        .join("/")}/${destination.lat},${destination.lng}`}
                    className="btn btn-sm w-full max-w-lg"
                >
                    <WazeIcon size={19} />
                    Ver ruta en Waze
                </Link>
            </div>
        </div>
    );
}
