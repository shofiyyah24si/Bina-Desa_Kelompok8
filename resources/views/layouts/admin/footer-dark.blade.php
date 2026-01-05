<!-- Dark Futuristic Footer -->
<footer class="dark-footer mt-5">
    <!-- Animated Background -->
    <div class="dark-bg-animation">
        <div class="floating-orbs">
            <div class="orb orb-1"></div>
            <div class="orb orb-2"></div>
            <div class="orb orb-3"></div>
            <div class="orb orb-4"></div>
            <div class="orb orb-5"></div>
            <div class="orb orb-6"></div>
        </div>
        <div class="grid-overlay"></div>
    </div>

    <div class="dark-container">
        <div class="container-fluid">
            <!-- Main Content -->
            <div class="dark-content">
                <div class="row g-4">
                    <!-- Brand Section -->
                    <div class="col-lg-5 col-md-6">
                        <div class="dark-brand">
                            <div class="brand-dark">
                                <div class="brand-logo-dark">
                                    <div class="logo-hexagon">
                                        <i class="fas fa-home-heart"></i>
                                        <div class="hexagon-glow"></div>
                                    </div>
                                    <div class="brand-text-dark">
                                        <h3>BINA DESA</h3>
                                        <span class="brand-subtitle">DISASTER MANAGEMENT SYSTEM</span>
                                        <div class="brand-line"></div>
                                    </div>
                                </div>
                                <p class="brand-description-dark">
                                    Advanced digital platform for comprehensive disaster management, 
                                    coordinating relief efforts with precision and efficiency through 
                                    cutting-edge technology solutions.
                                </p>
                                
                                <!-- Tech Stack Display -->
                                <div class="tech-stack">
                                    <div class="tech-badge-dark">
                                        <i class="fab fa-laravel"></i>
                                        <span>Laravel {{ app()->version() }}</span>
                                    </div>
                                    <div class="tech-badge-dark">
                                        <i class="fab fa-php"></i>
                                        <span>PHP {{ PHP_VERSION }}</span>
                                    </div>
                                    <div class="tech-badge-dark">
                                        <i class="fas fa-database"></i>
                                        <span>MySQL</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Matrix -->
                    <div class="col-lg-3 col-md-6">
                        <div class="dark-section">
                            <h5 class="dark-title">
                                <i class="fas fa-sitemap"></i>
                                <span>NAVIGATION MATRIX</span>
                                <div class="title-glow"></div>
                            </h5>
                            <div class="nav-matrix">
                                <a href="{{ route('dashboard') }}" class="matrix-link">
                                    <div class="link-icon">
                                        <i class="fas fa-tachometer-alt"></i>
                                    </div>
                                    <span>DASHBOARD</span>
                                    <div class="link-arrow">→</div>
                                </a>
                                <a href="{{ route('kejadian.index') }}" class="matrix-link">
                                    <div class="link-icon">
                                        <i class="fas fa-exclamation-triangle"></i>
                                    </div>
                                    <span>INCIDENTS</span>
                                    <div class="link-arrow">→</div>
                                </a>
                                <a href="{{ route('posko.index') }}" class="matrix-link">
                                    <div class="link-icon">
                                        <i class="fas fa-home"></i>
                                    </div>
                                    <span>COMMAND POSTS</span>
                                    <div class="link-arrow">→</div>
                                </a>
                                <a href="{{ route('logistik.index') }}" class="matrix-link">
                                    <div class="link-icon">
                                        <i class="fas fa-boxes"></i>
                                    </div>
                                    <span>LOGISTICS</span>
                                    <div class="link-arrow">→</div>
                                </a>
                                <a href="{{ route('distribusi.index') }}" class="matrix-link">
                                    <div class="link-icon">
                                        <i class="fas fa-truck"></i>
                                    </div>
                                    <span>DISTRIBUTION</span>
                                    <div class="link-arrow">→</div>
                                </a>
                                <a href="{{ route('donasi.index') }}" class="matrix-link">
                                    <div class="link-icon">
                                        <i class="fas fa-hand-holding-heart"></i>
                                    </div>
                                    <span>DONATIONS</span>
                                    <div class="link-arrow">→</div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- System Analytics -->
                    <div class="col-lg-4 col-md-12">
                        <div class="dark-section">
                            <h5 class="dark-title">
                                <i class="fas fa-analytics"></i>
                                <span>SYSTEM ANALYTICS</span>
                                <div class="title-glow"></div>
                            </h5>
                            <div class="analytics-grid">
                                <div class="analytics-card">
                                    <div class="card-header">
                                        <i class="fas fa-users"></i>
                                        <span>REGISTERED CITIZENS</span>
                                    </div>
                                    <div class="card-value" data-count="{{ \App\Models\Warga::count() }}">0</div>
                                    <div class="card-progress">
                                        <div class="progress-bar" style="width: 85%"></div>
                                    </div>
                                </div>
                                
                                <div class="analytics-card">
                                    <div class="card-header">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        <span>DISASTER EVENTS</span>
                                    </div>
                                    <div class="card-value" data-count="{{ \App\Models\KejadianBencana::count() }}">0</div>
                                    <div class="card-progress">
                                        <div class="progress-bar" style="width: 65%"></div>
                                    </div>
                                </div>
                                
                                <div class="analytics-card">
                                    <div class="card-header">
                                        <i class="fas fa-hand-holding-heart"></i>
                                        <span>ACTIVE DONATIONS</span>
                                    </div>
                                    <div class="card-value" data-count="{{ \App\Models\DonasiBencana::count() }}">0</div>
                                    <div class="card-progress">
                                        <div class="progress-bar" style="width: 92%"></div>
                                    </div>
                                </div>
                                
                                <div class="analytics-card">
                                    <div class="card-header">
                                        <i class="fas fa-boxes"></i>
                                        <span>LOGISTICS ITEMS</span>
                                    </div>
                                    <div class="card-value" data-count="{{ \App\Models\LogistikBencana::count() }}">0</div>
                                    <div class="card-progress">
                                        <div class="progress-bar" style="width: 78%"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Social Network -->
                            <div class="social-network">
                                <h6 class="social-title">CONNECT WITH US</h6>
                                <div class="social-dark">
                                    <a href="#" class="social-node facebook">
                                        <i class="fab fa-facebook-f"></i>
                                        <div class="node-pulse"></div>
                                    </a>
                                    <a href="#" class="social-node twitter">
                                        <i class="fab fa-twitter"></i>
                                        <div class="node-pulse"></div>
                                    </a>
                                    <a href="#" class="social-node instagram">
                                        <i class="fab fa-instagram"></i>
                                        <div class="node-pulse"></div>
                                    </a>
                                    <a href="#" class="social-node linkedin">
                                        <i class="fab fa-linkedin-in"></i>
                                        <div class="node-pulse"></div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Terminal -->
            <div class="footer-terminal">
                <div class="terminal-header">
                    <div class="terminal-controls">
                        <span class="control close"></span>
                        <span class="control minimize"></span>
                        <span class="control maximize"></span>
                    </div>
                    <div class="terminal-title">BINA_DESA_SYSTEM_v2.0</div>
                </div>
                <div class="terminal-body">
                    <div class="terminal-line">
                        <span class="prompt">root@binadesa:~$</span>
                        <span class="command">© {{ date('Y') }} BINA DESA KELOMPOK 8 - ALL RIGHTS RESERVED</span>
                    </div>
                    <div class="terminal-line">
                        <span class="prompt">system@status:~$</span>
                        <span class="command">SECURE CONNECTION ESTABLISHED | ENCRYPTION: AES-256</span>
                    </div>
                    <div class="terminal-line">
                        <span class="prompt">dev@team:~$</span>
                        <span class="command">DEVELOPED WITH ❤️ FOR DISASTER MANAGEMENT EXCELLENCE</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
