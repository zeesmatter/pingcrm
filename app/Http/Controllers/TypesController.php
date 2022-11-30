<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTypesRequest;
use App\Http\Requests\UpdateTypesRequest;
use App\Models\Types;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class TypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('Types/Index', [
            'filters' => Request::all('search', 'trashed'),
            'types' => Types::orderBy('name')
                ->filter(Request::only('search', 'trashed'))
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($type) => [
                    'id' => $type->id,
                    'name' => $type->name,
                    'resource_name' => $type->resource_name,
                    'parent_name' => $type->parent_name
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
        return Inertia::render('Types/Create', [
            'types' =>  Types::orderBy('name')
            ->get()
            ->map
            ->only('id', 'name')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTypesRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        Types::create(
            Request::validate([
                'name' => ['required', 'max:100'],
                'resource_name' => ['required', 'max:50'],
                'parent_id' => ['nullable', 'exists:types,id'],
            ])
        );

        return Redirect::route('types')->with('success', 'Type created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Types  $types
     * @return \Illuminate\Http\Response
     */
    public function show(Types $types)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Types  $types
     * @return \Inertia\Response
     */
    public function edit(Types $type)
    {
        return Inertia::render('Types/Edit', [
            'type' => [
                'id' => $type->id,
                'name' => $type->name,
                'resource_name' => $type->resource_name,
                'parent' => $type->parent ? $type->parent->id : null,
            ],
            'types' =>  Types::orderBy('name')->where('id', '!=', $type->id)->get()->map->only('id', 'name')

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTypesRequest  $request
     * @param  \App\Models\Types  $types
     * @return \Illuminate\Http\Response
     */
    public function update(Types $type)
    {
        $type->update(
            Request::validate([
                'name' => ['required', 'max:100'],
                'resource_name' => ['required', 'max:50'],
                'parent_id' => ['nullable', 'exists:types,id'],
            ])
        );

        return Redirect::route('types')->with('success', 'Type created.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Types  $types
     * @return \Illuminate\Http\Response
     */
    public function destroy(Types $types)
    {
        //
    }
}
