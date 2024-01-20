<?php

namespace App\Models;

use AbuDawud\AlCrudLaravel\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property-read int $id
 */
class Order extends BaseModel
{
    use HasFactory;

    protected $table = "order";

    public $fillable = [
        'code', 'customer_id', 'order_date',
        'start_time', 'end_time', 'name',
        'terapis_id', 'price', 'transport',
        'invoice_total', 'cash', 'transfer',
        'payment_total', 'description', 'created_by',
        'sec', 'status_id', 'ex_night', 'site_id',
        'site_bank_id',
    ];

    public $visible = [
        'code', 'customer_id', 'order_date',
        'name', 'terapis_id', 'price',
        'transport', 'invoice_total', 'payment_total',
        'status_id', 'ex_night', 'site_id',

        // relation
        'customer', 'terapis',
        'site',

        // raw column
        'terapis_price',
    ];

    public $casts = [
        'order_date' => 'date',
    ];

    const VALIDATION_RULES = [
        'site_id' => 'required',
        'customer_id' => 'required',
        'order_date' => 'required|date:Y-m-d',
        'start_time' => 'required',
        'end_time' => 'required',
        'name' => 'required',
        'terapis_id' => 'required',
        'transport' => 'required|integer',
        'ex_night' => 'required|integer',
        'description' => 'nullable',
    ];

    const VALIDATION_MESSAGES = [];

    public static function newCode($siteCode)
    {
        $prefix = "O{$siteCode}-" . date('ym');
        $lastNo = static::where('code', 'like', "{$prefix}%")
            ->latest('id');
        $newNo = 1;
        if ($lastNo->exists()) {
            $newNo = hexdec(str_replace($prefix, "", $lastNo->first()->code));
            $newNo += 1;
        }
        $newNo = dechex($newNo);

        return $prefix . \Illuminate\Support\Str::padLeft($newNo, 4, 0);
    }

    public function updateInvoice() {
        $this->price = $this->items->sum('total') + $this->packages->sum('total');
        $this->invoice_total = $this->price + $this->transport + $this->ex_night;
        $this->save();
    }

    public function getIsDraftAttribute() {
        return $this->status_id == Reference::ORDER_STATUS_DRAFT_ID;
    }

    public function getIsPaidAttribute() {
        return $this->status_id == Reference::ORDER_STATUS_TERBAYAR_ID;
    }

    public function getIsProcessAttribute() {
        return $this->status_id == Reference::ORDER_STATUS_PROSES_ID;
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function site() {
        return $this->belongsTo(Site::class, 'site_id');
    }

    public function terapis()
    {
        return $this->belongsTo(Employee::class, 'terapis_id');
    }

    public function createdBy() {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function packages() {
        return $this->hasmany(OrderPackage::class, 'order_id');
    }

    public function items() {
        return $this->hasmany(OrderItem::class, 'order_id');
    }
}
