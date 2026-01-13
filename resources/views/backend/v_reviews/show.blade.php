@extends('backend.v_layouts.app')

@section('title', 'Detail Review')

@section('content')
<style>
    .content-header {
        background: linear-gradient(135deg, #f58b95 0%, #ff6b9d 100%);
        padding: 25px;
        border-radius: 15px;
        margin-bottom: 25px;
        box-shadow: 0 5px 20px rgba(245, 139, 149, 0.3);
    }
    
    .content-header h5 {
        color: white;
        font-weight: 700;
        margin: 0;
        font-size: 24px;
    }
    
    .card {
        border-radius: 15px;
        border: none;
        box-shadow: 0 2px 15px rgba(245, 139, 149, 0.1);
    }
    
    .info-label {
        font-weight: 600;
        color: #666;
        margin-bottom: 5px;
    }
    
    .info-value {
        font-size: 15px;
        color: #333;
        margin-bottom: 15px;
    }
    
    .review-box {
        background: #f8f9fa;
        border-left: 4px solid #f58b95;
        padding: 20px;
        border-radius: 10px;
        margin: 20px 0;
    }
    
    .reply-box {
        background: #e8f5e9;
        border-left: 4px solid #43e97b;
        padding: 20px;
        border-radius: 10px;
        margin: 20px 0;
    }
    
    .product-image {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .btn-back {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        padding: 10px 25px;
        border-radius: 8px;
        font-weight: 600;
    }
    
    .btn-back:hover {
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }
    
    .btn-reply {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        border: none;
        color: white;
        padding: 10px 25px;
        border-radius: 8px;
        font-weight: 600;
    }
    
    .btn-reply:hover {
        background: linear-gradient(135deg, #38f9d7 0%, #43e97b 100%);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(67, 233, 123, 0.4);
    }
    
    .btn-delete {
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
        border: none;
        color: white;
        padding: 10px 25px;
        border-radius: 8px;
        font-weight: 600;
    }
    
    .btn-delete:hover {
        background: linear-gradient(135deg, #ee5a6f 0%, #ff6b6b 100%);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(238, 90, 111, 0.4);
    }
    
    .badge-status {
        padding: 8px 15px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 12px;
    }
    
    .badge-replied {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        color: white;
    }
    
    .badge-pending {
        background: linear-gradient(135deg, #ffd89b 0%, #f093fb 100%);
        color: white;
    }
</style>

<div class="container-fluid">
    
    <div class="content-header">
        <h5><i class="fas fa-star mr-2"></i> Detail Review</h5>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <!-- Customer Info -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="font-weight-bold mb-4">
                        <i class="fas fa-user text-primary"></i> Informasi Customer
                    </h5>
                    
                    <div class="info-label">Nama</div>
                    <div class="info-value">{{ $review->customer->nama ?? '-' }}</div>
                    
                    <div class="info-label">Email</div>
                    <div class="info-value">{{ $review->customer->email ?? '-' }}</div>
                    
                    <div class="info-label">No. HP</div>
                    <div class="info-value">{{ $review->customer->no_hp ?? '-' }}</div>
                    
                    <div class="info-label">Status Review</div>
                    <div class="info-value">
                        @if($review->admin_reply)
                            <span class="badge-status badge-replied">
                                <i class="fas fa-check-circle"></i> Sudah Dibalas
                            </span>
                        @else
                            <span class="badge-status badge-pending">
                                <i class="fas fa-clock"></i> Belum Dibalas
                            </span>
                        @endif
                    </div>
                    
                    <div class="info-label">Tanggal Review</div>
                    <div class="info-value">
                        {{ $review->created_at->format('d F Y, H:i') }}
                        <br>
                        <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Review Detail -->
        <div class="col-md-8 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="font-weight-bold mb-4">
                        <i class="fas fa-comment-dots text-primary"></i> Detail Review
                    </h5>

                    <!-- Produk Info -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            @if($review->produk && $review->produk->foto)
                                <img src="{{ asset('storage/img-produk/' . $review->produk->foto) }}" 
                                     alt="{{ $review->produk->nama_produk }}" 
                                     class="product-image">
                            @else
                                <div class="product-image bg-gradient-to-br from-primary to-accent d-flex align-items-center justify-content-center">
                                    <i class="fas fa-image text-white fa-3x"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-9">
                            <div class="info-label">Nama Produk</div>
                            <div class="info-value">
                                <h5 class="font-weight-bold">{{ $review->produk->nama_produk ?? '-' }}</h5>
                            </div>
                            
                            <div class="info-label">Kode Transaksi</div>
                            <div class="info-value">
                                <span class="badge badge-info">
                                    {{ $review->transaksi->kode_transaksi ?? '-' }}
                                </span>
                            </div>
                            
                            <div class="info-label">Kategori</div>
                            <div class="info-value">
                                {{ $review->produk->kategori->nama_kategori ?? '-' }}
                            </div>
                        </div>
                    </div>

                    <!-- Rating -->
                    <div class="mb-4">
                        <div class="info-label">Rating</div>
                        <div class="info-value">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fa fa-star fa-2x {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                            @endfor
                            <span class="ml-2 font-weight-bold" style="font-size: 20px;">{{ $review->rating }}/5</span>
                        </div>
                    </div>

                    <!-- Ulasan Customer -->
                    <div class="review-box">
                        <div class="info-label mb-2">
                            <i class="fas fa-comment mr-2"></i> Ulasan Customer
                        </div>
                        <div style="font-size: 15px; line-height: 1.6; white-space: pre-wrap;">{{ $review->review }}</div>
                    </div>

                    <!-- Balasan Admin -->
                    @if($review->admin_reply)
                        <div class="reply-box">
                            <div class="info-label mb-2">
                                <i class="fas fa-reply mr-2"></i> Balasan Admin
                            </div>
                            <div style="font-size: 15px; line-height: 1.6; white-space: pre-wrap;">{{ $review->admin_reply }}</div>
                            <small class="text-muted d-block mt-2">
                                <i class="far fa-clock"></i> Dibalas pada: {{ $review->replied_at ? $review->replied_at->format('d F Y, H:i') : '-' }}
                            </small>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            Belum ada balasan dari admin
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="mt-4 d-flex justify-content-between">
                        <a href="{{ route('backend.reviews.index') }}" class="btn btn-back">
                            <i class="fas fa-arrow-left mr-2"></i> Kembali
                        </a>
                        
                        <div>
                            <button class="btn btn-reply" data-toggle="modal" data-target="#replyModal">
                                <i class="fas fa-reply mr-2"></i> 
                                {{ $review->admin_reply ? 'Edit Balasan' : 'Balas Review' }}
                            </button>
                            
                            <form action="{{ route('backend.reviews.destroy', $review->id) }}" 
                                  method="POST" 
                                  class="d-inline"
                                  onsubmit="return confirm('Yakin ingin menghapus review ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-delete">
                                    <i class="fas fa-trash mr-2"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Reply -->
<div class="modal fade" id="replyModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <form method="POST" action="{{ route('backend.reviews.reply', $review->id) }}">
            @csrf
            <div class="modal-content" style="border-radius: 15px;">
                <div class="modal-header" style="background: linear-gradient(135deg, #f58b95 0%, #ff6b9d 100%); color: white; border-radius: 15px 15px 0 0;">
                    <h5 class="modal-title">
                        <i class="fas fa-reply mr-2"></i> Balas Review
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="admin_reply" class="font-weight-bold">
                            <i class="fas fa-comment-dots text-success mr-2"></i> Balasan Admin
                        </label>
                        <textarea name="admin_reply"
                            id="admin_reply"
                            class="form-control"
                            rows="6"
                            placeholder="Tulis balasan Anda untuk customer..."
                            required
                            style="border-radius: 10px; border: 2px solid #f58b95;">{{ $review->admin_reply }}</textarea>
                        <small class="text-muted">
                            <i class="fas fa-info-circle"></i> 
                            Balasan akan ditampilkan di halaman produk dan bisa dilihat oleh customer.
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" style="border-radius: 8px;">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-success" style="border-radius: 8px; background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); border: none;">
                        <i class="fas fa-paper-plane"></i> Kirim Balasan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection