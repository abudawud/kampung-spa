<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use AbuDawud\AlCrudLaravel\Models\BaseModel;

/**
 * @property-read int $id
 */
class Employee extends BaseModel
{
    use HasFactory;

    protected $table = "employee";

    public $fillable = [
        'position_id',
        'nip',
        'name',
        'no_hp',
        'sex_id',
        'dob',
        'hire_at',
        'height',
        'weight',
        'site_id',
        'address',
        'created_by',
        'is_active'
    ];

    public $visible = [
        'id',
        'site_id',
        'position_id',
        'nip',
        'name',
        'sex_id',
        'dob',
        'no_hp',
        'height',
        'weight',
        'hire_at',
        'address',
        'is_active',

        'position', 'site', 'sex',

    ];

    const VALIDATION_RULES = [
        'position_id' => 'required',
        'name' => 'required',
        'no_hp' => 'required',
        'sex_id' => 'required',
        'dob' => 'required|date:Y-m-d',
        'hire_at' => 'required|date:Y-m-d',
        'height' => 'nullable|integer|gte:0',
        'weight' => 'nullable|integer|gte:0',
        'site_id' => 'required',
        'address' => 'nullable',
        'is_active' => 'nullable',
    ];

    const VALIDATION_MESSAGES = [];

    public function site() {
        return $this->belongsTo(Site::class, 'site_id');
    }

    public function position() {
        return $this->belongsTo(Position::class, 'position_id');
    }

    public function sex() {
        return $this->belongsTo(Reference::class, 'sex_id');
    }
}
