<?php

namespace App\Services\Location;

use Illuminate\Support\Facades\Cache;

class StateService
{
    private array $cities;
    private array $provinces;

    public function __construct()
    {
        $this->cities = Cache::rememberForever('cities', function(){
            return json_decode(file_get_contents(__DIR__ . '/cities.json'), true);
        });
        $this->provinces = Cache::rememberForever('provinces', function(){
            return json_decode(file_get_contents(__DIR__ . '/provinces.json'), true);
        });
    }

    public function getAllCities(): array
    {
        return $this->cities;
    }

    public function getAllProvinces(): array
    {
        return $this->provinces;
    }

    public function getCitiesByProvinceName(string $name): array
    {
        $province = current(array_filter($this->provinces, fn ($p) => $p['name'] === $name));
        return $province ? array_filter($this->cities, fn ($city) => $city['province_id'] === $province['id']) : [];
    }

    public function getCitiesByProvinceId(int $id): array
    {
        return array_filter($this->cities, fn ($city) => $city['province_id'] === $id);
    }

    public function getCitiesByProvinceSlug(string $slug): array
    {
        $province = current(array_filter($this->provinces, fn ($p) => $p['slug'] === $slug));
        return $province ? array_filter($this->cities, fn ($city) => $city['province_id'] === $province['id']) : [];
    }

    public function getCityByName(string $name): array
    {
        return array_filter($this->cities, fn ($city) => $city['name'] === $name);
    }

    public function getCityById(int $id): array
    {
        return array_filter($this->cities, fn ($city) => $city['id'] === $id);
    }

    public function getCityBySlug(string $slug): array
    {
        return array_filter($this->cities, fn ($city) => $city['slug'] === $slug);
    }
}
