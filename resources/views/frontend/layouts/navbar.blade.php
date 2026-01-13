{{-- Top Banner Promo --}}
<div class="bg-gradient-to-r from-primary to-accent text-white py-2 text-center text-sm">
    <div class="container mx-auto px-4 flex items-center justify-center space-x-4">
        <i class="fas fa-gift"></i>
        <span>Gratis Ongkir min. belanja Rp 50.000 | Diskon hingga 50% untuk produk pilihan!</span>
    </div>
</div>

{{-- Main Navbar --}}
<nav class="bg-white shadow-md sticky top-0 z-50">
    <div class="container mx-auto px-4 py-3">
        <div class="flex items-center justify-between gap-4">
            
            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center space-x-2 flex-shrink-0">
                <img src="{{ asset('image/logo_emina.png') }}" alt="Emina Beauty" class="w-10 h-10 object-contain">
                <div class="hidden lg:block">
                    <h1 class="text-xl font-bold bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent">
                        Emina Beauty
                    </h1>
                    <p class="text-xs text-gray-500">Stay Cute, Stay Confident</p>
                </div>
            </a>

            {{-- Search Bar (Desktop) --}}
            <div class="hidden md:flex flex-1 max-w-2xl">
                <form action="{{ route('shop.index') }}" method="GET" class="w-full flex">
                    <input type="text" 
                           name="search" 
                           placeholder="Cari produk makeup, skincare, atau lip cream..."
                           class="flex-1 px-4 py-2 border-2 border-primary rounded-l-md focus:outline-none focus:border-accent"
                           value="{{ request('search') }}">
                    <button type="submit" class="bg-primary hover:bg-accent text-white px-6 rounded-r-md transition">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>

            {{-- Right Menu (Desktop) --}}
            <div class="hidden md:flex items-center space-x-6">
                {{-- Cart dengan Badge --}}
                <a href="{{ route('cart.index') }}" class="relative hover:text-primary transition group">
                    <i class="fas fa-shopping-cart text-2xl text-gray-700 group-hover:text-primary"></i>
                    
                    {{-- 🔥 BADGE NOTIFIKASI DESKTOP --}}
                    <span id="cart-badge-desktop" 
                          class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center shadow-lg animate-bounce"
                          style="display: none;">
                        0
                    </span>
                    
                    <span class="text-xs text-gray-600 group-hover:text-primary block text-center mt-1">Keranjang</span>
                </a>

                {{-- User Menu --}}
                @auth('customer')
                    <div class="relative group">
                        <button class="flex items-center space-x-2 hover:text-primary transition">
                            <div class="w-9 h-9 rounded-full overflow-hidden border-2 border-primary">
                                @if(Auth::guard('customer')->user()->foto)
                                    <img src="{{ asset('storage/img-customer/' . Auth::guard('customer')->user()->foto) }}" 
                                         alt="{{ Auth::guard('customer')->user()->nama }}" 
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gradient-to-r from-primary to-accent flex items-center justify-center">
                                        <i class="fas fa-user text-white text-sm"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="text-left">
                                <p class="text-xs text-gray-600">Akun Saya</p>
                                <p class="text-sm font-medium text-gray-800 max-w-[100px] truncate">{{ Auth::guard('customer')->user()->nama }}</p>
                            </div>
                            <i class="fas fa-chevron-down text-xs text-gray-500"></i>
                        </button>
                        
                        {{-- Dropdown --}}
                        <div class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 border">
                            <div class="px-4 py-3 border-b bg-bg-light">
                                <p class="text-sm font-semibold text-gray-800">{{ Auth::guard('customer')->user()->nama }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ Auth::guard('customer')->user()->email }}</p>
                            </div>
                            <a href="{{ route('customer.profile') }}" class="flex items-center px-4 py-3 hover:bg-bg-light text-gray-700 hover:text-primary transition">
                                <i class="fas fa-user-circle mr-3 w-5"></i> 
                                <span>Profil Saya</span>
                            </a>
                            <a href="{{ route('customer.orders') }}" class="flex items-center px-4 py-3 hover:bg-bg-light text-gray-700 hover:text-primary transition">
                                <i class="fas fa-box mr-3 w-5"></i> 
                                <span>Pesanan Saya</span>
                            </a>
                            <hr>
                            <form action="{{ route('customer.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left flex items-center px-4 py-3 text-red-600 hover:bg-red-50 transition">
                                    <i class="fas fa-sign-out-alt mr-3 w-5"></i> 
                                    <span>Keluar</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('customer.login') }}" class="flex flex-col items-center hover:text-primary transition group">
                        <i class="fas fa-user text-2xl text-gray-700 group-hover:text-primary"></i>
                        <span class="text-xs text-gray-600 group-hover:text-primary mt-1">Masuk</span>
                    </a>
                @endauth
            </div>

            {{-- Mobile Menu Button --}}
            <button id="mobile-menu-btn" class="md:hidden text-gray-700">
                <i class="fas fa-bars text-2xl"></i>
            </button>
        </div>

        {{-- Search Bar Mobile --}}
        <div class="md:hidden mt-3">
            <form action="{{ route('shop.index') }}" method="GET" class="flex">
                <input type="text" 
                       name="search" 
                       placeholder="Cari produk..."
                       class="flex-1 px-3 py-2 border-2 border-primary rounded-l-md focus:outline-none text-sm"
                       value="{{ request('search') }}">
                <button type="submit" class="bg-primary text-white px-4 rounded-r-md">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
    </div>
