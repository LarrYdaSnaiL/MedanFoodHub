<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medan Food Hub</title>
    <link rel="icon" href="/assets/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <!--navbar-->
    <header>
        <div class="navbar">
            <img src="/assets/logo.png" alt="Medan Food Hub" class="logo">
            <div class="search-container">
                <input type="text" class="form-control" placeholder="Temukan tempat makan sekitarmu..">
                <button class="btn btn-primary">FILTER <i class="bi bi-filter"></i></button>
            </div>
            <div class="auth-buttons">
                <div class="login-container">
                    <button>Masuk</button>
                </div>
                <div class="divider"></div>
                <div class="signup-container">
                    <button>Daftar</button>
                </div>
            </div>
        </div>
    </header>

    <main>
        <!--carousel 1-->
        <div class="carousel-gambar">
            <div id="carouselExampleIndicators" class="carousel slide mb-4 carousel-spacing" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner d-flex">
                    <div class="carousel-item active flex-fill">
                        <img src="download (3).jpeg" class="d-block w-100" alt="Image 1">
                    </div>
                    <div class="carousel-item flex-fill">
                        <img src="/assets/logo.png" class="d-block w-100" alt="Image 2">
                    </div>
                    <div class="carousel-item flex-fill">
                        <img src="download (3).jpeg" class="d-block w-100" alt="Image 3">
                    </div>
                </div>
            </div>
        </div>
        
        <!-- carousel kedua-->
        <div class="container">
            <h2 class="text-center">Tempat-Tempat Terkenal</h2>
            <div id="tempatCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <!-- First carousel item (active) -->
                    <div class="carousel-item active">
                        <div class="d-flex flex-row justify-content-center">
                            <!-- Card 1 -->
                            <div class="card mx-2">
                                <img class="card-img-top" src="image1.jpg" alt="Tempat 1">
                                <div class="card-body text-center">
                                    <div class="text-box">
                                        <p class="card-text">Nama Tempat 1<br>
                                            📍 Lokasi<br>
                                            ⭐ Rating
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!-- Card 2 -->
                            <div class="card mx-2">
                                <img class="card-img-top" src="image2.jpg" alt="Tempat 2">
                                <div class="card-body text-center">
                                    <p class="card-text">Nama Tempat 2</p>
                                    <p class="card-text">📍 Lokasi</p>
                                    <p class="card-text">⭐ Rating</p>
                                </div>
                            </div>
                            <!-- Card 3 -->
                            <div class="card mx-2">
                                <img class="card-img-top" src="image3.jpg" alt="Tempat 3">
                                <div class="card-body text-center">
                                    <p class="card-text">Nama Tempat 3</p>
                                    <p class="card-text">📍 Lokasi</p>
                                    <p class="card-text">⭐ Rating</p>
                                </div>
                            </div>
                            <!-- Card 4 -->
                            <div class="card mx-2">
                                <img class="card-img-top" src="image4.jpg" alt="Tempat 4">
                                <div class="card-body text-center">
                                    <p class="card-text">Nama Tempat 4</p>
                                    <p class="card-text">📍 Lokasi</p>
                                    <p class="card-text">⭐ Rating</p>
                                </div>
                            </div>
                            <!-- Card 5 -->
                            <div class="card mx-2">
                                <img class="card-img-top" src="image5.jpg" alt="Tempat 5">
                                <div class="card-body text-center">
                                    <p class="card-text">Nama Tempat 5</p>
                                    <p class="card-text">📍 Lokasi</p>
                                    <p class="card-text">⭐ Rating</p>
                                </div>
                            </div>
                            <!-- Card 6 -->
                            <div class="card mx-2">
                                <img class="card-img-top" src="image6.jpg" alt="Tempat 6">
                                <div class="card-body text-center">
                                    <p class="card-text">Nama Tempat 6</p>
                                    <p class="card-text">📍 Lokasi</p>
                                    <p class="card-text">⭐ Rating</p>
                                </div>
                            </div>
                            <div class="card mx-2">
                                <img class="card-img-top" src="image6.jpg" alt="Tempat 6">
                                <div class="card-body text-center">
                                    <p class="card-text">Nama Tempat 7</p>
                                    <p class="card-text">📍 Lokasi</p>
                                    <p class="card-text">⭐ Rating</p>
                                </div>
                            </div>
                        </div>
                    </div>             
                    </div>
            </div>
        </div>
    </main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
