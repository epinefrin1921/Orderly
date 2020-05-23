<div id="fix">
    <header id="h1">
        <div id="d1" class="wrap">
            <a id="naslov" href="/Orderly/index.php">orderly</a>

            <nav class="menu-item notactive" id="marg">
                <a href="/Orderly/index.php"  class="nav1">Home</a>
                <a href="/Orderly/about.php" class="nav1">About</a>
                <a href="/Orderly/products/products/products.php" class="nav1">Menu</a>

                <?php
                if (isset($_SESSION['id']) and $_SESSION['type']==0):?>
                    <a href="/Orderly/clients/myaccount.php" class="logout">My account</a>
                    <a href="/Orderly/orders/cart.php" class="logout">My cart</a>
                    <a href="/Orderly/validation/logout.php" class="logout">Log out</a>
                <?php endif;?>
                <?php
                if (!isset($_SESSION['id']) ):?>
                    <a href="/Orderly/validation/LogIn.php" class="logout">Log in</a>
                    <a href="/Orderly/validation/Register.php" class="logout">Register</a>
                <?php endif;?>
                <?php
                if (isset($_SESSION['id']) and $_SESSION['type']==1):?>
                    <a href="/Orderly/employee/myaccountemp.php" class="logout">My account</a>
                    <a href="#" class="logout">My orders</a>
                    <a href="/Orderly/employee/registerEmployee.php" class="logout">Register new employee</a>
                    <a href="/Orderly/validation/logout.php" class="logout">Log out</a>
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
                                <a href="/Orderly/clients/myaccount.php" class="logout">My account</a>
                                <a href="/Orderly/orders/cart.php" class="logout">My cart</a>
                                <a href="/Orderly/validation/logout.php" class="logout">Log out</a>
                            <?php endif;?>
                            <?php
                            if (isset($_SESSION['id']) and $_SESSION['type']==1):?>
                            <a href="/Orderly/employee/myaccountemp.php">My account</a>
                            <a href="#">My orders</a>

                                <a href="/Orderly/employee/registerEmployee.php">Register new employee</a>
                                <a href="/Orderly/validation/logout.php">Log out</a>

                            <?php endif;?>
                            <?php
                            if (!isset($_SESSION['id'])):?>
                                <a href="/Orderly/validation/LogIn.php">Log in</a>
                                <a href="/Orderly/validation/Register.php">Register</a>
                            <?php endif;?>
                        </div>
                    </li>
                </ul>
                <div id="d2">
                    <a href="/Orderly/validation/LogIn.php">Log in</a>
                    <a href="/Orderly/validation/Register.php">Register</a>
                </div>
            </nav>
            <a id="hamburger2" class="icon" onclick="myFunction()">
                <i class="fa fa-bars"></i>
            </a>
        </div>
    </header>
</div>
