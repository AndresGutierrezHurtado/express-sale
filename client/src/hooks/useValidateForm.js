import { toast } from "react-toastify";
import {
    email,
    length,
    maxValue,
    minLength,
    minValue,
    nonEmpty,
    object,
    parse,
    pipe,
    regex,
    string,
    ValiError,
} from "valibot";

export const useValidateform = (data = {}, form = "", extra = null) => {
    try {
        let schema;

        switch (form) {
            case "login-form":
                schema = object({
                    user_email: pipe(
                        nonEmpty("Correo requerido"),
                        string("Correo requerido"),
                        email("El correo debe ser válido")
                    ),
                    user_password: pipe(
                        nonEmpty("Contraseña requerida"),
                        string("Contraseña requerida"),
                        minLength(6, "La contraseña debe tener al menos 6 caracteres")
                    ),
                });
                break;
            case "register-form":
                schema = object({
                    user_name: pipe(
                        nonEmpty("Nombre requerido"),
                        string("Nombre requerido"),
                        minLength(3, "El nombre debe tener al menos 3 caracteres")
                    ),
                    user_lastname: pipe(
                        nonEmpty("Apellido requerido"),
                        string("Apellido requerido"),
                        minLength(3, "El apellido debe tener al menos 3 caracteres")
                    ),
                    user_alias: pipe(
                        nonEmpty("Alias requerido"),
                        string("Alias requerido"),
                        regex(
                            /^[a-zA-Z0-9-_]+$/,
                            "El nickname solo puede contener letras, números, guiones y guiones bajos."
                        ),
                        minLength(10, "El usuario debe tener al menos 10 caracteres")
                    ),
                    user_email: pipe(
                        nonEmpty("Correo requerido"),
                        string("Correo requerido"),
                        email("El correo debe ser válido")
                    ),
                    user_password: pipe(
                        nonEmpty("Contraseña requerida"),
                        string("Contraseña requerida"),
                        minLength(6, "La contraseña debe tener al menos 6 caracteres")
                    ),
                    role_id: pipe(nonEmpty("Rol requerido"), minLength(1, "El rol es requerido")),
                });
                break;
            case "contact-form":
                schema = object({
                    user_name: pipe(
                        nonEmpty("Nombre requerido"),
                        string("Nombre requerido"),
                        minLength(3, "El nombre es requerido")
                    ),
                    user_email: pipe(
                        nonEmpty("Correo requerido"),
                        string("Correo requerido"),
                        email("El correo debe ser válido")
                    ),
                    email_subject: pipe(
                        nonEmpty("Asunto requerido"),
                        string("Asunto requerido"),
                        minLength(10, "El asunto debe tener al menos 10 caracteres")
                    ),
                    email_message: pipe(
                        nonEmpty("Mensaje requerido"),
                        string("Mensaje requerido"),
                        minLength(15, "El mensaje debe tener al menos 15 caracteres")
                    ),
                });
                break;
            case "user-edit-form":
                schema = object({
                    user_name: pipe(
                        nonEmpty("Nombre requerido"),
                        string("Nombre requerido"),
                        minLength(3, "El nombre debe tener al menos 3 caracteres")
                    ),
                    user_lastname: pipe(
                        nonEmpty("Apellido requerido"),
                        string("Apellido requerido"),
                        minLength(3, "El apellido debe tener al menos 3 caracteres")
                    ),
                    user_alias: pipe(
                        nonEmpty("Alias requerido"),
                        string("Alias requerido"),
                        regex(
                            /^[a-zA-Z0-9-_]+$/,
                            "El nickname solo puede contener letras, números, guiones y guiones bajos."
                        ),
                        minLength(10, "El usuario debe tener al menos 10 caracteres")
                    ),
                    user_address: pipe(string("La dirección no es valida")),
                    user_phone: pipe(
                        string("El teléfono no es valido"),
                        regex(/^[0-9]*$/, "El teléfono solo puede contener números"),
                        regex(/^(?:\d{0}|\d{10})$/, "El telefono debe tener 10 digitos")
                    ),
                    worker_description: pipe(
                        regex(
                            /^(?:$|.{10,})$/,
                            "La descripción debe tener al menos 10 caracteres alfanuméricos"
                        )
                    ),
                    role_id: pipe(nonEmpty("Rol requerido"), minLength(1, "El rol es requerido")),
                });
                break;
            case "rate-form":
                schema = object({
                    rating_comment: pipe(
                        nonEmpty("El comentario es requerido"),
                        string("El comentario no es válido"),
                        minLength(10, "El comentario debe tener al menos 10 caracteres")
                    ),
                    rating_value: pipe(
                        nonEmpty("La calificación es requerida"),
                        number("La calificación no es valida"),
                        minValue(1, "Debes ingresar una calificación")
                    ),
                });
                break;
            case "update-product-form":
                schema = object({
                    product_name: pipe(
                        nonEmpty("El nombre es requerido"),
                        string("El nombre no es valido"),
                        minLength(3, "El nombre debe tener al menos 3 caracteres")
                    ),
                    product_price: pipe(
                        nonEmpty("El precio es requerido"),
                        string("El precio no es valido"),
                        minLength(3, "El precio debe tener al menos 3 digitos"),
                        regex(/^[0-9]*$/, "El precio debe tener solo números")
                    ),
                    product_description: pipe(
                        nonEmpty("La descripción es requerida"),
                        string("La descripción no es valida"),
                        minLength(10, "La descripción debe tener al menos 10 caracteres")
                    ),
                    product_quantity: pipe(
                        nonEmpty("La cantidad es requerida"),
                        string("La cantidad no es valida"),
                        minLength(1, "La cantidad debe tener al menos 1 caracter"),
                        regex(/^[0-9]*$/, "La cantidad debe tener solo números")
                    ),
                    product_status: pipe(
                        nonEmpty("El estado es requerido"),
                        string("El estado no es valido")
                    ),
                    category_id: pipe(
                        nonEmpty("La categoría es requerida"),
                        string("La categoría no es valida"),
                        minLength(1, "La categoría debe tener al menos 1 caracter"),
                        regex(/^[0-9]*$/, "La categoría debe tener solo números")
                    ),
                });
                break;
            case "create-product-form":
                schema = object({
                    product_name: pipe(
                        nonEmpty("El nombre es requerido"),
                        string("El nombre no es valido"),
                        minLength(3, "El nombre debe tener al menos 3 caracteres")
                    ),
                    product_price: pipe(
                        nonEmpty("El precio es requerido"),
                        string("El precio no es valido"),
                        minLength(3, "El precio debe tener al menos 3 digitos"),
                        regex(/^[0-9]*$/, "El precio debe tener solo números")
                    ),
                    product_description: pipe(
                        nonEmpty("La descripción es requerida"),
                        string("La descripción no es valida"),
                        minLength(10, "La descripción debe tener al menos 10 caracteres")
                    ),
                    product_quantity: pipe(
                        nonEmpty("La cantidad es requerida"),
                        string("La cantidad no es valida"),
                        minLength(1, "La cantidad debe tener al menos 1 caracter"),
                        regex(/^[0-9]*$/, "La cantidad debe tener solo números")
                    ),
                    product_status: pipe(
                        nonEmpty("El estado es requerido"),
                        string("El estado no es valido")
                    ),
                    category_id: pipe(
                        nonEmpty("La categoría es requerida"),
                        string("La categoría no es valida"),
                        minLength(1, "La categoría es requerida"),
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
                    payerMessage: pipe(
                        nonEmpty("El mensaje es requerido"),
                        string("El mensaje no es valido"),
                        minLength(3, "El mensaje debe tener al menos 3 caracteres")
                    ),
                });
                break;
            case "withdraw-modal-form":
                schema = object({
                    withdrawal_amount: pipe(
                        nonEmpty("El valor es requerido"),
                        string("El valor no es valido"),
                        regex(/^[0-9]*$/, "El valor debe tener solo números"),
                        minValue(10000, "El valor debe ser mayor a 10,000"),
                        maxValue(
                            parseInt(extra.trabajador_saldo),
                            `El valor debe ser menor a tu saldo: ${parseInt(
                                extra.trabajador_saldo
                            ).toLocaleString("es-CO")} COP`
                        )
                    ),
                });
                break;
            case "recovery-form":
                schema = object({
                    user_email: pipe(
                        nonEmpty("El correo es requerido"),
                        string("El correo no es valido"),
                        email("El correo no es valido")
                    ),
                });
                break;
            case "reset-password-form":
                schema = object({
                    user_password: pipe(
                        nonEmpty("Contraseña requerida"),
                        string("Contraseña requerida"),
                        minLength(6, "La contraseña debe tener al menos 6 caracteres")
                    ),
                    user_password_confirm: pipe(
                        nonEmpty("Contraseña requerida"),
                        string("Contraseña requerida"),
                        minLength(6, "La contraseña debe tener al menos 6 caracteres")
                    ),
                });

                break;
            default:
                return { success: false, message: "Formulario no encontrado", data: null };
                break;
        }

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

        const finalData = parse(schema, data);
        if (form === "reset-password-form" && data.user_password !== data.user_password_confirm) {
            if (data.user_password !== data.user_password_confirm) {
                throw new ValiError([
                    {
                        path: [{ key: "user_password" }],
                        message: "Las contraseñas no coinciden",
                    },
                    {
                        path: [{ key: "user_password_confirm" }],
                        message: "Las contraseñas no coinciden",
                    },
                ]);
            }
        }

        return { success: true, message: "Formulario valido", data: finalData };
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
