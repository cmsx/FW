<?php

require_once __DIR__ . '/../init.php';

class DummyTest extends PHPUnit_Framework_TestCase
{
  function testAutoload()
  {
    new Dummy\Thing();
    new Dummy_Hello();
  }
}