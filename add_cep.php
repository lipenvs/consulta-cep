<?php
require_once "connection.php";

$response = [];

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["cep"])) {
  $cep = str_replace('-', '', $_POST["cep"]);

  if (preg_match('/^[0-9]{8}$/', $cep)) {
    $stmt = $pdo->prepare("SELECT COUNT(*) AS count FROM enderecos WHERE cep = :cep");
    $stmt->execute([':cep' => $_POST["cep"]]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result['count'] > 0) {
      $response['success'] = false;
      $response['message'] = "Este CEP já está cadastrado.";
    } else {
      $url = "https://viacep.com.br/ws/$cep/json/";
      $response_api = file_get_contents($url);
      $data = json_decode($response_api);

      if (!isset($data->erro)) {
        $sql = "INSERT INTO enderecos (cep, logradouro, bairro, cidade, estado) VALUES (:cep, :logradouro, :bairro, :cidade, :estado)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
          ':cep' => $data->cep,
          ':logradouro' => $data->logradouro,
          ':bairro' => $data->bairro,
          ':cidade' => $data->localidade,
          ':estado' => $data->uf
        ]);

        $response['success'] = true;
        $response['message'] = "Endereço adicionado ao banco de dados com sucesso!";
      } else {
        $response['success'] = false;
        $response['message'] = "CEP não encontrado.";
      }
    }
  } else {
    $response['success'] = false;
    $response['message'] = "Formato de CEP inválido. O CEP deve conter 8 dígitos.";
  }
}

echo json_encode($response);
