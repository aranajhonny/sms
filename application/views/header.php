<?php defined('BASEPATH') or exit('No direct script access allowed');?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>NOUS SMS Api</title>

    <!-- Bootstrap core CSS -->
    <link href="https://sms.now.sh/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="https://sms.now.sh/justified-nav.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.css"/>

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
   <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.2.1/dt-1.10.16/datatables.min.js"></script>
    <script src="https://sms.now.sh/popper.min.js"></script>
    <script src="https://sms.now.sh/bootstrap.min.js"></script>

  </head>

  <body>

    <div class="container">

      <header class="masthead">
        <h3 class="text-muted">NOUS SMS - Beta</h3>

        <nav class="navbar navbar-expand-md navbar-light bg-light rounded mb-3">
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav text-md-center nav-justified w-100">
              <li class="nav-item">
                <a class="nav-link" href="<?php echo site_url() ?>">SMS enviados</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo site_url() . "/porenviar" ?>">SMS Por enviar</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo site_url() . "/planes" ?>">Planes</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo site_url() . "/notificar-pago" ?>">Notificar pago</a>
              </li>
              <li class="nav-item">
                <a class="nav-link">SMS Disponibles <span class="badge badge-primary"><strong><?php echo $mensajes; ?></strong></span>
</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $nombre . " "; ?></a>
                <div class="dropdown-menu" aria-labelledby="dropdown01">
                  <a class="dropdown-item" href="<?php echo site_url() ?>/token">Token de acceso</a>
                  <a class="dropdown-item" href="<?php echo site_url() ?>/perfil">Cambiar contraseña</a>
                  <a class="dropdown-item" href="<?php echo site_url() ?>/salir">Cerrar sesion</a>
                </div>
              </li>
            </ul>
          </div>
        </nav>
      </header>

      <main role="main">

