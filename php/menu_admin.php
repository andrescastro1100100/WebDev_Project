<body>
    <!-- Menu template for admin, meant to keep menus dynamic -->
    <div class="container">
        <header>
            <div class="searchbar">
                <!-- <img src="../icons/search-web.svg" alt="">
                <div></div> -->
            </div>

            <div class="user">
                <img id="notification" src="../icons/bell-ring.svg" alt="">
                <img id="userlogo" src="../icons/pfp.webp" alt="">
                <span><?php echo $_SESSION['correoCliente']; ?>
                    <a href="admin_dashboard.php?logout='1'" style="color: red;">Logout</a> </span>
            </div>
        </header>

        <div class="buttonsection">
            <!-- <button>New</button>
            <button>Upload</button>
            <button>Share</button> -->

        </div>

        <div class="sidebar">
            <div class="logo">
                <img src="../icons/airplane-search.svg" alt="flightscanner logo">
                <div>flightScanner</div>
            </div>

            <div class="menu">
                <div class="item">
                    <img src="../icons/airport.svg" alt="">
                    <span><a href="admin_dashboard.php">Vuelos</a></span>
                </div>

                <div class="item">
                    <img src="../icons/airplane-plus.svg" alt="">
                    <span><a href="add_vuelo.php">Agregar Vuelo</a></span>
                </div>

                <div class="item">
                    <img src="../icons/airplane-remove.svg" alt="">
                    <span><a href="modify_vuelo.php">Modificar Vuelos</a></span>
                </div>


                <div class="item">
                    <img src="../icons/cog.svg" alt="">
                    <span><a href="aeronaves_mod.php">Aeronaves</a></span>
                </div>


               
            </div>

            <div class="login">
                <img src="../icons/pfp.webp" alt="">
                <div>
                    <div id="welcome">Hi there,</div>
                    <div id="name"><?php echo $_SESSION['correoCliente']; ?></div>
                </div>
            </div>

        </div>