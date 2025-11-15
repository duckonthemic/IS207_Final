<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SpecDefinition;
use App\Models\ComponentType;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class SpecDefinitionController extends Controller
{
    /**
     * Display a listing of spec definitions for a component type.
     */
    public function index(Request $request): View
    {
        $componentTypeId = $request->input('component_type_id');
        $componentTypes = ComponentType::ordered()->get();
        
        $query = SpecDefinition::with('componentType');
        
        if ($componentTypeId) {
            $query->where('component_type_id', $componentTypeId);
        }
        
        $specDefinitions = $query->ordered()->paginate(20);
        
        return view('admin.spec-definitions.index', compact('specDefinitions', 'componentTypes', 'componentTypeId'));
    }

    /**
     * Show the form for creating a new spec definition.
     */
    public function create(Request $request): View
    {
        $componentTypes = ComponentType::ordered()->get();
        $selectedComponentTypeId = $request->input('component_type_id');
        
        return view('admin.spec-definitions.create', compact('componentTypes', 'selectedComponentTypeId'));
    }

    /**
     * Store a newly created spec definition in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'component_type_id' => 'nullable|exists:component_types,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:spec_definitions,code',
            'unit' => 'nullable|string|max:50',
            'input_type' => 'required|in:text,number,select,textarea',
            'options' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'is_required' => 'boolean',
            'is_filterable' => 'boolean',
        ]);

        // Xử lý options nếu là JSON string
        if (!empty($validated['options'])) {
            $validated['options'] = json_decode($validated['options'], true) ?? [];
        }

        // Auto-generate code nếu trống
        if (empty($validated['code'])) {
            $validated['code'] = Str::slug($validated['name'], '_');
        }

        SpecDefinition::create($validated);

        return redirect()
            ->route('admin.spec-definitions.index', ['component_type_id' => $validated['component_type_id']])
            ->with('success', 'Thông số kỹ thuật đã được tạo thành công!');
    }

    /**
     * Show the form for editing the specified spec definition.
     */
    public function edit(SpecDefinition $specDefinition): View
    {
        $componentTypes = ComponentType::ordered()->get();
        
        return view('admin.spec-definitions.edit', compact('specDefinition', 'componentTypes'));
    }

    /**
     * Update the specified spec definition in storage.
     */
    public function update(Request $request, SpecDefinition $specDefinition): RedirectResponse
    {
        $validated = $request->validate([
            'component_type_id' => 'nullable|exists:component_types,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:spec_definitions,code,' . $specDefinition->id,
            'unit' => 'nullable|string|max:50',
            'input_type' => 'required|in:text,number,select,textarea',
            'options' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'is_required' => 'boolean',
            'is_filterable' => 'boolean',
        ]);

        // Xử lý options nếu là JSON string
        if (!empty($validated['options'])) {
            $validated['options'] = json_decode($validated['options'], true) ?? [];
        }

        $specDefinition->update($validated);

        return redirect()
            ->route('admin.spec-definitions.index', ['component_type_id' => $validated['component_type_id']])
            ->with('success', 'Thông số kỹ thuật đã được cập nhật!');
    }

    /**
     * Remove the specified spec definition from storage.
     */
    public function destroy(SpecDefinition $specDefinition): RedirectResponse
    {
        $componentTypeId = $specDefinition->component_type_id;
        $specDefinition->delete();

        return redirect()
            ->route('admin.spec-definitions.index', ['component_type_id' => $componentTypeId])
            ->with('success', 'Thông số kỹ thuật đã được xóa!');
    }
}
