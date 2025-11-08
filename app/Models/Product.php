<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | MODELO PRODUCT
    |--------------------------------------------------------------------------
    | Nuria Rodríguez Vindel
    | Representa la tabla "products" de mi base de datos ls_shop.
    | Desde aquí podré recuperar los productos y relacionarlos con su categoría.
    */

    // Nombre exacto de la tabla que hice en SQL
    protected $table = 'products';

    // Permito asignación masiva en estos campos (para futuros CRUD)
    protected $fillable = [
        'nombre',
        'category_id',
        'precio',
        'descripcion',
        'sku',
        'stock',
        'activo',
        'imagen_url',
    ];

    // Relación: cada producto pertenece a 1 categoría
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
