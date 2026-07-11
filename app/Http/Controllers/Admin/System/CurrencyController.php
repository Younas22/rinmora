<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CurrencyController extends Controller
{
    public function store(Request $request)
    {
        $data = $this->validated($request);

        $data['sort_order'] = (Currency::max('sort_order') ?? 0) + 1;

        Currency::create($data);

        return redirect()->route('admin.system.settings.index', ['tab' => 'currency'])->with('success', 'Currency added.');
    }

    public function update(Request $request, Currency $currency)
    {
        $data = $this->validated($request, $currency);

        $currency->update($data);
        Currency::forgetActiveCache();

        return redirect()->route('admin.system.settings.index', ['tab' => 'currency'])->with('success', 'Currency updated.');
    }

    public function destroy(Currency $currency)
    {
        if ($currency->is_active) {
            return back()->with('error', 'Cannot delete the active currency. Activate a different one first.');
        }

        if ($currency->is_base) {
            return back()->with('error', 'Cannot delete the base currency — all prices are stored in it.');
        }

        $currency->delete();

        return redirect()->route('admin.system.settings.index', ['tab' => 'currency'])->with('success', 'Currency deleted.');
    }

    public function activate(Currency $currency)
    {
        $currency->activate();

        return redirect()->route('admin.system.settings.index', ['tab' => 'currency'])->with('success', $currency->code.' is now the active currency.');
    }

    protected function validated(Request $request, ?Currency $currency = null): array
    {
        return $request->validate([
            'code' => ['required', 'string', 'size:3', 'uppercase', Rule::unique('currencies', 'code')->ignore($currency)],
            'name' => 'required|string|max:255',
            'symbol' => 'required|string|max:10',
            'symbol_position' => 'required|in:before,after',
            'decimal_places' => 'required|integer|min:0|max:4',
            'exchange_rate' => 'required|numeric|min:0.000001',
        ]);
    }
}
