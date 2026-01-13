@extends('backend.v_layouts.app')
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
        
        .content-header i {
            color: white;
            margin-right: 10px;
        }
        
        .info-box {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            padding: 15px 20px;
            border-radius: 10px;
            color: white;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
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
        
        /* Customer Photo */
        .customer-photo {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #f58b95;
            box-shadow: 0 3px 10px rgba(245, 139, 149, 0.3);
        }
        
        .customer-photo-default {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #f58b95 0%, #ff6b9d 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            border: 3px solid #f58b95;
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
            font-size: 15px;
        }
        
        .customer-email {
            font-size: 13px;
            color: #999;
        }
        
        .customer-phone {
            font-size: 13px;
            color: #666;
        }
        
        /* Location Badge */
        .location-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 6px 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            color: white;
            font-weight: 600;
            font-size: 12px;
        }
        
        /* Status Badges */
        .badge-aktif {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            color: white;
            padding: 6px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 12px;
        }
        
        .badge-nonaktif {
            background: linear-gradient(135deg, #a8a8a8 0%, #7d7d7d 100%);
            color: white;
            padding: 6px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 12px;
        }
        
        /* Action Buttons */
        .btn-status {
            background: linear-gradient(135deg, #ffd89b 0%, #f093fb 100%);
            border: none;
            color: white;
            padding: 8px 15px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;
            margin: 2px;
            cursor: pointer;
        }
        
        .btn-status:hover {
            background: linear-gradient(135deg, #f093fb 0%, #ffd89b 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(240, 147, 251, 0.4);
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

        /* Modal */
        .modal-content {
            border-radius: 15px;
            border: none;
        }

        .modal-header {
            background: linear-gradient(135deg, #f58b95 0%, #ff6b9d 100%);
            color: white;
            border-radius: 15px 15px 0 0;
        }
    </style>

    <div class="row">
        <div class="col-12">
            <div class="content-header">
                <h5><i class="mdi mdi-account-group"></i>{{ $judul }}</h5>
                <div class="info-box">
                    <i class="fas fa-info-circle"></i>
                    <span>Data customer ini otomatis masuk saat customer melakukan registrasi di website</span>
                </div>
            </div>
            
            <div class="card">
                <div class="card-body">
                    @if($index->count() > 0)
                        <div class="table-responsive">
                            <table id="zero_config" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 60px;">No</th>
                                        <th style="width: 100px;">Foto</th>
                                        <th>Nama & Kontak</th>
                                        <th>Lokasi</th>
                                        <th style="width: 140px;">Tanggal Daftar</th>
                                        <th style="width: 120px;">Status</th>
                                        <th style="width: 200px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($index as $row)
                                        <tr>
                                            <td class="text-center">
                                                <span class="no-badge">{{ $loop->iteration }}</span>
                                            </td>
                                            <td class="text-center">
                                                @if ($row->foto)
                                                    <img src="{{ asset('storage/img-customer/' . $row->foto) }}" 
                                                         alt="Foto {{ $row->nama }}" 
                                                         class="customer-photo">
                                                @else
                                                    <div class="customer-photo-default">
                                                        <i class="fas fa-user"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="customer-info">
                                                    <span class="customer-name">{{ $row->nama }}</span>
                                                    <span class="customer-email">📧 {{ $row->email }}</span>
                                                    <span class="customer-phone">📱 {{ $row->no_hp }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                @if($row->kota || $row->provinsi)
                                                    <span class="location-badge">
                                                        <i class="mdi mdi-map-marker"></i>
                                                        {{ $row->kota ? $row->kota : '' }}{{ $row->kota && $row->provinsi ? ', ' : '' }}{{ $row->provinsi ? $row->provinsi : '' }}
                                                    </span>
                                                @else
                                                    <span style="color: #ccc; font-size: 13px;">-</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <small style="color: #666;">{{ $row->created_at->format('d M Y') }}</small>
                                            </td>
                                            <td class="text-center">
                                                @if ($row->status == 1)
                                                    <span class="badge-aktif">
                                                        <i class="mdi mdi-check-circle"></i> Aktif
                                                    </span>
                                                @else
                                                    <span class="badge-nonaktif">
                                                        <i class="mdi mdi-close-circle"></i> Banned
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-status" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#statusModal{{ $row->id }}"
                                                        title="Ubah Status">
                                                    <i class="mdi mdi-toggle-switch"></i> Status
                                                </button>
                                                
                                                <form method="POST" action="{{ route('backend.customer.destroy', $row->id) }}"
                                                    style="display: inline-block;">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="submit" class="btn btn-hapus show_confirm"
                                                        data-konf-delete="{{ $row->nama }}" title='Hapus'>
                                                        <i class="fas fa-trash-alt"></i> Hapus
                                                    </button>
                                                </form>

                                                <!-- Modal Ubah Status -->
                                                <div class="modal fade" id="statusModal{{ $row->id }}" tabindex="-1">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Ubah Status Customer</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <form action="{{ route('backend.customer.updateStatus', $row->id) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="modal-body">
                                                                    <p><strong>Nama:</strong> {{ $row->nama }}</p>
                                                                    <p><strong>Email:</strong> {{ $row->email }}</p>
                                                                    <hr>
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Status</label>
                                                                        <select name="status" class="form-select" required>
                                                                            <option value="1" {{ $row->status == 1 ? 'selected' : '' }}>Aktif</option>
                                                                            <option value="0" {{ $row->status == 0 ? 'selected' : '' }}>Banned</option>
                                                                        </select>
                                                                        <small class="text-muted">Status "Banned" akan memblokir customer dari login</small>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="mdi mdi-account-off"></i>
                            <h3>Belum Ada Customer Terdaftar</h3>
                            <p>Data customer akan muncul otomatis saat ada yang registrasi di website</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection