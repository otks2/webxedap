<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(request('search')) {
            return $this->search(request());
        }
        $books = Book::all();
        return view('index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('create');
    }
    public function store(Request $request)
    {
        $storeData = $request->validate([
            'product_name' => 'required|max:255',
            'product_description' => 'required|max:255',
            'product_author' => 'required|max:255',
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
            $books = Book::create($storeData);
        }
        return redirect('/books')->with('completed', 'News has been saved!');
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
        $books = Book::findOrFail($id);
        return view('update', compact('books'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $updateData = $request->validate([
            'product_name' => 'required|max:255',
            'product_description' => 'required|max:255',
            'product_author' => 'required|max:255',
            'product_price' => 'required|max:255',
        ]);

        Book::whereId($id)->update($updateData);

        return redirect('/books')->with('completed', 'This product has been saved!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $news = Book::findOrFail($id);
        $news->delete();
        return redirect('/books')->with('completed', 'This product has been deleted');
    }
    public function search(Request $request)
    {
        $search = strtolower($request->input('search'));

        $books = Book::where('product_name', 'like', "%$search%")->get();
        return view('index', compact('books'));
    }
    public function find($id) {
        $new = DB::table('books')
            ->where('id', $id)
            ->first();
        return response()->json($new);
    }
}
