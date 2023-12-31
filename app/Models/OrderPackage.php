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
        'price',
        'total',
    ];

    public $visible = [
        'order_id',
        'package_id',
        'qty',
        'duration',
        'price',

        'package',
    ];

    const VALIDATION_RULES = [
        'package_id' => 'required',
        'qty' => 'required|integer',
    ];

    const VALIDATION_MESSAGES = [
    ];

    public function order() {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function package() {
        return $this->belongsTo(Package::class, 'package_id');
    }

    public function items() {
        return $this->hasMany(OrderPackageItem::class, 'order_package_id');
    }
}
