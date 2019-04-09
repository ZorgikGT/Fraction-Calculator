<?php

namespace App\Tests;

use App\Calculator\Validator;
use PHPUnit\Framework\TestCase;
use App\Calculator\Calculator;
use App\Calculator\Parser;

class CalculatorTest extends TestCase
{
    /**
     * @var Parser $parser
     */
    protected $parser;

    protected function setUp(): void
    {
        $this->parser = new Parser(new Calculator());
    }
    public function testSingleNumber()
    {
        self::assertEquals('1000', $this->parser->main('1000'));
    }
    public function testSimpleOperations()
    {
        self::assertEquals('100/1', $this->parser->main('2*50'));
        self::assertEquals('1/4', $this->parser->main('2/4*5/10'));
        self::assertEquals('6/1', $this->parser->main('2+4'));
        self::assertEquals('0/1', $this->parser->main('5-5'));
        self::assertEquals('-10/1', $this->parser->main('-5-5'));
        self::assertEquals('3/5', $this->parser->main('(2/4)/(5/6)'));
        self::assertEquals('3/5', $this->parser->main('(-2/4)/(-5/6)'));
        self::assertEquals('3/2', $this->parser->main('1 + 1/2'));
    }
    public function testPriority()
    {
        self::assertEquals('16/1', $this->parser->main('2+4*6-1*10'));
    }
    public function testBracketStatement()
    {
        self::assertEquals('3/5', $this->parser->main('(2/4)/(5/6)'));
        self::assertEquals("3/4", $this->parser->main("(3/6) / (2/3)"));
        self::assertEquals("42", $this->parser->main("((42))"));
        self::assertEquals("3/8", $this->parser->main("1/(2/ (3/(4)))"));
        self::assertEquals('8/1', $this->parser->main('(2 + 2) + (2 + 2)'));
        self::assertEquals('16/1', $this->parser->main('(2 + 2) * (2 + 2)'));
        self::assertEquals('1/1', $this->parser->main('(2 + 2) / (2 + 2)'));
        self::assertEquals('4/1', $this->parser->main('(10 + 2) - (2 + 2) * 2'));
        self::assertEquals('11/8', $this->parser->main('1/2+(-3/2*7/4)/-3'));
        self::assertEquals('-47/42', $this->parser->main('(1/2 + 2/3) - ((2/7) / (1/8))'));
    }
    public function testIgnoreSpaces()
    {
        $result1 = $this->parser->main( ' 1 / 2 + 2 / 3 ');
        $result2 = $this->parser->main( '1/2+2/3');
        self::assertEquals('7/6', $result1);
        self::assertEquals($result1, $result2);
    }
    public function testValidator()
    {
        $validator = new Validator();
        self::assertEquals('Incorrect symbols', $validator->validate('1!+4@'));
        self::assertEquals('Incorrect amount of brackets', $validator->validate('(10 + 2 - (2 + 2) * 2'));
    }
}
