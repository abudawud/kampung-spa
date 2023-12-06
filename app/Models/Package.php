<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use AbuDawud\AlCrudLaravel\Models\BaseModel;

/**
 * @property-read int $id
 */
class Package extends BaseModel
{
    use HasFactory;

    protected $table = "package";

    public $fillable = [
        'site_id',
        'code',
        'name',
        'image_path',
        'normal_price',
        'member_price',
        'description',
        'launch_at',
        'end_at',
        'created_by'
    ];

    public $visible = [
        'site_id',
        'code',
        'name',
        'normal_price',
        'member_price',
        'description',
        'launch_at',
        'end_at',
    ];

    const VALIDATION_RULES = [
        'site_id' => 'required',
        'name' => 'required',
        'image_path' => 'nullable',
        'normal_price' => 'required|integer|gte:0',
        'member_price' => 'required|integer|gte:0',
        'description' => 'nullable',
        'launch_at' => 'required|date:Y-m-d',
        'end_at' => 'required|date:Y-m-d',
    ];

    const VALIDATION_MESSAGES = [

    ];
}
