import { Outlet } from "react-router-dom";

export default function GuestLayout() {
    return (
        <main>
            <Outlet />
        </main>
    );
}