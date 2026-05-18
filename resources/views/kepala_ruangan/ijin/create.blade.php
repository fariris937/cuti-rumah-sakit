@extends('layouts.app')

@section('title', 'Pengajuan Ijin')
@section('page-title', 'Pengajuan Ijin')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card p-3">
                <div class="text-center mb-3">
                    <img src="{{ asset('images/logo_rs_wates_husada.png') }}" alt="Logo RS Wates Husada" style="height: 80px;">
                    <h5 class="mt-2 fw-bold">RUMAH SAKIT WATES HUSADA</h5>
                    <p>Jl. Raya Wates Utara No.38 Kedungpring<br>Kec.Balongpanggang Kab.Gresik</p>
                    <p>Telp. (031) 7922351 Email : <a href="mailto:rswateshusada@gmail.com">rswateshusada@gmail.com</a></p>
                    <hr style="border-top: 2px solid black;">
                    <h6 class="fw-bold">FORM LAPORAN IJIN</h6>
                </div>
                <form action="{{ route('ijin.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <p>Bersama ini saya laporkan,</p>
                    <div class="row mb-2">
                        <div class="col-3">Nama</div>
                        <div class="col-9">: {{ $user->nama }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-3">Divisi/Jabatan</div>
                        <div class="col-9">: {{ $user->divisi ? $user->divisi->nama_divisi ?? $user->divisi : '-' }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-3">Bahwa pada tanggal</div>
                        <div class="col-9">: <input type="date" class="form-control @error('tanggal_ijin') is-invalid @enderror" name="tanggal_ijin" value="{{ old('tanggal_ijin') }}" required></div>
                        @error('tanggal_ijin')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-2">
                        <div class="col-3">Jam Mulai</div>
                        <div class="col-3">: <input type="time" class="form-control @error('jam_mulai') is-invalid @enderror" name="jam_mulai" value="{{ old('jam_mulai') }}"></div>
                        @error('jam_mulai')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="col-3">Jam Selesai</div>
                        <div class="col-3">: <input type="time" class="form-control @error('jam_selesai') is-invalid @enderror" name="jam_selesai" value="{{ old('jam_selesai') }}"></div>
                        @error('jam_selesai')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-2">
                        <div class="col-3">Jenis Ijin</div>
                        <div class="col-9">
                            : <select class="form-control @error('jenis_ijin') is-invalid @enderror" name="jenis_ijin" required>
                                <option value="">Pilih jenis ijin</option>
                                <option value="sakit" {{ old('jenis_ijin') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                                <option value="keluarga" {{ old('jenis_ijin') == 'keluarga' ? 'selected' : '' }}>Keluarga</option>
                                <option value="pribadi" {{ old('jenis_ijin') == 'pribadi' ? 'selected' : '' }}>Pribadi</option>
                                <option value="lainnya" {{ old('jenis_ijin') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('jenis_ijin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <p>Tidak bisa hadir/masuk kerja dengan alasan :</p>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>KETERANGAN</th>
                                <th>LAMA IJIN (HARI)</th>
                                <th>BERKAS PENDUKUNG</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Mangkir/Alpha/Bolos</td>
                                <td></td>
                                <td>Tanpa Surat</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Sakit</td>
                                <td></td>
                                <td>Surat Dokter+FC Kwitansi+Resep</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Menjaga Istri/Anak/Suami Atas Saran Dokter di RS</td>
                                <td>2</td>
                                <td>Surat Dokter</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Cuti Melahirkan</td>
                                <td>30+60</td>
                                <td>Surat Dokter</td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Keguguran</td>
                                <td>45</td>
                                <td>Surat Dokter</td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>Istirahat Atas Saran Dokter</td>
                                <td>2</td>
                                <td>Surat Dokter</td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td>Istri Melahirkan/Keguguran</td>
                                <td>2</td>
                                <td>Surat Dokter</td>
                            </tr>
                            <tr>
                                <td>8</td>
                                <td>Pernikahan Karyawan</td>
                                <td>3</td>
                                <td>Undangan</td>
                            </tr>
                            <tr>
                                <td>9</td>
                                <td>Mengkahitankan</td>
                                <td>2</td>
                                <td>Undangan</td>
                            </tr>
                            <tr>
                                <td>10</td>
                                <td>Pernikahan Anak Kandung</td>
                                <td>2</td>
                                <td>Undangan</td>
                            </tr>
                            <tr>
                                <td>11</td>
                                <td>Kematian Orang Tua/Mertua</td>
                                <td>2</td>
                                <td>Surat Ket. Lurah/RT</td>
                            </tr>
                            <tr>
                                <td>12</td>
                                <td>Kematian Anak/Istri/Suami</td>
                                <td>3</td>
                                <td>Surat Ket. Lurah/RT</td>
                            </tr>
                            <tr>
                                <td>13</td>
                                <td>Kematian Saudara Sekandung/Serumah</td>
                                <td>1</td>
                                <td>Surat Ket. Lurah/RT</td>
                            </tr>
                            <tr>
                                <td>14</td>
                                <td>Kebakaran/Bencana Alam</td>
                                <td>1</td>
                                <td>Surat Ket. Lurah/RT</td>
                            </tr>
                            <tr>
                                <td>15</td>
                                <td>Telambat Datang, pada jam</td>
                                <td></td>
                                <td>Alasan</td>
                            </tr>
                            <tr>
                                <td>16</td>
                                <td>Pulang Lebih Cepat, pada jam</td>
                                <td></td>
                                <td>Alasan</td>
                            </tr>
                            <tr>
                                <td>17</td>
                                <td>Meninggalkan Pekerjaan, jam</td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan Alasan :</label>
                        <textarea class="form-control @error('keterangan') is-invalid @enderror"
                                  id="keterangan" name="keterangan" rows="3"
                                  placeholder="Jelaskan alasan pengajuan ijin...">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="berkas_pendukung" class="form-label">Berkas Pendukung</label>
                        <input type="file" class="form-control @error('berkas_pendukung') is-invalid @enderror"
                               id="berkas_pendukung" name="berkas_pendukung"
                               accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                        <div class="form-text">Upload file pendukung (PDF, DOC, DOCX, JPG, JPEG, PNG) maksimal 2MB</div>
                        @error('berkas_pendukung')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <p>Gresik,</p>
                    <div class="row">
                        <div class="col-4 text-center">
                            Pemohon
                        </div>
                        <div class="col-4 text-center">
                            Atasan
                        </div>
                        <div class="col-4 text-center">
                            SDM
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-3">
                        <a href="{{ route('kepala-ruangan.dashboard') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-2"></i>Ajukan Ijin
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
