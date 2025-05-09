# Proyecto-FCT
Aplicación web para la gestión integral de una clínica podológica. Permite la administración de pacientes, citas, historiales clínicos y servicios, tanto por parte del personal administrativo como del propio paciente.


---

## 🚀 Instalación

1. Clona o descarga el repositorio.
2. Usa un servidor local como **XAMPP**, **WAMP** o similar.
3. Copia el proyecto dentro de `htdocs/` o el directorio raíz de tu servidor.
4. Crea una base de datos en **MySQL** y ejecuta el script `esquema.sql` si está disponible.
5. Configura tu archivo `/Codigo/conexion/conexion.php` con tus credenciales de base de datos.

---

## 🧪 Funcionalidades

### Para pacientes:
- Registro e inicio de sesión.
- Edición de perfil (email, teléfono, sexo, fecha nacimiento).
- Reservar, pagar y cancelar citas.

### Para administradores:
- Búsqueda y gestión de pacientes.
- Creación, edición y visualización de historiales clínicos.
- Gestión de servicios: agregar, editar y eliminar.
- Control de citas: bloquear, desbloquear.
- Alta/baja de pacientes temporales.

---

## 🛠 Tecnologías

- PHP 8+
- MySQL
- HTML/CSS/JavaScript
- jQuery
- Stripe API (pagos online)
- Google Calendar API (sincronización de citas)
- `IntlDateFormatter` (formateo de fechas en español)

---

## 🔐 Seguridad y Acceso

- Control de acceso mediante sesiones (`$_SESSION`).
- Roles diferenciados para **paciente** y **administrador**.
- Acceso restringido a funciones críticas.

---

## 💡 Notas Adicionales

- Responsive: se adapta a móviles y tablets.
- Las citas están separadas por franjas horarias.
- Historial clínico flexible: no requiere todos los campos.
- El sistema permite gestionar pacientes temporales y permanentes.

---

## ✍️ Autor

**Daniel Godoy Medina**  
Desarrollador del sistema como parte de prácticas del grado superior de desarrollo de aplicaciones web.

