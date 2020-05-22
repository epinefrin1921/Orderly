<div id="fix">
    <header id="h1">
        <div id="d1" class="wrap">
            <a id="naslov" href="../Orderly/index.php">orderly</a>

            <nav class="menu-item notactive" id="marg">
                <a href="index.php"  class="nav1">Home</a>
                <a href="about.php" class="nav1">About</a>
                <a href="products.php" class="nav1">Menu</a>

                <?php
                if (isset($_SESSION['id']) and $_SESSION['type']==0):?>
                    <a href="#" class="logout">My account</a>
                    <a href="#" class="logout">Previous orders</a>
                    <a href="#" class="logout">Balance</a>
                    <a href="logout.php" class="logout">Log out</a>
                <?php endif;?>
                <?php
                if (!isset($_SESSION['id']) ):?>
                    <a href="LogIn.php" class="logout">Log in</a>
                    <a href="Register.php" class="logout">Register</a>
                <?php endif;?>
                <?php
                if (isset($_SESSION['id']) and $_SESSION['type']==1):?>
                    <a href="#" class="logout">My account</a>
                    <a href="#" class="logout">My orders</a>
                    <a href="registerEmployee.php" class="logout">Register new employee</a>
                    <a href="logout.php" class="logout">Log out</a>
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
                                <a href="#">My account</a>
                                <a href="#">Previous orders</a>
                                <a href="#">Balance</a>
                                <a href="logout.php">Log out</a>
                            <?php endif;?>
                            <?php
                            if (isset($_SESSION['id']) and $_SESSION['type']==1):?>
                            <a href="#">My account</a>
                            <a href="#">My orders</a>

                                <a href="registerEmployee.php">Register new employee</a>
                                <a href="logout.php">Log out</a>

                            <?php endif;?>
                            <?php
                            if (!isset($_SESSION['id'])):?>
                                <a href="LogIn.php">Log in</a>
                                <a href="Register.php">Register</a>
                            <?php endif;?>
                        </div>
                    </li>
                </ul>
                <div id="d2">
                    <a href="LogIn.php">Log in</a>
                    <a href="Register.php">Register</a>
                </div>
            </nav>
            <a id="hamburger2" class="icon" onclick="myFunction()">
                <i class="fa fa-bars"></i>
            </a>
        </div>
    </header>
</div>
