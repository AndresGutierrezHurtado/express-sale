import { Outlet } from "react-router-dom";
import Header from "./header";
import Footer from "./footer";

// Toastify
import { ToastContainer } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";

// Contexts
import { useAuthContext } from "../context/authContext";
import Loading from "../components/loading";

export default function AppLayout() {
    const { loading } = useAuthContext();

    if (loading) return <Loading />;

    return (
        <>
            <div className="flex flex-col min-h-screen">
                <Header />
                <main className="flex-1">
                    <Outlet />
                </main>
                <Footer />
            </div>
            <ToastContainer />
        </>
    );
}
