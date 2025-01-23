<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Paper Dashboard 2 by Creative Tim
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
    name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
  <!-- CSS Files -->
  <?= styles('bootstrap', 'paper-bootstrap') ?>
</head>

<body class="">
  <div class="wrapper">
    <!-- End Navbar -->
    <div class="content">
      {{$VIEW}}
    </div>
  </div>
  <?= scripts('jquery', 'popper', 'bootstrap', 'perfect-scrollbar', 'bootstrap-notify', 'dashboard') ?>
  <?=component('notify');?>
</body>

</html>