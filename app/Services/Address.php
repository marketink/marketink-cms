<?php

namespace App\Services;

use App\Models\Address as Model;

class Address
{
    protected $user;
    protected string $name;
    protected ?string $address;
    protected string $city;
    protected ?int $postalCode;
    protected ?bool $isDefault;
    public static function make()
    {
        return new static();
    }

    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    public function create()
    {
        $this->disableIsDefualt();

        return Model::query()
            ->create([
                'is_default' => $this->isDefault,
                'city' => $this->city,
                'user_id' => $this->user->id,
                'address' => $this->address,
                'name' => $this->name,
                'postal_code' => $this->postalCode
            ]);
    }

    public function disableIsDefualt()
    {

        if ($this->isDefault) {
            $defaultAddress = Model::query()
                ->where('user_id', $this->user->id)
                ->where('is_default', true)
                ->first();
            if ($defaultAddress)
                $defaultAddress->update([
                    'is_default' => false
                ]);
        }
    }
    public function update(int $id)
    {
        $address = Model::query()
            ->where('user_id', $this->user->id)
            ->findOrFail($id);
        $this->disableIsDefualt();
        $address->update([
            'address' => $this->address,
            'postal_code' => $this->postalCode,
            'city' => $this->city,
            'is_default' => $this->isDefault
        ]);
        return $address->refresh();
    }

    public function index()
    {
        return Model::query();
    }

    public function get()
    {
        return $this->index()
            ->when($this?->user?->id ?? null, function ($query) {
                $query->where('user_id', $this->user->id);
            })
            ->get();
    }

    public function delete(int $id)
    {
        $address = Model::query()
            ->where("user_id", $this->user->id)
            ->findOrFail($id);
        $address->delete();
        return $address;
    }

    public function setAddress(string $address)
    {
        $this->address = $address;
        return $this;
    }

    public function setName(string $name = null)
    {
        $this->name = $name;
        return $this;
    }
    public function setPostalcode(int $postalCode = null)
    {
        $this->postalCode = $postalCode;
        return $this;
    }

    public function setIsDefault(bool $isDefault = null)
    {
        $this->isDefault = $isDefault;
        if ($this->isDefault == null) {
            $this->isDefault = false;
        }
        return $this;
    }
    public function setCity(string $city)
    {
        $this->city = $city;
        return $this;
    }
}
