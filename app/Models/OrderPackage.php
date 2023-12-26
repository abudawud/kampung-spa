<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use AbuDawud\AlCrudLaravel\Models\BaseModel;

/**
 * @property-read int $id
 */
class OrderPackage extends BaseModel
{
    use HasFactory;

    protected $table = "order_package";

    public $fillable = [
        'order_id',
        'package_id',
        'qty',
        'duration',
        'price'
    ];

    public $visible = [
        'order_id',
        'package_id',
        'qty',
        'duration',
        'price'
    ];

    const VALIDATION_RULES = [
        'package_id' => 'required',
        'qty' => 'required|integer',
        'duration' => 'required|integer',
        'price' => 'required|integer'
    ];

    const VALIDATION_MESSAGES = [
    ];
}
