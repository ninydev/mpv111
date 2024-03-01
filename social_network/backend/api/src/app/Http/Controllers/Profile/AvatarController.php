<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UploadAvatarRequest;
use App\Jobs\AvatarScaleDownJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\ImageManager;

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
    public function __invoke(UploadAvatarRequest $request)
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


        // Проверка типа файла
        if (!$avatar->isValid() ||
            !in_array($avatar->getClientMimeType(), [
                'image/jpeg', 'image/png', 'image/gif', 'image/jpg', 'image/webp'])) {
            return response()->json(['error' => '
            Файл должен быть изображением в формате JPEG, PNG, JPG, GIF или WEBP'], 400);
        }


        // Сохраним файл - который прислал пользователь
        $pathOriginal = $user_id . "/original";
        Storage::disk('avatars')->put($pathOriginal, $avatar->getContent() );
        $urlOriginal = Storage::disk('avatars')->url($pathOriginal);

        /**
         * Код, связанный с птимизацией аватарки необходимо выполнять
         * в фоновом режиме - то есть вне контроллера
         *
         * По этому мы переносим его в Job
         */

//        // Подключим библиотеку
//        $manager = new ImageManager(new Driver());
//
//        // Создадим аватары для разных разрешений и ужмем их в формат webP
//        // 100 - 100
//        $avatarSmallManager = $manager->read($avatar->getContent());
//        $avatarSmallManager->scaleDown(100,100);
//        $pathSmall = $user_id . "/small.webp";
//        Storage::disk('avatars')->put($pathSmall, $avatarSmallManager->toWebp());
//        $urlSmall = Storage::disk('avatars')->url($pathSmall);
//
//        // 300 - 300
//        $avatarBigManager = $manager->read($avatar->getContent());
//        $avatarBigManager->scaleDown(300,300);
//        $pathBig = $user_id . "/big.webp";
//        Storage::disk('avatars')->put($pathBig, $avatarBigManager->toWebp());
//        $urlBig = Storage::disk('avatars')->url($pathBig);

        // Выполняем задачу в фоновом режиме
        AvatarScaleDownJob::dispatch($user_id);

        /**
         * К этому моменту у меня еще нет оптимизированных аватарок
         * То есть - я не могу вернуть пользователю ссылки на них
         */
//        // Построим ответ
//        return response()->json([
//            "result" => "avatar upload",
//            "original" => $urlOriginal,
//            "avatar_urls" => [
//                "small" => $urlSmall,
//                "big" => $urlBig
//            ]
//        ], 201);

        return response()->json([
            "result" => "avatar upload",
            "original" => $urlOriginal,
            "message" => "Ваша аватарка стоит в очереди на оптимизацию"
        ], 201);
    }
}
