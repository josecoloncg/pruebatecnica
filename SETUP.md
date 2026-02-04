# Guía de Instalación y Configuración

## 📋 Requisitos Previos
- PHP >= 8.2
- Composer
- Node.js >= 18
- SQLite3

## 🚀 Instalación desde GitHub

### 1. Clonar el repositorio
```bash
git clone https://github.com/josecoloncg/Arismendy.git
cd Arismendy
```

### 2. Instalar dependencias de PHP
```bash
composer install
```

### 3. Instalar dependencias de Node.js
```bash
npm install
```

### 4. Configurar el archivo de entorno
```bash
# Copiar el archivo de ejemplo
cp .env.example .env

# Generar la clave de aplicación
php artisan key:generate
```

### 5. Configurar la base de datos
El archivo `.env` ya está configurado para SQLite. Solo necesitas crear el archivo de base de datos:

```bash
# Crear el archivo de base de datos
New-Item database/database.sqlite -ItemType File

# O en Linux/Mac
touch database/database.sqlite
```

### 6. Ejecutar migraciones y seeders
```bash
# Esto creará todas las tablas y cargará los datos de prueba
php artisan migrate:fresh --seed
```

**Los seeders cargarán automáticamente:**
- ✅ 3 usuarios: Luis, Gabriel, Sergio
- ✅ 4 proyectos: BICM, BALC, OPV, BRF
- ✅ 6 bloques vinculados a proyectos
- ✅ 8 piezas (4 fabricadas, 4 pendientes)

### 7. Compilar assets
```bash
# Para desarrollo
npm run dev

# Para producción
npm run build
```

### 8. Iniciar el servidor
```bash
php artisan serve
```

## 🔐 Credenciales de Acceso

| Usuario | Email | Contraseña |
|---------|-------|------------|
| Luis | luis@example.com | 0000 |
| Gabriel | gabriel@example.com | 1111 |
| Sergio | sergio@example.com | 2222 |

## 📍 URLs de Acceso

- **Inicio de sesión**: http://localhost:8000/login
- **Dashboard**: http://localhost:8000/dashboard
- **Formulario de Piezas**: http://localhost:8000/formulario-piezas
- **Reporte de Piezas**: http://localhost:8000/reporte-piezas

## 🗄️ Datos Precargados por los Seeders

### Proyectos (Tabla 3 del documento)
- BICM - Oceanográfico
- BALC - Buque DA
- OPV - Offshore
- BRF - Refluvial

### Bloques (Tabla 2 del documento)
- BICM-1110, BICM-3510, BICM-3610
- BALC-2210, BALC-3310
- OPV-2210

### Piezas (Tablas 4 y 5 del documento)

**Fabricadas:**
- B01 (BALC-2210) - 4.5 kg - Gabriel
- H12 (OPV-2210) - 16.6 kg - Sergio
- U23 (BICM-1110) - 4 kg - Sergio
- E29 (BICM-1110) - 7.2 kg - Luis

**Pendientes:**
- A02 (BALC-3310) - 20 kg
- R23 (BICM-1110) - 8 kg
- J25 (BICM-1110) - 11 kg
- E21 (BICM-3510) - 18 kg

## 🔄 Resetear Datos

Si necesitas volver a cargar los datos de ejemplo:

```bash
php artisan migrate:fresh --seed
```

Este comando:
1. Elimina todas las tablas
2. Vuelve a crear las tablas
3. Ejecuta todos los seeders automáticamente

## ⚠️ Importante

Los seeders están incluidos en el repositorio en `database/seeders/`:
- `DatabaseSeeder.php` - Crea usuarios y llama otros seeders
- `ProyectoSeeder.php` - Carga proyectos
- `BloqueSeeder.php` - Carga bloques
- `PiezaSeeder.php` - Carga piezas

**NO se borran al subir a GitHub**. Solo se borra la base de datos SQLite, pero los seeders permiten recrearla ejecutando `php artisan db:seed`.

## 🛠️ Comandos Útiles

```bash
# Ver rutas disponibles
php artisan route:list

# Limpiar caché
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Ver estado de migraciones
php artisan migrate:status

# Solo ejecutar seeders (sin borrar datos)
php artisan db:seed
```

## 📝 Notas de Desarrollo

- El proyecto usa **Repository Pattern** para la capa de datos
- **Laravel Sanctum** para autenticación
- **Inertia.js** para integración Laravel + Vue.js
- **Tailwind CSS** para estilos
- **SQLite** como base de datos (ideal para desarrollo)

## 🐛 Solución de Problemas

### Error: "Database does not exist"
```bash
New-Item database/database.sqlite -ItemType File
php artisan migrate:fresh --seed
```

### Error: "NPM dependencies not installed"
```bash
rm -rf node_modules package-lock.json
npm install
```

### Error: "Composer dependencies not installed"
```bash
rm -rf vendor composer.lock
composer install
```

### La aplicación no carga estilos
```bash
npm run build
php artisan view:clear
```
