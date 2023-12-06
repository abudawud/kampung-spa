<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use AbuDawud\AlCrudLaravel\Models\BaseModel;

/**
 * @property-read int $id
 */
class Customer extends BaseModel
{
    use HasFactory;

    protected $table = "customer";

    public $fillable = [
        'site_id',
        'code',
        'name',
        'instagram',
        'birth_date',
        'no_hp',
        'address',
        'is_member',
        'created_by'
    ];

    public $visible = [
        'site_id',
        'code',
        'name',
        'instagram',
        'birth_date',
        'no_hp',
        'address',
        'is_member',
    ];

    const VALIDATION_RULES = [
        'site_id' => 'required',
        'name' => 'required',
        'instagram' => 'nullable',
        'birth_date' => 'required',
        'no_hp' => 'required',
        'address' => 'nullable',
        'is_member' => 'nullable',
    ];

    const VALIDATION_MESSAGES = [

    ];
}
