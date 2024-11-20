<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Item::paginate(10); // Pagination

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'description' => 'nullable|string',
        // ]);

        // return Item::create($request->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'name' => 'required|string|max:255',     // Name is required and must be a string with a max length of 255
            'description' => 'required', // Email must be unique in the 'data' table
        ]);

        // Create a new record in the database
        $data = Item::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
        ]);

        // Return a success response
        return response()->json([
            'success' => true,
            'message' => 'Data saved successfully!',
            'data' => $data,
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        $data =  Item::find($item);
        // return $data->values();
        return response()->json($item, 200);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
        ]);

        $data = $item->update($validated);

        // Return a success response
        return response()->json(['success' => true, 'message' => 'Data saved successfully!'], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        $data = $item->delete();
        return response()->json(['success' => true, 'message' => 'Data deleted successfully!'], 201);

    }

    public function search($query)
    {
        return Item::where('name', 'like', "%$query%")->paginate(10);
    }
}
