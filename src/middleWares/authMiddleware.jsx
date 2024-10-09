import { Outlet } from "react-router-dom";
import { useAuthContext } from "../context/authContext";

export default function AuthMiddleware({ type = "auth" }) {
    const { userSession, authMiddlewareAlert } = useAuthContext();

    if (type == "guest") {
        if (userSession.logged == true) {
            authMiddlewareAlert("Ya iniciaste sesión");
        }
    } else {
        if (userSession.logged == false) {
            authMiddlewareAlert("Si deseas autenticarte, presiona el botón de continuar");
        }
    }

    return <Outlet />;
}