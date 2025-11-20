# LS_SHOP – La Tienda de la Nuri  
CRUD completo + Catálogo visual + Carrito con sesión

Autora: **Nuria Rodríguez Vindel**  
Módulo: **ICB0006 — UF2 — PR01**

---

## 1. Descripción general

LS_SHOP es una pequeña tienda online desarrollada con **Laravel** y **MySQL**.

Permite:

- Ver productos en tabla y en catálogo visual tipo tienda online.
- Filtrar por categoría.
- Buscar por nombre.
- Ordenar por precio.
- Ver, editar y borrar cada producto (CRUD completo).
- Insertar nuevos productos.
- Añadir productos a un carrito de compra guardado en sesión.
- Ver el carrito en cualquier momento desde el menú superior.

El diseño está personalizado con colores suaves, tarjetas, sombras, hover y textos explicativos con emojis.

---

## 2. Funcionalidades principales

- Catálogo visual con tarjetas (modo “Amazon”).
- Tabla de productos con filtros (Tarea 4).
- CRUD completo:
  - Crear
  - Leer
  - Actualizar
  - Eliminar
- Detalle editable de cada producto.
- Filtros y ordenación que se mantienen entre vistas.
- Carrito persistente en sesión (añadir, quitar, vaciar).
- Menú lateral + cabecera superior.
- Página de contacto y página de ofertas.
- Comentarios en el código pensados para estudiar después.

---

## 3. Tecnologías utilizadas

| Tecnología        | Uso principal                                      |
|-------------------|----------------------------------------------------|
| Laravel 10        | Backend, rutas, controladores                      |
| PHP 8+            | Lógica del servidor                                |
| Blade Templates   | Vistas y layout principal                          |
| MySQL (XAMPP)     | Base de datos `ls_shop`                            |
| CSS personalizado | Estilos, tarjetas, colores y “modo Amazon”        |
| Laravel Sessions  | Carrito persistente por usuario/navegador          |

---

## 4. Estructura del proyecto

Rutas y controladores:

- `routes/web.php`
- `app/Http/Controllers/Controller.php`
- `app/Http/Controllers/PageController.php`
- `app/Http/Controllers/CartController.php`
- `app/Http/Controllers/ShopController.php` (resource extra de práctica)

Vistas principales (`resources/views`):

- `layouts/app.blade.php` → layout general de la tienda
- `home.blade.php` → página principal (tabla con filtros – Tarea 4)
- `products/index.blade.php` → catálogo visual tipo Amazon
- `products/create.blade.php` → formulario de alta (INSERT)
- `details.blade.php` → ficha editable de cada producto (CRUD Update/Delete)
- `details_index.blade.php` → portada de la sección Detalles
- `cart.blade.php` → carrito de compra
- `contact.blade.php` → página de contacto
- `offers.blade.php` → página de ofertas

Archivos de base de datos:

- Script SQL de creación y datos de ejemplo  
  `database/sql/ls_shop_nuriarodriguez.sql` (nombre sugerido para el repo)

---

## 5. Base de datos

**Base de datos:** `ls_shop` (MariaDB / MySQL)

Tablas principales:

1. `categories`
2. `products`

Campos destacados de `products`:

- `id` (PK)
- `nombre`
- `category_id` (FK → `categories.id`)
- `precio`
- `descripcion`
- `sku`
- `stock`
- `activo`
- `imagen` (ruta opcional a la imagen del producto)

El script SQL crea la BD, las tablas con sus claves foráneas y carga datos de ejemplo.

---

## 6. Rutas principales

| Ruta               | Método(s) | Descripción                                       |
|--------------------|----------|---------------------------------------------------|
| `/` o `/home`      | GET      | Página principal con tabla y filtros              |
| `/products`        | GET      | Catálogo visual con tarjetas y paginación         |
| `/products/create` | GET      | Formulario de alta de producto                    |
| `/products`        | POST     | Guardar nuevo producto                            |
| `/details`         | GET      | Portada general de la sección detalles            |
| `/details/{id}`    | GET      | Ficha editable de un producto                     |
| `/details/{id}`    | PUT      | Actualizar producto                               |
| `/details/{id}`    | DELETE   | Eliminar producto                                 |
| `/cart`            | GET      | Ver carrito                                       |
| `/cart/add/{id}`   | POST     | Añadir producto al carrito                        |
| `/cart/remove/{id}`| POST     | Quitar un producto del carrito                    |
| `/cart/clear`      | POST     | Vaciar carrito completo                           |
| `/contact`         | GET      | Página de contacto                                |
| `/offers`          | GET      | Página de ofertas                                 |
| `/shop/*`          | Varios   | Rutas generadas por `Route::resource` (extra)     |

