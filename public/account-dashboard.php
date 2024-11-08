<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Dashboard - MedanFoodHub</title>
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

        <!-- Delete Account Modal -->
        <div id="deleteAccountModal"
            class="modal hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
            <div class="bg-white rounded-lg shadow-lg p-8 w-96">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4 text-center">Confirm Account Deletion</h2>
                <p class="text-sm text-gray-600 mb-6 text-center">Please re-enter your email to confirm account
                    deletion.</p>

                <form id="deleteAccountForm" method="POST" action="../config/delete_account.php">
                    <label for="confirmEmail" class="block text-gray-700">Email</label>
                    <input type="email" id="confirmEmail" name="confirm_email" required
                        class="mt-1 block w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-600"
                        placeholder="example@gmail.com">

                    <button type="submit"
                        class="mt-4 w-full bg-red-600 text-white py-2 rounded-lg hover:bg-red-500 transition duration-200">Delete
                        Account</button>
                </form>

                <div class="flex justify-center mt-4">
                    <button id="closeDeleteModal" class="text-gray-600 hover:text-gray-900">Cancel</button>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            <section id="profileSettings" class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-2xl font-semibold text-gray-800 mb-6">Profile Settings</h3>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="mb-4">
                        <img src="../Assets/blankPic.png" alt="Current Profile Picture" id="profilePic"
                            class="w-32 h-32 rounded-full mx-auto object-cover mb-3">
                        <input type="file" id="profilePicture" name="profilePicture"
                            class="block w-full text-sm text-gray-500 border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
                    </div>

                    <div class="mb-4">
                        <label for="full_name" class="block text-gray-700 font-medium mb-2">Name</label>
                        <input type="text" id="full_name" name="full_name"
                            class="block w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-600"
                            placeholder="New Name..." value="">
                    </div>

                    <div class="mb-4">
                        <label for="bio" class="block text-gray-700 font-medium mb-2">Bio</label>
                        <textarea id="bio" name="bio" rows="3"
                            class="block w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-600"
                            placeholder="Write something about yourself..."></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                        <input type="email" id="email" name="email"
                            class="block w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-600"
                            placeholder="example@gmail.com" value="">
                    </div>

                    <div class="mb-4">
                        <label for="phone" class="block text-gray-700 font-medium mb-2">Phone Number</label>
                        <input type="tel" id="phone" name="phone"
                            class="block w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-600"
                            placeholder="Phone Number" value="">
                    </div>

                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-500 transition duration-200">Save
                        Changes</button>
                </form>
            </section>

            <!-- Verify Account Section -->
            <section id="verifyAccount" class="bg-white p-6 rounded-lg shadow-md mt-6">
                <h3 class="text-2xl font-semibold text-gray-800 mb-4">Verify Account</h3>
                <p class='text-gray-700 mb-6'>
                    Account verification is required if you are a restaurant or cafe owner and want to list your
                    business on our platform. Verifying your account allows you to manage your restaurant's details,
                    including menu items, hours, and special offers.
                    Verified owners gain control over their establishment's profile, ensuring accurate and up-to-date
                    information for users. To get verified, please submit your business documentation, and our team will
                    review and approve your request within a few business days.
                </p>

                <!-- Button to start verification process -->
                <button class='bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-500 transition duration-200'
                    onclick='verif()'>
                    Start Verification Process
                </button>
            </section>

        </main>
    </div>

    <script>
        document.getElementById('deleteAccount').addEventListener('click', function () {
            document.getElementById('deleteAccountModal').classList.remove('hidden');
        });

        document.getElementById('closeDeleteModal').addEventListener('click', function () {
            document.getElementById('deleteAccountModal').classList.add('hidden');
        });

        function verif() {
            window.location.href = "account-verification.php";
        }

        function business() {
            window.location.href = "business-dashboard.php";
        }

        const profilePic = document.getElementById('profilePic');
        const inputProfile = document.getElementById('profilePicture');

        if (inputProfile) {
            inputProfile.addEventListener('change', function () {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function () {
                        profilePic.src = reader.result;
                    }
                    reader.readAsDataURL(file);
                }
            });
        }

    </script>
</body>

</html>