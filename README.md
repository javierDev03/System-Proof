# 📦 Sistema de Gestión de Órdenes - Laravel + VueJS + TailwindCSS

Este proyecto es un sistema web construido con **Laravel (backend)** y **VueJS (frontend)**, estilizado con **TailwindCSS**, que permite gestionar órdenes con las siguientes funcionalidades:

---

## ✨ Funcionalidades Principales

- 🔐 **Autenticación**: Login, registro de nuevos usuarios y recuperación de contraseña vía correo electrónico.
- 📋 **Listado de Órdenes**: Vista con todas las órdenes registradas.
- 📦 **Detalle de la Orden**:
  - Información general (fecha, número, etc).
  - Datos del cliente (desde un catálogo).
  - Productos añadidos a la orden (desde un catálogo).
- ➕ **Gestión de Órdenes**:
  - Crear nuevas órdenes.
  - Cancelar órdenes (no se eliminan).
- 🛠️ **Gestión de Ítems dentro de la orden**:
  - Agregar, editar o eliminar productos.
  - Cálculo dinámico del subtotal sin necesidad de recargar la página.

---

## 🚀 Tecnologías Utilizadas

- **Laravel** (Framework PHP - Backend)
- **VueJS** (Frontend Framework)
- **TailwindCSS** (Estilos)
- **SQLite** (Base de datos)
- **SMTP Gmail** (para envío de correos)

---

## ⚙️ Configuración del Proyecto

### 1. Clonar el repositorio
```bash
git clone https://github.com/tu-usuario/nombre-repo.git
cd nombre-repo 
```
### 2. Instalar Dependencias
# Dependencias PHP (Laravel)

```bash
composer install
```
# Dependencias JavaScript (Vue + Tailwind)
```bash
npm install
npm install -D tailwindcss postcss autoprefixer
npx tailwindcss init
```
### 3. Configurar .ENV 


