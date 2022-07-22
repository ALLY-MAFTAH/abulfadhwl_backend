<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Request as REQ;

class BookController extends Controller
{
    // Get all books
    public function getAllBooks()
    {
        $books = Book::all();
        if(REQ::is('api/*'))
        return response()->json([
            'books' => $books
        ], 200);
        return view('turaath/documents/all_books')->with('books',$books);
    }

    // Get a single book
    public function getSingleBook($bookId)
    {
        $book = Book::find($bookId);
        if (!$book) {
            return response()->json([
                'error' => "Book not found"
            ], 404);
        }
        if(REQ::is('api/*'))
        return response()->json([
            'book' => $book
        ], 200);
        return view('turaath/documents/book')->with('book', $book);
    }

    // Post book
    public function postBook(Request $request)
    {
        $this->path = null;

        // Validate if the request sent contains this parameters
        $validator = Validator::make($request->all(), [
            'file' => 'required',
            'cover' => 'required',
            'title' => 'required',
            'edition' => 'required',
            'pub_year' => 'required',
            'description' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
                'status' => false
            ], 404);
        }

        if ($request->hasFile('file')) {
            $this->song_path = $request->file('file')->storeAs(config('app.name').'/VITABU/' ,
            $request->title . '.' . $request->file('file')->getClientOriginalExtension(),
            'public');
        } else return response()->json([
            'error' => 'Add a book file'
        ], 404);

        if ($request->hasFile('cover')) {
            $this->cover_path = $request->file('cover')->store('books');
        } else return response()->json([
            'error' => 'Add a book cover'
        ], 404);

        $book = new Book();
        $book->title = $request->input('title');
        $book->author = 'Sheikh Abul Fadhwl Kassim Mafuta حفظه الله ورعاه';
        $book->edition = $request->input('edition');
        $book->pub_year = $request->input('pub_year');
        $book->description = $request->input('description');
        $book->file = $this->file_path;
        $book->cover = $this->cover_path;

        $book->save();

        return back()->with('success','Book added successfully');
    }

    // Edit book
    public function putBook(Request $request, $bookId)
    {

        $book = Book::find($bookId);
        if (!$book) {
            return response()->json([
                'error' => "Book not found"
            ], 404);
        }

        // Validate if the request sent contains this parameters
        // $validator = Validator::make($request->all(), [
        //     'title' => 'required',
        //     'edition' => 'required',
        //     'pub_year' => 'required',
        //     'description' => 'required',

        // ]);

        // // If validator fails
        // if ($validator->fails()) {
        //     if(REQ::is('api/*'))
        //     return response()->json([
        //         'error' => $validator->errors(),
        //     ], 404);
        //     return back()->withInput()->withErrors($validator);

        $book->update([
            'title' => $request->input('title'),
            'edition' => $request->input('edition'),
            'pub_year' => $request->input('pub_year'),
            'description' => $request->input('description')
        ]);

        $book->save();
            if(REQ::is('api/*'))
        return response()->json([
            'book' => $book
        ], 206);
        return back()->with('success','Book edited successfully');
    }

    // Delete book
    public function deleteBook($bookId)
    {
        $book = Book::find($bookId);
        if (!$book) {
            return response()->json([
                'error' => 'Book does not exist'
            ], 204);
        }

        $book->delete();

        if(REQ::is('api/*'))
        return response()->json([
            'book' => 'Book deleted successfully'
        ], 200);
        return back()->with('success', 'Book deleted successfully');
    }

    public function viewBookFile($bookId)
    {
        $book = Book::find($bookId);
        if (!$book) {
            return response()->json([
                'error' => 'Book not exists'
            ], 404);
        }
        $pathToFile = storage_path('/app/public/' . $book->file);

        return response()->download($pathToFile);
    }

    public function viewBookCover($bookId)
    {
        $book = Book::find($bookId);
        if (!$book) {
            return response()->json([
                'error' => 'Book not found'
            ], 404);
        }

        $pathToFile = storage_path('/app/public/' . $book->cover);
        return response()->download($pathToFile);
    }
}
