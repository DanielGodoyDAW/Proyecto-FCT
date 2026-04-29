# Proyecto-FCT
Aplicación web para la gestión integral de una clínica podológica. Permite la administración de pacientes, citas, historiales clínicos y servicios, tanto por parte del personal administrativo como del propio paciente.

---

## 🚀 Instalación y ejecución

1. Clona o descarga el repositorio.
2. Usa un servidor local como **XAMPP**, **WAMP** o similar.
3. Copia la carpeta `Proyecto-FCT` dentro de `htdocs/` (o la raíz de tu servidor).
4. Crea una base de datos en **MySQL** y ejecuta el script `esquema.sql` si está disponible.
5. Configura el archivo `/Codigo/conexion/conexion.php` con tus credenciales de base de datos.
6. Ejecuta `composer install` para instalar las dependencias necesarias (Stripe, Google API).
7. Rellena `config.env` con tus claves de Stripe, Google y UltraMsg.
8. Inicia Apache y MySQL desde el panel de XAMPP.
9. Abre en el navegador:

   👉 `http://localhost/Proyecto-FCT/Codigo/index.php`

### 🔐 Credenciales de prueba

**Administrador**  
- Usuario: `ana.martinez@ejemplo.com`  
- Contraseña: `Contra+1234`

**Paciente**  
- Usuario: `juan.perez@ejemplo.com`  
- Contraseña: `Contra+1234`

---

## 📁 Estructura del proyecto

```
📦Codigo
 ┣ 📂conexion
 ┃ ┣ 📜cerrar_sesion.php
 ┃ ┗ 📜conexion.php
 ┣ 📂config
 ┃ ┣ 📜credentials.json
 ┃ ┗ 📜stripe_config.php
 ┣ 📂estilos
 ┃ ┣ 📜style.css
 ┃ ┣ 📜styleAdmin.css
 ┃ ┣ 📜styleCalendario.css
 ┃ ┣ 📜styleCitas.css
 ┃ ┣ 📜styleCitasAdmin.css
 ┃ ┣ 📜styleCitasPaciente.css
 ┃ ┣ 📜styleColores.css
 ┃ ┣ 📜styleEditPerfil.css
 ┃ ┣ 📜stylePago.css
 ┃ ┣ 📜stylePromo.css
 ┃ ┣ 📜styleRecuperarContra.css
 ┃ ┗ 📜stylesRegistro.css
 ┣ 📂fuenteTexto
 ┃ ┗ 📂amazing_grotesk
 ┃ ┃ ┣ 📜Amazing Grotesk Book Italic.otf
 ┃ ┃ ┣ 📜Amazing Grotesk Book.otf
 ┃ ┃ ┣ 📜Amazing Grotesk Demi Italic.otf
 ┃ ┃ ┣ 📜Amazing Grotesk Demi.otf
 ┃ ┃ ┣ 📜Amazing Grotesk Light Italic.otf
 ┃ ┃ ┣ 📜Amazing Grotesk Light.otf
 ┃ ┃ ┣ 📜Amazing Grotesk Ultra Italic.otf
 ┃ ┃ ┣ 📜Amazing Grotesk Ultra.otf
 ┃ ┃ ┗ 📜license.pdf
 ┣ 📂googleCalendar
 ┃ ┗ 📜google_calendar.php
 ┣ 📂iconos
 ┣ 📂imagenes
 ┃ ┣ 📂cursores
 ┃ ┣ 📂promociones
 ┃ ┣ 📂servicios
 ┣ 📂js
 ┃ ┣ 📜menuNavegacion.js
 ┃ ┣ 📜registro.js
 ┃ ┗ 📜validacionUsuario.js
 ┣ 📂plantillas
 ┃ ┣ 📜footer.php
 ┃ ┗ 📜header.php
 ┣ 📂validaciones
 ┃ ┣ 📂busqueda
 ┃ ┃ ┣ 📜buscar_paciente.php
 ┃ ┃ ┣ 📜busqueda.php
 ┃ ┃ ┣ 📜guardar_id_paciente.php
 ┃ ┃ ┗ 📜procesar_busqueda.php
 ┃ ┣ 📂calendario
 ┃ ┃ ┗ 📜calendarioReserva.php
 ┃ ┣ 📂citas
 ┃ ┃ ┣ 📜bloquear_citas.php
 ┃ ┃ ┣ 📜cancelar_cita.php
 ┃ ┃ ┣ 📜citas_admin_gestion.php
 ┃ ┃ ┣ 📜citas_Bloqueadas.php
 ┃ ┃ ┣ 📜crear_cita_admin.php
 ┃ ┃ ┣ 📜desbloquear_citas.php
 ┃ ┃ ┣ 📜eliminar_paciente_temporal.php
 ┃ ┃ ┣ 📜pacientes_temporales.php
 ┃ ┃ ┣ 📜proximas_citas.php
 ┃ ┃ ┣ 📜reservar_tramo.php
 ┃ ┃ ┣ 📜subsecciones_admin_citas.js
 ┃ ┃ ┗ 📜tramos_horarios.php
 ┃ ┣ 📂editarPerfil
 ┃ ┃ ┣ 📜form_Edit_Perfil.php
 ┃ ┃ ┣ 📜popupContrasena.js
 ┃ ┃ ┗ 📜procesar_Edit_Perfil.php
 ┃ ┣ 📂historialClinico
 ┃ ┃ ┣ 📂archivos
 ┃ ┃ ┣ 📂crearHistorial
 ┃ ┃ ┃ ┣ 📜crearInforme.php
 ┃ ┃ ┃ ┣ 📜submenuCrearHistorial.js
 ┃ ┃ ┃ ┣ 📜validar_Crear_Informe.php
 ┃ ┃ ┃ ┣ 📜validar_Editar_Informe.php
 ┃ ┃ ┃ ┗ 📜validar_historial.php
 ┃ ┃ ┣ 📂editarHistorial
 ┃ ┃ ┃ ┣ 📜agregarPatologia.js
 ┃ ┃ ┃ ┣ 📜editarHistorial.js
 ┃ ┃ ┃ ┣ 📜editarHistorial.php
 ┃ ┃ ┃ ┣ 📜editarInforme.php
 ┃ ┃ ┃ ┗ 📜mostrar_editar_Historial_Informe.php
 ┃ ┃ ┣ 📂listarHistorial
 ┃ ┃ ┃ ┣ 📜listarHistorial.php
 ┃ ┃ ┃ ┣ 📜verHistorial.php
 ┃ ┃ ┃ ┗ 📜verInforme.php
 ┃ ┃ ┗ 📜ajusteTextarea.js
 ┃ ┣ 📂pago
 ┃ ┃ ┣ 📜pago_cita.php
 ┃ ┃ ┗ 📜procesar_pago.php
 ┃ ┣ 📂recordatorio_WhatsApp
 ┃ ┃ ┣ 📜cron_recordatorio.php
 ┃ ┃ ┗ 📜test-whatsapp.php
 ┃ ┣ 📂recuperarContra
 ┃ ┃ ┣ 📜enviarMail.php
 ┃ ┃ ┣ 📜guardar_nueva_contra.php
 ┃ ┃ ┣ 📜procesar_recuperacion.php
 ┃ ┃ ┣ 📜recuperar_contrasena.js
 ┃ ┃ ┗ 📜restablecer_contrasena.php
 ┃ ┣ 📂servicios
 ┃ ┃ ┣ 📜editarServicio.js
 ┃ ┃ ┣ 📜editar_servicios.php
 ┃ ┃ ┣ 📜eliminar_servicios.php
 ┃ ┃ ┣ 📜procesar_editar_servicios.php
 ┃ ┃ ┣ 📜procesar_servicios.php
 ┃ ┃ ┣ 📜servicios_form.php
 ┃ ┃ ┗ 📜servicios_lista.php
 ┃ ┣ 📂subseccionesAdmin
 ┃ ┃ ┣ 📜agregarServicio.php
 ┃ ┃ ┣ 📜busquedaP.php
 ┃ ┃ ┣ 📜subMenuHistorial.js
 ┃ ┃ ┗ 📜subseccion.js
 ┃ ┣ 📜debug.log
 ┃ ┣ 📜historial.php
 ┃ ┣ 📜validacionRegistro.php
 ┃ ┗ 📜validacionUsuario.php
 ┣ 📜admin.php
 ┣ 📜citas.php
 ┣ 📜debug.log
 ┣ 📜editar_perfil.php
 ┣ 📜index.php
 ┣ 📜registro.php
 ┣ 📜servicios.php
 ┗ 📜utilidades.php

```

