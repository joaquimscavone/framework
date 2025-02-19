<?php

defined('APPLICATION_PATH')             || define('APPLICATION_PATH', realpath(__DIR__ . "/../.."));
defined('APP_PATH')                     || define('APP_PATH', APPLICATION_PATH . DIRECTORY_SEPARATOR . "app");
defined('VIEWS_PATH')                   || define('VIEWS_PATH', APP_PATH . DIRECTORY_SEPARATOR . 'Views');
defined('VIEWS_EXT')                    || define('VIEWS_EXT', '.view.php');
defined('TEMPLATES_EXT')                || define('TEMPLATES_EXT', '.template.php');
defined('TEMPLATES_PATH')               || define('TEMPLATES_PATH', APP_PATH . DIRECTORY_SEPARATOR . 'Templates');
defined('COMPONENTS_PATH')              || define('COMPONENTS_PATH', VIEWS_PATH . DIRECTORY_SEPARATOR . 'Components');
defined('CONFIGS_PATH')                 || define('CONFIGS_PATH', APP_PATH . DIRECTORY_SEPARATOR . 'Configs');
defined('ROUTES_PATH')                  || define('ROUTES_PATH', APP_PATH . DIRECTORY_SEPARATOR . 'Routes');
defined('RULES_FMK')                    || define('RULES_FMK', '\\Fmk\Rules\\');
