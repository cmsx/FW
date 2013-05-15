<?php

use CMSx\Page;
use CMSx\Controller;
use Symfony\Component\HttpFoundation\Response;

class defaultController extends Controller
{
  function indexAction()
  {
    $p = new Page();
    $p->setTitle('Hello World!');
    $p->setText('<p>It works :)</p>');

    return $p;
  }

  /** Экшн для отображения возникающих ошибок. Отображается через подзапрос */
  function errorAction()
  {
    /** @var $e Symfony\Component\Debug\Exception\FlattenException */
    if (!$e = $this->getRequest()->attributes->get('exception')) {
      $this->notFound('Exception отсутствует в запросе');
    }

    $code = $e->getStatusCode();
    if (404 == $code) {
      $title = 'Страница не найдена!';
    } elseif (403 == $code) {
      $title = 'Доступ запрещен!';
    } else {
      $title = 'Ошибка!';
    }

    $p = new Page();
    $p->setTitle($title);
    if (DEVMODE) {
      $p->setText($e->getMessage());
    }

    return Response::create($p, $code, $e->getHeaders());
  }
}