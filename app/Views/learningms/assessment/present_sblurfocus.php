<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <h1>halo</h1>
</body>
</html>
<script src="<?= base_url() ?>assets/js/jquery.3.2.1.min.js"></script>
<script>


window.addEventListener('blur', function(){
   console.log('blur');
}, false);

window.addEventListener('focus', function(){
   console.log('focus');
}, false);
</script>