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
            max-width: 330px;
            padding: 15px;
            margin: 0 auto;
        }
    </style>
    <script src="<?= base_url('assets/js/jquery-3.6.4.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/toastr.min.js') ?>"></script>

</head>

<body>
    <div class="card">
        <article class="card-body">
            <h4 class="card-title mt-1 mb-4">Login</h4>
            <div class="form-group">
                <label>Username</label>
                <input name="username" id="uname" class="form-control" type="text" required autofocus>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input name="password" id="pwd" class="form-control" type="password" required>
            </div>
            <div class="form-group">
                <button id="login" class="btn btn-primary btn-block"> Proses </button>
            </div>

            <script>
                document.getElementById("uname")
                    .addEventListener("keyup", function(event) {
                        event.preventDefault();
                        if (event.keyCode === 13) {
                            document.getElementById("login").click();
                        }
                    });

                document.getElementById("pwd")
                    .addEventListener("keyup", function(event) {
                        event.preventDefault();
                        if (event.keyCode === 13) {
                            document.getElementById("login").click();
                        }
                    });
                    
                document.getElementById("login").onclick = function() {
                    let uname = document.getElementById('uname').value
                    let pwd = document.getElementById('pwd').value
                    if (uname == '' || pwd == '') {
                        toastr.warning('kolom username/password tidak boleh kosong!')
                    } else {
                        proses_login(uname, pwd)
                    }
                }

                function proses_login(uname, pwd) {
                    let url = "<?= site_url('proses-login') ?>"
                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: {
                            'uname': uname,
                            'pwd': pwd
                        },
                        dataType: 'Json',
                        cache: false,
                        success: function(data) {
                            if (data.status == false) {
                                toastr.error(data.pesan_gagal)
                            } else {
                                toastr.success(data.pesan_sukses)
                                window.setTimeout(function() {
                                    window.location = "<?= base_url('dashboard') ?>";
                                }, 3000)
                            }
                        }
                    })
                }
            </script>
        </article>
    </div> <!-- card.// -->
</body>

</html>