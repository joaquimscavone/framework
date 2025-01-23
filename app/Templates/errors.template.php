<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Not Found</title>
    <style>
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #1d3557, #457b9d);
            color: #f1faee;
            text-align: center;
        }

        .container {
            max-width: 600px;
        }

        h1 {
            font-size: 6rem;
            margin: 0;
        }

        p {
            font-size: 1.5rem;
            margin: 1rem 0;
        }

        a {
            display: inline-block;
            margin-top: 1.5rem;
            padding: 0.8rem 1.5rem;
            font-size: 1.2rem;
            color: #1d3557;
            background: #f1faee;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background: #a8dadc;
        }

        .illustration {
            font-size: 4rem;
            margin: 2rem 0;
        }
    </style>
</head>
<body>
    {{$VIEW}}
</body>
</html>
