import { useContext, createContext, useEffect, useState } from "react";
import { useLocation } from "react-router-dom";
import Swal from "sweetalert2";

// Hooks
import { useGetData } from "../hooks/useFetchData";

const AuthContext = createContext();
export const useAuthContext = () => useContext(AuthContext);

export function AuthProvider({ children }) {
    const [userSession, setUserSession] = useState(null);
    const location = useLocation();

    const getData = async () => {
        const user = await useGetData("/api/user/session");
        if (user.success) {
            setUserSession(user.data);
        } else {
            setUserSession(null);
        }
    };

    useEffect(() => {
        getData();
    }, [location]);

    const handleLogout = () => {
        Swal.fire({
            title: "¿Estás seguro?",
            text: "Dale a continuar si quieres cerrar sesión",
            icon: "warning",
            showCancelButton: true,
            cancelButtonText: "Cancelar",
            confirmButtonText: "Continuar",
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
        }).then(async (result) => {
            if (result.isConfirmed) {
                const response = await useGetData("/api/user/logout");
                if (response.success) {
                    setUserSession(null);
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
        <AuthContext.Provider value={{ userSession, handleLogout }}>
            {children}
        </AuthContext.Provider>
    );
}

export default AuthContext;
