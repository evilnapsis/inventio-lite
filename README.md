# Inventio Lite v4.2

Inventio Lite es un sistema moderno de Inventario, Punto de Venta (POS) y Gestión Comercial de propósito general desarrollado en **PHP** y **MySQL**.

---

## 🚀 Novedades y Actualizaciones (2026)

- **Arquitectura MVC con Enrutamiento Limpio**: Implementación de **FastRoute** para URLs amigables (ej: `/home`, `/pos`, `/products`, `/profile`, `/settings`).
- **Motor de Plantillas Twig**: Transición a vistas desacopladas y declarativas con soporte para herencia de layouts y seguridad integrada.
- **Seguridad Integrada**: Protección contra ataques **CSRF** en todos los formularios mediante tokens únicos por sesión.
- **Capa de Servicios**: Desacoplamiento de la lógica de negocio en clases de servicio dedicadas (`ProductService`, `SellService`, `ConfigurationService`, etc.).
- **Gestión de Perfil y Ajustes del Sistema**:
  - Módulo **Mi Perfil** (`/profile`): Seguridad, datos de cuenta y cambio de contraseña con notificaciones interactivas.
  - Módulo **Ajustes** (`/settings`): Gestión dinámica de parámetros globales almacenados en base de datos.
- **Interfaz de Usuario Moderna**: Plantilla integrada con **CoreUI v4**, componentes **Bootstrap 5**, **Bootstrap Icons**, **DataTables** y notificaciones con **SweetAlert2**.

---

## 📦 Módulos Principales

- **Dashboard / Inicio**: Métricas de resumen del sistema.
- **Vender POS**: Punto de venta ágil con carrito interactivo y búsqueda instantánea.
- **Ventas & Compras**: Historial detallado de operaciones de salida y abastecimiento.
- **Catálogos**: Productos, Categorías, Clientes y Proveedores.
- **Inventario**: Control de existencias, histórico de movimientos y alertas de stock mínimo.
- **Caja**: Apertura, registro de operaciones y historial de cierres de caja.
- **Reportes**: Reportes de movimientos de inventario y reportes de ventas filtrables.
- **Administración**: Gestión de usuarios, perfiles y ajustes del sistema.

---

## 🛠️ Requisitos del Sistema

- **Servidor Web**: Apache (con módulo `mod_rewrite` activado) o Nginx.
- **PHP**: versión 7.4 o superior (recomendado PHP 8.x) con extensión PDO/MySQLi.
- **Base de Datos**: MySQL 5.7+ / MariaDB 10.3+.
- **Gestor de dependencias**: Composer.

---

## ⚙️ Instalación y Configuración

1. **Clonar o descargar el repositorio**:
   Coloca el proyecto en el directorio raíz de tu servidor web (ej. `htdocs` en XAMPP/LAMPP).

2. **Instalar dependencias de Composer**:
   ```bash
   composer install
   ```

3. **Base de Datos**:
   Crea la base de datos `inventiolite` en MySQL e importa la estructura y datos iniciales del archivo `schema.sql`:
   ```sql
   CREATE DATABASE inventiolite;
   USE inventiolite;
   SOURCE schema.sql;
   ```

4. **Configuración de Conexión**:
   Edita los parámetros de conexión a la base de datos en [`core/controller/Database.php`](file:///c:/xampp/htdocs/inventio-lite/core/controller/Database.php):
   ```php
   $this->user = "root";
   $this->pass = "";
   $this->host = "localhost";
   $this->ddbb = "inventiolite";
   ```

5. **Acceso**:
   Abre tu navegador web e ingresa a `http://localhost/inventio-lite/`.

6. **Credenciales por defecto**:
   - **Usuario**: `admin` (o `juan@example.com` con datos demo)
   - **Contraseña**: `admin`

---

## 📄 Más Información y Créditos

Encuentra más información, instrucciones y demos en el siguiente enlace:
- **Link del Proyecto**: http://evilnapsis.com/2015/07/11/inventio-lite-sistema-de-inventario-y-ventas/

Desarrollado por [Evilnapsis](https://evilnapsis.com/).