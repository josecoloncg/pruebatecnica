# Sistema de Registro de Piezas - Test T�cnico

Sistema web para el registro y control de piezas fabricadas en diferentes proyectos y bloques.

##  Tecnolog�as

- Laravel 12 + Inertia.js + Vue 3
- SQLite + Eloquent ORM
- Repository Pattern
- Tailwind CSS

##  Instalaci�n

```bash
# 1. Clonar repositorio
git clone https://github.com/josecoloncg/Arismendy.git
cd Arismendy

# 2. Instalar dependencias
composer install
npm install

# 3. Configurar entorno
cp .env.example .env
php artisan key:generate

# 4. Crear base de datos
touch database/database.sqlite  # Linux/Mac
# O: New-Item database/database.sqlite -ItemType File  # Windows

# 5. Migrar y cargar datos de prueba
php artisan migrate:fresh --seed

# 6. Compilar assets y ejecutar
npm run dev
php artisan serve
```

### 🗄️ Datos Precargados (Seeders)

Los seeders están incluidos en el repositorio y cargan automáticamente:

**Seeders disponibles:**
- `DatabaseSeeder.php` - Crea 3 usuarios y ejecuta otros seeders
- `ProyectoSeeder.php` - 4 proyectos (BICM, BALC, OPV, BRF)
- `BloqueSeeder.php` - 6 bloques vinculados a proyectos
- `PiezaSeeder.php` - 8 piezas (4 fabricadas, 4 pendientes)

**Importante:** Los seeders NO se borran al subir a GitHub. Solo se excluye la base de datos SQLite (`.gitignore`), pero ejecutando `php artisan db:seed` se recrean todos los datos.

##  Usuarios de Prueba

| Usuario | Email | Contrase�a |
|---------|-------|------------|
| Luis | luis@example.com | 0000 |
| Gabriel | gabriel@example.com | 1111 |
| Sergio | sergio@example.com | 2222 |

##  Arquitectura Backend

### Repository Pattern implementado:
- Interfaces en app/Repositories/Contracts/
- Implementaciones en app/Repositories/
- Inyecci�n de dependencias en controladores

### Modelos con Eloquent:
- Relaciones completas (hasMany, belongsTo)
- Scopes personalizados
- Casts y mutators
- Atributo calculado diferencia_peso

##  API Endpoints

### Proyectos
- GET /api/proyectos - Listar
- POST /api/proyectos - Crear
- GET /api/proyectos/{id}/bloques - Bloques del proyecto

### Bloques
- GET /api/bloques?proyecto_id={id} - Por proyecto

### Piezas
- GET /api/piezas?bloque_id={id}&solo_pendientes=true
- POST /api/piezas/{id}/registrar-peso
- GET /api/reportes/piezas-pendientes-por-proyecto

##  Requerimientos Implementados

**B�sicos (RB):**
- [x] Login con validaci�n
- [x] Formulario CRUD completo
- [x] Fecha/hora autom�tica
- [x] Listas desplegables anidadas (Proyecto  Bloques  Piezas)
- [x] Autocarga peso te�rico
- [x] Validaci�n num�rica

**Adicionales (RA):**
- [x] Middleware auth (no acceso sin login)
- [x] Filtro piezas pendientes por bloque
- [x] C�lculo autom�tico diferencia peso
- [x] Validaci�n cliente y servidor
- [x] Dise�o responsive
- [x] Reporte piezas pendientes agrupadas

##  Base de Datos

- proyectos (codigo, nombre)
- bloques (nombre_bloque, proyecto_id)
- piezas (pieza, peso_teorico, peso_real, estado, bloque_id, fecha_registro, registrado_por)

Todos con CRUD completo y relaciones Eloquent.
