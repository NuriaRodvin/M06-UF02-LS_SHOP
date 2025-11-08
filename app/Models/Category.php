<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | MODELO CATEGORY
    |--------------------------------------------------------------------------
    | Nuria Rodríguez Vindel
    | Representa la tabla "categories" donde tengo Informatica, Ropa, etc.
    */

    protected $table = 'categories';

    protected $fillable = [
        'nombre',
        'slug',
    ];

    // Relación inversa: una categoría tiene muchos productos
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}
