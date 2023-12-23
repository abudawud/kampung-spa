<?php

use AbuDawud\AlCrudLaravel\Models\BaseModel;

return [
    'parent_model' => BaseModel::class,
    'user_model' => 'App\Models\User',
    'controller' => 'App\Http\Controllers\Controller.php',
    'route_model' => 'App\Models\Sys\Route',
    'menu_model' => 'App\Models\Sys\Menu',
    'default_module_id' => 1,
    'default_role_id' => 1,
];
