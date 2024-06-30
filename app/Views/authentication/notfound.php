<!DOCTYPE html>
<html lang="id" dir="ltr">

<head>
     <meta charset="utf-8" />
     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
     <meta name="description" content="" />
     <meta name="author" content="" />

     <!-- Title -->
     <title>Maaf, Halaman tidak ditemukan!</title>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous" />
</head>

<body class="bg-dark text-white py-5">
     <div class="container py-5 px-5">
          <div class="row d-flex justify-content-center py-5">
               <div class="col-md-2 text-center">
                    <p><i class="fa fa-exclamation-triangle fa-5x"></i><br/>Code: 404</p>
               </div>
               <div class="col-md-10">
                    <h3>OPPSSS!!!! Maaf...</h3>
                    <p>Maaf, halaman yang anda kunjungi tidak ditemukan.<br/>Silahkan kembail untuk melajutkan aktifitas anda.</p>
                    <a class="btn btn-danger" href="<?= base_url('/home/dashboard') ?>">Kembali</a>
                    <a class="btn btn-info" href="<?= base_url('/logout') ?>">Logout</a>
               </div>
          </div>
     </div>
</body>

</html>