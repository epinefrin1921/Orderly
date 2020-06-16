
<footer  class="wrap" style="margin-top: 40px">

        <div class="medias">
            <p>Visit us on:</p>
        </div>
        <div class="medias">
            <a href="#"><i class="fab fa-instagram-square"></i></a>
            <a href="#"><i class="fab fa-facebook-square"></i></a>
            <a href="#"><i class="fab fa-twitter-square"></i></a>
        </div>

        <div style="color: white; margin: 30px auto;" class="medias2">
            <div class="xyz">
                <a href="/Orderly/index.php">Home</a>
                <a href="/Orderly/about.php">About</a>
                <a href="/Orderly/products/products/products.php">Menu</a>
                <a href="/Orderly/validation/Register.php">Register</a>
                <a href="/Orderly/validation/LogIn.php">Login</a>
            </div>
            <div>
                &copy;SSST_2020 Orderly
            </div>
        </div>
</footer>

<script
        src="https://code.jquery.com/jquery-3.5.1.js"
        integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
        crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
<script src='https://kit.fontawesome.com/a076d05399.js'></script>

<script>
    $(function () {
        $(document).scroll(function () {
            var $nav = $("#fix");
            var $nav2 = $(".menu-item");
            $nav.toggleClass("scrolled", $(this).scrollTop() > $nav.height());
            $nav2.addClass('notactive', $(this).scrollTop() > $nav.height());
        });
    });


    function myFunction() {
        let x = document.getElementsByClassName("menu-item");

        for (let i = 0; i < x.length; i++) {
            x[i].classList.toggle('notactive');
        }
    }
   </script>