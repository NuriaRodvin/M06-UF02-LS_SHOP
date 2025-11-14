🛍️ LS_SHOP – La Tienda de la Nuri
CRUD + Catálogo De Productos + Carrito con Sesión

Autora: Nuria Rodríguez Vindel
Módulo: ICB0006 — UF2 — PR01

✨ Descripción general

LS_SHOP es una tienda online, desarrollada con Laravel + MySQL.
Permite:

👀 Ver productos en tabla o catálogo visual

🔎 Buscar productos

📂 Filtrar por categorías

💶 Ordenar por precio

📝 Ver y editar cada producto (CRUD)

➕ Insertar nuevos

🗑️ Eliminarlos

🛒 Añadir productos al carrito (con sesión)

📦 Ver el carrito en cualquier momento

Incluye un diseño totalmente personalizado con tarjetas, sombras, hover, emojis y estilo suave.

🌈 Tecnologías utilizadas
Tecnología	Uso
Laravel	Backend + rutas + controladores
Blade Templates	Vistas y layout
MySQL (XAMPP)	Base de datos de productos
PHP 8+	Lógica del servidor
CSS personalizado	Catálogo estilo Amazon
Laravel Sessions	Carrito persistente
📁 Estructura del proyecto
/app
  /Http/Controllers
      PageController.php
      CartController.php
      Controller.php

/resources/views
  layouts/app.blade.php     # Layout principal
  home.blade.php            # Página principal
  products/index.blade.php  # Catálogo tipo Amazon
  details.blade.php         # CRUD detallado
  details_index.blade.php   # Portada de detalles
  cart.blade.php            # Carrito
  contact.blade.php
  offers.blade.php

/routes/web.php             # Rutas del proyecto
/database                   # Migraciones, modelos

🧱 Base de datos

Tablas principales:

products

categories

Incluyen datos como:

id, nombre, category_id, precio,
descripcion, sku, stock, activo, imagen


🔽 Se entrega el fichero SQL
ls_shop_nuriarodriguez.sql

🧭 Rutas principales
Ruta	Descripción
/ o /home	Página principal con bienvenida
/products	Catálogo visual
/details	Portada general de detalles
/details/{id}	Ficha editable del producto
/products/create	Insertar producto nuevo
/cart	Ver carrito
/contact	Página de contacto
/offers	Página de ofertas
🛠️ CRUD implementado
✔️ CREATE

Formulario de alta en /products/create.

✔️ READ

Tabla en /home

Catálogo visual con tarjetas /products

Detalles en /details/{id}

✔️ UPDATE

Editar campos del producto en /details/{id}.

✔️ DELETE

Borrar un producto desde /details/{id}.

🛒 Carrito (con sesión)

Ruta: /cart
Controlador: CartController

El carrito almacena:

[
  product_id => [
    'id' => ...,
    'name' => ...,
    'price' => ...,
    'qty' => ...,
    'category' => ...
  ],
]


Funciones:

add() → añadir al carrito

remove() → eliminar 1 producto

clear() → vaciar carrito

index() → mostrar carrito

Icono del carrito disponible en la cabecera.

🎨 Originalidad añadida por la autora

⭐ Estilo visual totalmente personalizado

🟧 Catálogo de productos con hover + sombras

📦 Icono de caja cuando no hay imagen

✨ Textos con emojis y estilo cálido

🧭 Menú lateral + menú superior

💥 Promo de la semana

🛒 Carrito siempre accesible

📄 Comentarios detallados para estudiar



🚀 Instalación y uso
1️⃣ Clonar repositorio
git clone https://github.com/NuriaRodvin/M06-UF02-LS_SHOP.git

2️⃣ Instalar dependencias
composer install
npm install

3️⃣ Configurar .env

Copia .env.example → .env

Configura:

DB_DATABASE=ls_shop
DB_USERNAME=root
DB_PASSWORD=

4️⃣ Generar APP_KEY
php artisan key:generate

5️⃣ Importar SQL

Importa ls_shop_nuriarodriguez.sql en phpMyAdmin.

6️⃣ Iniciar servidor
php artisan serve
