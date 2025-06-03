<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$mensagem = '';

try {
    $pdo = new PDO("mysql:host=localhost;dbname=Pallozo;charset=utf8", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $cpf     = preg_replace('/[^0-9]/', '', $_POST['cpf'] ?? '');
        $nome    = strtoupper(trim($_POST['nome'] ?? ''));
        $contato = preg_replace('/[^0-9]/', '', $_POST['phone'] ?? '');
        $email   = strtolower(trim($_POST['email'] ?? ''));
        $senha   = $_POST['password'] ?? '';
        $confirm = $_POST['confirm-password'] ?? '';

        if (!$cpf || !$nome || !$contato || !$email || !$senha || !$confirm) {
            $mensagem = "<p class='erro'>❌ Todos os campos são obrigatórios.</p>";
        } elseif ($senha !== $confirm) {
            $mensagem = "<p class='erro'>❌ As senhas não coincidem.</p>";
        } elseif (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&]).{8,}$/', $senha)) {
            $mensagem = "<p class='erro'>❌ A senha deve ter pelo menos 8 caracteres, incluindo letra, número e caractere especial.</p>";
        } else {
            $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare("INSERT INTO cliente (cpf, nome_cliente, contato, email, data_registro, senha)
                                   VALUES (:cpf, :nome, :contato, :email, CURDATE(), :senha)");
            $stmt->execute([
                ':cpf'     => $cpf,
                ':nome'    => $nome,
                ':contato' => '+55' . $contato,
                ':email'   => $email,
                ':senha'   => $senhaCriptografada
            ]);

            $mensagem = "<p class='sucesso'>✅ Cadastro realizado com sucesso!</p>";
        }
    }
} catch (PDOException $e) {
    if ($e->getCode() === '23000') {
        $mensagem = "<p class='erro'>⚠️ Este CPF já está cadastrado.</p>";
    } else {
        $mensagem = "<p class='erro'>❌ Erro: " . $e->getMessage() . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Pallozo</title>
    <link rel="stylesheet" href="css/cadastro.css">
    <link rel="shortcut icon" href="icon/1.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        .sucesso { color: green; text-align: center; font-weight: bold; }
        .erro { color: red; text-align: center; font-weight: bold; }
    </style>
</head>

<body>
    <div class="main-content">
        <!-- Seção da imagem -->
        <div class="image-section">
            <img src="img/Rectangle 4519.png" alt="Barbearia estilizada">
        </div>

        <!-- Seção do formulário de cadastro -->
        <div class="cadastro-section">
            <h1 class="logo">PALLOZO</h1>
            <h2>Cadastro</h2>

            <?= $mensagem ?>

            <!-- Formulário de cadastro -->
            <form method="POST">
                <!-- Nome Completo -->
                <div class="input-group">
                    <input type="text" id="nome" name="nome" placeholder=""
                        oninput="this.value = this.value.toUpperCase()" pattern="[A-ZÀ-Ú\s]{5,}"
                        title="Digite seu nome completo (mínimo 5 caracteres)" required>
                    <label for="nome">Nome Completo</label>
                </div>
                <!-- Campo de telefone unificado -->
                <div class="input-group">
                    <div class="phone-input">
                        <input type="tel" id="phone" name="phone" maxlength="15" inputmode="numeric"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                            onkeypress="return event.charCode >= 48 && event.charCode <= 57" placeholder="" required>
                        <label for="phone">Número de telefone</label>
                    </div>
                </div>

                <!-- Campo de e-mail -->
                <div class="input-group">
                    <input type="email" id="email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                        oninvalid="this.setCustomValidity('Por favor, insira um e-mail válido com @')"
                        oninput="this.setCustomValidity('')" placeholder="" required>
                    <label for="email">E-mail</label>
                </div>

                <!-- Campo de CPF -->
                <div class="input-group">
                    <input type="text" id="cpf" name="cpf" maxlength="14" 
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                        onkeypress="return event.charCode >= 48 && event.charCode <= 57" placeholder="" required>
                    <label for="cpf" class="label-left">CPF</label>
                </div>

                <!-- Campo de senha -->
                <div class="input-group">
                    <input type="password" id="password" name="password"
                        pattern="^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$" placeholder="" required>
                    <button type="button" class="eye-button" data-target="password"></button>
                    <label for="password" class="label-left">Crie a sua senha</label>
                </div>
                <p class="password-hint">A senha deve ter 8 caracteres, incluindo um número e caractere especial.</p>

                <!-- Campo de confirmar senha -->
                <div class="input-group">
                    <input type="password" id="confirm-password" name="confirm-password" placeholder="" required>
                    <button type="button" class="eye-button" data-target="confirm-password"></button>
                    <label for="confirm-password" class="label-left">Confirme sua senha</label>
                </div>
                <p id="passwordError" style="color:red; display:none;">As senhas não coincidem!</p>

                <!-- Botão de enviar -->
                <button type="submit" class="login-btn">Enviar</button>

                <!-- Link para login -->
                <p class="login-link">Já tem uma conta? <a href="login.html">Logue-se</a></p>

                <!-- Divisor -->
                <p class="divider">ou</p>

                <!-- Botões de login social -->
                <button type="button" class="social-login google"> <img class="app-icon"
                        src="img/Group 955.png" />Continue com Google</button>
                <button type="button" class="social-login apple"><img class="app-icon"
                        src="img/Apple logo.png" />Continue com Apple</button>
            </form>
        </div>
    </div>

    <script src="js/cadastro.js"></script>
</body>

</html>
