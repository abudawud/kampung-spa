<?php

namespace App\Models;

use AbuDawud\AlCrudLaravel\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property-read int $id
 */
class Temp extends BaseModel
{
    use HasFactory;

    // overide default value
    protected $table = "temp";

    public $fillable = [];

    public $visible = [];

    const VALIDATION_RULES = [];

    const VALIDATION_MESSAGES = [];

    public static function migrateItem($siteId)
    {
        $site = Site::find($siteId);
        foreach (self::get() as $record) {
            // item utama
            $items = $record->utama;
            if (strlen($record->tambahan) > 5) {
                $items .= "," . $record->tambahan;
            }

            foreach (explode(",", $items) as $item) {
                $item = preg_replace('/\s+[0-9]+"$/', "", $item);
                $checkItem = Item::where('name', $item);
                if (!$checkItem->exists()) {
                    Item::create([
                        'site_id' => $siteId,
                        'code' => Item::newCode($site->city_code),
                        'name' => $item,
                        'duration' => 30,
                        'normal_price' => 0,
                        'member_price' => 0,
                    ]);
                }
            }
        }
    }
}
