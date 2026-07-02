# 🍔 Burger Tech - Panel de Administración MVC

Aplicación web dinámica desarrollada en PHP y MySQL para la gestión de un menú de hamburguesería utilizando el patrón arquitectónico Modelo-Vista-Controlador (MVC).

**Desarrollado por:** ANGEL LOOR Y ROBINSON RICAURTE 
**Curso:** DAW 2026  

##  Requisitos Mínimos Cumplidos
- **CRUD Completo:** Gestión de dos entidades relacionadas (`productos` y `categorias`).
- **Arquitectura:** Separación estricta de lógica en capas (Modelo, Vista, Controlador).
- **Validación Dual:** Controles de consistencia en Frontend (JavaScript) y Backend (PHP).

##  Instrucciones de Ejecución Local
1. Clonar este repositorio dentro del servidor web (`wwwroot` o `htdocs`).
2. Importar el script de la base de datos ubicado en `/database/database.sql` utilizando HeidiSQL.
3. Configurar las credenciales de conexión en el archivo `/app/config/Database.php`.
4. Activar la extensión `pdo_mysql` en el administrador del servidor (IIS/XAMPP).
5. Acceder desde el navegador a: `http://localhost/burger-tech/public/index.php`.
