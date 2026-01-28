<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offering;
use Illuminate\Http\Request;

class OfferingController extends Controller
{
    public function index()
    {
        $offerings = Offering::latest()->paginate(10);

        return view('admin.offerings.index', compact('offerings'));
    }

    public function create()
    {
        return view('admin.offerings.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'min_investment' => 'required|numeric|min:0',
            'total_units' => 'nullable|numeric|min:0',
            'location' => 'nullable|string|max:255',
            'status' => 'required|in:coming_soon,open,closed',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        Offering::create($validated);

        return redirect()->route('admin.offerings.index')->with('success', 'Offering created successfully!');
    }

    public function edit(Offering $offering)
    {
        return view('admin.offerings.edit', compact('offering'));
    }

    public function update(Request $request, Offering $offering)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'min_investment' => 'required|numeric|min:0',
            'total_units' => 'nullable|numeric|min:0',
            'location' => 'nullable|string|max:255',
            'status' => 'required|in:coming_soon,open,closed',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $offering->update($validated);

        return redirect()->route('admin.offerings.index')->with('success', 'Offering updated successfully!');
    }

    public function destroy(Offering $offering)
    {
        // Optional: Check if offering has active allocations/investments
        if ($offering->allocations()->where('status', 'active')->exists()) {
            return back()->with('error', 'Cannot delete offering with active investments.');
        }

        $offering->delete();

        return redirect()->route('admin.offerings.index')->with('success', 'Offering deleted successfully.');
    }
}
