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
        'duration',
        'normal_price',
        'member_price',
        'description',
        'launch_at',
        'end_at',
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
        'launch_at',
        'end_at',

        'site',
    ];

    const VALIDATION_RULES = [
        'site_id' => 'required',
        'name' => 'required',
        'duration' => 'required|integer',
        'image_path' => 'nullable',
        'normal_price' => 'required|integer|gte:0',
        'member_price' => 'required|integer|gte:0',
        'description' => 'nullable',
        'launch_at' => 'required|date:Y-m-d',
        'end_at' => 'required|date:Y-m-d',
    ];

    const VALIDATION_MESSAGES = [

    ];

    public static function newCode($siteCode)
    {
        $prefix = "P{$siteCode}-" . date('y');
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

    public function items() {
        return $this->hasMany(PackageItem::class, 'package_id');
    }

    public function createdBy() {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function guestPrice(Customer $customer) {
        return $customer->is_member ? $this->member_price : $this->normal_price;
    }

    public function fullName(Customer $customer) {
        return "{$this->name} | {$this->duration}\" | {$this->guestPrice($customer)}";
    }
}