:root {
    --dark-bg: #0a0a0a;
    --dark-secondary: #111111;
    --dark-accent: #00ff88;
    --dark-accent-2: #ff0080;
    --dark-text: #ffffff;
    --dark-text-muted: rgba(255, 255, 255, 0.7);
    --dark-border: rgba(0, 255, 136, 0.2);
    --dark-glow: rgba(0, 255, 136, 0.3);
    --dark-shadow: rgba(0, 0, 0, 0.8);
}

.dark-footer {
    background: linear-gradient(135deg, var(--dark-bg) 0%, var(--dark-secondary) 100%);
    color: var(--dark-text);
    position: relative;
    overflow: hidden;
    min-height: 600px;
}

/* Animated Background */
.dark-bg-animation {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
    z-index: 1;
}

.floating-orbs {
    position: relative;
    width: 100%;
    height: 100%;
}

.orb {
    position: absolute;
    border-radius: 50%;
    background: radial-gradient(circle, var(--dark-accent) 0%, transparent 70%);
    opacity: 0.1;
    animation: float-orbs 15s infinite linear;
}

.orb-1 { width: 100px; height: 100px; top: 10%; left: 10%; animation-delay: 0s; }
.orb-2 { width: 150px; height: 150px; top: 70%; right: 20%; animation-delay: -3s; }
.orb-3 { width: 80px; height: 80px; top: 40%; left: 60%; animation-delay: -6s; }
.orb-4 { width: 120px; height: 120px; top: 20%; right: 40%; animation-delay: -9s; }
.orb-5 { width: 60px; height: 60px; top: 80%; left: 30%; animation-delay: -12s; }
.orb-6 { width: 90px; height: 90px; top: 50%; right: 10%; animation-delay: -15s; }