---

## 🔮 Funcionalidades

### Para pacientes:
- Registro e inicio de sesión.
- Edición de perfil (email, teléfono, sexo, fecha de nacimiento).
- Reservar, pagar y cancelar citas.

### Para administradores:
- Búsqueda y gestión de pacientes (mediante buscador AJAX).
- Creación, edición y visualización de historiales clínicos.
- Gestión de servicios: agregar, editar y eliminar.
- Control de citas: bloquear, desbloquear y asignar.
- Alta/baja de pacientes temporales.
- Envío de recordatorios de citas por WhatsApp (mediante UltraMsg API).

---

## 🛠️ Tecnologías

- PHP 8+
- MySQL
- HTML/CSS/JavaScript
- jQuery
- AJAX (consultas dinámicas sin recarga de página)
- Stripe API (pagos online)
- Google Calendar API (sincronización de citas)
- UltraMsg API (recordatorios por WhatsApp)
- `IntlDateFormatter` (formateo de fechas en español)

---

## 🔒 Seguridad y acceso

- Control de acceso mediante sesiones (`$_SESSION`).
- Roles diferenciados para **paciente** y **administrador**.
- Acceso restringido a funciones críticas.

---

## 💡 Notas adicionales

- Responsive: se adapta a móviles y tablets.
- Las citas están separadas por franjas horarias.
- Historial clínico flexible: no requiere todos los campos.
- El sistema permite gestionar pacientes temporales y permanentes.

---

## ✍️ Autor

**Daniel Godoy Medina**  
Desarrollador del sistema como parte de prácticas del Grado Superior de Desarrollo de Aplicaciones Web.

---

## 📄 Licencia

Este proyecto ha sido desarrollado con fines educativos como parte del módulo Proyecto Integado del Grado Superior de Desarrollo de Aplicaciones Web.  
No está destinado a producción sin revisión profesional de seguridad.
