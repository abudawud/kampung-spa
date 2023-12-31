<html>

<head>
    <style>
        html,
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0px;
        }

        div.header-right {
            text-align: right;
            margin: 30px;
        }

        .header-title {
            font-size: 20pt;
            font-weight: bold;
        }

        .header-subtitle {
            font-size: 10pt;
            color: gray;
        }

        header,
        footer {
            position: fixed;
            left: 0px;
            right: 0px;
        }

        .float-right {
            float: right;
        }

        .clearfix {
            clear: both;
        }

        header {
            width: 100%;
            height: 100px;
            background: url("{{ asset('assets/img/header.png') }}") no-repeat;
            background-size: contain;
        }

        footer {
            bottom: 0px;
            height: 50px;
            margin-bottom: -55px;
            border-top: 1px solid;
            color: gray;
            font-size: 10pt;
            padding-top: 5px;
            font-style: italic;
        }


        table.table-bordered,
        table.table-bordered td,
        th {
            border-collapse: collapse;
            border: 1px solid gray;
        }

        table.table-noborder,
        table.table-noborder td,
        th {
            border-collapse: collapse;
            border: 0px solid black;
        }

        table.table-lg,
        table.table-lg td,
        th {
            font-size: 1.1em;
        }


        .bg-primary {
            background-color: #f7b220;
            color: white;
        }

        .bg-orange {
            background-color: #fbebd9;
        }

        .bg-yellow {
            background-color: #ffff88;
        }

        .bg-gray {
            background-color: #eeeeee;
        }

        .br-1 {
            margin-bottom: 10px;
        }

        .text-left {
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-sm {
            font-size: 0.8em;
        }

        .text-gray {
            color: gray;
        }

        .text-bold {
            font-weight: bolder;
        }

        .border {
            border: 1px solid;
        }

        .checklist {
            background-image: url('{{ asset(' assets/img/check.png') }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }

        .page-break {
            page-break-after: always;
        }

        main {
            margin-top: 100px;
            padding: 20px 30px;
        }

        .font-sm {
            font-size: 0.8em;
        }

        .font-xs {
            font-size: 0.6em;
        }
    </style>
    @stack('css')
    @yield('css')
</head>

<body>
    <header>
        @include('pdf.partial.header-default')
    </header>
    <main>
        @yield('content')
    </main>
    <footer>
        @include('pdf.partial.footer-default')
    </footer>
</body>

</html>
