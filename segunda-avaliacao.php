<?php
require_once('connection.php');

$orderBy = isset($_GET['orderby']) ? $_GET['orderby'] : 'id';
$order = isset($_GET['order']) ? $_GET['order'] : 'asc';

$results = $pdo->query("SELECT * FROM enderecos ORDER BY $orderBy $order")->fetchAll();

include_once('layout/_header.php');
?>

<!-- Lista de Links -->
<ul class="navbar-nav d-flex flex-row gap-4">
  <li class="nav-item">
    <a class="nav-link" href="index.php">Início</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="ex1.php">Algoritmos</a>
  </li>
  <li class="nav-item">
    <a class="nav-link active" href="segunda-avaliacao.php">Sistema Web</a>
  </li>
</ul>
</div>
</nav>

<main class="container mt-5">

  <main class="container mt-5 full-height">
    <div class="d-flex flex-row justify-content-between">
      <h1 class="title">Consulta CEP</h1>
      <a href="./ex1.php" class="custom-button2">
        <img alt="UltraLIMS Logo" src="./assets/github-logo.png" width="25" />
        <div class="custom-row2">
          <span class="title">Github do Projeto</span>
          <span class="material-symbols-outlined">
            arrow_right_alt
          </span>
        </div>
      </a>
    </div>

    <div class="card mt-5">
      <div class="card-body">
        <div class="row">
          <div class="col-md-3 mb-3">
            <input type="text" class="form-control" id="cep" name="cep" placeholder="Digite o CEP">
          </div>
          <div class="col-md-1">
            <button onclick="consultarCep()" class="btn btn-primary">Consultar</button>
          </div>
        </div>

        <!-- Alerta de sucesso ou erro -->
        <div id="alertMessage" class="mt-3"></div>

        <table class="table table-hover mt-3">
          <thead>
            <tr>
              <th>CEP</th>
              <th>Logradouro</th>
              <th><a href="?orderby=bairro&order=<?= ($orderBy == 'bairro' && $order == 'asc') ? 'desc' : 'asc' ?>" class="sortable <?= ($orderBy == 'bairro') ? 'dir-' . $order : '' ?>">Bairro</a></th>
              <th><a href="?orderby=cidade&order=<?= ($orderBy == 'cidade' && $order == 'asc') ? 'desc' : 'asc' ?>" class="sortable <?= ($orderBy == 'cidade') ? 'dir-' . $order : '' ?>">Cidade</a></th>
              <th><a href="?orderby=estado&order=<?= ($orderBy == 'estado' && $order == 'asc') ? 'desc' : 'asc' ?>" class="sortable <?= ($orderBy == 'estado') ? 'dir-' . $order : '' ?>">Estado</a></th>
              <th></th>
            </tr>

          </thead>
          <tbody>
            <?php foreach ($results as $item) : ?>
              <tr>
                <td><?= $item['cep'] ?></td>
                <td><?= $item['logradouro'] ?></td>
                <td><?= $item['bairro'] ?></td>
                <td><?= $item['cidade'] ?></td>
                <td><?= $item['estado'] ?></td>
                <td>
                  <a href="#" onclick="deleteCep(<?= $item['id'] ?>)"><span class="material-symbols-outlined" style="color: #E42222">
                      delete
                    </span></a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </main>

  <!-- Modal de exclusão de CEP -->
  <div class="modal fade" id="deleteCepModal" tabindex="-1" aria-labelledby="deleteCepModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteCepModalLabel">Excluir CEP</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Tem certeza de que deseja excluir este CEP?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Excluir</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    function consultarCep() {
      var cep = $('#cep').val();
      $.ajax({
        url: 'add_cep.php',
        method: 'POST',
        data: {
          cep: cep
        },
        success: function(response) {
          var data = JSON.parse(response);
          if (data.success) {
            showSuccessAlert(data.message);
            setTimeout(function() {
              window.location.reload();
            }, 1000);
          } else {
            showErrorAlert(data.message);
          }
        },
        error: function() {
          showErrorAlert('Erro ao consultar o CEP.');
        }
      });
    }

    function deleteCep(id) {
      $('#deleteCepModal').modal('show');
      $('#confirmDeleteBtn').unbind().click(function() {
        $.ajax({
          url: 'delete_cep.php',
          method: 'POST',
          data: {
            id: id
          },
          success: function(response) {
            $('#deleteCepModal').modal('hide');
            showSuccessAlert('CEP excluído com sucesso.');
            setTimeout(function() {
              window.location.reload();
            }, 1000);
          },
          error: function() {
            showErrorAlert('Erro de conexão.');
          }
        });
      });
    }

    function showSuccessAlert(message) {
      $('#alertMessage').html('<div class="alert alert-success" role="alert">' + message + '</div>');
    }

    function showErrorAlert(message) {
      $('#alertMessage').html('<div class="alert alert-danger" role="alert">' + message + '</div>');
    }
  </script>

  <?php include_once('layout/_footer.php'); ?>