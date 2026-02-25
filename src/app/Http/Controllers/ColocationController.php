<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\Membership;
use App\Enums\ColocationStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * This controller manages the lifecycle of a Colocation.
 * It handles the transition from "Simple User" to "House Member".
 */
class ColocationController extends Controller
{
    // view
    public function create(): View
    {
        return view('colocations.create');
    }

   // Create colcoation
    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            'name' => 'required|string|max:100|min:3',
        ]);

         try {
            DB::beginTransaction();


            $coloc = Colocation::create([
                'name' => $request->name,
                'status' => ColocationStatus::ACTIVE,
            ]);


            Membership::create([
                'user_id' => auth()->id(),
                'colocation_id' => $coloc->id,
                'is_owner' => true,
                'joined_at' => now(),
            ]);

            DB::commit();

             return redirect()->route('dashboard')->with('success', 'House Createed successfully!!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error in Creating !');
        }
    }
}
