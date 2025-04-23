// Components
import ContentLoading from "../contentLoading.jsx";
import { RegisterIcon } from "../icons";

// Hooks
import { useValidateform } from "@hooks/useValidateForm";
import { usePutData } from "@hooks/useFetchData";
import { useConvertImage } from "@hooks/useConvertImage";
import { useMapsApiLoader, useAddressAutocomplete } from "@hooks/useMaps";

export function UserEditModal({ user, reload }) {
    const isLoaded = useMapsApiLoader();

    if (isLoaded) useAddressAutocomplete("user_address");

    const handleUpdateUserSubmit = async (event) => {
        event.preventDefault();

        const data = Object.fromEntries(new FormData(event.target));
        const validation = useValidateform(data, "user-edit-form");

        if (validation.success) {
            const response = await usePutData(`/users/${user.user_id}`, {
                user: {
                    user_name: data.user_name,
                    user_lastname: data.user_lastname,
                    user_alias: data.user_alias,
                    user_phone: data.user_phone ? data.user_phone : null,
                    user_address: data.user_address ? data.user_address : null,
                },
                worker: {
                    worker_description: data.worker_description,
                },
                user_image:
                    data.user_image.size > 0 ? await useConvertImage(data.user_image) : null,
            });
            if (response.success) reload();
        }
    };

    return (
        <dialog id="user-edit-modal" className="modal">
            <div className="modal-box w-full max-w-[800px]">
                <form method="dialog">
                    <button className="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">
                        ✕
                    </button>
                </form>
                <h3 className="text-lg font-bold">Editar perfil:</h3>
                <p className="py-4">Cambia la información de tu perfil.</p>
                <form
                    onSubmit={handleUpdateUserSubmit}
                    className="space-y-3 [&_input:focus]:input-primary [&_input:focus]:outline-0"
                >
                    <fieldset className="w-full fieldset">
                        <div className="fieldset-label text-sm after:content-['*'] after:text-red-500">
                            Imagen:
                        </div>
                        <input
                            type="file"
                            className="w-full file-input file-input-primary file-input-bordered"
                            name="user_image"
                        />
                    </fieldset>
                    <fieldset className="w-full fieldset">
                        <div className="fieldset-label text-sm after:content-['*'] after:text-red-500">
                            Nombres:
                        </div>
                        <input
                            placeholder="Ingresa tus nombre"
                            className="w-full input input-bordered"
                            defaultValue={user.user_name}
                            name="user_name"
                        />
                    </fieldset>
                    <fieldset className="w-full fieldset">
                        <div className="fieldset-label text-sm after:content-['*'] after:text-red-500">
                            Apellidos:
                        </div>
                        <input
                            placeholder="Ingresa tus apellidos"
                            className="w-full input input-bordered"
                            defaultValue={user.user_lastname}
                            name="user_lastname"
                        />
                    </fieldset>
                    <fieldset className="w-full fieldset">
                        <div className="fieldset-label text-sm after:content-['*'] after:text-red-500">
                            Correo electrónico:
                        </div>
                        <input
                            placeholder="Ingresa tu correo principal de contacto"
                            className="w-full input input-bordered"
                            defaultValue={user.user_email}
                            disabled
                        />
                    </fieldset>
                    <fieldset className="w-full fieldset">
                        <div className="fieldset-label text-sm after:content-['*'] after:text-red-500">
                            Usuario:
                        </div>
                        <input
                            placeholder="Ingresa tu usuario, debe ser unico"
                            className="w-full input input-bordered"
                            defaultValue={user.user_alias}
                            name="user_alias"
                        />
                    </fieldset>
                    <fieldset className="w-full fieldset">
                        <div className="fieldset-label text-sm after:content-['*'] after:text-red-500">
                            Telefono:
                        </div>
                        <input
                            placeholder="Ingresa tu telefono principal de contacto"
                            className="w-full input input-bordered"
                            defaultValue={user.user_phone}
                            name="user_phone"
                        />
                    </fieldset>
                    <fieldset className="w-full fieldset">
                        <div className="fieldset-label text-sm after:content-['*'] after:text-red-500">
                            Direccion:
                        </div>
                        <input
                            placeholder="Ingresa la dirección precisa de tu vivienda/oficina"
                            className="w-full input input-bordered"
                            defaultValue={user.user_address}
                            name="user_address"
                        />
                    </fieldset>
                    {user.worker && (
                        <fieldset className="w-full fieldset">
                            <div className="fieldset-label text-sm after:content-['*'] after:text-red-500">
                                Descripción:
                            </div>
                            <textarea
                                className="w-full textarea textarea-bordered focus:outline-0 focus:border-primary resize-none h-24"
                                placeholder="Bio"
                                defaultValue={user.worker.worker_description}
                                name="worker_description"
                            ></textarea>
                        </fieldset>
                    )}
                    <fieldset className="w-full fieldset">
                        <button className="btn btn-primary group relative text-purple-300 hover:bg-purple-800 hover:text-purple-100 text-sm">
                            <span className="absolute left-3 top-1/2 transform -translate-y-1/2 text-purple-300 group-hover:text-purple-100">
                                <RegisterIcon />
                            </span>
                            Guardar cambios
                        </button>
                    </fieldset>
                </form>
            </div>
            <form method="dialog" className="modal-backdrop bg-black/50">
                <button>close</button>
            </form>
        </dialog>
    );
}
