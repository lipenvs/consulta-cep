<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
  require_once('connection.php');

  $id = $_POST["id"];

  $stmt = $pdo->prepare("DELETE FROM enderecos WHERE id = ?");
  $stmt->execute([$id]);

  if ($stmt->rowCount() > 0) {
    echo json_encode(["success" => true]);
    exit;
  }
}

echo json_encode(["success" => false]);
