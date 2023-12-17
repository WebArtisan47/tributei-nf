<!DOCTYPE html>
<html style='overflow: hidden;'>

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
  <link href="{{ mix('/css/app.css') }}" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/@mdi/font@7.x/css/materialdesignicons.min.css" rel="stylesheet">
  <script src="{{ mix('/js/app.js') }}" defer></script>
  <link rel="icon" type="image/x-icon" href="favicon.ico">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700&family=Roboto:wght@100&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="js/scripts.js"></script>
  <style>
    body {
      overflow-y: hidden !important;
    }
  </style>
  @inertiaHead
</head>

<body>
  @inertia
</body>

</html>