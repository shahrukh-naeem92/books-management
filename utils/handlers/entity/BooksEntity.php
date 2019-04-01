<?php

namespace Utils\Handlers\Entity;

use Utils\Api\ApiFactory;

/**
 * Class BooksEntity
 * @package Utils\Handlers\Entity
 */
class BooksEntity
{
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
}