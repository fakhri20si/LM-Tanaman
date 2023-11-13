@extends('layouts.main')
@section('container')
<div class="card">
    <h5 class="card-header">

          <div class="col-lg-4 col-md-6">
            <div class="mt-3">

              <a href="/users/create" class="btn rounded-pill btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalCenter">
                <i class="tf-icons bx bx-user-plus me-1 "></i>
                User
              </a>
              <!-- Modal -->
              <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="modalCenterTitle">Tambah Data User</h5>
                      <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                      ></button>
                    </div>
                    <form method="post" action="/users">
                      @csrf
                    <div class="modal-body">
                      <div class="row">
                        <div class="col mb-3">
                          <label for="nameWithTitle" class="form-label">Nama</label>
                          <input type="text" name="name" id="name" class="form-control" placeholder="Masukkan Nama" required autofocus/>
                        </div>
                      </div>
                      <div class="row g-2">
                        <div class="col mb-0">
                          <label for="emailWithTitle" class="form-label">NIK</label>
                          <input type="text" name="nik" id="nik" class="form-control" placeholder="Masukkan NIK" required/>
                        </div>
                        <div class="col mb-0">
                          <label for="dobWithTitle" class="form-label">Password</label>
                          <input type="text" name="password" id="password" class="form-control" placeholder="Masukkan Password" required/>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                      </button>
                      <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                  </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
    </h5>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
          // Temukan semua tombol edit dengan kelas .edit-user
          const editButtons = document.querySelectorAll('.edit-user');
  
          // Iterasi melalui setiap tombol edit
          editButtons.forEach(function (button) {
              button.addEventListener('click', function () {
                  // Dapatkan data dari atribut data
                  const userId = this.getAttribute('data-user-id');
                  const userName = this.getAttribute('data-user-name');
                  const userNik = this.getAttribute('data-user-nik');
  
                  // Temukan formulir modal berdasarkan ID yang sesuai
                  const modalId = `#modalCenter2_${userId}`;
                  const modal = document.querySelector(modalId);
  
                  // Isi formulir modal dengan data yang sesuai
                  modal.querySelector('#name').value = userName;
                  modal.querySelector('#nik').value = userNik;
                  // ... Isi elemen formulir lainnya sesuai kebutuhan ...
  
                  // Tampilkan modal
                  new bootstrap.Modal(modal).show();
              });
          });
      });
  </script>
  @foreach ($users as $user)
      <div class="modal fade" id="modalCenter2_{{ $user->id }}" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalCenterTitle">Edit Data User</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <form method="post" action="/users/{{ $user->id }}">
            @method('put')
            @csrf
          <div class="modal-body">
            <div class="row">
              <div class="col mb-3">
                <label for="nameWithTitle" class="form-label">Nama</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" placeholder="Masukkan Nama" required/>
              </div>
            </div>
            <div class="row g-2">
              <div class="col mb-0">
                <label for="emailWithTitle" class="form-label">NIK</label>
                <input type="text" name="nik" id="nik" class="form-control" {{ old('nik', $user->nik) }} placeholder="Masukkan NIK" required/>
              </div>
              <div class="col mb-0">
                <label for="dobWithTitle" class="form-label">Password</label>
                <input type="text" name="password" id="password" class="form-control" placeholder="Masukkan Password Baru" required/>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
              Close
            </button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </form>
        </div>
      </div>
    </div>
@endforeach
    <div class="table-responsive text-nowrap">
      @if(session()->has('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif
      <table class="table table-hover">
        <thead>
          <tr>
            <th>No</th>
            <th>NIK</th>
            <th>Nama</th>
            <th>Password</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
        @foreach ($users as $user)

          <tr>
            <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{ $loop->iteration }} </strong></td>
            <td>{{ $user->nik }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->password }}</td>
            <td >
              <div class=" d-flex demo-inline-spacing">
                <a href="#" class="btn rounded-pill btn-outline-warning edit-user" data-bs-toggle="modal" data-bs-target="#modalCenter2" data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}" data-user-nik="{{ $user->nik }}">
                  <span class="tf-icons bx bx-edit"></span>&nbsp; Edit
              </a>
                <form action="/users/{{ $user->id }}" method="post">
                  @method('delete')
                  @csrf
                <button class="btn rounded-pill btn-outline-danger">
                  <span class="tf-icons bx bx-delete"></span>&nbsp; Delete
                </button>
                </form>
              </div>
            </td>
          </tr>
        @endforeach

        </tbody>
      </table>
      <div class="float-end">
          {{ $users->links() }}
      </div>

    </>
  </div> 
@endsection