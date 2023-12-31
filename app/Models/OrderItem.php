<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use AbuDawud\AlCrudLaravel\Models\BaseModel;

/**
 * @property-read int $id
 */
class OrderItem extends BaseModel
{
    use HasFactory;

    protected $table = "order_item";

    public $fillable = [
        'order_id',
        'item_id',
        'qty',
        'duration',
        'price',
        'total',
    ];

    public $visible = [
        'order_id',
        'item_id',
        'qty',
        'duration',
        'price',

        'item',
    ];

    const VALIDATION_RULES = [
        'item_id' => 'required',
        'qty' => 'required|integer',
    ];

    const VALIDATION_MESSAGES = [];

    public function order() {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function item() {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
