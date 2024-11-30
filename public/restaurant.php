<?php
include "../database/connection.php";
session_start();

// Check if the user is logged in
if (!isset($_SESSION['login'])) {
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
        $is_owner = $user['is_owner'];
        $bookmarks = $user['bookmarks'] ? json_decode($user['bookmarks'], true) : [];
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit();
}

if (isset($_GET['item'])) {
    $resto_id = $_GET['item'];

    // Query to get restaurant details along with the average rating
    $sql = '
        SELECT 
            r.*, 
            COALESCE(AVG(rev.rating), 0) AS average_rating
        FROM 
            restaurants r
        LEFT JOIN 
            reviews rev ON r.id = rev.restaurant_id
        WHERE 
            r.id = :id
        GROUP BY 
            r.id, r.owner_id, r.pictures, r.restaurant_name, r.descriptions, r.categories';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam('id', $resto_id);
    $stmt->execute();

    $restaurant = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($restaurant) {
        // Extract restaurant details
        $restaurantName = $restaurant['restaurant_name'];
        $ownerId = $restaurant['owner_id'];
        $description = $restaurant['descriptions'];
        $categories = $restaurant['categories'];
        $averageRating = number_format($restaurant['average_rating'], 1); // Format rating to 1 decimal place

        // Get owner information
        $sql = 'SELECT * FROM users WHERE uid = :owner_id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam('owner_id', $ownerId);
        $stmt->execute();

        $ownerInformation = $stmt->fetch(PDO::FETCH_ASSOC);

        $ownerName = $ownerInformation ? $ownerInformation['full_name'] : null;
        $ownerPic = $ownerInformation ? $ownerInformation['profile_pic'] : null;
    } else {
        header("Location: ../");
        exit;
    }
} else {
    header("Location: ../");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Details - MedanFoodHub</title>
    <link rel="icon" href="/assets/Logo/icon.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../Assets/style.css">
</head>

<body class="bg-gray-100 font-sans">

    <!-- Navbar -->
    <nav class="bg-white shadow-md py-4">
        <div class="container mx-auto flex justify-between items-center px-6">
            <!-- Logo -->
            <a href="../" class="text-2xl font-bold text-blue-600">
                <img src="../Assets/Logo/text logo.png" width="200" alt="Text Logo">
            </a>

            <!-- Hamburger Menu -->
            <button id="hamburgerMenu" class="text-2xl lg:hidden focus:outline-none">
                ☰
            </button>

            <!-- Full Menu -->
            <div id="navMenu" class="hidden lg:flex lg:items-center lg:space-x-8">
                <!-- Search Section -->
                <div class="flex items-center space-x-2">
                    <input type="text" placeholder="Search..."
                        class="border rounded-lg px-4 py-1 focus:outline-none focus:border-blue-600 w-80">
                    <button class="bg-blue-600 text-white px-4 py-1 rounded-lg">Search</button>
                </div>

                <!-- Auth Section -->
                <?php if (!$_SESSION['login']) { ?>
                    <div class="flex items-center space-x-2">
                        <button id="openModal"
                            class="px-4 py-1 bg-blue-600 text-white rounded-lg hover:bg-blue-500 transition duration-200">Login</button>
                        <span>|</span>
                        <button id="openSignUp"
                            class="px-4 py-1 border border-blue-600 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition duration-200">Register</button>
                    </div>
                <?php } else { ?>
                    <!-- Profile Section -->
                    <div id="profileSection" class="flex items-center space-x-2 cursor-pointer"
                        onclick="movePage('account')">
                        <span class="text-black font-medium"><?php echo $full_name; ?></span>
                        <img src="<?php echo $profilePic != null ? $profilePic : '../Assets/blankPic.png'; ?>"
                            alt="User Profile Picture" class="w-10 h-10 rounded-full">
                    </div>
                <?php } ?>
            </div>
        </div>

        <!-- Responsive Menu -->
        <div id="responsiveMenu"
            class="hidden lg:hidden fixed top-0 right-0 h-full w-50% bg-white shadow-lg z-50 slide-enter">
            <div class="flex flex-col p-4 space-y-4 items-center content-centere">
                <!-- Close Button -->
                <button id="closeMenu" class="self-end text-2xl">
                    &times;
                </button>

                <!-- Search Section -->
                <div>
                    <input type="text" placeholder="Search..."
                        class="border rounded-lg px-4 py-1 w-full focus:outline-none focus:border-blue-600">
                    <button class="bg-blue-600 text-white px-4 py-1 rounded-lg w-full mt-2">Search</button>
                </div>

                <!-- Auth Section -->
                <?php if (!$_SESSION['login']) { ?>
                    <div class="flex flex-row items-center gap-2 content-center item-center">
                        <button id="openModalResponsive"
                            class="w-30 bg-blue-600 text-white px-4 py-1 rounded-lg hover:bg-blue-500 transition duration-200">Login</button>
                        <button id="openSignUpResponsive"
                            class="w-30 border border-blue-600 text-blue-600 px-4 py-1 rounded-lg hover:bg-blue-600 hover:text-white transition duration-200">Register</button>
                    </div>
                <?php } else { ?>
                    <!-- Profile Section -->
                    <div id="profileSection" class="flex items-center space-x-2 cursor-pointer"
                        onclick="movePage('account')">
                        <span class="text-black font-medium"><?php echo $full_name; ?></span>
                        <img src="<?php echo $profilePic != null ? $profilePic : '../Assets/blankPic.png'; ?>"
                            alt="User Profile Picture" class="w-10 h-10 rounded-full">
                    </div>
                <?php } ?>
            </div>
        </div>
    </nav>

    <!-- Login Modal -->
    <div id="loginModal" class="modal">
        <div class="bg-white rounded-lg shadow-lg p-8 w-96">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Login</h2>
            <form action="../config/login.php" method="POST">
                <div class="mb-4">
                    <label for="email" class="block text-gray-700">Email</label>
                    <input type="email" id="email" name="email" required
                        class="mt-1 block w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600"
                        placeholder="example@gmail.com">
                </div>
                <div class="mb-6">
                    <label for="password" class="block text-gray-700">Password</label>
                    <input type="password" id="password" name="password" required
                        class="mt-1 block w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600"
                        placeholder="Password...">
                    <div class="flex items-center mb-4">
                        <input type="checkbox" id="showPassword" class="hidden" onclick="togglePasswordVisibility()">
                        <label for="showPassword" class="flex items-center cursor-pointer">
                            <div class="relative">
                                <div class="w-10 h-5 bg-gray-300 rounded-full shadow-inner"></div>
                                <div class="dot absolute left-0 top-0 bg-white w-5 h-5 rounded-full shadow transition-transform duration-200"
                                    style="transform: translateX(0);"></div>
                            </div>
                            <span class="ml-2 text-gray-700">Show Password</span>
                        </label>
                    </div>
                </div>
                <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-500 transition duration-200">Login</button>
            </form>
            <button id="closeModal" class="absolute top-2 right-2 text-gray-600 hover:text-gray-900">&times;</button>
        </div>
    </div>

    <!-- Sign Up Modal -->
    <div id="signupModal" class="modal">
        <div class="bg-white rounded-lg shadow-lg p-8 w-96">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Register</h2>
            <form action="../config/signup.php" method="POST">
                <div class="mb-4">
                    <label for="email" class="block text-gray-700">Your Name</label>
                    <input type="text" id="full_name" name="full_name" required
                        class="mt-1 block w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600"
                        placeholder="Alexandra">
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700">Email</label>
                    <input type="email" id="sEmail" name="sEmail" required
                        class="mt-1 block w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600"
                        placeholder="example@gmail.com">
                </div>
                <div class="mb-6">
                    <label for="password" class="block text-gray-700">Password</label>
                    <input type="password" id="sPassword" name="sPassword" required
                        class="mt-1 block w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-600"
                        placeholder="Password...">
                    <div class="flex items-center mb-4">
                        <input type="checkbox" id="sShowPassword" class="hidden"
                            onclick="togglePasswordSignUpVisibility()">
                        <label for="sShowPassword" class="flex items-center cursor-pointer">
                            <div class="relative">
                                <div class="w-10 h-5 bg-gray-300 rounded-full shadow-inner"></div>
                                <div class="sDot absolute left-0 top-0 bg-white w-5 h-5 rounded-full shadow transition-transform duration-200"
                                    style="transform: translateX(0);"></div>
                            </div>
                            <span class="ml-2 text-gray-700">Show Password</span>
                        </label>
                    </div>
                </div>
                <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-500 transition duration-200">Login</button>
            </form>
            <button id="closeSignUpModal"
                class="absolute top-2 right-2 text-gray-600 hover:text-gray-900">&times;</button>
        </div>
    </div>

    <!-- Restaurant Details Content -->
    <div class="container mx-auto py-8 mb-12">
        <!-- Restaurant Header -->
        <div class="flex justify-between items-center mb-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800"><?php echo $restaurantName; ?></h1>
                <div class="text-gray-600 flex items-center space-x-2">
                    <?php
                    $stars = str_repeat("<span class='text-yellow-400'>★</span>", floor($restaurant['average_rating'])) .
                        str_repeat("<span class='text-gray-400'>☆</span>", 5 - floor($restaurant['average_rating']));

                    echo $stars;
                    ?>
                    <span>|</span>
                    <span>Category: <?php echo $categories; ?></span>
                </div>
            </div>
            <div>
                <form action="" method="POST">
                    <button class="bg-blue-600 text-white px-4 py-2 rounded-lg" id="share-btn"><i
                            class="fa-solid fa-share"></i>&nbsp;&nbsp;Share</button>
                    <button class="bg-blue-600 text-white px-4 py-2 rounded-lg" name="bookmark" type="submit">
                        <?php if (in_array($resto_id, $bookmarks)) {
                            echo "<i class='fa-solid fa-bookmark'></i>";
                        } else {
                            echo "<i class='fa-regular fa-bookmark'></i>";
                        } ?>
                        &nbsp;&nbsp;Bookmark</button>
                </form>

                <?php
                if (isset($_POST['bookmark'])) {
                    try {
                        $newRestaurantId = $_GET['item'];

                        if (in_array($newRestaurantId, $bookmarks)) {
                            // Remove the restaurant_id from bookmarks
                            $sql = "UPDATE users SET bookmarks = to_jsonb(array_remove(ARRAY(SELECT jsonb_array_elements_text(bookmarks))::TEXT[], :restaurant_id)) WHERE uid = :uid";
                            $action = "removed";
                        } else {
                            // Add the restaurant_id to bookmarks
                            $sql = "UPDATE users SET bookmarks = COALESCE(bookmarks, '[]'::JSONB) || to_jsonb(CAST(:restaurant_id AS TEXT)) WHERE uid = :uid";
                            $action = "added";
                        }

                        // Add new bookmark
                        $stmt = $pdo->prepare($sql);
                        $stmt->bindParam("restaurant_id", $_GET['item']);
                        $stmt->bindParam('uid', $_SESSION['uid']);
                        $added = $stmt->execute();
                        if ($added) {
                            echo "
                            <script>
                                location.href = 'restaurant.php?item=$resto_id';
                            </script>
                            ";
                        }
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                }
                ?>
            </div>
        </div>

        <!-- Restaurant Gallery with Thumbnails -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
            <img src="https://via.placeholder.com/300x200" alt="Gallery Image"
                class="thumbnail w-full h-32 object-cover rounded-md cursor-pointer"
                data-full="https://via.placeholder.com/800x600">
            <img src="https://via.placeholder.com/300x200" alt="Gallery Image"
                class="thumbnail w-full h-32 object-cover rounded-md cursor-pointer"
                data-full="https://via.placeholder.com/800x600/ff0000">
            <img src="https://via.placeholder.com/300x200" alt="Gallery Image"
                class="thumbnail w-full h-32 object-cover rounded-md cursor-pointer"
                data-full="https://via.placeholder.com/800x600/00ff00">
            <img src="https://via.placeholder.com/300x200" alt="Gallery Image"
                class="thumbnail w-full h-32 object-cover rounded-md cursor-pointer"
                data-full="https://via.placeholder.com/800x600/0000ff">
        </div>

        <!-- Full-Screen Modal -->
        <div id="modalGallery" class="modalGallery flex">
            <span class="close absolute top-4 right-4 text-white text-2xl cursor-pointer">&times;</span>
            <img id="modalImage" src="" alt="Full Image">
        </div>

        <!-- Owner Information Section -->
        <section id="ownerInfo" class="flex items-center mb-4 mt-4">
            <!-- Owner Profile Picture -->
            <div class="flex-shrink-0 mr-4">
                <img src="<?php echo $ownerPic; ?>" alt="Owner Profile Picture"
                    class="w-16 h-16 rounded-full object-cover">
            </div>

            <!-- Owner Name -->
            <div>
                <h3 class="text-xl font-semibold text-gray-800"><?php echo $ownerName; ?></h3>
            </div>
        </section>

        <!-- Description Section -->
        <section class="mb-4">
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">About This Restaurant/Cafe</h2>
                <p class="text-gray-700 leading-relaxed">
                    <?php echo $description; ?>
                </p>
            </div>
        </section>

        <!-- Ratings and Comments Section -->
        <div class="bg-white rounded-lg shadow-lg p-4">
            <h2 class="text-2xl font-semibold mb-4">Ratings and Comments</h2>

            <!-- Ratings Summary -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800">Rating Breakdown</h3>
                <div class="space-y-2 mt-4">
                    <div class="flex items-center">
                        <span class="text-yellow-500 mr-2">★★★★★</span>
                        <div class="w-64 bg-gray-200 rounded-full h-2 mr-2">
                            <div class="bg-yellow-500 h-2 rounded-full" style="width: 80%;"></div>
                        </div>
                        <span>80%</span> <!-- Example percentage -->
                    </div>
                    <div class="flex items-center">
                        <span class="text-yellow-500 mr-2">★★★★</span>
                        <div class="w-64 bg-gray-200 rounded-full h-2 mr-2">
                            <div class="bg-yellow-500 h-2 rounded-full" style="width: 10%;"></div>
                        </div>
                        <span>10%</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-yellow-500 mr-2">★★★</span>
                        <div class="w-64 bg-gray-200 rounded-full h-2 mr-2">
                            <div class="bg-yellow-500 h-2 rounded-full" style="width: 5%;"></div>
                        </div>
                        <span>5%</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-yellow-500 mr-2">★★</span>
                        <div class="w-64 bg-gray-200 rounded-full h-2 mr-2">
                            <div class="bg-yellow-500 h-2 rounded-full" style="width: 3%;"></div>
                        </div>
                        <span>3%</span>
                    </div>
                    <div class="flex items-center">
                        <span class="text-yellow-500 mr-2">★</span>
                        <div class="w-64 bg-gray-200 rounded-full h-2 mr-2">
                            <div class="bg-yellow-500 h-2 rounded-full" style="width: 2%;"></div>
                        </div>
                        <span>2%</span>
                    </div>
                </div>
            </div>

            <!-- New Comment Section -->
            <h3 class="text-xl font-semibold text-gray-800 mb-3">Add Your Comment</h3>

            <!-- Star Rating -->
            <div class="flex space-x-1 mb-4">
                <!-- Stars with click functionality -->
                <span onclick="setRating(1)" class="star text-gray-400 text-2xl cursor-pointer" id="star1">★</span>
                <span onclick="setRating(2)" class="star text-gray-400 text-2xl cursor-pointer" id="star2">★</span>
                <span onclick="setRating(3)" class="star text-gray-400 text-2xl cursor-pointer" id="star3">★</span>
                <span onclick="setRating(4)" class="star text-gray-400 text-2xl cursor-pointer" id="star4">★</span>
                <span onclick="setRating(5)" class="star text-gray-400 text-2xl cursor-pointer" id="star5">★</span>
            </div>

            <form action="" method="POST" class="space-y-4 mb-5">
                <input type="hidden" name="rating" id="rating" value="0">
                <!-- Comment Input -->
                <textarea name="newComment" id="newComment" rows="5"
                    class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
                    placeholder="Write your comment here..." required></textarea>

                <!-- Submit Button -->
                <button type="submit" name="submit-comment"
                    class="bg-blue-600 text-white py-2 px-6 rounded-lg hover:bg-blue-500 transition duration-200">
                    Submit Comment
                </button>
            </form>

            <?php
            if (isset($_POST["submit-comment"])) {
                try {
                    // $resto_id;
                    // $_SESSION['uid'];
            
                    $rating = isset($_POST['rating']) ? (int) $_POST['rating'] : 0;
                    $newComment = isset($_POST['newComment']) ? $_POST['newComment'] : '';

                    if ($rating < 1 || $rating > 5 || empty($newComment)) {
                        echo "
                        <script>
                            alert('Invalid Comment');
                            location.href = 'restaurant.php?item=$resto_id';
                        </script>
                        ";
                        exit;
                    }

                    $sql = "INSERT INTO reviews (id, restaurant_id, rating, review) VALUES (:uid, :restaurant_id, :rating, :comment)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':uid', $_SESSION['uid']);
                    $stmt->bindParam(':restaurant_id', $resto_id);
                    $stmt->bindParam(":rating", $rating);
                    $stmt->bindParam(':comment', $newComment);
                    if ($stmt->execute()) {
                        echo "
                        <script>
                            location.href = 'restaurant.php?item=$resto_id';
                        </script>
                        ";
                    }
                } catch (PDOException $e) {
                    echo "Err: " . $e->getMessage();
                }
            }

            ?>

            <!-- Individual Comments with Profile Pictures -->
            <div class="space-y-4">
                <?php
                $sql = "SELECT 
                            u.uid, rs.id AS restaurant_id, u.full_name, u.profile_pic, r.rating, r.review 
                        FROM 
                            users u 
                        JOIN 
                            reviews r ON r.id = u.uid 
                        JOIN restaurants rs ON r.restaurant_id = rs.id 
                        ORDER BY r.review_id DESC
                        ";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();

                $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($comments as $comment) {
                    if ($comment['restaurant_id'] == $resto_id) {
                        echo "
                        <div class='flex items-start space-x-4 border-b pb-4'>
                            <!-- Profile Picture -->
                            <img src='$comment[profile_pic]' alt='User Profile'
                                class='w-12 h-12 rounded-full object-cover'>
    
                            <!-- Comment Content -->
                            <div>
                                <p class='text-gray-700 font-semibold'>$comment[full_name]</p>
                                <!-- Star Rating -->
                                <div class='flex space-x-1 mb-4'>";
                        for ($i = 1; $i <= 5; $i++) {
                            echo $i <= $comment['rating']
                                ? "<span class='text-yellow-400'>★</span>"
                                : "<span class='text-gray-400'>☆</span>";
                        }
                        echo "
                            </div>
                                <p class='text-gray-600 mt-2'>$comment[review]</p>
                            </div>
                        </div>
                        ";
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Footer Section -->
    <footer class="bg-blue-600 text-gray-100 py-8">
        <div
            class="container mx-auto grid grid-cols-1 md:grid-cols-2 gap-6 px-6 justify-center items-center text-center">
            <!-- About Us Section -->
            <div>
                <h3 class="text-lg font-semibold mb-2">About MedanFoodHub</h3>
                <p class="text-white text-sm">MedanFoodHub is your go-to platform to discover the best restaurants
                    around Medan. Find top-rated, trending, and unique eateries all in one place.</p>
            </div>

            <!-- Contact Section -->
            <div>
                <h3 class="text-lg font-semibold mb-2">Contact Us</h3>
                <p class="text-white text-sm">Email: <a href="mailto:info@medanfoodhub.com"
                        class="hover:text-white">info@medanfoodhub.com</a></p>
                <p class="text-white text-sm">Phone: <a href="tel:+620123456789" class="hover:text-white">+62 012 345
                        6789</a></p>
                <div class="flex space-x-4 mt-4 justify-center">
                    <a href="https://facebook.com" target="_blank" class="text-gray-400 hover:text-white">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://twitter.com" target="_blank" class="text-gray-400 hover:text-white">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="https://instagram.com" target="_blank" class="text-gray-400 hover:text-white">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-300 mt-6 pt-4 text-center text-white text-sm">
            &copy; 2024 MedanFoodHub. All rights reserved.
        </div>
    </footer>

    <!-- JavaScript for Show More Gallery and Image Slider -->
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

        let modalGallery = document.getElementById('modalGallery');
        let modalImage = document.getElementById('modalImage');
        let thumbnails = document.querySelectorAll('.thumbnail');

        // Open modal on thumbnail click
        thumbnails.forEach(thumbnail => {
            thumbnail.addEventListener('click', function () {
                const fullImageSrc = thumbnail.getAttribute('data-full');
                modalImage.src = fullImageSrc;
                modalGallery.style.display = 'flex'; // Show the modal
            });
        });

        // Close modal on clicking the close button
        document.querySelector('.close').addEventListener('click', function () {
            modalGallery.style.display = 'none'; // Hide the modal
        });

        // Optional: Close modal on outside click
        modalGallery.addEventListener('click', function (event) {
            if (event.target === modalGallery) {
                modalGallery.style.display = 'none';
            }
        });

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

        // Function to set the rating
        let currentRating = 0;

        function setRating(rating) {
            currentRating = rating;

            // Update star colors based on rating
            for (let i = 1; i <= 5; i++) {
                const star = document.getElementById('star' + i);
                if (i <= rating) {
                    star.classList.remove('text-gray-400');
                    star.classList.add('text-yellow-400'); // Filled color
                } else {
                    star.classList.remove('text-yellow-400');
                    star.classList.add('text-gray-400'); // Unfilled color
                }
            }
        }

        function movePage(name) {
            switch (name) {
                case 'account':
                    window.location.href = "profile.php";
                    break;
                default:
                    break;
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