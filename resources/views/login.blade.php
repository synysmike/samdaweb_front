<!-- resources/views/auth/login.blade.php -->

<!-- resources/views/auth/login.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

{{-- <body class="min-h-screen flex bg-gray-100 relative"> --}}

<body class="min-h-screen bg-gray-100 relative">

    <!-- Background slideshow (optional) -->
    <div id="bg-slideshow">
        <img src="https://www.insignia.com/wp-content/uploads/2024/05/Insignia-Luxury-Lifestyle-Hero-scaled.jpg"
            style="display:block;">
        <img src="https://images.pexels.com/photos/1034940/pexels-photo-1034940.jpeg" style="display:none;">
        <img src="https://media.istockphoto.com/id/2153823097/id/foto/pasangan-atletik-ceria-jogging-melalui-taman.jpg?s=612x612&w=0&k=20&c=a-m5-CokUaWQs_i8BGEryW-6RwCK8pkY-tWpvOvHhHo="
            style="display:none;">
    </div>

    <style>
        #bg-slideshow {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        #bg-slideshow img {
            position: absolute;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .perspective {
            perspective: 1000px;
        }

        .preserve-3d {
            transform-style: preserve-3d;
        }

        .backface-hidden {
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden;
        }

        .rotate-y-180 {
            transform: rotateY(180deg);
        }

        #flip-card.flipped {
            transform: rotateY(180deg);
        }
    </style>


    <div class="min-h-screen flex flex-col lg:flex-row">
        <!-- Branding card -->
        <div class="order-1 lg:order-none w-full lg:w-1/2 flex items-center justify-center p-6">
            <div class="bg-white/20 backdrop-blur-md rounded-xl shadow-lg p-6 text-center w-full max-w-md min-h-[500px] flex flex-col justify-center">
                <img src="/images/logo.png" alt="Brand Logo" class="mx-auto w-24 sm:w-32 mb-6">
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-gray-100">Welcome to MyApp</h2>
                <p class="mt-2 text-base sm:text-lg text-gray-700 dark:text-gray-300">Your tagline goes here</p>
                <img src="/images/illustration.png" alt="Illustration" class="mt-6 max-w-xs sm:max-w-md mx-auto">
            </div>
        </div>

        <!-- Login card -->
        <div class="order-2 lg:order-none w-full lg:w-1/2 flex items-center justify-center p-6">
            <div class="relative w-full max-w-md perspective flex items-center">
                <div id="flip-card" class="transition-transform duration-700 transform preserve-3d w-full min-h-[500px]" style="transform-style: preserve-3d;">
                    <!-- Front: Login -->
                    <div class="absolute inset-0 w-full backface-hidden min-h-[500px]" style="backface-visibility: hidden; -webkit-backface-visibility: hidden; transform: rotateY(0deg);">
                        <div class="bg-white/30 backdrop-blur-md shadow-2xl rounded-xl p-8 h-full flex flex-col">
                            <h1 class="text-2xl font-bold mb-6">Login</h1>
                            <form class="space-y-4">
                                <div>
                                    <label>Email</label>
                                    <input type="email" class="w-full px-3 py-3 rounded-lg border"
                                        placeholder="you@example.com">
                                </div>
                                <div>
                                    <label>Password</label>
                                    <input type="password" class="w-full px-3 py-3 rounded-lg border"
                                        placeholder="••••••••">
                                </div>
                                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg">Sign
                                    In</button>
                            </form>
                            <!-- Divider -->
                            <div class="mt-6 relative">
                                <div class="absolute inset-0 flex items-center">
                                    <div class="w-full border-t border-gray-300 dark:border-gray-700"></div>
                                </div>
                                <div class="relative flex justify-center">
                                    <span
                                        class="bg-white/30 dark:bg-gray-800/30 px-2 text-sm text-gray-600 dark:text-gray-300">or</span>
                                </div>
                            </div>

                            <!-- Social login -->
                            <div class="mt-6 grid grid-cols-2 gap-3">
                                <!-- Google -->
                                <button type="button"
                                    class="flex items-center justify-center gap-2 rounded-lg border border-gray-300 dark:border-gray-700 px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-900">
                                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google"
                                        class="w-5 h-5">
                                    Google
                                </button>

                                <!-- Facebook -->
                                <button type="button"
                                    class="flex items-center justify-center gap-2 rounded-lg border border-gray-300 dark:border-gray-700 px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-900">
                                    <img src="https://www.svgrepo.com/show/475647/facebook-color.svg" alt="Facebook"
                                        class="w-5 h-5">
                                    Facebook
                                </button>
                            </div>
                            <p class="mt-4 text-sm text-center">
                                Don’t have an account?
                                <button onclick="flipCard()" class="text-blue-600 hover:underline">Sign up</button>
                            </p>
                        </div>
                    </div>

                    <!-- Back: Register -->
                    <div class="absolute inset-0 w-full backface-hidden min-h-[500px]" style="backface-visibility: hidden; -webkit-backface-visibility: hidden; transform: rotateY(180deg);">
                        <div class="bg-white/30 backdrop-blur-md shadow-2xl rounded-xl p-8 h-full flex flex-col">
                            <h1 class="text-2xl font-bold mb-6">Register</h1>
                            <form class="space-y-4">
                                <div>
                                    <label>Name</label>
                                    <input type="text" class="w-full px-3 py-3 rounded-lg border"
                                        placeholder="Your name">
                                </div>
                                <div>
                                    <label>Email</label>
                                    <input type="email" class="w-full px-3 py-3 rounded-lg border"
                                        placeholder="you@example.com">
                                </div>
                                <div>
                                    <label>Password</label>
                                    <input type="password" class="w-full px-3 py-3 rounded-lg border"
                                        placeholder="••••••••">
                                </div>
                                <button type="submit" class="w-full bg-green-600 text-white py-2 rounded-lg">Sign
                                    Up</button>
                            </form>
                            <!-- Divider -->
                            <!-- <div class="mt-6 relative">
                                <div class="absolute inset-0 flex items-center">
                                    <div class="w-full border-t border-gray-300 dark:border-gray-700"></div>
                                </div>
                                <div class="relative flex justify-center">
                                    <span
                                        class="bg-white/30 dark:bg-gray-800/30 px-2 text-sm text-gray-600 dark:text-gray-300">or</span>
                                </div>
                            </div> -->

                            <!-- Social login -->
                            <div class="mt-6 grid grid-cols-2 gap-3">
                                <!-- Google -->
                                <button type="button"
                                    class="flex items-center justify-center gap-2 rounded-lg border border-gray-300 dark:border-gray-700 px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-900">
                                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google"
                                        class="w-5 h-5">
                                    Google
                                </button>

                                <!-- Facebook -->
                                <button type="button"
                                    class="flex items-center justify-center gap-2 rounded-lg border border-gray-300 dark:border-gray-700 px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-900">
                                    <img src="https://www.svgrepo.com/show/475647/facebook-color.svg" alt="Facebook"
                                        class="w-5 h-5">
                                    Facebook
                                </button>
                            </div>
                            <p class="mt-4 text-sm text-center">
                                Already have an account?
                                <button onclick="flipCard()" class="text-green-600 hover:underline">Login</button>
                            </p>

                        </div>
                    </div>
                </div>
            </div>






            {{-- <div class="w-full max-w-md bg-white/30 dark:bg-gray-800/30 backdrop-blur-md shadow-2xl rounded-xl p-8">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">Login</h1>

                <form class="space-y-5">
                    <!-- Email -->
                    <div>
                        <label for="email"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                        <input type="email" id="email" name="email"
                            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900/40 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500 px-3 py-3"
                            placeholder="you@example.com" required />
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                        <input type="password" id="password" name="password"
                            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900/40 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500 px-3 py-3"
                            placeholder="••••••••" required />
                    </div>

                    <!-- Submit -->
                    <button type="submit"
                        class="w-full rounded-lg bg-blue-600/80 hover:bg-blue-600 text-white py-2 font-medium">
                        Sign In
                    </button>
                </form>

                <!-- Divider -->
                <div class="mt-6 relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300 dark:border-gray-700"></div>
                    </div>
                    <div class="relative flex justify-center">
                        <span
                            class="bg-white/30 dark:bg-gray-800/30 px-2 text-sm text-gray-600 dark:text-gray-300">or</span>
                    </div>
                </div>

                <!-- Social login -->
                <div class="mt-6 grid grid-cols-2 gap-3">
                    <!-- Google -->
                    <button type="button"
                        class="flex items-center justify-center gap-2 rounded-lg border border-gray-300 dark:border-gray-700 px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-900">
                        <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" class="w-5 h-5">
                        Google
                    </button>

                    <!-- Facebook -->
                    <button type="button"
                        class="flex items-center justify-center gap-2 rounded-lg border border-gray-300 dark:border-gray-700 px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-900">
                        <img src="https://www.svgrepo.com/show/475647/facebook-color.svg" alt="Facebook"
                            class="w-5 h-5">
                        Facebook
                    </button>
                </div>


                <!-- Footer -->
                <p class="mt-6 text-sm text-gray-600 dark:text-gray-300 text-center">
                    Don’t have an account?
                    <a href="#" class="text-blue-600 hover:text-blue-500">Sign up</a>
                </p>
            </div>
        </div> --}}
        </div>

        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


        <script>
            let flipped = false;

            function flipCard() {
                const card = document.getElementById('flip-card');
                flipped = !flipped;
                card.style.transform = flipped ? 'rotateY(180deg)' : 'rotateY(0deg)';
            }
            $(function() {
                let $slides = $('#bg-slideshow img');
                let i = 0;
                setInterval(function() {
                    $slides.eq(i).fadeOut(5000);
                    i = (i + 1) % $slides.length;
                    $slides.eq(i).fadeIn(5000);
                }, 6000);
            });
        </script>
</body>

</html>
