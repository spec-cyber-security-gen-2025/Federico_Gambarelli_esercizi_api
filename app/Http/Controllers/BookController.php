<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();
        return response()->json([
            'data' => $books,
            'links' => [
                'self' => [
                    'href' => url('/api/books'),
                    'method' => 'GET'
                ],
                'create' => [
                    'href' => url('/api/books'),
                    'method' => 'POST'
                ]
            ]
        ]);
    }

    public function show($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['error' => 'Book not found'], 404);
        }

        return response()->json([
            'data' => $book,
            'links' => [
                'self' => [
                    'href' => url("/api/books/{$id}"),
                    'method' => 'GET'
                ],
                'update' => [
                    'href' => url("/api/books/{$id}"),
                    'method' => 'PUT'
                ],
                'delete' => [
                    'href' => url("/api/books/{$id}"),
                    'method' => 'DELETE'
                ],
                'all_books' => [
                    'href' => url('/api/books'),
                    'method' => 'GET'
                ]
            ]
        ]);
    }

    public function store(Request $request)
    {
        $book = Book::create($request->all());

        return response()->json([
            'data' => $book,
            'links' => [
                'self' => [
                    'href' => url("/api/books/{$book->id}"),
                    'method' => 'GET'
                ],
                'update' => [
                    'href' => url("/api/books/{$book->id}"),
                    'method' => 'PUT'
                ],
                'delete' => [
                    'href' => url("/api/books/{$book->id}"),
                    'method' => 'DELETE'
                ],
                'all_books' => [
                    'href' => url('/api/books'),
                    'method' => 'GET'
                ]
            ]
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['error' => 'Book not found'], 404);
        }

        $book->update($request->all());

        return response()->json([
            'data' => $book,
            'links' => [
                'self' => [
                    'href' => url("/api/books/{$id}"),
                    'method' => 'GET'
                ],
                'delete' => [
                    'href' => url("/api/books/{$id}"),
                    'method' => 'DELETE'
                ],
                'all_books' => [
                    'href' => url('/api/books'),
                    'method' => 'GET'
                ]
            ]
        ]);
    }

    public function destroy($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['error' => 'Book not found'], 404);
        }

        $book->delete();

        return response()->json([
            'message' => 'Book deleted successfully',
            'links' => [
                'all_books' => [
                    'href' => url('/api/books'),
                    'method' => 'GET'
                ],
                'create' => [
                    'href' => url('/api/books'),
                    'method' => 'POST'
                ]
            ]
        ]);
    }
}
