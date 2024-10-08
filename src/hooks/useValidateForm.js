import { toast } from "react-toastify";
import {
    email,
    minLength,
    nonEmpty,
    object,
    parse,
    pipe,
    string,
    trim,
} from "valibot";

export const useValidateform = (data = {}, form = "") => {
    let schema;

    switch (form) {
        case "login-form":
            schema = object({
                usuario_correo: pipe(
                    nonEmpty("Correo requerido"),
                    string("Correo requerido"),
                    email("El correo debe ser válido")
                ),
                usuario_contra: pipe(
                    nonEmpty("Contraseña requerida"),
                    string("Contraseña requerida"),
                    minLength(
                        6,
                        "La contraseña debe tener al menos 6 caracteres"
                    )
                ),
            });
            break;
        case "register-form":
            schema = object({
                usuario_nombre: pipe(
                    nonEmpty("Nombre requerido"),
                    string("Nombre requerido"),
                    minLength(3, "El nombre debe tener al menos 3 caracteres")
                ),
                usuario_apellido: pipe(
                    nonEmpty("Apellido requerido"),
                    string("Apellido requerido"),
                    minLength(3, "El apellido debe tener al menos 3 caracteres")
                ),
                usuario_alias: pipe(
                    nonEmpty("Alias requerido"),
                    string("Alias requerido"),
                    trim("El usuario no debe tener espacios"),
                    minLength(10, "El usuario debe tener al menos 10 caracteres")
                ),
                usuario_correo: pipe(
                    nonEmpty("Correo requerido"),
                    string("Correo requerido"),
                    email("El correo debe ser válido")
                ),
                usuario_contra: pipe(
                    nonEmpty("Contraseña requerida"),
                    string("Contraseña requerida"),
                    minLength(
                        6,
                        "La contraseña debe tener al menos 6 caracteres"
                    )
                ),
                rol_id: pipe(
                    nonEmpty("Rol requerido"),
                    string("Rol requerido"),
                    minLength(1, "El rol es requerido")
                ),
            });
            break;
        default:
            return { success: false };
            break;
    }

    try {
        document.querySelectorAll(`.input-error`).forEach((input) => {
            input
                .closest(".form-control")
                .querySelector(".label-error")
                .remove();
            input.classList.remove("input-error");
            input.classList.remove("select-error");
            input.classList.remove("focus:input-error");
            input.classList.remove("focus:select-error");
        });

        return { success: true, data: parse(schema, data) };
    } catch (error) {
        let fieldErrors = [];

        error.issues.forEach((issue) => {
            fieldErrors.push({
                field: issue.path[0].key,
                message: issue.message,
            });

            toast.error(issue.message, {
                theme: "colored",
                position: "bottom-right",
                autoClose: 3000,
                pauseOnHover: false,
            });

            document
                .querySelectorAll(`[name="${issue.path[0].key}"]`)
                .forEach((input) => {
                    input.classList.add("input-error");
                    input.classList.add("select-error");
                    input.classList.add("focus:input-error");
                    input.classList.add("focus:select-error");

                    const errorLabel = document.createElement("label");
                    errorLabel.className = "label-error text-red-500";
                    errorLabel.textContent = issue.message;
                    input.closest(".form-control").appendChild(errorLabel);
                });
        });

        return { success: false, errors: fieldErrors };
    }
};
