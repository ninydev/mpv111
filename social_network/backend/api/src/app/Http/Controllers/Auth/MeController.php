<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

class MeController extends Controller
{
    public function __construct()
    {
        $this->middleware ('auth:api');
    }
    public function __invoke(Request $request)
    {
        $user = $request->user();

        return response()->json($user);
    }
}
