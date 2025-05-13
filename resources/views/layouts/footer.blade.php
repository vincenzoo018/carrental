<footer class="footer mt-auto py-3">
    <div class="footer-top">
        <div class="container">
            <div class="row gy-4 gx-5">
                <div class="col-lg-4 col-md-6">
                    <div class="footer-brand">
                        <div class="logo-container">
                            <svg class="logo-icon" viewBox="0 0 24 24" width="36" height="36">
                                <path d="M3,12h18M7,5h10c2,0,3,1,3,3v8c0,2-1,3-3,3H7c-2,0-3-1-3-3V8c0-2,1-3,3-3z M6,16h2M16,16h2" stroke="#fff" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <h3 class="mb-0">Bridge Method</h3>
                        </div>
                        <p class="mt-3">Connecting you to exceptional journeys with premium vehicles and unmatched service.</p>
                        <div class="footer-newsletter mt-4">
                            <h6 class="fw-bold mb-3">Get exclusive offers</h6>
                            <div class="input-group">
                                <input type="email" class="form-control" placeholder="Your email" aria-label="Your email">
                                <button class="btn btn-primary" type="button">Subscribe</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6">
                    <h5 class="footer-heading">Explore</h5>
                    <ul class="footer-links">
                        <li><a href="{{ route('user.home') }}">Home</a></li>
                        <li><a href="{{ route('user.cars') }}">Fleet</a></li>
                        <li><a href="{{ route('user.reservations') }}">Reservations</a></li>
                        <li><a href="{{ route('user.bookings') }}">Services</a></li>

                    </ul>
                </div>



                <div class="col-lg-4 col-md-6">
                    <h5 class="footer-heading">Connect With Us</h5>
                    <div class="social-icons">
                        <a href="https://facebook.com/bridgemethod" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://twitter.com/bridgemethod" target="_blank"><i class="fab fa-twitter"></i></a>
                        <a href="https://instagram.com/bridgemethod" target="_blank"><i class="fab fa-instagram"></i></a>
                        <a href="https://linkedin.com/company/bridgemethod" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                        <a href="https://youtube.com/bridgemethod" target="_blank"><i class="fab fa-youtube"></i></a>
                    </div>

                    <div class="contact-info mt-4">
                        <div class="contact-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <p>123 Rental Avenue, Business District, City</p>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-phone-alt"></i>
                            <p>+1 (800) BRIDGE-CAR</p>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-envelope"></i>
                            <p>support@bridgemethod.com</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-md-0">&copy; {{ date('Y') }} Bridge Method Car Rental. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="payment-methods">
                        <span>Payment Methods:</span>
                        <i class="fab fa-cc-visa"></i>
                        <i class="fab fa-cc-mastercard"></i>
                        <i class="fab fa-cc-amex"></i>
                        <i class="fab fa-cc-paypal"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
    .footer {
        background-color: #1a1a2e;
        color: #fff;
        font-family: 'Poppins', sans-serif;
    }

    .footer-top {
        padding: 4rem 0 3rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .logo-container {
        display: flex;
        align-items: center;
    }

    .logo-icon {
        margin-right: 10px;
    }

    .footer-brand h3 {
        color: #fff;
        font-weight: 600;
        font-size: 1.5rem;
    }

    .footer-brand p {
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.95rem;
        line-height: 1.6;
    }

    .footer-newsletter input {
        border-radius: 4px 0 0 4px;
        background: rgba(255, 255, 255, 0.1);
        border: none;
        color: #fff;
        padding: 0.6rem 1rem;
    }

    .footer-newsletter input::placeholder {
        color: rgba(255, 255, 255, 0.5);
    }

    .footer-newsletter button {
        border-radius: 0 4px 4px 0;
        background: #0066cc;
        border: none;
        font-weight: 500;
        padding: 0.6rem 1.2rem;
        transition: all 0.3s ease;
    }

    .footer-newsletter button:hover {
        background: #0052a3;
    }

    .footer-heading {
        color: #fff;
        font-weight: 600;
        margin-bottom: 1.5rem;
        font-size: 1.2rem;
        position: relative;
        padding-bottom: 0.75rem;
    }

    .footer-heading:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 2px;
        background: #0066cc;
    }

    .footer-links {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-links li {
        margin-bottom: 0.75rem;
    }

    .footer-links a {
        color: rgba(255, 255, 255, 0.7);
        text-decoration: none;
        transition: all 0.3s ease;
        font-size: 0.95rem;
        display: block;
        position: relative;
        padding-left: 15px;
    }

    .footer-links a:before {
        content: '›';
        position: absolute;
        left: 0;
        top: -2px;
        transition: all 0.3s ease;
        color: #0066cc;
        font-size: 1.2rem;
    }

    .footer-links a:hover {
        color: #fff;
        transform: translateX(5px);
    }

    .social-icons {
        display: flex;
        gap: 15px;
    }

    .social-icons a {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
        transition: all 0.3s ease;
    }

    .social-icons a:hover {
        background: #0066cc;
        transform: translateY(-5px);
    }

    .contact-item {
        display: flex;
        margin-bottom: 1rem;
        align-items: flex-start;
    }

    .contact-item i {
        color: #0066cc;
        margin-right: 15px;
        margin-top: 5px;
    }

    .contact-item p {
        color: rgba(255, 255, 255, 0.7);
        margin: 0;
        font-size: 0.95rem;
    }

    .footer-bottom {
        padding: 1.5rem 0;
        font-size: 0.9rem;
    }

    .footer-bottom p {
        color: rgba(255, 255, 255, 0.7);
        margin: 0;
    }

    .payment-methods {
        display: flex;
        align-items: center;
        gap: 10px;
        color: rgba(255, 255, 255, 0.7);
    }

    .payment-methods i {
        font-size: 1.5rem;
        transition: all 0.3s ease;
    }

    .payment-methods i:hover {
        color: #0066cc;
    }

    @media (max-width: 992px) {
        .footer-top {
            padding: 3rem 0 2rem;
        }
    }

    @media (max-width: 767px) {
        .footer-bottom {
            text-align: center;
        }

        .payment-methods {
            justify-content: center;
            margin-top: 1rem;
        }
    }
</style>
