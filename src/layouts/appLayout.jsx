import { Outlet } from "react-router-dom";
import Header from "./header";
import Footer from "./footer";

// Toastify
import { ToastContainer } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";

export default function AppLayout() {
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
