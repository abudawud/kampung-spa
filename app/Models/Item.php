<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use AbuDawud\AlCrudLaravel\Models\BaseModel;

/**
 * @property-read int $id
 */
class Item extends BaseModel
{
    use HasFactory;

    protected $table = "item";

    public $fillable = [
        'site_id',
        'code',
        'name',
        'duration',
        'image_path',
        'normal_price',
        'member_price',
        'description',
        'is_active',
        'created_by'
    ];

    public $visible = [
        'id',
        'site_id',
        'code',
        'name',
        'duration',
        'normal_price',
        'member_price',
        'description',
        'is_active',

        'site',
    ];

    const VALIDATION_RULES = [
        'site_id' => 'required',
        'name' => 'required',
        'duration' => 'required|integer|gte:0',
        'image_path' => 'nullable',
        'normal_price' => 'required|integer|gte:0',
        'member_price' => 'required|integer|gte:0',
        'description' => 'nullable',
        'is_active' => 'nullable',
    ];

    const VALIDATION_MESSAGES = [];

    public static function newCode($siteCode)
    {
        $prefix = "I{$siteCode}-" . date('y');
        $lastNo = static::where('code', 'like', "{$prefix}%")
            ->latest('id');
        $newNo = 1;
        if ($lastNo->exists()) {
            $newNo = (int) str_replace($prefix, "", $lastNo->first()->code);
            $newNo += 1;
        }

        return $prefix . \Illuminate\Support\Str::padLeft($newNo, 4, 0);
    }

    public function site() {
        return $this->belongsTo(Site::class, 'site_id');
    }

    public function guestPrice(Customer $customer) {
        return $customer->is_member ? $this->member_price : $this->normal_price;
    }

    public function fullName(Customer $customer) {
        return "{$this->name} | {$this->duration}\" | {$this->guestPrice($customer)}";
    }
}
