import { Outlet } from "react-router-dom";
import Header from "./header";

// Toastify
import { ToastContainer } from "react-toastify";
import 'react-toastify/dist/ReactToastify.css';

export default function AppLayout() {
    return (
        <>
            <Header />
            <main>
                <Outlet />
            </main>
            <ToastContainer />
        </>
    );
}
