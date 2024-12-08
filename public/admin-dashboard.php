<?php
session_start();

include '../database/connection.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: ../");
    exit();
}

try {
    // Query to get full_name using uid
    $sql = "SELECT * FROM users WHERE uid = :uid";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':uid', $_SESSION['uid']);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $full_name = $user['full_name'];
        $profilePic = $user['profile_pic'];
        $email = $user['email'];
        $phone = $user['phone'];
        $bio = $user['bio'];
        $is_admin = $user['is_admin'];
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit();
}

if (!$is_admin) {
    echo "
    <script>
        alert('You are not authorized to access this page');
        window.location.href = '../';
    </script>
    ";
}

// Fetch businessowner applicants
$sql = "
        SELECT
            *
        FROM
            businessowner
        JOIN
            users
        ON
            businessowner.uid = users.uid
        WHERE
            businessowner.status = 'in request'
        ";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$businessowners = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard - MedanFoodHub</title>
    <link rel="icon" href="./assets/Logo/icon.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/style.css">
</head>

<body class="bg-gray-100 font-sans antialiased">
    <div class="flex min-h-screen">
        <aside class="w-64 bg-white shadow-lg">
            <div class="p-6">
                <h2 class="text-2xl font-semibold text-gray-800">Dashboard</h2>
                <nav class="mt-8 space-y-4">
                    <a href="/"
                        class="block px-4 py-2 text-gray-700 hover:bg-blue-600 hover:text-white rounded-lg">Home</a>
                    <a href="banner"
                        class="block px-4 py-2 text-gray-700 hover:bg-blue-600 hover:text-white rounded-lg">
                        Manage Banners
                    </a>
                    <a href="account"
                        class="block px-4 py-2 text-gray-700 hover:bg-blue-600 hover:text-white rounded-lg">
                        Your Profile</a>
                    <a href="../config/logout.php"
                        class="block px-4 py-2 text-gray-700 hover:bg-red-600 hover:text-white rounded-lg">
                        Log Out
                    </a>
                </nav>
            </div>
        </aside>

        <main class="flex-1 p-8">
            <!-- Section Header -->
            <div class="mb-4">
                <h1 class="text-2xl font-bold text-gray-800">Business Owner Requests</h1>
                <p class="text-gray-600 mt-2">Below are the users who submitted their requests for business ownership
                    verification.</p>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto bg-white shadow-md rounded-lg p-4">
                <table class="table-auto w-full border-collapse border border-gray-200">
                    <thead>
                        <tr>
                            <th class="border border-gray-200 px-4 py-2 text-gray-600 font-semibold text-left">No.</th>
                            <th class="border border-gray-200 px-4 py-2 text-gray-600 font-semibold text-left">Full Name
                            </th>
                            <th class="border border-gray-200 px-4 py-2 text-gray-600 font-semibold text-left">Identity
                                Card
                            </th>
                            <th class="border border-gray-200 px-4 py-2 text-gray-600 font-semibold text-left">Taxpayer
                                Number</th>
                            <th class="border border-gray-200 px-4 py-2 text-gray-600 font-semibold text-left">Proof of
                                Ownership</th>
                            <th class="border border-gray-200 px-4 py-2 text-gray-600 font-semibold text-left">Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($businessowners && count($businessowners) > 0) {
                            foreach ($businessowners as $index => $applicant) {
                                $index++;
                                echo "
                                    <tr>
                                    <td class='border border-gray-200 px-4 py-2'>{$index}</td>
                                    <td class='border border-gray-200 px-4 py-2'>{$applicant['full_name']}</td>
                                    <td class='border border-gray-200 px-4 py-2'>
                                        <a href='{$applicant['identity_card']}' target='_blank'
                                            class='text-blue-500 hover:underline'>View Document</a>
                                    </td>
                                    <td class='border border-gray-200 px-4 py-2'>
                                        <a href='{$applicant['taxpayer_number']}' target='_blank'
                                            class='text-blue-500 hover:underline'>View Document</a>
                                    </td>
                                    <td class='border border-gray-200 px-4 py-2'>
                                        <a href='{$applicant['proof_ownership']}' target='_blank'
                                            class='text-blue-500 hover:underline'>View Document</a>
                                    </td>
                                    <td class='border border-gray-200 px-4 py-2'>
                                        <form action='' method='POST'>
                                            <input type='hidden' name='uid' value='{$applicant['uid']}'>
                                            <button type='submit' name='approve' 
                                                class='bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-400 transition duration-200'>
                                                <i class='fa-solid fa-check text-white'></i>
                                            </button>
                                            <button type='submit' name='reject' 
                                                class='bg-red-500 px-4 py-2 rounded-lg hover:bg-red-400 transition duration-200'>
                                                <i class='fa-solid fa-xmark text-white'></i>
                                            </button>
                                        </form>
                                    </td>
                                    </tr>
                                ";
                            }

                            if (isset($_POST['approve'])) {
                                $uid = $_POST['uid'];
                                $sql = "UPDATE businessowner SET status = 'approved' WHERE uid = :uid";
                                $stmt = $pdo->prepare($sql);
                                $stmt->bindParam(':uid', $uid);
                                $stmt->execute();
                                header("Location: admin");
                            }

                            if (isset($_POST['reject'])) {
                                $uid = $_POST['uid'];
                                $sql = "UPDATE businessowner SET status = 'rejected' WHERE uid = :uid";
                                $stmt = $pdo->prepare($sql);
                                $stmt->bindParam(':uid', $uid);
                                $stmt->execute();
                                header("Location: admin");
                            }
                        } else {
                            echo "
                                <tr>
                                    <td class='border border-gray-200 px-4 py-2 text-center' colspan='6'>No requests found</td>
                                </tr>
                                ";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <!-- JavaScript to filter the cards based on category -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const hamburgerMenu = document.getElementById('hamburgerMenu');
            const responsiveMenu = document.getElementById('responsiveMenu');
            const closeMenu = document.getElementById('closeMenu');

            // Toggle responsive menu
            hamburgerMenu.addEventListener('click', function () {
                responsiveMenu.classList.remove('hidden');
                responsiveMenu.classList.add('slide-enter-active');
            });

            closeMenu.addEventListener('click', function () {
                responsiveMenu.classList.add('hidden');
            });

            // Close menu when clicking outside
            document.addEventListener('click', function (e) {
                if (!responsiveMenu.contains(e.target) && e.target !== hamburgerMenu) {
                    responsiveMenu.classList.add('hidden');
                }
            });
        });


        function filterCategory(category, button) {
            // Filter cards by category
            const cards = document.querySelectorAll('.Card-Filter');
            cards.forEach(card => {
                if (card.classList.contains(category)) {
                    card.classList.remove('hidden');
                } else {
                    card.classList.add('hidden');
                }
            });

            // Highlight active button
            const buttons = document.querySelectorAll('.flex button');
            buttons.forEach(btn => {
                btn.classList.remove('bg-gray-300', 'font-bold'); // Remove active styles
                btn.classList.add('bg-gray-200', 'text-gray-800'); // Reset to default styles
            });

            button.classList.add('bg-gray-300', 'font-bold'); // Add active styles
            button.classList.remove('bg-gray-200', 'text-gray-800'); // Remove default styles
        }

        // Set initial state
        document.addEventListener('DOMContentLoaded', () => {
            const allButton = document.getElementById('All');
            filterCategory('All', allButton);
        });

        let currentSlide = 0;
        const slides = document.querySelectorAll(".carousel-images img");
        const totalSlides = slides.length;
        const nextButton = document.getElementById("next");
        const prevButton = document.getElementById("prev");
        const carouselImagesContainer = document.querySelector(".carousel-images");

        function updateSlidePosition() {
            carouselImagesContainer.style.transform = `translateX(-${currentSlide * 100}%)`;
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % totalSlides;
            updateSlidePosition();
        }

        function prevSlide() {
            currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
            updateSlidePosition();
        }

        nextButton.addEventListener("click", nextSlide);
        prevButton.addEventListener("click", prevSlide);

        // Auto-slide every 3 seconds
        setInterval(nextSlide, 3000);

        // Modal functionality
        const openModalButton = document.getElementById('openModal');
        const closeModalButton = document.getElementById('closeModal');
        const modal = document.getElementById('loginModal');

        openModalButton.addEventListener('click', () => {
            modal.classList.add('show');
        });

        closeModalButton.addEventListener('click', () => {
            modal.classList.remove('show');
        });

        // Close modal when clicking outside of it
        window.addEventListener('click', (event) => {
            if (event.target === modal) {
                modal.classList.remove('show');
            }
        });

        const openSignUp = document.getElementById('openSignUp');
        const closeSignUp = document.getElementById('closeSignUpModal');
        const modalSignUp = document.getElementById('signupModal');

        openSignUp.addEventListener('click', () => {
            modalSignUp.classList.add('show');
        });

        closeSignUp.addEventListener('click', () => {
            modalSignUp.classList.remove('show');
        });

        // Close modal when clicking outside of it
        window.addEventListener('click', (event) => {
            if (event.target === modalSignUp) {
                modalSignUp.classList.remove('show');
            }
        });

        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const showPasswordCheckbox = document.getElementById('showPassword');
            passwordInput.type = showPasswordCheckbox.checked ? 'text' : 'password';

            // Add class for animation on the dot
            const dot = document.querySelector('.dot');
            if (showPasswordCheckbox.checked) {
                dot.style.transform = 'translateX(100%)'; // Move the dot when checked
            } else {
                dot.style.transform = 'translateX(0)'; // Move the dot back when unchecked
            }
        }

        function togglePasswordSignUpVisibility() {
            const passwordInput = document.getElementById('sPassword');
            const showPasswordCheckbox = document.getElementById('sShowPassword');
            passwordInput.type = showPasswordCheckbox.checked ? 'text' : 'password';

            // Add class for animation on the dot
            const dot = document.querySelector('.sDot');
            if (showPasswordCheckbox.checked) {
                dot.style.transform = 'translateX(100%)'; // Move the dot when checked
            } else {
                dot.style.transform = 'translateX(0)'; // Move the dot back when unchecked
            }
        }

        // Responsive menu actions
        document.getElementById("hamburgerMenu").addEventListener("click", function () {
            document.getElementById("responsiveMenu").classList.toggle("hidden");
        });

        document.getElementById("closeMenu").addEventListener("click", function () {
            document.getElementById("responsiveMenu").classList.add("hidden");
        });

        // Responsive modal triggers
        document.getElementById("openModalResponsive").addEventListener("click", function () {
            loginModal.classList.add("show");
        });

        document.getElementById("openSignUpResponsive").addEventListener("click", function () {
            signupModal.classList.add("show");
        });
    </script>
</body>

</html>