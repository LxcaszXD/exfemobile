<!DOCTYPE html>
<html lang="pt-br">

<?php require_once('template/head.php'); ?>



<body>

    <div class="install-box">
        <img src="<?= BASE_URL ?>assets/img/logo_exfe.png" alt="Logo App" class="install-icon">
        <h2>Instale o App da Exfé</h2>
        <p>Experimente o sabor do café onde estiver.<br>Instale nosso app e peça com facilidade.</p>

        <!-- Mensagem e botões de instalação -->
        <div id="instalarContainer">
            <span>Deseja instalar o app?</span>
            <div>
                <button id="btnInstalar">Instalar</button>
                <button id="fecharInstalar">X</button>
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
            if (true){
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

            const { outcome } = await deferredPrompt.userChoice;
            console.log('Instalação: ' + outcome);

            if (outcome === 'accepted') {
                window.location.href = 'http://localhost/exfemobile/public/';
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
