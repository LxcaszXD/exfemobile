<!DOCTYPE html>
<html lang="pt-br">

<?php require_once('template/head.php'); ?>

<title>Exfé - Cafeteria</title>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Raleway:wght@500&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">



<body>
    <style>
        body {
            background: linear-gradient(135deg, #fffaf5, #f3e4d7, #e3c9b6, #c49a6c);
            font-family: 'Raleway', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100dvh;
            margin: 0 auto;
        }

        .install-box {
            background: #ffffffcc;
            border: 1px solid #e0d4c2;
            padding: 60px 50px;
            border-radius: 20px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
            text-align: center;
            max-width: 600px;
            width: 100%;
            height: auto;

            img {
                width: 250px;
                height: auto;
                margin-bottom: 20px;
            }
        }

        .install-icon {
            width: 160px;
            margin-bottom: 30px;
        }

        h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            color: #5c4033;
            margin-bottom: 20px;
        }

        p {
            font-size: 1.2rem;
            color: #6e5840;
            margin-bottom: 20px;
        }

        .btn-install {
            background-color: #8b5e3c;
            border: none;
            font-size: 1.15rem;
            padding: 14px 28px;
            border-radius: 10px;
            color: white;
            transition: background 0.3s ease;
        }

        .btn-install:hover {
            background-color: #74492c;
        }

        .small-text {
            color: #a58b73;
            font-size: 1rem;
            margin-top: 30px;
        }

        @media (max-width: 768px) {
            .install-box {
                padding: 40px 25px;
            }

            h2 {
                font-size: 2rem;
            }

            p {
                font-size: 1rem;
            }
        }
    </style>

    <div class="install-box">
        <img src="<?= BASE_URL ?>assets/img/logo_exfe.png" alt="Logo App" class="install-icon">
        <h2>Instale o App da Exfé</h2>
        <p>Experimente o sabor do café onde estiver.<br>Instale nosso app e peça com facilidade.</p>

        <!-- Mensagem e botões de instalação -->
        <div id="instalarContainer">
            <span>Deseja instalar o app?</span>
            <div>
                <button id="btnInstalar" class="btn btn-sm btn-light" style="background-color: #8b5e3c; color: white;">Instalar</button>
                <button id="fecharInstalar" class="btn btn-sm btn-light">X</button>
            </div>
        </div>


        <p class="small-text">Compatível com Android e iOS.</p>

        <!-- Instrução para iOS -->
        <div id="iosInstruction"></div>
    </div>

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Scripts PWA -->
    <script>
        let deferredPrompt;
        const container = document.getElementById('instalarContainer');
        const btnInstalar = document.getElementById('btnInstalar');
        const fecharInstalar = document.getElementById('fecharInstalar');
        const iosInstruction = document.getElementById('iosInstruction');

        const isIos = () => {
            const userAgent = window.navigator.userAgent.toLowerCase();
            return /iphone|ipad|ipod/.test(userAgent);
        };

        const isInStandaloneMode = () => ('standalone' in window.navigator) && window.navigator.standalone;

        window.addEventListener('load', () => {
            if (true) {
                if (!localStorage.getItem('ios-pwa-instruction-shown')) {
                    iosInstruction.innerHTML = '📲 No Safari, toque em <strong>Compartilhar</strong> e depois em <strong>“Adicionar à Tela de Início”</strong>.';
                    iosInstruction.style.display = 'block';
                    // localStorage.setItem('ios-pwa-instruction-shown', '1');
                }
            }
        });

        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            container.style.display = 'block';
        });

        btnInstalar.addEventListener('click', async () => {
            container.style.display = 'none';
            deferredPrompt.prompt();

            const {
                outcome
            } = await deferredPrompt.userChoice;
            console.log('Instalação: ' + outcome);

            if (outcome === 'accepted') {
                window.location.href = 'https://agenciatipi02.smpsistema.com.br/devcycle/exfemobile/public/';
            }

            deferredPrompt = null;
        });

        fecharInstalar.addEventListener('click', () => {
            container.style.display = 'none';
        });

        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('service_worker.js')
                    .then(reg => console.log('ServiceWorker registrado com sucesso:', reg.scope))
                    .catch(err => console.log('Erro ao registrar ServiceWorker:', err));
            });
        }
    </script>


</body>

</html>