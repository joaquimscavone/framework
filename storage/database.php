<?php

// Verifica se o script está sendo executado via linha de comando
if (php_sapi_name() !== 'cli') {
    die("Este script só pode ser executado via linha de comando.\n");
}

// Verifica se o arquivo SQL foi passado como argumento
if ($argc !== 2) {
    die("Uso: php database.php <caminho_para_arquivo.sql>\n");
}

// Obtém o caminho do arquivo SQL a partir dos argumentos
$sqlFile = $argv[1];

// Verifica se o arquivo SQL existe
if (!file_exists($sqlFile)) {
    die("Arquivo não encontrado: $sqlFile\n");
}

// Lê o conteúdo do arquivo SQL
$sqlContent = file_get_contents($sqlFile);

// Configurações de conexão ao banco de dados (modificar conforme necessário)
$host = 'localhost';
$username = 'root';
$password = '';
$charset = 'utf8mb4';

try {
    // Conectando ao servidor MySQL
    $pdo = new PDO("mysql:host=$host;charset=$charset", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Executa o SQL lido do arquivo
    $pdo->exec($sqlContent);

    echo "Script SQL executado com sucesso!\n";
} catch (PDOException $e) {
    die("Erro ao executar SQL: " . $e->getMessage() . "\n");
}

