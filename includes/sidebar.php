<?php
function showVar()
{
    echo "<pre>";
    print_r($_SERVER['REQUEST_URI']);
    echo "</pre>";
}
showvar();
?>


<!--Admin-->
<aside>
    <img src="../assets/images/logo_optispace.png" class="w-32 h-auto" alt="Logo da aplicação">
    <ul>
        <li><a href="../dashboard/index.php"><i class="fa-solid fa-chart-simple <?php echo isActive('/dashboard/'); ?>"></i> Dashboard</a></li>
        <li><a href="../dashboard/index.php"><i class="fa-solid fa-briefcase <?php echo isActive('/recursos/'); ?>"></i> Gestão de recursos</a></li>
        <li><a href="../reservas/index.php"><i class="fa-solid fa-desktop <?php echo isActive('/reservas/'); ?>"></i> Reservas</a></li>
        <li><a href="../utilizadores/index.php"><i class="fa-solid fa-chart-simple <?php echo isActive('/utilizadores/'); ?>"></i> Gestão de utilizadores</a></li>
        <li><a href="../definicoes/index.php"><i class="fa-solid fa-chart-simple <?php echo isActive('/definicoes/'); ?>"></i> Definições</a></li>
    </ul>
</aside>

<!--User-->
<aside>
    <img src="../assets/images/logo_optispace.png" alt="Logo da aplicação">
    <ul>
        <li><a href="/dashboard/index.php"><i class="fa-solid fa-chart-simple <?php echo isActive('/dashboard/'); ?>"></i> Dashboard</a></li>
        <li><a href="../reservas/index.php"><i class="fa-solid fa-desktop <?php echo isActive('/reservas/'); ?>"></i> Reservas</a></li>
        <li><a href="../definicoes/index.php"><i class="fa-solid fa-chart-simple <?php echo isActive('/definicoes/'); ?>"></i> Definições</a></li>
    </ul>
</aside>