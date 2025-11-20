📦 LS_SHOP – La Tienda de la Nuri
CRUD completo · Catálogo visual · Carrito con sesión

Autora: Nuria Rodríguez Vindel
Módulo: ICB0006 — UF2 — PR01

✨ 1. Descripción general

LS_SHOP es una tienda online desarrollada con Laravel + MySQL, con un diseño moderno, cálido y completamente personalizado.

Incluye:

✔️ Catálogo visual con tarjetas estilo tienda online

✔️ Filtros por categoría

✔️ Buscador inteligente

✔️ Ordenación por precio

✔️ CRUD completo (crear, ver, editar, borrar)

✔️ Carrito persistente mediante sesión

✔️ Menú lateral + menú superior

✔️ Iconos, emojis y diseño cálido

✔️ Comentarios educativos en el código

🌈 2. Tecnologías utilizadas
Tecnología	Uso
Laravel 10	Backend, rutas, controladores
PHP 8+	Lógica del servidor
Blade Templates	Vistas y layout
MySQL (XAMPP)	Base de datos ls_shop
CSS personalizado	Estilo tipo “Amazon”
Laravel Sessions	Carrito persistente
VS Code / HeidiSQL	Desarrollo y BD
📁 3. Estructura del proyecto
Controladores (app/Http/Controllers)

PageController.php

CartController.php

ShopController.php (extra 0,25 pts – Resource)

Controller.php

Vistas (resources/views)

layouts/app.blade.php — Layout principal

home.blade.php — Tabla con filtros (Tarea 4)

products/index.blade.php — Catálogo visual tipo Amazon

products/create.blade.php — Insertar producto

details.blade.php — Ficha editable CRUD

details_index.blade.php — Portada detalles

cart.blade.php — Carrito de la compra

contact.blade.php

offers.blade.php

Rutas

routes/web.php — Todas las rutas de la tienda

Base de datos

database/sql/ls_shop_nuriarodriguez.sql
(script limpio recomendado para el repositorio)

🧱 4. Base de datos

Base de datos: ls_shop
Tablas:

products

categories

Campos destacados de products:

id, nombre, categoria_id, precio

descripcion, sku, stock, activo, imagen

El SQL contiene:

Creación de la BD

Tablas con claves foráneas

Datos de ejemplo

Configuración UTF8MB4

🧭 5. Rutas principales
Ruta	Descripción
/ o /home	Página principal con tabla y filtros
/products	Catálogo visual
/products/create	Crear producto
/products (POST)	Guardar nuevo producto
/details	Portada general de detalles
/details/{id}	Ficha editable
/details/{id} PUT	Actualizar producto
/details/{id} DELETE	Borrar
/cart	Ver carrito
/cart/add/{id}	Añadir al carrito
/cart/remove/{id}	Quitar
/cart/clear	Vaciar
/contact	Contacto
/offers	Ofertas
/shop/*	Rutas del Resource extra (0,25 pts)
🛠️ 6. CRUD implementado
✔️ CREATE

/products/create — Formulario
storeProduct() — Inserta en BD

✔️ READ

Tabla con filtros en /home

Catálogo visual /products

Detalle /details/{id}

✔️ UPDATE

updateProduct() con validación

✔️ DELETE

deleteProduct() desde /details/{id}

🛒 7. Carrito de compra (con sesión)

Controlador: CartController.php
Vista: cart.blade.php

Estructura del carrito en sesión:

$cart = [
    product_id => [
        'id'       => (int),
        'name'     => (string),
        'price'    => (float),
        'qty'      => (int),
        'category' => (string),
    ]
];


Funciones:

index() → ver carrito y total

add() → añadir producto

remove() → quitar uno

clear() → vaciar todo

Persistente en sesión → cada usuario tiene su carrito.

⭐ 8. Extra 0,25 pts — Resource sin interferir

Añadido en routes/web.php:

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
// No lo uso en la tienda principal, pero lo incluyo para demostrar
// que entiendo cómo funciona un controlador REST completo en Laravel.
//
Route::resource('/shop', ShopController::class);


💡 No altera la tienda ni da errores.
💡 Garantiza el punto extra.

🚀 9. Instalación y uso
1️⃣ Clonar repositorio
git clone https://github.com/NuriaRodvin/M06-UF02-LS_SHOP.git
cd M06-UF02-LS_SHOP

2️⃣ Instalar dependencias
composer install
npm install

3️⃣ Configurar .env

Copiar .env.example a .env y editar:

DB_DATABASE=ls_shop
DB_USERNAME=root
DB_PASSWORD=

4️⃣ Generar key
php artisan key:generate

5️⃣ Importar base de datos

En phpMyAdmin → importar ls_shop_nuriarodriguez.sql.

6️⃣ Iniciar el servidor
php artisan serve


Abrir en navegador:

http://127.0.0.1:8000

📝 10. Notas finales

El proyecto incluye MUCHOS comentarios educativos para estudiar.

Combina Laravel, Blade, BD, CRUD, sesiones y diseño personalizado.

Carrito, catálogo, paginación y filtros funcionan perfectamente.

El repositorio está listo para evaluación o ampliación.

