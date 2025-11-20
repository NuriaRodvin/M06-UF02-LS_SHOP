🛍️ LS_SHOP – La Tienda de la Nuri
CRUD completo + Catálogo visual + Carrito con sesión

Autora: Nuria Rodríguez Vindel
Módulo: ICB0006 — UF2 — PR01

✨ Descripción general

LS_SHOP es una tienda online desarrollada con Laravel + MySQL, con un diseño moderno, divertido y completamente personalizado.

Incluye:

✅ Catálogo visual estilo tienda online
✅ Filtros por categoría
✅ Buscador inteligente
✅ Ordenación por precio
✅ CRUD completo (crear, ver, editar, borrar)
✅ Carrito persistente mediante sesión
✅ Menú lateral + menú superior
✅ Iconos, emojis y diseño cálido
✅ Comentarios educativos para estudiar

🌈 Tecnologías utilizadas
Tecnología	Uso
Laravel 10	Backend, rutas, controladores
Blade	Vistas y plantillas
MySQL (XAMPP)	Base de datos
PHP 8+	Lógica del servidor
CSS personalizado	Diseño “tipo Amazon”
Laravel Sessions	Carrito persistente
📁 Estructura del proyecto
/app
 └── /Http/Controllers
      ├── PageController.php
      ├── CartController.php
      └── Controller.php

/resources/views
 ├── layouts/app.blade.php
 ├── home.blade.php
 ├── products/index.blade.php
 ├── products/create.blade.php
 ├── details.blade.php
 ├── details_index.blade.php
 ├── cart.blade.php
 ├── contact.blade.php
 └── offers.blade.php

/routes/web.php
/database

🧱 Base de datos

Tablas principales:

products

categories

Campos destacados:

id

nombre

category_id

precio

descripcion

sku

stock

activo

imagen (opcional)

🔽 Se incluye el archivo SQL:
ls_shop_nuriarodriguez.sql

🧭 Rutas principales
Ruta	Descripción
/ ó /home	Página principal
/products	Catálogo tipo Amazon
/details	Portada de “detalles”
/details/{id}	Ficha editable (CRUD)
/products/create	Insertar producto
/cart	Ver carrito
/contact	Contacto
/offers	Ofertas
🛠️ CRUD implementado
✔️ CREATE

Formulario en: /products/create

✔️ READ

Tabla original en /home (guardada para práctica)

Catálogo visual en /products

Ficha detallada /details/{id}

✔️ UPDATE

Desde /details/{id} con formulario editable

✔️ DELETE

Botón eliminar en /details/{id}

🛒 Carrito con sesión (CartController)

El carrito guarda los productos así:

[
  product_id => [
    'id' => ...,
    'name' => ...,
    'price' => ...,
    'qty' => ...,
    'category' => ...
  ],
];


Funciones incluidas:

index() → ver carrito

add() → añadir producto

remove() → eliminar 1 producto

clear() → vaciar carrito

Incluye:
🛒 Icono del carrito en el menú superior
📦 Contador dinámico
🎨 Botón “Añadir al carrito” en el catálogo

⭐ Originalidad y diseño personalizado

✨ Estilo visual tipo tienda moderna
🟧 Hover, sombras y bordes redondeados
📦 Icono de caja cuando no hay imagen
😍 Textos cálidos con emojis
📌 Menú superior + menú lateral
🔥 Promo especial de la semana
🛒 Carrito siempre disponible
📝 Comentarios bien redactados para estudio

🧩 EXTRA +0,25 ptos — Uso de Route::resource()

(Se incluye exactamente como debe evaluarlo el profesor)

En routes/web.php añadí:

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
// 🔸 Yo no uso estas rutas en mi tienda principal (home, products, carrito…),
//     pero las añado para demostrar que conozco cómo funciona
//     un controlador REST completo en Laravel.
//
Route::resource('/shop', ShopController::class);


✔ No interfiere con mi proyecto
✔ Demuestra dominio de Laravel REST
✔ Justo lo que pedía la práctica para sumar puntos
✔ Ya validado en el repositorio

🚀 Instalación y uso
1️⃣ Clonar repositorio
git clone https://github.com/NuriaRodvin/M06-UF02-LS_SHOP.git

2️⃣ Instalar dependencias
composer install
npm install

3️⃣ Configurar entorno

Copiar .env.example → .env

Configurar:

DB_DATABASE=ls_shop
DB_USERNAME=root
DB_PASSWORD=

4️⃣ Generar APP_KEY
php artisan key:generate

5️⃣ Importar base de datos

Importar ls_shop_nuriarodriguez.sql en phpMyAdmin.

6️⃣ Iniciar servidor
php artisan serve
