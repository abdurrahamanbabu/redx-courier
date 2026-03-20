<?php 
namespace AbdurRahaman\RedxCourier\Facades;

use Illuminate\Support\Facades\Facade;

class Redx extends Facade{


    /**
    * @see \AbdurRahaman\RedxCourier\Redx;
    
    * @method static array getAreas()
    * @method static array areaByPostCode(int $postCode)
    * @method static array areaByDistrictName(string $districtName)
    * @method static array addPickupStore(array $data)
    * @method static array getPickupStores()
    * @method static array pickupDetails(int|string $pickupId)
    * @method static array getCharge(array $data)
    * @method static array createParcel(array $data)
    * @method static array parcelDetails(string $trackingId)
    * @method static array parcelUpdate(array $data)
    * @method static array trackParcel(string $trackingId)
    * @method static array froudCheck(string $contact)
    * Summary of getFacadeAccessor
    * @return string
    */
    protected static function getFacadeAccessor()
    {
        return 'redx-courier';
    }

    

}
