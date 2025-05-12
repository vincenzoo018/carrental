<footer class="footer mt-auto py-3 bg-dark text-white">
    <div class="container">
        <div class="row align-items-center gy-3">
            <div class="col-md-4 text-center text-md-start">
                <span class="fw-bold">CarRental</span> &mdash; Making your journey comfortable.
            </div>
            <div class="col-md-4 text-center">
                <a href="{{ route('user.home') }}" class="footer-link mx-2">Home</a>
                <a href="{{ route('user.cars') }}" class="footer-link mx-2">Cars</a>
                <a href="{{ route('user.reservations') }}" class="footer-link mx-2">Rentals</a>
                <a href="{{ route('user.bookings') }}" class="footer-link mx-2">Services</a>
            </div>
            <div class="col-md-4 text-center text-md-end">
                <a href="https://facebook.com/carrental" class="text-white-50 mx-1" target="_blank"><i class="fab fa-facebook-f"></i></a>
                <a href="https://twitter.com/carrental" class="text-white-50 mx-1" target="_blank"><i class="fab fa-twitter"></i></a>
                <a href="https://instagram.com/carrental" class="text-white-50 mx-1" target="_blank"><i class="fab fa-instagram"></i></a>
                <a href="https://linkedin.com/company/carrental" class="text-white-50 mx-1" target="_blank"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-12 text-center small text-white-50">
                &copy; {{ date('Y') }} CarRental System. All rights reserved.
            </div>
        </div>
    </div>
    <style>
        .footer {
            font-size: 0.97rem;
            box-shadow: 0 -1px 8px rgba(0, 0, 0, 0.04);
        }

        .footer-link {
            color: #fff;
            text-decoration: none;
            transition: color 0.2s;
        }

        .footer-link:hover {
            color: #0d6efd;
            text-decoration: underline;
        }

        .footer .social-icons a,
        .footer a i {
            transition: color 0.2s;
        }

        .footer .social-icons a:hover,
        .footer a i:hover {
            color: #0d6efd !important;
        }
    </style>
</footer>