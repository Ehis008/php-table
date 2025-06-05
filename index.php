<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - DriveLite Rentals</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/index.css">
</head>
<body>
    <?php require_once "components/navbar.php"; ?>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-image">
            <img src="carimages/car1.jpg" alt="DriveLite Rentals Hero Car" class="img-fluid">
        </div>
        <div class="container text-center">
            <h1>Welcome to DriveLite Rentals</h1>
            <p class="lead">Drive your journey with ease and style.</p>
            <a href="cars.php" class="btn btn-primary btn-lg mt-3">Rent a Car Now</a>
            <?php if (!isset($_SESSION['customer_id'])): ?>
                <a href="login.php" class="btn btn-outline-light btn-lg mt-3 ms-2">Log In</a>
            <?php else: ?>
                <a href="myrentals.php" class="btn btn-outline-light btn-lg mt-3 ms-2">View My Rentals</a>
            <?php endif; ?>
        </div>
    </section>

    <!-- About Section -->
    <section class="py-5 about-section">
        <div class="container">
            <h2 class="text-center mb-4">About DriveLite Rentals</h2>
            <div class="row">
                <div class="col-md-6 mb-4">
                    <p>DriveLite Rentals is your trusted partner for car rentals, offering a wide range of vehicles at affordable rates. With a focus on customer satisfaction, we provide reliable cars and seamless rental experiences.</p>
                </div>
                <div class="col-md-6 mb-4">
                    <img src="carimages/car1.jpg" alt="DriveLite Car" class="img-fluid rounded">
                </div>
            </div>
        </div>
    </section>

    <!-- Fleet Preview Section -->
    <section class="py-5 fleet-section">
        <div class="container">
            <h2 class="text-center mb-4">Our Fleet</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="carimages/car2.jpg" alt="Car 1" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title">Sedan</h5>
                            <p>Perfect for city drives.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="carimages/car3.jpg" alt="Car 2" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title">SUV</h5>
                            <p>Ideal for family trips.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="carimages/car16.jpg" alt="Car 3" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title">Luxury</h5>
                            <p>Travel in style.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <a href="cars.php" class="btn btn-primary">Explore All Cars</a>
            </div>
        </div>
    </section>

    <section class="py-5 testimonials-section">
        <div class="container">
            <h2 class="text-center mb-4">What Our Customers Say</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <p class="card-text">"DriveLite made my trip unforgettable! The car was spotless, and the service was top-notch."</p>
                            <p class="card-subtitle text-muted">— John D.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <p class="card-text">"Affordable prices and easy booking process. Highly recommend!"</p>
                            <p class="card-subtitle text-muted">— Sarah K.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <p class="card-text">"The best rental experience I’ve had. Will definitely use again!"</p>
                            <p class="card-subtitle text-muted">— Michael T.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 faq-section">
        <div class="container">
            <h2 class="text-center mb-4">Frequently Asked Questions</h2>
            <div class="accordion" id="faqAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="faq1">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                            What are the age requirements for renting a car?
                        </button>
                    </h2>
                    <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="faq1" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Renters must be at least 21 years old and have a valid driver’s license.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="faq2">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                            Can I return the car late?
                        </button>
                    </h2>
                    <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="faq2" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Late returns may incur additional fees. Please contact us to arrange an extension.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="faq3">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                            Is insurance included?
                        </button>
                    </h2>
                    <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="faq3" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Renters must provide their own insurance. Contact us for details.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 contact-section">
        <div class="container">
            <h2 class="text-center mb-4">Contact Us</h2>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card text-center">
                        <div class="card-body">
                            <p><i class="bi bi-envelope"></i> <a href="mailto:belovedogbu@gmail.com" class="text-white text-decoration-none hover-link">belovedogbu@gmail.com</a></p>
                            <p><i class="bi bi-phone"></i> <a href="tel:07030173746" class="text-white text-decoration-none hover-link">07030173746</a></p>
                            <p><i class="bi bi-geo-alt"></i> 123 Rental St, City, Country</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php require_once "components/footer.php"; ?>

    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
```