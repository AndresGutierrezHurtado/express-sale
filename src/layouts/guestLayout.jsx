import { Outlet } from "react-router-dom";

// Toastify
import { ToastContainer } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";

export default function GuestLayout() {
    return (
        <>
            <main>
                <Outlet />
            </main>
            <ToastContainer />
        </>
    );
}
