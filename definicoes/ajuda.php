<?php
include_once '../includes/functions.php';
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
            <h3 class="text-2xl font-semibold mb-6 text-black">Ajuda</h3>

            <div class="max-w-4xl mx-auto">
                <h4 class="text-3xl font-semibold mb-2 text-gray-900">Ajuda e Suporte - Optispace</h4>
                <p class="text-lg text-gray-600 mb-8">Guia rápido para gerir os seus recursos de forma eficiente.</p>

                <section class="mb-8">
                    <h4 class="text-2xl font-semibold mb-4 text-gray-900">Bem-vindo à Ajuda da Optispace</h4>
                    <p class="text-gray-700 mb-4">
                        A Optispace é a sua ferramenta para gerir recursos partilhados de forma simples e inteligente.
                        Aqui encontrará guias passo a passo para as principais funcionalidades. Se tiver dúvidas,
                        consulte a secção de Perguntas Frequentes ou contacte-nos.
                    </p>
                </section>

                <section class="mb-8">
                    <h4 class="text-2xl font-semibold mb-4 text-gray-900">Reservas com Otimização de Espaço</h4>
                    <p class="text-gray-700 mb-4">
                        Reserve salas de reunião, recursos móveis e viaturas de forma rápida e eficiente.
                        O sistema sugere automaticamente a melhor opção com base nas suas necessidades.
                    </p>

                    <h4 class="text-xl font-semibold mb-3 text-gray-900">Como usar:</h4>
                    <ol class="list-decimal list-inside space-y-2 text-gray-700 mb-4 ml-4">
                        <li>Aceda à secção "Reservas" no menu principal.</li>
                        <li>Selecione a data e hora pretendida.</li>
                        <li>Indique o número de participantes e equipamentos necessários (ex.: projetor, videoconferência).</li>
                        <li>O sistema verifica a disponibilidade em tempo real, integrada com os calendários dos colaboradores, e sugere a sala mais adequada.</li>
                        <li>Para reservas de recursos e viaturas, procure o item desejado (ex.: MacBook Air).</li>
                        <li>O sistema exibirá os recursos disponíveis para a data e horário selecionados anteriormente.</li>
                        <li>Confirme a reserva e receba uma confirmação por e-mail.</li>
                        <li>No momento do uso, registe o check-in e check-out através de código PIN para um rastreio preciso.</li>
                        <li>Receba notificações sobre devoluções pendentes.</li>
                    </ol>

                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-4">
                        <p class="text-blue-900">
                            <strong>Dica:</strong> Integre o seu calendário Google ou Outlook para evitar conflitos automáticos.
                        </p>
                    </div>
                </section>

                <section class="mb-8">
                    <h4 class="text-2xl font-semibold mb-4 text-gray-900">Regras Inteligentes</h4>
                    <p class="text-gray-700 mb-4">
                        O sistema gere reservas de forma autónoma para maximizar a disponibilidade.
                    </p>

                    <h4 class="text-xl font-semibold mb-3 text-gray-900">Como funciona:</h4>
                    <ul class="list-disc list-inside space-y-2 text-gray-700 mb-4 ml-4">
                        <li>Se não fizer check-in na sala nos primeiros 15 minutos, a reserva é libertada automaticamente.</li>
                        <li>Receberá um lembrete 5 minutos antes do fim do prazo.</li>
                        <li>Isso evita "reservas fantasma" e torna os recursos disponíveis para outros utilizadores.</li>
                    </ul>

                    <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 mb-4">
                        <p class="text-yellow-900">
                            <strong>Atenção:</strong> Faça sempre check-in para manter a sua reserva ativa.
                        </p>
                    </div>
                </section>

                <section class="mb-8">
                    <h4 class="text-2xl font-semibold mb-4 text-gray-900">Perguntas Frequentes</h4>

                    <div class="space-y-4">
                        <div>
                            <h4 class="text-lg font-semibold mb-2 text-gray-900">Posso cancelar uma reserva?</h4>
                            <p class="text-gray-700">
                                Sim, cancele até 1 hora antes sem penalizações através do dashboard.
                            </p>
                        </div>

                        <div>
                            <h4 class="text-lg font-semibold mb-2 text-gray-900">Como integro com o meu calendário?</h4>
                            <p class="text-gray-700">
                                Nas definições da conta, ative a sincronização com Google ou Outlook.
                            </p>
                        </div>

                        <div>
                            <h4 class="text-lg font-semibold mb-2 text-gray-900">O que fazer se um equipamento estiver indisponível?</h4>
                            <p class="text-gray-700">
                                Reporte o problema na secção de suporte para actualização imediata.
                            </p>
                        </div>
                    </div>
                </section>

                <section class="bg-primary-dark_green text-white rounded-lg p-6">
                    <h4 class="text-2xl font-semibold mb-4">Precisa de Mais Ajuda?</h4>
                    <p class="mb-4">Contacte a nossa equipa de suporte:</p>
                    <ul class="space-y-2">
                        <li><strong>E-mail:</strong> info@optispace.pt</li>
                        <li><strong>Telefone:</strong> +351 987 654 321</li>
                        <li><strong>Horário:</strong> Segunda a Sexta, 9h-18h</li>
                    </ul>
                </section>
            </div>
        </main>
    </div>
</body>

</html>