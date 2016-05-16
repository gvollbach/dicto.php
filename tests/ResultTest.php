<?php
/******************************************************************************
 * An implementation of dicto (scg.unibe.ch/dicto) in and for PHP.
 *
 * Copyright (c) 2016, 2015 Richard Klees <richard.klees@rwth-aachen.de>
 *
 * This software is licensed under The MIT License. You should have received
 * a copy of the licence along with the code.
 */

use Lechimp\Dicto\Dicto;

use Lechimp\Dicto\Analysis as Analysis;
use Lechimp\Dicto\Analysis\Violation;
use Lechimp\Dicto\Analysis\Result;

use Lechimp\Dicto\Definition\Variables as Vars;
use Lechimp\Dicto\Definition\Rules as Rules;

class ResultTest extends PHPUnit_Framework_TestCase {
    public function setUp() {
        Dicto::startDefinition();
        Dicto::MyClasses()->means()->classes();
        Dicto::MyFunctions()->means()->functions();
        Dicto::MyClasses()->cannot()->invoke()->MyFunctions();
        Dicto::MyFunctions()->cannot()->depend_on()->MyClasses();
        list($this->ruleset, $_) = Dicto::endDefinition(); 
        $rules = $this->ruleset->rules();
        $this->r1 = $rules[0];
        $this->r2 = $rules[1];

        $this->v1 = new Violation( $this->r1, "r1.php", 1, "line 1");
        $this->v2 = new Violation( $this->r2, "r2.php", 4, "line 4");
        $this->result = new Result($this->ruleset, array($this->v1, $this->v2));
    }

    public function test_violation_content() {
        $this->assertEquals($this->r1, $this->v1->rule());
        $this->assertEquals("r1.php", $this->v1->filename());
        $this->assertEquals(1, $this->v1->line_no());
        $this->assertEquals("line 1", $this->v1->line());

        $this->assertEquals($this->r2, $this->v2->rule());
        $this->assertEquals("r2.php", $this->v2->filename());
        $this->assertEquals(4, $this->v2->line_no());
        $this->assertEquals("line 4", $this->v2->line());
    }

    public function test_violations_in() {
        $in_r1 = array($this->v1);
        $in_r2 = array($this->v2);
        $this->assertEquals($in_r1, $this->result->violations_in("r1.php"));
        $this->assertEquals($in_r2, $this->result->violations_in("r2.php"));
    }

    public function test_violations_of() {
        $of_r1 = array($this->v1);
        $of_r2 = array($this->v2);
        $this->assertEquals($of_r1, $this->result->violations_of($this->r1));
        $this->assertEquals($of_r2, $this->result->violations_of($this->r2));
    }

    public function test_caches() {
        $this->assertEquals( $this->result->violations_in("r1.php")
                           , $this->result->violations_in("r1.php"));
        $this->assertEquals( $this->result->violations_of($this->r1)
                           , $this->result->violations_of($this->r1));
    }
}
