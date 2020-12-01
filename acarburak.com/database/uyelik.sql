-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: sql211.epizy.com
-- Üretim Zamanı: 08 Kas 2020, 12:12:17
-- Sunucu sürümü: 5.6.48-88.0
-- PHP Sürümü: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `epiz_25054667_uyelik`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `uyeler`
--

CREATE TABLE `uyeler` (
  `kullanici_adi` varchar(30) COLLATE utf8mb4_turkish_ci NOT NULL,
  `sifre` varchar(30) COLLATE utf8mb4_turkish_ci NOT NULL,
  `dogum_tarihi` date NOT NULL,
  `eposta` varchar(50) COLLATE utf8mb4_turkish_ci NOT NULL,
  `cinsiyet` varchar(5) COLLATE utf8mb4_turkish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `uyeler`
--

INSERT INTO `uyeler` (`kullanici_adi`, `sifre`, `dogum_tarihi`, `eposta`, `cinsiyet`) VALUES
('bon_jovi_chick', 'bon_jovi_chick', '1995-01-01', 'bon_jovi_chick@hotmail.com', 'erkek'),
('Burak', 'burak', '1997-11-15', 'burak@hotmail.com', 'erkek'),
('Hub', 'hub', '2020-02-14', 'hub@hotmail.com', 'erkek'),
('emre', '123', '1980-01-01', 'eyalcin@cumhuriyet.edu.tr', 'erkek'),
('Esra', '1250', '1993-08-18', 'esra@gmail.com', 'kadın'),
('LaLaLandSuck', 'LaLaLandSuck', '2000-02-02', 'lalalandsuck@hotmail.com', 'kadın'),
('louwburger', 'louwburger', '1990-10-10', 'louwburger@hotmail.com', 'erkek'),
('mhmt_korkmaz', 'mhmt_korkmaz', '1980-12-12', 'mhmt_korkmaz@hotmail.com', 'erkek'),
('miguelneto', 'miguelneto', '1970-05-05', 'miguelneto@hotmail.com', 'erkek'),
('muçoo', 'muço', '1997-01-02', 'muco@gmail.com', 'erkek'),
('Rizard', 'rizard', '1997-11-15', 'rizard@hotmail.com', 'erkek'),
('azatduman47', '000000', '1998-07-27', 'azat@gmail.com', 'erkek'),
('rdvaanyldz', '0000000', '1997-12-03', 'ridvan@gmail.com', 'erkek');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `uyeler`
--
ALTER TABLE `uyeler`
  ADD UNIQUE KEY `eposta` (`eposta`,`kullanici_adi`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
