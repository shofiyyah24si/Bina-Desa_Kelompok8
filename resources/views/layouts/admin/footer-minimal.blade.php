<!-- Minimal Modern Footer -->
<footer class="minimal-footer mt-5">
    <div class="minimal-container">
        <div class="container-fluid">
            <!-- Main Content -->
            <div class="minimal-content">
                <div class="row align-items-center g-4">
                    <!-- Brand & Description -->
                    <div class="col-lg-4 col-md-6">
                        <div class="minimal-brand">
                            <div class="brand-minimal">
                                <div class="brand-icon">
                                    <i class="fas fa-home-heart"></i>
                                </div>
                                <div class="brand-info">
                                    <h4>Bina Desa</h4>
                                    <span>Sistem Manajemen Bencana</span>
                                </div>
                            </div>
                            <p class="brand-desc">
                                Platform digital untuk koordinasi bantuan bencana yang efektif dan tepat sasaran.
                            </p>
                        </div>
                    </div>

                    <!-- Quick Stats -->
                    <div class="col-lg-4 col-md-6">
                        <div class="minimal-stats">
                            <h5 class="stats-title">
                                <i class="fas fa-chart-bar"></i>
                                Data Terkini
                            </h5>
                            <div class="stats-row">
                                <div class="stat-item">
                                    <span class="stat-value">{{ \App\Models\Warga::count() }}</span>
                                    <span class="stat-label">Warga</span>
                                </div>
                                <div class="stat-item">
                                    <span class="stat-value">{{ \App\Models\KejadianBencana::count() }}</span>
                                    <span class="stat-label">Kejadian</span>
                                </div>
                                <div class="stat-item">
                                    <span class="stat-value">{{ \App\Models\DonasiBencana::count() }}</span>
                                    <span class="stat-label">Donasi</span>
                                </div>
                                <div class="stat-item">
                                    <span class="stat-value">{{ \App\Models\LogistikBencana::count() }}</span>
                                    <span class="stat-label">Logistik</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Links & Social -->
                    <div class="col-lg-4 col-md-12">
                        <div class="minimal-links">
                            <h5 class="links-title">
                                <i class="fas fa-link"></i>
                                Akses Cepat
                            </h5>
                            <div class="links-grid">
                                <a href="{{ route('dashboard') }}" class="quick-link">
                                    <i class="fas fa-tachometer-alt"></i>
                                    <span>Dashboard</span>
                                </a>
                                <a href="{{ route('kejadian.index') }}" class="quick-link">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <span>Kejadian</span>
                                </a>
                                <a href="{{ route('posko.index') }}" class="quick-link">
                                    <i class="fas fa-home"></i>
                                    <span>Posko</span>
                                </a>
                                <a href="{{ route('donasi.index') }}" class="quick-link">
                                    <i class="fas fa-hand-holding-heart"></i>
                                    <span>Donasi</span>
                                </a>
                            </div>
                            
                            <!-- Social Links -->
                            <div class="social-minimal">
                                <a href="#" class="social-btn"><i class="fab fa-facebook-f"></i></a>
                                <a href="#" class="social-btn"><i class="fab fa-twitter"></i></a>
                                <a href="#" class="social-btn"><i class="fab fa-instagram"></i></a>
                                <a href="#" class="social-btn"><i class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="minimal-bottom">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="copyright-minimal">
                            <i class="fas fa-copyright"></i>
                            <span>{{ date('Y') }} <strong>Bina Desa Kelompok 8</strong> - Semua hak dilindungi</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="tech-minimal">
                            <span class="tech-item">
                                <i class="fab fa-laravel"></i>
                                Laravel {{ app()->version() }}
                            </span>
                            <span class="tech-item">
                                <i class="fas fa-shield-alt"></i>
                                Secure
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
:root {
    --minimal-primary: #191B47;
    --minimal-secondary: #242A61;
    --minimal-accent: #F6CFB5;
    --minimal-text: #ffffff;
    --minimal-text-muted: rgba(255, 255, 255, 0.8);
    --minimal-border: rgba(255, 255, 255, 0.1);
    --minimal-bg: rgba(255, 255, 255, 0.05);
}

.minimal-footer {
    background: linear-gradient(135deg, var(--minimal-primary) 0%, var(--minimal-secondary) 100%);
    color: var(--minimal-text);
    position: relative;
    overflow: hidden;
}

.minimal-footer::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, 
        var(--minimal-accent) 0%, 
        #FFD700 25%, 
        #FF6B6B 50%, 
        #4ECDC4 75%, 
        var(--minimal-accent) 100%);
    animation: rainbow-slide 3s ease-in-out infinite;
}

@keyframes rainbow-slide {
    0%, 100% { transform: translateX(-100%); }
    50% { transform: translateX(100%); }
}

.minimal-container {
    padding: 50px 0 20px;
    position: relative;
    z-index: 2;
}

/* Brand Section */
.minimal-brand {
    margin-bottom: 20px;
}

.brand-minimal {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 20px;
}

.brand-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, var(--minimal-accent), #FFD700);
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--minimal-primary);
    font-size: 1.8rem;
    box-shadow: 0 8px 25px rgba(246, 207, 181, 0.3);
    animation: gentle-bounce 3s ease-in-out infinite;
}

