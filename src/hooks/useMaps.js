import React, { useEffect, useState } from "react";
import { useLoadScript } from "@react-google-maps/api";

const libraries = ["places"];
const API_KEY = import.meta.env.VITE_GOOGLE_MAPS_KEY;

// Hook para cargar el API de Google Maps
export const useMapsApiLoader = (options) => {
    const { isLoaded } = useLoadScript({
        googleMapsApiKey: API_KEY,
        libraries,
        ...options,
    });

    return isLoaded;
};

// Hook para obtener la ubicación del usuario
export const useGetUserLocation = () => {
    const [location, setLocation] = useState({ lat: 4.708051570814126, lng: -74.07576082596674 });

    useEffect(() => {
        if (!navigator.geolocation) {
            console.error("La geolocalización no es compatible con este navegador.");
            return location;
        }

        const watcher = navigator.geolocation.watchPosition(
            (position) => {
                const { latitude: lat, longitude: lng } = position.coords;
                setLocation({ lat, lng });
                return { lat, lng };
            },
            (error) => {
                console.log(error.message);
                return location;
            }
        );

        return () => navigator.geolocation.clearWatch(watcher);
    }, []);

    return location;
};

// Hook para configurar Autocomplete en un input
export const useAddressAutocomplete = (inputName) => {
    if (document.getElementsByName(inputName)[0]) {
        const autocomplete = new window.google.maps.places.Autocomplete(
            document.getElementsByName(inputName)[0],
            {}
        );

        autocomplete.addListener("place_changed", () => {
            const place = autocomplete.getPlace();
            if (place.geometry && place.geometry.location) {
                const { lat, lng } = place.geometry.location;
            }
        });
    }
};

// Hook de geocodificación inversa para convertir coordenadas en dirección
export const useReverseGeocode = (lat, lng, inputName) => {
    if (document.getElementsByName(inputName)[0]) {
        const geocoder = new window.google.maps.Geocoder();

        geocoder.geocode({ location: { lat, lng } }, (results, status) => {
            if (status === "OK" && results[0]) {
                document.getElementsByName(inputName)[0].value = results[0].formatted_address;
            }
        });
    }
};

// Hook para hallar la distancia entre dos ubicaciones
export const useDistanceMatrix = (origin, destination) => {
    const [distance, setDistance] = useState(null);
    const [duration, setDuration] = useState(null);

    useEffect(() => {
        const service = new window.google.maps.DistanceMatrixService();
        service
            .getDistanceMatrix({
                origins: [origin],
                destinations: [destination],
                travelMode: "DRIVING",
            })
            .then((response) => {
                if (response.rows[0].elements[0].status === "OK") {
                    setDistance(response.rows[0].elements[0].distance.text);
                    setDuration(response.rows[0].elements[0].duration.text);
                }
            });
    }, [origin, destination]);

    return { distance, duration };
};

// Hook para hallar el camino mas corto iniciando por la ubicacion del usuario y devuelve los archivos en orden junto a la distancia total
export const useShortestPath = (waypoints) => {
    const [shortestPath, setShortestPath] = useState(null);

    const { userLocation } = useGetUserLocation();

    useEffect(() => {
        const service = new window.google.maps.DistanceMatrixService();
        service
            .getDistanceMatrix({
                origins: [userLocation],
                destinations: waypoints,
                travelMode: "DRIVING",
            })
            .then((response) => {
                if (response.rows[0].elements[0].status === "OK") {
                    setShortestPath(response.rows[0].elements);
                }
            });
    }, [waypoints, userLocation]);

    return { shortestPath };
};
