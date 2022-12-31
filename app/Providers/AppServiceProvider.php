<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
// python train.py --batch 20  --img 1024 --epochs 3  --data /content/yolov5/data/data.yaml  --weights /content/yolov5/data/yolov5s.pt --cache
