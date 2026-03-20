<?php 
namespace AbdurRahaman\RedxCourier\Facades;

use Illuminate\Support\Facades\Facade;

class Redx extends Facade{

    /**
     * @see \AbdurRahaman\RedxCourier\Redx;
     * Summary of getFacadeAccessor
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'redx-courier';
    }

    

}
