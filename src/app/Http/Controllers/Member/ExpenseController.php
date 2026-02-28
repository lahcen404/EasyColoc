<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ExpenseController extends Controller
{
    // show monthly statistics and history
    public function index(Request $request): View
    {
        $membership = auth()->user()->memberships()
            ->whereNull('left_at')
            ->firstOrFail();

        $month = $request->get('month', date('m'));
        $year = $request->get('year', date('Y'));

        $expenses = $membership->colocation->expenses()
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->with(['payer.user', 'category'])
            ->latest('date')
            ->paginate(15);

        return view('expenses.index', compact('expenses', 'month', 'year', 'membership'));
    }

    // show form to creaate a new expense
    public function create(): View
    {
        $categories = Category::all();


        $membership = auth()->user()->memberships()
            ->whereNull('left_at')
            ->first();

        if (!$membership) {
            return redirect()->route('dashboard')->with('error', 'Join a house first.');
        }

        return view('expenses.create', compact('categories', 'membership'));
    }

   // create a new expense
    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'category_id' => 'required|exists:categories,id',
            'date' => 'required|date',
        ]);


        $membership = auth()->user()->memberships()
            ->whereNull('left_at')
            ->first();


        Expense::create([
            'title' => $request->title,
            'amount' => $request->amount,
            'date' => $request->date,
            'payer_member_id' => $membership->id,
            'colocation_id' => $membership->colocation_id,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('dashboard')->with('success', 'Expense added successfully.');
    }
}
