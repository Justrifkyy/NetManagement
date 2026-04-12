<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::with(['user', 'subscriptions'])->paginate(15);
        return view('admin.customers.index', compact('customers'));
    }

    public function show(Customer $customer)
    {
        $customer->load(['user', 'subscriptions.package', 'lead', 'tickets']);
        return view('admin.customers.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'phone_number' => 'required|string',
            'address_installation' => 'required|string',
            'coordinates' => 'nullable|string',
        ]);

        $customer->update($validated);

        return redirect()->route('admin.customers.show', $customer)->with('success', 'Data pelanggan berhasil diperbarui');
    }

    public function isolate(Request $request, Customer $customer)
    {
        $reason = $request->validate(['reason' => 'required|string'])['reason'];

        Subscription::where('customer_id', $customer->id)
            ->update(['status' => 'isolated']);

        $customer->update(['is_isolated' => true]);

        // Log activity
        \App\Models\AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'isolate_customer',
            'description' => "Pelanggan {$customer->id} diisolir. Alasan: {$reason}",
            'details' => ['reason' => $reason],
        ]);

        return redirect()->back()->with('success', 'Pelanggan berhasil diisolir');
    }

    public function activate(Customer $customer)
    {
        Subscription::where('customer_id', $customer->id)
            ->update(['status' => 'active']);

        $customer->update(['is_isolated' => false]);

        \App\Models\AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'activate_customer',
            'description' => "Pelanggan {$customer->id} diaktifkan kembali",
        ]);

        return redirect()->back()->with('success', 'Pelanggan berhasil diaktifkan');
    }

    public function search(Request $request)
    {
        $query = $request->validate(['q' => 'required|string'])['q'];

        $customers = Customer::with(['user'])
            ->where('customer_code', 'like', "%{$query}%")
            ->orWhereHas('user', function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%");
            })
            ->get();

        return response()->json($customers);
    }
}
