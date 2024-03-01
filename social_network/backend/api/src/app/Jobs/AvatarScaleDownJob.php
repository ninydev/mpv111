<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\ImageManager;

class AvatarScaleDownJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private $user_id)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $avatar = Storage::disk('avatars')->get($this->user_id . "/original");


        // Подключим библиотеку
        $manager = new ImageManager(new Driver());

        // Создадим аватары для разных разрешений и ужмем их в формат webP
        // 100 - 100
        $avatarSmallManager = $manager->read($avatar);
        $avatarSmallManager->scaleDown(100,100);
        $pathSmall = $this->user_id . "/small.webp";
        Storage::disk('avatars')->put($pathSmall, $avatarSmallManager->toWebp());
        $urlSmall = Storage::disk('avatars')->url($pathSmall);

        // 300 - 300
        $avatarBigManager = $manager->read($avatar);
        $avatarBigManager->scaleDown(300,300);
        $pathBig = $this->user_id . "/big.webp";
        Storage::disk('avatars')->put($pathBig, $avatarBigManager->toWebp());
        $urlBig = Storage::disk('avatars')->url($pathBig);
    }
}
