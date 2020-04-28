<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Error 500</title>
    <style>
        .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Error 500 - Internal Server Error</h1>
    <?php if (DEV_MODE && isset($error_msg)): ?>
        <h2 style="margin-top: 0"><?=$error_msg?></h2>
    <?php endif; ?>
</div>
</body>
</html>