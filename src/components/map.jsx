import React, { useState, useEffect, useRef } from "react";
import { GoogleMap, Marker, useJsApiLoader } from "@react-google-maps/api";
import { useGetUserLocation } from "../hooks/useMaps";

const libraries = ["places"];
const API_KEY = import.meta.env.VITE_GOOGLE_MAPS_KEY;

// Componente de Mapa General
export function Map({ center, zoom, onClick, children, options }) {
    return (
        <GoogleMap
            mapContainerStyle={{ width: "100%", height: "100%" }}
            center={center}
            zoom={zoom}
            onClick={onClick}
            options={options}
        >
            {children}
        </GoogleMap>
    );
}

// Hook para configurar Autocomplete en un input
function useAddressAutocomplete(setLocation, setAddress, setError) {
    const autocompleteRef = useRef(null);
    const [trigger, setTrigger] = useState(0);
    
    useEffect(() => {
        if (window.google && window.google.maps.places && !autocompleteRef.current) {
            autocompleteRef.current = new window.google.maps.places.Autocomplete(
                document.getElementById("autocomplete"),
                { types: ["address"] }
            );
            autocompleteRef.current.addListener("place_changed", () => {
                const place = autocompleteRef.current.getPlace();
                if (place.geometry) {
                    setLocation({
                        lat: place.geometry.location.lat(),
                        lng: place.geometry.location.lng(),
                    });
                    setAddress(place.formatted_address || "");
                    setError(null);
                } else {
                    setError("Dirección no encontrada");
                }
            });
        } else {
            setTimeout(() => setTrigger(trigger + 1), 1000);
        }
    }, [trigger]);
}

// Función de geocodificación inversa para convertir coordenadas en dirección
function reverseGeocode(lat, lng, setAddress, setError) {
    const geocoder = new window.google.maps.Geocoder();
    geocoder.geocode({ location: { lat, lng } }, (results, status) => {
        if (status === "OK" && results[0]) {
            setAddress(results[0].formatted_address);
            setError(null);
        } else {
            setError("No se pudo obtener la dirección de esta ubicación");
        }
    });
}

// Componente de Mapa para Formulario de Pago
export function FormMap() {
    const { userLocation, setUserLocation } = useGetUserLocation();
    const [address, setAddress] = useState("");
    const [error, setError] = useState(null);
    const { isLoaded } = useJsApiLoader({
        googleMapsApiKey: API_KEY,
        libraries,
    });

    useAddressAutocomplete(setUserLocation, setAddress, setError);

    const onMapClick = (event) => {
        const lat = event.latLng.lat();
        const lng = event.latLng.lng();
        setUserLocation({ lat, lng });
        reverseGeocode(lat, lng, setAddress, setError);
    };

    if (!isLoaded) return <div className="w-full h-[200px] rounded skeleton"></div>;

    if (!userLocation) {
        return <div className="text-red-500">Ubicación del usuario no disponible</div>;
    }

    return (
        <div className="form-group space-y-4">
            <AddressInput address={address} setAddress={setAddress} error={error} />
            <div className="w-full h-[200px] rounded overflow-hidden">
                <Map
                    center={userLocation}
                    zoom={15}
                    options={{
                        streetViewControl: false,
                        mapTypeControl: false,
                        fullscreenControl: false,
                    }}
                    onClick={onMapClick}
                >
                    <Marker position={userLocation} title="Lugar de entrega" />
                </Map>
            </div>
        </div>
    );
}

// Componente Input para Dirección
function AddressInput({ address, setAddress, error }) {
    return (
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
                value={address}
                onChange={(e) => setAddress(e.target.value)}
            />
            {error && (
                <label className="label">
                    <span className="label-text-alt text-red-500">{error}</span>
                </label>
            )}
        </div>
    );
}

// Ejemplo de otro componente de mapa para la vista de rutas de vendedores
export function VendorRouteMap({ routeCoordinates }) {
    const { userLocation } = useGetUserLocation();
    const { isLoaded } = useJsApiLoader({
        googleMapsApiKey: API_KEY,
        libraries,
    });

    if (!isLoaded) return <div className="w-full h-[200px] rounded skeleton"></div>;

    return (
        <div className="w-full h-[400px] rounded overflow-hidden">
            <Map
                center={userLocation}
                zoom={10}
                options={{
                    streetViewControl: false,
                    mapTypeControl: false,
                    fullscreenControl: false,
                }}
            >
                {routeCoordinates.map((position, index) => (
                    <Marker key={index} position={position} title={`Punto ${index + 1}`} />
                ))}
            </Map>
        </div>
    );
}
