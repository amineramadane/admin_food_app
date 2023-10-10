<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- PWA  -->
    <meta name="theme-color" content="#6777ef"/>
    <link rel="apple-touch-icon" href="{{ asset('logo.png') }}">
    <link rel="manifest" href="{{ asset('/manifest.json') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ setting('app.name') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css" rel="stylesheet">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('style')

    @livewireStyles
</head>
<body>
    <style>
        .loader_page{
            position: fixed;
            display: absolute;
            height: 100%;
            width: 100%;
            min-width: 100vw;
            min-height: 100vh;
            background-color: red;
            z-index: 99999999999999;
            top: 0;
            left: 0;
            background-color: #A9C9FF;
            background-image: linear-gradient(180deg, #A9C9FF 0%, #FFBBEC 100%);
            overflow: hidden;
            padding-top: 20%;
            padding-left: 45%;
        }
    </style>
    <div id="loader" class="loader_page">
        <span>
            <svg xmlns="http://www.w3.org/2000/svg" version="1.0" width="150" height="150" viewBox="0 0 360.000000 360.000000" preserveAspectRatio="xMidYMid meet">
                <g transform="translate(0.000000,360.000000) scale(0.100000,-0.100000)" fill="#f7134b" stroke="none">
                <path d="M1655 3294 c-475 -51 -891 -300 -1151 -689 -118 -177 -189 -348 -235 -565 -31 -143 -33 -426 -5 -575 60 -324 201 -592 435 -826 182 -181 357 -292 590 -373 189 -66 280 -80 511 -80 231 0 322 14 511 80 233 81 408 192 590 373 234 234 375 502 435 826 28 149 26 432 -5 575 -46 217 -117 388 -235 565 -234 349 -588 584 -1002 665 -106 21 -346 34 -439 24z m1068 -628 c74 -78 91 -117 93 -211 2 -77 4 -83 47 -150 25 -38 54 -81 64 -95 10 -14 18 -29 18 -35 1 -5 15 -46 32 -90 90 -231 114 -483 67 -715 -108 -534 -490 -917 -1027 -1032 -130 -27 -353 -30 -467 -4 -261 58 -467 173 -653 365 -181 187 -286 385 -343 646 -26 120 -24 379 4 505 41 188 98 323 202 479 130 194 416 430 507 419 22 -3 13 -11 -63 -63 -165 -111 -333 -302 -422 -481 -43 -86 -99 -250 -117 -346 -89 -467 77 -935 425 -1197 406 -306 993 -307 1397 -2 234 176 408 481 454 791 16 115 6 352 -19 450 -36 135 -90 262 -139 328 -31 41 -70 61 -145 73 -68 11 -143 45 -174 81 -26 27 -246 343 -263 376 -14 27 2 30 21 3 7 -10 69 -80 137 -154 114 -125 151 -159 151 -139 0 4 -61 86 -135 181 -74 96 -133 177 -130 180 7 7 35 -22 175 -178 116 -129 150 -162 150 -143 0 4 -58 82 -128 173 -145 187 -147 189 -134 189 6 0 43 -37 82 -82 90 -103 222 -240 226 -235 6 6 -81 129 -170 241 -77 98 -95 126 -82 126 3 0 64 -66 137 -147 73 -82 144 -157 158 -168 l25 -19 -20 33 c-10 18 -67 98 -126 177 -60 79 -108 147 -108 151 0 7 221 -204 293 -281z m-1039 -68 c52 -19 62 -20 124 -9 78 15 104 8 167 -43 35 -29 48 -34 93 -34 74 0 134 -39 176 -112 26 -47 31 -65 31 -127 1 -61 4 -76 24 -97 28 -29 38 -95 21 -135 -19 -47 -54 -64 -127 -63 l-63 1 0 -44 c0 -53 5 -52 -126 -23 -134 29 -425 32 -522 5 -34 -10 -67 -15 -72 -12 -6 3 -10 27 -10 53 0 57 -4 64 -55 90 -86 43 -122 114 -116 224 2 39 54 94 109 114 59 22 53 15 63 71 12 64 49 116 101 142 55 27 111 27 182 -1z m-153 -817 c61 -39 104 -87 131 -146 32 -71 32 -205 -1 -288 -13 -32 -28 -56 -34 -54 -20 6 -100 167 -124 247 l-22 75 0 -47 c-2 -144 103 -304 254 -384 l57 -31 -49 -12 c-116 -29 -219 -103 -267 -191 -15 -30 -10 -26 35 22 52 55 149 128 171 128 20 0 1 -114 -27 -171 -50 -100 -149 -172 -267 -194 l-36 -7 -4 49 c-6 68 9 147 36 202 45 88 146 161 249 180 l42 8 -44 12 c-78 22 -215 16 -306 -13 -66 -21 -185 -86 -185 -100 0 -2 35 11 78 30 76 33 218 71 228 61 6 -6 -31 -81 -60 -120 -29 -40 -112 -92 -175 -111 -54 -16 -194 -22 -238 -10 -30 8 -29 27 6 99 49 104 143 179 266 211 56 15 187 18 253 5 l44 -9 -44 47 c-83 86 -118 174 -118 298 0 109 49 243 89 243 9 0 37 -13 62 -29z m562 -94 c39 -81 50 -138 44 -234 -4 -71 -11 -97 -41 -158 -20 -40 -53 -88 -74 -107 l-39 -35 119 5 c94 4 132 1 184 -13 75 -20 170 -79 208 -130 31 -40 76 -133 76 -156 0 -20 -39 -29 -129 -29 -158 0 -285 71 -347 192 -13 26 -24 50 -24 54 0 20 183 -32 269 -75 59 -31 60 -22 2 17 -100 69 -259 111 -365 98 -126 -16 -149 -28 -75 -40 93 -15 188 -87 236 -179 24 -45 27 -64 28 -147 l0 -95 -35 3 c-19 2 -67 19 -107 38 -76 37 -122 82 -162 161 -22 44 -44 153 -32 165 12 13 128 -70 182 -130 40 -44 47 -49 33 -23 -53 94 -141 159 -259 192 l-60 16 65 33 c144 73 250 236 249 385 0 36 -3 32 -28 -45 -28 -85 -62 -159 -99 -214 l-20 -28 -15 23 c-30 47 -50 139 -45 213 8 121 69 215 175 270 26 14 51 25 54 26 3 0 17 -24 32 -53z"/>
                <path d="M1524 2571 c-65 -30 -89 -72 -89 -156 0 -38 4 -81 9 -95 8 -23 7 -23 -28 8 -41 36 -55 38 -95 17 -30 -15 -61 -77 -61 -118 1 -35 35 -102 65 -125 30 -24 74 -28 107 -11 18 10 20 17 14 65 -3 30 -4 54 -1 54 3 0 11 -15 19 -34 19 -44 48 -60 103 -53 58 6 75 24 81 86 l4 50 22 -41 c32 -61 65 -81 140 -86 68 -4 94 5 169 59 51 37 60 29 18 -15 -38 -39 -35 -51 12 -61 46 -10 88 -34 118 -66 23 -25 35 -29 77 -29 43 0 54 4 71 26 36 45 26 81 -41 150 -38 39 -39 42 -17 47 19 5 21 11 17 49 -12 103 -72 168 -162 176 -37 3 -62 -1 -85 -13 -38 -19 -47 -15 -30 14 12 17 10 23 -10 45 -68 72 -165 54 -234 -44 l-17 -25 6 46 c5 43 4 48 -24 68 -44 31 -108 36 -158 12z"/>
                <path d="M1650 2105 c-8 -2 -49 -9 -90 -15 -78 -13 -130 -33 -130 -51 0 -6 15 -7 38 -4 l37 6 -40 -23 c-39 -23 -52 -46 -42 -72 4 -11 17 -10 69 1 135 31 439 17 570 -27 17 -5 30 -5 34 1 9 15 -14 37 -47 44 -47 10 -43 23 6 17 39 -4 45 -2 45 14 0 69 -94 101 -320 109 -63 2 -122 2 -130 0z"/>
                </g>
            </svg>
        </span>
    </div>
    @yield('content')

    <script>
        document.onreadystatechange = function () {
			if (document.readyState !== "complete") {
				document.querySelector("#loader").style.visibility = "visible";
			} else {
				document.querySelector("#loader").style.display = "none";
			}
		};
    </script>

    <script type="text/javascript">
        window.appLocale = "{{config('app.locale')}}";
    </script>

    @if(setting('auth.recaptcha') && setting('auth.recaptcha_key'))
        <script src='https://www.google.com/recaptcha/api.js'></script>
    @endif
    <script src="{{ asset('js/topbar.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    

    @yield('script')
    @stack('script')
    @livewireScripts
    <script src="{{ asset('js/livewire-sortable.js') }}"></script>
    <script src="{{ asset('/sw.js') }}"></script>
    <script>
        if (!navigator?.serviceWorker?.controller) {
            navigator?.serviceWorker?.register("/sw.js")?.then(function (reg) {
                console.log("Service worker has been registered for scope: " + reg.scope);
            });
        }
    </script>
</body>
</html>
