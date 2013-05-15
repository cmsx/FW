<?php

require_once __DIR__ . '/../inc/init.php';

use CMSx\EventListener;
use CMSx\ControllerResolver;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\EventDispatcher\EventDispatcher;

// Создаем объект Request
$request = Request::createFromGlobals();

// Диспетчер событий
$dispatcher = new EventDispatcher();

// Добавляем слушателя событий системы
$dispatcher->addSubscriber(new EventListener());

// Класс, находящий контроллер по URL
$resolver = new ControllerResolver(DIR_CTRL);

// Ядро преобразует запрос в ответ
$kernel = new HttpKernel($dispatcher, $resolver);

// Обрабатываем запрос
$response = $kernel->handle($request);

// Возвращаем результат
$response->send();

// Выполняем отложенные задачи, если они есть
$kernel->terminate($request, $response);