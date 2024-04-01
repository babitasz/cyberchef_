<?php

session_start();

include_once '../processos/inicializar_banco.php';

//definir fuso
date_default_timezone_set('America/Sao_Paulo');

// verificar se selecionou estrela
try {
  if (!empty($_POST['estrela'])) {
    $estrela = (int) filter_input(INPUT_POST, 'estrela', FILTER_DEFAULT); // Cast to integer
    $mensagem = filter_input(INPUT_POST, 'mensagem', FILTER_DEFAULT);

    // Recuperar ID do usuário da sessão
    $id_usuario = $_SESSION['usuario_id'];

    // CADASTRAR NO BANCO
    $query_avaliacoes = "INSERT INTO avaliacao (qtde_estrelas, mensagem, created, fk_id_usuario) VALUES (:qtde_estrelas, :mensagem, :created, :fk_id_usuario)";

    $cad_avaliacoes = $pdo->prepare($query_avaliacoes);

    $cad_avaliacoes->bindParam(':qtde_estrelas', $estrela, PDO::PARAM_INT);
    $cad_avaliacoes->bindParam(':mensagem', $mensagem, PDO::PARAM_STR);
    $created = date('Y-m-d H:i:s');
    $cad_avaliacoes->bindParam(':created', $created, PDO::PARAM_STR);
    $cad_avaliacoes->bindParam(':fk_id_usuario', $id_usuario, PDO::PARAM_INT); 


    if ($cad_avaliacoes->execute()) {
      header("Location: ../paginas/avaliar.php");
      $_SESSION['msg'] = "<p>Avaliação cadastrada com sucesso.</p>";
    } else {
      throw new PDOException("Erro ao cadastrar avaliação.");
    }
  } else {
    throw new PDOException("Erro: é necessário selecionar pelo menos 1 estrela.");
  }
} catch (PDOException $e) {
  $_SESSION['msg'] = "<p>Erro: " . $e->getMessage() . "</p>";
  header("Location: ../paginas/avaliar.php");
}

?>