@extends('backend.v_layouts.app')

@section('title', 'Review Customer')

@section('content')
    <style>
        /* Pink Theme Styling */
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
        
        .content-header i {
            color: white;
            margin-right: 10px;
        }
        
        .card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 2px 15px rgba(245, 139, 149, 0.1);
            overflow: hidden;
        }
        
        .card-body {
            padding: 25px;
        }
        
        .table thead th {
            background: linear-gradient(135deg, #f58b95 0%, #ff6b9d 100%);
            color: white;
            border: none;
            font-weight: 600;
            padding: 15px;
            text-align: center;
            vertical-align: middle;
            font-size: 14px;
        }
        
        .table tbody td {
            padding: 20px 15px;
            vertical-align: middle;
            border-bottom: 1px solid #ffe8ec;
        }
        
        .table tbody tr:hover {
            background: #fffafc;
        }
        
        /* Customer Info */
        .customer-info {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }
        
        .customer-name {
            font-weight: 700;
            color: #d94865;
            font-size: 14px;
        }
        
        .customer-contact {
            font-size: 12px;
            color: #999;
        }
        
        /* Product Badge */
        .product-badge {
            display: inline-block;
            padding: 6px 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            color: white;
            font-weight: 600;
            font-size: 12px;
        }
        
        /* Order Badge */
        .order-badge {
            display: inline-block;
            padding: 6px 12px;
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            border-radius: 15px;
            color: white;
            font-weight: 600;
            font-size: 11px;
        }
        
        /* Action Buttons */
        .btn-detail {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            padding: 8px 15px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;
            margin: 2px;
        }
        
        .btn-detail:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            color: white;
        }
        
        .btn-reply {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            border: none;
            color: white;
            padding: 8px 15px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;
            margin: 2px;
        }
        
        .btn-reply:hover {
            background: linear-gradient(135deg, #38f9d7 0%, #43e97b 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(67, 233, 123, 0.4);
            color: white;
        }
        
        .btn-hapus {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
            border: none;
            color: white;
            padding: 8px 15px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;
            margin: 2px;
        }
        
        .btn-hapus:hover {
            background: linear-gradient(135deg, #ee5a6f 0%, #ff6b6b 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(238, 90, 111, 0.4);
            color: white;
        }
        
        .no-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #f58b95 0%, #ff6b9d 100%);
            color: white;
            border-radius: 10px;
            font-weight: 700;
            font-size: 15px;
        }
        
        /* DataTable */
        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            border: 2px solid #f58b95;
            border-radius: 8px;
            padding: 5px 10px;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: linear-gradient(135deg, #f58b95 0%, #ff6b9d 100%) !important;
            border: none !important;
            color: white !important;
            border-radius: 8px;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state i {
            font-size: 80px;
            color: #f58b95;
            margin-bottom: 20px;
        }

        .empty-state h3 {
            color: #d94865;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .empty-state p {
            color: #999;
            font-size: 15px;
        }

        /* Review Text */
        .review-text {
            max-width: 300px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Reply Badge */
        .reply-badge {
            display: inline-block;
            padding: 4px 10px;
            background: #e8f5e9;
            color: #2e7d32;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
        }

        .no-reply-badge {
            display: inline-block;
            padding: 4px 10px;
            background: #fff3e0;
            color: #e65100;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
        }
    </style>

<div class="container-fluid">

    <div class="content-header">
        <h5><i class="fas fa-star"></i> Review Customer</h5>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="dataTable">
                    <thead>
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Customer</th>
                            <th>Produk</th>
                            <th style="width: 120px;">Order</th>
                            <th style="width: 120px;">Rating</th>
                            <th style="width: 250px;">Ulasan</th>
                            <th style="width: 150px;">Status Balasan</th>
                            <th style="width: 200px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reviews as $index => $review)
                            <tr>
                                <td class="text-center">
                                    <div class="no-badge">{{ $reviews->firstItem() + $index }}</div>
                                </td>

                                <td>
                                    <div class="customer-info">
                                        <span class="customer-name">{{ $review->customer->nama ?? '-' }}</span>
                                        <span class="customer-contact">{{ $review->customer->email ?? '-' }}</span>
                                        <span class="customer-contact">
                                            <i class="fas fa-phone fa-xs"></i> {{ $review->customer->no_hp ?? '-' }}
                                        </span>
                                    </div>
                                </td>

                                <td>
                                    <span class="product-badge">
                                        {{ Str::limit($review->produk->nama_produk ?? '-', 30) }}
                                    </span>
                                </td>

                                <td class="text-center">
                                    <span class="order-badge">
                                        {{ $review->transaksi->kode_transaksi ?? '-' }}
                                    </span>
                                </td>

                                <td class="text-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fa fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                                    @endfor
                                    <br>
                                    <small class="text-muted">{{ $review->rating }}/5</small>
                                </td>

                                <td>
                                    <div class="review-text" title="{{ $review->review }}">
                                        {{ $review->review }}
                                    </div>
                                    <small class="text-muted">
                                        <i class="far fa-clock fa-xs"></i> 
                                        {{ $review->created_at->diffForHumans() }}
                                    </small>
                                </td>

                                <td class="text-center">
                                    @if($review->admin_reply)
                                        <span class="reply-badge">
                                            <i class="fas fa-check-circle"></i> Sudah Dibalas
                                        </span>
                                        <br>
                                        <small class="text-muted">
                                            {{ $review->replied_at ? $review->replied_at->diffForHumans() : '' }}
                                        </small>
                                    @else
                                        <span class="no-reply-badge">
                                            <i class="fas fa-exclamation-circle"></i> Belum Dibalas
                                        </span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    <a href="{{ route('backend.reviews.show', $review->id) }}" 
                                       class="btn btn-detail btn-sm" 
                                       title="Lihat Detail">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                    
                                    <button class="btn btn-reply btn-sm"
                                        data-toggle="modal"
                                        data-target="#replyModal{{ $review->id }}"
                                        title="Balas Review">
                                        <i class="fas fa-reply"></i> 
                                        {{ $review->admin_reply ? 'Edit Balasan' : 'Balas' }}
                                    </button>

                                    <form action="{{ route('backend.reviews.destroy', $review->id) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus review ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-hapus btn-sm" title="Hapus Review">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <!-- MODAL BALAS -->
                            <div class="modal fade" id="replyModal{{ $review->id }}" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-lg" role="document">
                                    <form method="POST" action="{{ route('backend.reviews.reply', $review->id) }}">
                                        @csrf
                                        <div class="modal-content" style="border-radius: 15px;">
                                            <div class="modal-header" style="background: linear-gradient(135deg, #f58b95 0%, #ff6b9d 100%); color: white; border-radius: 15px 15px 0 0;">
                                                <h5 class="modal-title">
                                                    <i class="fas fa-reply mr-2"></i> Balas Review Customer
                                                </h5>
                                                <button type="button" class="close text-white" data-dismiss="modal">
                                                    <span>&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Review Info -->
                                                <div class="mb-4 p-3" style="background: #f8f9fa; border-radius: 10px;">
                                                    <h6 class="font-weight-bold mb-2">
                                                        <i class="fas fa-user text-primary"></i> 
                                                        {{ $review->customer->nama ?? '-' }}
                                                    </h6>
                                                    <div class="mb-2">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <i class="fa fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                                                        @endfor
                                                        <span class="ml-2 text-muted">{{ $review->rating }}/5</span>
                                                    </div>
                                                    <p class="mb-1"><strong>Produk:</strong> {{ $review->produk->nama_produk ?? '-' }}</p>
                                                    <p class="mb-1"><strong>Ulasan:</strong></p>
                                                    <p class="text-muted mb-0" style="white-space: pre-wrap;">{{ $review->review }}</p>
                                                </div>

                                                <!-- Reply Form -->
                                                <div class="form-group">
                                                    <label for="admin_reply" class="font-weight-bold">
                                                        <i class="fas fa-comment-dots text-success"></i> Balasan Admin
                                                    </label>
                                                    <textarea name="admin_reply"
                                                        id="admin_reply"
                                                        class="form-control"
                                                        rows="5"
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

                        @empty
                            <tr>
                                <td colspan="8">
                                    <div class="empty-state">
                                        <i class="fas fa-star-half-alt"></i>
                                        <h3>Belum Ada Review</h3>
                                        <p>Customer belum memberikan review untuk produk yang dibeli</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($reviews->hasPages())
                <div class="mt-4">
                    {{ $reviews->links() }}
                </div>
            @endif
        </div>
    </div>

</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            },
            "pageLength": 10,
            "ordering": true,
            "info": true,
            "paging": false,
            "searching": true
        });
    });
</script>
@endpush

@endsection