<?php
include "../database/connection.php";
session_start();

use Cloudinary\Api\Upload\UploadApi;

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
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Business - MedanFoodHub</title>
    <link rel="icon" href="../Assets/Logo/icon.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tesseract.js@2.1.0/dist/tesseract.min.js"></script>
</head>

<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-lg">
            <div class="p-6">
                <h2 class="text-2xl font-semibold text-gray-800">Dashboard</h2>
                <nav class="mt-8 space-y-4">
                    <a href="business"
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
            <div class="container mx-auto my-8 bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-2xl font-semibold mb-6">Manage Business</h2>
                <form action="" method="POST" enctype="multipart/form-data">
                    <!-- Main Picture Upload with Preview -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Main Picture (300x200 px)</label>
                        <input type="file" id="images" name="images[]" accept="image/*" class="border p-2 w-full"
                            onchange="previewMainImage(this)">
                        <p class="text-sm text-gray-500 mt-1">Only images with 300x200 pixels are accepted.</p>
                        <div id="main-image-preview" class="mt-4"></div>
                    </div>

                    <!-- Additional Pictures Upload with Preview -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Additional Pictures (Up to 3, 300x200
                            px)</label>
                        <input type="file" id="additional-pictures" name="images[]" accept="image/*" multiple
                            class="border p-2 w-full" onchange="previewAdditionalImages(this)">
                        <p class="text-sm text-gray-500 mt-1">You can upload up to 3 images with 300x200 pixels each.
                        </p>
                        <div id="additional-images-preview" class="mt-4 flex space-x-4"></div>
                    </div>

                    <!-- Restaurant/Cafe Name Input -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Restaurant/Cafe Name</label>
                        <input type="text" class="border p-2 w-full" name="restaurantName"
                            placeholder="Enter restaurant or cafe name">
                    </div>

                    <!-- Description Input -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Description</label>
                        <textarea class="border p-2 w-full" name="description" rows="5"
                            placeholder="Enter description of the restaurant or cafe"></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">
                            <div id="map"></div>
                            <!-- Replace the value of the key parameter with your own API key. -->
                            <script async defer
                                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCkUOdZ5y7hMm0yrcCQoCvLwzdM6M8s5qk&callback=initMap">
                                </script>
                        </label>
                    </div>

                    <!-- Category Checkboxes -->
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Categories</label>
                        <div class="flex flex-wrap gap-4">
                            <label class="inline-flex items-center">
                                <input type="radio" name="categories" class="form-radio text-blue-500"
                                    value="Indonesian">
                                <span class="ml-2 text-gray-700">Indonesian</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="categories" class="form-radio text-blue-500" value="Western">
                                <span class="ml-2 text-gray-700">Western</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="categories" class="form-radio text-blue-500" value="Chinese">
                                <span class="ml-2 text-gray-700">Chinese</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="categories" class="form-radio text-blue-500"
                                    value="Middle East">
                                <span class="ml-2 text-gray-700">Middle East</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="categories" class="form-radio text-blue-500" value="Others">
                                <span class="ml-2 text-gray-700">Others</span>
                            </label>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="bg-blue-500 text-white font-semibold py-2 px-4 rounded hover:bg-blue-600">Save</button>
                </form>

                <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    // Get the form data
                    $restaurantName = trim($_POST['restaurantName']);
                    $restaurantId = md5($restaurantName);
                    $description = trim($_POST['description']);
                    $categories = trim($_POST['categories']);
                    $ownerId = $_SESSION['uid'];

                    // Check if the business already exists
                    $dataCheck = "SELECT * FROM restaurants WHERE restaurant_name ILIKE :restaurantName";
                    $stmt = $pdo->prepare($dataCheck);
                    $stmt->bindParam(":restaurantName", $restaurantName);
                    $stmt->execute();

                    $data = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($data) {
                        echo "<script>alert('Business already exists.');</script>";
                    } else {
                        if (isset($_FILES['images']) && count($_FILES['images']['tmp_name']) > 0) {
                            $images = $_FILES['images']; // Assign $_FILES['images'] to a variable for clarity
                
                            foreach ($images['tmp_name'] as $key => $tmpName) {
                                // Check if the file is uploaded and has no error
                                if (is_uploaded_file($tmpName) && $images['error'][$key] === UPLOAD_ERR_OK) {
                                    try {
                                        $upload = new UploadApi();
                                        $result = $upload->upload($tmpName, [ // Use $tmpName here
                                            "folder" => "MedanFoodHub/Restaurant/$restaurantId",
                                            "public_id" => "{$restaurantId}{$uploadIndex}"
                                        ]);

                                        $cloudinaryUrls[] = $result['secure_url']; // Collect the uploaded file URL
                                        $uploadIndex++;
                                    } catch (Exception $e) {
                                        echo 'Error uploading file: ' . $e->getMessage();
                                    }
                                }
                            }

                            // Check if any files were uploaded successfully
                            if (!empty($cloudinaryUrls)) {
                                $jsonUrls = json_encode($cloudinaryUrls);

                                // Prepare a SQL statement to insert the business
                                $sql = "INSERT INTO restaurants (id, uid, pictures, restaurant_name, descriptions, categories) VALUES (:id, :owner_id, :pictures, :restaurantName, :description, :categories)";
                                $stmt = $pdo->prepare($sql);
                                $stmt->bindParam(":id", $restaurantId);
                                $stmt->bindParam(':owner_id', $_SESSION['uid']);
                                $stmt->bindParam(':pictures', $jsonUrls);
                                $stmt->bindParam(':restaurantName', $restaurantName);
                                $stmt->bindParam(':description', $description);
                                $stmt->bindParam(':categories', $categories);

                                // Execute the SQL statement
                                if ($stmt->execute()) {
                                    echo "
                                    <script>
                                        alert('Business added successfully.');
                                        window.location.href='business';
                                    </script>";
                                } else {
                                    echo "
                                    <script>
                                        alert('Failed to add business.');
                                        window.location.href='business';
                                    </script>";
                                }
                            } else {
                                echo "
                                <script>
                                    alert('No files were uploaded.');
                                </script>";
                            }
                        } else {
                            echo "<script>alert('Failed to upload image.');</script>";
                        }
                    }
                }
                ?>

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
                <p class="text-white text-sm">Phone: <a href="tel:+6288262263417" class="hover:text-white">+62 882 6226
                        3417</a></p>
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


    <script>
        // Function to validate, preview, and add delete button for the main image
        function previewMainImage(input) {
            const file = input.files[0];
            const previewContainer = document.getElementById('main-image-preview');
            previewContainer.innerHTML = ""; // Clear previous preview

            if (file) {
                const img = new Image();
                img.src = URL.createObjectURL(file);
                img.onload = function () {
                    if (img.width === 300 && img.height === 200) {
                        previewContainer.innerHTML = `
                            <div class="relative">
                                <img src="${img.src}" alt="Main Image" class="w-48 h-32 object-cover rounded border border-gray-300">
                                <button onclick="deleteMainImage()" class="absolute top-1 right-1 bg-red-500 text-white rounded-full px-2 py-1 text-xs">Delete</button>
                            </div>`;
                    } else {
                        alert("Please upload an image with 300x200 pixels.");
                        input.value = ""; // Clear the input
                    }
                };
            }
        }

        function deleteMainImage() {
            document.getElementById('images').value = ""; // Clear file input
            document.getElementById('main-image-preview').innerHTML = ""; // Clear preview
        }

        // Function to validate, preview, and add delete button for each additional image
        function previewAdditionalImages(input) {
            if (input.files.length > 3) {
                alert("You can only upload up to 3 additional pictures.");
                input.value = ""; // Clear the input
                return;
            }

            const previewContainer = document.getElementById('additional-images-preview');
            previewContainer.innerHTML = ""; // Clear previous previews

            Array.from(input.files).forEach((file, index) => {
                const img = new Image();
                img.src = URL.createObjectURL(file);
                img.onload = function () {
                    if (img.width === 300 && img.height === 200) {
                        const imgElement = `
                            <div class="relative">
                                <img src="${img.src}" alt="Additional Image ${index + 1}" class="w-48 h-32 object-cover rounded border border-gray-300">
                                <button onclick="deleteAdditionalImage(${index})" class="absolute top-1 right-1 bg-red-500 text-white rounded-full px-2 py-1 text-xs">Delete</button>
                            </div>`;
                        previewContainer.insertAdjacentHTML('beforeend', imgElement);
                    } else {
                        alert("Each additional image must be 300x200 pixels.");
                        input.value = ""; // Clear the input
                        return;
                    }
                };
            });
        }

        function deleteAdditionalImage(index) {
            const additionalPicturesInput = document.getElementById('additional-pictures');
            const fileList = Array.from(additionalPicturesInput.files);

            // Remove the selected image from the file list
            fileList.splice(index, 1);
            const dataTransfer = new DataTransfer();
            fileList.forEach(file => dataTransfer.items.add(file));
            additionalPicturesInput.files = dataTransfer.files;

            // Refresh the previews
            previewAdditionalImages(additionalPicturesInput);
        }
    </script>

</body>

</html>