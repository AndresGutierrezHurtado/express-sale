import { Outlet } from "react-router-dom";

export default function WorkerLayout() {
    return (
        <>
            <div className="drawer lg:drawer-open">
                <input id="my-drawer-2" type="checkbox" className="drawer-toggle" />
                <div className="drawer-content flex flex-col">
                    {/* Page content here */}
                    <Outlet />
                </div>
                <div className="drawer-side">
                    <label
                        htmlFor="my-drawer-2"
                        aria-label="close sidebar"
                        className="drawer-overlay"
                    ></label>
                    <ul className="menu bg-base-200 text-base-content min-h-full w-80 p-4">
                        {/* Sidebar content here */}
                        <div>
                            <li>
                                <a>Estadísticas</a>
                            </li>
                            <li>
                                <a>Productos</a>
                            </li>
                        </div>
                    </ul>
                </div>
            </div>
        </>
    );
}
