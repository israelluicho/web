SISTEMA DE BIBLIOTECA - PHP + MYSQL + BOOTSTRAP

REQUISITOS
- XAMPP (Apache, PHP 8+, MySQL/MariaDB)
- Navegador web

INSTALACIÓN EN XAMPP
1. Descomprima la carpeta biblioteca_php dentro de:
   C:\xampp\htdocs\
2. Abra XAMPP Control Panel e inicie Apache y MySQL.
3. Ingrese a http://localhost/phpmyadmin
4. Seleccione Importar y cargue el archivo database.sql.
   Esto crea la base de datos biblioteca_db y carga registros de ejemplo.
5. Revise config.php. Por defecto usa:
   host localhost | base biblioteca_db | usuario root | contraseña vacía
   Si su MySQL tiene otra contraseña, actualice DB_PASS.
6. Abra: http://localhost/biblioteca_php/login.php

ACCESO DEMO
Usuario: admin
Contraseña: Admin123*

MÓDULOS
- Login con contraseña almacenada mediante password_hash/password_verify.
- Dashboard con indicadores y préstamos recientes.
- Libros: registrar, listar, editar y eliminar.
- Lectores: registrar, listar, editar y eliminar.
- Préstamos: registrar, consultar y registrar devoluciones.
- Control de stock al prestar un libro.
- Consultas preparadas PDO, escape HTML y token CSRF en formularios POST.

NOTAS
- Bootstrap e iconos se cargan desde CDN; se requiere internet para el diseño.
- Cambie la contraseña de demostración antes de publicar el sistema en internet.
- Para producción añada permisos por rol, auditoría, copias de seguridad,
  validación adicional y HTTPS.
- Los datos son ficticios para pruebas.
