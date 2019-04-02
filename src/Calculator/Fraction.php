<?php

namespace App\Calculator;


class Fraction
{
    private $numerator;
    private $denominator = 1;

    /**
     * @return string
     */
    public function getNumerator(): ?string
    {
        return $this->numerator;
    }

    /**
     * @param string $numerator
     * @return Fraction
     */
    public function setNumerator(string $numerator): self
    {
        $this->numerator = $numerator;

        return $this;
    }

    /**
     * @return string
     */
    public function getDenominator() : ?string
    {
        return $this->denominator;
    }

    /**
     * @param string $denominator
     * @return Fraction
     */
    public function setDenominator(string $denominator): self
    {
        if ($denominator == "") return $this;
        $this->denominator = $denominator;

        return $this;
    }

    /**
     * @return string
     */
    public function getResult() : ?string
    {
        $numerator = $this->getNumerator();
        $denominator = $this->getDenominator();

        if ($numerator < 0 && $denominator < 0) {
            $numerator *= -1;
            $denominator *= -1;
            $this->setNumerator($numerator);
            $this->setDenominator($denominator);
        }

        $result = $this->getNumerator() . "/" . $this->getDenominator();

        return $result;
    }
}
