<?php

namespace App\Http\Controllers;

use App\Models\ItemVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemVariantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check permission - Using 'variant_view' from your seeder
        if (Auth::user()->can('variant_view')) {
            $variants = ItemVariant::orderBy('name')->get();
            return view('item-variants.index', compact('variants'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check permission - Using 'variant_add' from your seeder
        if (Auth::user()->can('variant_add')) {
            return view('item-variants.create');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check permission - Using 'variant_add' from your seeder
        if (Auth::user()->can('variant_add')) {
            $request->validate([
                'name' => 'required|string|max:255|unique:item_variants,name',
                'description' => 'nullable|string',
            ]);

            try {
                $variant = new ItemVariant();
                $variant->name = $request->name;
                $variant->description = $request->description;
                $variant->save();

                return redirect()->route('item-variants.index')
                    ->with('success', __('Item variant created successfully.'));
            } catch (\Exception $e) {
                return redirect()->back()
                    ->with('error', __('Error creating item variant: ') . $e->getMessage());
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ItemVariant $itemVariant)
    {
        // Check permission - Using 'variant_view' from your seeder
        if (Auth::user()->can('variant_view')) {
            return view('item-variants.show', compact('itemVariant'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ItemVariant $itemVariant)
    {
        // Check permission - Using 'variant_edit' from your seeder
        if (Auth::user()->can('variant_edit')) {
            return view('item-variants.edit', compact('itemVariant'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ItemVariant $itemVariant)
    {
        // Check permission - Using 'variant_edit' from your seeder
        if (Auth::user()->can('variant_edit')) {
            $request->validate([
                'name' => 'required|string|max:255|unique:item_variants,name,' . $itemVariant->id,
                'description' => 'nullable|string',
            ]);

            try {
                $itemVariant->name = $request->name;
                $itemVariant->description = $request->description;
                $itemVariant->save();

                return redirect()->route('item-variants.index')
                    ->with('success', __('Item variant updated successfully.'));
            } catch (\Exception $e) {
                return redirect()->back()
                    ->with('error', __('Error updating item variant: ') . $e->getMessage());
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ItemVariant $itemVariant)
    {
        // Check permission - Using 'variant_delete' from your seeder
        if (Auth::user()->can('variant_delete')) {
            try {
                $itemVariant->delete();
                return redirect()->route('item-variants.index')
                    ->with('success', __('Item variant deleted successfully.'));
            } catch (\Exception $e) {
                return redirect()->back()
                    ->with('error', __('Error deleting item variant: ') . $e->getMessage());
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}