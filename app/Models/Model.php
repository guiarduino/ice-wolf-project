<?php

namespace app\Models;

use ReflectionClass;
use ReflectionProperty;

abstract class Model
{
    abstract function __construct();

    abstract function fillEntity(array $args);

}