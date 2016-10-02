<?php
/******************************************************************************
 * An implementation of dicto (scg.unibe.ch/dicto) in and for PHP.
 * 
 * Copyright (c) 2016 Richard Klees <richard.klees@rwth-aachen.de>
 *
 * This software is licensed under The MIT License. You should have received 
 * a copy of the license along with the code.
 */

namespace Lechimp\Dicto\Variables;

use Lechimp\Dicto\Graph\Node;

abstract class Entities extends Variable {
    public function __construct($name= null) {
        if ($name === null) {
            $name = ucfirst($this->meaning());
        }
        parent::__construct($name);
    }

    /**
     * Get an id for the type of entity.
     *
     * @return  string
     */
    abstract public function id();

    /**
     * @inheritdocs
     */
    public function compile() {
        return function(Node $n) {
            return $n->type() == $this->id()
                || $n->type() == $this->id()." reference";
        };
    }
}

