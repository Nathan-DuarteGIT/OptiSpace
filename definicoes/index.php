<?php
include_once '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nova_senha']) && isset($_POST['confirmar_senha'])) {
    } elseif (isset($_FILES['foto_perfil'])) {
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/output.css">
    <link rel="shortcut icon" href="../assets/images/logo_optispace.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Document</title>
</head>

<body class="bg-primary font-sans text-gray-900 min-h-screen flex">
    <!-- Sidebar fixa à esquerda -->
    <?php include '../includes/sidebar.php'; ?>

    <!-- Conteúdo principal ocupa o resto -->
    <div class="flex-1 flex flex-col">
        <!-- Header no topo -->
        <?php include '../includes/header.php'; ?>
        <!-- Conteúdo principal -->
        <main class="flex-1 p-8">
            <div class="w-full max-w-xs">
                <h3 class="text-2xl font-semibold mb-6 text-black">Definições</h3>
                <!-- Botões de Definições -->
                <div class="space-y-4">
                    <!-- Botão Alterar senha -->
                    <button
                        onclick="openModal('modalSenha')"
                        class="w-full bg-white hover:bg-gray-50 text-left px-6 py-4 rounded-lg shadow-sm transition-colors duration-200 font-medium text-gray-900">
                        Alterar senha
                    </button>

                    <!-- Botão Alterar foto do perfil -->
                    <button
                        onclick="openModal('modalFoto')"
                        class="w-full bg-white hover:bg-gray-50 text-left px-6 py-4 rounded-lg shadow-sm transition-colors duration-200 font-medium text-gray-900">
                        Alterar foto do perfil
                    </button>

                    <!-- Botão Ajuda -->
                    <a
                        href="ajuda.php"
                        class="block w-full bg-white hover:bg-gray-50 text-left px-6 py-4 rounded-lg shadow-sm transition-colors duration-200 font-medium text-gray-900">
                        Ajuda
                    </a>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal Alterar Senha -->
    <div id="modalSenha" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl p-8 w-full max-w-md mx-4">
            <h4 class="text-xl font-semibold mb-6 text-gray-900">Alterar Senha</h4>

            <form method="post" class="space-y-4">
                <!-- Nova senha -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nova Senha</label>
                    <input
                        type="password"
                        name="nova_senha"
                        placeholder="Digite a nova senha"
                        required
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-dark_green focus:border-transparent outline-none transition bg-white">
                </div>

                <!-- Confirmar nova senha -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Confirmar Nova Senha</label>
                    <input
                        type="password"
                        name="confirmar_senha"
                        placeholder="Confirme a nova senha"
                        required
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-dark_green focus:border-transparent outline-none transition bg-white">
                </div>

                <!-- Botões -->
                <div class="flex gap-3 pt-4">
                    <button
                        type="button"
                        onclick="closeModal('modalSenha')"
                        class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-3 rounded-lg transition duration-200">
                        Cancelar
                    </button>
                    <button
                        type="submit"
                        class="flex-1 bg-primary-dark_green hover:bg-opacity-90 text-white font-medium py-3 rounded-lg transition duration-200">
                        Alterar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Alterar Foto -->
    <div id="modalFoto" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl p-8 w-full max-w-md mx-4">
            <h4 class="text-xl font-semibold mb-6 text-gray-900">Alterar Foto do Perfil</h4>

            <form method="post" enctype="multipart/form-data" class="space-y-4">
                <!-- Upload de foto -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Selecionar Foto</label>
                    <div class="relative">
                        <input
                            type="file"
                            name="foto_perfil"
                            accept="image/*"
                            required
                            id="fileInput"
                            class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-dark_green focus:border-transparent outline-none transition bg-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-primary-dark_green file:text-white hover:file:bg-opacity-90">
                    </div>
                    <p class="mt-2 text-xs text-gray-500">Formatos aceitos: JPG, PNG, GIF (máx. 5MB)</p>
                </div>

                <!-- Preview da imagem -->
                <div id="imagePreview" class="hidden mt-4">
                    <img id="preview" src="" alt="Preview" class="w-32 h-32 rounded-full object-cover mx-auto border-2 border-gray-200">
                </div>

                <!-- Botões -->
                <div class="flex gap-3 pt-4">
                    <button
                        type="button"
                        onclick="closeModal('modalFoto')"
                        class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium py-3 rounded-lg transition duration-200">
                        Cancelar
                    </button>
                    <button
                        type="submit"
                        class="flex-1 bg-primary-dark_green hover:bg-opacity-90 text-white font-medium py-3 rounded-lg transition duration-200">
                        Carregar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Funções para abrir e fechar modais
        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Fechar modal ao clicar fora
        document.getElementById('modalSenha').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal('modalSenha');
            }
        });

        document.getElementById('modalFoto').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal('modalFoto');
            }
        });

        // Preview da imagem selecionada
        document.getElementById('fileInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview').src = e.target.result;
                    document.getElementById('imagePreview').classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        });
    </script>