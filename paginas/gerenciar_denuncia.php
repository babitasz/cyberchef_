<?php
include '../processos/inicializar_banco.php';
session_start();

// Verificar se é administrador
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
header('Location: login.php');
exit;
}


$denuncias = $pdo->query("SELECT Denuncia.*, Receita.titulo AS receita_titulo, usuarios.nome AS denunciante_nome FROM Denuncia JOIN Receita ON Denuncia.fk_id_receita = Receita.id_receita JOIN usuarios ON Denuncia.fk_id_usuario = usuarios.id")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Administrativa - Gerenciar Receitas</title>
    <link rel="stylesheet" href="../css/style_home.css">
</head>
<body class="admin-home-page">
    <header>
        <nav class="navHeader">
            <a href="index.html" id="link-logo" title="Página inicial">
            <img src="../css/img/cyber_chef_logo.png" alt="logo" id="logo">
            </a>
            <div class="search-container">
            <!-- Omitir funcionalidades de pesquisa se não forem relevantes -->
            </div>
            <ul id="lista">
                <li>
                <a class="linksHeader" href="gerenciar_denuncia.php">GERENCIAR RECEITAS</a>
                </li>
                <li>
                <a class="linksHeader" href="home_admin.php">GERENCIAR USUÁRIOS</a>
                </li>
            </ul>
            <div class="user">Bem-vindo, Admin!</div>
            <a href="../processos/logout.php" alt="Sair" title="Sair">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#FFF" version="1.1" id="Capa_1" width="25px" height="25px" viewBox="0 0 492.5 492.5" xml:space="preserve">
                    <g>
                        <path d="M184.646,0v21.72H99.704v433.358h31.403V53.123h53.539V492.5l208.15-37.422v-61.235V37.5L184.646,0z M222.938,263.129   c-6.997,0-12.67-7.381-12.67-16.486c0-9.104,5.673-16.485,12.67-16.485s12.67,7.381,12.67,16.485   C235.608,255.748,229.935,263.129,222.938,263.129z"/>
                    </g>
                </svg>
            </a>
            <a href="../processos/logout.php" alt="Sair" title="Sair">
                <!-- Ícone de sair -->
            </a>
        </nav>
    </header>
    <main class="main-home">
        <h1>ADMINISTRAÇÃO DO CYBER CHEF</h1>
        <section class="user-list">
            <h2>Receitas Denunciadas</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID Denúncia</th>
                        <th>Motivo</th>
                        <th>Receita</th>
                        <th>Denunciante</th>
                        <th>Data Denúncia</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($denuncias as $denuncia): ?>
                    <tr>
                        <td><?= htmlspecialchars($denuncia['id_denuncia']); ?></td>
                        <td><?= htmlspecialchars($denuncia['motivo']); ?></td>
                        <td><?= htmlspecialchars($denuncia['receita_titulo']); ?></td>
                        <td><?= htmlspecialchars($denuncia['denunciante_nome']); ?></td>
                        <td><?= htmlspecialchars($denuncia['data_denuncia']); ?></td>
                        <td>
                            <a href="../processos/excluir_denuncia.php?id=<?= $denuncia['id_denuncia']; ?>" class="editar-btn" onclick="return confirm('Tem certeza que deseja excluir esta denúncia?')">Excluir Denúncia</a>
                            <a href="../processos/excluir_receita.php?id=<?= $denuncia['fk_id_receita']; ?>" class="excluir-btn" onclick="return confirm('Tem certeza que deseja excluir esta receita?')">Excluir Receita</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>


