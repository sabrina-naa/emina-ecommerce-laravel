@extends('backend.v_layouts.app')
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
        
        .btn-tambah {
            background: linear-gradient(135deg, #f58b95 0%, #ff6b9d 100%);
            border: none;
            color: white;
            padding: 12px 25px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(245, 139, 149, 0.3);
        }
        
        .btn-tambah:hover {
            background: linear-gradient(135deg, #ff6b9d 0%, #d94865 100%);
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(245, 139, 149, 0.5);
            color: white;
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
        
        .table {
            margin: 0;
        }
        
        .table thead th {
            background: linear-gradient(135deg, #f58b95 0%, #ff6b9d 100%);
            color: white;
            border: none;
            font-weight: 600;
            padding: 15px;
            text-align: center;
            vertical-align: middle;
        }
        
        .table tbody td {
            padding: 15px;
            vertical-align: middle;
            border-bottom: 1px solid #fff0f2;
        }
        
        .table tbody tr {
            transition: all 0.3s ease;
        }
        
        .table tbody tr:hover {
            background: #fff0f2;
            transform: scale(1.01);
        }
        
        /* User Photo Styling */
        .user-photo-container {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .user-photo {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #f58b95;
            box-shadow: 0 3px 10px rgba(245, 139, 149, 0.3);
            transition: all 0.3s ease;
        }
        
        .user-photo:hover {
            transform: scale(1.2);
            border-color: #ff6b9d;
            box-shadow: 0 5px 15px rgba(245, 139, 149, 0.5);
        }
        
        .user-photo-default {
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
            box-shadow: 0 3px 10px rgba(245, 139, 149, 0.3);
            transition: all 0.3s ease;
        }
        
        .user-photo-default:hover {
            transform: scale(1.2);
            box-shadow: 0 5px 15px rgba(245, 139, 149, 0.5);
        }
        
        /* User Info Badge */
        .user-info-badge {
            display: inline-flex;
            flex-direction: column;
            gap: 3px;
        }
        
        .user-name {
            font-weight: 700;
            color: #d94865;
            font-size: 15px;
        }
        
        .user-email {
            font-size: 13px;
            color: #999;
        }
        
        /* Role & Status Badges */
        .badge-super-admin {
            background: linear-gradient(135deg, #f58b95 0%, #ff6b9d 100%);
            color: white;
            padding: 6px 15px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 12px;
        }
        
        .badge-admin {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
            padding: 6px 15px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 12px;
        }
        
        .badge-aktif {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            color: white;
            padding: 6px 15px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 12px;
        }
        
        .badge-nonaktif {
            background: linear-gradient(135deg, #a8a8a8 0%, #7d7d7d 100%);
            color: white;
            padding: 6px 15px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 12px;
        }
        
        .btn-ubah {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            border: none;
            color: white;
            padding: 8px 18px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            font-size: 14px;
        }
        
        .btn-ubah:hover {
            background: linear-gradient(135deg, #00f2fe 0%, #4facfe 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(79, 172, 254, 0.4);
            color: white;
        }
        
        .btn-hapus {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            border: none;
            color: white;
            padding: 8px 18px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            font-size: 14px;
        }
        
        .btn-hapus:hover {
            background: linear-gradient(135deg, #f5576c 0%, #f093fb 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(245, 87, 108, 0.4);
            color: white;
        }
        
        .no-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 35px;
            height: 35px;
            background: linear-gradient(135deg, #f58b95 0%, #ff6b9d 100%);
            color: white;
            border-radius: 50%;
            font-weight: 700;
        }
        
        /* DataTable Customization */
        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            border: 2px solid #f58b95;
            border-radius: 8px;
            padding: 5px 10px;
        }
        
        .dataTables_wrapper .dataTables_length select:focus,
        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: #ff6b9d;
            outline: none;
            box-shadow: 0 0 10px rgba(245, 139, 149, 0.3);
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: linear-gradient(135deg, #f58b95 0%, #ff6b9d 100%) !important;
            border: none !important;
            color: white !important;
            border-radius: 8px;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #fff0f2 !important;
            border: none !important;
            color: #f58b95 !important;
        }
    </style>

    <!-- Content -->
    <div class="row">
        <div class="col-12">
            <!-- Header dengan gradient -->
            <div class="content-header">
                <h5><i class="mdi mdi-account-multiple"></i>{{ $judul }}</h5>
            </div>
            
            <!-- Tombol Tambah -->
            <a href="{{ route('backend.user.create') }}">
                <button type="button" class="btn btn-tambah mb-3">
                    <i class="fas fa-plus-circle"></i> Tambah User
                </button>
            </a>
            
            <!-- Card Table -->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="zero_config" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 80px;">No</th>
                                    <th style="width: 100px;">Foto</th>
                                    <th>Nama & Email</th>
                                    <th style="width: 150px;">Role</th>
                                    <th style="width: 130px;">Status</th>
                                    <th style="width: 250px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($index as $row)
                                    <tr>
                                        <td class="text-center">
                                            <span class="no-badge">{{ $loop->iteration }}</span>
                                        </td>
                                        <td>
                                            <div class="user-photo-container">
                                                @if ($row->foto)
                                                    <img src="{{ asset('storage/img-user/' . $row->foto) }}" 
                                                         alt="Foto {{ $row->nama }}" 
                                                         class="user-photo">
                                                @else
                                                    <div class="user-photo-default">
                                                        <i class="fas fa-user"></i>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="user-info-badge">
                                                <span class="user-name">{{ $row->nama }}</span>
                                                <span class="user-email">{{ $row->email }}</span>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @if ($row->role == 1)
                                                <span class="badge-super-admin">
                                                    <i class="mdi mdi-shield-crown"></i> Super Admin
                                                </span>
                                            @elseif($row->role == 0)
                                                <span class="badge-admin">
                                                    <i class="mdi mdi-shield-account"></i> Admin
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($row->status == 1)
                                                <span class="badge-aktif">
                                                    <i class="mdi mdi-check-circle"></i> Aktif
                                                </span>
                                            @elseif($row->status == 0)
                                                <span class="badge-nonaktif">
                                                    <i class="mdi mdi-close-circle"></i> NonAktif
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('backend.user.edit', $row->id) }}" title="Ubah Data">
                                                <button type="button" class="btn btn-ubah">
                                                    <i class="far fa-edit"></i> Ubah
                                                </button>
                                            </a>
                                            <form method="POST" action="{{ route('backend.user.destroy', $row->id) }}"
                                                style="display: inline-block;">
                                                @method('delete')
                                                @csrf
                                                <button type="submit" class="btn btn-hapus show_confirm"
                                                    data-konf-delete="{{ $row->nama }}" title='Hapus Data'>
                                                    <i class="fas fa-trash-alt"></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection