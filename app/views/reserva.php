<!DOCTYPE html>
<html lang="pt-br">

<?php
require_once('template/head.php');

?>

<body>
    <div id="reserva">
        <div class="header">
            <button class="back">
                <a href="<?php echo BASE_URL; ?>index.php?url=menu">
                    <img src="<?php echo BASE_URL; ?>assets/img/left-arrow.png" alt="">
                </a>
            </button>
            <h2>Reservas</h2>
            <button class="favorite">
                <img src="<?php echo BASE_URL; ?>assets/img/heart.png" alt="">
            </button>
        </div>

        <div class="image-container">
            <img src="<?php echo BASE_URL; ?>assets/img/Image.png" alt="Caffe Mocha">
        </div>

        <div class="content">
            <div class="title-row">
                <h3>Caffe Mocha</h3>
                <div class="icons">
                    <div class="icon">&#9749;</div>
                    <div class="icon">&#128230;</div>
                </div>
            </div>

            <div class="rating">

                <span class="rating-number">4.8</span>
                <span class="reviews">(230)</span>
            </div>

            <h4>Description</h4>
            <p class="description">
                A cappuccino is an approximately 150 ml (5 oz) beverage,
                with 25 ml of espresso coffee and 85ml of fresh milk the fo...
                <span class="read-more">Read More</span>
            </p>
            
            <section>
                <h4>Reservado</h4>
                <div class="reserva">
                <h5>Reservado para as 15:00</h5>
                </div>
            </section>
        </div>
        
        <nav class="footerSection">
            <div class="footer">
                <div class="price">
                    <p>Deseja Cancelar?</p>
                </div>
                <a href="<?php echo BASE_URL; ?>index.php?url=reserva">
                    <button class="reserve">Cancelar</button>
                </a>
            </div>
        </nav>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>

</html>