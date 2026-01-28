<?php

namespace App\Http\Controllers;

use App\Models\Allocation;
use App\Models\Offering;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total_investors' => User::where('role', 'investor')->count(),
            'total_offerings' => Offering::count(),
            'pending_allocations' => Allocation::where('status', 'pending')->count(),
        ];

        $recent_signups = User::where('role', 'investor')->latest()->take(5)->get();
        $offerings = Offering::latest()->take(5)->get();

        $startDate = now()->subMonths(5)->startOfMonth();
        $monthlySignupsCollection = User::where('role', 'investor')
            ->where('created_at', '>=', $startDate)
            ->orderBy('created_at')
            ->get()
            ->groupBy(function ($user) {
                return $user->created_at->format('Y-m');
            })
            ->map(function ($group) {
                return $group->count();
            })
            ->sortKeys();

        $months = collect();
        for ($i = 5; $i >= 0; $i--) {
            $months->push(now()->subMonths($i)->format('Y-m'));
        }

        $chartLabels = [];
        $chartData = [];

        foreach ($months as $month) {
            $chartLabels[] = \Carbon\Carbon::createFromFormat('Y-m', $month)->format('M Y');
            $chartData[] = $monthlySignupsCollection->get($month, 0);
        }

        $chart_data = [
            'labels' => $chartLabels,
            'data' => $chartData,
        ];

        // Chart Data: Allocation Status
        $allocation_stats = Allocation::selectRaw('count(id) as count, status')
            ->groupBy('status')
            ->get();

        $status_data = [
            'labels' => $allocation_stats->pluck('status')->map(fn ($s) => ucfirst($s))->toArray(),
            'data' => $allocation_stats->pluck('count')->toArray(),
        ];

        return view('admin.dashboard', compact('stats', 'recent_signups', 'offerings', 'chart_data', 'status_data'));
    }

    public function createOffering()
    {
        return view('admin.offerings.create');
    }

    public function storeOffering(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'target_amount' => 'required|numeric|min:0',
            'min_investment' => 'required|numeric|min:0',
            'status' => 'required|in:coming_soon,open,closed',
        ]);

        Offering::create($validated);

        return redirect()->route('admin.dashboard')->with('success', 'Offering created successfully!');
    }
}