---

## 7. CRUD implementado

### Create

- Formulario de alta en `/products/create`.
- Validación de campos en `PageController::storeProduct()`.
- Inserción con el modelo `Product`.

### Read

- Tabla de productos en `/home` (Tarea 4).
- Catálogo visual con tarjetas en `/products`.
- Detalle de producto en `/details/{id}`.

### Update

- Edición de cualquier campo del producto desde `/details/{id}`.
- Validación y guardado en `PageController::updateProduct()`.

### Delete

- Botón “Eliminar producto” en `/details/{id}`.
- Eliminación con `PageController::deleteProduct()`.

---
## 8. Extra 0,25 ptos - Resource sin interferior con lo anterior


⭐En routes/web.php se ha añadido un resource completo para ShopController:

 === EXTRA 0,25 ptos: Resource sin interferir con lo anterior ===
 Este resource crea automáticamente TODAS las rutas de un CRUD completo.

Laravel generará:

GET /shop → index

GET /shop/create → create

POST /shop → store

GET /shop/{id} → show

GET /shop/{id}/edit → edit

PUT /shop/{id} → update

DELETE /shop/{id} → destroy

 Yo no uso estas rutas en la tienda principal (home, products, carrito, etc.),
 pero las añado para demostrar que conozco cómo funciona un
 controlador REST completo en Laravel.

Route::resource('/shop', ShopController::class);


Estas rutas extra no interfieren con las rutas reales de la tienda y sirven como parte opcional de la práctica.



## 9. Instalación y ejecución

### Clonar el repositorio:

git clone https://github.com/NuriaRodvin/M06-UF02-LS_SHOP.git
cd M06-UF02-LS_SHOP


### Instalar dependencias de PHP:

composer install


### Instalar dependencias de frontend (opcional si se usan):

npm install


### Crear archivo .env a partir de .env.example y configurar la BD:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ls_shop
DB_USERNAME=root
DB_PASSWORD=


### Generar la APP_KEY de Laravel:

php artisan key:generate


### Importar el SQL de la base de datos en phpMyAdmin:

Archivo: database/sql/ls_shop_nuriarodriguez.sql


### Arrancar el servidor de desarrollo:

php artisan serve


### Abrir en el navegador:

http://127.0.0.1:8000


## 10. Notas finales


El código incluye muchos comentarios pensados para repasar para el examen.

El proyecto combina:

Trabajo con base de datos real.

Rutas y controladores de Laravel.

Blade y diseño propio.

Carrito con sesiones.




🚀 Instalación y ejecución del proyecto

1️⃣ Clonar el repositorio
git clone https://github.com/NuriaRodvin/M06-UF02-LS_SHOP.git
cd M06-UF02-LS_SHOP

2️⃣ Instalar dependencias PHP
composer install

3️⃣ Instalar dependencias de frontend (si se usan)
npm install

4️⃣ Crear y configurar el archivo .env

Copia .env.example y configúralo así:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ls_shop
DB_USERNAME=root
DB_PASSWORD=

5️⃣ Generar la APP_KEY de Laravel
php artisan key:generate

6️⃣ Importar la base de datos

En phpMyAdmin, importa el archivo:

database/sql/ls_shop_nuriarodriguez.sql

7️⃣ Arrancar el servidor
php artisan serve

8️⃣ Abrir en el navegador

👉 http://127.0.0.1:8000



## 📝 Notas finales

Todo el proyecto contiene comentarios muy detallados, pensados para estudiar y entender Laravel paso a paso.

Combina:

✔️ Base de datos real MySQL

✔️ Modelo–Vista–Controlador

✔️ Blade y diseño personalizado

✔️ Carrito persistente con sesiones

✔️ CRUD completo profesional


## EXTRA. Carrito de compra (sesión)

Controlador: `CartController`  
Vista: `cart.blade.php`  
Rutas: `/cart`, `/cart/add/{product}`, `/cart/remove/{product}`, `/cart/clear`

El carrito se guarda en la **sesión** de Laravel.  
Estructura del array `$cart`:

```php
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


### Funciones del controlador:


index() → Muestra el carrito, lista los productos añadidos y calcula el total (€).

add() → Añade un producto al carrito o incrementa la cantidad si ya existía.

remove() → Elimina una línea completa del carrito (no resta cantidades).

clear() → Vacía el carrito entero borrando la sesión.




