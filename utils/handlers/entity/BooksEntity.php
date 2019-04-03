<?php

namespace Utils\Handlers\Entity;

use Utils\Api\ApiFactory;
use App\Books;
use Illuminate\Database\Eloquent\Collection;
/**
 * Class BooksEntity
 * @package Utils\Handlers\Entity
 */
class BooksEntity
{
    /**
     * Gets books From ice and fire api
     *
     * @param string $name
     *
     * @throws \Exception
     *
     * @return array
     */
    public function getBooksFromIceAndFireApi(string $name) : array
    {
        $iceAndFireApi = ApiFactory::create('IceAndFireApi');

        return $this->refactorBooksFromIceAndFireApi($iceAndFireApi->getBooks($name));
    }

    /**
     * Create new book in database and returns it as an array
     *
     * @param array $data
     *
     * @throws \Exception
     *
     * @return array
     */
    public function create(array $data) : array
    {
        $book = $this->getBook();
        $book->fill($data);
        if ($book->save()) {
            $book = $this->formatBook($book);
            unset($book['id']);
            return ['book' => $book];
        } else {
            return [];
        }
    }

    /**
     * Get all books that passes the provided filters
     *
     * @param array $filters
     *
     * @return array
     */
    public function getAllBooks(array $filters) : array
    {
        $book = $this->getBook();

        return $this->formatBooks($book->getAllBooks($filters));
    }

    /**
     * Get book by id
     *
     * @param int $id
     *
     * @return array
     */
    public function getBookByID(int $id) : array
    {
        $bookModel = $this->getBook();
        $book = $bookModel->getBookByID($id);
        if ($book) {
            return $this->formatBook($book);
        }

        return [];
    }

    /**
     * Delete book by id
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return null|string
     */
    public function deleteBookById(int $id) : ?string
    {
        $book = $this->getBook();

        return $book->deleteBookById($id);
    }

    /**
     * Update book by id
     *
     * @param int $id
     * @param array $data
     *
     * @throws \Exception
     *
     * @return array
     */
    public function updateBookById(int $id, array $data) : array
    {
        $bookModel = $this->getBook();
        $book = $bookModel->updateBookById($id, $data);
        if ($book) {
            return $this->formatBook($book);
        }

        return [];
    }

    /**
     * Format books array and return books array
     *
     * @param Collection $books
     *
     * @return array
     */
    private function formatBooks(Collection $books) : array
    {
        $bookArray = [];
        foreach ($books as $book) {
            $bookArray[] = $this->formatBook($book);
        }

        return $bookArray;
    }

    /**
     * Format book and return book object as array
     *
     * @param Books $book
     *
     * @return array
     */
    private function formatBook(Books $book) : array
    {
        $bookArray = $book->toArray();
        $bookArray['authors'] = $book->getAuthors();

        return $bookArray;
    }

    /**
     * Removes and rename keys of books list that is received from ice and fire api
     *
     * @param array $books
     *
     * @return array
     */
    private function refactorBooksFromIceAndFireApi(array $books) : array
    {
        $booksArray = [];

        foreach ($books as $k => $book) {
            $booksArray[$k]['name'] = $book['name'];
            $booksArray[$k]['isbn'] = $book['isbn'];
            $booksArray[$k]['authors'] = $book['authors'];
            $booksArray[$k]['number_of_pages'] = $book['numberOfPages'];
            $booksArray[$k]['publisher'] = $book['publisher'];
            $booksArray[$k]['country'] = $book['country'];
            $booksArray[$k]['release_date'] = date('Y-m-d', strtotime($book['released']));
        }

        return $booksArray;
    }

    /**
     * @return Books
     */
    public function getBook() : Books
    {
        return new Books();
    }
}