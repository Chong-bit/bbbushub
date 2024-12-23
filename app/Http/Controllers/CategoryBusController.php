<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bus;

class CategoryBusController extends Controller
{
    public function index()
    {
        $buses = Bus::all(); // Fetch all buses from the database
        return view('admin.bus', compact('buses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'plate' => 'required|unique:buses,plate',
        ]);

        Bus::create(['plate' => $request->plate]); // Create a new bus record

        return redirect()->route('admin.bus')->with('success', 'Bus added successfully!');
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'plate' => 'required|unique:buses,plate,' . $id,
        ]);

        $bus = Bus::findOrFail($id); // Find the bus by ID
        $bus->update($validatedData); // Update the bus record

        return response()->json([
            'success' => true,
            'message' => 'Bus updated successfully!',
        ], 200); // Ensure 200 status code
    }

    public function destroy($id)
    {
        $bus = Bus::findOrFail($id); // Find the bus by ID
        $bus->delete(); // Delete the bus record

        return redirect()->route('admin.bus')->with('success', 'Bus deleted successfully!');
    }
}
