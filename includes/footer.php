<script src='https://kit.fontawesome.com/a076d05399.js'></script>
<footer  class="wrap">
    <div>&copy;SSST_2020</div>
    <div class="medias">
        <a href="#"><i class="fab fa-instagram-square"></i></a>
        <a href="#"><i class="fab fa-facebook-square"></i></a>
        <a href="#"><i class="fab fa-twitter-square"></i></a>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
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