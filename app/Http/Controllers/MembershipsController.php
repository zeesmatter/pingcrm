<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMembershipsRequest;
use App\Http\Requests\UpdateMembershipsRequest;
use App\Models\Memberships;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class MembershipsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('Memberships/Index', [
            'filters' => Request::all('search', 'trashed'),
            'memberships' => Memberships::
            orderByName()
                ->filter(Request::only('search', 'trashed'))
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($membership) => [
                    'id' => $membership->id,
                    'name' => $membership->name,
                    'price' => $membership->price,
                    'trial_allowed' => $membership->trial_allowed,
                    'period' => $membership->period,
                    'status' => $membership->status,
                    'data'  =>  $membership->data,
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
        return Inertia::render('Memberships/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMembershipsRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        Memberships::create(
            Request::validate([
                'name' => ['required', 'max:50'],
                'price' => ['required', 'max:4|integer'],
                'trial_allowed' => ['required', 'boolean'],
                'period' => ['required', 'max:3'],
                'status' => ['required', 'boolean']
            ])
        );

        return Redirect::route('memberships')->with('success', 'Contact created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Memberships  $memberships
     * @return \Illuminate\Http\Response
     */
    public function show(Memberships $memberships)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Memberships  $memberships
     * @return \Inertia\Response
     */
    public function edit(Memberships $membership)
    {
        return Inertia::render('Memberships/Edit', [
            'membership' => [
                'id' => $membership->id,
                'name' => $membership->name,
                'price' => $membership->price,
                'trial_allowed' => $membership->trial_allowed,
                'period' => $membership->period,
                'status' => $membership->status
            ],
            'organizations' => Auth::user()->account->organizations()
                ->orderBy('name')
                ->get()
                ->map
                ->only('id', 'name'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMembershipsRequest  $request
     * @param  \App\Models\Memberships  $memberships
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Memberships $membership)
    {
        $membership->update(
            Request::validate([
                'name' => ['required', 'max:50'],
                'price' => ['required', 'max:5|integer'],
                'trial_allowed' => ['required', 'boolean'],
                'period' => ['required', 'max:3'],
                'status' => ['required', 'boolean']
            ])
        );

        return Redirect::back()->with('success', 'Contact updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Memberships  $memberships
     * @return \Illuminate\Http\Response
     */
    public function destroy(Memberships $memberships)
    {
        //
    }
}
