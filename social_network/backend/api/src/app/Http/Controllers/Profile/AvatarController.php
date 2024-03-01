<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AvatarController extends Controller
{
    public function __construct()
    {
        $this->middleware ('auth:api');
    }
    public function __invoke(Request $request)
    {
        // Проверим - прислал ли пользователь файл
        // Если нет - вренем ошибку - статус
        if (!$request->hasFile("avatar")) {
            return response()-> json([
                'error' => "File not found"
            ], 422);
        }

        $avatar = $request->file('avatar');
        $user_id = $request->user()->id;
        $path = $user_id . "/avatar.jpg";

        Storage::disk('avatars')->put($path, $avatar->getContent() );
        $url = Storage::disk('avatars')->url($path);

        return response()->json([
            "result" => "avatar upload",
            "avatar_url" => $url
        ], 201);
    }
}