@keyframes gentle-bounce {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-5px); }
}

.brand-info h4 {
    margin: 0 0 5px 0;
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--minimal-text);
}

.brand-info span {
    color: var(--minimal-accent);
    font-size: 0.9rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.brand-desc {
    color: var(--minimal-text-muted);
    line-height: 1.6;
    margin: 0;
    font-size: 0.95rem;
}

/* Stats Section */
.minimal-stats {
    text-align: center;
}

.stats-title {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    color: var(--minimal-text);
    font-weight: 600;
    margin-bottom: 25px;
    font-size: 1.1rem;
}

.stats-title i {
    color: var(--minimal-accent);
}

.stats-row {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
}

.stat-item {
    background: var(--minimal-bg);
    border-radius: 12px;
    padding: 20px 15px;
    text-align: center;
    transition: all 0.3s ease;
    border: 1px solid var(--minimal-border);
    backdrop-filter: blur(10px);
}

.stat-item:hover {
    background: rgba(255, 255, 255, 0.1);
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
}

.stat-value {
    display: block;
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--minimal-accent);
    line-height: 1;
    margin-bottom: 5px;
}

.stat-label {
    font-size: 0.8rem;
    color: var(--minimal-text-muted);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Links Section */
.minimal-links {
    text-align: center;
}

.links-title {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    color: var(--minimal-text);
    font-weight: 600;
    margin-bottom: 25px;
    font-size: 1.1rem;
}

.links-title i {
    color: var(--minimal-accent);
}

.links-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
    margin-bottom: 25px;
}

.quick-link {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 12px 15px;
    background: var(--minimal-bg);
    border-radius: 10px;
    color: var(--minimal-text-muted);
    text-decoration: none;
    transition: all 0.3s ease;
    border: 1px solid var(--minimal-border);
    font-size: 0.9rem;
}

.quick-link:hover {
    background: var(--minimal-accent);
    color: var(--minimal-primary);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(246, 207, 181, 0.3);
}

.quick-link i {
    font-size: 0.9rem;
    width: 16px;
}

/* Social Links */
.social-minimal {
    display: flex;
    justify-content: center;
    gap: 12px;
}

.social-btn {
    width: 40px;
    height: 40px;
    background: var(--minimal-bg);
    border: 1px solid var(--minimal-border);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--minimal-text-muted);
    text-decoration: none;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.social-btn:hover {
    background: var(--minimal-accent);
    color: var(--minimal-primary);
    transform: translateY(-3px) scale(1.1);
    box-shadow: 0 8px 20px rgba(246, 207, 181, 0.4);
}

/* Footer Bottom */
.minimal-bottom {
    border-top: 1px solid var(--minimal-border);
    padding-top: 25px;
    margin-top: 40px;
}

.copyright-minimal {
    display: flex;
    align-items: center;
    gap: 8px;
    color: var(--minimal-text-muted);
    font-size: 0.9rem;
}

.copyright-minimal i {
    color: var(--minimal-accent);
}

.copyright-minimal strong {
    color: var(--minimal-text);
}

.tech-minimal {
    display: flex;
    justify-content: flex-end;
    gap: 20px;
    flex-wrap: wrap;
}

.tech-item {
    display: flex;
    align-items: center;
    gap: 6px;
    color: var(--minimal-text-muted);
    font-size: 0.85rem;
    padding: 5px 12px;
    background: var(--minimal-bg);
    border-radius: 15px;
    border: 1px solid var(--minimal-border);
}

.tech-item i {
    color: var(--minimal-accent);
    font-size: 0.9rem;
}

/* Mobile Responsiveness */
@media (max-width: 768px) {
    .minimal-container {
        padding: 40px 0 20px;
    }
    
    .brand-minimal {
        flex-direction: column;
        text-align: center;
        gap: 10px;
    }
    
    .brand-desc {
        text-align: center;
    }
    
    .stats-row {
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }
    
    .links-grid {
        grid-template-columns: 1fr;
        gap: 10px;
    }
    
    .tech-minimal {
        justify-content: center;
        margin-top: 15px;
    }
    
    .copyright-minimal {
        justify-content: center;
        text-align: center;
        margin-bottom: 15px;
    }
    
    .stat-value {
        font-size: 1.5rem;
    }
    
    .stat-item {
        padding: 15px 10px;
    }
}

@media (max-width: 576px) {
    .stats-row {
        grid-template-columns: 1fr;
        gap: 12px;
    }
    
    .social-minimal {
        gap: 8px;
    }
    
    .social-btn {
        width: 35px;
        height: 35px;
    }
    
    .tech-minimal {
        flex-direction: column;
        align-items: center;
        gap: 10px;
    }
}

/* Smooth Animations */
.minimal-footer * {
    transition: all 0.3s ease;
}

/* Hover Effects */
.stat-item:hover .stat-value {
    transform: scale(1.1);
    color: var(--minimal-text);
}

.quick-link:hover i {
    transform: scale(1.2);
}

/* Loading Animation */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.minimal-brand,
.minimal-stats,
.minimal-links {
    animation: fadeInUp 0.8s ease-out;
}

.minimal-stats {
    animation-delay: 0.2s;
}

.minimal-links {
    animation-delay: 0.4s;
}
</style>