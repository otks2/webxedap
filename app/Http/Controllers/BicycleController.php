<?php

namespace App\Http\Controllers;

use App\Models\Bicycle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BicycleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(request('search')) {
            return $this->search(request());
        }
        $bicycles = Bicycle::all();
        return view('index', compact('bicycles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     */
//    public function store(Request $request)
//    {
//        $storeData = $request->validate([
//            'product_name' => 'required|max:255',
//            'product_description' => 'required|max:255',
//            'product_price' => 'required|max:255',
//            'product_image_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:4096',
//        ]);
//        if ($request->hasFile('product_image_url')) {
//            $image = $request->file('product_image_url');
//            $imageName = time() . '.' . $image->getClientOriginalExtension();
//            $image->storeAs('public/images', $imageName);
//            $storeData['product_image_url'] = $imageName;
//        }
//        $news = Bicycle::create($storeData);
//        return redirect('/Bicycles')->with('completed', 'News has been saved!');
//    }
    public function store(Request $request)
    {
        $storeData = $request->validate([
            'product_name' => 'required|max:255',
            'product_description' => 'required|max:255',
            'product_price' => 'required|max:255',
            'product_image_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('product_image_url')) {
            $image = $request->file('product_image_url');

            // Validate file extension and MIME type
            $validExtensions = ['jpeg', 'png', 'jpg', 'gif'];
            $validMimeTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];

            if (!in_array($image->getClientOriginalExtension(), $validExtensions) || !in_array($image->getMimeType(), $validMimeTypes)) {
                // Invalid file type
                return redirect()->back()->withErrors(['product_image_url' => 'The product image must be a file of type: jpeg, png, jpg, gif.']);
            }

            // Store the file
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $imageName);
            $storeData['product_image_url'] = $imageName;
            $bicycles = Bicycle::create($storeData);
        }
        return redirect('/Bicycles')->with('completed', 'News has been saved!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $bicycles = Bicycle::findOrFail($id);
        return view('update', compact('bicycles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $updateData = $request->validate([
            'product_name' => 'required|max:255',
            'product_description' => 'required|max:255',
            'product_price' => 'required|max:255',
        ]);

        Bicycle::whereId($id)->update($updateData);

        return redirect('/Bicycles')->with('completed', 'This product has been saved!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $news = Bicycle::findOrFail($id);
        $news->delete();
        return redirect('/Bicycles')->with('completed', 'This product has been deleted');
    }
    public function search(Request $request)
    {
        $search = strtolower($request->input('search'));

        $bicycles = Bicycle::where('product_name', 'like', "%$search%")->get();
        return view('index', compact('bicycles'));
    }
    public function find($id) {
        $new = DB::table('Bicycles')
            ->where('id', $id)
            ->first();
        return response()->json($new);
    }
}
