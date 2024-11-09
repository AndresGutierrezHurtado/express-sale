import React, { useEffect, useRef, useState } from "react";
import { GoogleMap, MarkerF as Marker } from "@react-google-maps/api";
import {
    useAddressAutocomplete,
    useGetUserLocation,
    useMapsApiLoader,
    useReverseGeocode,
} from "../hooks/useMaps";

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
        setZoom((prev) => prev >= 19 ? prev : prev + 2);
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
                    onLoad={(map) => mapRef.current = map}
                >
                    <Marker position={location} title="Tu ubicación" animation={google.maps.Animation.DROP} />
                </GoogleMap>
            </div>
        </div>
    );
}

// Ejemplo de otro componente de mapa para la vista de rutas de domiciliarios
export function DeliveryRouteMap() {
    const { userLocation } = useGetUserLocation();
    const { isLoaded } = useJsApiLoader({
        googleMapsApiKey: API_KEY,
        libraries,
    });

    if (!isLoaded) return <div className="w-full h-[200px] rounded skeleton"></div>;

    return (
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
            ></GoogleMap>
        </div>
    );
}
