import { useContext, createContext, useEffect, useState } from "react";
import { useGetData } from "../hooks/useFetchData";

const AuthContext = createContext();
export const useAuthContext = () => useContext(AuthContext);

export function AuthProvider({ children }) {
    const [userSession, setUserSession] = useState(null);

    const getData = async () => {
        const user = await useGetData("/api/user/session");
        if (user.success) {
            setUserSession(user.data);
        }
    };

    useEffect(() => {
        getData();
    }, [window.location.href, window.location, window.location.pathname]);

    return (
        <AuthContext.Provider value={{ userSession }}>
            {children}
        </AuthContext.Provider>
    );
}

export default AuthContext;
