import { Outlet } from "react-router-dom";
import Header from "./header";

export default function AppLayout() {
    return (
        <>
            <Header />
            <main>
                <Outlet />
            </main>
        </>
    );
}
