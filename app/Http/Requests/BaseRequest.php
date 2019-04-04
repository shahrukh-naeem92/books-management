<?php

namespace App\Http\Requests;

use Pearl\RequestValidate\RequestAbstract;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Utils\Utils;

/**
 * Class BaseRequest
 * @package App\Http\Requests
 */
class BaseRequest extends RequestAbstract
{
    /**
     * @return array
     */
    public function rules() : array
    {
        return [];
    }

    /**
     * Returns all the form data from put request
     *
     * @return array
     */
    public function getParametersFromPutRequest() : array
    {
        $putdata = fopen("php://input", "r");
        $raw_data = '';
        $data = [];
        while ($chunk = fread($putdata, 1024)) {
            $raw_data .= $chunk;
        }
        fclose($putdata);

        $boundary = substr($raw_data, 0, strpos($raw_data, "\r\n"));

        if (empty($boundary)) {
            parse_str($raw_data, $data);

            return $data;
        }

        // Fetch each part
        $parts = array_slice(explode($boundary, $raw_data), 1);
        $data = array();

        foreach ($parts as $part) {
            if ($part == "--\r\n") {
                break;
            }
            // Separate content from headers
            $part = ltrim($part, "\r\n");
            list($raw_headers, $body) = explode("\r\n\r\n", $part, 2);

            // Parse the headers list
            $raw_headers = explode("\r\n", $raw_headers);
            $headers = array();
            foreach ($raw_headers as $header) {
                list($name, $value) = explode(':', $header);
                $headers[strtolower($name)] = ltrim($value, ' ');
            }

            // Parse the Content-Disposition to get the field name, etc.
            if (isset($headers['content-disposition'])) {
                $filename = null;
                $tmp_name = null;
                preg_match(
                    '/^(.+); *name="([^"]+)"(; *filename="([^"]+)")?/',
                    $headers['content-disposition'],
                    $matches
                );
                list(, $type, $name) = $matches;

                //Parse File
                if (isset($matches[4])) {
                    //if labeled the same as previous, skip
                    if (isset($_FILES[$matches[2]])) {
                        continue;
                    }

                    //get filename
                    $filename = $matches[4];

                    //get tmp name
                    $filename_parts = pathinfo($filename);
                    $tmp_name = tempnam(ini_get('upload_tmp_dir'), $filename_parts['filename']);

                    //populate $_FILES with information, size may be off in multibyte situation
                    $_FILES[ $matches[ 2 ] ] = array(
                        'error'=>0,
                        'name'=>$filename,
                        'tmp_name'=>$tmp_name,
                        'size'=>strlen($body),
                        'type'=>$value
                    );

                    //place in temporary directory
                    file_put_contents($tmp_name, $body);
                } else {
                    $data[$name] = substr($body, 0, strlen($body) - 2);
                }
            }
        }

        return $data;
    }

    /**
     * Format the errors from the given Validator instance.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     *
     * @return JsonResponse
     */
    protected function formatErrors(Validator $validator) : JsonResponse
    {
        return new JsonResponse(
            [
                'status_code' => 400,
                'status' => 'failure',
                'data' => [],
                'message' => Utils::getInstance()->getErrorMessagesFromValidator($validator)
            ],
            400
        );
    }
}
