<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    // list categories
    public function index(): View
    {
        $membership = Auth::user()->memberships()->where('is_owner', true)->whereNull('left_at')->firstOrFail();
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    // store new category
    public function store(Request $request): RedirectResponse
    {
        $this->ensureIsOwner();

        $request->validate([
            'name' => 'required|string|max:50|unique:categories,name',
        ]);

        Category::create([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'New category registered in the registry.');
    }

    // show edit form
    public function edit(Category $category): View
    {
        $this->ensureIsOwner();
        return view('categories.edit', compact('category'));
    }

    // update category
    public function update(Request $request, Category $category): RedirectResponse
    {
        $this->ensureIsOwner();

        $request->validate([
            'name' => 'required|string|max:50|unique:categories,name,' . $category->id,
        ]);

        $category->update([
            'name' => $request->name
        ]);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    // delete category
    public function destroy(Category $category): RedirectResponse
    {
        $this->ensureIsOwner();

        if ($category->expenses()->count() > 0) {
            return redirect()->back()->with('error', 'Integrity Error: Cannot delete category containing active expenses.');
        }

        $category->delete();
        return redirect()->back()->with('success', 'Category removed from house options.');
    }

    // verify owner status
    private function ensureIsOwner()
    {
        Auth::user()->memberships()
            ->where('is_owner', true)
            ->whereNull('left_at')
            ->firstOrFail();
    }
}
