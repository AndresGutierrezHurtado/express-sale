### INTRODUCCIÓN

Express Sale es un sistema de información diseñado para facilitar la venta  y distribuición de productos de primera necesidad. 
Esta documentación proporciona instrucciones para la instalación del sistema y enumera las funcionalidades disponibles, así como las áreas que requieren desarrollo adicional.

### INSTALACIÓN:

1. Clonar el Repositorio:
    Clone el repositorio de Express Sale desde el repositorio remoto.

2. Configuración del Entorno:
    Asegúrese de tener instalado XAMPP.
    Inicie Apache, FileZilla y MySQL desde el panel de control de XAMPP.

3. Importar la Base de Datos:
    Localice el archivo 'express-sale-db.sql' en la ruta '/public/SQL/express-sale-db.sql'
    Abra phpMyAdmin desde su navegador web, generalmente accediendo a http://localhost/phpmyadmin.
    Haga clic en la pestaña "Importar" en la parte superior de la pantalla.
    Haga clic en el botón "Seleccionar archivo" y seleccione el archivo "express-sale-db.sql".

3. Inicio del Servidor:
    Abra la carpeta raíz del proyecto en la terminal.
    Ejecute el comando 'php -S localhost:3000'' para iniciar el servidor local.

### Estructura del Proyecto

El proyecto Express Sale sigue una estructura organizativa clara para facilitar su mantenimiento y comprensión. A continuación se detalla la disposición de los archivos y carpetas en la raíz del proyecto:

1. **index.php:**
   - Este archivo es el punto de entrada del proyecto. Contiene la lógica necesaria para iniciar el enrutador (router) y dirigir las solicitudes entrantes al controlador correspondiente.

2. **.htaccess:**
   - El archivo .htaccess se utiliza para configurar las reglas de reescritura de URL y garantizar que todas las solicitudes sean dirigidas correctamente al archivo index.php. Esto es fundamental para el funcionamiento del enrutador.

3. **app/:**
   - En esta carpeta se encuentran todos los componentes relacionados con la lógica de la aplicación.
     - **models/:** Contiene los modelos de datos, que se encargan de interactuar con la base de datos y realizar consultas.
     - **views/:** En esta carpeta se encuentran las vistas de la aplicación, que son archivos de plantillas utilizados para generar la interfaz de usuario.
     - **controllers/:** Aquí se almacenan los controladores, que son responsables de procesar las solicitudes del usuario y coordinar las acciones necesarias.
     - **services/:** Esta carpeta guarda servicios adicionales utilizados en la aplicación, como la conexión a la base de datos, PHP Mailer, FPDF para la generación de facturas, y un ORM para ejecutar operaciones CRUD.

4. **public/:**
   - Esta carpeta contiene archivos accesibles públicamente, como JavaScript, CSS e imágenes.

La arquitectura MVC (Modelo-Vista-Controlador) se sigue de manera estricta en la carpeta `app/`, donde los controladores se encargan de la lógica de la aplicación, los modelos interactúan con la base de datos y las vistas son manejadas por las plantillas o archivos de vistas. La carpeta `services/` contiene servicios adicionales que pueden ser utilizados por otros componentes de la aplicación.

Además, se ha implementado un ORM (Object-Relational Mapping) como parte de la estructura del modelo, el cual es una clase base que permite realizar operaciones CRUD (Create, Read, Update, Delete) en la base de datos. Este ORM es la clase padre de los modelos, lo que significa que los modelos heredan sus funcionalidades básicas y pueden personalizar las consultas según sea necesario desde los controladores.

### FUNCIONALIDADES ACTUALES:

- Index / Mail Footer: (Sección principal de la página, junto a un formulario de envío)
- Registro, contraseña olvidada e inicio de Sesión: (Registro de diferentes tipos de usuarios junto a la opción de recuperar sus credenciales)
- Productos: (Sección de productos, junto a su busqueda, filtro, organización, calificación y adición al carrito de compras)
- Perfil Público: (Prefil de los vendedores donde se encontrará su información y productos, teniendo la opción de calificarlos y ver sus comentarios)
- Carrito de Compras: (sección donde se verán los productos agregados al carrito, con opción de vaciar el carro, incrementar o decrementar su cantidad o eliminarlos)
- Formulario de Pago: (Formulario para ingresar la información del comprador que inclue la integración con Google Maps para la selección de direcciones de entrega precisas)
- Perfil de Usuario: (Permitir a los usuarios actualizar su información e imagen de perfil, ver sus compas, y como vendedor gestionar sus productos (añadir, eliminar, editar))
- Mi compra: (Sección donde los usuarios puedan ver la información de su compra y su factura)
- Entrega: (sección para la gestión de pedidos como domiciliario, donde se verá entregas pendientes por realizar junto a su ruta)
- Panel de Control: (panel de control para administradores con capacidades de búsqueda, clasificación, visualización y eliminación de usuarios y productos.)
 
### POR HACER:
 - perfil domiciliario
 - quitar el caché al perfil de usuario y de producto
 - mejorar el ui de la sección de ventas
 - cambiar firma factura
 - eliminación y reporte de comentarios
 - mostrar mensaje al domiciliario
 - mostrar vendedor en la sección de delivery
 - añadir ruta en waze y arreglar el de google maps
 - arreglar update user
 - perfil producto (zoom y calificaciones)