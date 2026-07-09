<?php

namespace App\Http\Controllers\Admin\Catalog;

use App\Http\Controllers\Controller;
use App\Models\Catalog\Attribute;
use App\Models\Catalog\AttributeValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttributeController extends Controller
{
    public function index(Request $request)
    {
        $attributes = Attribute::with('values')->orderBy('name')->get();
        $editing = $request->filled('edit') ? Attribute::with('values')->find($request->get('edit')) : null;

        return view('admin.catalog.attributes.index', compact('attributes', 'editing'));
    }

    public function store(Request $request)
    {
        $this->save($request);

        return back()->with('success', 'Attribute created.');
    }

    public function update(Request $request, Attribute $attribute)
    {
        $this->save($request, $attribute);

        return back()->with('success', 'Attribute updated.');
    }

    protected function save(Request $request, ?Attribute $attribute = null): Attribute
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'display_type' => 'required|in:dropdown,color_swatch,button,text',
            'use_for_variants' => 'nullable|boolean',
            'values' => 'array',
            'values.*' => 'string|max:100',
        ]);

        return DB::transaction(function () use ($data, $request, $attribute) {
            $attribute = $attribute
                ? tap($attribute)->update([
                    'name' => $data['name'],
                    'display_type' => $data['display_type'],
                    'use_for_variants' => $request->boolean('use_for_variants', true),
                ])
                : Attribute::create([
                    'name' => $data['name'],
                    'display_type' => $data['display_type'],
                    'use_for_variants' => $request->boolean('use_for_variants', true),
                ]);

            $existingValues = collect($data['values'] ?? []);
            $attribute->values()->whereNotIn('value', $existingValues)->delete();

            foreach ($existingValues as $i => $value) {
                AttributeValue::firstOrCreate(
                    ['attribute_id' => $attribute->id, 'value' => $value],
                    ['sort_order' => $i]
                );
            }

            return $attribute;
        });
    }

    public function destroy(Attribute $attribute)
    {
        $attribute->delete();

        return back()->with('success', 'Attribute deleted.');
    }

    public function destroyValue(Attribute $attribute, AttributeValue $value)
    {
        if ($value->attribute_id !== $attribute->id) {
            abort(404);
        }

        $value->delete();

        return back()->with('success', 'Value removed.');
    }
}
