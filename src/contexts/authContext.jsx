import { useContext, createContext, useEffect, useState } from "react";
import { useLocation, useNavigate } from "react-router-dom";
import Swal from "sweetalert2";

// Hooks
import { useGetData } from "../hooks/useFetchData";

// Components
import Loading from "../components/pageLoading";

const AuthContext = createContext();
export const useAuthContext = () => useContext(AuthContext);

export function AuthProvider({ children }) {
    const [userSession, setUserSession] = useState(null);
    const [loading, setLoading] = useState(true);
    const location = useLocation();
    const navigate = useNavigate();

    const getData = async () => {
        const user = await useGetData("/api/user/session");
        if (user) {
            setLoading(false);
            
            if (user.success) {
                setUserSession(user.data);
            } else {
                setUserSession(null);
            }
        }
    }

    useEffect(() => {
        getData();
    }, [location, loading]);

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
                await useGetData("/api/user/logout").then(response => {
                    if (response.success) {
                        setLoading(true);
                        navigate("/")
                        Swal.fire({
                            icon: "info",
                            title: "Sesión cerrada",
                            text: response.message,
                        });
                    }
                });
            }
        });
    };

    const authMiddlewareAlert = message => {
        Swal.fire({
            icon: "error",
            title: "No tienes acceso a esta página/acción",
            text: message,
            cancelButtonText: "Cancelar",
            confirmButtonText: "Continuar",
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
        }).then(result => {
            navigate("/")
        });
    };

    if (loading) return <Loading />;

    return (
        <AuthContext.Provider
            value={{ userSession, loading, setLoading, handleLogout, authMiddlewareAlert }}
        >
            {children}
        </AuthContext.Provider>
    );
}
