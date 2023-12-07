<?php

namespace App\Models;

use AbuDawud\AlCrudLaravel\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property-read int $id
 */
class Reference extends BaseModel
{
    use HasFactory;

    // overide default value
    protected $table = "reference";

    public $fillable = [
        'cat_id',
        'cat_name',
        'code',
        'name',
        'description',
        'order',
        'is_active'
    ];

    public $visible = [
        'cat_id',
        'cat_name',
        'code',
        'name',
        'description',
        'order',
        'is_active'
    ];

    const VALIDATION_RULES = [
        'cat_id',
        'cat_name',
        'code',
        'name',
        'description',
        'order',
        'is_active'
    ];

    const VALIDATION_MESSAGES = [

    ];
}
