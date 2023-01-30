<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Error 404</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      overflow: hidden;
      font-family: 'Roboto', sans-serif;
    }
    .wrapper {
      width: 100vw;
      height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }
    .text {
      font-size: 30px;
      user-select: none;
      margin-bottom: 15px;
      opacity: 0.6;
    }
    a {
      opacity: 0.7;
    }
    a:hover {
      color:blue;
    }
  </style>
</head>
<body>
  <div class="wrapper">
    <div class="text">404 | Page Not Found</div>
    <div><a href="{{url('/')}}">go home</a></div>
  </div>
</body>
</html>