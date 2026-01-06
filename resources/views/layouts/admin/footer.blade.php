<!-- Ultra Simple Footer -->
<footer class="ultra-simple-footer mt-5">
    <div class="footer-container">
        <div class="container-fluid">
            <div class="row align-items-center">
                <!-- Left: Copyright -->
                <div class="col-md-8">
                    <div class="copyright-text">
                        <i class="fas fa-shield-alt"></i>
                        <span>© {{ date('Y') }} <strong>Kelompok 8</strong> - Sistem Kebencanaan & Tanggap Darurat</span>
                    </div>
                </div>

                <!-- Right: Social Links -->
                <div class="col-md-4">
                    <div class="social-links">
                        <a href="#" class="social-btn facebook" title="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-btn twitter" title="Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="social-btn instagram" title="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="social-btn linkedin" title="LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
:root {
    --ultra-primary: #191B47;
    --ultra-secondary: #242A61;
    --ultra-accent: #F6CFB5;
    --ultra-text: #ffffff;
    --ultra-text-muted: rgba(255, 255, 255, 0.8);
    --ultra-border: rgba(255, 255, 255, 0.1);
}

.ultra-simple-footer {
    background: linear-gradient(135deg, var(--ultra-primary) 0%, var(--ultra-secondary) 100%);
    color: var(--ultra-text);
    position: relative;
    overflow: hidden;
}

.ultra-simple-footer::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, 
        var(--ultra-accent) 0%, 
        #FFD700 25%, 
        #FF6B6B 50%, 
        #4ECDC4 75%, 
        var(--ultra-accent) 100%);
    animation: gradient-slide 4s ease-in-out infinite;
}

@keyframes gradient-slide {
    0%, 100% { transform: translateX(-100%); }
    50% { transform: translateX(100%); }
}

.footer-container {
    padding: 25px 0;
    position: relative;
    z-index: 2;
}

/* Copyright Text */
.copyright-text {
    display: flex;
    align-items: center;
    gap: 10px;
    color: var(--ultra-text-muted);
    font-size: 0.9rem;
}

.copyright-text i {
    color: var(--ultra-accent);
    font-size: 1.1rem;
}

.copyright-text strong {
    color: var(--ultra-text);
    font-weight: 600;
}

/* Social Links */
.social-links {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
}

.social-btn {
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid var(--ultra-border);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--ultra-text-muted);
    text-decoration: none;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.social-btn:hover {
    transform: translateY(-3px) scale(1.1);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
}

.social-btn.facebook:hover {
    background: #1877f2;
    color: white;
    border-color: #1877f2;
    box-shadow: 0 8px 20px rgba(24, 119, 242, 0.4);
}

.social-btn.twitter:hover {
    background: #1da1f2;
    color: white;
    border-color: #1da1f2;
    box-shadow: 0 8px 20px rgba(29, 161, 242, 0.4);
}

.social-btn.instagram:hover {
    background: linear-gradient(45deg, #f09433 0%,#e6683c 25%,#dc2743 50%,#cc2366 75%,#bc1888 100%);
    color: white;
    border-color: #e6683c;
    box-shadow: 0 8px 20px rgba(230, 104, 60, 0.4);
}

.social-btn.linkedin:hover {
    background: #0077b5;
    color: white;
    border-color: #0077b5;
    box-shadow: 0 8px 20px rgba(0, 119, 181, 0.4);
}

/* Mobile Responsiveness */
@media (max-width: 768px) {
    .footer-container {
        padding: 20px 0;
    }
    
    .copyright-text {
        justify-content: center;
        text-align: center;
        margin-bottom: 15px;
        font-size: 0.85rem;
    }
    
    .social-links {
        justify-content: center;
        gap: 10px;
    }
    
    .social-btn {
        width: 36px;
        height: 36px;
    }
}

@media (max-width: 576px) {
    .copyright-text {
        flex-direction: column;
        gap: 5px;
        font-size: 0.8rem;
    }
    
    .social-links {
        gap: 8px;
    }
    
    .social-btn {
        width: 34px;
        height: 34px;
    }
}

/* Smooth Animations */
.ultra-simple-footer * {
    transition: all 0.3s ease;
}

/* Loading Animation */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.copyright-text,
.social-links {
    animation: fadeIn 0.6s ease-out;
}

.social-links {
    animation-delay: 0.2s;
}

/* Hover Effects */
.social-btn i {
    transition: transform 0.3s ease;
}

.social-btn:hover i {
    transform: scale(1.2);
}
</style>
