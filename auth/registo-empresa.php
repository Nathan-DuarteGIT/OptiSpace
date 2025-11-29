<?php
require_once "../config/config.php";

// Capturar mensagens de erro
$erro = '';
if (isset($_GET['erro']) && !empty($_GET['erro'])) {
    $erro = htmlspecialchars($_GET['erro']);
}

// Manter os valores preenchidos em caso de erro
$name_admin = isset($_GET['name_admin']) ? htmlspecialchars($_GET['name_admin']) : '';
$name_empresa = isset($_GET['name_empresa']) ? htmlspecialchars($_GET['name_empresa']) : '';
$email = isset($_GET['email']) ? htmlspecialchars($_GET['email']) : '';
?>

<!DOCTYPE html>

<html lang="pt" class="h-screen w-screen">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/output.css">
    <link rel="shortcut icon" href="../assets/images/logo_optispace.ico" type="image/x-icon">
    <title>Registo Empresa</title>
</head>

<body class="bg-primary m-0 p-0 h-screen w-screen">
    <div class="flex flex-col md:flex-row h-full relative">
        <div class="left-section bg-primary-dark flex flex-col justify-between items-center flex-1 h-[40vh] md:h-screen relative order-2 md:order-1 relative z-0">
            <img src="../assets/images/logo_optispace_branca.png"
                alt="logo_OptiSpace"
                class="absolute top-4 md:top-6 left-4 md:left-8 w-20 md:w-28 h-auto">
            <img src="../assets/images/Saly-2.png"
                alt="Decoração"
                class="absolute left-1/2 md:left-[90px] top-1/2 -translate-x-1/2 md:translate-x-0 -translate-y-1/2 w-[200px] md:w-[350px] h-auto md:block">
        </div>

        <div class="right-section flex-1 flex justify-center items-center h-[40vh] md:h-screen relative bg-gray-50 order-3 relative z-0">
            <img src="../assets/images/computer_inicio.png"
                alt="Computer"
                class="absolute right-1/2 md:right-[100px] top-1/2 translate-x-1/2 md:translate-x-0 -translate-y-1/2 w-[180px] md:w-[375px] h-auto md:block">
        </div>

        <div class="form-container w-[90%] md:w-full max-w-md bg-white p-8 rounded-2xl shadow-xl absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-20">
            <form method="POST" action="../actions/action-register.php" class="space-y-6">
                <div class="text-left mb-6">
                    <h1 class="text-lg md:text-xl text-dark">Bem-vindo à OptiSpace</h1>
                    <h2 class="text-2xl md:text-3xl text-dark-600 mt-1">Entrar</h2>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Primeiro e Último Nome do Admin</label>
                    <input type="text" name="name_admin" required placeholder="Primeiro e Último Nome"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-dark focus:border-transparent transition">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nome da Empresa</label>
                    <input type="text" name="name_empresa" required placeholder="Nome da Empresa"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-dark focus:border-transparent transition">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Insira o Email do Admin</label>
                    <input type="email" name="email" required placeholder="Email"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-dark focus:border-transparent transition">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Insira a sua Palavra-passe</label>
                    <input type="password" name="password" required placeholder="Palavra-passe"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-dark focus:border-transparent transition">
                </div>

                <button type="submit" class="w-full bg-primary-dark_green text-white py-3 rounded-lg font-semibold text-lg hover:bg-primary-dark/90 transition">Registar</button>

                <div class="links absolute top-3 md:top-6 right-3 md:right-6 text-xs md:text-sm text-gray-600 bg-white/80 backdrop-blur-sm px-2 md:px-3 py-1 rounded-md">
                    <span>Já tem conta? </span><br>
                    <a href="login.php" class="text-primary-dark font-semibold hover:underline">Entrar</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('registerForm');
            const hasError = <?php echo !empty($erro) ? 'true' : 'false'; ?>;

            // Se houver erro, focar no primeiro campo
            if (hasError) {
                const firstInput = form.querySelector('input');
                if (firstInput) {
                    firstInput.focus();
                }
            }

            form.addEventListener('submit', function(e) {
                const nameAdmin = document.querySelector('input[name="name_admin"]').value.trim();
                const nameEmpresa = document.querySelector('input[name="name_empresa"]').value.trim();
                const email = document.querySelector('input[name="email"]').value.trim();
                const password = document.querySelector('input[name="password"]').value;

                // Validar campos vazios
                if (!nameAdmin || !nameEmpresa || !email || !password) {
                    e.preventDefault();
                    showError('Por favor, preencha todos os campos.');
                    return false;
                }

                // Validar nome completo (pelo menos 2 palavras)
                if (nameAdmin.split(' ').filter(n => n.length > 0).length < 2) {
                    e.preventDefault();
                    showError('Por favor, insira o primeiro e último nome.');
                    return false;
                }

                // Validar email
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    e.preventDefault();
                    showError('Por favor, insira um email válido.');
                    return false;
                }

                // Validar palavra-passe (mínimo 6 caracteres)
                if (password.length < 6) {
                    e.preventDefault();
                    showError('A palavra-passe deve ter no mínimo 6 caracteres.');
                    return false;
                }
            });

            function showError(message) {
                // Remover erro anterior se existir
                const oldError = document.querySelector('.error-message-js');
                if (oldError) {
                    oldError.remove();
                }

                // Criar nova mensagem de erro
                const errorDiv = document.createElement('div');
                errorDiv.className = 'error-message-js bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-4 text-left';
                errorDiv.innerHTML = '<strong class="font-bold">Erro: </strong><span class="block sm:inline">' + message + '</span>';

                // Inserir antes do primeiro campo
                const firstDiv = form.querySelector('div');
                firstDiv.parentNode.insertBefore(errorDiv, firstDiv.nextSibling);

                // Scroll para o erro
                errorDiv.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }
        });
    </script>
</body>

</html>