# ✅ Sistema de Registro de Piezas - CRUD Completo

Sistema web en **Laravel 12 + Blade + Tailwind** sin Jetstream con CRUD completo para todas las tablas.

## ✅ CRUD Completo Implementado

| Tabla | Create | Read | Update | Delete | Show |
|-------|--------|------|--------|--------|------|
| **Proyectos** | ✅ | ✅ | ✅ | ✅ | ✅ |
| **Bloques** | ✅ | ✅ | ✅ | ✅ | ✅ |
| **Piezas** | ✅ | ✅ | ✅ | ✅ | ✅ |

## 🚀 Instalación Rápida

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
New-Item database/database.sqlite -ItemType File
php artisan migrate:fresh --seed
npm run build
php artisan serve
```

**Acceso**: http://localhost:8000/login

## 🔐 Credenciales

- luis@example.com / 0000
- gabriel@example.com / 1111  
- sergio@example.com / 2222

## 🎯 Navbar Incluye

- 📁 Proyectos (CRUD completo)
- 🧱 Bloques (CRUD completo)
- 🔧 Piezas (CRUD completo)
- ✏️ Formulario de Peso
- 📊 Reporte
- 🚪 Logout

## ⚙️ Tecnologías

- Laravel 12 (sin Jetstream)
- Blade Templates
- Tailwind CSS
- Repository Pattern
- SQLite

## 📊 Seeders Incluidos

- 3 usuarios
- 4 proyectos
- 6 bloques
- 8 piezas

¡Todo listo para usar!
