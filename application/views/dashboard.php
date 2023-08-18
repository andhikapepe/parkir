<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="aplikasi parkir berbasis web">
    <meta name="author" content="andhika6@gmail.com">
    <link rel="icon" href="<?= base_url('assets/img/logo.png') ?>">

    <title>Aplikasi Parkir</title>
    <!-- Bootstrap core CSS -->
    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/toastr.min.css') ?>" rel="stylesheet">

    <style>
        /*html,
        body {
            height: 100%;
        }*/

        body {
            display: -ms-flexbox;
            display: -webkit-box;
            display: flex;
            -ms-flex-align: center;
            -ms-flex-pack: center;
            -webkit-box-align: center;
            align-items: center;
            -webkit-box-pack: center;
            justify-content: center;
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #f5f5f5;
        }

        .card {
            width: 100%;
            max-width: 600px;
            /* padding: 10px; */
            margin: 0 auto;
        }
    </style>
    <script src="<?= base_url('assets/js/jquery-3.6.4.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/popper.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/toastr.min.js') ?>"></script>

</head>

<body style="zoom: 95%;">
    <div class="card">
        <article class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <span class="float-left">
                    <h4 class="card-title mt-1">Aplikasi Parkir</h4>
                    <h6 class="card-subtitle mb-2" id="nama-tempat">Subtitle</h6>
                </span>
                <span class="float-right">
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="<?= base_url('assets/img/settings.png') ?>" style="max-width:25px" alt="pengaturan">
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                            <a href="#" class="dropdown-item active">Halo..<?= ucfirst($this->session->userdata('username'))?>!</a>
                            <button data-toggle="modal" id="buka-modal" data-target="#myModal" class="dropdown-item">Pengaturan</button>
                            <a href="<?= base_url('laporan') ?>" class="dropdown-item">Laporan</a>
                            <a href="<?= base_url('logout') ?>" class="dropdown-item">Logout</a>
                        </div>
                    </div>
                </span>
            </div>
            <hr>
            <div id="clock" class="text-center"></div>
            <hr>
            <div class="d-flex justify-content-center">
                <div class="card mr-3">
                    <div class="d-flex justify-content-around align-items-center">
                        <img class="card-img-top" style="width: 80px;" src="<?= base_url('assets/img/scooter-in.png') ?>" alt="Sepeda Motor Masuk">
                        <h1 class="card-title" id="jml-motor-masuk"></h1>
                    </div>
                    <div class="card-body">
                        <button id="button-motor-masuk" class="btn btn-success btn-block">Sepeda Motor </br> Masuk</a>
                    </div>
                </div>
                <div class="card">
                    <div class="d-flex justify-content-around align-items-center">
                        <img class="card-img-top" style="width: 80px;" src="<?= base_url('assets/img/sedan-in.png') ?>" alt="Mobil Masuk">
                        <h1 class="card-title" id="jml-mobil-masuk"></h1>
                    </div>
                    <div class="card-body">
                        <button id="button-mobil-masuk" class="btn btn-success btn-block">Mobil </br> Masuk</a>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center mt-3">
                <div class="card mr-3">
                    <div class="d-flex justify-content-around align-items-center">
                        <img class="card-img-top" style="width: 80px;" src="<?= base_url('assets/img/scooter-out.png') ?>" alt="Sepeda Motor Keluar">
                        <h1 class="card-title" id="jml-motor-keluar"></h1>
                    </div>
                    <div class="card-body">
                        <button id="button-motor-keluar" class="btn btn-danger btn-block">Sepeda Motor </br> Keluar</a>
                    </div>
                </div>
                <div class="card">
                    <div class="d-flex justify-content-around align-items-center">
                        <img class="card-img-top" style="width: 80px;" src="<?= base_url('assets/img/sedan-out.png') ?>" alt="Mobil Keluar">
                        <h1 class="card-title" id="jml-mobil-keluar"></h1>
                    </div>
                    <div class="card-body">
                        <button id="button-mobil-keluar" class="btn btn-danger btn-block">Mobil </br> Keluar</a>
                    </div>
                </div>
            </div>
            <div class="d-flex mt-3">
                <div class="card mr-3 border-0">
                    <div class="card-body">
                        <p class="card-text">
                            Kapasitas Parkir Motor = <span id="kapasitas-motor"></span></br>
                            <strong>Sisa Ruang Parkir Motor = <span id="sisa-kapasitas-motor"></span></strong>
                        </p>
                    </div>
                </div>
                <div class="card border-0">
                    <div class="card-body">
                        <p class="card-text">
                            Kapasitas Parkir Mobil = <span id="kapasitas-mobil"></span></br>
                            <strong>Sisa Ruang Parkir Mobil = <span id="sisa-kapasitas-mobil"></span></strong>
                        </p>
                    </div>
                </div>
            </div>
        </article>
        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Pengaturan</h5>
                        <button type="button" id="tutup-modal" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group row">
                                <label for="inputTempat" class="col-sm-4 col-form-label">Nama Tempat</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="inputTempat">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputKapasitasMotor" class="col-sm-4 col-form-label">Total Kapasitas Motor</label>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control" id="inputKapasitasMotor">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputKapasitasMobil" class="col-sm-4 col-form-label">Total Kapasitas Mobil</label>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control" id="inputKapasitasMobil">
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row">
                                <label for="inputUsernameBaru" class="col-sm-4 col-form-label">Username Baru</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="inputUsernameBaru">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputPasswordBaru" class="col-sm-4 col-form-label">Password Baru</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="inputPasswordBaru">
                                </div>
                            </div>
                            <input type="hidden" name="dtID" id="dtID">
                            <input type="hidden" name="method" id="method">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="simpan-modal">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            const date = new Date(),
                year = date.toLocaleString("default", {
                    year: "numeric"
                }),
                month = date.toLocaleString("default", {
                    month: "2-digit"
                }),
                day = date.toLocaleString("default", {
                    day: "2-digit"
                }),
                tgl_sekarang = year + "-" + month + "-" + day

            cekMenuPengaturan()

            function cekMenuPengaturan() {
                const url = "<?= base_url('basis') ?>"
                $.ajax({
                    type: 'GET',
                    url: url,
                    dataType: 'JSON',
                    cache: false,
                    success: function(data) {
                        if (data.status == false) {
                            document.getElementById('button-motor-masuk').disabled = true
                            document.getElementById('button-motor-keluar').disabled = true
                            document.getElementById('button-mobil-masuk').disabled = true
                            document.getElementById('button-mobil-keluar').disabled = true
                            toastr.options = {
                                "showDuration": "300",
                                "positionClass": "toast-top-center",
                                "preventDuplicates": false,
                            }
                            toastr.info('Silahkan melakukan pengaturan terlebih dahulu!')
                            $("#myModal").modal({
                                show: true
                            })
                            document.getElementById('kapasitas-motor').innerHTML = 0
                            document.getElementById('kapasitas-mobil').innerHTML = 0
                            document.getElementById('method').value = data.method
                            document.getElementById('dtID').value = data.dtID
                        } else {
                            document.getElementById('nama-tempat').innerHTML = data.nama_tempat
                            document.getElementById('kapasitas-motor').innerHTML = data.kapasitas_motor
                            document.getElementById('kapasitas-mobil').innerHTML = data.kapasitas_mobil
                            document.getElementById('inputTempat').value = data.nama_tempat
                            document.getElementById('inputKapasitasMotor').value = data.kapasitas_motor
                            document.getElementById('inputKapasitasMobil').value = data.kapasitas_mobil
                            document.getElementById('dtID').value = data.dtID
                            document.getElementById('method').value = data.method
                        }
                    }
                })
            }

            document.getElementById('buka-modal').onclick = function() {
                cekMenuPengaturan()
            }

            document.getElementById('tutup-modal').onclick = function() {
                document.getElementById('dtID').value = ''
                document.getElementById('method').value = ''
                document.getElementById('inputTempat').value = ''
                document.getElementById('inputKapasitasMotor').value = ''
                document.getElementById('inputKapasitasMobil').value = ''
                document.getElementById('inputUsernameBaru').value = ''
                document.getElementById('inputPasswordBaru').value = ''
            }

            document.getElementById('simpan-modal').onclick = function() {
                const dtID = document.getElementById('dtID').value,
                    method = document.getElementById('method').value,
                    inputTempat = document.getElementById('inputTempat').value,
                    inputKapasitasMotor = document.getElementById('inputKapasitasMotor').value,
                    inputKapasitasMobil = document.getElementById('inputKapasitasMobil').value,
                    inputUsernameBaru = document.getElementById('inputUsernameBaru').value,
                    inputPasswordBaru = document.getElementById('inputPasswordBaru').value
                if (inputUsernameBaru.length > 0 && inputPasswordBaru == '') {
                    toastr.error('Kolom Password Baru Belum Diisi!')
                }

                data = {
                    'dtID': dtID,
                    'method': method,
                    'inputTempat': inputTempat,
                    'inputKapasitasMotor': inputKapasitasMotor,
                    'inputKapasitasMobil': inputKapasitasMobil,
                }

                if (inputUsernameBaru.length > 0 && inputPasswordBaru.length > 0) {
                    dataBaru = {
                        'inputUsernameBaru': inputUsernameBaru,
                        'inputPasswordBaru': inputPasswordBaru
                    }
                    data = Object.assign(data, dataBaru)
                }

                $.ajax({
                    type: 'POST',
                    url: '<?= base_url('simpan-modal') ?>',
                    data: data,
                    dataType: 'JSON',
                    cache: false,
                    success: function(data) {
                        if (data.pesan_konfigurasi) {
                            toastr.success(data.pesan_konfigurasi)
                        }
                        if (data.pesan_pengguna) {
                            toastr.success(data.pesan_pengguna)
                        }
                        window.setTimeout(function() {
                            $("#myModal").modal('hide')
                            location.reload()
                        }, 3000)
                    }
                })
            }

            hitungMotor()

            function hitungMotor() {
                const url = '<?= base_url('hitung-jml') ?>'
                const data = {
                    'jenis_kendaraan': 'motor',
                    'tgl': tgl_sekarang
                }
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: data,
                    dataType: 'JSON',
                    cache: false,
                    success: function(data) {
                        document.getElementById('sisa-kapasitas-motor').innerHTML = data.sisa
                        document.getElementById('kapasitas-motor').innerHTML = data.kapasitas
                        document.getElementById('jml-motor-masuk').innerHTML = data.jml_masuk
                        document.getElementById('jml-motor-keluar').innerHTML = data.jml_keluar
                        if (data.sisa == 0) {
                            document.getElementById('button-motor-masuk').disabled = true
                        }
                        if (data.jml_keluar == data.jml_masuk) {
                            document.getElementById('button-motor-keluar').disabled = true
                        }
                        if (data.jml_masuk > data.jml_keluar) {
                            document.getElementById('button-motor-keluar').disabled = false
                        }                     
                    }
                })
            }

            hitungMobil()

            function hitungMobil() {
                const url = '<?= base_url('hitung-jml') ?>'
                const data = {
                    'jenis_kendaraan': 'mobil',
                    'tgl': tgl_sekarang
                }
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: data,
                    dataType: 'JSON',
                    cache: false,
                    success: function(data) {
                        document.getElementById('sisa-kapasitas-mobil').innerHTML = data.sisa
                        document.getElementById('kapasitas-mobil').innerHTML = data.kapasitas
                        document.getElementById('jml-mobil-masuk').innerHTML = data.jml_masuk
                        document.getElementById('jml-mobil-keluar').innerHTML = data.jml_keluar
                        if (data.sisa == 0) {
                            document.getElementById('button-mobil-masuk').disabled = true
                        }
                        if (data.jml_keluar == data.jml_masuk) {
                            document.getElementById('button-mobil-keluar').disabled = true
                        }
                        if (data.jml_masuk > data.jml_keluar) {
                            document.getElementById('button-mobil-keluar').disabled = false
                        }
                    }
                })
            }

            document.getElementById("button-motor-masuk").onclick = function() {
                const url = "<?= base_url('tambah-data') ?>"
                const data = {
                    'jenis_kendaraan': 'motor',
                    'status_in_out': 'in'
                }
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: data,
                    dataType: 'JSON',
                    cache: false,
                    success: function(data) {
                        if (data.status == false) {
                            toastr.error(data.pesan_gagal)
                        } else {
                            toastr.success(data.pesan_sukses)
                            hitungMotor()
                        }
                    }
                })
            }

            document.getElementById("button-motor-keluar").onclick = function() {
                const url = "<?= base_url('tambah-data') ?>"
                const data = {
                    'jenis_kendaraan': 'motor',
                    'status_in_out': 'out'
                }
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: data,
                    dataType: 'JSON',
                    cache: false,
                    success: function(data) {
                        if (data.status == false) {
                            toastr.error(data.pesan_gagal)
                        } else {
                            toastr.success(data.pesan_sukses)
                            hitungMotor()
                        }
                    }
                })
            }

            document.getElementById("button-mobil-masuk").onclick = function() {
                const url = "<?= base_url('tambah-data') ?>"
                const data = {
                    'jenis_kendaraan': 'mobil',
                    'status_in_out': 'in'
                }
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: data,
                    dataType: 'JSON',
                    cache: false,
                    success: function(data) {
                        if (data.status == false) {
                            toastr.error(data.pesan_gagal)
                        } else {
                            toastr.success(data.pesan_sukses)
                            hitungMobil()
                        }
                    }
                })
            }

            document.getElementById("button-mobil-keluar").onclick = function() {
                const url = "<?= base_url('tambah-data') ?>"
                const data = {
                    'jenis_kendaraan': 'mobil',
                    'status_in_out': 'out'
                }
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: data,
                    dataType: 'JSON',
                    cache: false,
                    success: function(data) {
                        if (data.status == false) {
                            toastr.error(data.pesan_gagal)
                        } else {
                            toastr.success(data.pesan_sukses)
                            hitungMobil()
                        }
                    }
                })
            }

            function displayTime() {
                const d = new Date()
                const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']
                const months = [
                    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                ]
                const day = days[d.getDay()]
                const month = months[d.getMonth()]
                const dateNum = d.getDate()
                const year = d.getFullYear()
                const hours = formatTime(d.getHours())
                const minutes = formatTime(d.getMinutes())
                const seconds = formatTime(d.getSeconds())
                const time = `${hours}:${minutes}:${seconds}`
                const timezoneOffset = d.getTimezoneOffset()
                const timezoneHours = Math.abs(Math.floor(timezoneOffset / 60))
                const timezoneMinutes = Math.abs(timezoneOffset % 60)
                const timezoneSign = timezoneOffset > 0 ? '-' : '+'
                const timezone = `GMT${timezoneSign}${formatTime(timezoneHours)}:${formatTime(timezoneMinutes)}`
                const dateIndonesia = `${day}, ${dateNum} ${month} ${year}`
                document.getElementById('clock').innerHTML = `${dateIndonesia} - ${time} ${timezone}`
            }

            function formatTime(timeValue) {
                return timeValue < 10 ? `0${timeValue}` : timeValue
            }

            setInterval(displayTime, 1000)
        </script>
    </div>
</body>

</html>