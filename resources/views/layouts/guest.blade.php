<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link href="{{ asset('plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/bootstrap/css/bootstrap-theme.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/guest.css') }}" rel="stylesheet">
</head>
<body>
    <center><img src="{{ asset('images/logo.png') }}" alt="" style="border-radius: 5px;width: 300px;height: 55px;margin:2% auto 1%;" /></center>

    <!-- <div class="col-md-5"> -->
        <div class="tab_container">
            <input id="tab1" type="radio" name="tabs" {{ old('tab') != 'register' ? 'checked' : '' }} class="radio_hidden">
            <label for="tab1" class="head" style="width: 100%;"><span>Selamat Datang!</span></label>

            <input id="tab2" type="radio" name="tabs" {{ old('tab') == 'register' ? 'checked' : '' }} class="radio_hidden">
            <!-- <label for="tab2" class="head"><i class="fa fa-user-plus"></i><span>SIGN UP</span></label> -->

            <div class="contents">
                <section id="content1" class="tab-content">
                    <div class="bg"></div>
                    @include('auth.login')
                </section>

                <section id="content2" class="tab-content">
                    <div class="bg"></div>
                    @include('auth.register')
                </section>
            </div>
        </div>
        <div class="footer-bg"></div>
        <center>
            <label style="margin-top: 10px;color: #555;margin-bottom: 20px;">Dinas Cipta Tata Karya, Tata Ruang dan Pertanahan Jakarta<br>© 2017 - <?php echo date("Y");?></label>
        </center>
        @include('widgets.footer')
    </div>
    <!-- Scripts -->
    <script src="{{ asset('plugins/jquery/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>
</body>
</html>