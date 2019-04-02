<?php

namespace App\Http\Controllers;

use App\Books;
use Illuminate\Http\Request;
use Log;
use Utils\Handlers\Entity\BooksEntity;
use Utils\Handlers\Entity\EntityFactory;
use App\Http\Requests\CreateBooks;
use App\Http\Requests\GetAllBooks;

/**
 * Class BooksController
 * @package App\Http\Controllers
 */
class BooksController extends Controller
{
    /**
     * Api for retrieving external book information
     *
     * @param Request $request
     *
     * @return array
     */
    public function getBooksFromIceAndFireApi(Request $request) : array
    {
        try {
            $book = $this->getBooksEntity();

            return [
                "status_code" => 200,
                "status" => "success",
                "data" => $book->getBooksFromIceAndFireApi($request->get('nameOfABook', ''))
            ];
        } catch (\Throwable $ex) {
            Log::error($ex->getMessage());

            return [
                "status_code" => 500,
                "status" => "failure",
                "data" => []
            ];
        }
    }

    /**
     * Api for creating new book
     *
     * @param CreateBooks $request
     *
     * @return array
     */
    public function createBook(CreateBooks $request) : array
    {
        try {
            $book = $this->getBooksEntity();

            return [
                "status_code" => 201,
                "status" => "success",
                "data" => $book->create($request->input())
            ];
        } catch (\Throwable $ex) {
            Log::error($ex->getMessage());

            return [
                "status_code" => 500,
                "status" => "failure",
                "data" => []
            ];
        }
    }

    /**
     * Api for creating new book
     *
     * @param GetAllBooks $request
     *
     * @return array
     */
    public function getAllBooks(GetAllBooks $request) : array
    {
        try {
            $book = $this->getBooksEntity();

            return [
                "status_code" => 200,
                "status" => "success",
                "data" => $book->getAllBooks($request->input())
            ];
        } catch (\Throwable $ex) {
            Log::error($ex->getMessage());

            return [
                "status_code" => 500,
                "status" => "failure",
                "data" => []
            ];
        }
    }

    /**
     * @throws \Exception
     *
     * @return BooksEntity
     */
    private function getBooksEntity() : BooksEntity
    {
        return EntityFactory::create('BooksEntity');
    }
}
