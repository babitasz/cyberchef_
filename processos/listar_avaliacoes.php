<?php
include_once '../processos/inicializar_banco.php';

if (!$conn) {  
    die("Falha na conexão: " . mysqli_connect_error());
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Avaliações</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/style_avaliacao.css">
</head>
<body>
    
    <h1>Avaliações dos Usuários</h1>

    <?php
        $query_avaliacoes = "SELECT a.id_avaliacao, a.qtde_estrelas, a.mensagem, a.created, u.id AS id_usuario FROM avaliacao AS a INNER JOIN usuarios AS u ON a.fk_id_usuario = u.id ORDER BY a.id_avaliacao DESC";
        $result_avaliacoes = $conn->prepare($query_avaliacoes);
        $result_avaliacoes->execute();

        if ($result_avaliacoes->rowCount() > 0) {  // Verificação de resultados
            while ($row_avaliacao = $result_avaliacoes->fetch(PDO::FETCH_ASSOC)) {
                extract($row_avaliacao);
                echo "<p>Avaliação feita por: $id_usuario <br> $created </p>";

                for ($i = 1; $i <= 5; $i++) {
                    if ($i <= $qtde_estrelas) {
                        echo '<i class="estrela-preenchida fa-solid fa-star"></i>';
                    } else {
                        echo '<i class="estrela-vazia fa-solid fa-star"></i>';
                    }
                }

                echo "<p>Comentário: $mensagem</p><br><hr>";
            }
        } else {
            echo "<p>Não há avaliações cadastradas.</p>"; 
        }
    ?>

</body>
</html>
