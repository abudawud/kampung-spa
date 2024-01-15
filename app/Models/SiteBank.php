<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use AbuDawud\AlCrudLaravel\Models\BaseModel;

/**
 * @property-read int $id
 */
class SiteBank extends BaseModel
{
    use HasFactory;

    protected $table = "site_bank";

    public $fillable = [
        'site_id', 'bank_type_id', 'bank_no',
        'is_active', 'name', 'created_by',
    ];

    public $visible = [
        'site_id', 'bank_type_id', 'bank_no',
        'is_active', 'name',

        // relation
        'bankType'
    ];

    const VALIDATION_RULES = [
        'bank_type_id' => 'required',
        'bank_no' => 'required',
        'is_active' => 'required',
        'name' => 'required',
    ];

    const VALIDATION_MESSAGES = [

    ];

    public function site() {
        return $this->belongsTo(Site::class, 'site_id');
    }

    public function bankType() {
        return $this->belongsTo(Reference::class, 'bank_type_id');
    }
}
