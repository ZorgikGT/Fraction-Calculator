<?php

namespace App\Calculator;


class Validator
{
    private $unnecessarySymbolsPattern;
    private $amountLeftBrackets;
    private $amountRightBrackets;

    public function __construct()
    {
        $this->unnecessarySymbolsPattern = '#[\^@-\[\]-~!-\',\.;-?]+#';
        $this->amountLeftBrackets = '#[\(]#';
        $this->amountRightBrackets = '#[\)]#';
    }

    public function validate(String $expression)
    {
        if(!$this->unnecessarySymbols($expression)) {

            return 'Incorrect symbols';
        }

        if(!$this->amountBrackets($expression)) {

            return 'Incorrect amount of brackets';
        }

        return true;
    }

    private function amountBrackets(String $expression)
    {
        preg_match_all($this->amountLeftBrackets, $expression, $leftBrackets);
        preg_match_all($this->amountRightBrackets, $expression, $rightBrackets);

        $amount = 0;
        foreach ($expression as $item) {
            if($item == '(') {
                $amount++;
            }

        }
        if(count($leftBrackets[0]) != count($rightBrackets[0])) {

            return false;
        }

        return true;

    }

    private function unnecessarySymbols(String $expression): bool
    {
        preg_match($this->unnecessarySymbolsPattern, $expression, $base);
        if(!empty($base)) {

            return false;
        }

        return true;
    }
}
