<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductsRequest;
use App\Http\Requests\UpdateProductsRequest;
use App\Models\Customers;
use App\Models\Products;
use App\Models\Types;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {

        return Inertia::render('Products/Index', [
            'filters' => Request::all('search', 'trashed'),
            'products' => Products::orderByName()
                ->filter(Request::only('search', 'trashed'))
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($product) => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'type_name' => $product->type_name,
                    'status' => $product->status,
                    'parent_name' => $product->parent_name,
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
        return Inertia::render('Products/Create', [
            'types' => Types::where('resource_name', 'Products')->get()->map->only('id', 'name'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductsRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $product = Auth::user()->account->products()->create(
            Request::validate([
                'name' => ['required', 'max:100'],
                'description' => ['nullable', 'max:150'],
                'types_id' => ['required', 'exists:types,id'],
                'status'    =>  ['required', 'max:20', 'string']
            ])
        );

        return Redirect('products/'.$product->id . '/edit')->with('success', 'Product created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function show(Products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Products  $products
     * @return \Inertia\Response
     */
    public function edit(Products $product)
    {
        return Inertia::render('Products/Edit', [
            'product' => [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'types_id' => $product->types_id,
                'status' => $product->status,
                'parent_id' => $product->parent ? $product->parent->id : null,
            ],
            'types' =>  Types::orderBy('name')->get()->map->only('id', 'name')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductsRequest  $request
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Products $product)
    {
        $product->update(
            Request::validate([
                'name' => ['required', 'max:50'],
                'description' => ['nullable', 'max:150'],
                'types_id' => ['required', 'exists:types,id'],
                'status'    =>  ['required', 'max:20', 'string']
            ])
        );

        return Redirect::back()->with('success', 'Product updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy(Products $products)
    {
        //
    }
}
