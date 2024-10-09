import { useParams } from "react-router-dom";
import { useGetData } from "../../hooks/useFetchData";
import { useAuthContext } from "../../context/authContext";

// Icons
import { PencilIcon } from "../icons";

export default function IndexUserProfile() {
    const { id } = useParams();
    const { userSession } = useAuthContext();

    const user = id ? useGetData(`/api/users/${id}`) : userSession;
    return (
        <section className="w-full px-3">
            <div className="w-full max-w-[1200px] mx-auto py-5">
                <h3 className="text-4xl font-extrabold"> Perfil del usuario <span className="text-primary">{user.usuario_nombre} {user.usuario_apellido}</span> </h3>
                <div className="card bg-base-100 w-full shadow-xl">
                    <div className="card-body">
                        <div>
                            <div className="avatar relative">
                                <div className="badge bg-white badge-lg absolute bottom-[7%] right-[7%] p-[1px]">
                                    <div className="w-full h-full bg-green-500 rounded-full [&_svg]:fill-black">
                                        <PencilIcon  />
                                    </div>
                                </div>

                                <div className="w-[200px] rounded-full">
                                    <img src={user.usuario_imagen_url} />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    );
}