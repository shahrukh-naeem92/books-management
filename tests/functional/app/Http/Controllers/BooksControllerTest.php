<?php

namespace Tests\Functional\App\Http\Controller;

use Tests\Functional\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Books;

/**
 * Class BooksControllerTest
 * @package Tests\Functional\App\Http\Controller
 */
class BooksControllerTest extends TestCase
{

    use DatabaseTransactions;
    
    /**
     * @var string
     */
    private $bookCrudUrl = '/api/v1/books';

    /**
     * Test getBooksFromIceAndFireApi function of BooksController
     *
     * @param string $name
     *
     * @dataProvider getBooksFromIceAndFireApiDataProvider
     *
     * @return void
     */
    public function testGetBooksFromIceAndFireApi(string $name): void
    {
        $response = $this->getResponse('GET', '/api/external-books', ['nameOfABook' => $name]);
        $result = $this->getResponseContentAsArray($response);
        $this->generalBookAssertion(200, 200, 'success', $response, $result);

        if (isset($result['data'][0]['name'])) {
            $this->assertEquals($name, $result['data'][0]['name']);
        }
    }

    /**
     * Test createBook function of BooksController
     *
     * @param array $data
     * @param int $responseCode
     * @param int $statusCode
     * @param string $status
     * @param array $result
     *
     * @dataProvider createBookDataProvider
     *
     * @return void
     */
    public function testCreateBook(
        array $data,
        int $responseCode,
        int $statusCode,
        string $status,
        array $result
    ): void {
        $response = $this->getResponse('POST', $this->bookCrudUrl, $data);
        $apiResult = $this->getResponseContentAsArray($response);
        $this->generalBookAssertion($responseCode, $statusCode, $status, $response, $apiResult);
        $this->assertEquals($apiResult['data'], $result);
    }

    /**
     * Test getAllBooks function of BooksController
     *
     * @return void
     */
    public function testGetAllBooks(): void
    {
        $response = $this->getResponse('GET', $this->bookCrudUrl, []);
        $apiResult = $this->getResponseContentAsArray($response);
        $this->generalBookAssertion(200, 200, 'success', $response, $apiResult);
    }

    /**
     * Test getBook function of BooksController
     *
     * @return void
     */
    public function testGetBook(): void
    {
        $response = $this->getResponse('GET', $this->bookCrudUrl.'/1', []);
        $apiResult = $this->getResponseContentAsArray($response);
        $this->generalBookAssertion(200, 200, 'success', $response, $apiResult);
    }

    /**
     * Test deleteBook function of BooksController
     *
     * @param array $data
     * @param string $status
     * @param string $message
     *
     * @dataProvider deleteBookDataProvider
     *
     * @throws \Exception
     *
     * @return void
     */
    public function testDeleteBook(array $data, string $status, string $message): void
    {
        if (!empty($data)) {
            $book = new Books();
            $book->fill($data);
            $book->save();
        }
        $id = !empty($book->id) ? $book->id : 123423456787;
        $response = $this->getResponse('DELETE', $this->bookCrudUrl.'/'.$id, []);
        $apiResult = $this->getResponseContentAsArray($response);
        $this->generalBookAssertion(200, 204, $status, $response, $apiResult);
        $this->assertEquals($apiResult['message'], $message);
    }

    /**
     * Test updateBook function of BooksController
     *
     * @param array $data
     * @param array $updatedData
     * @param string $status
     * @param string $message
     *
     * @dataProvider updateBookDataProvider
     *
     * @throws \Exception
     *
     * @return void
     */
    public function testUpdateBook(array $data, array $updatedData, string $status, string $message): void
    {
        if (!empty($data)) {
            $book = new Books();
            $book->fill($data);
            $book->save();
        }
        $id = !empty($book->id) ? $book->id : 1234234567;
        $response = $this->getResponse('PATCH', $this->bookCrudUrl.'/'.$id, $updatedData);
        $apiResult = $this->getResponseContentAsArray($response);
        $this->generalBookAssertion(200, 200, $status, $response, $apiResult);
        $this->assertEquals($apiResult['message'], $message);
       // $this->assertEquals($apiResult['data'], $updatedData);
    }

    /**
     * @return array
     */
    public function getBooksFromIceAndFireApiDataProvider(): array
    {
        return [
            [
                'A Game of Thrones',
            ],
            [
                'There cannot be a book of this name'
            ]
        ];
    }

    /**
     * @return array
     */
    public function createBookDataProvider(): array
    {
        return [
            [
                [],
                400,
                400,
                'failure',
                []
            ],
            [
                [
                    'name' => 'test book',
                    'isbn' => 'test isbn',
                    'authors' => ['test authors'],
                    'country' => 'test country',
                    'number_of_pages' => 120,
                    'publisher' => 'test publisher',
                    'release_date' => '1999-12-12'
                ],
                200,
                201,
                'success',
                [
                    'book' => [
                        'name' => 'test book',
                        'isbn' => 'test isbn',
                        'authors' => ['test authors'],
                        'country' => 'test country',
                        'number_of_pages' => 120,
                        'publisher' => 'test publisher',
                        'release_date' => '1999-12-12'
                    ]

                ]
            ]

        ];
    }

    /**
     * @return array
     */
    public function deleteBookDataProvider(): array
    {
        return [
            [
                [],
                'failure',
                'The book could not be deleted'
            ],
            [
                [
                    'name' => 'test book',
                    'isbn' => 'test isbn',
                    'authors' => ['test authors'],
                    'country' => 'test country',
                    'number_of_pages' => 120,
                    'publisher' => 'test publisher',
                    'release_date' => '1999-12-12'
                ],
                'success',
                'The book test book was deleted successfully'
            ]

        ];
    }

    /**
     * @return array
     */
    public function updateBookDataProvider(): array
    {
        return [
            [
                [],
                [],
                'failure',
                'The book could not be updated'
            ],
            [
                [
                    'name' => 'test book',
                    'isbn' => 'test isbn',
                    'authors' => ['test authors'],
                    'country' => 'test country',
                    'number_of_pages' => 120,
                    'publisher' => 'test publisher',
                    'release_date' => '1999-12-12'
                ],
                [
                    'name' => 'test book',
                    'isbn' => 'new test isbn',
                    'authors' => ['new test authors'],
                    'country' => 'new test country',
                    'number_of_pages' => 120,
                    'publisher' => 'new test publisher',
                    'release_date' => '1999-12-11'
                ],
                'success',
                'The book test book was updated successfully'
            ]

        ];
    }

    /**
     * @param int $responseCode
     * @param int $statusCode
     * @param string $success
     * @param Response $response
     * @param null|array $result
     *
     * @return void
     */
    private function generalBookAssertion(
        int $responseCode,
        int $statusCode,
        string $status,
        Response $response,
        ?array $result
    ): void {
        $this->assertEquals($responseCode, $response->status());
        $this->assertEquals($statusCode, $result['status_code']);
        $this->assertEquals($status, $result['status']);
        $this->assertIsArray($result['data']);
    }
}