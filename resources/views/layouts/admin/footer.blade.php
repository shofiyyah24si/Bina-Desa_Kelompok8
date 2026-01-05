<!-- Modern Footer -->
<footer class="modern-footer mt-5">
    <div class="footer-wave">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" class="shape-fill"></path>
            <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" class="shape-fill"></path>
            <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" class="shape-fill"></path>
        </svg>
    </div>
    
    <div class="footer-content">
        <div class="container-fluid">
            <div class="row g-4">
                <!-- Brand Section -->
                <div class="col-lg-4 col-md-6">
                    <div class="footer-brand">
                        <div class="brand-logo">
                            <i class="fas fa-home-heart"></i>
                            <h4>Bina Desa</h4>
                        </div>
                        <p class="brand-description">
                            Sistem Informasi Manajemen Bencana untuk membantu koordinasi dan distribusi bantuan kepada masyarakat yang membutuhkan.
                        </p>
                        <div class="social-links">
                            <a href="#" class="social-link" title="Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="social-link" title="Twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="social-link" title="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="social-link" title="LinkedIn">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-lg-2 col-md-6">
                    <div class="footer-section">
                        <h5 class="footer-title">
                            <i class="fas fa-link me-2"></i>Menu Utama
                        </h5>
                        <ul class="footer-links">
                            <li><a href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                            <li><a href="{{ route('kejadian.index') }}"><i class="fas fa-exclamation-triangle"></i> Kejadian</a></li>
                            <li><a href="{{ route('posko.index') }}"><i class="fas fa-home"></i> Posko</a></li>
                            <li><a href="{{ route('logistik.index') }}"><i class="fas fa-boxes"></i> Logistik</a></li>
                            <li><a href="{{ route('distribusi.index') }}"><i class="fas fa-truck"></i> Distribusi</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Data Management -->
                <div class="col-lg-2 col-md-6">
                    <div class="footer-section">
                        <h5 class="footer-title">
                            <i class="fas fa-database me-2"></i>Data
                        </h5>
                        <ul class="footer-links">
                            <li><a href="{{ route('warga.index') }}"><i class="fas fa-users"></i> Data Warga</a></li>
                            <li><a href="{{ route('donasi.index') }}"><i class="fas fa-hand-holding-heart"></i> Donasi</a></li>
                            <li><a href="{{ route('users.index') }}"><i class="fas fa-user-cog"></i> Pengguna</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Contact & Info -->
                <div class="col-lg-4 col-md-6">
                    <div class="footer-section">
                        <h5 class="footer-title">
                            <i class="fas fa-info-circle me-2"></i>Informasi Sistem
                        </h5>
                        <div class="footer-info">
                            <div class="info-item">
                                <i class="fas fa-code"></i>
                                <div>
                                    <strong>Kelompok 8</strong>
                                    <span>Tim Pengembang</span>
                                </div>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-calendar-alt"></i>
                                <div>
                                    <strong>{{ date('Y') }}</strong>
                                    <span>Tahun Pengembangan</span>
                                </div>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-server"></i>
                                <div>
                                    <strong>Laravel {{ app()->version() }}</strong>
                                    <span>Framework</span>
                                </div>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-shield-alt"></i>
                                <div>
                                    <strong>Secure & Reliable</strong>
                                    <span>Sistem Terpercaya</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="footer-bottom">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="copyright">
                            <i class="fas fa-copyright me-1"></i>
                            {{ date('Y') }} <strong>Bina Desa Kelompok 8</strong>. 
                            <span class="highlight">Semua hak dilindungi</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="footer-stats">
                            <div class="stat-item">
                                <i class="fas fa-users text-primary"></i>
                                <span>{{ \App\Models\Warga::count() }} Warga</span>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-exclamation-triangle text-warning"></i>
                                <span>{{ \App\Models\KejadianBencana::count() }} Kejadian</span>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-hand-holding-heart text-success"></i>
                                <span>{{ \App\Models\DonasiBencana::count() }} Donasi</span>
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
    --footer-primary: #191B47;
    --footer-secondary: #242A61;
    --footer-accent: #F6CFB5;
    --footer-text: #ffffff;
    --footer-text-muted: rgba(255, 255, 255, 0.7);
    --footer-border: rgba(255, 255, 255, 0.1);
}

.modern-footer {
    position: relative;
    background: linear-gradient(135deg, var(--footer-primary) 0%, var(--footer-secondary) 100%);
    color: var(--footer-text);
    overflow: hidden;
}

.footer-wave {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    overflow: hidden;
    line-height: 0;
    transform: rotate(180deg);
}

