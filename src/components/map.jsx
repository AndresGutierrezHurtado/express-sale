import React, { useState, useEffect, useRef } from "react";
import { GoogleMap, Marker, useJsApiLoader } from "@react-google-maps/api";

import { useGetUserLocation } from "../hooks/useMaps";

const libraries = ["places"];

export function FormMap() {
    const API_KEY = import.meta.env.VITE_GOOGLE_MAPS_KEY;
    const { userLocation, setUserLocation } = useGetUserLocation();
    const [address, setAddress] = useState("");
    const [error, setError] = useState(null);
    const autocompleteRef = useRef(null);

    const { isLoaded } = useJsApiLoader({
        googleMapsApiKey: API_KEY,
        libraries,
    });

    useEffect(() => {
        if (isLoaded && !autocompleteRef.current) {
            autocompleteRef.current = new window.google.maps.places.Autocomplete(
                document.getElementById("autocomplete"),
                { types: ["address"] }
            );

            autocompleteRef.current.addListener("place_changed", () => {
                const place = autocompleteRef.current.getPlace();
                if (place.geometry) {
                    setUserLocation({
                        lat: place.geometry.location.lat(),
                        lng: place.geometry.location.lng(),
                    });
                    setAddress(place.formatted_address || "");
                    setError(null);
                } else {
                    setError("Dirección no encontrada");
                }
            });
        }
    }, [isLoaded]);

    const onMapClick = (event) => {
        const lat = event.latLng.lat();
        const lng = event.latLng.lng();
        setUserLocation({ lat, lng });

        const geocoder = new window.google.maps.Geocoder();
        geocoder.geocode({ location: { lat, lng } }, (results, status) => {
            if (status === "OK" && results[0]) {
                setAddress(results[0].formatted_address);
                setError(null);
            } else {
                setError("No se pudo obtener la dirección de esta ubicación");
            }
        });
    };

    if (!isLoaded) return <div className="w-full h-[200px] rounded skeleton"></div>;

    if (!userLocation) {
        return <div className="text-red-500">Ubicación del usuario no disponible</div>;
    }

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
                    name="buyerAddress"
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
            <div className="w-full h-[200px] rounded overflow-hidden">
                <Map
                    mapContainerStyle={{ width: "100%", height: "100%" }}
                    center={userLocation}
                    zoom={15}
                    options={{
                        streetViewControl: false,
                        mapTypeControl: false,
                        fullscreenControl: false,
                    }}
                    onClick={onMapClick}
                >
                    {userLocation && (
                        <Marker position={userLocation} title="Lugar de entrega." />
                    )}
                </Map>
            </div>
        </div>
    );
}

export function Map({ children, ...props }) {
    return (
        <GoogleMap
            mapContainerStyle={{ width: "100%", height: "100%" }}
            center={props.center}
            zoom={props.zoom}
            onClick={props.onClick}
            options={props.options}
        >
            {children}
        </GoogleMap>
    );
}
