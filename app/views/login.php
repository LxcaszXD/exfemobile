<!DOCTYPE html>
<html lang="en">

<?php
require_once('template/head.php');
?>

<body>
    <section id="login">
        <div class="container-home">
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">

                    <div class="swiper-slide">
                        <figure><img src="<?php echo BASE_URL; ?>assets/img/bg-home.png" alt=""></figure>

                        <div class="home-txt">
                            <h2>Apaixone-se por café em um prazer encantador!</h2>
                            <p>Bem-vindo ao nosso aconchegante cantinho do café, onde cada xícara é um deleite para você.
                            </p>
                            <button class="btn-app" data-bs-toggle="modal" data-bs-target="#modalLogin">
                                Comece agora
                            </button>
                        </div>

                        <div class="gradient-home">
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <figure><img src="<?php echo BASE_URL; ?>assets/img/bg-home2.jpg" alt=""></figure>

                        <div class="home-txt">
                            <h2>Apaixone-se por café em um prazer encantador!</h2>
                            <p>Bem-vindo ao nosso aconchegante cantinho do café, onde cada xícara é um deleite para você.
                            </p>
                            <button class="btn-app" data-bs-toggle="modal" data-bs-target="#modalLogin">
                                Comece agora
                            </button>
                        </div>

                        <div class="gradient-home">
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <figure><img src="<?php echo BASE_URL; ?>assets/img/bg-home3.png" alt=""></figure>

                        <div class="home-txt">
                            <h2>Apaixone-se por café em um prazer encantador!</h2>
                            <p>Bem-vindo ao nosso aconchegante cantinho do café, onde cada xícara é um deleite para você.
                            </p>
                            <button class="btn-app" data-bs-toggle="modal" data-bs-target="#modalLogin">
                                Comece agora
                            </button>
                        </div>

                        <div class="gradient-home">
                        </div>
                    </div>

                </div>

                <div class="swiper-pagination"></div>
            </div>
    </section>



    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>



    </div>

    <!-- Modal -->
    <div class="modal fade modalLogin" id="modalLogin" tabindex="-1" aria-labelledby="loginModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 shadow">
                <div class="modal-header border-0 pb-0">
                    <h1 class="modal-title fs-5 w-100 text-center" id="loginModalLabel">Login - Exfe</h1>
                    <button type="button" class="btn-close position-absolute end-0 me-3" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body pt-2">
                    <!-- Corpo do modal com o formulário -->
                    <form method="POST" action="<?php echo BASE_URL; ?>index.php?url=login/autenticar">
                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail:</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="senha" class="form-label">Senha:</label>
                            <input type="password" name="senha" id="senha" class="form-control" required>
                        </div>

                        <!-- Rodapé do modal com os botões -->
                        <div class="d-flex justify-content-evenly mt-4">
                            <button type="button" class="btn btn-danger w-45" data-bs-dismiss="modal">Fechar</button>

                            <button type="submit" class=" btn-app w-45">Entrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
        crossorigin="anonymous"></script>

    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('service_worker.js')
                    .then(function(registration) {
                        console.log('Service Worker registrado', registration.scope);
                    })
                    .catch(function(error) {
                        console.log('Erro ao registrar o Service Worker:', error);
                    });
            });
        }
    </script>


    <script src="<?php echo BASE_URL; ?>assets/script/script.js"></script>
</body>

</html>