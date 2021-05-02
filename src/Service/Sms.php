<?php
namespace App\Service;

use Melipayamak\MelipayamakApi;

class Sms
{
    private $sender;

    public function __construct() {
        // this connectivity is used for melipayamak api and it is for test (that's why we didn't store username and password in database)
        $api = new MelipayamakApi('09034034103','7179');
        $this->sender = $api->sms();
    }

    /**
     * this method will be used for sending message through melipayamak api and returns server response
     *
     * @param string $to
     * @param string $text
     * @return array
     */
    public function send(string $to , string $text) : array
    {
        $from = '50004000403103';
        try{
            $response = $this->sender->send($to,$from,$text);
            $array = json_decode($response , true);
            return $array;
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }
}