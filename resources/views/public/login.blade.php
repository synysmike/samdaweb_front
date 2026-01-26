<!-- resources/views/auth/login.blade.php -->

<!-- resources/views/auth/login.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

{{-- <body class="min-h-screen flex bg-gray-100 relative"> --}}

<body class="min-h-screen bg-gray-100 relative">


    <style>
        #bg-slideshow {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
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

        #flip-card {
            height: auto;
            min-height: fit-content;
        }

        #login-side,
        #forgot-password-side,
        #register-side {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            width: 100%;
        }

        .loading-spinner {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .error-message {
            display: none;
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .error-message.show {
            display: block;
        }

        .input-error {
            border-color: #ef4444 !important;
        }

        .input-success {
            border-color: #10b981 !important;
        }
    </style>


    <div class="min-h-screen flex flex-col lg:flex-row">
        <!-- Image slideshow section (2/3 width) -->
        <div class="order-1 lg:order-none w-full lg:w-2/3 relative flex items-center justify-center">
            <!-- Background slideshow -->
            <div id="bg-slideshow">
                <img src="https://www.insignia.com/wp-content/uploads/2024/05/Insignia-Luxury-Lifestyle-Hero-scaled.jpg"
                    style="display:block;">
                <img src="https://images.pexels.com/photos/1034940/pexels-photo-1034940.jpeg" style="display:none;">
                <img src="https://media.istockphoto.com/id/2153823097/id/foto/pasangan-atletik-ceria-jogging-melalui-taman.jpg?s=612x612&w=0&k=20&c=a-m5-CokUaWQs_i8BGEryW-6RwCK8pkY-tWpvOvHhHo="
                    style="display:none;">
            </div>

            <!-- Elegant Welcome Card -->
            <div class="relative z-10 w-full max-w-lg mx-auto px-6 py-8">
                <div class="bg-white/10 backdrop-blur-lg rounded-2xl shadow-2xl border border-white/20 p-8 md:p-12 text-center transform transition-all duration-300 hover:scale-105">
                    <!-- Shop Logo -->
                    <div class="mb-6">
                        <img src="/images/logo.png" alt="Shop Logo" class="mx-auto w-32 h-32 md:w-40 md:h-40 object-contain drop-shadow-2xl">
                    </div>

                    <!-- Welcome Greeting -->
                    <div class="space-y-4">
                        <h1 class="text-4xl md:text-5xl font-bold text-white drop-shadow-lg">
                            Welcome Back
                        </h1>
                        <p class="text-xl md:text-2xl text-white/90 font-light drop-shadow-md">
                            Your journey continues here
                        </p>
                        <div class="pt-4">
                            <div class="w-24 h-1 bg-white/60 mx-auto rounded-full"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Login card (1/3 width with white background) -->
        <div class="order-2 lg:order-none w-full lg:w-1/3 flex items-center justify-center p-6 bg-gradient-to-br from-gray-50 via-white to-gray-50">
            <div class="relative w-full max-w-md perspective">
                <div id="flip-card" class="transition-transform duration-700 transform preserve-3d w-full"
                    style="transform-style: preserve-3d;">
                    <!-- Front: Login -->
                    <div id="login-side" class="absolute inset-0 w-full backface-hidden"
                        style="backface-visibility: hidden; -webkit-backface-visibility: hidden; transform: rotateY(0deg);">
                        <div class="bg-white shadow-2xl rounded-2xl p-8 flex flex-col border border-gray-100 relative overflow-hidden">
                            <!-- Decorative top accent -->
                            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-500 via-purple-500 to-blue-500"></div>

                            <!-- Header with icon -->
                            <div class="text-center mb-8">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 mb-4 shadow-lg">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <h1 class="text-3xl font-bold text-gray-800 mb-2">Welcome Back</h1>
                                <p class="text-sm text-gray-500">Sign in to continue</p>
                            </div>

                            <!-- Error Alert Container -->
                            <div id="login-error-alert" class="hidden mb-4 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700 text-sm"></div>

                            <!-- Success Alert Container -->
                            <div id="login-success-alert" class="hidden mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700 text-sm"></div>

                            <form id="login-form" class="space-y-5 flex-1">
                                <div>
                                    <label for="login-email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                            </svg>
                                        </div>
                                        <input type="email" id="login-email" name="email" required
                                            class="w-full pl-10 pr-4 py-3 rounded-lg border-2 border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all outline-none bg-gray-50 focus:bg-white"
                                            placeholder="you@example.com">
                                        <div class="error-message" id="login-email-error"></div>
                                    </div>
                                </div>
                                <div>
                                    <label for="login-password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                            </svg>
                                        </div>
                                        <input type="password" id="login-password" name="password" required
                                            class="w-full pl-10 pr-4 py-3 rounded-lg border-2 border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all outline-none bg-gray-50 focus:bg-white"
                                            placeholder="••••••••">
                                        <div class="error-message" id="login-password-error"></div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <a href="#" onclick="flipToForgotPassword(); return false;"
                                        class="text-sm text-blue-600 hover:underline">Forgot Password?</a>
                                </div>
                                <button type="submit" id="login-submit-btn" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white py-3 rounded-lg font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 hover:from-blue-700 hover:to-blue-800 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
                                    <span class="login-btn-text">Sign In</span>
                                    <span class="login-btn-loading hidden"><span class="loading-spinner mr-2"></span>Signing in...</span>
                                </button>
                            </form>
                            <!-- Divider -->
                            <div class="mt-6 relative">
                                <div class="absolute inset-0 flex items-center">
                                    <div class="w-full border-t border-gray-300 dark:border-gray-700"></div>
                                </div>
                                <div class="relative flex justify-center">
                                    <span
                                        class="bg-white px-2 text-sm text-gray-600 dark:text-gray-300">or</span>
                                </div>
                            </div>

                            <!-- Social login -->
                            <div class="mt-6 grid grid-cols-2 gap-3">
                                <!-- Google -->
                                <button type="button"
                                    class="flex items-center justify-center gap-2 rounded-lg border-2 border-gray-200 px-3 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:border-gray-300 transition-all shadow-sm hover:shadow">
                                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google"
                                        class="w-5 h-5">
                                    Google
                                </button>

                                <!-- Facebook -->
                                <button type="button"
                                    class="flex items-center justify-center gap-2 rounded-lg border-2 border-gray-200 px-3 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:border-gray-300 transition-all shadow-sm hover:shadow">
                                    <img src="https://www.svgrepo.com/show/475647/facebook-color.svg" alt="Facebook"
                                        class="w-5 h-5">
                                    Facebook
                                </button>
                            </div>

                            <!-- Sign Up Button -->
                            <div class="mt-6">
                                <button type="button" onclick="flipToRegister()"
                                    class="w-full bg-white border-2 border-blue-600 text-blue-600 py-3 rounded-lg font-semibold shadow-md hover:shadow-lg hover:bg-blue-50 transform hover:-translate-y-0.5 transition-all duration-200">
                                    Create New Account
                                </button>
                            </div>

                            <p class="mt-4 text-sm text-center text-gray-600">
                                Already have an account?
                                <span class="text-blue-600 font-medium">You're all set!</span>
                            </p>
                        </div>
                    </div>

                    <!-- Back: Forgot Password -->
                    <div id="forgot-password-side" class="absolute inset-0 w-full backface-hidden"
                        style="backface-visibility: hidden; -webkit-backface-visibility: hidden; transform: rotateY(180deg); z-index: 1;">
                        <div class="bg-white shadow-2xl rounded-2xl p-8 flex flex-col border border-gray-100 relative overflow-hidden">
                            <!-- Decorative top accent -->
                            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-500 via-purple-500 to-blue-500"></div>

                            <!-- Header with icon -->
                            <div class="text-center mb-8">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 mb-4 shadow-lg">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                                    </svg>
                                </div>
                                <h1 class="text-3xl font-bold text-gray-800 mb-2">Reset Password</h1>
                                <p class="text-sm text-gray-500 mb-6">
                                    Enter your email address and we'll send you a link to reset your password.
                                </p>
                            </div>

                            <!-- Error Alert Container -->
                            <div id="forgot-password-error-alert" class="hidden mb-4 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700 text-sm"></div>

                            <!-- Success Alert Container -->
                            <div id="forgot-password-success-alert" class="hidden mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700 text-sm"></div>

                            <form id="forgot-password-form" class="space-y-5 flex-1">
                                <div>
                                    <label for="forgot-email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                            </svg>
                                        </div>
                                        <input type="email" id="forgot-email" name="email" required
                                            class="w-full pl-10 pr-4 py-3 rounded-lg border-2 border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all outline-none bg-gray-50 focus:bg-white"
                                            placeholder="you@example.com">
                                        <div class="error-message" id="forgot-email-error"></div>
                                    </div>
                                </div>
                                <button type="submit" id="forgot-password-submit-btn" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white py-3 rounded-lg font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 hover:from-blue-700 hover:to-blue-800 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
                                    <span class="forgot-btn-text">Send Reset Link</span>
                                    <span class="forgot-btn-loading hidden"><span class="loading-spinner mr-2"></span>Sending...</span>
                                </button>
                            </form>
                            <p class="mt-4 text-sm text-center">
                                Remember your password?
                                <button onclick="flipToLogin()" class="text-blue-600 hover:underline">Back to
                                    Login</button>
                            </p>
                        </div>
                    </div>

                    <!-- Back: Register (hidden by default, shown when flipping to register) -->
                    <div id="register-side" class="absolute inset-0 w-full backface-hidden"
                        style="backface-visibility: hidden; -webkit-backface-visibility: hidden; transform: rotateY(180deg); z-index: 0; visibility: hidden;">
                        <div class="bg-white shadow-2xl rounded-2xl p-8 flex flex-col border border-gray-100 relative overflow-hidden">
                            <!-- Decorative top accent -->
                            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-green-500 via-emerald-500 to-green-500"></div>

                            <!-- Header with icon -->
                            <div class="text-center mb-8">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-br from-green-500 to-green-600 mb-4 shadow-lg">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                    </svg>
                                </div>
                                <h1 class="text-3xl font-bold text-gray-800 mb-2">Create Account</h1>
                                <p class="text-sm text-gray-500">Join us today</p>
                            </div>

                            <!-- Error Alert Container -->
                            <div id="register-error-alert" class="hidden mb-4 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700 text-sm"></div>

                            <!-- Success Alert Container -->
                            <div id="register-success-alert" class="hidden mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700 text-sm"></div>

                            <form id="register-form" class="space-y-5 flex-1">
                                <div>
                                    <label for="register-name" class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </div>
                                        <input type="text" id="register-name" name="name" required
                                            class="w-full pl-10 pr-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all outline-none bg-gray-50 focus:bg-white"
                                            placeholder="Your name">
                                        <div class="error-message" id="register-name-error"></div>
                                    </div>
                                </div>
                                <div>
                                    <label for="register-email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                            </svg>
                                        </div>
                                        <input type="email" id="register-email" name="email" required
                                            class="w-full pl-10 pr-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all outline-none bg-gray-50 focus:bg-white"
                                            placeholder="you@example.com">
                                        <div class="error-message" id="register-email-error"></div>
                                    </div>
                                </div>
                                <div>
                                    <label for="register-password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                            </svg>
                                        </div>
                                        <input type="password" id="register-password" name="password" required
                                            class="w-full pl-10 pr-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all outline-none bg-gray-50 focus:bg-white"
                                            placeholder="••••••••">
                                        <div class="error-message" id="register-password-error"></div>
                                    </div>
                                </div>
                                <div>
                                    <label for="register-confirm-password" class="block text-sm font-semibold text-gray-700 mb-2">Confirm Password</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                            </svg>
                                        </div>
                                        <input type="password" id="register-confirm-password" name="confirm_password" required
                                            class="w-full pl-10 pr-4 py-3 rounded-lg border-2 border-gray-200 focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all outline-none bg-gray-50 focus:bg-white"
                                            placeholder="••••••••">
                                        <div class="error-message" id="register-confirm-password-error"></div>
                                    </div>
                                </div>
                                <button type="submit" id="register-submit-btn" class="w-full bg-gradient-to-r from-green-600 to-green-700 text-white py-3 rounded-lg font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 hover:from-green-700 hover:to-green-800 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
                                    <span class="register-btn-text">Sign Up</span>
                                    <span class="register-btn-loading hidden"><span class="loading-spinner mr-2"></span>Creating account...</span>
                                </button>
                            </form>


                            <!-- Social login -->
                            <div class="mt-6 grid grid-cols-2 gap-3">
                                <!-- Google -->
                                <button type="button"
                                    class="flex items-center justify-center gap-2 rounded-lg border-2 border-gray-200 px-3 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:border-gray-300 transition-all shadow-sm hover:shadow">
                                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google"
                                        class="w-5 h-5">
                                    Google
                                </button>

                                <!-- Facebook -->
                                <button type="button"
                                    class="flex items-center justify-center gap-2 rounded-lg border-2 border-gray-200 px-3 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:border-gray-300 transition-all shadow-sm hover:shadow">
                                    <img src="https://www.svgrepo.com/show/475647/facebook-color.svg" alt="Facebook"
                                        class="w-5 h-5">
                                    Facebook
                                </button>
                            </div>
                            <p class="mt-4 text-sm text-center">
                                Already have an account?
                                <button onclick="flipToLogin()" class="text-green-600 hover:underline">Login</button>
                            </p>

                        </div>
                    </div>
                </div>
            </div>



        </div>

        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


        <script>
            // ============================================
            // API Configuration
            // ============================================
            const API_CONFIG = {
                baseURL: 'http://36.93.42.27:4340',
                endpoints: {
                    login: '/api/v1/auth/login',
                    register: '/api/v1/auth/register',
                    forgotPassword: '/api/password/forgot',
                    // Add more endpoints as needed
                },
                timeout: 30000, // 30 seconds
            };

            // ============================================
            // AJAX Setup for External API
            // ============================================
            $.ajaxSetup({
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            });

            // ============================================
            // Utility Functions
            // ============================================

            /**
             * Show error message for a specific field
             */
            function showFieldError(fieldId, message) {
                const errorElement = document.getElementById(fieldId + '-error');
                const inputElement = document.getElementById(fieldId);
                if (errorElement) {
                    errorElement.textContent = message;
                    errorElement.classList.add('show');
                }
                if (inputElement) {
                    inputElement.classList.add('input-error');
                    inputElement.classList.remove('input-success');
                }
            }

            /**
             * Clear error message for a specific field
             */
            function clearFieldError(fieldId) {
                const errorElement = document.getElementById(fieldId + '-error');
                const inputElement = document.getElementById(fieldId);
                if (errorElement) {
                    errorElement.textContent = '';
                    errorElement.classList.remove('show');
                }
                if (inputElement) {
                    inputElement.classList.remove('input-error');
                }
            }

            /**
             * Clear all errors for a form
             */
            function clearFormErrors(formId) {
                const form = document.getElementById(formId);
                if (form) {
                    const inputs = form.querySelectorAll('input');
                    inputs.forEach(input => {
                        clearFieldError(input.id);
                    });
                }
            }

            /**
             * Show alert message
             */
            function showAlert(alertId, message, type = 'error') {
                const alertElement = document.getElementById(alertId);
                if (alertElement) {
                    alertElement.textContent = message;
                    alertElement.classList.remove('hidden');
                    if (type === 'success') {
                        alertElement.classList.remove('bg-red-50', 'border-red-200', 'text-red-700');
                        alertElement.classList.add('bg-green-50', 'border-green-200', 'text-green-700');
                    } else {
                        alertElement.classList.remove('bg-green-50', 'border-green-200', 'text-green-700');
                        alertElement.classList.add('bg-red-50', 'border-red-200', 'text-red-700');
                    }
                }
            }

            /**
             * Hide alert message
             */
            function hideAlert(alertId) {
                const alertElement = document.getElementById(alertId);
                if (alertElement) {
                    alertElement.classList.add('hidden');
                }
            }

            /**
             * Set loading state for a button
             */
            function setButtonLoading(buttonId, isLoading) {
                const button = document.getElementById(buttonId);
                if (button) {
                    const textSpan = button.querySelector('.btn-text, .login-btn-text, .forgot-btn-text, .register-btn-text');
                    const loadingSpan = button.querySelector('.btn-loading, .login-btn-loading, .forgot-btn-loading, .register-btn-loading');

                    if (isLoading) {
                        button.disabled = true;
                        if (textSpan) textSpan.classList.add('hidden');
                        if (loadingSpan) loadingSpan.classList.remove('hidden');
                    } else {
                        button.disabled = false;
                        if (textSpan) textSpan.classList.remove('hidden');
                        if (loadingSpan) loadingSpan.classList.add('hidden');
                    }
                }
            }

            /**
             * Get form data as object
             */
            function getFormData(formId) {
                const form = document.getElementById(formId);
                const formData = new FormData(form);
                const data = {};
                for (let [key, value] of formData.entries()) {
                    data[key] = value;
                }
                return data;
            }

            /**
             * Validate email format
             */
            function isValidEmail(email) {
                if (!email || typeof email !== 'string') {
                    return false;
                }
                // RFC 5322 compliant email regex (simplified but effective)
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return emailRegex.test(email.trim());
            }

            /**
             * Validate email and show error if invalid
             */
            function validateEmailField(email, fieldId, alertId) {
                if (!email || email.trim() === '') {
                    showFieldError(fieldId, 'Email is required.');
                    if (alertId) {
                        showAlert(alertId, 'Please enter your email address.', 'error');
                    }
                    return false;
                }

                if (!isValidEmail(email)) {
                    showFieldError(fieldId, 'Please enter a valid email address.');
                    if (alertId) {
                        showAlert(alertId, 'Please enter a valid email address.', 'error');
                    }
                    return false;
                }

                return true;
            }

            /**
             * Handle API errors
             */
            function handleApiError(error, formId, alertId) {
                console.error('API Error:', error);

                let errorMessage = 'An error occurred. Please try again.';

                if (error.responseJSON) {
                    const response = error.responseJSON;

                    // Handle different API response formats
                    const errors = response.errors || response.error || response.message || response.data?.message;

                    if (typeof errors === 'object' && !Array.isArray(errors)) {
                        // Validation errors object (field-based)
                        Object.keys(errors).forEach(field => {
                            const fieldErrors = Array.isArray(errors[field]) ? errors[field] : [errors[field]];
                            const fieldId = formId.replace('-form', '-') + field.replace('_', '-');
                            showFieldError(fieldId, fieldErrors[0]);
                        });
                        errorMessage = 'Please fix the errors below.';
                    } else if (typeof errors === 'string') {
                        errorMessage = errors;
                    } else if (Array.isArray(errors) && errors.length > 0) {
                        errorMessage = errors[0];
                    } else if (response.message) {
                        errorMessage = response.message;
                    }
                } else if (error.status === 0) {
                    errorMessage = 'Network error. Please check your connection and CORS settings.';
                } else if (error.status === 401) {
                    errorMessage = 'Invalid credentials. Please try again.';
                } else if (error.status === 422) {
                    errorMessage = 'Validation failed. Please check your input.';
                } else if (error.status === 500) {
                    errorMessage = 'Server error. Please try again later.';
                } else if (error.statusText) {
                    errorMessage = error.statusText;
                }

                if (alertId) {
                    showAlert(alertId, errorMessage, 'error');
                }
            }

            // ============================================
            // API Call Functions
            // ============================================

            /**
             * Generic API POST function
             */
            function apiPost(endpoint, data, options = {}) {
                return $.ajax({
                    url: API_CONFIG.baseURL + endpoint,
                    method: 'POST',
                    data: JSON.stringify(data),
                    contentType: 'application/json',
                    dataType: 'json',
                    timeout: options.timeout || API_CONFIG.timeout,
                    beforeSend: options.beforeSend,
                    ...options
                });
            }

            /**
             * Login API call
             */
            function loginApi(email, password) {
                return apiPost(API_CONFIG.endpoints.login, {
                    email: email,
                    password: password
                });
            }

            /**
             * Register API call
             */
            function registerApi(name, email, password, confirmPassword) {
                return apiPost(API_CONFIG.endpoints.register, {
                    name: name,
                    email: email,
                    password: password,
                    confirm_password: confirmPassword
                });
            }

            /**
             * Store token in Laravel session
             */
            function storeTokenInSession(token, userData, profileData, roles) {
                const csrfToken = $('meta[name="csrf-token"]').attr('content');

                console.log('🌐 Making AJAX request to /api/store-token');
                console.log('📋 Request payload:', {
                    token: token ? 'Present' : 'Missing',
                    hasUser: !!userData,
                    hasProfile: !!profileData,
                    roles: roles
                });

                // Build request data - only include roles if it exists
                const requestData = {
                    token: token,
                    user: userData || null,
                    profile: profileData || null
                };

                // Only add roles if it exists and is not null/empty
                if (roles && roles !== null && roles !== '') {
                    requestData.roles = String(roles);
                }

                const ajaxRequest = $.ajax({
                    url: '/api/store-token',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    xhrFields: {
                        withCredentials: true // Important: Send cookies with request
                    },
                    data: JSON.stringify(requestData),
                    contentType: 'application/json',
                    dataType: 'json',
                    crossDomain: false,
                    beforeSend: function(xhr) {
                        console.log('📡 Request being sent...');
                        console.log('🔗 URL:', '/api/store-token');
                        console.log('📤 Method: POST');
                    }
                });

                // Add global error handler for debugging
                ajaxRequest.fail(function(jqXHR, textStatus, errorThrown) {
                    console.error('❌ AJAX Request Failed!');
                    console.error('Status:', jqXHR.status);
                    console.error('Status Text:', textStatus);
                    console.error('Error:', errorThrown);
                    console.error('Response:', jqXHR.responseText);
                    console.error('Response JSON:', jqXHR.responseJSON);
                });

                return ajaxRequest;
            }

            /**
             * Forgot Password API call
             */
            function forgotPasswordApi(email) {
                return apiPost(API_CONFIG.endpoints.forgotPassword, {
                    email: email
                });
            }

            // ============================================
            // Form Handlers
            // ============================================

            /**
             * Handle login form submission
             */
            function handleLogin(e) {
                e.preventDefault();

                const formId = 'login-form';
                const alertId = 'login-error-alert';
                const submitBtnId = 'login-submit-btn';

                // Clear previous errors
                clearFormErrors(formId);
                hideAlert(alertId);
                hideAlert('login-success-alert');

                // Get form data
                const formData = getFormData(formId);
                const email = formData.email;
                const password = formData.password;

                // Basic client-side validation
                if (!email || !password) {
                    showAlert(alertId, 'Please fill in all fields.', 'error');
                    if (!email) {
                        showFieldError('login-email', 'Email is required.');
                    }
                    if (!password) {
                        showFieldError('login-password', 'Password is required.');
                    }
                    return;
                }

                // Validate email format
                if (!validateEmailField(email, 'login-email', alertId)) {
                    return;
                }

                // Set loading state
                setButtonLoading(submitBtnId, true);

                // Make API call
                loginApi(email, password)
                    .done(function(response) {
                        // Handle success
                        console.log('Login successful:', response);

                        // Handle new response structure: { status, message, data: { token, user, profile, roles } }
                        let token = null;
                        let userData = null;
                        let profileData = null;
                        let roles = null;

                        if (response.data) {
                            // New structure: response.data contains token, user, profile, roles
                            token = response.data.token || response.data.access_token;
                            userData = response.data.user || null;
                            profileData = response.data.profile || null;
                            roles = response.data.roles || null;
                        } else {
                            // Fallback to old structure
                            token = response.token || response.access_token;
                            userData = response.user || null;
                        }

                        // Store token if provided
                        if (token) {
                            // Merge user and profile data
                            const mergedUserData = {
                                ...userData,
                                ...profileData,
                                roles: roles
                            };

                            // Store in localStorage as backup
                            localStorage.setItem('auth_token', token);
                            if (mergedUserData) {
                                localStorage.setItem('user_data', JSON.stringify(mergedUserData));
                            }

                            // Show success message
                            showAlert('login-success-alert', response.message || 'Login successful! Redirecting...', 'success');

                            // Store token in Laravel session with full data structure, then redirect
                            console.log('📤 Attempting to store token in session...');
                            console.log('🔑 Token:', token ? 'Present (' + token.substring(0, 20) + '...)' : 'Missing');
                            console.log('👤 User data:', mergedUserData);

                            const csrfToken = $('meta[name="csrf-token"]').attr('content');
                            console.log('🔐 CSRF Token:', csrfToken ? 'Present' : 'Missing');

                            if (!csrfToken) {
                                console.error('❌ CSRF Token is missing! Cannot proceed.');
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'CSRF token missing. Please refresh the page and try again.',
                                    confirmButtonColor: '#3085d6'
                                });
                                return;
                            }

                            storeTokenInSession(token, mergedUserData, profileData, roles)
                                .done(function(sessionResponse) {
                                    console.log('✅ Token stored in session:', sessionResponse);
                                    console.log('Session ID:', sessionResponse.session_id);
                                    console.log('Has token:', sessionResponse.has_token);

                                    if (sessionResponse.has_token) {
                                        // Wait longer to ensure session is fully saved server-side
                                        // Then redirect to home page with a fresh request
                                        setTimeout(() => {
                                            // Force a full page navigation to ensure session cookie is sent
                                            // Use replace to avoid back button issues
                                            window.location.replace(window.location.origin + '/');
                                        }, 1500);
                                    } else {
                                        console.warn('⚠️ Token not found in session response, but continuing...');
                                        setTimeout(() => {
                                            window.location.href = '/';
                                        }, 1500);
                                    }
                                })
                                .fail(function(error) {
                                    console.error('❌ Failed to store token in session:', error);
                                    console.error('Error details:', error.responseJSON || error.responseText || error);
                                    console.error('Status:', error.status);
                                    console.error('Status text:', error.statusText);

                                    // Still redirect even if session storage fails (token is in localStorage)
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Warning',
                                        text: 'Session storage failed, but you can still use the app. Token is stored in localStorage.',
                                        confirmButtonColor: '#3085d6'
                                    });
                                    setTimeout(() => {
                                        window.location.href = '/';
                                    }, 1000);
                                });
                        } else {
                            // No token, just show message
                            showAlert('login-success-alert', response.message || 'Login successful!', 'success');
                        }
                    })
                    .fail(function(error) {
                        // Handle error
                        handleApiError(error, formId, alertId);
                    })
                    .always(function() {
                        // Always reset loading state
                        setButtonLoading(submitBtnId, false);
                    });
            }

            /**
             * Handle register form submission
             */
            function handleRegister(e) {
                e.preventDefault();

                const formId = 'register-form';
                const alertId = 'register-error-alert';
                const submitBtnId = 'register-submit-btn';

                // Clear previous errors
                clearFormErrors(formId);
                hideAlert(alertId);
                hideAlert('register-success-alert');

                // Get form data
                const formData = getFormData(formId);
                const name = formData.name;
                const email = formData.email;
                const password = formData.password;
                const confirmPassword = formData.confirm_password;

                // Basic client-side validation
                if (!name || !email || !password || !confirmPassword) {
                    showAlert(alertId, 'Please fill in all fields.', 'error');
                    if (!name) {
                        showFieldError('register-name', 'Name is required.');
                    }
                    if (!email) {
                        showFieldError('register-email', 'Email is required.');
                    }
                    if (!password) {
                        showFieldError('register-password', 'Password is required.');
                    }
                    if (!confirmPassword) {
                        showFieldError('register-confirm-password', 'Please confirm your password.');
                    }
                    return;
                }

                // Validate email format
                if (!validateEmailField(email, 'register-email', alertId)) {
                    return;
                }

                if (password.length < 8) {
                    showAlert(alertId, 'Password must be at least 8 characters.', 'error');
                    showFieldError('register-password', 'Password must be at least 8 characters.');
                    return;
                }

                // Validate password match
                if (password !== confirmPassword) {
                    showAlert(alertId, 'Passwords do not match.', 'error');
                    showFieldError('register-confirm-password', 'Passwords do not match.');
                    return;
                }

                // Set loading state
                setButtonLoading(submitBtnId, true);

                // Make API call
                registerApi(name, email, password, confirmPassword)
                    .done(function(response) {
                        // Handle success
                        console.log('Registration successful:', response);

                        // Handle new response structure: { status, message, data: { token, user, profile, roles } }
                        let token = null;
                        let userData = null;
                        let profileData = null;
                        let roles = null;

                        if (response.data) {
                            // New structure: response.data contains token, user, profile, roles
                            token = response.data.token || response.data.access_token;
                            userData = response.data.user || null;
                            profileData = response.data.profile || null;
                            roles = response.data.roles || null;
                        } else {
                            // Fallback to old structure
                            token = response.token || response.access_token;
                            userData = response.user || null;
                        }

                        // Store token if provided
                        if (token) {
                            // Merge user and profile data
                            const mergedUserData = {
                                ...userData,
                                ...profileData,
                                roles: roles
                            };

                            // Store in localStorage as backup
                            localStorage.setItem('auth_token', token);
                            if (mergedUserData) {
                                localStorage.setItem('user_data', JSON.stringify(mergedUserData));
                            }

                            // Show success message
                            showAlert('register-success-alert', response.message || 'Registration successful! Redirecting...', 'success');

                            // Store token in Laravel session with full data structure, then redirect
                            storeTokenInSession(token, mergedUserData, profileData, roles)
                                .done(function(sessionResponse) {
                                    console.log('Token stored in session:', sessionResponse);
                                    // Redirect after token is stored in session
                                    setTimeout(() => {
                                        window.location.href = '/';
                                    }, 500);
                                })
                                .fail(function(error) {
                                    console.error('Failed to store token in session:', error);
                                    // Still redirect even if session storage fails
                                    setTimeout(() => {
                                        window.location.href = '/';
                                    }, 500);
                                });
                        } else {
                            // No token, redirect to login page
                            showAlert('register-success-alert', response.message || 'Registration successful! Redirecting to login...', 'success');
                            setTimeout(() => {
                                flipToLogin();
                            }, 2000);
                        }
                    })
                    .fail(function(error) {
                        // Handle error
                        handleApiError(error, formId, alertId);
                    })
                    .always(function() {
                        // Always reset loading state
                        setButtonLoading(submitBtnId, false);
                    });
            }

            /**
             * Handle forgot password form submission
             */
            function handleForgotPassword(e) {
                e.preventDefault();

                const formId = 'forgot-password-form';
                const alertId = 'forgot-password-error-alert';
                const submitBtnId = 'forgot-password-submit-btn';

                // Clear previous errors
                clearFormErrors(formId);
                hideAlert(alertId);
                hideAlert('forgot-password-success-alert');

                // Get form data
                const formData = getFormData(formId);
                const email = formData.email;

                // Validate email format
                if (!validateEmailField(email, 'forgot-email', alertId)) {
                    return;
                }

                // Set loading state
                setButtonLoading(submitBtnId, true);

                // Make API call
                forgotPasswordApi(email)
                    .done(function(response) {
                        // Handle success
                        console.log('Forgot password successful:', response);

                        // Show success message
                        showAlert('forgot-password-success-alert', response.message || 'Password reset link has been sent to your email.', 'success');

                        // Clear form
                        document.getElementById('forgot-email').value = '';
                    })
                    .fail(function(error) {
                        // Handle error
                        handleApiError(error, formId, alertId);
                    })
                    .always(function() {
                        // Always reset loading state
                        setButtonLoading(submitBtnId, false);
                    });
            }

            // ============================================
            // Flip Card Functions
            // ============================================
            let currentSide = 'login'; // 'login', 'forgot-password', or 'register'

            function updateFlipCardHeight() {
                const card = document.getElementById('flip-card');
                const loginSide = document.getElementById('login-side');
                const forgotPasswordSide = document.getElementById('forgot-password-side');
                const registerSide = document.getElementById('register-side');

                // Get the height of the currently visible side
                let visibleHeight = 0;
                if (currentSide === 'login' && loginSide) {
                    visibleHeight = loginSide.querySelector('div').offsetHeight;
                } else if (currentSide === 'forgot-password' && forgotPasswordSide) {
                    visibleHeight = forgotPasswordSide.querySelector('div').offsetHeight;
                } else if (currentSide === 'register' && registerSide) {
                    visibleHeight = registerSide.querySelector('div').offsetHeight;
                }

                // Set the flip-card height to match the visible content
                if (card && visibleHeight > 0) {
                    card.style.height = visibleHeight + 'px';
                }
            }

            function flipToLogin() {
                const card = document.getElementById('flip-card');
                const forgotPasswordSide = document.getElementById('forgot-password-side');
                const registerSide = document.getElementById('register-side');

                currentSide = 'login';
                card.style.transform = 'rotateY(0deg)';
                forgotPasswordSide.style.visibility = 'hidden';
                forgotPasswordSide.style.zIndex = '0';
                registerSide.style.visibility = 'hidden';
                registerSide.style.zIndex = '0';
                setTimeout(updateFlipCardHeight, 100);
            }

            function flipToForgotPassword() {
                const card = document.getElementById('flip-card');
                const forgotPasswordSide = document.getElementById('forgot-password-side');
                const registerSide = document.getElementById('register-side');

                currentSide = 'forgot-password';
                forgotPasswordSide.style.visibility = 'visible';
                forgotPasswordSide.style.zIndex = '2';
                registerSide.style.visibility = 'hidden';
                registerSide.style.zIndex = '0';
                card.style.transform = 'rotateY(180deg)';
                setTimeout(updateFlipCardHeight, 100);
            }

            function flipToRegister() {
                const card = document.getElementById('flip-card');
                const forgotPasswordSide = document.getElementById('forgot-password-side');
                const registerSide = document.getElementById('register-side');

                currentSide = 'register';
                forgotPasswordSide.style.visibility = 'hidden';
                forgotPasswordSide.style.zIndex = '0';
                registerSide.style.visibility = 'visible';
                registerSide.style.zIndex = '2';
                card.style.transform = 'rotateY(180deg)';
                setTimeout(updateFlipCardHeight, 100);
            }

            // Keep the old flipCard function for backward compatibility
            function flipCard() {
                if (currentSide === 'login') {
                    flipToRegister();
                } else {
                    flipToLogin();
                }
            }

            // ============================================
            // Document Ready
            // ============================================
            $(function() {
                // Initialize slideshow
                let $slides = $('#bg-slideshow img');
                let i = 0;
                setInterval(function() {
                    $slides.eq(i).fadeOut(5000);
                    i = (i + 1) % $slides.length;
                    $slides.eq(i).fadeIn(5000);
                }, 6000);

                // Initialize flip card height on page load
                updateFlipCardHeight();

                // Update height on window resize
                $(window).on('resize', function() {
                    updateFlipCardHeight();
                });

                // Attach form submit handlers
                $('#login-form').on('submit', handleLogin);
                $('#register-form').on('submit', handleRegister);
                $('#forgot-password-form').on('submit', handleForgotPassword);

                // Clear errors on input change
                $('#login-form input').on('input', function() {
                    clearFieldError(this.id);
                });

                $('#register-form input').on('input', function() {
                    clearFieldError(this.id);
                });

                $('#forgot-password-form input').on('input', function() {
                    clearFieldError(this.id);
                });

                // Real-time email validation on blur
                $('#login-email, #register-email, #forgot-email').on('blur', function() {
                    const email = $(this).val();
                    const fieldId = this.id;

                    if (email && email.trim() !== '') {
                        if (!isValidEmail(email)) {
                            showFieldError(fieldId, 'Please enter a valid email address.');
                        } else {
                            clearFieldError(fieldId);
                        }
                    }
                });

                // Initialize tooltips or other plugins if needed
                // Example: Initialize validation, etc.
            });
        </script>
</body>

</html>