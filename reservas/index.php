<?php
include_once '../includes/functions.php';
require_once "../config/config.php";
$file_path = '../assets/js/reservas.js';
$version = filemtime($file_path);
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
    <title>Reservas</title>
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
            <section class="mt-8">
                <h3 class="text-2xl font-semibold mb-6 text-black">Reservas</h3>

                <!-- Container dos cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-x-0 gap-y-6">
                    <!-- card criar reserva -->
                    <a href="criar.php"
                        class="card-dashboard flex flex-col items-center justify-center hover:bg-gray-50 hover:shadow-xl transition-all duration-200 cursor-pointer group">
                        <h4 class="text-lg font-bold text-black group-hover:text-indigo-600 transition-colors">Criar Reserva</h4>
                    </a>

                    <?php render_reservas_empresa_cards($_SESSION['user_id']) ?>
                </div>
            </section>

            <!-- Modal de Confirmação com PIN (inicialmente escondido) -->
            <div id="confirm-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center hidden z-50">
                <div class="p-8 border w-full max-w-md shadow-lg rounded-md bg-white">
                    <div class="text-center">
                        <h3 class="text-2xl font-bold text-gray-900">Confirmar Reserva</h3>

                        <p class="text-sm text-gray-500 mt-2">
                            Enviamos um PIN para o seu e-mail. Por favor, insira-o abaixo para confirmar a sua reserva.
                        </p>

                        <!-- Formulário de Confirmação -->
                        <form action="../actions/action-confirmarReserva.php" method="post">
                            <div class="mt-4">
                                <input type="hidden" id="id_reserva_no_modal" name="id_reserva" value="">
                                <input
                                    type="text"
                                    id="pin-input"
                                    name="pin_confirmacao"
                                    placeholder="Digite o PIN"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md text-center"
                                    maxlength="6">
                                <!-- Mensagem de erro -->
                                <p id="pin-error" class="text-red-500 text-xs mt-1 hidden">PIN inválido ou expirado.</p>
                            </div>

                            <div class="mt-6 flex justify-center gap-4">
                                <button type="button" onclick="fecharModal('confirm-modal')" id="close-confirm-modal" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400">
                                    Fechar
                                </button>
                                <button type="submit" id="submit-pin-btn" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
                                    Confirmar Reserva
                                </button>
                        </form>
                    </div>
                </div>
            </div>
    </div>

    <!-- Modal de Erro (inicialmente escondido) -->
    <div id="error-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center hidden z-50">
        <div class="p-8 border w-full max-w-md shadow-lg rounded-md bg-white">
            <div class="text-center">
                <h3 class="text-2xl font-bold text-red-600">Erro de Confirmação</h3>
                <p id="error-message" class="text-sm text-gray-500 mt-2">
                    <!-- Mensagem de erro será inserida aqui pelo JS -->
                </p>
                <div class="mt-6 flex justify-center">
                    <button type="button" onclick="handleErrorOk()" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">
                        OK
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Cancelamento (inicialmente escondido) -->
    <div id="cancel-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center hidden z-50">
        <div class="p-8 border w-full max-w-md shadow-lg rounded-md bg-white">
            <div class="text-center">
                <h3 class="text-2xl font-bold text-gray-900">Atenção!</h3>
                <p class="text-sm text-gray-500 mt-2">
                    Tem certeza que deseja cancelar esta reserva? Esta ação não pode ser desfeita.
                </p>
                <form action="../actions/action-cancelarReserva.php" method="post">
                    <input type="hidden" id="id_reserva_cancelar" name="id_reserva" value="">
                    <div class="mt-6 flex justify-center gap-4">
                        <button type="button" onclick="fecharModal('cancel-modal')" id="close-cancel-modal" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400">
                            Não, manter reserva
                        </button>
                        <button type="submit" id="confirm-cancel-btn" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">
                            Sim, cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    </main>
    </div>
    <script src="<?= $file_path ?>?v=<?= $version ?>"></script>
    <?php
    $erro_pin = '';
    if (isset($_GET['erro_pin'])) {
        $erro_pin = htmlspecialchars($_GET['erro_pin']);
    }
    ?>
    <script>
        // Variável para armazenar a mensagem de erro do PHP
        const pinErrorMessage = "<?= $erro_pin ?>";

        // Função para abrir o modal de erro
        function openErrorModal(message) {
            document.getElementById('error-message').innerText = message;
            document.getElementById('error-modal').classList.remove('hidden');
        }

        // Função para fechar o modal de erro e reabrir o modal de PIN
        function handleErrorOk() {
            document.getElementById('error-modal').classList.add('hidden');
            // Reabre o modal de confirmação do PIN
            document.getElementById('confirm-modal').classList.remove('hidden');
        }

        // Lógica para verificar se houve um erro de PIN após o redirecionamento
        if (pinErrorMessage) {
            // Oculta o modal de PIN (se estiver visível) e mostra o modal de erro
            document.getElementById('confirm-modal').classList.add('hidden');
            openErrorModal(pinErrorMessage);

            // Remove o parâmetro da URL para evitar que o modal reapareça em um refresh
            if (window.history.replaceState) {
                const url = new URL(window.location.href);
                url.searchParams.delete('erro_pin');
                window.history.replaceState({
                    path: url.href
                }, '', url.href);
            }
        }
    </script>
</body>

</html>