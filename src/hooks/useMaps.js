import React, { useEffect, useState } from "react";

export const useGetUserLocation = () => {
    const [userLocation, setUserLocation] = useState({ lat: 0, lng: 0 });

    useEffect(() => {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    setUserLocation({
                        lat: position.coords.latitude,
                        lng: position.coords.longitude,
                    });
                },
                (error) => console.error("Error obteniendo la ubicación:", error),
                { enableHighAccuracy: true }
            );
        } else {
            console.error("La geolocalización no es compatible con este navegador.");
        }
    }, []);

    return { userLocation, setUserLocation };
};
