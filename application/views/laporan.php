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
        html,
        body {
            height: 100%;
        }

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
            max-width: 800px;
            margin: 0 auto;
        }
    </style>
    <script src="<?= base_url('assets/js/jquery-3.6.4.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/popper.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/toastr.min.js') ?>"></script>
</head>

<body>
    <div class="card">
        <article class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <span class="float-left">
                    <h4 class="card-title mt-1">Laporan</h4>
                </span>
                <span class="float-right">
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="<?= base_url('assets/img/settings.png') ?>" style="max-width:25px" alt="pengaturan">
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                            <a href="#" class="dropdown-item active">Halo..<?= ucfirst($this->session->userdata('username')) ?>!</a>
                            <a href="<?= base_url('dashboard') ?>" class="dropdown-item">Dashboard</a>
                            <a href="<?= base_url('logout') ?>" class="dropdown-item">Logout</a>
                        </div>
                    </div>
                </span>
            </div>
            <div class="jumbotron mt-3">
                <div class="form-inline">
                    <label>Tampilkan Laporan :&nbsp;</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="pilihLaporan" id="harian" value="harian">
                        <label class="form-check-label" for="harian">Harian</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="pilihLaporan" id="bulanan" value="bulanan">
                        <label class="form-check-label" for="bulanan">Bulanan</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="pilihLaporan" id="tahunan" value="tahunan">
                        <label class="form-check-label" for="tahunan">Tahunan</label>
                    </div>
                </div>
                <div id="tampilForm" class="tampilForm"></div>
            </div>
            <div id="tampilTabel" class="tampilTabel"></div>
        </article>
        <script>
            document.getElementById('harian').onclick = function() {
                dt = document.getElementById('tampilForm');
                let insertedContent = document.querySelector(".insertedContent");
                if (insertedContent) {
                    insertedContent.parentNode.removeChild(insertedContent);
                }
                let tampilan = '<hr>'
                tampilan += '<div class="form-inline">'
                tampilan += '    <div class="form-group">'
                tampilan += '    <label for="inputTanggal"> Pilih Tanggal </label>'
                tampilan += '    <input type="date" id="inputTanggal" name="inputTanggal" class="form-control mx-sm-3">'
                tampilan += '    <button class="btn btn-danger" id="btnHarian" onclick="tampilHarian()"> Tampilkan </button>'
                tampilan += '    </div>'
                tampilan += '</div>'
                dt.insertAdjacentHTML('afterbegin', '<span class="insertedContent">' + tampilan + '</span>')
            }

            //fungsi jika btnHarian di klik
            function tampilHarian() {
                let valTglHarian = document.getElementById('inputTanggal').value,
                    data = {
                        jenisLaporan: 'harian',
                        date: valTglHarian
                    }
                if (valTglHarian.length > 0) {
                    $.ajax({
                        type: 'POST',
                        url: '<?= base_url('tampil-laporan') ?>',
                        data: data,
                        dataType: 'JSON',
                        cache: false,
                        success: function(data) {
                            let table = '<table class="table table-hover table-striped">'
                            table += '<thead>'
                            table += '    <tr>'
                            table += '        <th colspan="3">Periode : ' + data.periode + '</th>'
                            table += '        <th colspan="2">Jenis Laporan: ' + data.jenis_laporan + '</th>'
                            table += '    </tr>'
                            table += '    <tr class="bg-primary text-white">'
                            table += '        <th>Jenis Kendaraan</th>'
                            table += '        <th class="text-center">Kapasitas</th>'
                            table += '        <th class="text-center">Jumlah Masuk</th>'
                            table += '        <th class="text-center">Jumlah Keluar</th>'
                            table += '        <th class="text-center">Sisa Parkir</th>'
                            table += '    </tr>'
                            table += '</thead>'
                            table += '<tbody>'
                            for (var key in data.data) {
                                let sisa = data.data[key].kapasitas - (data.data[key].jml_masuk - data.data[key].jml_keluar)
                                table += '<tr>'
                                table += '<td>' + data.data[key].jenis_kendaraan + '</td>'
                                table += '<td class="text-center">' + data.data[key].kapasitas + '</td>'
                                table += '<td class="text-center">' + data.data[key].jml_masuk + '</td>'
                                table += '<td class="text-center">' + data.data[key].jml_keluar + '</td>'
                                table += '<td class="text-center">' + sisa + '</td>'
                                table += '</tr>'
                            }
                            table += '</tbody>'
                            table += '</table>'
                            dt = document.getElementById('tampilTabel');
                            let insertedTable = document.querySelector(".insertedTable");
                            if (insertedTable) {
                                insertedTable.parentNode.removeChild(insertedTable);
                            }
                            dt.insertAdjacentHTML('afterbegin', '<span class="insertedTable">' + table + '</span>')
                        }
                    })
                } else {
                    toastr.warning('Tanggal belum diisi!')
                }
            }
            //end fungsi bthHarian

            document.getElementById('bulanan').onclick = function() {
                dt = document.getElementById('tampilForm');
                let insertedContent = document.querySelector(".insertedContent");
                if (insertedContent) {
                    insertedContent.parentNode.removeChild(insertedContent);
                }
                let tampilan = '<hr>'
                tampilan += '<div class="form-inline">'
                tampilan += '    <div class="form-group">'
                tampilan += '        <label for="inputBulan">Pilih Bulan</label>'
                tampilan += '        <input type="month" id="inputBulan" name="inputBulan" class="form-control mx-sm-3" max="<?= date('Y-m') ?>">'
                tampilan += '        <button class="btn btn-danger" id="btnBulanan" onclick="tampilBulanan()">Tampilkan</button>'
                tampilan += '    </div>'
                tampilan += '</div>'
                dt.insertAdjacentHTML('afterbegin', '<span class="insertedContent">' + tampilan + '</span>')
            }

            //fungsi btnBulanan
            function tampilBulanan() {
                let valBulanan = document.getElementById('inputBulan').value,
                    data = {
                        jenisLaporan: 'bulanan',
                        date: valBulanan
                    }
                if (valBulanan.length > 0) {
                    $.ajax({
                        type: 'POST',
                        url: '<?= base_url('tampil-laporan') ?>',
                        data: data,
                        dataType: 'JSON',
                        cache: false,
                        success: function(data) {
                            let table = '<table class="table table-hover table-striped">'
                            table += '<thead>'
                            table += '    <tr>'
                            table += '        <th colspan="2">Periode : ' + data.periode + '</th>'
                            table += '        <th colspan="2" class="text-right">Jenis Laporan: ' + data.jenis_laporan + '</th>'
                            table += '    </tr>'
                            table += '    <tr class="bg-primary text-white">'
                            table += '        <th>Jenis Kendaraan</th>'
                            table += '        <th class="text-center">Jumlah Masuk</th>'
                            table += '        <th class="text-center">Jumlah Keluar</th>'
                            table += '        <th class="text-center">Selisih</th>'
                            table += '    </tr>'
                            table += '</thead>'
                            table += '<tbody>'
                            for (var key in data.data) {
                                let selisih = data.data[key].jml_masuk - data.data[key].jml_keluar
                                table += '<tr>'
                                table += '<td>' + data.data[key].jenis_kendaraan + '</td>'
                                table += '<td class="text-center">' + data.data[key].jml_masuk + '</td>'
                                table += '<td class="text-center">' + data.data[key].jml_keluar + '</td>'
                                table += '<td class="text-center">' + selisih + '</td>'
                                table += '</tr>'
                            }
                            table += '</tbody>'
                            table += '</table>'
                            dt = document.getElementById('tampilTabel');
                            let insertedTable = document.querySelector(".insertedTable");
                            if (insertedTable) {
                                insertedTable.parentNode.removeChild(insertedTable);
                            }
                            dt.insertAdjacentHTML('afterbegin', '<span class="insertedTable">' + table + '</span>')
                        }
                    })
                } else {
                    toastr.warning('Bulan tahun belum diisi!')
                }
            }
            //end fungsi btnBulanan

            document.getElementById('tahunan').onclick = function() {
                dt = document.getElementById('tampilForm');
                let insertedContent = document.querySelector(".insertedContent");
                if (insertedContent) {
                    insertedContent.parentNode.removeChild(insertedContent);
                }
                let tampilan = '<hr>'                
                tampilan += '<div class="form-inline">'
                tampilan += '    <div class="form-group">'
                tampilan += '        <label for="inputTahun">Input Tahun</label>'
                tampilan += '        <input type="text" onkeypress="validate(event)" pattern="[0-9]+" minlength="4" maxlength="4" id="inputTahun" name="inputTahun" class="form-control mx-sm-3">'
                tampilan += '        <button class="btn btn-danger" id="btnTahunan" onclick="tampilTahunan()">Tampilkan</button>'
                tampilan += '    </div>'
                tampilan += '</div>'
                dt.insertAdjacentHTML('afterbegin', '<span class="insertedContent">' + tampilan + '</span>')
            }
            //fungsi btnTahunan
            function tampilTahunan() {
                let valTahun = document.getElementById('inputTahun').value,
                    data = {
                        jenisLaporan: 'tahunan',
                        date: valTahun
                    }
                if (valTahun.length > 0 && valTahun.length < 4) {
                    toastr.warning('periksa inputan tahun');
                }

                if (valTahun.length == 4) {
                    $.ajax({
                        type: 'POST',
                        url: '<?= base_url('tampil-laporan') ?>',
                        data: data,
                        dataType: 'JSON',
                        cache: false,
                        success: function(data) {
                            let table = '<table class="table table-hover table-striped">'
                            table += '<thead>'
                            table += '    <tr>'
                            table += '        <th colspan="2">Periode : ' + data.periode + '</th>'
                            table += '        <th colspan="2" class="text-right">Jenis Laporan: ' + data.jenis_laporan + '</th>'
                            table += '    </tr>'
                            table += '    <tr class="bg-primary text-white">'
                            table += '        <th>Jenis Kendaraan</th>'
                            table += '        <th class="text-center">Jumlah Masuk</th>'
                            table += '        <th class="text-center">Jumlah Keluar</th>'
                            table += '        <th class="text-center">Selisih</th>'
                            table += '    </tr>'
                            table += '</thead>'
                            table += '<tbody>'
                            for (var key in data.data) {
                                let selisih = data.data[key].jml_masuk - data.data[key].jml_keluar
                                table += '<tr>'
                                table += '<td>' + data.data[key].jenis_kendaraan + '</td>'
                                table += '<td class="text-center">' + data.data[key].jml_masuk + '</td>'
                                table += '<td class="text-center">' + data.data[key].jml_keluar + '</td>'
                                table += '<td class="text-center">' + selisih + '</td>'
                                table += '</tr>'
                            }
                            table += '</tbody>'
                            table += '</table>'
                            dt = document.getElementById('tampilTabel');
                            let insertedTable = document.querySelector(".insertedTable");
                            if (insertedTable) {
                                insertedTable.parentNode.removeChild(insertedTable);
                            }
                            dt.insertAdjacentHTML('afterbegin', '<span class="insertedTable">' + table + '</span>')
                        }
                    })
                }
            }
            //end fungsi btnTahunan
            function validate(evt) {
                var theEvent = evt || window.event;

                // Handle paste
                if (theEvent.type === 'paste') {
                    key = event.clipboardData.getData('text/plain');
                } else {
                    // Handle key press
                    var key = theEvent.keyCode || theEvent.which;
                    key = String.fromCharCode(key);
                }
                var regex = /[0-9]|\./;
                if (!regex.test(key)) {
                    theEvent.returnValue = false;
                    if (theEvent.preventDefault) theEvent.preventDefault();
                }
            }
        </script>
    </div> <!-- card.// -->
</body>

</html>