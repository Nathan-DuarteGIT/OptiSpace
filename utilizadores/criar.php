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
            <div class="w-full max-w-md">
                <h3 class="text-2xl font-semibold mb-6 text-black">Criar Utilizador</h3>
                <!-- Card do formulário -->
                <div class="rounded-2xl px-8 py-10">
                    <form action="" method="post" class="space-y-8">
                        <!-- Nome -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nome do Utilizador</label>
                            <input type="text" name="name" placeholder="Nome do utilizador" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            </div>
                        </div>

                        <!-- Email do utilizador  -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email do Utilizador</label>
                            <input type="email" name="email" placeholder="Email do utilizador" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            </div>
                        </div>

                        <!-- Palavra-passe -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Palavra-passe do Utilizador</label>
                            <input type="password" name="palavra_passe" placeholder="Palavra-passe do utilizador" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                            </input>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            </div>
                        </div>

                        <div class="pt-6">
                            <button type="submit"
                                class="w-full bg-primary-dark_green hover:bg-primary-600 text-white font-medium py-4 rounded-xl transition duration-200 shadow-lg hover:shadow-xl">
                                Criar Utilizador
                            </button>
                        </div>
                    </form>
                </div>
        </main>
    </div>
</body>

</html>