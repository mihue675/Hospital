# Gestión para Hospital

Proyecto web desarrollado para la Universidad Católica de Santiago del Estero, como parte de la carrera de Ingeniería en Informática. Este proyecto tiene como objetivo facilitar la gestión de equipos médicos dentro de un hospital, cubriendo inventario, mantenimiento, uso y disponibilidad, consumibles, proveedores, reportes y más.

## Universidad Católica de Santiago del Estero

**Facultad de Ciencias para la Innovación y el Desarrollo**  
**Ingeniería en Informática - Programacion I - 2024**

## Objetivos del Proyecto

Este proyecto busca que los estudiantes:

- Diseñen una aplicación web que solucione una problemática específica.
- Apliquen conocimientos en desarrollo con **PHP**, maquetación con **HTML5**, programación con **JavaScript**, estilizado con **CSS3** y diseño en **capas**.

## Descripción del Proyecto

Esta aplicación web permite al hospital gestionar el inventario y uso de sus equipos médicos de manera eficiente, abarcando funcionalidades que incluyen desde el registro hasta el mantenimiento de los equipos y la administración de consumibles.

### Funcionalidades Principales

1. **Gestión de Inventario de Equipos Médicos**

   - Registro de equipos con detalles específicos (nombre, marca, modelo, número de serie, etc.).
   - Clasificación por categorías (ej. monitores, ventiladores).
   - Estado actual de los equipos (disponible, en uso, mantenimiento).
   - Ubicación física de cada equipo.
   - Baja de equipos obsoletos o dañados.

2. **Gestión de Mantenimiento**

   - Programación de mantenimientos preventivos.
   - Historial de mantenimiento (fechas, tipo, técnicos responsables).
   - Notificaciones de mantenimiento programado.
   - Solicitud de mantenimiento correctivo por fallas reportadas.
   - Asignación de técnicos para mantenimiento.

3. **Gestión de Uso y Disponibilidad**

   - Reservas de equipos para procedimientos.
   - Registro del historial de uso (quién usó, cuándo y para qué).
   - Control de disponibilidad en tiempo real.
   - Asignación de prioridad en casos de alta demanda.

4. **Gestión de Consumibles**

   - Inventario de consumibles (electrodos, baterías, etc.).
   - Notificaciones de reabastecimiento de consumibles.
   - Registro del uso de consumibles para control de stock.

5. **Gestión de Proveedores y Contratos**

   - Registro de información de proveedores (contacto, garantías).
   - Administración de contratos de mantenimiento.
   - Seguimiento de garantías.

6. **Reportes y Estadísticas**

   - Reporte de estado de equipos.
   - Historial de reparaciones.
   - Estadísticas de uso de equipos.

7. **Autenticación y Roles de Usuarios**

   - Sistema de roles y permisos (administradores, técnicos, personal médico).
   - Acceso controlado a funcionalidades.

8. **Notificaciones y Alertas**
   - Alertas de mantenimiento programado y fallas.
   - Notificaciones de disponibilidad.
   - Avisos de vencimiento de garantías.

## Tecnologías Utilizadas

- **Backend**: PHP
- **Frontend**: HTML5, CSS3, JavaScript
- **Base de Datos**: MySQL (u otro gestor SQL de preferencia)
- **Arquitectura**: Programación en capas

## Requisitos

- **Servidor web**: Apache o Nginx
- **PHP**: Versión 7.4 o superior
- **Base de Datos**: MySQL o MariaDB
- **Extensiones de PHP**: `PDO`, `mbstring`, `json`, entre otras

## Instalación

1. Clona el repositorio en tu servidor local.
   ```bash
   git clone https://github.com/tu_usuario/gestor-equipos-medicos.git
   ```
