<?php
include_once '../includes/functions.php';
require_once "../config/config.php";
$file_css = '../assets/css/output.css';
$versioncss = filemtime($file_css);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/output.css?v=<?= $versioncss ?>">
    <link rel="shortcut icon" href="../assets/images/logo_optispace.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Definições - OptiSpace</title>
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

                <!-- Mensagem de Sucesso -->
                <?php if (isset($_GET['sucesso_senha'])): ?>
                    <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded" role="alert">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            <span><?php echo htmlspecialchars($_GET['sucesso_senha']); ?></span>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Mensagem de Erro -->
                <?php if (isset($_GET['erro_senha'])): ?>
                    <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded" role="alert">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            <span><?php echo htmlspecialchars($_GET['erro_senha']); ?></span>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Mensagem de Sucesso - Foto -->
                <?php if (isset($_GET['sucesso_foto'])): ?>
                    <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded" role="alert">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            <span><?php echo htmlspecialchars($_GET['sucesso_foto']); ?></span>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Mensagem de Erro - Foto -->
                <?php if (isset($_GET['erro_foto'])): ?>
                    <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded" role="alert">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            <span><?php echo htmlspecialchars($_GET['erro_foto']); ?></span>
                        </div>
                    </div>
                <?php endif; ?>

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

            <form method="post" action="<?php echo BASE_URL; ?>../actions/action-alterarSenha.php" class="space-y-4" id="formAlterarSenha">
                <!-- Nova senha -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nova Senha <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input
                            type="password"
                            name="nova_senha"
                            id="nova_senha"
                            placeholder="Digite a nova senha (mínimo 6 caracteres)"
                            required
                            minlength="6"
                            class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-dark_green focus:border-transparent outline-none transition bg-white pr-10">
                        <button
                            type="button"
                            onclick="togglePassword('nova_senha')"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                            <i class="fas fa-eye" id="icon_nova_senha"></i>
                        </button>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">A senha deve ter no mínimo 6 caracteres</p>
                </div>

                <!-- Confirmar nova senha -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Confirmar Nova Senha <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input
                            type="password"
                            name="confirmar_senha"
                            id="confirmar_senha"
                            placeholder="Confirme a nova senha"
                            required
                            minlength="6"
                            class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-dark_green focus:border-transparent outline-none transition bg-white pr-10">
                        <button
                            type="button"
                            onclick="togglePassword('confirmar_senha')"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                            <i class="fas fa-eye" id="icon_confirmar_senha"></i>
                        </button>
                    </div>
                </div>

                <!-- Mensagem de erro de validação client-side -->
                <div id="erro_validacao" class="hidden bg-red-100 border border-red-400 text-red-700 px-3 py-2 rounded text-sm">
                    <span id="mensagem_erro"></span>
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

            <form method="post" action="../actions/action-alterarFoto.php" enctype="multipart/form-data" class="space-y-4" id="formAlterarFoto">
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

            // Limpar mensagens de erro ao fechar
            if (modalId === 'modalSenha') {
                document.getElementById('erro_validacao').classList.add('hidden');
                document.getElementById('formAlterarSenha').reset();
            }

            if (modalId === 'modalFoto') {
                document.getElementById('formAlterarFoto').reset();
                document.getElementById('imagePreview').classList.add('hidden');
            }
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

        // Função para mostrar/ocultar senha
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById('icon_' + inputId);

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Validação client-side do formulário
        document.getElementById('formAlterarSenha').addEventListener('submit', function(e) {
            const novaSenha = document.getElementById('nova_senha').value;
            const confirmarSenha = document.getElementById('confirmar_senha').value;
            const erroDiv = document.getElementById('erro_validacao');
            const mensagemErro = document.getElementById('mensagem_erro');

            // Limpar erros anteriores
            erroDiv.classList.add('hidden');

            // Validar comprimento mínimo
            if (novaSenha.length < 6) {
                e.preventDefault();
                mensagemErro.textContent = 'A nova senha deve ter no mínimo 6 caracteres.';
                erroDiv.classList.remove('hidden');
                return false;
            }

            // Validar se as senhas coincidem
            if (novaSenha !== confirmarSenha) {
                e.preventDefault();
                mensagemErro.textContent = 'A nova senha e a confirmação não coincidem.';
                erroDiv.classList.remove('hidden');
                return false;
            }

            return true;
        });

        // Feedback visual em tempo real
        document.getElementById('confirmar_senha').addEventListener('input', function() {
            const novaSenha = document.getElementById('nova_senha').value;
            const confirmarSenha = this.value;

            if (confirmarSenha.length > 0) {
                if (novaSenha === confirmarSenha) {
                    this.classList.remove('border-red-500');
                    this.classList.add('border-green-500');
                } else {
                    this.classList.remove('border-green-500');
                    this.classList.add('border-red-500');
                }
            } else {
                this.classList.remove('border-red-500', 'border-green-500');
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

        // Auto-fechar mensagens de sucesso/erro após 5 segundos
        window.addEventListener('DOMContentLoaded', function() {
            const alertas = document.querySelectorAll('[role="alert"]');
            alertas.forEach(function(alerta) {
                setTimeout(function() {
                    alerta.style.transition = 'opacity 0.5s';
                    alerta.style.opacity = '0';
                    setTimeout(function() {
                        alerta.remove();
                    }, 500);
                }, 5000);
            });
        });
    </script>
</body>

</html>