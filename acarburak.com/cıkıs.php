<?php
echo '<link rel="shortcut icon" type="image/x-icon" href="css/images/favicon.ico">';
    session_start();
    session_destroy();
    echo("Çıkış Yaptınız Anasayfaya Yönlendiriliyorsunuz");
    Echo '<meta http-equiv="refresh" content="0;URL=index.php"/>';
?>