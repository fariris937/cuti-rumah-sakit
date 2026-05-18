<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Document')</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 10px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 6px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    @yield('content')
</body>
</html>