@keyframes float-orbs {
    0% { transform: translateY(0px) rotate(0deg); opacity: 0.1; }
    50% { transform: translateY(-30px) rotate(180deg); opacity: 0.3; }
    100% { transform: translateY(0px) rotate(360deg); opacity: 0.1; }
}

.grid-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: 
        linear-gradient(rgba(0, 255, 136, 0.03) 1px, transparent 1px),
        linear-gradient(90deg, rgba(0, 255, 136, 0.03) 1px, transparent 1px);
    background-size: 50px 50px;
    animation: grid-move 20s linear infinite;
}

@keyframes grid-move {
    0% { transform: translate(0, 0); }
    100% { transform: translate(50px, 50px); }
}

/* Content */
.dark-container {
    position: relative;
    z-index: 2;
    padding: 60px 0 0;
}

.dark-content {
    margin-bottom: 40px;
}

/* Brand Section */
.dark-brand {
    margin-bottom: 30px;
}

.brand-dark {
    position: relative;
}

.brand-logo-dark {
    display: flex;
    align-items: center;
    gap: 25px;
    margin-bottom: 30px;
}

.logo-hexagon {
    position: relative;
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, var(--dark-accent), var(--dark-accent-2));
    clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
    display: flex;
    align-items: center;
    justify-content: center;
    animation: hexagon-rotate 10s linear infinite;
}

.logo-hexagon i {
    font-size: 2rem;
    color: var(--dark-bg);
    z-index: 2;
}

.hexagon-glow {
    position: absolute;
    top: -10px;
    left: -10px;
    right: -10px;
    bottom: -10px;
    background: linear-gradient(135deg, var(--dark-accent), var(--dark-accent-2));
    clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
    opacity: 0.3;
    filter: blur(10px);
    animation: glow-pulse 2s ease-in-out infinite;
}

