<?php
session_start();


try{
    $dbBaglanti=new PDO("mysql:host=localhost;dbname=film","root","");
    $dbBaglanti->exec("SET NAMES 'utf8'; SET CHARSET 'utf8'");
} catch(PDOException $e){
    print $e->getMessage();
}
            $outputString='';
            $filt='';
            $dbfilt='';

            $url = $_SERVER['REQUEST_URI'];
            if(strstr($url,"aksiyon")){
                $filt="aksiyon/";
                $dbfilt="aksiyon";
            }
            if(strstr($url,"komedi")){
                $filt="komedi/";
                $dbfilt="komedi";
            }
            if(strstr($url,"bilim-kurgu")){
                $filt="bilim-kurgu/";
                $dbfilt="bilim kurgu";
            }
            if(strstr($url,"tarih")){
                $filt="tarih/";
                $dbfilt="tarih";
            }
            if(strstr($url,"dram")){
                $filt="dram/";
                $dbfilt="dram";
            }
            if(strstr($url,"animasyon")){
                $filt="animasyon/";
                $dbfilt="animasyon";
            }
            if(strstr($url,"savas")){
                $filt="savas/";
                $dbfilt="savaş";
            }
            if(strstr($url,"yerli")){
                $filt="yerli/";
                $dbfilt="yerli";
            }
            if(strstr($url,"gerilim")){
                $filt="gerilim/";
                $dbfilt="gerilim";
            }
            if(strstr($url,"suc")){
                $filt="suc/";
                $dbfilt="suç";
            }
            if(strstr($url,"fantastik")){
                $filt="fantastik/";
                $dbfilt="fantastik";
            }
            if(strstr($url,"korku")){
                $filt="korku/";
                $dbfilt="korku";
            }
            if(strstr($url,"macera")){
                $filt="macera/";
                $dbfilt="macera";
            }
            if(strstr($url,"polisiye")){
                $filt="polisiye/";
                $dbfilt="polisiye";
            }
            if(strstr($url,"psikolojik")){
                $filt="psikolojik/";
                $dbfilt="psikolojik";
            }
            if(strstr($url,"romantik")){
                $filt="romantik/";
                $dbfilt="romantik";
            }
            $query=$dbBaglanti->query("SELECT * FROM movie WHERE film_tur LIKE '%$dbfilt%' " , PDO::FETCH_ASSOC);
            $toplam_icerik=$query->rowCount();

            $sayfada=5;

            $toplam_sayfa=ceil($toplam_icerik/$sayfada);

            $topon=isset($_GET['topon']) ? (int) $_GET['topon']:1;

            $sayfa=isset($_GET['filmler/'.$filt.'sayfa']) ? (int) $_GET['filmler/'.$filt.'sayfa']:1;

            if($sayfa < 1) $sayfa = 1;
            if($sayfa > $toplam_sayfa) $sayfa = $toplam_sayfa;
            
            if(strstr($url,"topon")){
                $query=$dbBaglanti->prepare("SELECT * FROM movie ORDER BY puan desc LIMIT 0,10");
                $query->execute();
                $toplam_sayfa=0;
            }else{
                $limit = ($sayfa - 1) * $sayfada;
                $query = $dbBaglanti->query('SELECT * FROM movie WHERE film_tur LIKE "%'.$dbfilt.'%" ORDER BY film_tarih DESC LIMIT ' . $limit . ',' . $sayfada );
            }
            echo '
                <nav id="navigation">
            <ul>
                <li><a href="?/topon/" >TOP 10</a></li>';
            if(!isset($_SESSION["login"])){
                echo '     
                <li> <a href="giris.html">Giriş</a></li>
                <li> <a href="uye_ol.html">Üye Ol</a></li>
                <p id="demo"></p>
            </ul>
            </nav>
            <!-- end of navigation -->
            <div class="cl">&nbsp;</div>
            </div>
            <div class="main">
                <section class="content">';
            }else{
                $kad=$_SESSION["uname"];
                echo '     
                <li> <a href="#">'.$_SESSION["uname"].'</a></li>
                <li> <a href="cıkıs.php">Çıkış</a></li>
                <p id="demo"></p>
            </ul>
            </nav>
            <!-- end of navigation -->
            <div class="cl">&nbsp;</div>
            </div>
            <div class="main">
                <section class="content">';
            }  
            
            
            if($query->rowCount()){
                foreach($query as $row){ 
                    $film_id=$row["film_id"];
                    $film_adi=$row["film_adi"];
                    $film_konu=$row["film_konu"];
                    $film_tarih=$row["film_tarih"];
                    $film_tur=$row["film_tur"];
                    $puan=$row["puan"];
                    $puanlama_sayisi=$row["puanlama_sayisi"];
                    echo '
                    <div class="post">
                        <!-- post-inner -->
                        <div class="post-inner">
                            <h2><a href="#">'.$film_adi.'</a></h2>
                            <p class="tags"><a href="#"> '.$film_tur.' </a> </p>
                            <div class="cl">&nbsp;</div>
                        </header>
                        <div class="img-holder">
                        <a href="#"><img src="css/images/'.$film_id.'.png" alt=""></a>
                        
                    </div>';
                    if(isset($_SESSION["login"])){
                        $puanuyevarmi=$dbBaglanti->prepare("SELECT puan, COUNT(puan) AS pupp FROM puanuye WHERE kullanici_adi=? AND film_id=?");
                        $puanuyevarmi->execute(array($kad,$film_id));
                        foreach($puanuyevarmi as $row){
                            $puanlamavarsa=$row["puan"];
                            $pupp=$row["pupp"];
                        }
                        if($pupp>0){
                            echo '<p class="puanlanmis">Verdiğiniz Puan: '.$puanlamavarsa.'</p>';
                        }else{
                        echo '<form action="puanekle.php" id="ratingForm" method="POST">
                                <div class="puanver">
                                    <input type="radio" name ="star" id="star" value ="1">1 
                                    <input type="radio" name ="star" id="star" value ="2">2 
                                    <input type="radio" name ="star" id="star" value ="3" checked>3 
                                    <input type="radio" name ="star" id="star" value ="4">4 
                                    <input type="radio" name ="star" id="star" value ="5">5 
                                    <input type="hidden" name ="rated" id="filmid" value="'.$film_id.'">
                                    <input type="submit" name="submit" id="submit" value="Puanla">
                                </div>
                            </form>';
                        }
                    }else{
                        echo '<form action="puanekle.php" id="ratingForm" method="POST">
                                <div class="puanver">
                                    <input type="radio" name ="star" id="star" value ="1">1 
                                    <input type="radio" name ="star" id="star" value ="2">2 
                                    <input type="radio" name ="star" id="star" value ="3" checked>3 
                                    <input type="radio" name ="star" id="star" value ="4">4 
                                    <input type="radio" name ="star" id="star" value ="5">5 
                                    <input type="hidden" name ="rated" id="filmid" value="'.$film_id.'">
                                    <input type="submit" name="submit" id="submit" value="Puanla">
                                </div>
                            </form>';
                    }
                        echo '<!-- meta -->
                        <div class="meta">
                            <p class="date">'.$film_tarih.'</p>
                            <div class="right">
                                <div class="rating-holder">
                                    <p>ORTALAMA</p>';
                                    if(!isset($_SESSION["login"])){
                                        echo '<div class="rating"><span style="width:'. $puan*20 .'%;"></span> </div>';
                                        
                                    }else{
                                        
                                        $kad=$_SESSION["uname"];
                                        //$x=100;
                                        $bosss=$dbBaglanti->prepare("SELECT COUNT(*) AS sayisi FROM puanuye where kullanici_adi=?");
                                        $bosss->execute(array($kad));
                                        foreach ($bosss as $row) {
                                            $oylama_sayisi=$row["sayisi"];
                                        }
                                        $boss=$dbBaglanti->query("SELECT puan FROM puanuye where kullanici_adi='{$kad}' and film_id='{$film_id}'")->fetch(PDO::FETCH_ASSOC);
                                        if($boss==0 && $oylama_sayisi>0){
                                            include("tahminpuan.php");
                                            echo '<div class="rating"><span style="width:'. $puan*20 .'%;"></span></div>';
                                            if($tahmin_alt==0){
                                                echo '<br><p class="tahmin">Şuan bu film için size bir tahminimiz yok.</p> <br> <p class="tahmin">Puanlama yaparak tahmin alabilirsiniz.<p>';
                                            }else{
                                                echo '<br><p class="tahmin">Bu film için size önerimiz: '.$tahmin.'</p>';
                                            }
                                            
                                            
                                            //echo '<div class="rating"><span style="width:100%;">Tahmini Puan'.$top_sonuc.'</span></div>';
                                        }else if ($boss==0 && $boss==0){
                                            echo '<div class="rating"><span style="width:'. $puan*20 .'%;"></span></div>';
                                            echo '<br><p class="tahmin">Şuan sizin için bir tahminimiz yok.</p> <br> <p class="tahmin">Puanlama yaparak tahmin alabilirsiniz.<p>';
                                        }
                                        else{
                                            echo '<div class="rating"><span style="width:'. $puan*20 .'%;"></span></div>';
                                        }
                                        
                                    }
                                echo '</div>
                            </div>
                            <div class="cl">&nbsp;</div>
                        </div>
                        <!-- end of meta -->
                        <!-- post-cnt -->
                        <div class="post-cnt">
                            <p>'.$film_konu.'</p>
                        </div>
                        <!-- post-inner -->
                    </div>
                    ';
                }
            }
            //echo $outputString;

            //<li> <a href="?filmler/'.$filt.'sayfa=' . $s . '">' . $s . '</a> </li>
            
            if(isset($_GET['filmler/'.$filt.'sayfa'])){
                $pageno=$_GET['filmler/'.$filt.'sayfa'];
            }else{
                $pageno=1;
            }
                    echo '
                    <div class="pagination">
                    <ul>';
                        
                        
                        for($s = 1; $s <= $toplam_sayfa; $s++) {
                            if($s==$pageno){
                                echo '<li class="active"><a href="#">'.$pageno.'</a></li>';
                            }else{
                                echo '<li> <a href="?filmler/'.$filt.'sayfa=' . $s . '">' . $s . '</a> </li>'; 
                            }                             
                        }
                        echo'
                    </ul>
                    </div>';
                
                
            
            
        echo '
            </section>
            <aside class="sidebar">
              <div class="widget">
                <h3 class="widgettitle">Türler</h3>
                <ul>
                  <li><a href="?/filmler/aksiyon">Aksiyon</a></li>
                  <li><a href="?/filmler/komedi">Komedi</a></li>
                  <li><a href="?/filmler/bilim-kurgu">Bilim Kurgu</a></li>
                  <li><a href="?/filmler/tarih">Tarih</a></li>
                  <li><a href="?/filmler/dram">Dram</a></li>
                  <li><a href="?/filmler/animasyon">Animasyon</a></li>
                  <li><a href="?/filmler/savas/">Savaş</a></li>
                  <li><a href="?/filmler/yerli/">Yerli Filmler</a></li>
                  <li><a href="?/filmler/gerilim/">Gerilim</a></li>
                  <li><a href="?/filmler/suc/">Suç</a></li>
                  <li><a href="?/filmler/fantastik/">Fantastik</a></li>
                  <li><a href="?/filmler/korku/">Korku</a></li>
                  <li><a href="?/filmler/macera/">Macera </a></li>
                  <li><a href="?/filmler/polisiye/">Polisiye </a></li>
                  <li><a href="?/filmler/psikolojik/">Psikolojik </a></li>
                  <li><a href="?/filmler/romantik/">Romantik </a></li>
                </ul>
              </div>
            </aside>
            ';   
            
?>