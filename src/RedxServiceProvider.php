<?php
namespace AbdurRahaman\RedxCourier;

use Illuminate\Support\ServiceProvider;

class RedxServiceProvider extends ServiceProvider{

    public function register(){
        
        $this->mergeConfigFrom(
            __DIR__.'/config/redex-courier.php',
            'redx'
        );

        $this->app->bind('redx-courier',function($app){
            return new \AbdurRahaman\RedxCourier\Redx();
        });
    }


    public function boot(){
        if(file_exists(__DIR__.'/Helpers/helper.php')){
            require_once __DIR__.'/Helpers/helper.php';
        }

         $this->publishes([
            __DIR__.'/config/redex-courier.php' => config_path('redex-courier.php'),
        ], 'redx-config');
    }

}