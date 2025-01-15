import Swal from "sweetalert2";
import { useState, useEffect } from "react";
import { useLocation } from "react-router-dom";

// Convertir useQuery en una función regular
const queryApi = async (endpoint, options, showSuccessMessage = false) => {
    try {
        const response = await fetch(`${import.meta.env.VITE_API_URL}${endpoint}`, options);
        const result = await response.json();

        if (result.success && showSuccessMessage) {
            Swal.fire({
                icon: "success",
                title: "Acción exitosa",
                text: result.message,
            });
        } else if (!result.success && showSuccessMessage) {
            Swal.fire({
                icon: "error",
                title: "Acción fallida",
                text: result.message,
            });
        }

        return result;
    } catch (error) {
        console.error("Error al realizar la petición:", error);
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "Hubo un error en la petición",
        });
        return undefined;
    }
};

// Hooks personalizados para las llamadas a la API
export const useGetData = (endpoint) => {
    const [data, setData] = useState(null);
    const [loading, setLoading] = useState(true);
    const [trigger, setTrigger] = useState(0);
    const location = useLocation();

    useEffect(() => {
        const fetchData = async () => {
            const result = await queryApi(endpoint, {
                method: "GET",
                headers: {
                    "Content-Type": "application/json",
                },
                credentials: "include",
            });
            if (result) {
                setData(result.data);
            }
            setLoading(false);
        };
        fetchData();
    }, [endpoint, trigger, location]);

    const reload = () => setTrigger((prev) => prev + 1);

    return { data, loading, reload };
};

export const usePutData = async (endpoint, data) => {
    return await queryApi(
        endpoint,
        {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(data),
            credentials: "include",
        },
        true
    );
};

export const usePostData = async (endpoint, data) => {
    return await queryApi(
        endpoint,
        {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(data),
            credentials: "include",
        },
        true
    );
};

export const useDeleteData = async (endpoint) => {
    return await queryApi(
        endpoint,
        {
            method: "DELETE",
            headers: {
                "Content-Type": "application/json",
            },
            credentials: "include",
        },
        true
    );
};
