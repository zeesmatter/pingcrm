<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomersRequest;
use App\Http\Requests\UpdateCustomersRequest;
use App\Models\CustomerAddress;
use App\Models\CustomerPhone;
use App\Models\Customers;
use App\Models\Memberships;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('Customers/Index', [
            'filters' => Request::all('search', 'trashed'),
            'customers' => Customers::
//                with('organization')
            orderByName()
                ->filter(Request::only('search', 'trashed'))
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($customer) => [
                    'id' => $customer->id,
                    'name' => $customer->name,
                    'email' => $customer->email,
                ]),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Customers/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCustomersRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $customer = Customers::create(
            Request::validate([
                'name' => ['required', 'max:50'],
                'email' => ['nullable', 'max:50', 'email']
            ])
        );

        return redirect('customers/'.$customer->id . '/edit')->with('success', 'Contact created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customers  $customers
     * @return \Illuminate\Http\Response
     */
    public function show(Customers $customers)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customers  $customers
     * @return \Inertia\Response
     */
    public function edit(Customers $customer)
    {

        return Inertia::render('Customers/Edit', [
            'customer' => [
                'id' => $customer->id,
                'name' => $customer->name,
                'email' => $customer->email,
                'phones'    =>  $customer->phones->toArray(),
                'address'   =>  $customer->address->toArray(),
                'newNumber'  =>  null
            ],
            'customerMemberships'   =>  $customer->memberships()->withPivot('start_at', 'expire_at', 'status')->get(),
            'memberships'   => Memberships::select('id', 'name')->get()->map->only('id', 'name'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCustomersRequest  $request
     * @param  \App\Models\Customers  $customers
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Customers $customer)
    {

        $customer->update(
            Request::validate([
                'name' => ['required', 'max:50'],
                'email' => ['nullable', 'max:50', 'email']
            ])
        );

        foreach(request()->phones as $phone)
        {
            CustomerPhone::find($phone['id'])->update($phone);
        }

        if(request()->address && is_array(request()->address))
            foreach(request()->address as $address)
            {
                $data = collect($address)->only(CustomerAddress::fillableFields())->toArray();
                if(isset($address['id']))
                {
                    CustomerAddress::find($address['id'])->update($data);
                }
                else if( $this->checkValues($address) )
                {
                    $customer->address()->create();
                }

            }


        if(request()->newNumber)
            $customer->phones()->create(['phone_number' =>  \request()->newNumber]);

        return Redirect::back()->with('success', 'Customer updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customers  $customers
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customers $customers)
    {
        //
    }

    public function checkValues(Array $values)
    {

        foreach($values as $key => $val)
        {
            if($val) return true;
        }

        return false;
    }


}
