<?php

namespace App\Models;

use AbuDawud\AlCrudLaravel\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property-read int $id
 */
class Order extends BaseModel
{
    use HasFactory;

    protected $table = "order";

    public $fillable = [
        'code', 'customer_id', 'order_date',
        'start_time', 'end_time', 'name',
        'terapis_id', 'price', 'transport',
        'invoice_total', 'cash', 'transfer',
        'payment_total', 'description', 'created_by'
    ];

    public $visible = [
        'code', 'customer_id', 'order_date',
        'name', 'terapis_id', 'price',
        'transport', 'invoice_total', 'payment_total',

        // relation
        'customer', 'terapis',
    ];

    const VALIDATION_RULES = [
        'customer_id' => 'required',
        'order_date' => 'required|date:Y-m-d',
        'start_time' => 'required|regex:/^([01]\d|2[0-3]):([0-5]\d):([0-5]\d)$/i',
        'end_time' => 'required|regex:/^([01]\d|2[0-3]):([0-5]\d):([0-5]\d)$/i',
        'name' => 'required',
        'terapis_id' => 'required',
        'transport' => 'required|integer',
        'description' => 'nullable',
    ];

    const VALIDATION_MESSAGES = [];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function terapis()
    {
        return $this->belongsTo(Employee::class, 'terapis_id');
    }

    public function createdBy() {
        return $this->belongsTo(User::class, 'created_by');
    }
}
