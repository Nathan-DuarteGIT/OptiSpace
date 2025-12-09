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
            <h3 class="text-2xl font-semibold mb-6 text-black">Gestão de Utilizadores</h3>

            <!-- Botão criar utilizador -->
            <div class="mb-6 flex justify-end">
                <a
                    href="criar.php"
                    class="w-8 h-8 bg-primary-dark_green hover:bg-opacity-90 text-white rounded-full flex items-center justify-center transition-colors shadow-sm">
                    <i class="fa-solid fa-plus text-sm"></i>
                </a>
            </div>

            <!-- Campo de pesquisa -->
            <div class="mb-6 flex items-center justify-between">
                <div class="relative flex-1 max-w-md">
                    <i class="fa-solid fa-magnifying-glass absolute left-4 top-4 text-gray-300 text-xs pointer-events-none"></i>
                    <input
                        type="text"
                        placeholder="Busque utilizadores por nome ou email"
                        class="w-full pl-11 pr-4 py-3 text-sm border border-gray-50 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-dark_green focus:border-transparent bg-white shadow-sm">
                </div>
            </div>

            <!-- Container principal -->
            <div class="bg rounded-lg shadow-sm">
                <!-- Tabela de utilizadores -->
                <div class="overflow-x-auto">
                    <?php buscar_utilizadores($_SESSION['user_id']) ?>
                </div>
            </div>
        </main>
    </div>
</body>

</html>