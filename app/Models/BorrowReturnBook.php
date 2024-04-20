<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BorrowReturnBook extends Model
{
    use HasFactory;

    public function member() {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function book() {
        return $this->belongsTo(Book::class, 'book_id');
    }
}
