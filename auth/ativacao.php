<?php
require_once "../config/config.php";
$file_css = '../assets/css/output.css';
$versioncss = filemtime($file_css);

// Capturar o email do GET ou da SESSION
$email = '';
if (isset($_GET['email']) && !empty($_GET['email'])) {
    $email = htmlspecialchars($_GET['email']);
}

// Capturar mensagem de erro se existir e limpar da URL
$erro = '';
if (isset($_GET['erro']) && !empty($_GET['erro'])) {
    $erro = htmlspecialchars($_GET['erro']);

    // Redirecionar para limpar a URL (só mantém o email)
    if (isset($_GET['email'])) {
        echo "<script>
            if (window.history.replaceState) {
                window.history.replaceState(null, null, '?email=" . urlencode($_GET['email']) . "');
            }
        </script>";
    }
}

// Se não houver email, redirecionar ou mostrar erro
if (empty($email)) {
    header("Location: " . BASE_URL . "auth/login.php?erro=" . urlencode("Email não fornecido."));
    exit();
}
?>
<!DOCTYPE html>

<html lang="pt" class="h-screen w-screen">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/output.css?v=<?= $versioncss ?>">
    <link rel="shortcut icon" href="../assets/images/logo_optispace.ico" type="image/x-icon">
    <title>Ativação</title>
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
    </div>

    <div class="form-container w-[90%] md:w-full max-w-md bg-white p-8 rounded-2xl shadow-xl absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-20">
        <form method="POST" action="../actions/action-ativate.php?<?php echo !empty($email) ? 'email=' . urlencode($email) : ''; ?>" class="space-y-6 text-center" id="activationForm">
            <div class="text-left mb-6">
                <h1 class="text-lg md:text-xl text-dark">Bem-vindo à OptiSpace</h1>
                <h2 class="text-2xl md:text-3xl text-dark-600 mt-1">Ative a sua conta</h2>
            </div>

            <?php if (!empty($erro)): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-4 text-left" role="alert">
                    <strong class="font-bold">Erro: </strong>
                    <span class="block sm:inline"><?php echo $erro; ?></span>
                </div>
            <?php endif; ?>

            <div class="flex justify-center gap-6 mb-6">
                <input type="text" name="digit1" maxlength="1"
                    class="input-activation w-10 h-10 md:w-10 md:h-10 text-center text-xl font-semibold border-2 border-gray-300 rounded-lg focus:border-primary-dark focus:ring-2 focus:ring-primary-dark transition" required>
                <input type="text" name="digit2" maxlength="1"
                    class="input-activation w-10 h-10 md:w-10 md:h-10 text-center text-xl font-semibold border-2 border-gray-300 rounded-lg focus:border-primary-dark focus:ring-2 focus:ring-primary-dark transition" required>
                <input type="text" name="digit3" maxlength="1"
                    class="input-activation w-10 h-10 md:w-10 md:h-10 text-center text-xl font-semibold border-2 border-gray-300 rounded-lg focus:border-primary-dark focus:ring-2 focus:ring-primary-dark transition" required>
                <input type="text" name="digit4" maxlength="1"
                    class="input-activation w-10 h-10 md:w-10 md:h-10 text-center text-xl font-semibold border-2 border-gray-300 rounded-lg focus:border-primary-dark focus:ring-2 focus:ring-primary-dark transition" required>
                <input type="text" name="digit5" maxlength="1"
                    class="input-activation w-10 h-10 md:w-10 md:h-10 text-center text-xl font-semibold border-2 border-gray-300 rounded-lg focus:border-primary-dark focus:ring-2 focus:ring-primary-dark transition" required>
                <input type="text" name="digit6" maxlength="1"
                    class="input-activation w-10 h-10 md:w-10 md:h-10 text-center text-xl font-semibold border-2 border-gray-300 rounded-lg focus:border-primary-dark focus:ring-2 focus:ring-primary-dark transition" required>
            </div>

            <button type="submit"
                class="w-full bg-primary-dark_green text-white py-3 rounded-lg font-semibold text-lg hover:bg-primary-dark/90 transition">
                Ativar
            </button>

            <div class="absolute top-3 md:top-6 right-3 md:right-6 text-xs md:text-sm text-gray-600 bg-white/80 backdrop-blur-sm px-2 md:px-3 py-1 rounded-md">
                <span>Já tem conta? </span><br>
                <a href="login.php" class="text-primary-dark font-semibold hover:underline">Entrar</a>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.input-activation');
            const form = document.getElementById('activationForm');
            const hasError = <?php echo !empty($erro) ? 'true' : 'false'; ?>;

            // SEMPRE limpar todos os campos ao carregar a página se houver erro
            if (hasError) {
                inputs.forEach(input => {
                    input.value = '';
                });
                // Focar no primeiro campo
                if (inputs[0]) {
                    inputs[0].focus();
                }
            }

            inputs.forEach((input, index) => {
                // Focar no primeiro campo ao carregar 
                if (index === 0 && !hasError) {
                    input.focus();
                }

                // Avançar automaticamente para o próximo campo
                input.addEventListener('input', function() {
                    // Permitir apenas números
                    this.value = this.value.replace(/[^0-9]/g, '');

                    if (this.value.length === 1 && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }

                    // Se for o último campo e estiver preenchido, submeter automaticamente
                    if (index === inputs.length - 1 && this.value.length === 1) {
                        // Verificar se todos os campos estão preenchidos
                        let allFilled = true;
                        inputs.forEach(inp => {
                            if (inp.value.length === 0) {
                                allFilled = false;
                            }
                        });

                        if (allFilled) {
                            // Submeter automaticamente após breve delay
                            setTimeout(() => {
                                form.submit();
                            }, 300);
                        }
                    }
                });

                // Permitir voltar com backspace
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Backspace') {
                        if (this.value === '' && index > 0) {
                            inputs[index - 1].focus();
                            inputs[index - 1].value = '';
                        }
                    }
                });

                // Permitir colar código completo
                input.addEventListener('paste', function(e) {
                    e.preventDefault();
                    const pasteData = e.clipboardData.getData('text').replace(/[^0-9]/g, '');

                    if (pasteData.length >= 6) {
                        inputs.forEach((inp, i) => {
                            inp.value = pasteData[i] || '';
                        });
                        inputs[5].focus();

                        // Submeter automaticamente após colar ou preencher tudos os campos
                        setTimeout(() => {
                            form.submit();
                        }, 300);
                    }
                });
            });
        });
    </script>
</body>

</html>