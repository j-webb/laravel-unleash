<?php

namespace JWebb\Unleash\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use KJ\Core\controllers\BaseController;

class MainController extends BaseController
{
    public function refresh(Request $request)
    {
        Artisan::call('cache:features-d-b');

        return response()->json([
            'success' => true
        ]);
    }

}