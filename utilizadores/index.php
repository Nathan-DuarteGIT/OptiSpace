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
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-100">
                                <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider w-3/5">Name</th>
                                <th class="text-left pl-0 pr-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">User Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            <!-- Utilizador 1 -->
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 w-3/5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center flex-shrink-0">
                                            <i class="fa-solid fa-user text-indigo-600 text-sm"></i>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900 text-sm">Sonia Almeida</div>
                                            <div class="text-gray-500 text-xs">sonia.almeida@optispace.pt</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="pl-0 pr-6 py-4">
                                    <span class="inline-flex items-center gap-1 text-sm">
                                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-600"></span>
                                        <span class="text-indigo-600 font-medium">Active</span>
                                    </span>
                                </td>
                            </tr>

                            <!-- Utilizador 2 -->
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center flex-shrink-0">
                                            <i class="fa-solid fa-user text-indigo-600 text-sm"></i>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900 text-sm">Nathan Duarte</div>
                                            <div class="text-gray-500 text-xs">nathan.duarte@optispace.pt</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="pl-0 pr-6 py-4">
                                    <span class="inline-flex items-center gap-1 text-sm">
                                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-600"></span>
                                        <span class="text-indigo-600 font-medium">Active</span>
                                    </span>
                                </td>
                            </tr>

                            <!-- Utilizador 3 -->
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center flex-shrink-0">
                                            <i class="fa-solid fa-user text-indigo-600 text-sm"></i>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900 text-sm">Andrea Rego</div>
                                            <div class="text-gray-500 text-xs">andrea.regoa@optispace.pt</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="pl-0 pr-6 py-4">
                                    <span class="inline-flex items-center gap-1 text-sm">
                                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-600"></span>
                                        <span class="text-indigo-600 font-medium">Active</span>
                                    </span>
                                </td>
                            </tr>

                            <!-- Utilizador 4 -->
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center flex-shrink-0">
                                            <i class="fa-solid fa-user text-indigo-600 text-sm"></i>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900 text-sm">Jorge Oliveira</div>
                                            <div class="text-gray-500 text-xs">jorge.oliveira@optispace.pt</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="pl-0 pr-6 py-4">
                                    <span class="inline-flex items-center gap-1 text-sm">
                                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-600"></span>
                                        <span class="text-indigo-600 font-medium">Active</span>
                                    </span>
                                </td>
                            </tr>

                            <!-- Utilizador 5 -->
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center flex-shrink-0">
                                            <i class="fa-solid fa-user text-indigo-600 text-sm"></i>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900 text-sm">Mira Herwitz</div>
                                            <div class="text-gray-500 text-xs">mira.herwitz@optispace.pt</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="pl-0 pr-6 py-4">
                                    <span class="inline-flex items-center gap-1 text-sm">
                                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-600"></span>
                                        <span class="text-indigo-600 font-medium">Active</span>
                                    </span>
                                </td>
                            </tr>

                            <!-- Utilizador 6 -->
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center flex-shrink-0">
                                            <i class="fa-solid fa-user text-indigo-600 text-sm"></i>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900 text-sm">Ines Gomes</div>
                                            <div class="text-gray-500 text-xs">ines.gomes@optispace.pt</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="pl-0 pr-6 py-4">
                                    <span class="inline-flex items-center gap-1 text-sm">
                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                        <span class="text-gray-600 font-medium">Inactive</span>
                                    </span>
                                </td>
                            </tr>

                            <!-- Utilizador 7 -->
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center flex-shrink-0">
                                            <i class="fa-solid fa-user text-indigo-600 text-sm"></i>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900 text-sm">João Marques</div>
                                            <div class="text-gray-500 text-xs">joao.marques@optispace.pt</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="pl-0 pr-6 py-4">
                                    <span class="inline-flex items-center gap-1 text-sm">
                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                        <span class="text-gray-600 font-medium">Inactive</span>
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>

</html>