</nav>

{{-- Category Menu (Sticky) --}}
<div class="bg-white border-b shadow-sm sticky top-[64px] z-40 hidden md:block">
    <div class="container mx-auto px-4">
        <div class="flex items-center space-x-8 py-3 overflow-x-auto">
            <a href="{{ route('home') }}" class="text-gray-700 hover:text-primary transition whitespace-nowrap {{ request()->routeIs('home') ? 'text-primary font-semibold' : '' }}">
                <i class="fas fa-home mr-1"></i> Home
            </a>
            <a href="{{ route('shop.index') }}" class="text-gray-700 hover:text-primary transition whitespace-nowrap {{ request()->routeIs('shop.*') ? 'text-primary font-semibold' : '' }}">
                <i class="fas fa-fire mr-1"></i> Semua Produk
            </a>
            <a href="{{ route('makeup') }}" class="text-gray-700 hover:text-primary transition whitespace-nowrap">
                <i class="fas fa-palette mr-1"></i> Makeup
            </a>
            <a href="{{ route('skincare') }}" class="text-gray-700 hover:text-primary transition whitespace-nowrap">
                <i class="fas fa-spa mr-1"></i> Skincare
            </a>
            <a href="{{ route('lip-products') }}" class="text-gray-700 hover:text-primary transition whitespace-nowrap">
                <i class="fas fa-kiss-wink-heart mr-1"></i> Lip Products
            </a>
            <a href="{{ route('promo') }}" class="text-accent hover:text-primary transition whitespace-nowrap font-medium">
                <i class="fas fa-tags mr-1"></i> Promo
            </a>
        </div>
    </div>
</div>

{{-- Mobile Sidebar Menu --}}
<div id="mobile-menu" class="fixed inset-0 bg-black bg-opacity-50 z-[60] hidden">
    <div class="fixed left-0 top-0 bottom-0 w-80 bg-white shadow-2xl transform -translate-x-full transition-transform duration-300" id="mobile-menu-content">
        <div class="p-4 overflow-y-auto h-full">
            {{-- Close Button --}}
            <button id="close-menu-btn" class="absolute top-4 right-4 text-gray-600 hover:text-gray-900">
                <i class="fas fa-times text-2xl"></i>
            </button>

            {{-- User Section --}}
            @auth('customer')
                <div class="flex items-center space-x-3 mb-6 pb-6 border-b">
                    <div class="w-14 h-14 rounded-full overflow-hidden border-2 border-primary">
                        @if(Auth::guard('customer')->user()->foto)
                            <img src="{{ asset('storage/img-customer/' . Auth::guard('customer')->user()->foto) }}" 
                                 alt="{{ Auth::guard('customer')->user()->nama }}" 
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gradient-to-r from-primary to-accent flex items-center justify-center">
                                <i class="fas fa-user text-white text-xl"></i>
                            </div>
                        @endif
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800">{{ Auth::guard('customer')->user()->nama }}</p>
                        <p class="text-xs text-gray-500 truncate max-w-[180px]">{{ Auth::guard('customer')->user()->email }}</p>
                    </div>
                </div>
            @else
                <div class="mb-6 pb-6 border-b">
                    <a href="{{ route('customer.login') }}" class="block w-full bg-gradient-to-r from-primary to-accent text-white text-center py-3 rounded-lg font-medium hover:shadow-lg transition">
                        <i class="fas fa-sign-in-alt mr-2"></i> Masuk / Daftar
                    </a>
                </div>
            @endauth

            {{-- Menu Items --}}
            <div class="space-y-1">
                <a href="{{ route('home') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-bg-light hover:text-primary rounded-lg transition">
                    <i class="fas fa-home w-6"></i>
                    <span>Home</span>
                </a>
                <a href="{{ route('shop.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-bg-light hover:text-primary rounded-lg transition">
                    <i class="fas fa-shopping-bag w-6"></i>
                    <span>Semua Produk</span>
                </a>
                <a href="{{ route('cart.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-bg-light hover:text-primary rounded-lg transition">
                    <i class="fas fa-shopping-cart w-6"></i>
                    <span>Keranjang</span>
                    {{-- BADGE MOBILE SIDEBAR --}}
                    <span id="cart-badge-mobile-sidebar" class="ml-auto bg-accent text-white text-xs px-2 py-1 rounded-full font-bold" style="display: none;">0</span>
                </a>
                
                @auth('customer')
                    <a href="{{ route('customer.profile') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-bg-light hover:text-primary rounded-lg transition">
                        <i class="fas fa-user-circle w-6"></i>
                        <span>Profil Saya</span>
                    </a>
                    <a href="{{ route('customer.orders') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-bg-light hover:text-primary rounded-lg transition">
                        <i class="fas fa-box w-6"></i>
                        <span>Pesanan Saya</span>
                    </a>
                    <form action="{{ route('customer.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center px-4 py-3 text-red-600 hover:bg-red-50 rounded-lg transition">
                            <i class="fas fa-sign-out-alt w-6"></i>
                            <span>Keluar</span>
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </div>
</div>

