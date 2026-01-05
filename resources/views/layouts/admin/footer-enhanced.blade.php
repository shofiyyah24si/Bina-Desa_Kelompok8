<!-- Enhanced Modern Footer with Advanced Animations -->
<footer class="enhanced-footer mt-5">
    <!-- Animated Background -->
    <div class="footer-bg-animation">
        <div class="floating-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
            <div class="shape shape-4"></div>
            <div class="shape shape-5"></div>
        </div>
    </div>

    <!-- Wave Animation -->
    <div class="footer-wave-enhanced">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
            <defs>
                <linearGradient id="waveGradient" x1="0%" y1="0%" x2="100%" y2="0%">
                    <stop offset="0%" style="stop-color:#F6CFB5;stop-opacity:0.8" />
                    <stop offset="50%" style="stop-color:#191B47;stop-opacity:0.6" />
                    <stop offset="100%" style="stop-color:#F6CFB5;stop-opacity:0.8" />
                </linearGradient>
            </defs>
            <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" 
                  fill="url(#waveGradient)" class="wave-path wave-1">
                <animateTransform attributeName="transform" type="translate" 
                                values="0 0;50 0;0 0" dur="8s" repeatCount="indefinite"/>
            </path>
            <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" 
                  fill="url(#waveGradient)" opacity="0.7" class="wave-path wave-2">
                <animateTransform attributeName="transform" type="translate" 
                                values="0 0;-30 0;0 0" dur="6s" repeatCount="indefinite"/>
            </path>
            <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" 
                  fill="#f8f9fa" class="wave-path wave-3">
            </path>
        </svg>
    </div>
    
    <div class="footer-content-enhanced">
        <div class="container-fluid">
            <!-- Main Content Grid -->
            <div class="row g-4 mb-5">
                <!-- Brand Section with Enhanced Animation -->
                <div class="col-lg-4 col-md-6">
                    <div class="footer-brand-enhanced">
                        <div class="brand-logo-enhanced">
                            <div class="logo-container">
                                <i class="fas fa-home-heart"></i>
                                <div class="logo-glow"></div>
                            </div>
                            <div class="brand-text">
                                <h4>Bina Desa</h4>
                                <span class="brand-tagline">Sistem Manajemen Bencana</span>
                            </div>
                        </div>
                        <p class="brand-description-enhanced">
                            Platform terintegrasi untuk koordinasi bantuan bencana, 
                            menghubungkan masyarakat dengan bantuan yang tepat sasaran.
                        </p>
                        <div class="social-links-enhanced">
                            <a href="#" class="social-link-enhanced facebook" title="Facebook">
                                <i class="fab fa-facebook-f"></i>
                                <span class="social-tooltip">Facebook</span>
                            </a>
                            <a href="#" class="social-link-enhanced twitter" title="Twitter">
                                <i class="fab fa-twitter"></i>
                                <span class="social-tooltip">Twitter</span>
                            </a>
                            <a href="#" class="social-link-enhanced instagram" title="Instagram">
                                <i class="fab fa-instagram"></i>
                                <span class="social-tooltip">Instagram</span>
                            </a>
                            <a href="#" class="social-link-enhanced linkedin" title="LinkedIn">
                                <i class="fab fa-linkedin-in"></i>
                                <span class="social-tooltip">LinkedIn</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Quick Navigation -->
                <div class="col-lg-2 col-md-6">
                    <div class="footer-section-enhanced">
                        <h5 class="footer-title-enhanced">
                            <i class="fas fa-compass"></i>
                            <span>Navigasi</span>
                        </h5>
                        <ul class="footer-links-enhanced">
                            <li><a href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
                            <li><a href="{{ route('kejadian.index') }}"><i class="fas fa-exclamation-triangle"></i>Kejadian</a></li>
                            <li><a href="{{ route('posko.index') }}"><i class="fas fa-home"></i>Posko</a></li>
                            <li><a href="{{ route('logistik.index') }}"><i class="fas fa-boxes"></i>Logistik</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Data Management -->
                <div class="col-lg-2 col-md-6">
                    <div class="footer-section-enhanced">
                        <h5 class="footer-title-enhanced">
                            <i class="fas fa-database"></i>
                            <span>Manajemen</span>
                        </h5>
                        <ul class="footer-links-enhanced">
                            <li><a href="{{ route('warga.index') }}"><i class="fas fa-users"></i>Data Warga</a></li>
                            <li><a href="{{ route('donasi.index') }}"><i class="fas fa-hand-holding-heart"></i>Donasi</a></li>
                            <li><a href="{{ route('distribusi.index') }}"><i class="fas fa-truck"></i>Distribusi</a></li>
                            <li><a href="{{ route('users.index') }}"><i class="fas fa-user-cog"></i>Pengguna</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Live Statistics -->
                <div class="col-lg-4 col-md-6">
                    <div class="footer-section-enhanced">
                        <h5 class="footer-title-enhanced">
                            <i class="fas fa-chart-line"></i>
                            <span>Statistik Real-time</span>
                        </h5>
                        <div class="stats-grid">
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="stat-info">
                                    <span class="stat-number" data-count="{{ \App\Models\Warga::count() }}">0</span>
                                    <span class="stat-label">Total Warga</span>
                                </div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                                <div class="stat-info">
                                    <span class="stat-number" data-count="{{ \App\Models\KejadianBencana::count() }}">0</span>
                                    <span class="stat-label">Kejadian Bencana</span>
                                </div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-hand-holding-heart"></i>
                                </div>
                                <div class="stat-info">
                                    <span class="stat-number" data-count="{{ \App\Models\DonasiBencana::count() }}">0</span>
                                    <span class="stat-label">Total Donasi</span>
                                </div>
                            </div>
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-boxes"></i>
                                </div>
                                <div class="stat-info">
                                    <span class="stat-number" data-count="{{ \App\Models\LogistikBencana::count() }}">0</span>
                                    <span class="stat-label">Item Logistik</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Bottom Enhanced -->
            <div class="footer-bottom-enhanced">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="copyright-enhanced">
                            <div class="copyright-icon">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <div class="copyright-text">
                                <strong>© {{ date('Y') }} Bina Desa Kelompok 8</strong>
                                <span>Dikembangkan dengan ❤️ untuk Indonesia</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="tech-info">
                            <div class="tech-badge">
                                <i class="fab fa-laravel"></i>
                                <span>Laravel {{ app()->version() }}</span>
                            </div>
                            <div class="tech-badge">
                                <i class="fas fa-server"></i>
                                <span>Secure & Fast</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
