<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AddressResource;
use App\Models\Customers\Address;
use Illuminate\Http\Request;

class StorefrontAddressController extends Controller
{
    public function index(Request $request)
    {
        $addresses = Address::where('user_id', $request->user()->id)
            ->orderByDesc('is_default')
            ->orderByDesc('created_at')
            ->get();

        return AddressResource::collection($addresses);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        $address = $request->user()->addresses()->create($data);

        if ($request->boolean('is_default')) {
            $address->makeDefault();
        }

        return new AddressResource($address->fresh());
    }

    public function update(Request $request, Address $address)
    {
        $this->authorizeOwnership($request, $address);

        $data = $this->validated($request);

        $address->update($data);

        if ($request->boolean('is_default')) {
            $address->makeDefault();
        }

        return new AddressResource($address->fresh());
    }

    public function destroy(Request $request, Address $address)
    {
        $this->authorizeOwnership($request, $address);

        $address->delete();

        return response()->json(['message' => 'Address deleted.']);
    }

    protected function authorizeOwnership(Request $request, Address $address): void
    {
        if ($address->user_id !== $request->user()->id) {
            abort(404);
        }
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'type' => 'required|in:shipping,billing',
            'recipient_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:30',
            'address_line1' => 'required|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'nullable|string|max:255',
            'zip' => 'nullable|string|max:255',
            'country' => 'required|string|max:255',
        ]);
    }
}
