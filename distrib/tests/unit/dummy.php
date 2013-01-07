<?php

require_once __DIR__ . '/../init.php';

class DummyTest extends PHPUnit_Framework_TestCase
{
  function testMe()
  {
    $this->assertEquals(4, 2*2, 'Не удивительно :)');
  }
}