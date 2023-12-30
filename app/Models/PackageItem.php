<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use AbuDawud\AlCrudLaravel\Models\BaseModel;

/**
 * @property-read int $id
 */
class PackageItem extends BaseModel
{
    use HasFactory;

    protected $table = "package_item";

    public $fillable = [
        'package_id',
        'item_id'
    ];

    public $visible = [
        'package_id',
        'item_id',

        'item',
    ];

    const VALIDATION_RULES = [
        'items' => 'required|array',
    ];

    const VALIDATION_MESSAGES = [

    ];

    public function item() {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
