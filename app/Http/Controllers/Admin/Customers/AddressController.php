<?php

namespace App\Http\Controllers\Admin\Customers;

use App\Http\Controllers\Controller;
use App\Models\Customers\Address;
use App\Models\User;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index(Request $request)
    {
        $query = Address::with('user');

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('city', 'like', "%{$search}%")
                    ->orWhere('zip', 'like', "%{$search}%")
                    ->orWhereHas('user', fn ($u) => $u->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%"));
            });
        }
        if ($type = $request->get('type')) {
            $query->where('type', $type);
        }
        if ($country = $request->get('country')) {
            $query->where('country', $country);
        }

        $addresses = $query->latest()->paginate(15)->withQueryString();

        $stats = [
            'total' => Address::count(),
            'default_shipping' => Address::where('type', 'shipping')->where('is_default', true)->count(),
            'default_billing' => Address::where('type', 'billing')->where('is_default', true)->count(),
            'countries' => Address::select('country')->distinct()->count(),
        ];

        $customers = User::customers()->orderBy('first_name')->get();
        $countries = Address::distinct()->orderBy('country')->pluck('country');

        return view('admin.customers.addresses.index', compact('addresses', 'stats', 'customers', 'countries'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        $address = Address::create($data);

        if ($request->boolean('is_default')) {
            $address->makeDefault();
        }

        return back()->with('success', 'Address added.');
    }

    public function update(Request $request, Address $address)
    {
        $data = $this->validated($request);
        $address->update($data);

        if ($request->boolean('is_default')) {
            $address->makeDefault();
        }

        return back()->with('success', 'Address updated.');
    }

    public function destroy(Address $address)
    {
        $address->delete();

        return back()->with('success', 'Address deleted.');
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'user_id' => 'required|exists:users,id',
            'type' => 'required|in:shipping,billing',
            'recipient_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'address_line1' => 'required|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'nullable|string|max:255',
            'zip' => 'nullable|string|max:255',
            'country' => 'required|string|max:255',
        ]);
    }
}
