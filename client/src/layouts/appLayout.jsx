import { Outlet } from "react-router-dom";
import Header from "./header";
import Footer from "./footer";

// Toastify
import { ToastContainer } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";
import { AccessibilityWidget } from "sena-accessibility";
import "sena-accessibility/dist/index.css";

export default function AppLayout() {
    return (
        <>
            <AccessibilityWidget
                styles={{ "widget-primary": "#3b0764", "widget-secondary": "#7e22ce" }}
            />
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
