<?php

namespace App\Services;


use App\Services\Contracts\TranslateServiceContract;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class TranslateService implements TranslateServiceContract
{

    public function translate($text)
    {
        $URL = 'https://translation.googleapis.com/language/translate/v2';

        $client = new Client();

        $res = $client->post($URL, [
            'query' => [
                'key' => 'AIzaSyCEYe59xoog4g8GvqPOrBOP-veGVY8IFqI',
                'souce' => 'cs',
                'target' => 'sk',
                'format' => 'text'
            ],

            'form_params' => [
                'q' => $text
            ]
            
        ]);

        $responseArray = json_decode($res->getBody() ,true);
        $translatedText = $responseArray['data']['translations'][0]['translatedText'];

        return $translatedText;

    }
}
