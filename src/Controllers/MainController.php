<?php

namespace JWebb\Unleash\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use KJ\Core\controllers\BaseController;

class MainController extends BaseController
{

    public function __construct()
    {
        $this->setGuard();
        parent::__construct();
    }

    public function refresh(Request $request)
    {
        Artisan::call('cache:features-d-b');

        return response()->json([
            'success' => true
        ]);
    }
    public function setGuard(): void
    {
        $this->guard = config('unleash.guard', 'auth');
    }

}