<?php

namespace AbdurRahaman\RedxCourier;

use Illuminate\Support\Facades\Http;

class Redx
{
    protected string $apiKey;
    protected int $timeout;
    protected string $baseUrl;
    protected string $env;

    public function __construct()
    {
        $this->env = config('redex-courier.redx_env', 'SANDBOX');
        $this->apiKey = config("redex-courier.api_key", '');
        $this->timeout = config('redex-courier.timeout', 30);
        $this->baseUrl = $this->env === 'LIVE' ? config('redex-courier.live_url')  : config('redex-courier.sendbox_url');
    }


    private function request(string $method, string $uri, array $params = []): array
    {
        $response = Http::withHeaders([
            'API-ACCESS-TOKEN' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ])
            ->timeout($this->timeout)
            ->baseUrl($this->baseUrl)
            ->$method($uri, $params);

        return $response->json();
    }



    public function getAreas(): array
    {
        $data = $this->request('get', '/v1.0.0-beta/areas');
        return $data['areas'] ?? [];
    }

    public function areaByPostCode(int $postalCode): array
    {
        return $this->request('get', '/v1.0.0-beta/areas', ['post_code' => $postalCode]);
    }

    public function areaByDistrictName(string $districtName): array
    {
        return $this->request('get', '/v1.0.0-beta/areas', ['district_name' => $districtName]);
    }

    public function addPickupStore(array $data): array
    {
        return $this->request('post', '/v1.0.0-beta/pickup/store', [
            "name" => $data['name'] ?? '',
            "phone" => $data['phone'] ?? '',
            "address" => $data['address'] ?? '',
            "area_id" => $data['area_id'] ?? null,
        ]);
    }

    public function getPickupStores(): array
    {
        return $this->request('get', '/v1.0.0-beta/pickup/stores');
    }

    public function pickupDetails(int|string $pickupId): array
    {
        return $this->request('get', '/v1.0.0-beta/pickup/store/info/' . $pickupId);
    }



    public function getCharge(array $data): array
    {
        return $this->request('get', '/v1.0.0-beta/charge/charge_calculator', [
            'delivery_area_id' => $data['area_id'] ?? null,
            'pickup_area_id' => $data['pickup_id'] ?? null,
            'cash_collection_amount' => $data['total_amount'] ?? 0,
            'weight' => $data['weight'] ?? 0,
        ]);
    }

    public function createParcel(array $data): array
    {
        // Required fields
        $required = [
            'customer_name',
            'customer_phone',
            'delivery_area',
            'delivery_area_id',
            'customer_address',
            'merchant_invoice_id',
            'cash_collection_amount',
            'parcel_weight',
            'instruction',
            'value',
            'is_closed_box',
            'pickup_store_id',
            'parcel_details_json',
        ];

        // Check missing fields
        $missing = array_diff($required, array_keys($data));
        if (!empty($missing)) {
            throw new \InvalidArgumentException('Missing required fields: ' . implode(', ', $missing));
        }

        // Use the reusable request method
        return $this->request('post', '/v1.0.0-beta/parcel', $data);
    }

    public function parcelDetails(string $tracking_id){
         return $this->request('get', '/v1.0.0-beta/parcel/info/' . $tracking_id);
    }

    public function parcelUpdate($data = []){
        $payload = [
            'entity_type' => $data['entity_type'],
            'entity_id' => $data['entity_id'],
            'update_details' => [
                'property_name' => $data['property_name'],
                'new_value' => $data['new_value'],
                'reason' => $data['reason'] ?? '',
            ]
        ];
        return $this->request('patch', '/v1.0.0-beta/parcels', $payload);
    }

    public function trackParcel($tracking_id)
    {
       return $this->request('get','v1.0.0-beta/parcel/track/'.$tracking_id);
    }


    public function froudCheck($contact){

        $contact = ensureCountryCode($contact);
        $response = Http::withHeaders([
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
            'Accept' => 'application/json, text/plain, */*',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->get("https://redx.com.bd/api/redx_se/admin/parcel/customer-success-return-rate?phoneNumber={$contact}");

        return $response->json();
    }
}
