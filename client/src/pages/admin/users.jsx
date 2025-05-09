import React from "react";
import { Link, useSearchParams } from "react-router-dom";
import Swal from "sweetalert2";

// Hooks
import { useGetData } from "@hooks/useFetchData.js";

// Components
import { PencilIcon, TrashIcon } from "@components/icons.jsx";
import ContentLoading from "@components/contentLoading.jsx";
import Pagination from "@components/pagination";

// Hooks
import { useDeleteData } from "@hooks/useFetchData.js";

// Contexts
import { useAuthContext } from "@contexts/authContext.jsx";

export default function UsersAdmin() {
    const [searchParams, setSearchParams] = useSearchParams();
    const { userSession } = useAuthContext();

    const updateParam = (key, value) => {
        const newSearchParams = new URLSearchParams(searchParams);
        newSearchParams.set(key, value);
        setSearchParams(newSearchParams);
    };

    const {
        data: users,
        loading: usersLoading,
        reload: reloadUsers,
    } = useGetData(`/users?${searchParams.toString()}`);

    const handleDeleteUser = (id, nombre) => {
        if (id == userSession.user_id) {
            Swal.fire({
                icon: "error",
                title: "Accion fallida",
                text: "No puedes eliminar tu propia cuenta.",
            });
            return null;
        }
        Swal.fire({
            icon: "warning",
            title: `¿Estás Seguro de eliminar al usuario ${nombre}`,
            text: "Esta acción será irrevertible.",
            showCancelButton: true,
            cancelButtonColor: "red",
            cancelButtonText: "Cancelar",
            confirmButtonColor: "blue",
            confirmButtonText: "Eliminar",
        }).then(async (result) => {
            if (result.isConfirmed) {
                const response = await useDeleteData(`/users/${id}`);
                if (response.success) {
                    reloadUsers();
                }
            }
        });
    };

    if (usersLoading) return <ContentLoading />;
    return (
        <article className="card bg-white max-w-[1000px] shadow-xl mx-auto my-10">
            <div className="card-body">
                <div className="overflow-auto border border-base-300/60 rounded">
                    <table className="table">
                        <thead className="bg-gray-200">
                            <tr>
                                <td>ID</td>
                                <td>Nombre</td>
                                <td>Usuario</td>
                                <td>Correo</td>
                                <td>Rol</td>
                                <td className="text-center">Acciones</td>
                            </tr>
                        </thead>
                        <tbody className="text-xs">
                            {users.rows.map((user) => (
                                <tr key={user.user_id}>
                                    <td>{user.user_id}</td>
                                    <td>
                                        {user.user_name} {user.user_lastname}
                                    </td>
                                    <td>{user.user_alias}</td>
                                    <td>{user.user_email}</td>
                                    <td className="capitalize">{user.role.role_name}</td>
                                    <td>
                                        <div className="flex justify-center items-center gap-2">
                                            <Link
                                                to={`/profile/user/${user.user_id}`}
                                                className="btn btn-sm min-h-none h-auto py-2.5 pl-8 relative bg-gray-200 hover:bg-gray-200 text-gray-500 hover:text-gray-600"
                                            >
                                                <span className="absolute left-3 top-1/2 transform -translate-y-1/2">
                                                    <PencilIcon />
                                                </span>
                                                Editar
                                            </Link>
                                            <button
                                                onClick={() =>
                                                    handleDeleteUser(
                                                        user.user_id,
                                                        user.user_name
                                                    )
                                                }
                                                className="btn btn-sm min-h-none h-auto py-2.5 pl-8 relative bg-red-600 hover:bg-red-700 text-red-300 hover:text-red-200"
                                            >
                                                <span className="absolute left-3 top-1/2 transform -translate-y-1/2">
                                                    <TrashIcon />
                                                </span>
                                                Eliminar
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
                <nav className="flex flex-col md:flex-row justify-between">
                    <Pagination
                        data={users}
                        updateParam={updateParam}
                        searchParams={searchParams}
                    />
                </nav>
            </div>
        </article>
    );
}
