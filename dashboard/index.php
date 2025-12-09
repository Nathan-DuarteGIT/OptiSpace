<?php
include_once '../includes/functions.php';
require_once "../config/config.php";
?>

<!DOCTYPE html>

<html lang="pt" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/output.css">
    <link rel="shortcut icon" href="../assets/images/logo_optispace.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Dashboard</title>
</head>

<?php if ($_SESSION['nivel_acesso'] == 'admin'): ?>

    <body class="bg-primary font-sans text-gray-900 min-h-screen flex flex-col lg:flex-row">
        <!-- Sidebar fixa à esquerda -->
        <?php include '../includes/sidebar.php'; ?>

        <!-- Conteúdo principal ocupa o resto -->
        <div class="flex-1 flex flex-col w-full lg:w-auto overflow-x-hidden">
            <!-- Header no topo -->
            <?php include '../includes/header.php'; ?>

            <!-- Conteúdo principal -->
            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                <section class="mt-4 sm:mt-6 lg:mt-8">
                    <h3 class="text-xl sm:text-2xl font-semibold mb-4 sm:mb-6">Dashboard</h3>

                    <!-- Container dos cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8">

                        <!-- Card: Salas -->
                        <div class="card-dashboard">
                            <div class="leading-tight flex-1">
                                <h4 class="text-sm sm:text-base font-medium text-gray-700">Salas</h4>
                                <p id="salas" class="text-lg sm:text-xl font-black text-gray-900 mt-1"><?php echo contar_salas($_SESSION['user_id']) ?></p>
                            </div>
                            <img src="../assets/images/salas.png" alt="Salas" class="w-8 sm:w-10 h-auto ml-2 flex-shrink-0">
                        </div>

                        <!-- Card: Equipamentos -->
                        <div class="card-dashboard">
                            <div class="leading-tight flex-1">
                                <h4 class="text-sm sm:text-base font-medium text-gray-700">Equipamentos</h4>
                                <p id="equipamentos" class="text-lg sm:text-xl font-black text-gray-900 mt-1"><?php echo contar_equipamentos($_SESSION['user_id']) ?></p>
                            </div>
                            <img src="../assets/images/equipamentos.png" alt="Equipamentos" class="w-8 sm:w-10 h-auto ml-2 flex-shrink-0">
                        </div>

                        <!-- Card: Viaturas -->
                        <div class="card-dashboard">
                            <div class="leading-tight flex-1">
                                <h4 class="text-sm sm:text-base font-medium text-gray-700">Viaturas</h4>
                                <p id="viaturas" class="text-lg sm:text-xl font-black text-gray-900 mt-1"><?php echo contar_viaturas($_SESSION['user_id']) ?></p>
                            </div>
                            <img src="../assets/images/viaturas.png" alt="Viaturas" class="w-8 sm:w-10 h-auto ml-2 flex-shrink-0">
                        </div>

                    </div>
                </section>
            </main>
        </div><!-- Conteúdo principal ocupa o resto -->
    </body>
<?php else: ?>

    <body class="bg-primary font-sans text-gray-900 min-h-screen flex flex-col lg:flex-row">
        <!-- Sidebar fixa à esquerda -->
        <?php include '../includes/sidebar.php'; ?>

        <!-- Conteúdo principal ocupa o resto -->
        <div class="flex-1 flex flex-col w-full lg:w-auto overflow-x-hidden">
            <!-- Header no topo -->
            <?php include '../includes/header.php'; ?>

            <!-- Conteúdo principal -->
            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                <section class="mt-4 sm:mt-6 lg:mt-8">
                    <h3 class="text-xl sm:text-2xl font-semibold mb-4 sm:mb-6">Dashboard</h3>

                    <!-- Container dos cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8">

                        <!-- Card: Salas -->
                        <div class="card-dashboard">
                            <div class="leading-tight flex-1">
                                <h4 class="text-sm sm:text-base font-medium text-gray-700">Salas</h4>
                                <p id="salas" class="text-lg sm:text-xl font-black text-gray-900 mt-1">0</p>
                            </div>
                            <img src="../assets/images/salas.png" alt="Salas" class="w-8 sm:w-10 h-auto ml-2 flex-shrink-0">
                        </div>

                        <!-- Card: Equipamentos -->
                        <div class="card-dashboard">
                            <div class="leading-tight flex-1">
                                <h4 class="text-sm sm:text-base font-medium text-gray-700">Equipamentos</h4>
                                <p id="equipamentos" class="text-lg sm:text-xl font-black text-gray-900 mt-1">0</p>
                            </div>
                            <img src="../assets/images/equipamentos.png" alt="Equipamentos" class="w-8 sm:w-10 h-auto ml-2 flex-shrink-0">
                        </div>

                        <!-- Card: Viaturas -->
                        <div class="card-dashboard">
                            <div class="leading-tight flex-1">
                                <h4 class="text-sm sm:text-base font-medium text-gray-700">Viaturas</h4>
                                <p id="viaturas" class="text-lg sm:text-xl font-black text-gray-900 mt-1">0</p>
                            </div>
                            <img src="../assets/images/viaturas.png" alt="Viaturas" class="w-8 sm:w-10 h-auto ml-2 flex-shrink-0">
                        </div>

                    </div>
                </section>
            </main>
        </div>
    </body>
<?php endif; ?>