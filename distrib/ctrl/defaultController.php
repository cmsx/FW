<?php

use CMSx\Page;
use CMSx\Controller;

class defaultController extends Controller
{
  function indexAction()
  {
    $p = new Page();
    $p->setTitle('Hello World!');
    $p->setText('<p>It works :)</p>');

    return $p;
  }
}