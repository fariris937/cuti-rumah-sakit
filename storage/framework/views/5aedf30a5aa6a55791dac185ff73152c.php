

<?php $__env->startSection('title', 'Pengajuan Ijin - Kepala Bagian'); ?>
<?php $__env->startSection('page-title', 'Pengajuan Ijin'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card p-3">
                <div class="text-center mb-3">
                    <img src="<?php echo e(asset('images/logo_rs_wates_husada.png')); ?>" alt="Logo RS Wates Husada" style="height: 80px;">
                    <h5 class="mt-2 fw-bold">RUMAH SAKIT WATES HUSADA</h5>
                    <p>Jl. Raya Wates Utara No.38 Kedungpring<br>Kec.Balongpanggang Kab.Gresik</p>
                    <p>Telp. (031) 7922351 Email : <a href="mailto:rswateshusada@gmail.com">rswateshusada@gmail.com</a></p>
                    <hr style="border-top: 2px solid black;">
                    <h6 class="fw-bold">FORM LAPORAN IJIN - KEPALA BAGIAN</h6>
                </div>
                <form action="<?php echo e(route('kepala-bagian.ijin.store')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <p>Bersama ini saya laporkan,</p>
                    <div class="row mb-2">
                        <div class="col-3">Nama</div>
                        <div class="col-9">: <?php echo e($kepalaBagian->nama); ?></div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-3">Jabatan</div>
                        <div class="col-9">: Kepala Bagian</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-3">Bahwa pada tanggal</div>
                        <div class="col-9">: <input type="date" class="form-control <?php $__errorArgs = ['tanggal_ijin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="tanggal_ijin" value="<?php echo e(old('tanggal_ijin')); ?>" required></div>
                        <?php $__errorArgs = ['tanggal_ijin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="row mb-2">
                        <div class="col-3">Jam Mulai</div>
                        <div class="col-3">: <input type="time" class="form-control <?php $__errorArgs = ['jam_mulai'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="jam_mulai" value="<?php echo e(old('jam_mulai')); ?>"></div>
                        <?php $__errorArgs = ['jam_mulai'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <div class="col-3">Jam Selesai</div>
                        <div class="col-3">: <input type="time" class="form-control <?php $__errorArgs = ['jam_selesai'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="jam_selesai" value="<?php echo e(old('jam_selesai')); ?>"></div>
                        <?php $__errorArgs = ['jam_selesai'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="row mb-2">
                        <div class="col-3">Jenis Ijin</div>
                        <div class="col-9">
                            : <select class="form-control <?php $__errorArgs = ['jenis_ijin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="jenis_ijin" required>
                                <option value="">Pilih jenis ijin</option>
                                <option value="sakit" <?php echo e(old('jenis_ijin') == 'sakit' ? 'selected' : ''); ?>>Sakit</option>
                                <option value="keluarga" <?php echo e(old('jenis_ijin') == 'keluarga' ? 'selected' : ''); ?>>Keluarga</option>
                                <option value="pribadi" <?php echo e(old('jenis_ijin') == 'pribadi' ? 'selected' : ''); ?>>Pribadi</option>
                                <option value="lainnya" <?php echo e(old('jenis_ijin') == 'lainnya' ? 'selected' : ''); ?>>Lainnya</option>
                            </select>
                            <?php $__errorArgs = ['jenis_ijin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
                        <textarea class="form-control <?php $__errorArgs = ['keterangan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                  id="keterangan" name="keterangan" rows="3"
                                  placeholder="Jelaskan alasan pengajuan ijin..." required><?php echo e(old('keterangan')); ?></textarea>
                        <?php $__errorArgs = ['keterangan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="mb-3">
                        <label for="berkas_pendukung" class="form-label">Berkas Pendukung</label>
                        <input type="file" class="form-control <?php $__errorArgs = ['berkas_pendukung'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               id="berkas_pendukung" name="berkas_pendukung"
                               accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                        <div class="form-text">Upload file pendukung (PDF, DOC, DOCX, JPG, JPEG, PNG) maksimal 2MB</div>
                        <?php $__errorArgs = ['berkas_pendukung'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="alert alert-info">
                        <strong>Catatan:</strong> Sebagai Kepala Bagian, pengajuan ijin Anda akan otomatis disetujui dan langsung muncul di dashboard Kepala Kepegawaian.
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
                        <a href="<?php echo e(route('kepala-bagian.dashboard')); ?>" class="btn btn-secondary">
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\farir\cuti-rumah-sakit\resources\views/kepala_bagian/ijin/create.blade.php ENDPATH**/ ?>