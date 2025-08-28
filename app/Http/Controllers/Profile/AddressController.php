<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAddressRequest;
use App\Services\Address as AddressService;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use Yajra\DataTables\DataTables;

class AddressController extends Controller
{
    protected AddressService $addressService;

    public function __construct(AddressService $addressService)
    {
        $this->addressService = $addressService;
    }

    public function index()
    {
        $addresses = $this->addressService->get();
        return view("profile.address",[
            "addresses" => $addresses,
            "user" => auth()->user(),
            "SEOData" => new SEOData(
                title: trans("message.my_addresses"),
                description: trans("message.parde_e_shop_seo")." | ". trans("message.profile"). " | " . trans("message.my_addresses")
            )
        ]);
        //return DataTables::of($addresses)->make(true);
    }
    public function store(StoreAddressRequest $request)
    {
        $address = $this->addressService
            ->setPostalcode($request->postal_code)
            ->setName($request->name)
            ->setUser(auth()->user())
            ->setAddress($request->address)
            ->setCity($request->city)
            ->setIsDefault($request->is_default)
            ->create();
        flash(trans("message.added_successfully"));
        return redirect()
            ->back();
    }

    public function update(StoreAddressRequest $request, int $id)
    {
        $address = $this->addressService
            ->setPostalcode($request->postal_code)
            ->setName($request->name)
            ->setUser($this->user())
            ->setAddress($request->address)
            ->setCity($request->city)
            ->setIsDefault($request->is_default)
            ->update($id);
        return $this->res($address);
    }

    public function delete(int $id)
    {
        $address = $this->addressService
            ->setUser(auth()->user())
            ->delete($id);
        return redirect()
            ->back();
    }
}
