<footer class="bg-white border-t mt-20 pb-20 md:pb-0">
    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-2 md:grid-cols-5 gap-8">
            
            {{-- Customer Care --}}
            <div>
                <h4 class="text-sm font-bold text-gray-800 mb-4 uppercase">Layanan Pelanggan</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-600 hover:text-primary transition text-sm">Pusat Bantuan</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-primary transition text-sm">Cara Pembelian</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-primary transition text-sm">Cara Pengembalian</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-primary transition text-sm">Lacak Pesanan</a></li>
                </ul>
            </div>

            {{-- About Emina --}}
            <div>
                <h4 class="text-sm font-bold text-gray-800 mb-4 uppercase">Tentang Kami</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-600 hover:text-primary transition text-sm">Tentang Emina Beauty</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-primary transition text-sm">Kebijakan Privasi</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-primary transition text-sm">Syarat & Ketentuan</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-primary transition text-sm">Blog</a></li>
                </ul>
            </div>

            {{-- Payment --}}
            <div>
                <h4 class="text-sm font-bold text-gray-800 mb-4 uppercase">Pembayaran</h4>
                <div class="flex flex-wrap gap-2">
                    <div class="w-12 h-8 bg-gray-100 rounded border flex items-center justify-center">
                        <i class="fab fa-cc-visa text-blue-600 text-lg"></i>
                    </div>
                    <div class="w-12 h-8 bg-gray-100 rounded border flex items-center justify-center">
                        <i class="fab fa-cc-mastercard text-red-600 text-lg"></i>
                    </div>
                    <div class="w-12 h-8 bg-gray-100 rounded border flex items-center justify-center text-xs font-bold text-blue-600">
                        BCA
                    </div>
                    <div class="w-12 h-8 bg-gray-100 rounded border flex items-center justify-center text-xs font-bold text-red-600">
                        BNI
                    </div>
                    <div class="w-12 h-8 bg-gray-100 rounded border flex items-center justify-center text-xs font-bold text-blue-500">
                        BRI
                    </div>
                    <div class="w-12 h-8 bg-gray-100 rounded border flex items-center justify-center text-xs font-bold text-orange-600">
                        OVO
                    </div>
                    <div class="w-12 h-8 bg-gray-100 rounded border flex items-center justify-center text-xs font-bold text-blue-400">
                        DANA
                    </div>
                    <div class="w-12 h-8 bg-gray-100 rounded border flex items-center justify-center text-xs font-bold text-red-500">
                        GOPAY
                    </div>
                </div>
            </div>

            {{-- Shipping --}}
            <div>
                <h4 class="text-sm font-bold text-gray-800 mb-4 uppercase">Pengiriman</h4>
                <div class="flex flex-wrap gap-2">
                    <div class="w-16 h-8 bg-gray-100 rounded border flex items-center justify-center text-xs font-bold text-green-600">
                        JNE
                    </div>
                    <div class="w-16 h-8 bg-gray-100 rounded border flex items-center justify-center text-xs font-bold text-red-600">
                        J&T
                    </div>
                    <div class="w-16 h-8 bg-gray-100 rounded border flex items-center justify-center text-xs font-bold text-blue-600">
                        SiCepat
                    </div>
                    <div class="w-16 h-8 bg-gray-100 rounded border flex items-center justify-center text-xs font-bold text-purple-600">
                        AnterAja
                    </div>
                    <div class="w-16 h-8 bg-gray-100 rounded border flex items-center justify-center text-xs font-bold text-green-700">
                        Ninja
                    </div>
                </div>
            </div>

            {{-- Follow Us --}}
            <div>
                <h4 class="text-sm font-bold text-gray-800 mb-4 uppercase">Ikuti Kami</h4>
                <div class="space-y-3">
                    <a href="https://www.instagram.com/emina/" class="flex items-center text-gray-600 hover:text-primary transition text-sm group">
                        <i class="fab fa-instagram text-lg mr-3 group-hover:scale-110 transition-transform"></i>
                        <span>Instagram</span>
                    </a>
                    <a href="https://www.facebook.com/eminacosmetics/?locale=id_ID" class="flex items-center text-gray-600 hover:text-primary transition text-sm group">
                        <i class="fab fa-facebook text-lg mr-3 group-hover:scale-110 transition-transform"></i>
                        <span>Facebook</span>
                    </a>
                    <a href="https://www.tiktok.com/@eminacosmeticsmy?lang=en" class="flex items-center text-gray-600 hover:text-primary transition text-sm group">
                        <i class="fab fa-tiktok text-lg mr-3 group-hover:scale-110 transition-transform"></i>
                        <span>TikTok</span>
                    </a>
                    <a href="https://www.youtube.com/@EminaCosmetics" class="flex items-center text-gray-600 hover:text-primary transition text-sm group">
                        <i class="fab fa-youtube text-lg mr-3 group-hover:scale-110 transition-transform"></i>
                        <span>YouTube</span>
                    </a>
                </div>
            </div>
        </div>

        {{-- Divider --}}
        <div class="border-t my-8"></div>

        {{-- Bottom Section --}}
        <div class="grid md:grid-cols-2 gap-8">
            {{-- Company Info --}}
            <div>
                <div class="flex items-center space-x-3 mb-3">
                    <img src="{{ asset('image/logo_emina.png') }}" alt="Emina Beauty" class="w-10 h-10 object-contain">
                    <div>
                        <h3 class="text-lg font-bold bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent">
                            Emina Beauty
                        </h3>
                        <p class="text-xs text-gray-500">Stay Cute, Stay Confident</p>
                    </div>
                </div>
                <p class="text-gray-600 text-sm mb-3">
                    Emina Beauty adalah brand kecantikan terpercaya untuk generasi muda Indonesia dengan produk berkualitas tinggi dan harga terjangkau.
                </p>
                <div class="flex items-center space-x-2 text-sm text-gray-600">
                    <i class="fas fa-phone text-primary"></i>
                    <span>+62 821-1234-5678</span>
                </div>
                <div class="flex items-center space-x-2 text-sm text-gray-600 mt-1">
                    <i class="fas fa-envelope text-primary"></i>
                    <span>hello@eminabeauty.com</span>
                </div>
            </div>

            {{-- Newsletter --}}
            <div>
                <h4 class="text-sm font-bold text-gray-800 mb-3 uppercase">Berlangganan Newsletter</h4>
                <p class="text-gray-600 text-sm mb-3">
                    Dapatkan promo dan info produk terbaru langsung ke email kamu!
                </p>
                <form class="flex">
                    <input type="email" 
                           placeholder="Masukkan email kamu" 
                           class="flex-1 px-4 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:border-primary text-sm">
                    <button type="submit" class="bg-gradient-to-r from-primary to-accent text-white px-6 py-2 rounded-r-lg hover:shadow-lg transition font-medium">
                        Subscribe
                    </button>
                </form>
            </div>
        </div>

        {{-- Copyright --}}
        <div class="border-t mt-8 pt-6 text-center">
            <p class="text-gray-500 text-sm">
                © {{ date('Y') }} Emina Beauty. All rights reserved. Made with <i class="fas fa-heart text-red-500"></i> in Indonesia
            </p>
        </div>
    </div>
</footer>