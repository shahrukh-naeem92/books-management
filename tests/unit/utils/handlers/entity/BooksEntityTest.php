<?php

namespace Tests\Unit\Utils\Handlers\Entity;

use Utils\Handlers\Entity\BooksEntity;
use Tests\TestCase;
use App\Books;
use Illuminate\Database\Eloquent\Collection;

class BooksEntityTest extends TestCase
{

    public function testCreate()
    {
        $data = [
            'name' => 'test book',
            'isbn' => 'test isbn',
            'authors' => ['test authors'],
            'country' => 'test country',
            'number_of_pages' => 120,
            'publisher' => 'test publisher',
            'release_date' => '1999-12-12'
        ];
        $book = new Books();
        $book->fill($data);

        $bookMock = $this->getMockBuilder(Books::class)
            ->setMethods(['saveBook'])
            ->getMock();
        $bookMock->method('saveBook')
            ->willReturn($book);

        $entity = $this->getMockBuilder(BooksEntity::class)
            ->setMethods(['getBook'])
            ->getMock();
        $entity->method('getBook')
            ->willReturn($bookMock);

        $result = $entity->create($data);
        $result = !empty($result) ? $result['book'] : [];

        $this->assertEquals(json_encode($data), json_encode($result));
    }

    public function testGetAllBooks()
    {
        $data = [
            'name' => 'test book',
            'isbn' => 'test isbn',
            'authors' => ['test authors'],
            'country' => 'test country',
            'number_of_pages' => 120,
            'publisher' => 'test publisher',
            'release_date' => '1999-12-12'
        ];
        $book = new Books();
        $book->fill($data);

        $collection = new Collection();
        $collection->add($book);

        $bookMock = $this->getMockBuilder(Books::class)
            ->setMethods(['getAllBooks'])
            ->getMock();
        $bookMock->method('getAllBooks')
            ->willReturn($collection);

        $entity = $this->getMockBuilder(BooksEntity::class)
            ->setMethods(['getBook'])
            ->getMock();
        $entity->method('getBook')
            ->willReturn($bookMock);

        $result = $entity->getAllBooks();
        $result = isset($result[0]) ? $result[0] : [];

        $this->assertEquals(json_encode($data), json_encode($result));
    }

    public function testGetBookByID()
    {
        $data = [
            'name' => 'test book',
            'isbn' => 'test isbn',
            'authors' => ['test authors'],
            'country' => 'test country',
            'number_of_pages' => 120,
            'publisher' => 'test publisher',
            'release_date' => '1999-12-12'
        ];
        $book = new Books();
        $book->fill($data);

        $bookMock = $this->getMockBuilder(Books::class)
            ->setMethods(['getBookByID'])
            ->getMock();
        $bookMock->method('getBookByID')
            ->willReturn($book);

        $entity = $this->getMockBuilder(BooksEntity::class)
            ->setMethods(['getBook'])
            ->getMock();
        $entity->method('getBook')
            ->willReturn($bookMock);

        $result = $entity->getBookByID(1);

        $this->assertEquals(json_encode($data), json_encode($result));
    }

    public function testDeleteBookById()
    {
        $bookName = 'Name of the book';

        $bookMock = $this->getMockBuilder(Books::class)
            ->setMethods(['deleteBookByID'])
            ->getMock();
        $bookMock->method('deleteBookByID')
            ->willReturn($bookName);

        $entity = $this->getMockBuilder(BooksEntity::class)
            ->setMethods(['getBook'])
            ->getMock();
        $entity->method('getBook')
            ->willReturn($bookMock);

        $result = $entity->deleteBookByID(1);

        $this->assertEquals($bookName, $result);
    }

    public function testUpdateBookById()
    {
        $data = [
            'name' => 'test book',
            'isbn' => 'test isbn',
            'authors' => ['test authors'],
            'country' => 'test country',
            'number_of_pages' => 120,
            'publisher' => 'test publisher',
            'release_date' => '1999-12-12'
        ];
        $book = new Books();
        $book->fill($data);

        $bookMock = $this->getMockBuilder(Books::class)
            ->setMethods(['updateBookByID'])
            ->getMock();
        $bookMock->method('updateBookByID')
            ->willReturn($book);

        $entity = $this->getMockBuilder(BooksEntity::class)
            ->setMethods(['getBook'])
            ->getMock();
        $entity->method('getBook')
            ->willReturn($bookMock);

        $result = $entity->updateBookByID(1, []);

        $this->assertEquals(json_encode($data), json_encode($result));
    }
}