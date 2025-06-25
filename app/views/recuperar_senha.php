<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Recuperar Senha</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            width: 100%;
            max-width: 500px;
            height: auto;
            margin: 0 auto;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .form-container {
            background: linear-gradient(to bottom, #eecdc5, #fff);
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            text-transform: uppercase;
            font-size: 24px;
            font-weight: bold;
        }

        h1 span {
            display: block;
            line-height: 1;
        }

        .btn {
            font-weight: 600;
        }
    </style>
</head>

<body>

    <div class="form-container">
        <h1>
            <span>Recuperar</span>
            <span>Senha</span>
        </h1>

        <form action="<?php echo BASE_URL; ?>index.php?url=login/enviarRecuperacao" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">E-mail cadastrado:</label>
                <input type="email" id="email" name="email" class="form-control" required placeholder="Digite seu e-mail cadastrado">
            </div>

            <button type="submit" class="btn btn-primary w-100 mb-2">Enviar Link</button>
            <a href="<?php echo BASE_URL; ?>index.php?url=login" class="btn btn-outline-secondary w-100">Voltar ao Login</a>
        </form>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>