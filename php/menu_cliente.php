<body>
    <!-- Menu template for cliente, meant to keep menus dynamic -->
    <div class="container">
        <header>
            <div class="searchbar">
                <!-- <img src="../icons/search-web.svg" alt=""> -->
                <!-- <div></div> -->
            </div>

            <div class="user">
                <img id="notification" src="../icons/bell-ring.svg" alt="">
                <img id="userlogo" src="../icons/pfp.webp" alt="">
                <span><?php echo $_SESSION['correoCliente']; ?>
                    <a href="cliente_dashboard.php?logout='1'" style="color: red;">Logout</a></span>
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
                    <img src="../icons/airplane-flight-svgrepo-com.svg" alt="">
                    <span><a href="cliente_vuelos.php">Mis vuelos</a></span>
                </div>


                <div class="item">
                    <img src="../icons/gallery.svg" alt="">
                    <span><a href="galeria_imagen.php">Galería</a></span>
                </div>

                <div class="item">
                    <img src="../icons/ubi2.svg" alt="">
                    <span><a href="aeropuertos_cliente.php">Aeropuertos</a></span>
                </div>

                <div class="item">
                    <img src="../icons/account.svg" alt="">
                    <span><a href="info_usuario.php">Usuario</a></span>
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