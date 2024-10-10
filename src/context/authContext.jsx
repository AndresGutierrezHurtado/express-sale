import { useContext, createContext, useEffect, useState } from "react";
import { useLocation, useNavigate } from "react-router-dom";
import Swal from "sweetalert2";

// Hooks
import { useGetData } from "../hooks/useFetchData";

const AuthContext = createContext();
export const useAuthContext = () => useContext(AuthContext);

export function AuthProvider({ children }) {
    const [userSession, setUserSession] = useState({ logged: "loading" });
    const navigate = useNavigate();
    const location = useLocation();

    const getData = async () => {
        const user = await useGetData("/api/user/session");
        if (user.success) {
            setUserSession({ logged: true, ...user.data });
        } else {
            setUserSession({ logged: false });
        }
    };

    const authMiddlewareAlert = message => {
        Swal.fire({
            icon: "error",
            title: "No tienes acceso a esta página",
            text: message,
            cancelButtonText: "Cancelar",
            confirmButtonText: "Continuar",
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
        }).then(result => {
            navigate("/")
        });
    };

    useEffect(() => {
        getData();
    }, [location]);

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
                const response = await useGetData("/api/user/logout");
                if (response.success) {
                    getData();
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

    return (
        <AuthContext.Provider
            value={{ userSession, handleLogout, authMiddlewareAlert, getData }}
        >
            {children}
        </AuthContext.Provider>
    );
}
