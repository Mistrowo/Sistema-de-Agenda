# 📅 Sistema de Gestión de Instalaciones - Ohffice

Sistema web desarrollado en **Laravel** para la gestión integral de instalaciones, agendamiento de servicios y seguimiento de notas de venta integrado con **Softland ERP**.

---

## 🚀 Características Principales

### 📊 Gestión de Calendario
- **Vista Diaria**: Visualización de instalaciones por bloques horarios (A-1 a A-8)
- **Vista Semanal**: Planificación semanal de instalaciones
- **Vista de Listado**: Administración completa de notas de venta

### 👥 Roles de Usuario
1. **Administrador (ROL 1)**: Acceso completo al sistema
2. **Khemnova (ROL 2)**: Vista específica para instaladores externos
3. **Instalador (ROL 3)**: Vista personalizada de agenda individual

### 🔄 Integración con Softland
- Sincronización automática de notas de venta
- Actualización en tiempo real de estados
- Gestión de clientes y productos desde ERP

### 📱 Funcionalidades Clave
- ✅ Asignación de instaladores por bloques horarios
- ✅ Gestión de estados (Calendarizado, En Espera, Post-Venta)
- ✅ Asignación múltiple de fechas e instaladores
- ✅ Sistema de notas y observaciones
- ✅ Filtros avanzados por fecha y estado
- ✅ Interfaz responsive con Tailwind CSS

---

## 🛠️ Tecnologías

### Backend
- **Framework**: Laravel 10.x
- **PHP**: 8.1+
- **Base de Datos**: MySQL (principal) + SQL Server (Softland)

### Frontend
- **CSS Framework**: Tailwind CSS 3.x
- **JavaScript**: Vanilla JS con jQuery
- **Iconos**: Font Awesome 6.x
- **Alertas**: SweetAlert2

### Dependencias Principales
```json
{
  "laravel/framework": "^10.0",
  "carbon": "^2.0",
  "tailwindcss": "^3.0"
}
```

---

## 📦 Instalación

### Requisitos Previos
- PHP >= 8.1
- Composer
- MySQL
- SQL Server (para integración con Softland)
- Node.js y NPM

### Pasos de Instalación

1. **Clonar el repositorio**
```bash
git clone https://github.com/tu-usuario/ohffice-instalaciones.git
cd ohffice-instalaciones
```

2. **Instalar dependencias PHP**
```bash
composer install
```

3. **Instalar dependencias JavaScript**
```bash
npm install
```

4. **Configurar variables de entorno**
```bash
cp .env.example .env
```

Editar `.env` con tus credenciales:
```env
# Base de datos principal (MySQL)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ohffice_instalaciones
DB_USERNAME=root
DB_PASSWORD=

# Base de datos Softland (SQL Server)
DB_HOST_SOFT=servidor_softland
DB_PORT_SOFT=1433
DB_DATABASE_SOFT=softland_db
DB_USERNAME_SOFT=usuario_soft
DB_PASSWORD_SOFT=password_soft
```

5. **Generar key de la aplicación**
```bash
php artisan key:generate
```

6. **Ejecutar migraciones**
```bash
php artisan migrate
```

7. **Compilar assets**
```bash
npm run build
```

8. **Iniciar servidor de desarrollo**
```bash
php artisan serve
```

La aplicación estará disponible en `http://localhost:8000`

---

## 🗄️ Estructura de Base de Datos

### Tablas Principales

#### `agenda_def`
Almacena las asignaciones de instalaciones:
- `nota_venta`: Folio de la nota de venta
- `instalador`: Nombre del instalador asignado
- `bloque`: Bloque horario (A-1 a A-8)
- `fecha_instalacion2`: Fecha programada
- `estado`: Estado de la instalación
- `observacion_bloque`: Observaciones
- `nota_resumida`: Nota visible en agenda
- `transportista`: Transportista asignado

#### `calendario_def` (Legacy)
Tabla anterior de calendario (en proceso de migración)

