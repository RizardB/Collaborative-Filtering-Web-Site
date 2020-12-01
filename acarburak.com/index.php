<!DOCTYPE html>
<html lang="tr">
<head>
<script data-ad-client="ca-pub-5320581972134082" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script data-ad-client="pub-5320581972134082" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-MPSGGGW');</script>
<!-- End Google Tag Manager -->
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-158319113-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-158319113-1');
</script>
<title>Film Öneri Sitesi</title>

<meta charset="utf-8">
<meta name="author" content="Burak Acar">
<meta name="description" content="Ortak Filtreleme Kullanarak Kullanıcıların Benzerliklerini Hesaplayıp Filmler İçin Tahmin Üretebilen Sistem">
<meta name="google-site-verification" content="KSaAO845iMKeauMAuE5cQ78BLTyznjfdoofOYgKgHws" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" type="image/x-icon" href="css/images/favicon.ico">
<link rel="stylesheet" href="css/style.css" type="text/css" media="all">
<link rel="stylesheet" href="css/colorbox.css" type="text/css" media="all">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style>
  #more {display: none;}
</style>
</head>
<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MPSGGGW"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<!-- wrapper -->
<div id="wrapper">
  <div class="light-bg">
    <!-- shell -->
    <div class="shell">
      <!-- header -->
      <div class="header">
        <!-- socials -->
        <!-- end of socials -->
        <h1 id="logo"><a href="index.php">FireFilm</a></h1>
        <!-- navigation -->
          <!-- post -->
          <?php 
            include("yeni.php");
            if(isset($_SESSION["login"])){
              include("benzerlik.php");
              //include("arama.php");
            }
          ?>
        
        <!-- end of sidebar -->
        <div class="cl">&nbsp;</div>
      </div>
      <!-- end of main -->
      <div class="footer">
        <p class="copy">Copyright &copy; 2020 <span>|</span> FireFilm Burak Acar</a></p>
      </div>
    </div>
    <!-- end of shell -->
  </div>
<!-- end of wrapper -->
</body>
</html>
