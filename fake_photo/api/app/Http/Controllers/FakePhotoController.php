<?php

namespace App\Http\Controllers;

use App\Services\RemoveBgService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

class FakePhotoController extends Controller
{
    /**
     * Отобразить форму
     */
    public function show(Request $request){
        return view("fakephoto.form");
    }


    /**
     * Загрузить фото и отобразить результат
     */
    public function store(Request $request){

        $photo = $request->file('photo');
        $back = $request->file('back');

        Storage::disk('azure')
            ->put($photo->getClientOriginalName(), $photo->getContent());
        Storage::disk('azure')
            ->put($back->getClientOriginalName(), $back->getContent());

        $photoUrl=Storage::disk('azure')
            ->url($photo->getClientOriginalName());
        $backUrl=Storage::disk('azure')
            ->url($back->getClientOriginalName());

        $ximilarService = new RemoveBgService();

        $result = $ximilarService->removeBackground($photoUrl);

        $photoBgUrl = $result["records"]["0"]["_output_url"];

        Storage::disk('azure')
            ->put("nobg." . $photo->getClientOriginalName(), file_get_contents($photoBgUrl));
        $photoBgUrl = Storage::disk('azure')
            ->url("nobg." . $photo->getClientOriginalName());

// Загрузка изображений из хранилища
        $manager = ImageManager::imagick();
        // $manager = ImageManager::gd();

        $photo = $manager->read($photoUrl);
        $background = $manager->read($backUrl);

// Размеры фотографии
        $photoWidth = $photo->width();
        $photoHeight = $photo->height();

// Размеры фона (если нужно изменить размер фона под размер фотографии)
        $background->resize($photoWidth, $photoHeight);

// Наложение фотографии на фон

        $background->place($photo,
            'bottom-right',
            10,
            10,
            25);
        Storage::disk('azure')
            ->put("result." . $photo->getClientOriginalName(), $background->toWebp());
        $resultUrl = Storage::disk('azure')
            ->url("result." . $photo->getClientOriginalName());



        return view("fakephoto.result", [
                "photoUrl" => $photoUrl,
                "backUrl" => $backUrl,
                "photoBgUrl" => $photoBgUrl,
                "resultUrl" => $resultUrl
        ]);
    }
}
