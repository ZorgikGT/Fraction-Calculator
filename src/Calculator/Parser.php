<?php

namespace App\Calculator;


class Parser
{
    private $calculator;
    private $patternBase;
    private $patternInternalBrackets;
    private $patternFraction;
    private $patternPriorities;
    private $patternPlusMinus;

    public function __construct(Calculator $calculator)
    {
        $this->calculator = $calculator;
        $this->patternBase = '/-?\d+\/-?\d+|-?\d+/';
        $this->patternInternalBrackets = '/\(([^\(]+)\)/';
        $this->patternFraction = '/(-?\d+)+\/?(\d*)/';
        $this->patternPriorities= '/(-?\d+\/\d+|-?\d+)([\*\:])(-?\d+\/\d+|-?\d+)/';
        $this->patternPlusMinus = '/(-?\d+\/\d+|-?\d+)([\+\-])(-?\d+\/\d+|-?\d+)/';
    }

    public function main($expression)
    {
        $expression = preg_replace('/\s/', '', $expression);
        $expression = preg_replace('#/#', ':', $expression);

        preg_match($this->patternInternalBrackets, $expression, $internalBrackets);

        if (!empty($internalBrackets)) {
            $result = $this->countWithBrackets($expression);
        } else {
            $result = $this->countWithoutBrackets($expression);
        }

        return $result;
    }

     public function countWithBrackets($expression)
    {
        preg_match($this->patternBase, $expression, $base);
        if (strlen($base[0]) == strlen($expression))  {
            return $expression;
        }
        preg_match($this->patternInternalBrackets, $expression, $internalBrackets);

        while(!empty($internalBrackets)) {
            $result = $this->countWithoutBrackets($internalBrackets[1]);
            $expression = preg_replace($this->patternInternalBrackets, $result, $expression, 1);

            preg_match($this->patternInternalBrackets, $expression, $internalBrackets);
        }

        return $this->countWithoutBrackets($expression);
    }
    

    public function countWithoutBrackets($expression)
    {
        preg_match($this->patternBase, $expression, $base);
        if (strlen($base[0]) == strlen($expression))  {
            return $expression;
        }

        preg_match($this->patternPriorities, $expression, $fractionPriority);
        array_shift($fractionPriority);

        if (!empty($fractionPriority)) {
            $result = $this->createNewFraction($fractionPriority);
            $expression = preg_replace($this->patternPriorities, $result, $expression, 1);

            return $this->countWithoutBrackets($expression);
        } else {
            preg_match($this->patternPlusMinus, $expression, $fractionPlusMinus);
            array_shift($fractionPlusMinus);

                if (!empty($fractionPlusMinus)) {
                $result = $this->createNewFraction($fractionPlusMinus);
                $expression = preg_replace($this->patternPlusMinus, $result, $expression,1 );

                return $this->countWithoutBrackets($expression);
            }
        }

        return $expression;
    } 

    public function createNewFraction($fractionsArray)
    {
        preg_match($this->patternFraction, $fractionsArray[0], $fraction);
        $fractionFirst = new Fraction();
        $fractionFirst->setNumerator($fraction[1]);
        $fractionFirst->setDenominator($fraction[2]);

        preg_match($this->patternFraction, $fractionsArray[2], $fraction);
        $fractionSecond = new Fraction();
        $fractionSecond->setNumerator($fraction[1]);
        $fractionSecond->setDenominator($fraction[2]);

        $this->calculator->setMethod($fractionsArray[1]);
        $result = $this->calculator->calculate($fractionFirst, $fractionSecond);

        return $result;
    }
}
