import { toast } from "react-toastify";
import { email, length, minLength, nonEmpty, object, parse, pipe, regex, string } from "valibot";

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
                    minLength(6, "La contraseña debe tener al menos 6 caracteres")
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
                    regex(
                        /^[a-zA-Z0-9-_]+$/,
                        "El nickname solo puede contener letras, números, guiones y guiones bajos."
                    ),
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
                    minLength(6, "La contraseña debe tener al menos 6 caracteres")
                ),
                rol_id: pipe(
                    nonEmpty("Rol requerido"),
                    string("Rol requerido"),
                    minLength(1, "El rol es requerido")
                ),
            });
            break;
        case "contact-form":
            schema = object({
                usuario_nombre: pipe(
                    nonEmpty("Nombre requerido"),
                    string("Nombre requerido"),
                    minLength(3, "El nombre es requerido")
                ),
                usuario_correo: pipe(
                    nonEmpty("Correo requerido"),
                    string("Correo requerido"),
                    email("El correo debe ser válido")
                ),
                correo_asunto: pipe(
                    nonEmpty("Nombre requerido"),
                    string("Nombre requerido"),
                    minLength(10, "El nombre es requerido")
                ),
                correo_mensaje: pipe(
                    nonEmpty("Nombre requerido"),
                    string("Nombre requerido"),
                    minLength(15, "El nombre es requerido")
                ),
            });
            break;
        case "user-edit-modal-form":
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
                    regex(
                        /^[a-zA-Z0-9-_]+$/,
                        "El nickname solo puede contener letras, números, guiones y guiones bajos."
                    ),
                    minLength(10, "El usuario debe tener al menos 10 caracteres")
                ),
                usuario_direccion: pipe(string("La dirección no es valida")),
                usuario_telefono: pipe(
                    string("El teléfono no es valido"),
                    regex(/^[0-9]*$/, "El teléfono solo puede contener números"),
                    regex(/^(?:\d{0}|\d{10})$/, "El telefono debe tener 10 digitos")
                ),
                trabajador_descripcion: pipe(
                    regex(/^$|^.{3,}$/, "La descripción debe tener al menos 3 caracteres")
                ),
            });
            break;
        case "rate-form":
            schema = object({
                calificacion_comentario: pipe(
                    nonEmpty("El comentario es requerido"),
                    string("El comentario no es válido"),
                    minLength(10, "El comentario debe tener al menos 10 caracteres")
                ),
                calificacion: pipe(
                    nonEmpty("La calificación es requerida"),
                    string("La calificación no es valida"),
                    length(1, "Debes ingresar una calificación válida")
                ),
            });
            break;
        case "update-product-form":
            schema = object({
                producto_nombre: pipe(
                    nonEmpty("El nombre es requerido"),
                    string("El nombre no es valido"),
                    minLength(3, "El nombre debe tener al menos 3 caracteres")
                ),
                producto_precio: pipe(
                    nonEmpty("El precio es requerido"),
                    string("El precio no es valido"),
                    minLength(3, "El precio debe tener al menos 3 digitos"),
                    regex(/^[0-9]*$/, "El precio debe tener solo números")
                ),
                producto_descripcion: pipe(
                    nonEmpty("La descripción es requerida"),
                    string("La descripción no es valida"),
                    minLength(10, "La descripción debe tener al menos 10 caracteres")
                ),
                producto_cantidad: pipe(
                    nonEmpty("La cantidad es requerida"),
                    string("La cantidad no es valida"),
                    minLength(1, "La cantidad debe tener al menos 1 caracter"),
                    regex(/^[0-9]*$/, "La cantidad debe tener solo números")
                ),
                producto_estado: pipe(
                    nonEmpty("El estado es requerido"),
                    string("El estado no es valido")
                ),
                categoria_id: pipe(
                    nonEmpty("La categoría es requerida"),
                    string("La categoría no es valida"),
                    minLength(1, "La categoría debe tener al menos 1 caracter"),
                    regex(/^[0-9]*$/, "La categoría debe tener solo números")
                ),
            });
            break;
        case "create-product-form":
            schema = object({
                producto_nombre: pipe(
                    nonEmpty("El nombre es requerido"),
                    string("El nombre no es valido"),
                    minLength(3, "El nombre debe tener al menos 3 caracteres")
                ),
                producto_precio: pipe(
                    nonEmpty("El precio es requerido"),
                    string("El precio no es valido"),
                    minLength(3, "El precio debe tener al menos 3 digitos"),
                    regex(/^[0-9]*$/, "El precio debe tener solo números")
                ),
                producto_descripcion: pipe(
                    nonEmpty("La descripción es requerida"),
                    string("La descripción no es valida"),
                    minLength(10, "La descripción debe tener al menos 10 caracteres")
                ),
                producto_cantidad: pipe(
                    nonEmpty("La cantidad es requerida"),
                    string("La cantidad no es valida"),
                    minLength(1, "La cantidad debe tener al menos 1 caracter"),
                    regex(/^[0-9]*$/, "La cantidad debe tener solo números")
                ),
                producto_estado: pipe(
                    nonEmpty("El estado es requerido"),
                    string("El estado no es valido")
                ),
                categoria_id: pipe(
                    nonEmpty("La categoría es requerida"),
                    string("La categoría no es valida"),
                    minLength(1, "La categoría debe tener al menos 1 caracter"),
                    regex(/^[0-9]*$/, "La categoría debe tener solo números")
                ),
            });
            break;
        case "pay-form":
            schema = object({
                amount: pipe(
                    nonEmpty("La cantidad es requerida"),
                    string("La cantidad no es valida"),
                    minLength(1, "La cantidad debe tener al menos 1 caracter"),
                    regex(/^[0-9]*$/, "La cantidad debe tener solo números")
                ),
                buyerEmail: pipe(
                    nonEmpty("El correo es requerido"),
                    string("El correo no es valido"),
                    email("El correo no es valido")
                ),
                buyerFullName: pipe(
                    nonEmpty("El nombre es requerido"),
                    string("El nombre no es valido"),
                    minLength(3, "El nombre debe tener al menos 3 caracteres")
                ),
                payerDocument: pipe(
                    nonEmpty("El documento es requerido"),
                    string("El documento no es valido"),
                    minLength(3, "El documento debe tener al menos 3 caracteres")
                ),
                payerPhone: pipe(
                    nonEmpty("El telefono es requerido"),
                    string("El telefono no es valido"),
                    minLength(3, "El telefono debe tener al menos 3 caracteres")
                ),
                shippingAddress: pipe(
                    nonEmpty("La dirección es requerida"),
                    string("La dirección no es valida"),
                    minLength(3, "La dirección debe tener al menos 3 caracteres")
                ),
            });
            break;
        default:
            return { success: false, message: "Formulario no encontrado", data: null };
            break;
    }

    try {
        document.querySelectorAll(`.input-error`).forEach((input) => {
            input
                .closest(".form-control")
                .querySelectorAll(".label-error")
                .forEach((element) => element.remove());
            input.classList.remove("input-error");
            input.classList.remove("focus:input-error");
            input.classList.remove("select-error");
            input.classList.remove("focus:select-error");
            input.classList.remove("textarea-error");
            input.classList.remove("focus:textarea-error");
        });

        return { success: true, message: "Formulario valido", data: parse(schema, data) };
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

            document.querySelectorAll(`[name="${issue.path[0].key}"]`).forEach((input) => {
                input.classList.add("input-error");
                input.classList.add("focus:input-error");
                input.classList.add("select-error");
                input.classList.add("focus:select-error");
                input.classList.add("textarea-error");
                input.classList.add("focus:textarea-error");

                const errorLabel = document.createElement("label");
                errorLabel.className = "label-error text-red-500";
                errorLabel.textContent = issue.message;
                input.closest(".form-control").appendChild(errorLabel);
            });
        });

        return { success: false, message: "Formulario no valido", errors: fieldErrors };
    }
};
