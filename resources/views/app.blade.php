<!DOCTYPE html>
<html style='overflow: hidden;'>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@7.x/css/materialdesignicons.min.css" rel="stylesheet">
    <script src="{{ mix('/js/app.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <style>
      body{
      overflow-y: hidden !important;
      }
    </style>
    @inertiaHead
  </head>
  <body>
    @inertia
  </body>
</html>