.footer-wave svg {
    position: relative;
    display: block;
    width: calc(100% + 1.3px);
    height: 60px;
}

.footer-wave .shape-fill {
    fill: #f8f9fa;
}

.footer-content {
    position: relative;
    z-index: 2;
    padding: 60px 0 20px;
}

.footer-brand {
    margin-bottom: 30px;
}

.brand-logo {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
}

.brand-logo i {
    font-size: 2.5rem;
    color: var(--footer-accent);
    margin-right: 15px;
}

.brand-logo h4 {
    color: var(--footer-text);
    margin: 0;
    font-weight: 700;
    font-size: 1.8rem;
}

.brand-description {
    color: var(--footer-text-muted);
    line-height: 1.6;
    margin-bottom: 25px;
}

.social-links {
    display: flex;
    gap: 15px;
}

.social-link {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 45px;
    height: 45px;
    background: rgba(255, 255, 255, 0.1);
    color: var(--footer-text);
    border-radius: 50%;
    text-decoration: none;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.social-link:hover {
    background: var(--footer-accent);
    color: var(--footer-primary);
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(246, 207, 181, 0.3);
}

.footer-section {
    margin-bottom: 30px;
}

.footer-title {
    color: var(--footer-text);
    font-weight: 600;
    margin-bottom: 20px;
    font-size: 1.1rem;
    display: flex;
    align-items: center;
}

.footer-title i {
    color: var(--footer-accent);
}

.footer-links {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-links li {
    margin-bottom: 12px;
}

.footer-links a {
    color: var(--footer-text-muted);
    text-decoration: none;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    padding: 5px 0;
}

.footer-links a i {
    width: 20px;
    margin-right: 10px;
    color: var(--footer-accent);
    font-size: 0.9rem;
}

.footer-links a:hover {
    color: var(--footer-accent);
    padding-left: 10px;
}

.footer-info {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 10px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 10px;
    transition: all 0.3s ease;
}

.info-item:hover {
    background: rgba(255, 255, 255, 0.1);
    transform: translateX(5px);
}

.info-item i {
    width: 35px;
    height: 35px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--footer-accent);
    color: var(--footer-primary);
    border-radius: 8px;
    font-size: 1rem;
}

.info-item div strong {
    display: block;
    color: var(--footer-text);
    font-weight: 600;
    margin-bottom: 2px;
}

.info-item div span {
    color: var(--footer-text-muted);
    font-size: 0.85rem;
}

.footer-bottom {
    border-top: 1px solid var(--footer-border);
    padding-top: 25px;
    margin-top: 40px;
}

.copyright {
    color: var(--footer-text-muted);
    font-size: 0.9rem;
}

.copyright .highlight {
    color: var(--footer-accent);
    font-weight: 600;
}

.footer-stats {
    display: flex;
    justify-content: flex-end;
    gap: 20px;
    flex-wrap: wrap;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 8px;
    color: var(--footer-text-muted);
    font-size: 0.9rem;
    padding: 5px 12px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 20px;
    transition: all 0.3s ease;
}

.stat-item:hover {
    background: rgba(255, 255, 255, 0.1);
    color: var(--footer-text);
}

.stat-item i {
    font-size: 1rem;
}

/* Mobile Responsiveness */
@media (max-width: 768px) {
    .footer-content {
        padding: 40px 0 20px;
    }
    
    .footer-wave svg {
        height: 40px;
    }
    
    .brand-logo {
        justify-content: center;
        text-align: center;
    }
    
    .brand-description {
        text-align: center;
    }
    
    .social-links {
        justify-content: center;
    }
    
    .footer-title {
        text-align: center;
    }
    
    .footer-links {
        text-align: center;
    }
    
    .footer-stats {
        justify-content: center;
        margin-top: 15px;
    }
    
    .stat-item {
        font-size: 0.8rem;
        padding: 4px 10px;
    }
    
    .copyright {
        text-align: center;
        margin-bottom: 15px;
    }
}

/* Animation */
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

.brand-logo i {
    animation: float 3s ease-in-out infinite;
}

/* Scroll Animation */
.footer-section {
    opacity: 0;
    transform: translateY(30px);
    animation: fadeInUp 0.8s ease forwards;
}

.footer-section:nth-child(1) { animation-delay: 0.1s; }
.footer-section:nth-child(2) { animation-delay: 0.2s; }
.footer-section:nth-child(3) { animation-delay: 0.3s; }
.footer-section:nth-child(4) { animation-delay: 0.4s; }

@keyframes fadeInUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
