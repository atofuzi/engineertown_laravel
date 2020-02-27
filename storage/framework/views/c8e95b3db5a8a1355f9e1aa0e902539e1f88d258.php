<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
  <title>Title</title>
</head>
<body>
<h1>sample</h1>
<div id="app">
    <sample-component></sample-component>
</div>

<script src="<?php echo e(asset('/js/app.js')); ?>"></script>
</body>
</html><?php /**PATH /Applications/MAMP/htdocs/engineertown_laravel/resources/views/sample.blade.php ENDPATH**/ ?>