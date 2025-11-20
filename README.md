LS_SHOP – La Tienda de la Nuri
CRUD completo + Catálogo visual + Carrito con sesión

Autora: Nuria Rodríguez Vindel
Módulo: ICB0006 — UF2 — PR01

📋 Descripción General
LS_SHOP es una pequeña tienda online desarrollada con Laravel y MySQL que permite:

Ver productos en tabla y en catálogo visual tipo tienda online

Filtrar por categoría y buscar por nombre

Ordenar por precio

Ver, editar y borrar cada producto (CRUD completo)

Insertar nuevos productos

Añadir productos a un carrito de compra guardado en sesión

Ver el carrito en cualquier momento desde el menú superior

El diseño está personalizado con colores suaves, tarjetas, sombras, efectos hover y textos explicativos con emojis.

⚙️ Funcionalidades Principales
🏪 Catálogo visual con tarjetas (modo "Amazon")

📊 Tabla de productos con filtros (Tarea 4)

🔄 CRUD completo:

Crear

Leer

Actualizar

Eliminar

✏️ Detalle editable de cada producto

🔍 Filtros y ordenación que se mantienen entre vistas

🛒 Carrito persistente en sesión (añadir, quitar, vaciar)

🧭 Menú lateral + cabecera superior

📞 Página de contacto y página de ofertas

💡 Comentarios en el código pensados para estudiar después

🛠️ Tecnologías Utilizadas
Tecnología	Uso Principal
Laravel 10	Backend, rutas, controladores
PHP 8+	Lógica del servidor
Blade Templates	Vistas y layout principal
MySQL (XAMPP)	Base de datos ls_shop
CSS personalizado	Estilos, tarjetas, colores y "modo Amazon"
Laravel Sessions	Carrito persistente por usuario/navegador
📁 Estructura del Proyecto
🎯 Rutas y Controladores
routes/web.php

app/Http/Controllers/Controller.php

app/Http/Controllers/PageController.php

app/Http/Controllers/CartController.php

app/Http/Controllers/ShopController.php (resource extra de práctica)

👁️ Vistas Principales (resources/views)
layouts/app.blade.php → Layout general de la tienda

home.blade.php → Página principal (tabla con filtros – Tarea 4)

products/index.blade.php → Catálogo visual tipo Amazon

products/create.blade.php → Formulario de alta (INSERT)

details.blade.php → Ficha editable de cada producto (CRUD Update/Delete)

details_index.blade.php → Portada de la sección Detalles

cart.blade.php → Carrito de compra

contact.blade.php → Página de contacto

offers.blade.php → Página de ofertas

🗄️ Base de Datos
Script SQL de creación y datos de ejemplo:
database/sql/ls_shop_nuriarodriguez.sql

🗃️ Base de Datos
Base de datos: ls_shop (MariaDB / MySQL)

Tablas Principales:
categories

products

Campos Destacados de products:
id (PK)

nombre

category_id (FK → categories.id)

precio

descripcion

sku

stock

activo

imagen (ruta opcional a la imagen del producto)

El script SQL crea la BD, las tablas con sus claves foráneas y carga datos de ejemplo.

🚦 Rutas Principales
Ruta	Método(s)	Descripción
/ o /home	GET	Página principal con tabla y filtros
/products	GET	Catálogo visual con tarjetas y paginación
/products/create	GET	Formulario de alta de producto
/products	POST	Guardar nuevo producto
/details	GET	Portada general de la sección detalles
/details/{id}	GET	Ficha editable de un producto
/details/{id}	PUT	Actualizar producto
/details/{id}	DELETE	Eliminar producto
/cart	GET	Ver carrito
/cart/add/{id}	POST	Añadir producto al carrito
/cart/remove/{id}	POST	Quitar un producto del carrito
/cart/clear	POST	Vaciar carrito completo
/contact	GET	Página de contacto
/offers	GET	Página de ofertas
/shop/*	Varios	Rutas generadas por Route::resource (extra)
🔄 CRUD Implementado
➕ Create
Formulario de alta en /products/create

Validación de campos en PageController::storeProduct()

Inserción con el modelo Product

👁️ Read
Tabla de productos en /home (Tarea 4)

Catálogo visual con tarjetas en /products

Detalle de producto en /details/{id}

✏️ Update
Edición de cualquier campo del producto desde /details/{id}

Validación y guardado en PageController::updateProduct()

🗑️ Delete
Botón "Eliminar producto" en /details/{id}

Eliminación con PageController::deleteProduct()

🛒 Carrito de Compra (Sesión)
Controlador: CartController
Vista: cart.blade.php
Rutas: /cart, /cart/add/{product}, /cart/remove/{product}, /cart/clear

El carrito se guarda en la sesión de Laravel.

Estructura del Array $cart:
php
$cart = [
    product_id => [
        'id'       => (int),    // id del producto
        'name'     => (string), // nombre
        'price'    => (float),  // precio unitario
        'qty'      => (int),    // cantidad
        'category' => (string), // nombre de la categoría (informativo)
    ],
    // ...
];
Funciones del Controlador:
index() → Muestra el carrito y calcula el total

add() → Añade un producto (o suma cantidad si ya existe)

remove() → Quita una línea completa del carrito

clear() → Vacía el carrito entero

⭐ Extra 0,25 ptos – Resource sin Interferir
En routes/web.php se ha añadido un resource completo para ShopController:

php
// === EXTRA 0,25 ptos: Resource sin interferir con lo anterior ===
// Este resource crea automáticamente TODAS las rutas de un CRUD completo.
// Laravel generará:
//   - GET    /shop             → index()
//   - GET    /shop/create      → create()
//   - POST   /shop             → store()
//   - GET    /shop/{id}        → show()
//   - GET    /shop/{id}/edit   → edit()
//   - PUT    /shop/{id}        → update()
//   - DELETE /shop/{id}        → destroy()
//
// Yo no uso estas rutas en la tienda principal (home, products, carrito, etc.),
// pero las añado para demostrar que conozco cómo funciona un
// controlador REST completo en Laravel.

Route::resource('/shop', ShopController::class);
Estas rutas extra no interfieren con las rutas reales de la tienda y sirven como parte opcional de la práctica.

🚀 Instalación y Ejecución
1️⃣ Clonar el repositorio
bash
git clone https://github.com/NuriaRodvin/M06-UF02-LS_SHOP.git
cd M06-UF02-LS_SHOP
2️⃣ Instalar dependencias PHP
bash
composer install
3️⃣ Instalar dependencias de frontend (opcional)
bash
npm install
4️⃣ Configurar entorno
Crear archivo .env a partir de .env.example y configurar la BD:

env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ls_shop
DB_USERNAME=root
DB_PASSWORD=
5️⃣ Generar clave de aplicación
bash
php artisan key:generate
6️⃣ Importar base de datos
Importar el SQL en phpMyAdmin:

text
database/sql/ls_shop_nuriarodriguez.sql
7️⃣ Arrancar servidor
bash
php artisan serve
8️⃣ Abrir en navegador
text
http://127.0.0.1:8000
📝 Notas Finales
El código incluye muchos comentarios pensados para repasar para el examen

El proyecto combina:

✅ Trabajo con base de datos real

✅ Rutas y controladores de Laravel

✅ Blade y diseño propio

✅ Carrito con sesiones

✅ CRUD completo profesional
