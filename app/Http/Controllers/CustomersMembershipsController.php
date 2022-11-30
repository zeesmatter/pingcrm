<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomersMembershipsRequest;
use App\Http\Requests\UpdateCustomersMembershipsRequest;
use App\Models\Customers;
use App\Models\CustomersMemberships;
use App\Models\Memberships;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CustomersMembershipsController extends Controller
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
     * @param  \App\Http\Requests\StoreCustomersMembershipsRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Customers $customer, Request $request)
    {

        if($request->membership && $membership = Memberships::findOrFail($request->membership))
        {

            if( ($activeMemberships = $customer->activeMembership) ? $activeMemberships->count() > 0 : null)
            {
                $active = $activeMemberships->last();

                $active->pivot->forceExpire();
            }

            $start_at = NOW();
            $expire_at = NOW()->addDays($membership->period);
            $customer->memberships()->attach($membership->id, ['start_at' => $start_at, 'expire_at' => $expire_at]);

            return Redirect::back()->with('success', 'Membership Added.');

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CustomersMemberships  $customersMemberships
     * @return \Illuminate\Http\Response
     */
    public function show(CustomersMemberships $customersMemberships)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CustomersMemberships  $customersMemberships
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomersMemberships $customersMemberships)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCustomersMembershipsRequest  $request
     * @param  \App\Models\CustomersMemberships  $customersMemberships
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomersMembershipsRequest $request, CustomersMemberships $customersMemberships)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CustomersMemberships  $customersMemberships
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomersMemberships $customersMemberships)
    {
        //
    }
}
