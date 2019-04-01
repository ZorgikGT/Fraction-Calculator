<?php

namespace App\Calculator;


class Calculator
{
    private $method;

    /**
     * @return string
     */
    public function getMethod(): ?string
    {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod(string $method)
    {
        $this->method = $method;
    }

    /**
     * @param Fraction $f1
     * @param Fraction $f2
     * @return string
     */
    public function calculate(Fraction $f1, Fraction $f2)
    {
        /** @var Fraction $fraction */
        $fraction = 0;
        switch ($this->getMethod()) {
            case "-":
                $fraction = $this->minus($f1, $f2);
                break;
            case "+":
                $fraction = $this->plus($f1, $f2);
                break;
            case "*":
                $fraction = $this->multiplication($f1, $f2);
                break;
            case ":":
                $fraction = $this->division($f1, $f2);
                break;
        }

        return $fraction->getResult();
    }

    /**
     * @param Fraction $f1
     * @param Fraction $f2
     * @return Fraction
     */
    public function plus(Fraction $f1, Fraction $f2)
    {
        $newFraction = new Fraction();
        $newFraction->setNumerator(
            $f1->getNumerator() * $f2->getDenominator()
            + $f2->getNumerator() * $f1->getDenominator()
        );
        $newFraction->setDenominator($f1->getDenominator() * $f2->getDenominator());

        return $this->simplify($newFraction);
    }

    /**
     * @param Fraction $f1
     * @param Fraction $f2
     * @return Fraction
     */
    public function multiplication(Fraction $f1, Fraction $f2)
    {
        $newFraction = new Fraction();
        $newFraction->setNumerator($f1->getNumerator() * $f2->getNumerator());
        $newFraction->setDenominator($f1->getDenominator() * $f2->getDenominator());

        return $this->simplify($newFraction);
    }

    /**
     * @param Fraction $f1
     * @param Fraction $f2
     * @return Fraction
     */
    public function minus(Fraction $f1, Fraction $f2)
    {
        $newFraction = new Fraction();
        $newFraction->setNumerator(
            $f1->getNumerator() * $f2->getDenominator()
            - $f2->getNumerator() * $f1->getDenominator()
        );
        $newFraction->setDenominator($f1->getDenominator() * $f2->getDenominator());

        return $this->simplify($newFraction);
    }

    /**
     * @param Fraction $f1
     * @return Fraction
     */
    public function minusFraction(Fraction $f1)
    {
        $newFraction = new Fraction();
        $newFraction->setNumerator($f1->getNumerator() * (-1));
        $newFraction->setDenominator($f1->getDenominator());

        return $this->simplify($newFraction);
    }

    /**
     * @param Fraction $f1
     * @param Fraction $f2
     * @return Fraction
     */
    public function division(Fraction $f1, Fraction $f2)
    {
        $newFraction = new Fraction();
        $newFraction->setNumerator($f1->getNumerator() * $f2->getDenominator());
        $newFraction->setDenominator($f1->getDenominator() * $f2->getNumerator());

        return $this->simplify($newFraction);
    }


    public function simplify(Fraction $fraction)
    {
        $numerator = abs($fraction->getNumerator());
        $denominator = abs($fraction->getDenominator());
        while($numerator !== 0 && $denominator !== 0) {
            if ($numerator > $denominator) {
                $numerator %= $denominator;
            } else {
                $denominator %= $numerator;
            }
        }

        $fraction
            ->setDenominator($fraction->getDenominator() / ($numerator + $denominator))
            ->setNumerator($fraction->getNumerator() / ($numerator + $denominator));

        return $fraction;
    }

}