@keyframes hexagon-rotate {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

@keyframes glow-pulse {
    0%, 100% { opacity: 0.3; transform: scale(1); }
    50% { opacity: 0.6; transform: scale(1.1); }
}

.brand-text-dark h3 {
    font-size: 2.2rem;
    font-weight: 900;
    color: var(--dark-text);
    margin: 0 0 8px 0;
    text-shadow: 0 0 20px var(--dark-glow);
    letter-spacing: 2px;
}

.brand-subtitle {
    color: var(--dark-accent);
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 3px;
    display: block;
    margin-bottom: 10px;
}

.brand-line {
    width: 60px;
    height: 2px;
    background: linear-gradient(90deg, var(--dark-accent), var(--dark-accent-2));
    animation: line-extend 3s ease-in-out infinite;
}

@keyframes line-extend {
    0%, 100% { width: 60px; }
    50% { width: 120px; }
}

.brand-description-dark {
    color: var(--dark-text-muted);
    line-height: 1.7;
    margin-bottom: 25px;
    font-size: 0.95rem;
}

.tech-stack {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}

.tech-badge-dark {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 15px;
    background: rgba(0, 255, 136, 0.1);
    border: 1px solid var(--dark-border);
    border-radius: 20px;
    color: var(--dark-accent);
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: all 0.3s ease;
}

.tech-badge-dark:hover {
    background: var(--dark-accent);
    color: var(--dark-bg);
    box-shadow: 0 0 20px var(--dark-glow);
}

/* Dark Sections */
.dark-section {
    margin-bottom: 30px;
}

.dark-title {
    display: flex;
    align-items: center;
    gap: 12px;
    color: var(--dark-text);
    font-weight: 700;
    margin-bottom: 25px;
    font-size: 1rem;
    text-transform: uppercase;
    letter-spacing: 2px;
    position: relative;
}

.dark-title i {
    color: var(--dark-accent);
    font-size: 1.1rem;
}

.title-glow {
    position: absolute;
    bottom: -5px;
    left: 0;
    width: 100%;
    height: 2px;
    background: linear-gradient(90deg, var(--dark-accent), transparent);
    animation: title-scan 3s ease-in-out infinite;
}

@keyframes title-scan {
    0%, 100% { width: 0%; }
    50% { width: 100%; }
}

/* Navigation Matrix */
.nav-matrix {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.matrix-link {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 12px 15px;
    background: rgba(0, 255, 136, 0.05);
    border: 1px solid rgba(0, 255, 136, 0.1);
    border-radius: 8px;
    color: var(--dark-text-muted);
    text-decoration: none;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    font-size: 0.85rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.matrix-link::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(0, 255, 136, 0.1), transparent);
    transition: left 0.5s;
}

.matrix-link:hover::before {
    left: 100%;
}

.matrix-link:hover {
    background: rgba(0, 255, 136, 0.1);
    border-color: var(--dark-accent);
    color: var(--dark-accent);
    transform: translateX(10px);
    box-shadow: 0 0 20px rgba(0, 255, 136, 0.2);
}

.link-icon {
    width: 30px;
    height: 30px;
    background: rgba(0, 255, 136, 0.1);
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--dark-accent);
}

.link-arrow {
    margin-left: auto;
    color: var(--dark-accent);
    font-weight: bold;
    transition: transform 0.3s ease;
}

.matrix-link:hover .link-arrow {
    transform: translateX(5px);
}

/* Analytics Grid */
.analytics-grid {
    display: flex;
    flex-direction: column;
    gap: 15px;
    margin-bottom: 30px;
}

.analytics-card {
    background: rgba(0, 255, 136, 0.05);
    border: 1px solid rgba(0, 255, 136, 0.1);
    border-radius: 10px;
    padding: 20px;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.analytics-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 2px;
    background: linear-gradient(90deg, var(--dark-accent), var(--dark-accent-2));
    transform: scaleX(0);
    transition: transform 0.3s ease;
}

.analytics-card:hover::before {
    transform: scaleX(1);
}

.analytics-card:hover {
    background: rgba(0, 255, 136, 0.1);
    border-color: var(--dark-accent);
    box-shadow: 0 10px 30px rgba(0, 255, 136, 0.2);
}

