<?php
    require_once "../config/database.php";
    require_once "../config/config.php";
    require_once "../includes/functions.php";

    if($_SERVER['REQUEST_METHOD']==='POST'){
        if(isset($_POST['nome_recurso'], $_POST['tipo_recurso'])) {
            $nome_recurso = $_POST['nome_recurso'];
            $tipo_recurso = $_POST['tipo_recurso'];

            $db = new Database();
            $conn = $db->getConnection();

            if($tipo_recurso === 'sala'){
                

            }else if($tipo_recurso === 'equipamento'){
                $caminho_imagem = "../uploads/recurso-default.png";

                if(isset($_FILES['imagem_equipamento']) && $_FILES['imagem_equipamento']['error'] !== UPLOAD_ERR_NO_FILE) {
                    $upload_result = upload_imagem($_FILES['imagem_equipamento'], '../uploads');
                    if($upload_result['sucesso']) {
                        $caminho_imagem = $upload_result['caminho'];
                    } else {
                        header("Location: " . BASE_URL . "recursos/criar.php?erro_upload=" . urlencode($upload_result['mensagem']));
                        exit();
                    }
                }
                
                if(isset($_POST['tipo_equipamento'])) {
                    $tipo_equipamento = $_POST['tipo_equipamento'];
                    $empresa_id = buscar_empresa($_SESSION['user_id']);

                    $stmt = $conn->prepare("INSERT INTO equipamentos (empresa_id, nome, foto_path, tipoEquipamento) VALUES (:empresa_id, :nome, :caminho, :tipo)");
                    $stmt->bindParam(':empresa_id', $empresa_id);
                    $stmt->bindParam(':nome', $nome_recurso);
                    $stmt->bindParam(':caminho', $caminho_imagem);
                    $stmt->bindParam(':tipo', $tipo_equipamento);
                    
                    
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
                $caminho_imagem = "../uploads/viatura-default.png";

                if(isset($_FILES['imagem_viatura']) && $_FILES['imagem_equipamento']['error'] !== UPLOAD_ERR_NO_FILE) {
                    $upload_result = upload_imagem($_FILES['imagem_viatura'], '../uploads');
                    if($upload_result['sucesso']) {
                        $caminho_imagem = $upload_result['caminho'];
                    } else {
                        header("Location: " . BASE_URL . "recursos/criar.php?erro_upload=" . urlencode($upload_result['mensagem']));
                        exit();
                    }
                }

                if(isset($_POST['marca'], $_POST['modelo'], $_POST['matricula'])) {
                    $marca = $_POST['marca'];
                    $modelo = $_POST['modelo'];
                    $matricula = $_POST['matricula'];
                    $empresa_id = buscar_empresa($_SESSION['user_id']);

                    $stmt = $conn->prepare("INSERT INTO viaturas (empresa_id, nome, matricula, modelo, marca, foto_path) VALUES (:empresa_id, :nome, :matricula, :modelo, :marca, :caminho)");
                    $stmt->bindParam(':empresa_id', $empresa_id);
                    $stmt->bindParam(':nome', $nome_recurso);
                    $stmt->bindParam(':matricula', $matricula);
                    $stmt->bindParam(':modelo', $modelo);
                    $stmt->bindParam(':marca', $marca);
                    $stmt->bindParam(':caminho', $caminho_imagem);
                    
                    
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

            }

            $db->closeConnection();

        } else {
            header("Location: " . BASE_URL . "recursos/criar.php?erro_campos=" . urlencode("Por favor, preencha todos os campos obrigatórios."));
            exit();
        }

        
    } else {
        header("Location: " . BASE_URL . "recursos/criar.php");
        exit();
    }