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
                    <a href="#profileSettings"
                        class="block px-4 py-2 text-gray-700 hover:bg-blue-600 hover:text-white rounded-lg">Profile
                        Settings</a>
                    <a href="#verifyAccount"
                        class="block px-4 py-2 text-gray-700 hover:bg-blue-600 hover:text-white rounded-lg <?php echo $is_owner ? 'hidden' : ''; ?>">Verify
                        Account</a>
                    <a href="#" onclick="business()"
                        class="block px-4 py-2 text-gray-700 hover:bg-blue-600 hover:text-white rounded-lg <?php echo $is_owner ? '' : 'hidden'; ?>">Your
                        Business</a>
                    <a href="../config/logout.php"
                        class="block px-4 py-2 text-gray-700 hover:bg-red-600 hover:text-white rounded-lg">Log Out</a>
                    <a id="deleteAccount" href="#"
                        class="block px-4 py-2 text-gray-700 hover:bg-red-600 hover:text-white rounded-lg text-red-600">Delete
                        Account</a>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            <!-- Header Section -->
            <div class="container mx-auto my-8 bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-2xl font-semibold mb-6">Edit Business</h2>

                <!-- Main Picture Upload with Preview and Delete Option -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Main Picture (300x200 px)</label>
                    <input type="file" id="main-picture" accept="image/*" class="border p-2 w-full"
                        onchange="previewMainImage(this)">
                    <p class="text-sm text-gray-500 mt-1">Only images with 300x200 pixels are accepted.</p>
                    <div id="main-image-preview" class="mt-4">
                        <!-- Existing main image preview (if available) -->
                        <div class="relative">
                            <img src="existing-main-image.jpg" alt="Main Image"
                                class="w-48 h-32 object-cover rounded border border-gray-300">
                            <button onclick="deleteMainImage()"
                                class="absolute top-1 right-1 bg-red-500 text-white rounded-full px-2 py-1 text-xs">Delete</button>
                        </div>
                    </div>
                </div>

                <!-- Additional Pictures Upload with Preview and Delete Option -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Additional Pictures (Up to 3, 300x200
                        px)</label>
                    <input type="file" id="additional-pictures" accept="image/*" multiple class="border p-2 w-full"
                        onchange="previewAdditionalImages(this)">
                    <p class="text-sm text-gray-500 mt-1">You can upload up to 3 images with 300x200 pixels each.</p>
                    <div id="additional-images-preview" class="mt-4 flex space-x-4">
                        <!-- Existing additional images preview (if available) -->
                        <div class="relative">
                            <img src="existing-additional-image1.jpg" alt="Additional Image 1"
                                class="w-48 h-32 object-cover rounded border border-gray-300">
                            <button onclick="deleteAdditionalImage(0)"
                                class="absolute top-1 right-1 bg-red-500 text-white rounded-full px-2 py-1 text-xs">Delete</button>
                        </div>
                        <div class="relative">
                            <img src="existing-additional-image2.jpg" alt="Additional Image 2"
                                class="w-48 h-32 object-cover rounded border border-gray-300">
                            <button onclick="deleteAdditionalImage(1)"
                                class="absolute top-1 right-1 bg-red-500 text-white rounded-full px-2 py-1 text-xs">Delete</button>
                        </div>
                    </div>
                </div>

                <!-- Restaurant/Cafe Name Input -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Restaurant/Cafe Name</label>
                    <input type="text" class="border p-2 w-full" placeholder="Enter restaurant or cafe name"
                        value="Existing Restaurant Name">
                </div>

                <!-- Description Input -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Description</label>
                    <textarea class="border p-2 w-full"
                        placeholder="Enter description of the restaurant or cafe">Existing description of the restaurant or cafe.</textarea>
                </div>

                <!-- Category Checkboxes -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2">Category</label>
                    <div class="flex flex-wrap gap-4">
                        <label class="inline-flex items-center">
                            <input type="checkbox" class="form-checkbox text-blue-500" value="Nusantara">
                            <span class="ml-2 text-gray-700">Nusantara</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="checkbox" class="form-checkbox text-blue-500" value="Asian">
                            <span class="ml-2 text-gray-700">Asian</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="checkbox" class="form-checkbox text-blue-500" value="Western">
                            <span class="ml-2 text-gray-700">Western</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="checkbox" class="form-checkbox text-blue-500" value="Chinese">
                            <span class="ml-2 text-gray-700">Chinese</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="checkbox" class="form-checkbox text-blue-500" value="Middle East">
                            <span class="ml-2 text-gray-700">Middle East</span>
                        </label>
                    </div>
                </div>

                <!-- Save Button -->
                <button class="bg-blue-500 text-white font-semibold py-2 px-4 rounded hover:bg-blue-600">Save
                    Changes</button>
            </div>

        </main>
    </div>

    <script>
        // Script to add interactivity if needed in the future
        document.getElementById('manage').addEventListener('click', function () {
            window.location.href = 'manage-business.php';
        });
    </script>
</body>

</html>