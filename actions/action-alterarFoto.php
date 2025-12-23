<?php
require_once "../config/database.php";
require_once "../config/config.php";
require_once "../includes/functions.php";

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: " . BASE_URL . "login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] !== UPLOAD_ERR_NO_FILE) {
        $user_id = $_SESSION['user_id'];
        
        // Validação 1: Verificar se o arquivo foi realmente enviado
        if ($_FILES['foto_perfil']['error'] !== UPLOAD_ERR_OK) {
            header("Location: " . BASE_URL . "definicoes/index.php?erro_foto=" . urlencode("Erro ao fazer upload da imagem. Tente novamente."));
            exit();
        }

        // Fazer upload da imagem usando a função existente
        $upload_result = upload_imagem($_FILES['foto_perfil'], '../uploads');
        
        if (!$upload_result['sucesso']) {
            // Se o upload falhou, redireciona com a mensagem de erro
            header("Location: " . BASE_URL . "definicoes/index.php?erro_foto=" . urlencode($upload_result['mensagem']));
            exit();
        }

        // Upload foi bem-sucedido, agora atualizar na base de dados
        $caminho_foto = $upload_result['caminho'];
        
        $db = new Database();
        $conn = $db->getConnection();

        // Buscar a foto atual do usuário para possível remoção posterior
        $stmt_buscar = $conn->prepare("SELECT foto_path FROM utilizadores WHERE id = :user_id");
        $stmt_buscar->bindParam(':user_id', $user_id);
        $stmt_buscar->execute();
        $usuario = $stmt_buscar->fetch(PDO::FETCH_ASSOC);
        
        $foto_antiga = $usuario['foto_path'] ?? null;

        // Atualizar a foto na base de dados
        $stmt_update = $conn->prepare("UPDATE utilizadores SET foto_path = :foto_path WHERE id = :user_id");
        $stmt_update->bindParam(':foto_path', $caminho_foto);
        $stmt_update->bindParam(':user_id', $user_id);

        if ($stmt_update->execute()) {
            // Opcional: Remover a foto antiga do servidor (se não for a default)
            if ($foto_antiga && $foto_antiga !== '../uploads/user-default.png' && file_exists('../uploads/' . $foto_antiga)) {
                @unlink('../uploads/' . $foto_antiga);
            }
            
            $db->closeConnection();
            $_SESSION['user_photo'] = $caminho_foto;
            header("Location: " . BASE_URL . "definicoes/index.php?sucesso_foto=" . urlencode("Foto do perfil alterada com sucesso!"));
            exit();
        } else {
            // Se falhou ao atualizar na BD, remover a foto que foi feita upload
            if (file_exists('../uploads/' . $caminho_foto)) {
                @unlink('../uploads/' . $caminho_foto);
            }
            
            $db->closeConnection();
            header("Location: " . BASE_URL . "definicoes/index.php?erro_foto=" . urlencode("Erro ao salvar a foto. Tente novamente."));
            exit();
        }

    } else {
        header("Location: " . BASE_URL . "definicoes/index.php?erro_foto=" . urlencode("Por favor, selecione uma imagem."));
        exit();
    }
} else {
    header("Location: " . BASE_URL . "definicoes/index.php");
    exit();
}
?>