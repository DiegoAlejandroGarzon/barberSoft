<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
     
     'nombres',
     'apellidos',
     'cedula',
     'telefono',
     'reference_number',
     'description',
     'precio',
     'status',
     'created_at',    ];

    public static function getProductPrice($value){
        switch($value) {
            case 'producto_1':
                    $price='1.00';
                    break;
            case 'producto_2':
                    $price='2.00';
                    break;
            case 'producto_3':
                    $price='3.00';
                    break;
            default:
                    $price='0.00';
                    break;
        }
        return $price;
    }

    public static function getProductDescription($value){

        switch($value) {
            case 'producto_1':
                    $description='$producto_1';
                    break;
            case 'producto_2':
                    $description='$producto_2';
                    break;
            case 'producto_3':
                    $description='$producto_3';
                    break;
            default:
                    $description='$Producto Invalido';
            }
        return $description;
    }

    

}
