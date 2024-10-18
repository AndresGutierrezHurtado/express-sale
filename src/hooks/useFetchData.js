import Swal from "sweetalert2";

export const useGetData = async (endpoint) => {
    try {
        const response = await fetch(
            `${import.meta.env.VITE_API_URL}${endpoint}`,
            {
                method: "GET",
                credentials: "include",
            }
        );
        const result = await response.json();
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

export const usePostData = async (endpoint, data) => {
    try {
        const response = await fetch(
            `${import.meta.env.VITE_API_URL}${endpoint}`,
            {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(data),
                credentials: "include",
            }
        );
        const result = await response.json();

        if (result.success) {
            Swal.fire({
                icon: "success",
                title: "Acción exitosa",
                text: result.message,
            });
        } else {
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

export const usePutData = async (endpoint, data) => {
    try {
        const response = await fetch(
            `${import.meta.env.VITE_API_URL}${endpoint}`,
            {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(data),
                credentials: "include",
            }
        );
        const result = await response.json();

        if (result.success) {
            Swal.fire({
                icon: "success",
                title: "Acción exitosa",
                text: result.message,
            });
        } else {
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

export const useDeleteData = async (endpoint) => {
    try {
        const response = await fetch(
            `${import.meta.env.VITE_API_URL}${endpoint}`,
            {
                method: "DELETE",
                credentials: "include",
            }
        );
        const result = await response.json();

        if (result.success) {
            Swal.fire({
                icon: "success",
                title: "Acción exitosa",
                text: result.message,
            });
        } else {
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
