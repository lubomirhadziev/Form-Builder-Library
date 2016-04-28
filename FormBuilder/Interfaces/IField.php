<?php

namespace libraries\Form\Interfaces;

interface IField
{
    
    public function __construct();

    public function dbField();

    public function fieldNameBase();

    public function title();
    
}
