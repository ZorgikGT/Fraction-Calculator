<?php

namespace App\Generators;


class RandomNumberGenerator
{
    public function getArrayOfNumbers()
    {
        $data = $this->getData();

        foreach($data as $item) {
            if(is_array($item)) {
                foreach ($item as $key => $param) {
                    if($param["data"]) {
                        $numbers = $param["data"];
                    }
                    return $numbers;
                }
            }
        }

        throw new \Exception('Something went wrong', 405);
    }

    private function getData()
    {
        $data_string = "{
                    \"jsonrpc\": \"2.0\",
                    \"method\": \"generateIntegers\",
                    \"params\": {
                        \"apiKey\": \"token here\",
                        \"n\": 1000,
                        \"min\": 0,
                        \"max\": 2,
                        \"replacement\": true
                    },
                    \"id\": 42
                }";

        $ch = curl_init('https://api.random.org/json-rpc/2/invoke');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($result, true);

        return $result;
    }
}
