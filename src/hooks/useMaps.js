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

export const useGeocode = (address, isLoaded) => {
    const [location, setLocation] = useState(null);
    const geocoder = !isLoaded ? null : new window.google.maps.Geocoder();

    useEffect(() => {
        if (!geocoder || !address) return;

        const geocodeAddress = () => {
            geocoder.geocode({ address }, (results, status) => {
                if (status === "OK" && results[0]) {
                    const { lat, lng } = results[0].geometry.location;
                    setLocation({ lat: lat(), lng: lng() });
                } else {
                    console.error(`Geocode failed for ${address}: ${status}`);
                }
            });
        };

        geocodeAddress();

    }, [address, isLoaded]);

    return location;
};

// Hook para hallar el camino mas corto iniciando por la ubicacion del usuario y devuelve los archivos en orden junto a la distancia total
export const useShortestPath = (waypoints, isLoaded, userLocation) => {
    const [shortestPath, setShortestPath] = useState({ loaded: false, route: [], distance: 0 });
    const geocodedWaypoints = waypoints.map((address) => useGeocode(address, isLoaded));

    useEffect(() => {
        if (!userLocation || !geocodedWaypoints[0] || !isLoaded ) return;

        const directionsService = new window.google.maps.DirectionsService();

        directionsService.route(
            {
                origin: userLocation,
                waypoints: geocodedWaypoints.map((waypoint) => ({ location: waypoint })),
                destination: geocodedWaypoints[geocodedWaypoints.length - 1],
                travelMode: window.google.maps.TravelMode.DRIVING,
                optimizeWaypoints: true,
                unitSystem: window.google.maps.UnitSystem.METRIC,
            },
            (result, status) => {
                if (status === "OK") {
                    const route = result.routes[0];
                    let totalDistance = 0;

                    route.legs.forEach((leg) => {
                        totalDistance += leg.distance.value;
                    });

                    setShortestPath({
                        loaded: true,
                        route: route.legs.map((leg) => ({
                            address: leg.end_address,
                            lat: leg.end_location.lat(),
                            lng: leg.end_location.lng(),
                        })),
                        distance: totalDistance / 1000,
                    });
                } else {
                    console.error("Error calculating route: ", status);
                }
            }
        );
    }, [userLocation, waypoints, isLoaded]);

    return shortestPath;
};
