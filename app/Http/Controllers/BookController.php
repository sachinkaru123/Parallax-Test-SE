<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookController extends Controller
{
    public function create(){
        $categories =BookCategory::all();
        return view('pages.books.create')->with("categories",$categories);
    }
    public function store(Request $request){
        // dd($request);

        $request->validate([
            'book_name'=> 'required',
            'book_author'=>'required',
            'book_price'=>'required|numeric|min:0',
            'book_qtt'=>'required|integer|min:1',
            'category_id'=>'required|integer',
        ],[
            'book.required' => 'the book title is reqired',
            'book_author.required'  => 'The author name field cannot be empty',
            'book_price.numeric' =>'please Provide  a valid number for price',
            'book_qtt.integer' => 'Please provide a valid quantity',
            'category_id.integer' => 'Please provide a valid category',
        ]);


        try {
            DB::beginTransaction();

            $book = new Book();
            $book->title = $request->book_name;
            $book->author =$request->book_author;
            $book->price =$request->book_price;
            $book->stock = $request->book_qtt;
            $book->book_category_id= $request->category_id;
            $book->save();

            DB::commit();

            toastr()->success('Data has been saved successfully!');
            return redirect()->back();

        } catch (\Throwable $th) {
            DB::rollback();
            Log::error($th);
            toastr()->error($th->getMessage());
            return redirect()->back()->withMessage('error', 'Error in storing the data');
        }
        
    }

    public function find_books(Request $request)
    {
        $searchTerm = $request->get('term');

        $queryResults = Book::where('title', 'LIKE', '%' . $searchTerm . '%')->get();

        $results = [];
        foreach ($queryResults as $result) {
            $results[] = [
            'title' => $result->title,
            'value' => $result->title,
             'id' => $result->id,
             'author'=>$result->author,
             'book_category_id'=>$result->book_category_id,
             'stock'=>$result->stock,
             'price'=>$result->price,
             'created_at'=>$result->created_at,
             'category_name'=>$result->category->name,
            ];
        }

        return response()->json($results);
    }

    public function updateView($id){
        $book = Book::find($id);
        $categories =BookCategory::all();
        // dd($book);
       return(view('pages.books.update') -> with('book',$book)->with("categories",$categories)); 
    }

    public function update(Request $request , $id){
        $request->validate([
            'book_name'=> 'required',
            'book_author'=>'required',
            'book_price'=>'required|numeric|min:0',
            'book_qtt'=>'required|integer|min:1',
            'category_id'=>'required|integer',
        ],[
            'book.required' => 'the book title is reqired',
            'book_author.required'  => 'The author name field cannot be empty',
            'book_price.numeric' =>'please Provide  a valid number for price',
            'book_qtt.integer' => 'Please provide a valid quantity',
            'category_id.integer' => 'Please provide a valid category',
        ]);


        try {
            DB::beginTransaction();

            $book = Book::find( $id );
            $book->title = $request->book_name;
            $book->author =$request->book_author;
            $book->price =$request->book_price;
            $book->stock = $request->book_qtt;
            $book->book_category_id= $request->category_id;
            $book->update();

            DB::commit();

            toastr()->success('Book has been Update successfully!');
            return redirect()->route('home');

        } catch (\Throwable $th) {
            DB::rollback();
            Log::error($th);
            toastr()->error($th->getMessage());
            return redirect()->back()->withMessage('error', 'Error in storing the data');
        }
    }

    public function delete($id){
        // dd($id);

        $book = Book::find($id);
        $book->delete();
        toastr()->success('Book has been Deleted successfully!');
        return redirect()->route('home');
    }
}

