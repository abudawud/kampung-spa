<?php

namespace App\Models\Sys;

use AbuDawud\AlCrudLaravel\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// unimplemented yet
class Role extends BaseModel
{
    use HasFactory;

    const ADMIN = "Admin";
    const ADMIN_CABANG = "Admin Cabang";
    const TERAPIS = "Terapis";
}
