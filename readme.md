# Express Sale

## Introducción

Express Sale es un sistema de información diseñado para facilitar la venta y distribución de productos de primera necesidad. Esta documentación proporciona instrucciones para la instalación del sistema, detalla las funcionalidades disponibles y menciona las áreas que requieren desarrollo adicional.

## Instalación

1. **Clonar el Repositorio:**
   - Clone el repositorio de Express Sale desde el repositorio remoto.

2. **Configuración del Entorno:**
   - Asegúrese de tener instalado XAMPP.
   - Inicie Apache, FileZilla y MySQL desde el panel de control de XAMPP.

3. **Importar la Base de Datos:**
   - Localice el archivo `express-sale-db.sql` en la ruta `/public/SQL/express-sale-db.sql`.
   - Abra phpMyAdmin desde su navegador web, generalmente accediendo a [http://localhost/phpmyadmin](http://localhost/phpmyadmin).
   - Haga clic en la pestaña "Importar" y seleccione el archivo `express-sale-db.sql`.

4. **Inicio del Servidor:**
   - Abra la carpeta raíz del proyecto en la terminal.
   - Ejecute el comando `php -S localhost:3000` para iniciar el servidor local.

## Estructura del Proyecto

El proyecto Express Sale sigue una arquitectura MVC (Modelo-Vista-Controlador) organizada de la siguiente manera:

1. **index.php:**
   - Punto de entrada del proyecto, encargado de iniciar el enrutador y dirigir las solicitudes al controlador correspondiente.

2. **.htaccess:**
   - Configura las reglas de reescritura de URL para que todas las solicitudes sean dirigidas al archivo `index.php`.

3. **app/:**
   - **models/:** Contiene los modelos de datos, responsables de interactuar con la base de datos.
   - **views/:** Contiene las vistas, que son plantillas utilizadas para generar la interfaz de usuario.
   - **controllers/:** Almacena los controladores, que procesan las solicitudes del usuario y coordinan las acciones necesarias.
   - **services/:** Incluye servicios adicionales como la conexión a la base de datos, PHP Mailer, FPDF para generación de facturas y un ORM para operaciones CRUD.

4. **public/:**
   - Carpeta que contiene archivos accesibles públicamente como JavaScript, CSS e imágenes.

El ORM implementado en el proyecto es una clase base para los modelos, facilitando las operaciones CRUD y permitiendo la personalización de consultas desde los controladores.

## Funcionalidades Actuales

- **Index / Mail Footer:** Sección principal de la página con un formulario de envío.
- **Registro, Contraseña Olvidada e Inicio de Sesión:** Registro de usuarios con opción para resetear la contraseña.
- **Productos:** Sección de productos con búsqueda, filtro, organización, link al perfil del producto y adición al carrito.
- **Perfil vendedor:** Perfil de vendedores con información y productos, incluyendo calificaciones y comentarios.
- **Carrito de Compras:** Visualización de productos en el carrito, con opciones para modificar la cantidad o eliminar artículos.
- **Formulario de Pago:** Formulario de información del comprador con integración de Google Maps para selección de direcciones.
- **Perfil de Usuario:** Actualización de información del usuario y gestión de productos para vendedores.
- **Mi Compra:** Información de compras y facturas de los usuarios.
- **Entrega:** Gestión de pedidos para domiciliarios, con visualización de entregas pendientes y rutas.
- **Panel de Control:** Panel para administradores con capacidades de búsqueda, clasificación y gestión de usuarios y productos.

## Por Hacer

- Seccion de estadísticas para vendedores y domiciliarios