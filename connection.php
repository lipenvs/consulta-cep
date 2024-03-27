<?php
try {
  $pdo = new PDO('mysql:host=localhost;dbname=cadastro_enderecos', 'root', '');
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo "Erro na conexão: " . $e->getMessage();
}
