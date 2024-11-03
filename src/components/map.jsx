import React, { useState, useEffect, useRef } from "react";
import { GoogleMap, Marker, useJsApiLoader } from "@react-google-maps/api";

import { useGetUserLocation } from "../hooks/useMaps";

export function FormMap() {
    const API_KEY = import.meta.env.VITE_GOOGLE_MAPS_KEY;
    const { userLocation, setUserLocation } = useGetUserLocation();
    const [address, setAddress] = useState("");
    const [error, setError] = useState(null);

    const { isLoaded } = useJsApiLoader({
        googleMapsApiKey: API_KEY,
    });

    const codeAddress = (e) => {
        setAddress(e.target.value);
        const geocoder = new window.google.maps.Geocoder();

        geocoder.geocode({ address: address }, (results, status) => {
            if (status === "OK" && results[0]) {
                setUserLocation({
                    lat: results[0].geometry.location.lat(),
                    lng: results[0].geometry.location.lng(),
                });
                console.log(userLocation);
                setError(null);
            } else {
                setError("Dirección no encontrada");
            }
        });
    };

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
                    name="buyerAddress"
                    placeholder="Ingresa tu direccion"
                    className="input input-bordered input-sm focus:outline-0 focus:input-primary"
                    value={address}
                    onChange={codeAddress}
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
                >
                    <Marker position={userLocation} title="Tu ubicación" />
                </Map>
            </div>
        </div>
    );
}

export function Map({ children, ...props }) {
    return (
        <GoogleMap
            mapContainerStyle={{ width: "100%", height: "100%" }}
            center={{ lat: -3.745, lng: -38.523 }}
            zoom={10}
            {...props}
        >
            {children}
        </GoogleMap>
    );
}
