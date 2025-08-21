<style>
/* Car emoji animation */
.animate-car {
    display: inline-block;
    animation: carMove 2s infinite alternate ease-in-out;
}
@keyframes carMove {
    0% { transform: translateX(0); }
    100% { transform: translateX(5px); }
}

/* Glass effect navbar */
.navbar {
    border-radius: 15px;
    padding: 0.8rem 1rem;
    position: relative;
    overflow: hidden;
    z-index: 10;
    background: rgba(20, 20, 20, 0.5); /* dark semi-transparent */
    backdrop-filter: blur(10px); /* glass blur effect */
    box-shadow: 0 4px 20px rgba(0,0,0,0.5);
}

/* Navbar overlay for sparkles */
.navbar-overlay {
    position: absolute;
    top:0; left:0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: 1;
}

/* Navbar links */
.navbar-dark .navbar-nav .nav-link {
    color: #e0e0e0;
    font-weight: 500;
    margin: 0 8px;
    transition: all 0.3s ease;
    position: relative;
    z-index: 10;
}
.navbar-dark .navbar-nav .nav-link:hover {
    color: #ffffff;
}
.navbar-dark .navbar-nav .nav-link::after {
    content: '';
    position: absolute;
    width: 0;
    height: 3px;
    bottom: -5px;
    left: 0;
    background: linear-gradient(90deg, #f8c146, #ff7f50);
    transition: width 0.3s;
    border-radius: 3px;
}
.navbar-dark .navbar-nav .nav-link:hover::after,
.navbar-dark .navbar-nav .nav-link.active::after {
    width: 100%;
}

/* Login button style */
.btn-login {
    background: linear-gradient(135deg, #f8c146, #ff7f50);
    color: #1a1a1a;
    font-weight: bold;
    border-radius: 30px;
    padding: 8px 20px;
    transition: transform 0.2s, box-shadow 0.3s;
    box-shadow: 0 4px 15px rgba(0,0,0,0.3);
    z-index: 10;
    position: relative;
}
.btn-login:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 25px rgba(0,0,0,0.4);
}
</style>

<!-- Navbar with glass effect -->
<nav class="navbar navbar-expand-lg navbar-dark shadow-sm mx-3 my-3">
    <canvas id="navbarCanvas" class="navbar-overlay"></canvas>
    <div class="container">
        <a class="navbar-brand fw-bold animate-car" href="index.php">🚗 CarShowroom</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'services.php' ? 'active' : '' ?>" href="services.php">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'spareparts.php' ? 'active' : '' ?>" href="spareparts.php">Spare Parts</a>
                </li>
                <li class="nav-item ms-2">
                    <a class="btn btn-login btn-sm" href="login.php">Login</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script>
// Sync Navbar sparkles with Hero sparkles
document.addEventListener('DOMContentLoaded', function() {
    const navbarCanvas = document.getElementById('navbarCanvas');
    const ctx = navbarCanvas.getContext('2d');
    navbarCanvas.width = navbarCanvas.offsetWidth;
    navbarCanvas.height = navbarCanvas.offsetHeight;

    let particles = [];
    const particleCount = 50; // slightly fewer than hero
    for(let i=0;i<particleCount;i++){
        particles.push({
            x: Math.random() * navbarCanvas.width,
            y: Math.random() * navbarCanvas.height,
            radius: Math.random() * 2 + 1,
            speedY: Math.random() * 0.5 + 0.2,
            alpha: Math.random() * 0.5 + 0.4
        });
    }

    function animateParticles(){
        ctx.clearRect(0,0,navbarCanvas.width,navbarCanvas.height);
        particles.forEach(p=>{
            ctx.beginPath();
            ctx.arc(p.x, p.y, p.radius, 0, Math.PI*2);
            ctx.fillStyle = `rgba(248, 193, 70, ${p.alpha})`; // golden sparkle color synced
            ctx.fill();
            p.y -= p.speedY;
            if(p.y < 0) p.y = navbarCanvas.height;
        });
        requestAnimationFrame(animateParticles);
    }
    animateParticles();

    window.addEventListener('resize', () => {
        navbarCanvas.width = navbarCanvas.offsetWidth;
        navbarCanvas.height = navbarCanvas.offsetHeight;
    });
});
</script>
