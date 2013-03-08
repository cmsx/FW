<?php

/** Настройка подключения к БД **/
X::AddConnection('localhost', 'cmsx', 'qwerty', 'cmsx', 'utf8');

/** Префикс к таблицам в БД */
define ('PREFIX', 'cmsx_');

/** Режим разработчика - вывод ошибок PHP + расширенная информация при отображении Exception */
define ('DEVMODE', true);