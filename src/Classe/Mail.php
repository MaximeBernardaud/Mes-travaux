<?php

namespace App\Classe;

use Mailjet\Client;
use Mailjet\Resources;

class Mail
{
    private $api_key = 'b617489860c334b1a8dada9907eabc68';
    private $api_key_secret = 'cff8b66b0d2e6219cb6a1b2ee81b2e09';

    public function send($to_email, $to_name, $subject, $content)
    {
        $mj = new Client($this->api_key, $this->api_key_secret, true,['version'=>'v3.1']);

        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "picsou-live@hotmail.fr",
                        'Name' => "La boutique Française"
                    ],
                    'To' => [
                        [
                            'Email' => $to_email,
                            'Name' => $to_name
                        ]
                    ],
                    'TemplateID' => 2661099,
                    'TemplateLanguage' => true,
                    'Subject' => $subject,
                    'Variables' => [
                        'content' => $content,
                    ]
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success();
    }
}