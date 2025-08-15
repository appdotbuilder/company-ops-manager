<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWarehouseItemRequest;
use App\Http\Requests\UpdateWarehouseItemRequest;
use App\Models\WarehouseItem;
use Inertia\Inertia;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = WarehouseItem::latest()->paginate(10);
        
        return Inertia::render('warehouse/index', [
            'items' => $items,
            'lowStockCount' => WarehouseItem::lowStock()->active()->count()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('warehouse/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWarehouseItemRequest $request)
    {
        $item = WarehouseItem::create($request->validated());

        return redirect()->route('warehouse.show', $item)
            ->with('success', 'Warehouse item created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(WarehouseItem $warehouse)
    {
        return Inertia::render('warehouse/show', [
            'item' => $warehouse
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WarehouseItem $warehouse)
    {
        return Inertia::render('warehouse/edit', [
            'item' => $warehouse
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWarehouseItemRequest $request, WarehouseItem $warehouse)
    {
        $warehouse->update($request->validated());

        return redirect()->route('warehouse.show', $warehouse)
            ->with('success', 'Warehouse item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WarehouseItem $warehouse)
    {
        $warehouse->delete();

        return redirect()->route('warehouse.index')
            ->with('success', 'Warehouse item deleted successfully.');
    }
}