:root {
    --enhanced-primary: #191B47;
    --enhanced-secondary: #242A61;
    --enhanced-accent: #F6CFB5;
    --enhanced-gradient: linear-gradient(135deg, #191B47 0%, #242A61 50%, #2D3478 100%);
    --enhanced-text: #ffffff;
    --enhanced-text-muted: rgba(255, 255, 255, 0.8);
    --enhanced-glow: rgba(246, 207, 181, 0.3);
}

.enhanced-footer {
    position: relative;
    background: var(--enhanced-gradient);
    color: var(--enhanced-text);
    overflow: hidden;
    min-height: 500px;
}

/* Floating Background Shapes */
.footer-bg-animation {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
    z-index: 1;
}

.floating-shapes {
    position: relative;
    width: 100%;
    height: 100%;
}

.shape {
    position: absolute;
    background: var(--enhanced-accent);
    opacity: 0.1;
    border-radius: 50%;
    animation: float-shapes 20s infinite linear;
}

.shape-1 {
    width: 80px;
    height: 80px;
    top: 20%;
    left: 10%;
    animation-delay: 0s;
}

.shape-2 {
    width: 120px;
    height: 120px;
    top: 60%;
    right: 15%;
    animation-delay: -5s;
}

.shape-3 {
    width: 60px;
    height: 60px;
    top: 80%;
    left: 70%;
    animation-delay: -10s;
}

.shape-4 {
    width: 100px;
    height: 100px;
    top: 30%;
    right: 40%;
    animation-delay: -15s;
}

.shape-5 {
    width: 40px;
    height: 40px;
    top: 10%;
    right: 25%;
    animation-delay: -8s;
}

@keyframes float-shapes {
    0% {
        transform: translateY(0px) rotate(0deg);
        opacity: 0.1;
    }
    50% {
        transform: translateY(-20px) rotate(180deg);
        opacity: 0.2;
    }
    100% {
        transform: translateY(0px) rotate(360deg);
        opacity: 0.1;
    }
}

/* Enhanced Wave */
.footer-wave-enhanced {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    overflow: hidden;
    line-height: 0;
    transform: rotate(180deg);
    z-index: 2;
}

.footer-wave-enhanced svg {
    position: relative;
    display: block;
    width: calc(100% + 1.3px);
    height: 80px;
}

/* Content */
.footer-content-enhanced {
    position: relative;
    z-index: 3;
    padding: 80px 0 30px;
}

/* Enhanced Brand */
.footer-brand-enhanced {
    margin-bottom: 30px;
}

.brand-logo-enhanced {
    display: flex;
    align-items: center;
    margin-bottom: 25px;
    gap: 20px;
}

.logo-container {
    position: relative;
    width: 70px;
    height: 70px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.logo-container i {
    font-size: 2.5rem;
    color: var(--enhanced-accent);
    z-index: 2;
    position: relative;
    animation: pulse-glow 2s ease-in-out infinite;
}

.logo-glow {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 80px;
    height: 80px;
    background: radial-gradient(circle, var(--enhanced-glow) 0%, transparent 70%);
    border-radius: 50%;
    animation: glow-pulse 2s ease-in-out infinite;
}

.brand-text h4 {
    color: var(--enhanced-text);
    margin: 0 0 5px 0;
    font-weight: 700;
    font-size: 2rem;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
}

.brand-tagline {
    color: var(--enhanced-accent);
    font-size: 0.9rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.brand-description-enhanced {
    color: var(--enhanced-text-muted);
    line-height: 1.7;
    margin-bottom: 30px;
    font-size: 1rem;
}

/* Enhanced Social Links */
.social-links-enhanced {
    display: flex;
    gap: 15px;
}

.social-link-enhanced {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 50px;
    height: 50px;
    background: rgba(255, 255, 255, 0.1);
    color: var(--enhanced-text);
    border-radius: 15px;
    text-decoration: none;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    overflow: hidden;
}

.social-link-enhanced::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.social-link-enhanced:hover::before {
    left: 100%;
}

.social-link-enhanced:hover {
    transform: translateY(-5px) scale(1.1);
    box-shadow: 0 15px 35px var(--enhanced-glow);
}

.social-link-enhanced.facebook:hover { background: #1877f2; }
.social-link-enhanced.twitter:hover { background: #1da1f2; }
.social-link-enhanced.instagram:hover { background: linear-gradient(45deg, #f09433 0%,#e6683c 25%,#dc2743 50%,#cc2366 75%,#bc1888 100%); }
.social-link-enhanced.linkedin:hover { background: #0077b5; }

.social-tooltip {
    position: absolute;
    bottom: 120%;
    left: 50%;
    transform: translateX(-50%);
    background: var(--enhanced-primary);
    color: var(--enhanced-text);
    padding: 5px 10px;
    border-radius: 5px;
    font-size: 0.8rem;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.3s;
    white-space: nowrap;
}

.social-link-enhanced:hover .social-tooltip {
    opacity: 1;
}

/* Enhanced Sections */
.footer-section-enhanced {
    margin-bottom: 30px;
}

.footer-title-enhanced {
    display: flex;
    align-items: center;
    gap: 12px;
    color: var(--enhanced-text);
    font-weight: 600;
    margin-bottom: 25px;
    font-size: 1.2rem;
    position: relative;
}

.footer-title-enhanced::after {
    content: '';
    position: absolute;
    bottom: -8px;
    left: 0;
    width: 50px;
    height: 3px;
    background: linear-gradient(90deg, var(--enhanced-accent), transparent);
    border-radius: 2px;
}

.footer-title-enhanced i {
    color: var(--enhanced-accent);
    font-size: 1.1rem;
}

.footer-links-enhanced {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-links-enhanced li {
    margin-bottom: 15px;
}

.footer-links-enhanced a {
    color: var(--enhanced-text-muted);
    text-decoration: none;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 8px 0;
    border-radius: 8px;
    position: relative;
    overflow: hidden;
}

.footer-links-enhanced a::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    width: 0;
    height: 100%;
    background: rgba(246, 207, 181, 0.1);
    transition: width 0.3s ease;
    z-index: -1;
}

.footer-links-enhanced a:hover::before {
    width: 100%;
}

.footer-links-enhanced a:hover {
    color: var(--enhanced-accent);
    padding-left: 15px;
}

.footer-links-enhanced a i {
    width: 20px;
    color: var(--enhanced-accent);
    font-size: 0.9rem;
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 15px;
}

.stat-card {
    background: rgba(255, 255, 255, 0.05);
    border-radius: 15px;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 15px;
    transition: all 0.3s ease;
    border: 1px solid rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
}

.stat-card:hover {
    background: rgba(255, 255, 255, 0.1);
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
}

.stat-icon {
    width: 45px;
    height: 45px;
    background: var(--enhanced-accent);
    color: var(--enhanced-primary);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
}

.stat-info {
    flex: 1;
}

.stat-number {
    display: block;
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--enhanced-text);
    line-height: 1;
}

.stat-label {
    font-size: 0.85rem;
    color: var(--enhanced-text-muted);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Enhanced Footer Bottom */
.footer-bottom-enhanced {
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    padding-top: 30px;
    margin-top: 50px;
}

.copyright-enhanced {
    display: flex;
    align-items: center;
    gap: 15px;
}

.copyright-icon {
    width: 40px;
    height: 40px;
    background: var(--enhanced-accent);
    color: var(--enhanced-primary);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.copyright-text strong {
    display: block;
    color: var(--enhanced-text);
    font-size: 1rem;
    margin-bottom: 3px;
}

.copyright-text span {
    color: var(--enhanced-text-muted);
    font-size: 0.9rem;
}

.tech-info {
    display: flex;
    justify-content: flex-end;
    gap: 15px;
    flex-wrap: wrap;
}

.tech-badge {
    display: flex;
    align-items: center;
    gap: 8px;
    background: rgba(255, 255, 255, 0.1);
    padding: 8px 15px;
    border-radius: 20px;
    color: var(--enhanced-text-muted);
    font-size: 0.9rem;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.tech-badge i {
    color: var(--enhanced-accent);
}

/* Animations */
@keyframes pulse-glow {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

@keyframes glow-pulse {
    0%, 100% { opacity: 0.5; transform: translate(-50%, -50%) scale(1); }
    50% { opacity: 0.8; transform: translate(-50%, -50%) scale(1.1); }
}

/* Counter Animation */
@keyframes countUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.stat-number {
    animation: countUp 0.8s ease-out;
}

/* Mobile Responsiveness */
@media (max-width: 768px) {
    .footer-content-enhanced {
        padding: 60px 0 20px;
    }
    
    .brand-logo-enhanced {
        flex-direction: column;
        text-align: center;
        gap: 15px;
    }
    
    .brand-text {
        text-align: center;
    }
    
    .brand-description-enhanced {
        text-align: center;
    }
    
    .social-links-enhanced {
        justify-content: center;
    }
    
    .footer-title-enhanced {
        justify-content: center;
    }
    
    .footer-links-enhanced {
        text-align: center;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .tech-info {
        justify-content: center;
        margin-top: 20px;
    }
    
    .copyright-enhanced {
        justify-content: center;
        text-align: center;
        margin-bottom: 20px;
    }
    
    .shape {
        display: none;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animate counters
    const counters = document.querySelectorAll('.stat-number');
    
    const animateCounter = (counter) => {
        const target = parseInt(counter.getAttribute('data-count'));
        const duration = 2000;
        const step = target / (duration / 16);
        let current = 0;
        
        const timer = setInterval(() => {
            current += step;
            if (current >= target) {
                counter.textContent = target;
                clearInterval(timer);
            } else {
                counter.textContent = Math.floor(current);
            }
        }, 16);
    };
    
    // Intersection Observer for counter animation
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counter = entry.target.querySelector('.stat-number');
                if (counter && !counter.classList.contains('animated')) {
                    counter.classList.add('animated');
                    animateCounter(counter);
                }
            }
        });
    });
    
    document.querySelectorAll('.stat-card').forEach(card => {
        observer.observe(card);
    });
});
</script>