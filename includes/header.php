<div id="fix">
    <header id="h1">
        <div id="d1" class="wrap">
            <a id="naslov" href="/index.php">orderly</a>

            <nav class="menu-item notactive" id="marg">
                <a href="/index.php"  class="nav1">Home</a>
                <a href="/about.php" class="nav1">About</a>
                <a href="/products/products/products.php" class="nav1">Menu</a>

                <?php
                if (isset($_SESSION['id']) and $_SESSION['type']==0):?>
                    <a href="/clients/myaccount.php" class="logout"><i class="far fa-user"></i> My account</a>
                    <a href="/orders/cart.php" class="logout"><i class="fas fa-shopping-cart"></i>  My cart</a>
                    <a href="/visits/newvisit.php" class="logout"><i class="fas fa-utensils"></i>  New Visit</a>
                    <a href="/validation/logout.php" class="logout"><i class="fas fa-sign-out-alt"></i>  Log out</a>
                <?php endif;?>
                <?php
                if (!isset($_SESSION['id']) ):?>
                    <a href="/validation/LogIn.php" class="logout"><i class="fas fa-sign-in-alt"></i> Log in</a>
                    <a href="/validation/Register.php" class="logout"><i class="far fa-user"></i> Register</a>
                <?php endif;?>
                <?php
                if (isset($_SESSION['id']) and $_SESSION['type']==1):?>
                    <a href="/employee/myaccount.php" class="logout"><i class="far fa-user"></i> My account</a>
                    <a href="/orders/allorders.php" class="logout"><i class="far fa-folder"></i>  All orders</a>
                    <a href="/validation/logout.php" class="logout"><i class="fas fa-sign-out-alt"></i>  Log out</a>
                <?php endif;?>
            </nav>


            <nav class="menu-item notactive logout2">
                <ul>
                    <li class="has-drop">
                        <a id="hamburger" class="icon" onclick="myFunction()">
                            <i class="fa fa-bars"></i>
                        </a>
                        <div class="dropdown">
                            <?php
                            if (isset($_SESSION['id']) and $_SESSION['type']==0):?>
                                <a href="/clients/myaccount.php" class="logout"><i class="far fa-user"></i> My account</a>
                                <a href="/orders/cart.php" class="logout"><i class="fas fa-shopping-cart"></i>  My cart</a>
                                <a href="/visits/newvisit.php" class="logout"><i class="fas fa-utensils"></i>  New Visit</a>
                                <a href="/validation/logout.php" class="logout"><i class="fas fa-sign-out-alt"></i>  Log out</a>
                            <?php endif;?>
                            <?php
                            if (isset($_SESSION['id']) and $_SESSION['type']==1):?>
                            <a href="/employee/myaccount.php"><i class="far fa-user"></i> My account</a>
                            <a href="/orders/allorders.php"><i class="fas fa-hamburger"></i>  All orders</a>
                                <a href="/validation/logout.php"><i class="fas fa-sign-out-alt"></i>  Log out</a>

                            <?php endif;?>
                            <?php
                            if (!isset($_SESSION['id'])):?>
                                <a href="/validation/LogIn.php"><i class="fas fa-sign-in-alt"></i>  Log in</a>
                                <a href="/validation/Register.php"><i class="far fa-user"></i> Register</a>
                            <?php endif;?>
                        </div>
                    </li>
                </ul>
                <div id="d2">
                    <a href="/validation/LogIn.php"><i class="fas fa-sign-in-alt"></i>  Log in</a>
                    <a href="/validation/Register.php"><i class="far fa-user"></i>  Register</a>
                </div>
            </nav>
            <a id="hamburger2" class="icon" onclick="myFunction()">
                <i class="fa fa-bars"></i>
            </a>
        </div>
    </header>
</div>
