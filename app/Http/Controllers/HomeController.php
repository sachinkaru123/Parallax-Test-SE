<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Yoeunes\Toastr\Facades\Toastr;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    //home page
    public function index()
    {
        $books = Book::all();
        $categories =BookCategory::all();

        foreach ($books as $key => $book) {
           $book->category_name = $book->category->name;
        }

        return view('home')->with("books",$books)->with("categories",$categories);
    }

    public function registerView(){
        return view("auth.register");
    }
    
    //custome user createfunctionality
    public function createUser(Request $request){

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        try {
            DB::beginTransaction();

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'remember_token' => Str::random(10),
            ]);

            DB::commit();
            Toastr()->success('User Created');
            return redirect()->back();

        } catch (\Throwable $th) {
            Toastr()->error('Some Error Happend');
            Log::error($th);
        }
    }
}
