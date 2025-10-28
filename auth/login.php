<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../assets/css/output.css">
</head>

<body>
    <div class="container">
        <div class="tabs bg-black text-white w-32">
            <img src="assets/images/logo_optispace" alt="Logo">
            <img src="assets/images/Saly-2" alt="Decoração">
        </div>
    </div>

    <div class="right-section m-5">
                <div class="form-card">
                        <img src="../assets/css/output.css" alt="Logo">
                        <img src="../assets/css/output.css" alt="Decoração">
                </div>
    </div>       

    <form method="POST">
                <label>Insira o seu Email</label>
                <input type="email" name="email" required placeholder="E-mail">
                        
                <label>Insira a sua Palavra-passe</label>
                <input type="password" name="password" required placeholder="Palavra-passe">

                <button type="submit">Entrar</button>

                <h1>Bem-vindo à Optispace</h1>
                    <h2>Entrar</h2>
                    
                    <div class="links">
                        <span class="active">Não tem conta?</span>
                        <a href="registo.php">Registe-se</a>
                    </div>
    </form>
        
</body>
</html>