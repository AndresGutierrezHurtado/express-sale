import { Outlet } from "react-router-dom";
import { useAuthContext } from "@contexts/authContext";

export default function AuthMiddleware({ type = "auth" }) {
    const { userSession, loading, authMiddlewareAlert } = useAuthContext();

    if (type == "guest") {
        if (!loading && userSession) {
            authMiddlewareAlert("Ya iniciaste sesión");
        }
    } else {
        if (!loading && !userSession) {
            authMiddlewareAlert("Si deseas autenticarte, presiona el botón de continuar");
        }
    }

    return <Outlet />;
}