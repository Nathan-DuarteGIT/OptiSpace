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
        </main>
    </div>
</body>

</html>