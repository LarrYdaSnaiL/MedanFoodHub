<?php
session_start();
include "../database/connection.php";// Make sure to include your database connection file

// Assuming restaurant_id is passed as a GET parameter (e.g., edit.php?id=123)
$restaurantId = $_GET['edit'] ?? null;

if (!$restaurantId) {
    echo "<script>alert('Invalid request.'); window.location.href = 'account';</script>";
    exit;
}

// Fetch business details from the database
$stmt = $pdo->prepare("SELECT * FROM restaurants WHERE id = :restaurantId");
$stmt->bindParam(':restaurantId', $restaurantId);
$stmt->execute();
$restaurant = $stmt->fetch();

if (!$restaurant) {
    echo "<script>alert('Restaurant not found.'); window.location.href = 'account';</script>";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    // Get the updated form data
    $restaurantName = $_POST['restaurantName'];
    $description = $_POST['description'];
    $categories = $_POST['categories'];

    // Update business details in the database
    $updateStmt = $pdo->prepare("UPDATE restaurants SET restaurant_name = :restaurantName, descriptions = :description, categories = :categories WHERE id = :restaurantId");
    $updateStmt->bindParam(':restaurantName', $restaurantName);
    $updateStmt->bindParam(':description', $description);
    $updateStmt->bindParam(':categories', $categories);
    $updateStmt->bindParam(':restaurantId', $restaurantId);

    if ($updateStmt->execute()) {
        echo "<script>alert('Business updated successfully.'); window.location.href = 'business';</script>";
    } else {
        echo "<script>alert('Failed to update business.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit <?php echo $restaurant['restaurant_name'] ?> - MedanFoodHub</title>
    <link rel="icon" href="../Assets/Logo/icon.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
    </head>

<body class="bg-gray-100 font-sans antialiased">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-lg">
            <div class="p-6">
                <h2 class="text-2xl font-semibold text-gray-800">Dashboard</h2>
                <nav class="mt-8 space-y-4">
                    <a href="account"
                        class="block px-4 py-2 text-gray-700 hover:bg-blue-600 hover:text-white rounded-lg">Back</a>
                    <a href="account"
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
            <div class="container mx-auto my-8 bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-2xl font-semibold mb-6">Edit Business:
                    <?= htmlspecialchars($restaurant['restaurant_name']); ?>
                </h2>

                <!-- Restaurant/Cafe Name Input -->
                <form method="POST" class="space-y-4">
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Restaurant/Cafe Name</label>
                        <input type="text" name="restaurantName" class="border p-2 w-full"
                            value="<?= htmlspecialchars($restaurant['restaurant_name']); ?>" required>
                    </div>

                    <!-- Description Input -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Description</label>
                        <textarea name="description" class="border p-2 w-full"
                            required><?= htmlspecialchars($restaurant['descriptions']); ?></textarea>
                    </div>

                    <!-- Category Checkboxes -->
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Category</label>
                        <div class="flex flex-wrap gap-4">
                            <?php
                            $categoriesArray = explode(', ', $restaurant['categories']);
                            $categoriesList = ['Indonesian', 'Western', 'Chinese', 'Middle East', 'Others'];

                            foreach ($categoriesList as $category) {
                                $checked = in_array($category, $categoriesArray) ? 'checked' : '';
                                echo "
                                    <label class='inline-flex items-center'>
                                        <input type='radio' name='categories' class='form-checkbox text-blue-500' value='$category' $checked>
                                        <span class='ml-2 text-gray-700'>$category</span>
                                    </label>";
                            }
                            ?>
                        </div>
                    </div>

                    <!-- Save Button -->
                    <button type="submit"
                        class="bg-blue-500 text-white font-semibold py-2 px-4 rounded hover:bg-blue-600">Save
                        Changes</button>
                </form>
            </div>
        </main>
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
</body>

</html>