<?php
require_once "../config/config.php";
$file_css = '../assets/css/output.css';
$versioncss = filemtime($file_css);

$erro = '';
if (isset($_SESSION['erro_registo'])) {
    $erro = htmlspecialchars($_SESSION['erro_registo']);
    unset($_SESSION['erro_registo']);
}

$name_admin = '';
$name_empresa = '';
$email = '';
if (isset($_SESSION['form_data'])) {
    $name_admin = htmlspecialchars($_SESSION['form_data']['name_admin'] ?? '');
    $name_empresa = htmlspecialchars($_SESSION['form_data']['name_empresa'] ?? '');
    $email = htmlspecialchars($_SESSION['form_data']['email'] ?? '');
    unset($_SESSION['form_data']);
}
?>

<!DOCTYPE html>

<html lang="pt" class="h-screen w-screen">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/output.css?v=<?= $versioncss ?>">
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
            <form method="POST" action="../actions/action-register.php" class="space-y-6" id="registerForm">
                <div class="text-left mb-6">
                    <h1 class="text-lg md:text-xl text-dark">Bem-vindo à OptiSpace</h1>
                    <h2 class="text-2xl md:text-3xl text-dark-600 mt-1">Entrar</h2>
                </div>

                <?php if (!empty($erro)): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-4 text-left" role="alert">
                        <strong class="font-bold">Erro: </strong>
                        <span class="block sm:inline"><?php echo $erro; ?></span>
                    </div>
                <?php endif; ?>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Primeiro e Último Nome do Admin</label>
                    <input type="text"
                        name="name_admin"
                        required
                        placeholder="Primeiro e Último Nome"
                        value="<?php echo $name_admin; ?>"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-dark focus:border-transparent transition">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nome da Empresa</label>
                    <input type="text"
                        name="name_empresa"
                        required
                        placeholder="Nome da Empresa"
                        value="<?php echo $name_empresa; ?>"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-dark focus:border-transparent transition">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Insira o Email do Admin</label>
                    <input type="email"
                        name="email"
                        required
                        placeholder="exemplo@email.com"
                        value="<?php echo $email; ?>"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-dark focus:border-transparent transition">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Insira a sua Palavra-passe</label>
                    <div class="relative">
                        <input type="password"
                            name="password"
                            id="register_password"
                            required
                            placeholder="Mínimo 6 caracteres"
                            minlength="6"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-dark focus:border-transparent transition pr-10">
                        <button
                            type="button"
                            onclick="togglePassword('register_password')"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 p-1">

                            <!-- Ícone de Olho Aberto (Visível por padrão) -->
                            <svg id="icon_register_password_open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>

                            <!-- Ícone de Olho Fechado (Oculto por padrão) -->
                            <svg id="icon_register_password_closed" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hidden">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12c0 2.21.574 4.257 1.543 6.114M10.125 10.5h.008v.008h-.008v-.008Zm2.25 0h.008v.008h-.008v-.008Zm2.25 0h.008v.008h-.008v-.008Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 18.375L12 12M12 12L5.625 5.625" />
                            </svg>
                        </button>
                    </div>
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
        function togglePassword(fieldId) {
            const passwordField = document.getElementById(fieldId);
            const iconOpen = document.getElementById('icon_' + fieldId + '_open');
            const iconClosed = document.getElementById('icon_' + fieldId + '_closed');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                iconOpen.classList.add('hidden');
                iconClosed.classList.remove('hidden');
            } else {
                passwordField.type = 'password';
                iconOpen.classList.remove('hidden');
                iconClosed.classList.add('hidden');
            }
        }

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