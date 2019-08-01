<html>
<head>
    <style>
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            color: #B0BEC5;
            display: table;
            font-weight: 100;
        }

        .container {
            text-align: center;
            display: table-cell;
            vertical-align: middle;
        }

        .content {
            text-align: center;
            display: inline-block;
        }

        .title {
            font-size: 72px;
            margin-bottom: 40px;
        }

        p {
            font-size: 26px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="content">
        <p>You must use the application to generate this report. </p>
        <p> <a href="{{ route('dash') }}">Click here</a> to go back to application.</p>
    </div>
</div>
</body>
</html>
