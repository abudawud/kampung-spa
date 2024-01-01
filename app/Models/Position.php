<?php

namespace App\Models;

use AbuDawud\AlCrudLaravel\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property-read int $id
 */
class Position extends BaseModel
{
    use HasFactory;
    const ADMIN_ID = 1;
    const TERAPIS_ID = 2;

    // overide default value
    protected $table = "position";

    public $fillable = [
        'code',
        'name',
        'is_active',
        'created_by'
    ];

    public $visible = [
        'code',
        'name',
        'is_active',
        'created_by'
    ];

    const VALIDATION_RULES = [
        'code',
        'name',
        'is_active',
        'created_by'
    ];

    const VALIDATION_MESSAGES = [

    ];
}