{{-- Bottom Navigation (Mobile Only) --}}
<div class="fixed bottom-0 left-0 right-0 bg-white border-t shadow-lg md:hidden z-40">
    <div class="flex justify-around items-center py-2">
        <a href="{{ route('home') }}" class="flex flex-col items-center py-2 {{ request()->routeIs('home') ? 'text-primary' : 'text-gray-600' }}">
            <i class="fas fa-home text-xl"></i>
            <span class="text-xs mt-1">Home</span>
        </a>
        <a href="{{ route('shop.index') }}" class="flex flex-col items-center py-2 {{ request()->routeIs('shop.*') ? 'text-primary' : 'text-gray-600' }}">
            <i class="fas fa-th-large text-xl"></i>
            <span class="text-xs mt-1">Kategori</span>
        </a>
        <a href="{{ route('cart.index') }}" class="flex flex-col items-center py-2 relative {{ request()->routeIs('cart.*') ? 'text-primary' : 'text-gray-600' }}">
            <i class="fas fa-shopping-cart text-xl"></i>
            {{-- BADGE BOTTOM NAV --}}
            <span id="cart-badge-bottom" class="absolute top-0 right-2 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center font-bold" style="display: none;">0</span>
            <span class="text-xs mt-1">Keranjang</span>
        </a>
        @auth('customer')
            <a href="{{ route('customer.profile') }}" class="flex flex-col items-center py-2 {{ request()->routeIs('customer.profile') ? 'text-primary' : 'text-gray-600' }}">
                <i class="fas fa-user text-xl"></i>
                <span class="text-xs mt-1">Saya</span>
            </a>
        @else
            <a href="{{ route('customer.login') }}" class="flex flex-col items-center py-2 text-gray-600">
                <i class="fas fa-user text-xl"></i>
                <span class="text-xs mt-1">Masuk</span>
            </a>
        @endauth
    </div>
</div>

<script>
// Mobile Menu Toggle
const mobileMenuBtn = document.getElementById('mobile-menu-btn');
const mobileMenu = document.getElementById('mobile-menu');
const mobileMenuContent = document.getElementById('mobile-menu-content');
const closeMenuBtn = document.getElementById('close-menu-btn');

mobileMenuBtn?.addEventListener('click', () => {
    mobileMenu.classList.remove('hidden');
    setTimeout(() => {
        mobileMenuContent.classList.remove('-translate-x-full');
    }, 10);
});

closeMenuBtn?.addEventListener('click', () => {
    mobileMenuContent.classList.add('-translate-x-full');
    setTimeout(() => {
        mobileMenu.classList.add('hidden');
    }, 300);
});

mobileMenu?.addEventListener('click', (e) => {
    if (e.target === mobileMenu) {
        mobileMenuContent.classList.add('-translate-x-full');
        setTimeout(() => {
            mobileMenu.classList.add('hidden');
        }, 300);
    }
});
</script>