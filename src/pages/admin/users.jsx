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

    const {
        data: users,
        loading: usersLoading,
        reload: reloadUsers,
    } = useGetData(`/users?${searchParams.toString()}`);

    const updateParam = (key, value) => {
        const newSearchParams = new URLSearchParams(searchParams);
        newSearchParams.set(key, value);
        setSearchParams(newSearchParams);
    };

    const handleDeleteUser = (id, nombre) => {
        if (id == userSession.usuario_id) {
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
            <div className="card-body overflow-auto">
                <table className="table border">
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
                            <tr key={user.usuario_id}>
                                <td>{user.usuario_id}</td>
                                <td>
                                    {user.usuario_nombre}{" "}
                                    {user.usuario_apellido}
                                </td>
                                <td>{user.usuario_alias}</td>
                                <td>{user.usuario_correo}</td>
                                <td className="capitalize">
                                    {user.role.rol_nombre}
                                </td>
                                <td>
                                    <div className="flex justify-center items-center gap-2">
                                        <Link
                                            to={`/profile/user/${user.usuario_id}`}
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
                                                    user.usuario_id,
                                                    user.usuario_nombre
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
                <Pagination
                    data={users}
                    updateParam={updateParam}
                    searchParams={searchParams}
                />
            </div>
        </article>
    );
}
