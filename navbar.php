<style>
    .animate-car {
        display: inline-block;
        animation: carMove 2s infinite alternate ease-in-out;
    }
    @keyframes carMove {
        0% { transform: translateX(0); }
        100% { transform: translateX(5px); }
    }
    .navbar-nav .nav-link {
        transition: color 0.3s ease, transform 0.2s ease;
    }
    .navbar-nav .nav-link:hover {
        color: #f8c146 !important;
        transform: translateY(-2px);
    }
</style>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold animate-car" href="index.php">🚗 Showroom</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'services.php' ? 'active' : '' ?>" href="services.php">Services</a></li>
                <li class="nav-item"><a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'spareparts.php' ? 'active' : '' ?>" href="spareparts.php">Spare Parts</a></li>
                <li class="nav-item">
                    <a class="btn btn-warning btn-sm text-dark ms-2 px-3" href="login.php">Login</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
