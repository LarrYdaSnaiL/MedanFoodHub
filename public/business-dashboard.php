<?php
include "../database/connection.php";
session_start();

// Check if the user is logged in
if (!isset($_SESSION['login'])) {
    header("Location: ../");
    exit();
}

// Assuming the logged-in user's ID is stored in the session
$owner_id = $_SESSION['uid'];  // Change this to the correct session variable for the logged-in user

// Query untuk mengambil data restoran
$sql = "SELECT 
            r.id, 
            r.pictures, 
            r.restaurant_name, 
            r.categories, 
            r.owner_id,
            COALESCE(AVG(rev.rating), 0) AS average_rating
        FROM 
            restaurants r
        LEFT JOIN 
            reviews rev ON r.id = rev.restaurant_id
        JOIN 
            users u ON r.owner_id = u.uid  -- Menghubungkan restoran dengan pengguna berdasarkan owner_id dan uid
        WHERE 
            r.owner_id = :owner_id  -- Filter berdasarkan owner_id yang sama dengan session
        GROUP BY 
            r.id, r.pictures, r.restaurant_name, r.categories";

$stmt = $pdo->prepare($sql);

// Bind the owner_id to the prepared statement
$stmt->bindParam(':owner_id', $owner_id, PDO::PARAM_INT);

// Execute the statement
$stmt->execute();
$restaurants = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Dashboard - MedanFoodHub</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 font-sans antialiased">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-lg">
            <div class="p-6">
                <h2 class="text-2xl font-semibold text-gray-800">Dashboard</h2>
                <nav class="mt-8 space-y-4">
                    <a href="index.php"
                        class="block px-4 py-2 text-gray-700 hover:bg-blue-600 hover:text-white rounded-lg">Home</a>
                    <a href="account-dashboard.php"
                        class="block px-4 py-2 text-gray-700 hover:bg-blue-600 hover:text-white rounded-lg">Profile
                        Settings</a>
                    <a href="../config/logout.php"
                        class="block px-4 py-2 text-gray-700 hover:bg-red-600 hover:text-white rounded-lg">Log Out</a>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            <!-- Header Section -->
            <section class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-3xl font-semibold text-gray-800 mb-6">Your Business</h3>
                <a href="add-business.php">
                    <button
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-500 transition duration-200 mb-6">
                        Add New Business
                    </button>
                </a>
                <!-- Business Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <?php
                    foreach ($restaurants as $restaurant) {
                        // Format the restaurant name
                        $restaurant['restaurant_name'] = ucwords(strtolower($restaurant['restaurant_name']));
                        $pictures = $restaurant['pictures'] ? json_decode($restaurant['pictures'], true) : [];
                        $firstPicture = isset($pictures[0]) ? $pictures[0] : 'https://via.placeholder.com/300';

                        // Generate stars for ratings
                        $stars = str_repeat("<span class='text-yellow-400'>★</span>", floor($restaurant['average_rating'])) .
                            str_repeat("<span class='text-gray-400'>☆</span>", 5 - floor($restaurant['average_rating']));

                        echo "
                        <div class='bg-white rounded-lg shadow-lg p-4'>
                            <img src='{$firstPicture}' alt='Restaurant Image'
                                class='w-full h-32 object-cover rounded-md'>
                            <h3 class='text-lg font-semibold mt-2'>{$restaurant['restaurant_name']}</h3>
                            <p class='text-gray-600'>Category: {$restaurant['categories']}</p>
                            <p class='text-yellow-500'>{$stars}</p>
                            <div class='mt-4'>
                                <a href='edit-business.php?edit={$restaurant['id']}' class='bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-500 transition duration-200'>
                                    Manage Restaurant
                                </a>
                            </div>
                        </div>  
                        ";
                    }
                    ?>
                </div>
            </section>
        </main>
    </div>

    <!-- Footer Section -->
    <footer class="bg-blue-600 text-gray-100 py-8">
        <div
            class="container mx-auto grid grid-cols-1 md:grid-cols-2 gap-6 px-6 justify-center items-center text-center">
            <div>
                <h3 class="text-lg font-semibold mb-2">About MedanFoodHub</h3>
                <p class="text-white text-sm">MedanFoodHub is your go-to platform to discover the best restaurants
                    around Medan. Find top-rated, trending, and unique eateries all in one place.</p>
            </div>
            <div>
                <h3 class="text-lg font-semibold mb-2">Contact Us</h3>
                <p class="text-white text-sm">Email: <a href="mailto:info@medanfoodhub.com"
                        class="hover:text-white">info@medanfoodhub.com</a></p>
                <p class="text-white text-sm">Phone: <a href="tel:+620123456789" class="hover:text-white">+62 012 345
                        6789</a></p>
            </div>
        </div>
    </footer>
</body>

</html>