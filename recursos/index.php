<?php
include_once '../includes/functions.php';
require_once "../config/config.php";
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
            <section class="mt-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-semibold">Gestão de Recursos</h3>

                    <!-- Botão verde para adicionar -->
                    <a href="criar.php"
                        class="bg-primary-dark hover:bg-primary-dark text-white w-10 h-10 rounded-full flex items-center justify-center text-2xl font-light shadow-lg transition-colors">+</a>
                </div>

                <!-- Abas de filtro -->
                <div class="flex gap-3 mb-6">
                    <button class="px-6 py-2 rounded-full border border-primary-dark bg-primary-dark text-white text-sm font-normal cursor-pointer transition-all tab-btn" data-filter="salas">
                        Salas
                    </button>
                    <button class="px-6 py-2 rounded-full border border-primary-dark text-primary-dark text-sm font-normal cursor-pointer transition-all tab-btn" data-filter="equipamentos">
                        Equipamentos
                    </button>
                    <button class="px-6 py-2 rounded-full border border-primary-dark text-primary-dark text-sm font-normal cursor-pointer transition-all tab-btn" data-filter="viaturas">
                        Viaturas
                    </button>
                </div>

                <!-- Container dos cards -->
                <div id="cardsContainer" class="flex flex-col sm:flex-row justify-start gap-8 flex-wrap bg-red-300">
                    <!-- Cards de Salas -->
                    <div class="card-dashboard card-item" data-category="salas">
                        <div class="leading-tight">
                            <h4 class="text-base font-semibold text-black-800 mb-1">Sala 1</h4>
                            <p class="text-base font-semibold text-black-600 mb-2">12 lugares</p>
                            <p class="text-base font-semibold text-black-500">Projetor, computador</p>
                        </div>
                    </div>

                    <div class="card-dashboard card-item" data-category="salas">
                        <div class="leading-tight">
                            <h4 class="text-base font-semibold text-black-800 mb-1">Sala 2</h4>
                            <p class="text-base font-semibold text-black-600 mb-2">10 lugares</p>
                            <p class="text-base font-semibold text-black-500">Projetor, computador</p>
                        </div>
                    </div>

                    <div class="card-dashboard card-item" data-category="salas">
                        <div class="leading-tight">
                            <h4 class="text-base font-semibold text-black-800 mb-1">Sala 3</h4>
                            <p class="text-base font-semibold text-black-600 mb-2">6 lugares</p>
                            <p class="text-base font-semibold text-black-500">Projetor, computador</p>
                        </div>
                    </div>

                    <!-- Cards de Equipamentos (inicialmente ocultos) -->
                     <?php render_equipamentos_portatil_card($_SESSION['user_id'])?>
                    <?php render_equipamentos_fixos_card($_SESSION['user_id'])?>
                    
                    <!-- Cards de Viaturas (inicialmente ocultos) -->
                     <?php render_viaturas_card($_SESSION['user_id']) ?>
                    
                </div>
            </section>
        </main>
    </div>

    <script>
        // Script para filtrar os cards
        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('.tab-btn');
            const cards = document.querySelectorAll('.card-item');

            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const filter = this.getAttribute('data-filter');

                    // Atualizar aba ativa
                    tabButtons.forEach(btn => {
                        btn.classList.remove('bg-primary-dark', 'text-white');
                        btn.classList.add('bg-transparent', 'text-primary-dark');
                    });
                    this.classList.remove('bg-transparent', 'text-primary-dark');
                    this.classList.add('bg-primary-dark', 'text-white');

                    // Filtrar cards
                    cards.forEach(card => {
                        if (card.getAttribute('data-category') === filter) {
                            card.classList.remove('hidden');
                        } else {
                            card.classList.add('hidden');
                        }
                    });
                });
            });
        });
    </script>

</body>