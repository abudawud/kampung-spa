<?php

namespace App\Models;

use AbuDawud\AlCrudLaravel\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property-read int $id
 */
class CustomerRegistration extends BaseModel
{
    use HasFactory;

    protected $table = "customer_registration";

    public $fillable = [
        'customer_id',
        'code',
        'price',
        'description',
        'created_by'
    ];

    public $visible = [
        'customer_id',
        'price',
        'description',
        'created_at',

        // relation
        'customer',
    ];

    const VALIDATION_RULES = [
        'customer_id' => 'required',
        'price' => 'required',
        'description' => 'nullable',
    ];

    const VALIDATION_MESSAGES = [

    ];

    public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
