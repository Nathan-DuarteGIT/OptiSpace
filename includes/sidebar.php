<!--Admin-->
<?php if($_SESSION['nivel_acesso'] == 'admin'):?>
    <aside class="w-64 flex flex-col justify-between items-center px-4 py-6 border-r-2 border-r-[#DDDDDD]">
        <div class="flex flex-col items-center">
            <img src="../assets/images/logo_optispace.png" class="w-32 h-auto" alt="Logo da aplicação">
            <ul>
                <li><a href="../dashboard/index.php" class="<?php echo isActive('/dashboard/'); ?>"><i class="fa-solid fa-chart-simple"></i> Dashboard</a></li>
                <li><a href="../recursos/index.php" class="<?php echo isActive('/recursos/'); ?>"><i class="fa-solid fa-briefcase"></i> Gestão de recursos</a></li>
                <li><a href="../reservas/index.php" class="<?php echo isActive('/reservas/'); ?>"><i class="fa-solid fa-desktop"></i> Reservas</a></li>
                <li><a href="../utilizadores/index.php" class="<?php echo isActive('/utilizadores/'); ?>"><i class="fa-solid fa-users"></i> Gestão de utilizadores</a></li>
                <li><a href="../definicoes/index.php" class="<?php echo isActive('/definicoes/'); ?>"><i class="fa-solid fa-gear"></i> Definições</a></li>
            </ul>
        </div>
        <a href="../index.php"><button class="text-red-500"><i class="fa-solid fa-arrow-right-from-bracket text-red-500"></i>Sair</button></a>
    </aside>
<?php else: ?>
<!--User-->
    <aside class="w-64 flex flex-col justify-between items-center px-4 py-6 border-r-2 border-r-[#DDDDDD]">
        <div class="flex flex-col items-center">
            <img src="../assets/images/logo_optispace.png" class="w-32 h-auto" alt="Logo da aplicação">
            <ul>
                <li><a href="../dashboard/index.php" class="<?php echo isActive('/dashboard/'); ?>"><i class="fa-solid fa-chart-simple"></i> Dashboard</a></li>
                <li><a href="../reservas/index.php" class="<?php echo isActive('/reservas/'); ?>"><i class="fa-solid fa-desktop"></i> Reservas</a></li>
                <li><a href="../definicoes/index.php" class="<?php echo isActive('/definicoes/'); ?>"><i class="fa-solid fa-gear"></i> Definições</a></li>
            </ul>
        </div>
        <a href="../actions/action-logout.php"><button class="text-red-500"><i class="fa-solid fa-arrow-right-from-bracket text-red-500"></i>Sair</button></a>
    </aside>
<?php endif; ?>