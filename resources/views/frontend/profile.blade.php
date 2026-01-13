@extends('frontend.layouts.app')

@section('title', 'Profile Saya - Emina Beauty')

@section('content')

{{-- Breadcrumb --}}
<div class="bg-gray-50 border-b">
    <div class="container mx-auto px-4 py-3">
        <nav class="flex items-center text-sm" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="text-gray-500 hover:text-primary transition">
                <i class="fas fa-home mr-1"></i>Home
            </a>
            <i class="fas fa-chevron-right mx-2 text-gray-400 text-xs"></i>
            <span class="text-gray-800 font-medium">Profile</span>
        </nav>
    </div>
</div>

{{-- Profile Section --}}
<section class="py-6 md:py-12 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4">

        <div class="flex flex-col lg:flex-row gap-6">
            
            {{-- Sidebar --}}
            <div class="lg:w-64 flex-shrink-0">
                <div class="bg-white rounded-lg shadow-sm p-4 sticky top-20">
                    {{-- User Info with Photo Upload --}}
                    <div class="text-center mb-4 pb-4 border-b">
                        <div class="relative inline-block">
                            <div class="w-20 h-20 bg-gradient-to-r from-primary to-accent rounded-full flex items-center justify-center mx-auto mb-2 overflow-hidden">
                                @if($customer->foto)
                                    <img src="{{ asset('storage/img-customer/' . $customer->foto) }}" 
                                         id="preview-foto"
                                         alt="{{ $customer->nama }}" 
                                         class="w-full h-full object-cover">
                                @else
                                    <i class="fas fa-user text-white text-3xl" id="preview-icon"></i>
                                @endif
                            </div>
                            {{-- Upload Button --}}
                            <label for="foto_upload" class="absolute bottom-0 right-0 bg-primary hover:bg-accent text-white rounded-full w-8 h-8 flex items-center justify-center cursor-pointer transition shadow-md">
                                <i class="fas fa-camera text-xs"></i>
                            </label>
                            {{-- Form Upload Foto Terpisah --}}
                            <form id="form_foto" action="{{ route('customer.profile.foto') }}" method="POST" enctype="multipart/form-data" class="hidden">
                                @csrf
                                @method('PUT')
                                <input type="file" id="foto_upload" name="foto" accept="image/*" onchange="previewAndUpload(event)">
                            </form>
                        </div>
                        <h3 class="font-bold text-gray-800 text-sm">{{ $customer->nama }}</h3>
                        <p class="text-xs text-gray-500 truncate">{{ $customer->email }}</p>
                    </div>

                    {{-- Stats --}}
                    <div class="grid grid-cols-3 gap-2 mb-4 text-center text-xs">
                        <div class="bg-blue-50 rounded p-2">
                            <div class="font-bold text-blue-600">{{ $totalTransaksi }}</div>
                            <div class="text-blue-800">Pesanan</div>
                        </div>
                        <div class="bg-yellow-50 rounded p-2">
                            <div class="font-bold text-yellow-600">{{ $transaksiPending }}</div>
                            <div class="text-yellow-800">Pending</div>
                        </div>
                        <div class="bg-green-50 rounded p-2">
                            <div class="font-bold text-green-600">{{ $transaksiSelesai }}</div>
                            <div class="text-green-800">Selesai</div>
                        </div>
                    </div>

                    {{-- Menu --}}
                    <nav class="space-y-1">
                        <a href="{{ route('customer.profile') }}" 
                           class="flex items-center px-3 py-2 bg-primary text-white rounded-md font-medium text-sm">
                            <i class="fas fa-user w-5 mr-2"></i> Profile
                        </a>
                        <a href="{{ route('customer.orders') }}" 
                           class="flex items-center px-3 py-2 text-gray-700 hover:bg-gray-50 rounded-md transition text-sm">
                            <i class="fas fa-receipt w-5 mr-2"></i> Pesanan Saya
                        </a>
                        <form action="{{ route('customer.logout') }}" method="POST">
                            @csrf
                            <button type="submit" 
                                    class="w-full flex items-center px-3 py-2 text-red-600 hover:bg-red-50 rounded-md transition text-sm">
                                <i class="fas fa-sign-out-alt w-5 mr-2"></i> Logout
                            </button>
                        </form>
                    </nav>
                </div>
            </div>

            {{-- Main Content --}}
            <div class="flex-1 space-y-6">
                
                {{-- Update Profile --}}
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-user-edit text-primary mr-2"></i> Edit Profile
                    </h3>

                    <form action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            {{-- Nama --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nama" value="{{ old('nama', $customer->nama) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-1 focus:ring-primary focus:border-primary @error('nama') border-red-500 @enderror"
                                       required>
                                @error('nama')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="email" value="{{ old('email', $customer->email) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-1 focus:ring-primary focus:border-primary @error('email') border-red-500 @enderror"
                                       required>
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- No HP --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    No. HP/WhatsApp <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="no_hp" value="{{ old('no_hp', $customer->no_hp) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-1 focus:ring-primary focus:border-primary @error('no_hp') border-red-500 @enderror"
                                       required>
                                @error('no_hp')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Kota --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kota</label>
                                <input type="text" name="kota" value="{{ old('kota', $customer->kota) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-1 focus:ring-primary focus:border-primary"
                                       placeholder="Contoh: Jakarta">
                            </div>

                            {{-- Provinsi --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Provinsi</label>
                                <input type="text" name="provinsi" value="{{ old('provinsi', $customer->provinsi) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-1 focus:ring-primary focus:border-primary"
                                       placeholder="Contoh: DKI Jakarta">
                            </div>

                            {{-- Kode Pos --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kode Pos</label>
                                <input type="text" name="kode_pos" value="{{ old('kode_pos', $customer->kode_pos) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-1 focus:ring-primary focus:border-primary"
                                       placeholder="12345">
                            </div>

                            {{-- Alamat --}}
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                                <textarea name="alamat" rows="3" 
                                          class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-1 focus:ring-primary focus:border-primary"
                                          placeholder="Jl. Contoh No. 123, RT/RW 001/002">{{ old('alamat', $customer->alamat) }}</textarea>
                            </div>
                        </div>

                        <div class="mt-4 flex justify-end">
                            <button type="submit" 
                                    class="bg-primary hover:bg-accent text-white px-6 py-2 rounded-md font-semibold transition">
                                <i class="fas fa-save mr-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Change Password --}}
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-lock text-primary mr-2"></i> Ubah Password
                    </h3>

                    <form action="{{ route('customer.profile.password') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="space-y-4 max-w-md">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Password Lama <span class="text-red-500">*</span>
                                </label>
                                <input type="password" name="current_password" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-1 focus:ring-primary focus:border-primary @error('current_password') border-red-500 @enderror"
                                       required>
                                @error('current_password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Password Baru <span class="text-red-500">*</span>
                                </label>
                                <input type="password" name="password" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-1 focus:ring-primary focus:border-primary @error('password') border-red-500 @enderror"
                                       required>
                                @error('password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Konfirmasi Password Baru <span class="text-red-500">*</span>
                                </label>
                                <input type="password" name="password_confirmation" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-1 focus:ring-primary focus:border-primary"
                                       required>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" 
                                    class="bg-primary hover:bg-accent text-white px-6 py-2 rounded-md font-semibold transition">
                                <i class="fas fa-key mr-2"></i> Ubah Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
// Preview foto sebelum upload
function previewAndUpload(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('preview-foto');
            const icon = document.getElementById('preview-icon');
            
            if (preview) {
                preview.src = e.target.result;
            } else if (icon) {
                // Replace icon with image
                icon.parentElement.innerHTML = `<img src="${e.target.result}" id="preview-foto" class="w-full h-full object-cover">`;
            }
        }
        reader.readAsDataURL(file);
        
        // Auto submit setelah preview
        setTimeout(() => {
            document.getElementById('form_foto').submit();
        }, 300);
    }
}

@if(session('success'))
    showNotification('success', '{{ session('success') }}');
@endif

@if(session('error'))
    showNotification('error', '{{ session('error') }}');
@endif

function showNotification(type, message) {
    const bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';
    const notification = document.createElement('div');
    notification.className = `fixed top-20 right-4 ${bgColor} text-white px-6 py-3 rounded-lg shadow-lg z-50`;
    notification.innerHTML = `
        <div class="flex items-center gap-2">
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
            <span>${message}</span>
        </div>
    `;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}
</script>
@endpush