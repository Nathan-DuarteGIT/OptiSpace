<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="tabs bg-black">
            <a href="login.php" class="tab active">Login</a>
            <a href="registo.php" class="tab">Register</a>
        </div>

        <form method="POST">
                <label>Insira o seu Email</label>
                <input type="email" name="email" required placeholder="E-mail">
                        
                <label>Insira a sua Palavra-passe</label>
                <input type="password" name="password" required placeholder="Palavra-passe">
                        
                <button type="submit">Entrar</button>
        </form>
        
        <div class="content-wrapper">
            <div class="left-section">
                <img src="assets/css/output.css" alt="Logo">

            </div>
            
            <div class="right-section m-5">
                <div class="form-card">
                    <div class="logo">
                        <img src="../assets/css/output.css" alt="Logo">
                        <img src="../assets/css/output.css" alt="Decoração">
                    </div>
                    
                    <h1>Bem-vindo à Optispace</h1>
                    <h2>Entrar</h2>
                    
                    <div class="links">
                        <span class="active">Não tem conta?</span>
                        <a href="registo.php">Registe-se</a>
                    </div>
                    
                    <?php if ($error): ?>
                        <div class="error"><?php echo $error; ?></div>
                    <?php endif; ?>
                    
                    
                </div>
            </div>
            
            <div class="decoration">
                <img src="../assets/css/computer_inicio" alt="Decoration">
            </div>
        </div>
    </div>
</body>
</html>