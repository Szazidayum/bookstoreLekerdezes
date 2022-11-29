<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    public function index(){
        $books =  Book::all();
        return $books;
    }
    
    public function show($id)
    {
        $book = Book::find($id);
        return $book;
    }
    public function destroy($id)
    {
        Book::find($id)->delete();
    }
    public function store(Request $request)
    {
        $Book = new Book();
        $Book->author = $request->author;
        $Book->title = $request->title;
        $Book->save();
    }

    public function update(Request $request, $id)
    {
        $Book = Book::find($id);
        $Book->author = $request->author;
        $Book->title = $request->title;
    }

    public function bookCopies($title)
    {	
        $copies = Book::with('copy_c')->where('title','=', $title)->get();
        return $copies;
    }

    //2. Csoportosítsd szerzőnként a könyveket (nem példányokat) a szerzők ABC szerinti növekvő sorrendjében!
    public function szerzokABC()
    {
        $konyvek = DB::table('books as b')
        ->select('b.book_id', 'b.author', 'b.title')
        ->orderBy('b.author')
        ->get();
        return $konyvek;
    }

    //3. Határozd meg a könyvtár nyilvántartásában legalább 2 könyvvel rendelkező szerzőket!
    public function moreThan2()
    {
        $konyvek = DB::table('books as b')
        ->selectRaw('count(title),b.author')
        ->groupBy('b.author')
        ->having('count(title)', '>', 1)
        ->get();
        return $konyvek;
    }

    //4. A B betűvel kezdődő szerzőket add meg!
    public function szerzokB($text)
    {
        $konyvek= DB::table('books')
        ->select('author')
        ->whereRaw("author like \"${text}%\"")
        ->get();

        return $konyvek;
    }

    
}
