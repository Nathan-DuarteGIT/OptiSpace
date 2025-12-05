<?php
    require_once "../config/database.php";
    require_once "../config/config.php";

    if($_SERVER['REQUEST_METHOD']==='POST'){
        if(isset($_POST['nome_recurso'], $_POST['tipo_recurso'])) {
            $nome_recurso = $_POST['nome_recurso'];
            $tipo_recurso = $_POST['tipo_recurso'];

            if($tipo_recurso === 'sala'){
                

            }else if($tipo_recurso === 'equipamento'){
                if(isset($_POST['tipo_equipamento'])) {
                    $tipo_equipamento = $_POST['tipo_equipamento'];
                    
                    $stmt = $pdo->prepare("INSERT INTO recursos (nome, tipo, sub_tipo) VALUES (:nome, :tipo, :sub_tipo)");
                    $stmt->bindParam(':nome', $nome_recurso);
                    $stmt->bindParam(':tipo', $tipo_recurso);
                    $stmt->bindParam(':sub_tipo', $tipo_equipamento);
                    
                    if($stmt->execute()) {
                        header("Location: " . BASE_URL . "recursos/index.php?sucesso=" . urlencode("Recurso criado com sucesso."));
                        exit();
                    } else {
                        header("Location: " . BASE_URL . "recursos/criar.php?erro_db=" . urlencode("Erro ao criar recurso. Tente novamente."));
                        exit();
                    }
                } else {
                    header("Location: " . BASE_URL . "recursos/criar.php?erro_campos=" . urlencode("Por favor, selecione o tipo de equipamento."));
                    exit();
                }
            }else if($tipo_recurso === 'viatura'){

            }
        } else {
            header("Location: " . BASE_URL . "recursos/criar.php?erro_campos=" . urlencode("Por favor, preencha todos os campos obrigatórios."));
            exit();
        }
    } else {
        header("Location: " . BASE_URL . "recursos/criar.php");
        exit();
    }