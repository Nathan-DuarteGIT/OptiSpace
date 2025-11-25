<header class="flex justify-between items-center px-10 py-8 shadow-md">
    <h1 class="text-xl font-bold">Bem-vindo, <?php echo $_SESSION['user_name'] ?></h1>
    <div class="flex items-center ">
        <i class="fa-regular fa-bell mx-4"></i>
        <div class="flex items-center">
            <img src=<?php if($_SESSION['user_photo'] == NULL){
                        echo"../uploads/user-default.png";
                        } else {
                            echo "" . $_SESSION['user_photo'];
                        } 
                    ?> 
            alt="Foto de Perfil" class="w-8 h-auto rounded-full object-contain self-center mx-2">
            <div class="text-xs">
                <p class="font-bold"><?php echo $_SESSION['user_name'] ?></p>
                <p class="font-light"><?php echo $_SESSION['nivel_acesso'] ?></p>
            </div>

        </div>
    </div>
</header>