#### Integración Softland
**Vista/Tabla**: `NotaVta_Actualiza`
- Conexión SQL Server
- Lectura de notas de venta en tiempo real
- Campos principales: `nv_folio`, `nv_cliente`, `nv_descripcion`, `nv_estado`

---

## 🎯 Uso del Sistema

### Login
Acceder a `/` con credenciales:
- Email del sistema
- Contraseña

### Roles y Rutas

#### Administrador (ROL 1)
- `/calendario-def/calendario` - Listado de notas de venta
- `/agenda-def/detalle-softland/{folio}` - Detalle de instalación
- `/agenda-def/agenda-dia` - Vista diaria
- `/agenda-def/agenda-semana` - Vista semanal

#### Khemnova (ROL 2)
- `/calendario-def/calendario/Khemnova` - Listado Khemnova
- `/agenda-def/detalle-softland-khem/{folio}` - Detalle Khemnova

#### Instalador (ROL 3)
- `/calendario-def/calendarioinstalador` - Mi calendario
- `/agenda-def/detalle-softland-instalador/{folio}` - Mi agenda

---

## 🔧 Configuración

### Bloques Horarios
```php
'A-1' => '08:00-10:00'
'A-2' => '10:00-12:00'
'A-3' => '12:00-14:00'
'A-4' => '14:00-16:00'
'A-5' => '16:00-18:00'
'A-6' => '18:00-20:00'
'A-7' => '20:00-22:00'
'A-8' => '22:00-24:00'
```

### Estados de Instalación
- **Calendarizado**: Instalación confirmada y agendada
- **En Espera**: Pendiente de confirmación
- **Post-Venta**: Servicio post-instalación

---

## 📱 Capturas de Pantalla

### Vista de Calendario Diario
Visualización de instalaciones por bloques horarios con código de colores según estado.

### Vista de Listado
Tabla completa de notas de venta con filtros avanzados y estado de agendamiento.

### Modal de Asignación
Interfaz intuitiva para asignar instaladores, fechas y bloques horarios.

---

## 🤝 Contribución

Las contribuciones son bienvenidas. Por favor:

1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/nueva-funcionalidad`)
3. Commit tus cambios (`git commit -am 'Agrega nueva funcionalidad'`)
4. Push a la rama (`git push origin feature/nueva-funcionalidad`)
5. Abre un Pull Request

---

## 📝 Notas Importantes

### Migración desde CalendarioDef
El sistema está en proceso de migración de `calendario_def` a integración directa con Softland. Las nuevas funcionalidades usan:
- `TablaSoftland::class` para lectura de notas
- `AgendaDef::class` para gestión de instalaciones

### Relación de Modelos
```php
// AgendaDef obtiene cliente desde Softland
public function notaVentaSoftland() {
    return $this->belongsTo(TablaSoftland::class, 'nota_venta', 'nv_folio');
}

// Accessor para cliente
public function getClienteAttribute() {
    return $this->notaVentaSoftland?->nv_cliente ?? 'Sin cliente';
}
```

---

## 🐛 Resolución de Problemas

### Error de conexión a Softland
Verificar credenciales en `.env` y que el servidor SQL Server sea accesible.

### Cliente no aparece en agenda
Asegurar que existe relación `notaVentaSoftland` y usar el accessor `$item->cliente`.

### Fechas no se filtran correctamente
Verificar formato de fecha en consultas (usar solo fecha sin hora).

---

## 📄 Licencia

Este proyecto es propiedad de **Ohffice** y su uso está restringido según los términos establecidos por la empresa.

---

## 👨‍💻 Equipo de Desarrollo

Desarrollado para **Ohffice**  
Sistema de Gestión de Instalaciones

---

## 📞 Soporte

Para soporte técnico o consultas, contactar al equipo de desarrollo interno de Ohffice.

---

**Versión**: 2.0  
**Última Actualización**: Noviembre 2025