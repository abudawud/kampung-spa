<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use AbuDawud\AlCrudLaravel\Models\BaseModel;

/**
 * @property-read int $id
 */
class Site extends BaseModel
{
    use HasFactory;

    // overide default value
    protected $table = "site";

    public $fillable = [
        'city_code',
        'city_name',
        'owner_name',
        'no_hp',
        'address',
        'created_by'
    ];

    public $visible = [
        'city_code',
        'city_name',
        'owner_name',
        'no_hp',
        'address',
    ];

    const VALIDATION_RULES = [
        'city_code' => 'required|unique:site,city_code',
        'city_name' => 'required',
        'owner_name' => 'required',
        'no_hp' => 'nullable',
        'address' => 'nullable',
    ];

    const VALIDATION_MESSAGES = [

    ];
}
