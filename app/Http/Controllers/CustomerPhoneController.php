<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerPhoneRequest;
use App\Http\Requests\UpdateCustomerPhoneRequest;
use App\Models\CustomerPhone;

class CustomerPhoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCustomerPhoneRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomerPhoneRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CustomerPhone  $customerPhone
     * @return \Illuminate\Http\Response
     */
    public function show(CustomerPhone $customerPhone)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CustomerPhone  $customerPhone
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomerPhone $customerPhone)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCustomerPhoneRequest  $request
     * @param  \App\Models\CustomerPhone  $customerPhone
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomerPhoneRequest $request, CustomerPhone $customerPhone)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CustomerPhone  $customerPhone
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomerPhone $customerPhone)
    {
        //
    }
}
