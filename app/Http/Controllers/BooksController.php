<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use Utils\Handlers\Entity\EntityFactory;

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
            $iceAndFireApi = EntityFactory::create('BooksEntity');

            return [
                "status_code" => 200,
                "status" => "success",
                "data" => $iceAndFireApi->getBooksFromIceAndFireApi($request->get('nameOfABook', ''))
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
}
