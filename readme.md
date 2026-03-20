Installation
Run the following command to install the package:

``` bash

composer require abdur-rahaman/redx-courier

```

Configuration
After installation, publish the configuration file:

``` bash

php artisan vendor:publish --provider="AbdurRahaman\\RedxCourier\\RedxServiceProvider"

```

This will create a config/redex-courier.php file. Update the configuration with your API key and environment settings.

Example configuration:

``` bash
<?php

return [
    'api_key' => env('REDX_API_KEY'),
    'redx_env' => env('REDX_ENV', 'SANDBOX'), // 'SANDBOX' or 'LIVE'
    'live_url' => 'https://api.redx.com.bd',
    'sendbox_url' => 'https://sandbox.redx.com.bd',
    'timeout' => 30,
];

```

Usage
Basic Usage
Use the Redx facade or resolve the service from the container.

``` bash
<?php
    use AbdurRahaman\RedxCourier\Facades\Redx;

    // Get all areas
    $areas = Redx::getAreas();

    // Get area by postal code
    $area = Redx::areaByPostCode(1200);

    // Add a pickup store
    $store = Redx::addPickupStore([
        'name' => 'My Store',
        'phone' => '0123456789',
        'address' => '123 Main St',
        'area_id' => 1,
    ]);

    // Get charge for delivery
    $charge = Redx::getCharge([
        'area_id' => 1,
        'pickup_id' => 1,
        'total_amount' => 1000,
        'weight' => 1.5,
    ]);

    // Create a parcel
    $parcel = Redx::createParcel([
        'customer_name' => 'John Doe',
        'customer_phone' => '0123456789',
        'delivery_area' => 'Dhaka',
        'delivery_area_id' => 1,
        'customer_address' => '456 Elm St',
        'merchant_invoice_id' => 'INV001',
        'cash_collection_amount' => 1000,
        'parcel_weight' => 1.5,
        'instruction' => 'Handle with care',
        'value' => 1000,
        'is_closed_box' => true,
        // ... other fields
    ]);

    // Update a Parcel
    $update = Redex::parcelUpdate([
         'entity_type' => "parcel-tracking-id", 
         "entity_id" => '20A316MOG0DI',
         "property_name" => 'status', // Property name you want to update
         "new_value" => "cancelled", // Update value
         "reason" => "Customer Change his mind" // Update reason
    ]);

```


Available Methods

```bash
getAreas(): Get all delivery areas

areaByPostCode(int $postalCode): Get area by postal code

areaByDistrictName(string $districtName): Get area by district name

addPickupStore(array $data): Add a pickup store

getPickupStores(): Get all pickup stores

pickupDetails(int|string $pickupId): Get pickup store details

getCharge(array $data): Calculate delivery charge

createParcel(array $data): Create a new parcel

trackParcel(string $tracking_id) : Track a Parcel 

parcelUpdate(array $data ) : Update Parcel Details

froudCheck(string $contact): Customer Recieved and cancelation ratio 

```
Requirements
PHP 8.1 or higher

Laravel 9 or higher

License
MIT