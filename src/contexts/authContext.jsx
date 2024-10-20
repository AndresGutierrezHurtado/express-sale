import { useContext, createContext, useEffect, useState } from "react";
import { useLocation, useNavigate } from "react-router-dom";
import Swal from "sweetalert2";

// Hooks
import { useGetData, usePostData } from "../hooks/useFetchData";

// Components
import Loading from "../components/pageLoading";

const AuthContext = createContext();
export const useAuthContext = () => useContext(AuthContext);

export function AuthProvider({ children }) {
    const { loading, data: userSession, reload } = useGetData("/user/session");
    const navigate = useNavigate();

    const handleLogout = () => {
        Swal.fire({
            icon: "warning",
            title: "¿Estás seguro?",
            text: "Dale a continuar si quieres cerrar sesión",
            showCancelButton: true,
            cancelButtonText: "Cancelar",
            confirmButtonText: "Continuar",
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
        }).then(async (result) => {
            if (result.isConfirmed) {
                const response = await usePostData("/user/logout", {});
                if (response.success) {
                    reload();
                    navigate("/");
                    Swal.fire({
                        icon: "info",
                        title: "Sesión cerrada",
                        text: response.message,
                    });
                }
            }
        });
    };

    const authMiddlewareAlert = (message) => {
        Swal.fire({
            icon: "error",
            title: "No tienes acceso a esta página/acción",
            text: message,
            cancelButtonText: "Cancelar",
            confirmButtonText: "Continuar",
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
        }).then((result) => {
            navigate("/");
        });
    };

    if (loading) return <Loading />;

    return (
        <AuthContext.Provider
            value={{
                userSession,
                loading,
                reload,
                handleLogout,
                authMiddlewareAlert,
            }}
        >
            {children}
        </AuthContext.Provider>
    );
}
