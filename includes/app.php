<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Utils\View;
use WilliamCosta\DatabaseManager\Database;
use WilliamCosta\DotEnv\Environment;
use WilliamCosta\DatabaseManager\Databe;

/** Carrega variáveis de ambiente */
Environment::load(__DIR__ . '/../');

/** Define as configurações de banco de dados */
Database::config(
    getenv('DB_HOST'),
    getenv('DB_NAME'),
    getenv('DB_USER'),
    getenv('DB_PASS'),
    getenv('DB_PORT')
);

/** Definir o seu localhost */
define('URL', getenv('URL'));

/** Definir o valor padrão das variáveis */
View::init([
    'URL' => URL,
]);
