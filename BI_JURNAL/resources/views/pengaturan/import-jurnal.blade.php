@extends('layouts.app')

@section('title', 'Import Jurnal')

@section('content')
    <div class="header d-flex justify-content-center align-items-center mb-4 position-relative">
        <!-- Tombol Burger (mobile) -->
        <div class="d-md-none position-absolute start-0">
            <button class="btn btn-outline-dark" data-bs-toggle="offcanvas" data-bs-target="#sidebarMobile">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <!-- Judul di Tengah -->
        <h1 class="m-0 text-center">Impor Excel ke SQL</h1>
    </div>
    <div class="container mt-4">


        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow-sm p-4">
            <form action="{{ route('pengaturan.import-jurnal.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="file" class="form-label fw-semibold">Pilih File Excel (.xlsx atau .csv)</label>
                    <input type="file" name="file" id="file" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-add">
                    <i class="bi bi-upload"></i> Upload & Import
                </button>

                <a href="{{ asset('template/template_import_jurnal.xlsx') }}" class="btn btn-sm-1 ">
                    <i class="bi bi-download"></i> Download Template Excel
                </a>
            </form>
        </div>

        <p class="mt-4 text-muted small">
            Pastikan format kolom sesuai template agar data terimport dengan benar.
        </p>
    </div>
@endsection
