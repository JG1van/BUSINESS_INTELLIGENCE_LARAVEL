@extends('layouts.app')
@section('title', 'Profil Akun')

@section('content')
    <div class="container p-4">
        <div class="header d-flex justify-content-center align-items-center mb-4 position-relative">
            <!-- Tombol Burger (mobile) -->
            <div class="d-md-none position-absolute start-0">
                <button class="btn btn-outline-dark" data-bs-toggle="offcanvas" data-bs-target="#sidebarMobile">
                    <i class="fas fa-bars"></i>
                </button>
            </div>

            <!-- Judul di Tengah -->
            <h1 class="m-0 text-center">Profil Akun</h1>
        </div>

        <div class="alas p-3 bg-light rounded shadow-sm">
            <!-- ✅ Perbaikan route dan method -->
            <form id="updateProfileForm" action="{{ route('pengaturan.profil.update') }}" method="POST">
                @csrf
                @method('PUT')

                <h5 class="mb-3">Informasi Akun</h5>

                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}" required />
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ Auth::user()->email }}" readonly />
                </div>

                <div class="mb-3">
                    <label class="form-label">Password Lama</label>
                    <input type="password" name="current_password" class="form-control" />
                </div>

                <div class="mb-3">
                    <label class="form-label">Password Baru</label>
                    <input type="password" name="new_password" class="form-control" />
                </div>

                <div class="mb-3">
                    <label class="form-label">Konfirmasi Password Baru</label>
                    <input type="password" name="new_password_confirmation" class="form-control" />
                </div>

                <button type="button" class="btn btn-add w-100 mt-3" id="btnConfirmSave">
                    <i class="fas fa-save me-2"></i> Simpan Semua Perubahan
                </button>
            </form>

            <!-- ✅ Route diperbaiki -->
            <form id="deactivateForm" action="{{ route('pengaturan.profil.deactivate') }}" method="POST">
                @csrf
            </form>

            <button type="button" class="btn btn-sm-1 w-100 mt-3" id="btnConfirmDeactivate">
                <i class="fas fa-user-slash me-2"></i> Nonaktifkan Akun
            </button>
        </div>
    </div>

    <!-- Modal Konfirmasi -->
    <div class="modal fade" id="globalConfirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi</h5>
                </div>
                <div class="modal-body" id="globalConfirmMessage"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="globalConfirmOk">OK</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const modalElement = document.getElementById("globalConfirmModal");
            const modal = new bootstrap.Modal(modalElement);
            const confirmMessage = document.getElementById("globalConfirmMessage");
            const confirmOkBtn = document.getElementById("globalConfirmOk");
            let confirmAction = null;

            function showConfirmModal(message, actionCallback) {
                confirmMessage.textContent = message;
                confirmOkBtn.disabled = false;
                confirmOkBtn.innerHTML = "OK";
                confirmAction = actionCallback;
                modal.show();
            }

            const saveBtn = document.getElementById("btnConfirmSave");
            if (saveBtn) {
                saveBtn.addEventListener("click", function() {
                    showConfirmModal("Yakin ingin menyimpan semua perubahan?", function() {
                        confirmOkBtn.disabled = true;
                        confirmOkBtn.innerHTML =
                            '<i class="fas fa-spinner fa-spin me-2"></i> Menyimpan...';
                        document.getElementById("updateProfileForm").submit();
                    });
                });
            }

            const deactivateBtn = document.getElementById("btnConfirmDeactivate");
            if (deactivateBtn) {
                deactivateBtn.addEventListener("click", function() {
                    showConfirmModal("Yakin ingin menonaktifkan akun ini?", function() {
                        confirmOkBtn.disabled = true;
                        confirmOkBtn.innerHTML =
                            '<i class="fas fa-spinner fa-spin me-2"></i> Menonaktifkan...';
                        document.getElementById("deactivateForm").submit();
                    });
                });
            }

            confirmOkBtn.addEventListener("click", function() {
                if (typeof confirmAction === "function") {
                    confirmAction();
                }
            });
        });
    </script>
@endsection
