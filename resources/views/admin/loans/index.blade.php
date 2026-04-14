@extends('layouts.app')

@section('title', 'Data Peminjaman')

@section('content')

@if(session('success'))
    <div class="alert alert-dismissible fade show d-flex align-items-center gap-2" 
         role="alert"
         style="background:#EAF3DE; border:0.5px solid #C0DD97; color:#3B6D11; border-radius:8px; font-size:13px;">
        <i class="fas fa-check-circle"></i>
        <span>{{ session('success') }}</span>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" style="font-size:11px;"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-dismissible fade show d-flex align-items-center gap-2" 
         role="alert"
         style="background:#FCEBEB; border:0.5px solid #F09595; color:#A32D2D; border-radius:8px; font-size:13px;">
        <i class="fas fa-circle-exclamation"></i>
        <span>{{ session('error') }}</span>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" style="font-size:11px;"></button>
    </div>
@endif

{{-- Page Header --}}
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h5 class="mb-0 fw-500" style="font-size:18px;">Data Peminjaman</h5>
        <p class="mb-0 text-muted" style="font-size:13px;">Kelola seluruh transaksi peminjaman buku</p>
    </div>
</div>

<div class="card" style="border:0.5px solid #e0e0e0; border-radius:12px;">

    {{-- Search Bar --}}
    <div class="card-header bg-white border-0" style="border-bottom:0.5px solid #e0e0e0 !important; border-radius:12px 12px 0 0; padding:1rem 1.25rem;">
        <form method="GET" class="d-flex gap-2">
            <input type="text" name="search"
                   class="form-control"
                   style="font-size:13px; border:0.5px solid #ccc; border-radius:8px;"
                   placeholder="Cari nama user atau judul buku..."
                   value="{{ request('search') }}">
            <button type="submit"
                    class="btn btn-outline-secondary d-flex align-items-center gap-1"
                    style="font-size:13px; border-radius:8px; white-space:nowrap;">
                <i class="fas fa-search" style="font-size:11px;"></i> Cari
            </button>
            @if(request('search'))
                <a href="{{ route('admin.loans.index') }}"
                   class="btn d-flex align-items-center gap-1"
                   style="font-size:13px; border-radius:8px; background:#FCEBEB; color:#A32D2D; border:0.5px solid #F09595; white-space:nowrap;">
                    <i class="fas fa-times" style="font-size:11px;"></i> Reset
                </a>
            @endif
        </form>
    </div>

    {{-- Table --}}
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0" style="min-width:680px;">
                <thead>
                    <tr style="background:#f8f8f6;">
                        <th style="width:120px; font-size:11px; font-weight:500; text-transform:uppercase; letter-spacing:.06em; color:#888; padding:10px 14px; border-bottom:0.5px solid #e0e0e0;">Kode</th>
                        <th style="font-size:11px; font-weight:500; text-transform:uppercase; letter-spacing:.06em; color:#888; padding:10px 14px; border-bottom:0.5px solid #e0e0e0;">User</th>
                        <th style="font-size:11px; font-weight:500; text-transform:uppercase; letter-spacing:.06em; color:#888; padding:10px 14px; border-bottom:0.5px solid #e0e0e0;">Buku</th>
                        <th style="font-size:11px; font-weight:500; text-transform:uppercase; letter-spacing:.06em; color:#888; padding:10px 14px; border-bottom:0.5px solid #e0e0e0;">Tgl Pinjam</th>
                        <th style="font-size:11px; font-weight:500; text-transform:uppercase; letter-spacing:.06em; color:#888; padding:10px 14px; border-bottom:0.5px solid #e0e0e0;">Tgl Kembali</th>
                        <th style="font-size:11px; font-weight:500; text-transform:uppercase; letter-spacing:.06em; color:#888; padding:10px 14px; border-bottom:0.5px solid #e0e0e0;">Status</th>
                        <th style="width:150px; font-size:11px; font-weight:500; text-transform:uppercase; letter-spacing:.06em; color:#888; padding:10px 14px; border-bottom:0.5px solid #e0e0e0;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($loans as $loan)
                        <tr>
                            {{-- Kode --}}
                            <td style="padding:12px 14px; font-size:13px; border-bottom:0.5px solid #f0f0f0; vertical-align:middle;">
                                <span style="font-size:11px; font-weight:500; padding:3px 8px; border-radius:6px; background:#E6F1FB; color:#0C447C; font-family:monospace;">
                                    {{ $loan->kode_peminjaman }}
                                </span>
                            </td>

                            {{-- User --}}
                            <td style="padding:12px 14px; font-size:13px; border-bottom:0.5px solid #f0f0f0; vertical-align:middle;">
                                <div style="font-size:13px; font-weight:500; margin:0;">{{ $loan->user->name ?? '-' }}</div>
                                <div style="font-size:11px; color:#888; margin:0;">{{ $loan->user->email ?? '-' }}</div>
                            </td>

                            {{-- Buku --}}
                            <td style="padding:12px 14px; font-size:13px; border-bottom:0.5px solid #f0f0f0; vertical-align:middle;">
                                <div style="font-size:13px; font-weight:500; margin:0;">
                                    {{ Illuminate\Support\Str::limit($loan->book->title ?? '-', 40) }}
                                </div>
                                <div style="font-size:11px; color:#888;">Stok: {{ $loan->book->stock ?? 0 }}</div>
                            </td>

                            {{-- Tgl Pinjam --}}
                            <td style="padding:12px 14px; font-size:13px; border-bottom:0.5px solid #f0f0f0; vertical-align:middle;">
                                {{ $loan->tgl_pinjam ? \Carbon\Carbon::parse($loan->tgl_pinjam)->format('d/m/Y') : '-' }}
                            </td>

                            {{-- Tgl Kembali --}}
                            <td style="padding:12px 14px; border-bottom:0.5px solid #f0f0f0; vertical-align:middle;">
                                @if($loan->tgl_kembali)
                                    <span style="font-size:12px; padding:3px 8px; border-radius:6px;
                                        {{ $loan->isOverdue() ? 'background:#FCEBEB; color:#A32D2D;' : 'background:#E1F5EE; color:#0F6E56;' }}">
                                        {{ \Carbon\Carbon::parse($loan->tgl_kembali)->format('d/m/Y') }}
                                    </span>
                                @else
                                    <span style="color:#aaa;">-</span>
                                @endif
                            </td>

                            {{-- Status --}}
                            <td style="padding:12px 14px; border-bottom:0.5px solid #f0f0f0; vertical-align:middle;">
                                @switch($loan->status)
                                    @case('pending')
                                        <span style="font-size:11px; font-weight:500; padding:3px 10px; border-radius:20px; background:#FAEEDA; color:#854F0B;">Pending</span>
                                        @break
                                    @case('dipinjam')
                                        <span style="font-size:11px; font-weight:500; padding:3px 10px; border-radius:20px; background:#EAF3DE; color:#3B6D11;">Dipinjam</span>
                                        @break
                                    @case('terlambat')
                                        <span style="font-size:11px; font-weight:500; padding:3px 10px; border-radius:20px; background:#FCEBEB; color:#A32D2D;">Terlambat</span>
                                        @break
                                    @case('dikembalikan')
                                        <span style="font-size:11px; font-weight:500; padding:3px 10px; border-radius:20px; background:#F1EFE8; color:#5F5E5A;">Dikembalikan</span>
                                        @break
                                    @default
                                        <span style="font-size:11px; font-weight:500; padding:3px 10px; border-radius:20px; background:#F1EFE8; color:#5F5E5A;">{{ ucfirst($loan->status) }}</span>
                                @endswitch
                            </td>

                            {{-- Aksi --}}
                            <td style="padding:12px 14px; border-bottom:0.5px solid #f0f0f0; vertical-align:middle;">
                                <div class="d-flex gap-1">
                                    {{-- Detail --}}
                                    <a href="{{ route('admin.loans.show', $loan) }}"
                                       class="btn btn-sm d-flex align-items-center"
                                       style="border:0.5px solid #ccc; border-radius:6px; padding:4px 8px; font-size:12px; color:#555; background:#fff;"
                                       title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    {{-- Konfirmasi --}}
                                    @if($loan->status === 'pending')
                                        <form action="{{ route('admin.loans.confirm', $loan) }}" method="POST" class="d-inline">
                                            @csrf @method('PATCH')
                                            <button type="submit"
                                                    onclick="return confirm('Konfirmasi peminjaman ini?')"
                                                    title="Konfirmasi"
                                                    style="border:0.5px solid #C0DD97; border-radius:6px; padding:4px 8px; font-size:12px; background:#EAF3DE; color:#3B6D11; cursor:pointer;">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Kembalikan --}}
                                    @if(in_array($loan->status, ['dipinjam', 'terlambat']))
                                        <form action="{{ route('admin.loans.return', $loan) }}" method="POST" class="d-inline">
                                            @csrf @method('PATCH')
                                            <button type="submit"
                                                    onclick="return confirm('Proses pengembalian buku ini?')"
                                                    title="Kembalikan"
                                                    style="border:0.5px solid #B5D4F4; border-radius:6px; padding:4px 8px; font-size:12px; background:#E6F1FB; color:#185FA5; cursor:pointer;">
                                                <i class="fas fa-undo"></i>
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Hapus --}}
                                    @if(!in_array($loan->status, ['dipinjam', 'terlambat', 'dikembalikan']))
                                        <form action="{{ route('admin.loans.destroy', $loan) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                    onclick="return confirm('Yakin ingin menghapus data ini?')"
                                                    title="Hapus"
                                                    style="border:0.5px solid #F09595; border-radius:6px; padding:4px 8px; font-size:12px; background:#FCEBEB; color:#A32D2D; cursor:pointer;">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5" style="color:#aaa;">
                                <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                <span style="font-size:13px;">Belum ada data peminjaman</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Footer: Pagination + Info --}}
    <div class="card-footer bg-white border-0" style="border-top:0.5px solid #e0e0e0 !important; border-radius:0 0 12px 12px; padding:.75rem 1.25rem;">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <p class="mb-0" style="font-size:12px; color:#888;">
                Menampilkan {{ $loans->firstItem() ?? 0 }} &ndash; {{ $loans->lastItem() ?? 0 }}
                dari {{ $loans->total() }} data
            </p>
            <div>
                {{ $loans->appends(request()->query())->links() }}
            </div>
        </div>
    </div>

</div>
@endsection