<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Emina Beauty - Stay Cute, Stay Confident')</title>

    {{-- FAVICON --}}
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('image/logo_emina.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('image/logo_emina.png') }}">
    
    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }
        
        :root {
            --primary: #F58B95;
            --secondary: #FFC1C8;
            --accent: #FF6B7A;
            --bg-light: #FFF5F7;
        }

        /* Smooth Scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--accent);
        }

        /* Prevent layout shift for mobile bottom nav */
        @media (max-width: 768px) {
            body {
                padding-bottom: 60px;
            }
        }

        /* Loading Animation */
        .loading-spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solid var(--primary);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Hover Effects */
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(245, 139, 149, 0.2);
        }

        /* Card Shadow */
        .card-shadow {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            transition: box-shadow 0.3s ease;
        }

        .card-shadow:hover {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
        }

        /* Toast Animations */
        @keyframes slide-in-right {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        @keyframes slide-out-right {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }
        
        .animate-slide-in-right {
            animation: slide-in-right 0.3s ease-out;
        }
    </style>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary': '#F58B95',
                        'secondary': '#FFC1C8',
                        'accent': '#FF6B7A',
                        'bg-light': '#FFF5F7',
                    },
                    boxShadow: {
                        'custom': '0 4px 14px rgba(245, 139, 149, 0.15)',
                    }
                }
            }
        }
    </script>

    @stack('styles')
</head>
<body class="bg-gray-50 min-h-screen">
    
    {{-- Navbar --}}
    @include('frontend.layouts.navbar')

    {{-- Main Content --}}
    <main class="min-h-screen">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('frontend.layouts.footer')

    {{-- Back to Top Button --}}
    <button id="backToTop" class="fixed bottom-24 md:bottom-8 right-4 bg-primary hover:bg-accent text-white w-12 h-12 rounded-full shadow-lg opacity-0 invisible transition-all duration-300 z-40 flex items-center justify-center">
        <i class="fas fa-arrow-up"></i>
    </button>

    {{-- 🔥 Toast Notification Container --}}
    <div id="toast-container" class="fixed top-20 right-4 z-[70] space-y-2"></div>

    {{-- jQuery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    {{-- 🔥 Global Functions --}}
    <script>
        // Back to Top Button
        const backToTopBtn = document.getElementById('backToTop');
        
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                backToTopBtn.classList.remove('opacity-0', 'invisible');
                backToTopBtn.classList.add('opacity-100', 'visible');
            } else {
                backToTopBtn.classList.remove('opacity-100', 'visible');
                backToTopBtn.classList.add('opacity-0', 'invisible');
            }
        });

        backToTopBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Loading state helper
        window.showLoading = function(element) {
            element.disabled = true;
            element.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Loading...';
        }

        window.hideLoading = function(element, originalText) {
            element.disabled = false;
            element.innerHTML = originalText;
        }

        // 🔥 Toast Notification Function
        window.showToast = function(message, type = 'success') {
            const container = document.getElementById('toast-container');
            
            const colors = {
                success: 'bg-green-500',
                error: 'bg-red-500',
                info: 'bg-blue-500',
                warning: 'bg-yellow-500'
            };
            
            const icons = {
                success: 'fa-check-circle',
                error: 'fa-exclamation-circle',
                info: 'fa-info-circle',
                warning: 'fa-exclamation-triangle'
            };
            
            const toast = document.createElement('div');
            toast.className = `${colors[type]} text-white px-6 py-4 rounded-lg shadow-2xl flex items-center gap-3 min-w-[300px] max-w-md animate-slide-in-right`;
            toast.innerHTML = `
                <i class="fas ${icons[type]} text-xl"></i>
                <div class="flex-1">
                    <p class="font-semibold text-sm">${message}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="text-white hover:text-gray-200 transition">
                    <i class="fas fa-times"></i>
                </button>
            `;
            
            container.appendChild(toast);
            
            // Auto remove after 3 seconds
            setTimeout(() => {
                toast.style.animation = 'slide-out-right 0.3s ease-out';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        // 🔥 Update Cart Badge (Global function)
        window.updateCartBadge = function() {
            fetch('/cart/count')
                .then(response => response.json())
                .then(data => {
                    const count = data.count;
                    const displayCount = count > 99 ? '99+' : count;
                    
                    // Desktop badge
                    const badgeDesktop = document.getElementById('cart-badge-desktop');
                    if (badgeDesktop) {
                        if (count > 0) {
                            badgeDesktop.textContent = displayCount;
                            badgeDesktop.style.display = 'flex';
                        } else {
                            badgeDesktop.style.display = 'none';
                        }
                    }
                    
                    // Mobile sidebar badge
                    const badgeSidebar = document.getElementById('cart-badge-mobile-sidebar');
                    if (badgeSidebar) {
                        if (count > 0) {
                            badgeSidebar.textContent = displayCount;
                            badgeSidebar.style.display = 'block';
                        } else {
                            badgeSidebar.style.display = 'none';
                        }
                    }
                    
                    // Bottom nav badge
                    const badgeBottom = document.getElementById('cart-badge-bottom');
                    if (badgeBottom) {
                        if (count > 0) {
                            badgeBottom.textContent = displayCount;
                            badgeBottom.style.display = 'flex';
                        } else {
                            badgeBottom.style.display = 'none';
                        }
                    }
                })
                .catch(error => console.error('Error updating cart badge:', error));
        }

        // Check session messages and update badge on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Update cart badge
            updateCartBadge();
            
            // Show session notifications
            @if(session('success'))
                showToast('{{ session('success') }}', 'success');
                setTimeout(() => updateCartBadge(), 500);
            @endif

            @if(session('error'))
                showToast('{{ session('error') }}', 'error');
            @endif

            @if(session('warning'))
                showToast('{{ session('warning') }}', 'warning');
            @endif

            @if(session('info'))
                showToast('{{ session('info') }}', 'info');
            @endif
        });

        // Update badge every 30 seconds (auto refresh)
        setInterval(updateCartBadge, 30000);
    </script>
    
    @stack('scripts')
</body>
</html>