<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use AbuDawud\AlCrudLaravel\Models\BaseModel;

/**
 * @property-read int $id
 */
class OrderPackageItem extends BaseModel
{
    use HasFactory;

    protected $table = "order_package_item";

    public $fillable = [
        'order_package_id',
        'item_id',
        'qty',
        'duration',
        'price'
    ];

    public $visible = [
        'order_package_id',
        'item_id',
        'qty',
        'duration',
        'price'
    ];

    const VALIDATION_RULES = [
        'order_package_id',
        'item_id',
        'qty',
        'duration',
        'price'
    ];

    const VALIDATION_MESSAGES = [

    ];

    public function item() {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
