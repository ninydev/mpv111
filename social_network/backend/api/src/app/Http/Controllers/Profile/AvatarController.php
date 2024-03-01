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

    /**
     * Для решения задачи хранения аватарок пользователя мне необходимо:
     * 1. Сформировать хранилище - место где будут жить файлы
     * 2. Проверить, пришел ли файл в запросе
     * 3. Сохранить файл методами фреймворка (Фасадом для файловой структуры)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        // Проверим - прислал ли пользователь файл
        // Если нет - вренем ошибку - статус
        if (!$request->hasFile("avatar")) {
            return response()-> json([
                'error' => "File not found"
            ], 422);
        }

        // Настроим переменные для хранения файла
        $avatar = $request->file('avatar');
        $user_id = $request->user()->id;
        $path = $user_id . "/avatar.jpg";

        // Сохраним файл
        Storage::disk('avatars')->put($path, $avatar->getContent() );
        $url = Storage::disk('avatars')->url($path);

        // Построим ответ
        return response()->json([
            "result" => "avatar upload",
            "avatar_url" => $url
        ], 201);
    }
}
