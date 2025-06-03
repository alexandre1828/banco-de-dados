<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$mensagem = '';

try {
    $pdo = new PDO("mysql:host=localhost;dbname=Pallozo;charset=utf8", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $telefone = preg_replace('/[^0-9]/', '', $_POST['phone'] ?? '');
        $senha    = $_POST['password'] ?? '';

        if (!$telefone || !$senha) {
            $mensagem = "<p class='erro'>❌ Preencha todos os campos.</p>";
        } else {
            $contato = '+55' . $telefone;

            $stmt = $pdo->prepare("SELECT senha FROM cliente WHERE contato = :contato");
            $stmt->execute([':contato' => $contato]);
            $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($cliente && password_verify($senha, $cliente['senha'])) {
                $mensagem = "<p class='sucesso'>✅ Login concluído com sucesso!</p>";
            } else {
                $mensagem = "<p class='erro'>❌ Telefone ou senha incorretos.</p>";
            }
        }
    }
} catch (PDOException $e) {
    $mensagem = "<p class='erro'>❌ Erro: " . $e->getMessage() . "</p>";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Pallozo</title>
    <link rel="stylesheet" href="css/login.css">

    <link rel="shortcut icon" href="icon/1.ico" type="image/x-icon">
    <style>
        .mensagem { text-align: center; margin-bottom: 20px; font-weight: bold; }
        .sucesso { color: green; }
        .erro { color: red; }
    </style>
</head>
<body>
    <div class="main-content">
        <div class="image-section">
            <img src="img/Rectangle 4519.png" alt="Barbearia estilizada">
        </div>

        <div class="login-section">
            <h1 class="logo">PALLOZO</h1>
            <h2>Login</h2>

            <!-- Mensagem de status -->
            <div class="mensagem">
                <?= $mensagem ?>
            </div>

            <!-- Formulário de login -->
            <form method="POST">
                <label for="phone" class="label-left">Número de telefone</label>
                <div class="input-group">
                    <div class="phone-input">
                        <span class="prefix">+55</span>
                        <input type="text" id="phone" name="phone" placeholder="DDD + número" maxlength="11" inputmode="numeric" required
                            oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                    </div>
                </div>

                <label for="password" class="label-left">Senha</label>
                <div class="input-group">
                    <input type="password" id="password" name="password" placeholder="********" maxlength="20" required>
                    <button type="button" class="eye-button" onclick="togglePasswordVisibility()">
                        <img class="eye-icon" src="img/Invisible.png" alt="Mostrar senha">
                    </button>
                </div>
                <a href="#" class="forgot-password">Esqueceu a senha?</a>

                <button type="submit" class="login-btn">Login</button>

                <p>Não tem uma conta? <a href="cadastro.php" class="register-link">Registre-se</a></p>
                <p class="divider">ou</p>

                <button type="button" class="social-login google">
                    <img class="eye-icon" src="img/Group 955.png">Continue com Google
                </button>
                <button type="button" class="social-login apple">
                    <img class="eye-icon" src="img/Apple logo.png">Continue com Apple
                </button>
            </form>
        </div>
    </div>

    <script>
        function togglePasswordVisibility() {
            const input = document.getElementById("password");
            input.type = input.type === "password" ? "text" : "password";
        }
    </script>
</body>
</html>