.card-header {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 15px;
    color: var(--dark-text-muted);
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.card-header i {
    color: var(--dark-accent);
}

.card-value {
    font-size: 2rem;
    font-weight: 900;
    color: var(--dark-accent);
    margin-bottom: 10px;
    text-shadow: 0 0 10px var(--dark-glow);
}

.card-progress {
    width: 100%;
    height: 4px;
    background: rgba(0, 255, 136, 0.1);
    border-radius: 2px;
    overflow: hidden;
}

.progress-bar {
    height: 100%;
    background: linear-gradient(90deg, var(--dark-accent), var(--dark-accent-2));
    border-radius: 2px;
    animation: progress-glow 2s ease-in-out infinite;
}

@keyframes progress-glow {
    0%, 100% { box-shadow: 0 0 5px var(--dark-glow); }
    50% { box-shadow: 0 0 15px var(--dark-glow); }
}

/* Social Network */
.social-network {
    text-align: center;
}

.social-title {
    color: var(--dark-text-muted);
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 2px;
    margin-bottom: 20px;
}

.social-dark {
    display: flex;
    justify-content: center;
    gap: 15px;
}

.social-node {
    position: relative;
    width: 50px;
    height: 50px;
    background: rgba(0, 255, 136, 0.1);
    border: 2px solid rgba(0, 255, 136, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--dark-accent);
    text-decoration: none;
    transition: all 0.3s ease;
    overflow: hidden;
}

.node-pulse {
    position: absolute;
    top: -2px;
    left: -2px;
    right: -2px;
    bottom: -2px;
    border: 2px solid var(--dark-accent);
    border-radius: 50%;
    opacity: 0;
    animation: node-pulse 2s ease-in-out infinite;
}

@keyframes node-pulse {
    0% { transform: scale(1); opacity: 1; }
    100% { transform: scale(1.5); opacity: 0; }
}

.social-node:hover {
    background: var(--dark-accent);
    color: var(--dark-bg);
    border-color: var(--dark-accent);
    box-shadow: 0 0 30px var(--dark-glow);
    transform: scale(1.1);
}

/* Footer Terminal */
.footer-terminal {
    background: #000000;
    border: 1px solid var(--dark-border);
    border-radius: 10px;
    margin-top: 40px;
    overflow: hidden;
    box-shadow: 0 10px 40px var(--dark-shadow);
}

.terminal-header {
    background: #1a1a1a;
    padding: 10px 15px;
    display: flex;
    align-items: center;
    gap: 15px;
    border-bottom: 1px solid var(--dark-border);
}

.terminal-controls {
    display: flex;
    gap: 8px;
}

.control {
    width: 12px;
    height: 12px;
    border-radius: 50%;
}

.control.close { background: #ff5f57; }
.control.minimize { background: #ffbd2e; }
.control.maximize { background: #28ca42; }

.terminal-title {
    color: var(--dark-accent);
    font-family: 'Courier New', monospace;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.terminal-body {
    padding: 20px;
    font-family: 'Courier New', monospace;
    font-size: 0.85rem;
    line-height: 1.6;
}

.terminal-line {
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.prompt {
    color: var(--dark-accent);
    font-weight: 600;
}

.command {
    color: var(--dark-text-muted);
    flex: 1;
}

/* Mobile Responsiveness */
@media (max-width: 768px) {
    .dark-container {
        padding: 40px 0 0;
    }
    
    .brand-logo-dark {
        flex-direction: column;
        text-align: center;
        gap: 15px;
    }
    
    .brand-text-dark {
        text-align: center;
    }
    
    .brand-description-dark {
        text-align: center;
    }
    
    .tech-stack {
        justify-content: center;
    }
    
    .dark-title {
        justify-content: center;
    }
    
    .analytics-grid {
        gap: 12px;
    }
    
    .social-dark {
        gap: 12px;
    }
    
    .social-node {
        width: 45px;
        height: 45px;
    }
    
    .terminal-body {
        padding: 15px;
        font-size: 0.75rem;
    }
    
    .terminal-line {
        flex-direction: column;
        align-items: flex-start;
        gap: 5px;
    }
    
    .orb {
        display: none;
    }
}

/* Counter Animation */
.card-value {
    animation: countUp 1s ease-out;
}

@keyframes countUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animate counters
    const counters = document.querySelectorAll('.card-value');
    
    const animateCounter = (counter) => {
        const target = parseInt(counter.getAttribute('data-count'));
        const duration = 2500;
        const step = target / (duration / 16);
        let current = 0;
        
        const timer = setInterval(() => {
            current += step;
            if (current >= target) {
                counter.textContent = target.toLocaleString();
                clearInterval(timer);
            } else {
                counter.textContent = Math.floor(current).toLocaleString();
            }
        }, 16);
    };
    
    // Intersection Observer for counter animation
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counter = entry.target;
                if (!counter.classList.contains('animated')) {
                    counter.classList.add('animated');
                    animateCounter(counter);
                }
            }
        });
    });
    
    counters.forEach(counter => {
        observer.observe(counter);
    });
    
    // Matrix link hover effects
    const matrixLinks = document.querySelectorAll('.matrix-link');
    matrixLinks.forEach(link => {
        link.addEventListener('mouseenter', function() {
            this.style.setProperty('--glow-intensity', '1');
        });
        
        link.addEventListener('mouseleave', function() {
            this.style.setProperty('--glow-intensity', '0');
        });
    });
});
</script>