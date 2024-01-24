<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use AbuDawud\AlCrudLaravel\Models\BaseModel;
use Carbon\CarbonInterval;
use Illuminate\Support\Carbon;

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
        'id',
        'site_id',
        'code',
        'name',
        'instagram',
        'birth_date',
        'no_hp',
        'address',
        'is_member',

        'site',
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

    const VALIDATION_MESSAGES = [];

    public static function newCode($siteCode)
    {
        $prefix = "C{$siteCode}-" . date('y');
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

    public function memberStatus() {
        return $this->belongsTo(Reference::class, 'member_status_id');
    }

    public function getMemberTextAttribute()
    {
        return $this->is_member == 1 ? 'Member' : 'Non-Member';
    }

    public function getMemberCountDownAttribute()
    {
        $now = now();
        $expAt = Carbon::parse($this->member_at)->addYear();
        $diff = $expAt->diffInDays($now);

        return CarbonInterval::days($diff)->cascade()->forHumans();
    }

    public function getMemberIconAttribute()
    {
        return $this->is_member == 1 ? '<span class="fas fa-check-circle text-primary"></span>' : '<span class="fas fa-times-circle text-danger"></span>';
    }
}
