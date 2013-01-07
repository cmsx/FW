<?php

/** Автолодер Composer */
require_once __DIR__ . '/../vendor/autoload.php';
/** Константы */
require_once __DIR__ . '/const.php';
/** Пути к папкам в системе */
require_once __DIR__ . '/paths.php';
/** Настройка доступа в БД, префикс, режим отладки */
require_once __DIR__ . '/config.php';

/** Вывод ошибок */
if (DEVMODE) {
  ini_set('error_level', E_ALL);
  ini_set('display_errors', true);
} else {
  ini_set('display_errors', false);
}

/** Настройки шаблонизатора */
\CMSx\Template::SetPath(DIR_TMPL);
\CMSx\Template::EnableDebug(DEVMODE);

/** Задаем префикс для запросов в БД */
\CMSx\DB::SetPrefix(PREFIX);