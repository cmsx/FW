<?php

require_once __DIR__ . '/../inc/init.php';

use CMSx\Router;

$r = new Router(null, DIR_CTRL);
$r->enableDebug(DEVMODE);
$r->process();