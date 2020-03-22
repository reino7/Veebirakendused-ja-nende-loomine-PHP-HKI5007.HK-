-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 22, 2020 at 04:47 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `reinoristissaar`
--

-- --------------------------------------------------------

--
-- Table structure for table `vr20_news`
--

CREATE TABLE `vr20_news` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` varchar(1500) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `deleted` datetime DEFAULT NULL,
  `picture` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vr20_news`
--

INSERT INTO `vr20_news` (`id`, `userid`, `title`, `content`, `created`, `deleted`, `picture`) VALUES
(1, 1, 'Testpealkiri', 'Test uudise sisu', '2020-02-27 12:38:26', NULL, NULL),
(2, 1, 'Testpealkiri2', 'Test uudise sisu2', '2020-02-27 12:39:08', NULL, NULL),
(3, 1, 'Testpealkiri3', 'Test uudise sisu3', '2020-02-27 12:52:51', NULL, NULL),
(5, 1, 'Lorem Ipsum – Generator, Origins and Meaning', 'Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print, graphic or web designs. The passage is attributed to an unknown typesetter in the 15th century who is thought to have scrambled parts of Cicero\'s De Finibus Bonorum et Malorum for use in a type specimen book.', '2020-02-27 13:20:47', NULL, NULL),
(6, 1, 'NASA missioon Marsile paljastas punase planeedi kohta nii mõndagi uut', '&quot;Esmakordselt oleme me teaduslikult tõestanud, et Marss on seismiliselt aktiivne planeet,&quot; kommenteeris avastusi InSighti teadusvalla juht Bruce Barnerdt. Esimene marsivärin tuvastati planeedil ametlikult eelmise aasta aprillikuus.\r\n\r\nSellest ajast on registreeritud kokku üle 450 värina, millest valdav osa on oluliselt väiksema magnituudiga, kui Maal esinevad värinad. Samas on vähemalt kaks neist olnud nii võimsad, et teadlased on suutnud nende lähtekoha paika panna - selleks on Cerberus Fossae nime kandev seismiliselt aktiivne ala planeedi pinnal.', '2020-02-27 13:48:43', NULL, NULL),
(7, 1, 'Maailma suuruselt teise Wikipedia koostas peamiselt üks autor, kes pole isegi inimene', 'Vabatahtlike tööna valmiva veebientsüklopeedia Wikipedia eesmärk on levitada veebis teadmisi nii laialdaselt ja nii paljudes keeltes kui võimalik.\r\n\r\nSeni on tõesti suureks kasvanud eelkõige ingliskeelne variant, mis sisaldab hiljutise seisuga juba üle kuue miljoni artikli. Erikeelseid variante on kokku 309, vähemalt miljonit artiklit sisaldavad neist 16.', '2020-02-27 16:02:44', NULL, NULL),
(8, 1, 'Mainekas ühendus otsustas: just see on eelmise aasta parim nutitelefon', 'Kokku kandideeris sellele aule neli telefoni. Huawei P30 Pro, Apple\'i iPhone 11 Pro, OnePlusi 7T Pro ja Samsungi volditav telefon Galaxy Fold. Mõnevõrra üllatuslikult noppis hiidude seast võidu OnePlus. Kohtunike sõnul avaldas neile telefoni puhul enim muljet selle tehniline võimekus - protsessori töökiirus, kiire laadimine ning hea tarkvara. Samuti kiideti OnePlusi uusima seadme head ja konkurentsivõimelist hinda.', '2020-02-27 16:04:15', NULL, NULL),
(9, 1, 'Smart-ID kasutajaks saab nüüd biomeetrilise passiga', 'SK ID Solutions lõi Smart-ID jaoks uue biomeetrilise registreerimisviisi, mis võimaldab neil, kellel pole muid elektroonilisi autentimisvahendeid, luua Smart-ID pangakontorit külastamata.\r\n\r\nSelle tulemusel saavad kasutajad turvalise e-identiteedi, mis laseb end autentida ja anda käsitsi kirjutatud allkirjadega samaväärseid e-allkirju.\r\n\r\nKui siiani sai Smart-ID luua pangakontoris, Mobiil-ID või ID-kaardi abil, siis nüüd lisandub biomeetrilise identiteedi kontrollimise võimalus.\r\n\r\nUus identifitseerimismeetod läbis rahvusvahelise auditi ja selle on heaks kiitnud Riigi Infosüsteemi Amet.', '2020-02-27 16:05:36', NULL, NULL),
(10, 1, 'Uus lahendus võimaldab õhust elektrit toota', 'Uus seadeldis sai nimeks Air-Gen ja sisaldab looduslikest valkudest loodud elektrit juhtivat nanotraadistikku. Traati valmistab Geobacter-i nimeline bakter. Valkudest koosnev traadistik ühendab süsteemis paiknevaid elektroode nii, et elektrivool tekib õhus olevast õhuniiskusest.\r\n\r\n&quot;Me oleme võimelised tootma elektrit lihtsalt õhust,&quot; on üks uue süsteemi loonud elektriinsener Jun Yao oma leiutise üle uhke. &quot;Air-Gen toodab puhast elektrit 24 tundi päevas, seitse päeva nädalas. See on siiani kindlasti kõige põnevam lahendus, kus nanotraadistikke kunagi kasutatud on,&quot; arvab ta.', '2020-02-27 16:07:23', NULL, NULL),
(11, 1, 'Üle-euroopalisest uuest trendist võidavad tublisti ka Eesti korteriomanikud', 'Eesti Korteriühistute Liidu (EKÜL) juhatuse esimees Andres Jaadla kirjutab liidu ajakirjas Elamu, et Euroopas on algamas renoveerimislaine, millest tõuseb kasu ka Eestile.\r\n\r\n„Mullu aasta lõpul esitletud Euroopa roheleppe üheks olulisemaks prioriteediks saab üle-euroopaline hoonete renoveerimise programm, mille eesmärk on tõsta nende energiatõhusust,“ vahendas Jaadla, kes kuulub ka Euroopa elamuorganisatsiooni Housing Europe’i juhatusse.\r\n\r\nJaadla sõnul rõhutatakse kokkuleppes vajadust tagada ühest küljest eluasemete energiatõhusus ja teisalt taskukohasus. „Ollakse veendumusel, et renoveerimine kahandab energiaarveid ja vähendab kütteostuvõimetust, samuti elavdab ehitussektorit ning annab võimaluse toetada ettevõtlust ja luua kohalikke töökohti.“', '2020-02-27 16:09:02', NULL, NULL),
(12, 1, 'Kuidas turvaliselt veebi teel õppida ja töötada', 'Ajal, kui koroonaviiruse leviku piiramiseks on koolid suletud ja õpilased kodutööl ning tööandjad suunanud võimalikult palju töötajaid kaugtööle, võib tekkida kiusatus vaadata mööda elementaarsetest küberturvalisuse soovitustest, sest elukorraldus on hetkel niigi keerukas.\r\n\r\nMida rohkem me veebi teel (õppe)tööd teeme, seda enam on vaja hoolitseda selle eest, et seadmed ja süsteemid oleksid töökorras ning andmed võõraste eest kaitstud.\r\n\r\nNii nagu me ühiskonnana oleme järjest paremini saanud aru käte pesemise olulisusest, tuleks sarnaselt suhtuda ka küberhügieeni.\r\n\r\nEttevaatlikkus e-kirjadega, uuendatud tarkvara ja viirusetõrjega seadmed, pikad paroolid ja mitmefaktoriline autentimine ning korrapärane varundus aitavad sul kodust arvutiga tööd tehes vähem muretseda. Lisaks ei maksa nende põhimõtete jälgimine sulle peaaegu midagi, küberhügieenist mitte kinnipidamine võib aga rahakotile üpris kulukaks osutuda.', '2020-03-18 23:16:32', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vr20_studylog`
--

CREATE TABLE `vr20_studylog` (
  `id` int(11) NOT NULL,
  `course` varchar(20) NOT NULL,
  `activity` varchar(20) NOT NULL,
  `studytime` float NOT NULL,
  `dayadded` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vr20_studylog`
--

INSERT INTO `vr20_studylog` (`id`, `course`, `activity`, `studytime`, `dayadded`) VALUES
(7, '1', '1', 2, '2020-03-21 23:24:12'),
(8, '4', '2', 24, '2020-03-21 23:24:45'),
(9, '3', '3', 2, '2020-03-21 23:24:58'),
(10, '2', '4', 4, '2020-03-21 23:27:27'),
(11, '1', '1', 0.5, '2020-03-22 00:59:52'),
(12, '4', '2', 0.25, '2020-03-22 01:03:44'),
(13, '5', '3', 0.5, '2020-03-22 01:03:52'),
(14, '1', '4', 0.75, '2020-03-22 01:03:59'),
(15, '3', '4', 20.75, '2020-03-22 01:10:52'),
(16, '1', 'teamwork', 8.25, '2020-03-22 14:52:53'),
(17, '1', '1', 23.75, '2020-03-22 16:49:47'),
(18, '5', '4', 3.5, '2020-03-22 17:10:37'),
(19, '6', '4', 1.75, '2020-03-22 17:36:05'),
(20, '6', '5', 5.25, '2020-03-22 17:41:16');

-- --------------------------------------------------------

--
-- Table structure for table `vr20_studylog_activities`
--

CREATE TABLE `vr20_studylog_activities` (
  `ActivityID` int(11) NOT NULL,
  `ActivityName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vr20_studylog_activities`
--

INSERT INTO `vr20_studylog_activities` (`ActivityID`, `ActivityName`) VALUES
(1, 'Iseseisev materjali omandamine'),
(2, 'Koduste ülesannete lahendamine'),
(3, 'Kordamine'),
(4, 'Rühmatöö'),
(5, 'E-õpe');

-- --------------------------------------------------------

--
-- Table structure for table `vr20_studylog_courses`
--

CREATE TABLE `vr20_studylog_courses` (
  `CourseID` int(11) NOT NULL,
  `CourseName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vr20_studylog_courses`
--

INSERT INTO `vr20_studylog_courses` (`CourseID`, `CourseName`) VALUES
(1, 'Multimeediumi praktika (HKI5068.HK)'),
(2, 'Veebirakendused ja nende loomine (HKI5096.HK)'),
(3, 'Andmeturve (HKI6010.HK)'),
(4, 'Mobiilirakenduste arendamine (HKI5061.HK)'),
(5, 'Digitaalne helikujundus (HKI5066.HK)'),
(6, 'Seltskonnatants');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `vr20_news`
--
ALTER TABLE `vr20_news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vr20_studylog`
--
ALTER TABLE `vr20_studylog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vr20_studylog_activities`
--
ALTER TABLE `vr20_studylog_activities`
  ADD PRIMARY KEY (`ActivityID`);

--
-- Indexes for table `vr20_studylog_courses`
--
ALTER TABLE `vr20_studylog_courses`
  ADD PRIMARY KEY (`CourseID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `vr20_news`
--
ALTER TABLE `vr20_news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `vr20_studylog`
--
ALTER TABLE `vr20_studylog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `vr20_studylog_activities`
--
ALTER TABLE `vr20_studylog_activities`
  MODIFY `ActivityID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `vr20_studylog_courses`
--
ALTER TABLE `vr20_studylog_courses`
  MODIFY `CourseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
