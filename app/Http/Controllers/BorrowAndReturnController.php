<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BorrowReturnBook;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BorrowAndReturnController extends Controller
{
    public function borrowView()
    {
        $members = Member::all();

        return view('pages.borrowReturn.borrow')->with(compact('members'));
    }

    public function storeBorrow(Request $request)
    {

        try {
            $member_id = $request->input('memberId');


            $books = $request->input('bookList');

            $today = Carbon::today();
            DB::beginTransaction();

            foreach ($books as $key => $value) {
                $book = new BorrowReturnBook();
                $book->member_id = $member_id;
                $book->book_id = $value['book_id'];
                $book->borrow_date = $today;
                $book->save();

                $stord_book = Book::find($value['book_id']);
                $stord_book->stock = $stord_book->stock - 1;
                $stord_book->save();
            }
            DB::commit();

            return response()->json(['success' => true]);
        } catch (\Throwable $th) {
            log::error($th);
            DB::rollback();
            return response()->json(['success' => false, 'error' => $th->getMessage()], 500);
        }
    }

    public function returnView()
    {
        $borrowList = BorrowReturnBook::paginate(10);

        return view("pages.borrowReturn.return")->with("borrows", $borrowList);
    }

    public function confirmReturn(Request $request)
    {
        try {
            $rec_id = $request->input('rec_id');

            DB::beginTransaction();

            $borrowRec = BorrowReturnBook::find($rec_id);
            $book_id = $borrowRec->book_id;
            $borrowRec->status = "Complete";
            $borrowRec->return_date = Carbon::today();
            $borrowRec->update();

            $book = Book::find($book_id);
            $book->stock = $book->stock +  1;
            $book->update();
            DB::commit();

            return response()->json(['success' => true]);

        } catch (\Throwable $th) {
            log::error($th);
            DB::rollback();
            return response()->json(['success' => false, 'error' => $th->getMessage()], 500);
        }
    }
}
