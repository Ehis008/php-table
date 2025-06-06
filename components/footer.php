<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');

    .footer {
        background-color: #2c2c2c;
        padding: 3rem 0;
        font-family: 'Poppins', sans-serif;
        color: #ffffff;
    }

    .footer h3 {
        font-weight: 700;
        margin-bottom: 1.5rem;
    }

    .footer h4 {
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .footer p, .footer a {
        font-weight: 400;
        margin-bottom: 0.5rem;
    }

    .footer .hover-link {
        color: #ffffff;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .footer .hover-link:hover {
        color: #0d6efd !important;
    }

    .footer .social-link {
        display: inline-block;
        color: #ffffff;
        font-size: 1.5rem;
        margin: 0 0.5rem;
        transition: transform 0.3s ease, color 0.3s ease;
    }

    .footer .social-link:hover {
        color: #0d6efd;
        transform: scale(1.05);
    }

    .footer .contact-card, .footer .nav-card {
        background-color: #333333;
        border-radius: 10px;
        padding: 1.5rem;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .footer .contact-card:hover, .footer .nav-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
    }

    .footer i {
        margin-right: 0.5rem;
    }

    .footer .copyright {
        margin-top: 2rem;
        font-size: 0.9rem;
        color: #cccccc;
    }

    @media (max-width: 767px) {
        .footer .contact-card, .footer .nav-card {
            margin-bottom: 1.5rem;
        }
        .footer h3 {
            font-size: 1.5rem;
        }
        .footer h4 {
            font-size: 1.2rem;
        }
        .footer .social-link {
            font-size: 1.3rem;
        }
    }
</style>

<footer class="footer text-white text-center">
    <div class="container">
        <div class="row">
            <!-- Contact Section -->
            <div class="col-md-4">
                <div class="contact-card">
                    <h3>Contact Us</h3>
                    <p><i class="bi bi-envelope"></i> <a href="mailto:belovedogbu@gmail.com" class="hover-link">belovedogbu@gmail.com</a></p>
                    <p><i class="bi bi-phone"></i> <a href="tel:07030173746" class="hover-link">07030173746</a></p>
                    <p><i class="bi bi-geo-alt"></i> 123 Rental St, City, Country</p>
                </div>
            </div>
            <!-- Navigation Section -->
            <div class="col-md-4">
                <div class="nav-card">
                    <h4>Quick Links</h4>
                    <p><a href="index.php" class="hover-link">Home</a></p>
                    <p><a href="cars.php" class="hover-link">Rent a Car</a></p>
                    <p><a href="terms.php" class="hover-link">Terms</a></p>
                    <p><a href="admins/login.php" class="hover-link">Admin</a></p>
                    <?php if (isset($_SESSION['customer_id'])): ?>
                        <p><a href="myrentals.php" class="hover-link">My Rentals</a></p>
                    <?php endif; ?>
                </div>
            </div>
            <!-- Social Media Section -->
            <div class="col-md-4">
                <div class="contact-card">
                    <h4>Follow Us</h4>
                    <p>
                        <a href="https://x.com/Magg10995" class="social-link" target="_blank"><i class="bi bi-twitter"></i></a>
                        <a href="https://facebook.com/BartholomewItodo" class="social-link" target="_blank"><i class="bi bi-facebook"></i></a>
                        <a href="https://instagram.com/bartholomewitodo" class="social-link" target="_blank"><i class="bi bi-instagram"></i></a>
                    </p>
                </div>
            </div>
        </div>
        <div class="copyright">
            <p>&copy; 2025 DriveLite Rentals. All rights reserved.</p>
        </div>
    </div>
</footer>
