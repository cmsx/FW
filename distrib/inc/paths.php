<?php

/** Основная папка с движком */
define ('DIR_ROOT', realpath(__DIR__ . '/../'));
/** Папка с классами приложения */
define ('DIR_APP', DIR_ROOT . '/app');
/** Папка с классами приложения */
define ('DIR_WEB', DIR_ROOT . '/web');
/** Папка с контроллерами */
define ('DIR_CTRL', DIR_ROOT . '/ctrl');
/** Папка с шаблонами */
define ('DIR_TMPL', DIR_ROOT . '/tmpl');
/** Папка с тестами */
define ('DIR_TEST', DIR_ROOT . '/tests');
/** Папка с временными файлами и кешем */
define ('DIR_TEMP', DIR_ROOT . '/temp');
/** Путь к изображениям на сайте - /files */
define ('DIR_FILES', '/files');
/** Папка с изображениями */
define ('DIR_FILES_PATH', DIR_WEB . DIR_FILES);