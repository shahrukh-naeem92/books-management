<?php

namespace App\Http\Controllers;

use App\Http\Requests\BaseRequest;
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
     * @param BaseRequest $request
     *
     * @return array
     */
    public function getBooksFromIceAndFireApi(BaseRequest $request) : array
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
     * Api for retrieving a list of books
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
     * Api for retrieving a book by its id
     *
     * @param int $id
     *
     * @return array
     */
    public function getBook(int $id) : array
    {
        try {
            $book = $this->getBooksEntity();

            return [
                "status_code" => 200,
                "status" => "success",
                "data" => $book->getBookByID($id)
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
     * Api for deleting a book by its id
     *
     * @param int $id
     *
     * @return array
     */
    public function deleteBook(int $id) : array
    {
        try {
            $book = $this->getBooksEntity();
            $bookName = $book->deleteBookById($id);
            return [
                "status_code" => 204,
                "status" => $bookName ? 'success' : 'failure',
                "message" => $bookName ?
                    "The book $bookName was deleted successfully" :
                    "The book could not be deleted",
                "data" => []
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
     * Api for updating a book by its id
     *
     * @param BaseRequest $request
     * @param int $id
     *
     * @return array
     */
    public function updateBook(BaseRequest $request, int $id) : array
    {
        try {
            $bookEntity = $this->getBooksEntity();
            $book = $bookEntity->updateBookById($id, $request->getParametersFromPutRequest());
            return [
                "status_code" => 200,
                "status" => (!empty($book)) ? 'success' : 'failure',
                "message" => (!empty($book)) ?
                    "The book ".$book['name'] ." was updated successfully" :
                    "The book could not be updated",
                "data" => $book
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
