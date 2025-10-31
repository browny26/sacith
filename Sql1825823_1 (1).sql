-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 31.11.39.184:3306
-- Creato il: Set 29, 2025 alle 16:39
-- Versione del server: 8.0.36-28
-- Versione PHP: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Sql1825823_1`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `CodiceConfigurazioneComplessa`
--

CREATE TABLE `CodiceConfigurazioneComplessa` (
  `id` int NOT NULL,
  `prodottoRiga1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `prodottoRiga2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `prodottoRiga3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `codice_univoco` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `CodiceConfigurazioneComplessa`
--

INSERT INTO `CodiceConfigurazioneComplessa` (`id`, `prodottoRiga1`, `prodottoRiga2`, `prodottoRiga3`, `codice_univoco`) VALUES
(30, 'Chrome Sphere', 'Chrome Insert for Sphere', NULL, '1'),
(31, 'White Sphere', 'Chrome Insert for Sphere', NULL, '2'),
(32, 'Chrome Sphere', 'White Insert for Sphere', NULL, '3'),
(33, 'White Sphere', 'White Insert for Sphere', NULL, '4'),
(34, NULL, NULL, 'Chrome Cone', '5'),
(38, NULL, NULL, 'White Cone', '6'),
(39, 'Plastic Chrome Cover', NULL, NULL, '1'),
(40, 'Plastic White Cover', NULL, NULL, '2'),
(41, NULL, 'AISI 304 Metal Cover', NULL, '3'),
(42, 'Body Open', 'Body Flat Ø 16 mm', NULL, 'ISJNFLAT165'),
(43, 'Body Blind Lh', 'Body Flat Ø 16 mm', NULL, 'ISJFLATCS165'),
(44, 'Body Blind Rt', 'Body Flat Ø 16 mm', NULL, 'ISJFLATCD165'),
(45, 'Body Open', 'Body Flat Ø 20 mm', NULL, 'ISJNFLAT005'),
(46, 'Body Blind Lh', 'Body Flat Ø 20 mm', NULL, 'ISJNFLATCS5'),
(47, 'Body Blind Rt', 'Body Flat Ø 20 mm', NULL, 'ISJNFLATCD5'),
(57, 'Chrome Flat Cover', NULL, NULL, 'ISJPLFLAT05'),
(58, 'White Flat Cover', NULL, NULL, 'ISJPLFLAT01'),
(59, NULL, 'Chrome Round Cover', NULL, 'ISJPL010105'),
(60, NULL, 'White Round Cover', NULL, 'ISJPL010101'),
(61, NULL, NULL, 'Chrome Lux Cover', 'ISJPLLX0205'),
(62, NULL, NULL, 'White Lux Cover', 'ISJPLLX0201'),
(69, 'Chrome Flat Nozzle', NULL, NULL, 'ISJROFLAT5'),
(70, 'White Flat Nozzle', NULL, NULL, 'ISJROFLAT1'),
(71, NULL, 'Chrome Flower Nozzle', NULL, 'ISJRO01NS5'),
(72, NULL, 'White Flower Nozzle', NULL, 'ISJRO01NS1'),
(73, 'Body Open Multijet', 'Chrome Nozzle', NULL, 'ISJNBOMUJVA255E'),
(74, 'Body Blind Lh Multijet', 'Chrome Nozzle', NULL, 'ISJBMUJVC25S5E'),
(75, 'Body Blind Rt Multijet', 'Chrome Nozzle', NULL, 'ISJBOMUJVC25D5E'),
(76, 'Body Open Multijet', 'White Nozzle', NULL, 'ISJBOMUJVA251E'),
(77, 'Body Blind Lh Multijet', 'White Nozzle', NULL, 'ISJBOMUJVC25S1E'),
(78, 'Body Blind Rt Multijet', 'White Nozzle', NULL, 'ISJBOMUJVC25D1E'),
(79, 'Body Open Square Jet', 'Body Ø 16 mm Square Jet', NULL, 'ISJNSQU165'),
(80, 'Body Blind Lh Square Jet', 'Body Ø 16 mm Square Jet', NULL, 'ISJNSQUCS165'),
(81, 'Body Blind Rt Square Jet', 'Body Ø 16 mm Square Jet', NULL, 'ISJNSQUCD165'),
(82, 'Body Open Square Jet', 'Body Ø 20 mm Square Jet', NULL, 'ISJNSQU005'),
(83, 'Body Blind Lh Square Jet', 'Body Ø 20 mm Square Jet', NULL, 'ISJNSQUCS5'),
(84, 'Body Blind Rt Square Jet', 'Body Ø 20 mm Square Jet', NULL, 'ISJNSQUCD5'),
(85, NULL, 'Chrome Lux Cover', NULL, 'ISJPLLX0205'),
(86, NULL, 'White Lux Cover', NULL, 'ISJPLLX0201'),
(87, NULL, NULL, 'Chrome Round Cover', 'ISJPL010105');

-- --------------------------------------------------------

--
-- Struttura della tabella `Kit`
--

CREATE TABLE `Kit` (
  `id` int NOT NULL,
  `nome` varchar(255) NOT NULL,
  `descrizione` text,
  `immagine` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `titoli_prodottiConfigurabili` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `sottotitoli_prodottiConfigurabili` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `titoli_prodottiNonConfigurabili` text NOT NULL,
  `titoli_prodottiOptional` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `codice_univoco` varchar(255) NOT NULL,
  `navigazione` varchar(255) DEFAULT NULL,
  `pdf` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `Kit`
--

INSERT INTO `Kit` (`id`, `nome`, `descrizione`, `immagine`, `titoli_prodottiConfigurabili`, `sottotitoli_prodottiConfigurabili`, `titoli_prodottiNonConfigurabili`, `titoli_prodottiOptional`, `codice_univoco`, `navigazione`, `pdf`) VALUES
(17, 'Basic Air Kit', 'The Basic Air kit is the cheapest system operated by a blowing motor. The motor On/Off is controlled by a pneumatic push that is acting directly on the switch of the blower. The kit is presented with a manifold with integrated fast connectors and with a guide track for installation under the bathtub edge, that are speeding up both the operations of connections to the airjets and of mounting itself. The system is equipped with a safety airloop, available in two different heights 180mm and 400mm, that prevents water infiltrations into the motor. For this purpose a check valve that can be mounted inside the manifold and a safety valve diam. 32 that can be mounted on the motor, are also available. The blower offered in the kit has a very well performing 700W motor, whose low noise can be even further reduced by an optional noise-absorbing filter. The blowing motor is also available in the TOP version with double layer case and integrated noise-absorbing filter, for high-quality applications.\r\n\r\nAll the parts composing the kit are MADE IN ITALY.', 'Whirlpool_System/Air_System/Basic_Air_Kit/Basic_Air_Kit.jpg', 'Airjet-Fast Connecting-Fast Connecting Manifold-Blower-Pneumatic Push', 'Airjet-Fast Connecting-Fast Connecting Manifold-Manifold Installation Plate-Blower-Pneumatic Push', 'Non Configurabili', 'Optional', 'ISKBAIR12E5', 'Whirlpool System-Air System-Basic Air Kit', 'Basic_Air_Kit.pdf'),
(18, 'Basic Hydro Kit', 'It is the most economical hydro massage equipment, realized with manual controls, that can be placed in the preferred position. Air regulation is manual and the regulator is equipped with a check valve integrated in its body. The jets suggested for the installation are the Multijets with horizontal water connection dia. 25mm, for mounting with clamps.\r\nAs the nozzle of the jet is adjustable, scale/encrustation can be easily removed through the movement.\r\nThe massage spray is quite strong and the Venturi mixture of air and water very well balanced.\r\nThis jet allows a complete closing of both water and air.\r\nDrainage from the jet body is granted by its \"Y\" shaped connections.\r\nThe suction body is a 90° elbow and allows the mounting both with clamps and with glue.\r\nBasic Hydro kit is available both in chrome and white finishing.\r\nThe kit is offered with all pipes and fittings needed for installation.\r\n\r\nAll the parts composing the kit are MADE IN ITALY.', 'Whirlpool_System/Water_System/Basic_Hydro_Kit/Basic_Hydro_Kit.png', 'Jet-Suction-Pneumatic Push-Air Regulator-Pump', 'Jet-Suction-Pneumatic Push-Air Regulator-Pump', 'Non Configurabili', 'Optional', 'ISKMUL6V255', 'Whirlpool System-Water System-Basic Hydro Kit', 'Basic_Hydro_Kit.pdf'),
(19, 'Microjet Kit with Separate Air Regulation', 'The Microjet kit is conceived as option that can be mounted in addition to standard hydro/air systems, to offer a special dorsal, lumbar or feet stimulating massage through a small Venturi jet. The jet is designed with the aim of allowing a very simple, time-saving and safe installation. The Microjet kit is offered with an air regulator that allows a separate control of the air to this system. For a cheaper installation, a junction between the microjet and the jet- line air circuits is also possible (see: ISKMICJ6RJ05 Microjet kit with jet junction) The kit is installed with a pipe of small diameter that is inserted in fast connections integrated in the microjet body and in a compart manifold and therefore the mounting operations can be easily carried out in reduced spaces. The special tee-piece with microjet extension, makes the connection to the pump very fast and simple.\r\n\r\nAll the parts composing the kit are MADE IN ITALY.', 'Whirlpool_System/Water_System/Microjet_Kit/Microjet_Kit_with_separate_air_regulation/B_Microjet_Kit_with_separate_air_regulation.png', 'Microjet Simple-Microjet Fast Connection-Air Regulator-Fittings', 'Microjet Simple-Microjet Fast Connection-Air Regulator-Fittings', 'Non Configurabili', 'Optional', 'ISKMICJ6RA05', 'Whirlpool System-Water System-Microjet Kit', 'Microjet_Kit.pdf');

-- --------------------------------------------------------

--
-- Struttura della tabella `ProdottoConfigurabile`
--

CREATE TABLE `ProdottoConfigurabile` (
  `id` int NOT NULL,
  `nome` varchar(255) NOT NULL,
  `descrizione` text,
  `immagine` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `titoli_configurazione` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `sottotitoli_configurazione` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `titolo_optional` text,
  `codice_base` varchar(255) NOT NULL,
  `navigazione` varchar(255) DEFAULT NULL,
  `pdf` varchar(255) DEFAULT NULL,
  `dimensioni` text,
  `finiture` text,
  `materiali` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `ProdottoConfigurabile`
--

INSERT INTO `ProdottoConfigurabile` (`id`, `nome`, `descrizione`, `immagine`, `titoli_configurazione`, `sottotitoli_configurazione`, `titolo_optional`, `codice_base`, `navigazione`, `pdf`, `dimensioni`, `finiture`, `materiali`) VALUES
(4, 'In-line Manifold', 'Air system manifold with 6 outlets with integrated fast connecting mechanism. Complete with a support to facilitate installation under the bath. The module allows the connection of more manifolds to increase the number of available outlets.', 'Whirlpool_System/Air_System/Manifols/Manifolds/Manifold_6_Outlet_Isj/B_Manifold_6_Outlet_Isj.jpg-Whirlpool_System/Air_System/Manifols/Accessories_Manifolds/Installation_Plate_Isj/B_Installation_Plate_Isj.jpg', 'Outlet-Material', '', '', 'ISJCO6PLR10', 'Whirlpool System-Air System-Manifolds-Manifolds', NULL, 'Connection pipe: Ø  mm. 32%Outlets: Ø mm. 10', NULL, NULL),
(5, 'Airjet', 'Body made of nylon with fibre glass charge, with ABS cover and supplied with sealing.', 'Whirlpool_System/Air_System/Airjet/Airjet/B_Airjet.jpg', 'Cover', '', '', 'ISJUGL102P5', 'Whirlpool System-Air System-Airjet', NULL, 'External cover Ø 28 mm', 'Chrome%White', 'Nylon 30 FG & ABS'),
(6, 'ROND Pneumatic Push', 'Round version of pneumatic push. Made of ABS. It can be dismantled from the bath side.', 'Whirlpool_System/Air_System/Controls/Pneumatic_Push/Round_Pneumatic_Push/B_Round_Pneumatic_Push.jpg', 'Cover', '', '', 'ISPST020105', 'Whirlpool System-Air System-Controls-Pneumatic Push/Whirlpool Systems-Water System-Controls', NULL, 'External cover: Ø 49 mm%Hole: Ø 40 mm', 'Chrome%White', 'ABS'),
(7, 'FLAT Pneumatic Push', 'Flat version of pneumatic push. Made of ABS. It can be dismantled from the bath side.', 'Whirlpool_System/Air_System/Controls/Pneumatic_Push/Flat_Pneumatic_Push/B_Flat_Pneumatic_Push.jpg', 'Cover-Serigraphy', '', '', 'ISPSTFLAT05', 'Whirlpool System-Air System-Controls-Pneumatic Push/Whirlpool Systems-Water System-Controls', NULL, 'External cover: Ø 49 mm%Hole: Ø 40 mm', 'Chrome%White', 'ABS'),
(8, 'Air Regulator', 'Air regulator with bottom air intake and integrated check valve.', 'Whirlpool_System/Water_System/Controls/Air_Regulator/B_Air_Regulator.jpg', 'Cover', '', '', 'ISPRNEW0105', 'Whirlpool System-Water System-Controls', NULL, 'External cover Ø 50 mm%Hole Ø 40 mm', 'Chrome%White', 'ABS'),
(9, 'Flat Air Regulator', 'Air regulator with bottom air intake and integrated check valve. Made of ABS.', 'Whirlpool_System/Water_System/Controls/Flat_Air_Regulator/B_Flat_Air_Regulator.jpg', 'Cover-Serigraphy', '', '', 'ISPRFLAT05', 'Whirlpool System-Water System-Controls', NULL, 'External cover Ø 49 mm%Hole Ø 40 mm', 'Chrome%White%Chrome with serigraphy', 'ABS'),
(10, 'Flat Pneumatic Control All-In-One', 'All-in-one flat pneumatic control. Pump on-off and integrated air regulator with check-valve. Made of ABS. It can be dismantled from the bath side.', 'Whirlpool_System/Water_System/Controls/Flat_Pneumatic_Control_All_In_One/B_Flat_Pneumatic_Control_All_In_One.jpg', 'Cover-Serigraphy', '', '', 'ISPSREGFL05', 'Whirlpool System-Water System-Controls', NULL, 'External diam.: Ø 49 mm%Hole: Ø 40 mm', 'Chrome%White%Chrome with serigraphy', 'ABS'),
(11, 'Microjet Flat Fast Connecting', 'Microjet flat-cover with plastic body to be installed with fast connecting couplings.\r\nAvarage delivery: lt/min 9/12', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Microjets/Microjet_Flat/Microjet_Flat_P/B_Microjet_Flat_P.jpg-Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Microjets/Microjet_Flat/Microjet_Flat_P/Microjet_Flat_P_1.jpg', 'Cover', '', '', 'ISBOMRJP5FL', 'Whirlpool System-Water System-Microjets', NULL, 'Water inlet: Ø10 mm%Air inlet pipe: Ø10 mm%Hole: Ø29mm%External diam.:Ø29mm', 'Chrome%White', NULL),
(12, 'Microjet Flat Fast Connecting Clips', 'Microjet flat-cover with plastic body to be installed with fast connecting couplings or clips.\r\nAvarage delivery: lt/min 9/12', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Microjets/Microjet_Flat/Microjet_Flat_Oc/B_Microjet_Flat_Oc.jpg-Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Microjets/Microjet_Flat/Microjet_Flat_Oc/Microjet_Flat_Oc_1.jpg', 'Cover', '', '', 'ISBOMRJOC5FL', 'Whirlpool System-Water System-Microjets', NULL, 'Water inlet: Ø10 mm%Air inlet pipe: Ø10 mm%Hole: Ø29mm%External diam.:Ø29mm', 'Chrome%White', NULL),
(13, 'Microjet Fast Connecting', 'Microjet with plastic body to be installed with fast connecting couplings.\r\nAvarage delivery: lt/min 9/12', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Microjets/Microjet_Tondo/Microjet_Tondo_P/B_Microjet_Tondo_P.jpg-Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Microjets/Microjet_Tondo/Microjet_Tondo_P/Microjet_Tondo_P_1.jpg', 'Cover', '', '', 'ISBOMRJP5', 'Whirlpool System-Water System-Microjets', NULL, 'Water inlet: Ø10 mm%Air inlet pipe: Ø10 mm%Hole: Ø29mm%External diam.:Ø29mm', 'Chrome%White', NULL),
(14, 'Line Jet', 'PVC body with pivoting nozzle. The jet design grants a complete water drainage. For installation with clamps. Available in white and chrome finishing or combi chrome cover and white nozzle.', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Line_Jet/B_Line_Jet.jpg', 'Cover-Nozzle-Body', '', 'Flat Sponge Gasket-Key', 'ISJLINEA005', 'Whirlpool System-Water System-Jets-Jets', 'Line_Jet.pdf', 'Air inlet pipe: Ø 16 mm%Water inlet pipe: Ø 25 mm%Hole: Ø 50 mm%Hole (with rubber gasket): Ø 51 mm%External cover: Ø 61 mm', 'Chrome%White', 'PVC'),
(15, 'Minijet', 'Body made of PVC with pivoting nozzle and anti-encrustration device. ABS cover with bayonet connection.\r\nAverage delivery: lt/min 30/35.', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Minijet_Skat/B_Minijet_Skat.jpg', 'Cover-Nozzle', '', 'Flat Sponge Gasket-PVC Air Plug-Key', 'ISJBO020201', 'Whirlpool System-Water System-Jets-Jets', NULL, 'Water inlet pipe: Ø 25 mm%Air inlet pipe: Ø 16 mm%Hole: Ø 44 mm%External cover: Ø 60 mm', 'Chrome%White', NULL),
(16, 'Shower Jet', 'Body made of Nylon with T connection included. Cover and eyeball made of ABS. Including anti-blocking device.', 'Shower_System/Shower_Jets/Shower_Jet/B_Shower_Jet.jpg', 'Body', '', '', 'ISJSJOKMM05', 'Shower System-Shower Jets', NULL, 'External diam.: Ø 50 mm%Hole: Ø 40 mm%Connection pipe: Ø 10 mm', NULL, 'Nylon & ABS'),
(17, 'Minimal Shower Jet', 'Body made of Nylon with T connection included. Cover and eyeball made of ABS. Including green silicone rubber, anti-blocking device.', 'Shower_System/Shower_Jets/Minimal_Shower_Jet/B_Minimal_Shower_Jet.jpg', 'Body', '', '', 'ISJSMMPAV05', 'Shower System-Shower Jets', NULL, 'External diam.: Ø 50 mm%Hole: Ø 40 mm%Connection pipe: Ø 10 mm', NULL, 'Nylon & ABS'),
(18, 'Micro Shower Jet', 'Body made of Nylon realized for fast connection. Cover plate made of ABS. Including black rubber anti-blocking device.', 'Shower_System/Shower_Jets/Micro_Shower_Jet/B_Micro_Shower_Jet.jpg', 'Cover', '', '', 'ISJBOMJ005', 'Shower System-Shower Jets', NULL, 'External diam.: Ø 30 mm%Hole: Ø 19 mm%Connection pipe: Ø 10 mm', 'Chrome%White', 'Nylon & ABS'),
(19, 'Round Micro Shower Jet', 'Body made of Nylon with ABS chrome cover. Equipped with fast 90° or Tee fast connector. Minimal design.', 'Shower_System/Shower_Jets/Round_Micro_Shower_Jet/B_Round_Micro_Shower_Jet.jpg', 'Cover-Body', '', '', 'ISSHR00105', 'Shower System-Shower Jets', NULL, 'External diam.: Ø 22 mm%Hole: Ø 13 mm%Connection pipe: Ø 10 mm', 'Chrome%White', 'Nylon & ABS'),
(20, 'Round Nebulizer Jet', 'Body made of Nylon with ABS chrome cover. Equipped with fast 90° or Tee fast connector. Minimal design.', 'Shower_System/Shower_Jets/Round_Micro_Shower_Jet/B_Round_Micro_Shower_Jet.jpg', 'Cover-Body', '', '', 'ISNEBR0105', 'Shower System-Shower Jets', NULL, 'External diam.: Ø 22 mm%Hole: Ø 13 mm%Connection pipe: Ø 10 mm', 'Chrome%White', 'Nylon & ABS'),
(21, 'Round H30 with Plate', 'Shower drain round with removable siphon.\r\n\r\nFor more information take a look to the PDF below.', 'Shower_System/Shower_Drains/Shower_Drains/Round_Shower_Drain_H30_with_Plate/B_Round_Shower_Drain_H30_with_Plate.jpg', 'Body for Self Tapping Screw-Cover-Gasket', '', '', 'SD-9030', 'Shower System-Shower Drains-Round', 'Round.pdf', 'Shower tray hole: Ø 90 mm&Outlet with connecting nut: Ø 40 mm', NULL, NULL),
(22, 'Round H30 without Plate', 'Shower drain round with removable siphon.\r\n\r\nFor more information take a look to the PDF below.', 'Shower_System/Shower_Drains/Shower_Drains/Round_Shower_Drain_H30_without_Plate/B_Round_Shower_Drain_H30_without_Plate.jpg', 'Body for Self Tapping Screw-Gasket', '', '', 'SD-9031', 'Shower System-Shower Drains-Round', 'Round.pdf', 'Shower tray hole: Ø 90 mm&Outlet with connecting nut: Ø 40 mm', NULL, NULL),
(23, 'Round H50 with Plate', 'Shower drain round with removable siphon.\r\n\r\nFor more information take a look to the PDF below.', 'Shower_System/Shower_Drains/Shower_Drains/Round_Shower_Drain_H50_with_Plate/B_Round_Shower_Drain_H50_with_Plate.jpg', 'Body for Self Tapping Screw-Body H50 with Joint-Cover-Gasket', '', '', 'SD-9050', 'Shower System-Shower Drains-Round', 'Round.pdf', 'Shower tray hole: Ø 90 mm&Outlet with connecting nut: Ø 40 mm', NULL, NULL),
(24, 'Round H50 without Plate', 'Shower drain round with removable siphon.\r\n\r\nFor more information take a look to the PDF below.', 'Shower_System/Shower_Drains/Shower_Drains/Round_Shower_Drain_H50_without_Plate/B_Round_Shower_Drain_H50_without_Plate.jpg', 'Body for Self Tapping Screw-Body H50 with Joint-Gasket', '', '', 'SD-9051', 'Shower System-Shower Drains-Round', 'Round.pdf', 'Shower tray hole: Ø 90 mm&Outlet with connecting nut: Ø 40 mm', NULL, NULL),
(25, 'Microjet Fast Connecting Clips', 'Microjet with plastic body to be installed with fast connecting couplings or clips.\r\nAvarage delivery: lt/min 9/12', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Microjets/Microjet_Tondo/Microjet_Tondo_Oc/B_Microjet_Tondo_Oc.jpg-Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Microjets/Microjet_Tondo/Microjet_Tondo_Oc/Microjet_Tondo_Oc_1.jpg', 'Cover', '', '', 'ISBOMRJOC5', 'Whirlpool System-Water System-Microjets', NULL, 'Water inlet: Ø10 mm%Air inlet pipe: Ø10 mm%Hole: Ø29mm%External diam.:Ø29mm', NULL, NULL),
(26, 'Rectangular 2 Siphon H30 without Plate', 'Rectangular shower drain with removable siphon.\r\n\r\nFor more information take a look to the PDF below.', 'Shower_System/Shower_Drains/Shower_Drains/Rectangular_2_Syphon_Shower_Drain_H30_without_Plate/B_Rectangular_2_Syphon_Shower_Drain_H30_without_Plate.jpg', 'Body for Self Tapping Screw-Flange-Gasket', '', '', 'PRH30-1SP', 'Shower System-Shower Drains-Rectangular 2 Siphon', 'Rectangular_2_Siphon.pdf', 'Shower tray hole: 47x192 mm%Outlet with connecting nut dia.: Ø 40 mm', NULL, NULL),
(27, 'Rectangular 2 Siphon H30 with Plate', 'Rectangular shower drain with removable siphon.\r\n\r\nFor more information take a look to the PDF below.', 'Shower_System/Shower_Drains/Shower_Drains/Rectangular_2_Syphon_Shower_Drain_H30_with_Plate/B_Rectangular_2_Syphon_Shower_Drain_H30_with_Plate.jpg', 'Body for Self Tapping Screw-Flange-Gasket', '', '', 'PRH30-CP', 'Shower System-Shower Drains-Rectangular 2 Siphon', 'Rectangular_2_Siphon.pdf', 'Shower tray hole: 47x192 mm%Outlet with connecting nut dia.: Ø 40 mm', NULL, NULL),
(28, 'Rectangular 2 Siphon H50 with Plate', 'Rectangular shower drain with removable siphon.\r\n\r\nFor more information take a look to the PDF below.', 'Shower_System/Shower_Drains/Shower_Drains/Rectangular_2_Syphon_Shower_Drain_H50_with_Plate/B_Rectangular_2_Syphon_Shower_Drain_H50_with_Plate.jpg', 'Body for Self Tapping Screw-Flange-Gasket', '', '', 'PRH50-CP', 'Shower System-Shower Drains-Rectangular 2 Siphon', 'Rectangular_2_Siphon.pdf', 'Shower tray hole: 47x192 mm%Outlet with connecting nut dia.: Ø 40 mm', NULL, NULL),
(29, 'Rectangular 2 Siphon H50 without Plate', 'Rectangular shower drain with removable siphon.\r\n\r\nFor more information take a look to the PDF below.', 'Shower_System/Shower_Drains/Shower_Drains/Rectangular_2_Syphon_Shower_Drain_H50_without_Plate/B_Rectangular_2_Syphon_Shower_Drain_H50_with_Plate.jpg', 'Body for Self Tapping Screw-Flange-Gasket', '', '', 'PRH50-1', 'Shower System-Shower Drains-Rectangular 2 Siphon', 'Rectangular_2_Siphon.pdf', 'Shower tray hole: 47x192 mm%Outlet with connecting nut dia.: Ø 40 mm', NULL, NULL),
(30, 'Rectangular 3 Siphon H30', 'Rectanguar shower drain with removable siphon.\r\n\r\nFor more information take a look to the PDF below.', 'Shower_System/Shower_Drains/Shower_Drains/Rectangular_3_Syphon_Shower_Drain_H30/B_Rectangular_3_Syphon_Shower_Drain_H30.jpg', 'Flange-Gasket', '', '', 'SRH30-1', 'Shower System-Shower Drains-Rectangular 3 Siphon', 'Rectangular_3_Siphon_H30.pdf', 'Shower tray hole: 31x298 mm%Outlet with connecting nut diam.: Ø 40 mm', NULL, NULL),
(31, 'Rectangular 3 Siphon H50', 'Rectanguar shower drain with removable siphon.\r\n\r\nFor more information take a look to the PDF below.', 'Shower_System/Shower_Drains/Shower_Drains/Rectangular_3_Syphon_Shower_Drain_H50/B_Rectangular_3_Syphon_Shower_Drain_H50.jpg', 'Flange-Gasket', '', '', 'SRH50-1', 'Shower System-Shower Drains-Rectangular 3 Siphon', 'Rectangular_3_Siphon_H50.pdf', 'Shower tray hole: 31x298 mm%Outlet with connecting nut diam.: Ø 40 mm', NULL, NULL),
(32, 'Slim Jet', 'PVC body with pivoting nozzle. The jet design grants a complete water drainage. For installation with clamps. Chrome cover available with internal white insert or only chrome.\r\nAverage water flow It/min: 35/40', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Slim_Jet/B_Slim_Jet.jpg', 'Insert-Nozzle-Body', '', 'Flat Sponge Gasket-Key', 'ISJSLIMA005', 'Whirlpool System-Water System-Jets-Jets', 'Slim_Jet.pdf', 'Air inlet pipe: Ø 16 mm%Water inlet pipe: Ø 25 mm%Hole: Ø 50 mm%Hole (with rubber gasket): Ø 51 mm%External cover: Ø 61 mm', 'Chrome%White', 'PVC'),
(33, 'Suction 3F', 'PVC Body and ABS cover. Patented. It enables to implement 3 different functions: suction, cleaning and safety. Every fuction is modular and can be implemented by the customer as desired, independently from the others.', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Suctions/Suction_3F/B_Suction_3F.jpg', 'Body-Cover', '', 'Adapter-Flat Sponge Gasket-Key-Safety Valve-U Seal Gasket', 'ISJPL3F0105', 'Whirlpool System-Water System-Suctions-Suctions', '3F_Suction.pdf', 'Cover plate external diam.: Ø 90 mm%Body internal passage: Ø 40 mm%Body hole: Ø 60 mm%Body external diam.: Ø 75 mm', 'Chrome%White', 'ABS & PVC'),
(34, 'Suction 3F Lux', 'PVC Body and ABS cover. Patented. It enables to implement 3 different functions: suction, cleaning and safety. Every fuction is modular and can be implemented by the customer as desired, independently from the others.\r\n', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Suctions/Suction_3F_Lux/B_Suction_3F_Lux.jpg', 'Body-Cover', '', 'Adapter-Flat Sponge Gasket-Key-Safety Valve-U Seal Gasket', 'ISJPL3FL105', 'Whirlpool System-Water System-Suctions-Suctions', '3F_Suction.pdf', 'Cover plate external diam.: Ø 90 mm%Body internal passage: Ø 40 mm%Body hole: Ø 60 mm%Body external diam.: Ø 75 mm', 'Chrome%White', 'ABS & PVC'),
(35, 'Suction 3F Square', 'PVC Body, ABS cover plate. Square cover design, for use together with \"square\" jets.\r\n', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Suctions/Suction_3F_Square/B_Suction_3F_Square.jpg', 'Body-Cover', '', 'Adapter-Flat Sponge Gasket-Key-Safety Valve-U Seal Gasket', 'ISPL3FSQU05', 'Whirlpool System-Water System-Suctions-Suctions', '3F_Suction.pdf', 'Plate external diam.: Ø 90 mm%Body internal passage: Ø 40 mm%Body hole: Ø 60 mm%Body external diam.: Ø 75 mm', 'Chrome%White', 'ABS & PVC'),
(37, 'Suction Standard', 'Body made of PVC.\r\nCover made of ABS.\r\nPlate held by a central self-tapping screw.', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Suctions/Suction_Standard/B_Suction_Standard.jpg', 'Body-Cover', '', 'Key-PVC Elbow 90°-U Seal Gasket', 'ISJPL040105', 'Whirlpool System-Water System-Suctions-Suctions', NULL, 'Body Internal passage: Ø 40 mm%Body Hole: Ø 60 mm%Body External diam.: Ø 75 mm%Plate External diam. : Ø 80 mm', 'Chrome%White', 'PVC & ABS'),
(38, 'Moon Jet', '\"Moon\" is the innovative whirlpool jet system developed by Sacith. It’s highly configurable, disassemblable and made in Italy with high-quality materials.\r\n- Optional adjustable multicolour LED lighting.\r\n- All components are available in white or chrome.\r\n- Available with the innovative conical jet or with a directional sphere jet.\r\n- Available in the version with the application of silicone or with the sealing gasket.\r\n- Available with plastic or metal tightening ring (cover).', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Moon_Jet/B_Moon_Jet.png-Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Moon_Jet/Moon_Jet_Codes_Configurator.jpg', 'Body-Silicone or Gasket-Light or No Light-Nozzle Type and Finiture-Cover Material and Finiture', 'Nozzle Type and Finiture-Sphere/Nozzle Type and Finiture-Insert/Nozzle Type and Finiture-Cone/Cover Material and Finiture-Plastic Cover/Cover Material and Finiture-Metal Cover', 'Key', 'MNJ', 'Whirlpool System-Water System-Jets-Jets', 'Moon_Jet.pdf', NULL, 'Chrome%White%RAL Color', NULL),
(39, 'Bouquet Steam Outlet', 'Steam outlet with essence-holder.\r\n\r\nItem ISRUBBQ0001: Drainage into shower cabin.\r\nItem ISRUBBQ0000: Drainage through pop-up waste.', 'Shower_System/Steam_Accessories_&_Fittings/Bouquet_Steam_Outlet/B_Bouquet_Steam_Outlet.jpg', 'Body', '', '', 'ISRUBBQ0001', 'Shower System-Steam, Accessories & Fittings', '', 'Size: 95x45x30 mm%Thread: 3/4%Connection diam.: Ø 10 mm', 'White', ''),
(40, 'Closed Cap Steam Outlet', 'Steam outlet with essence-holder.\r\n\r\nItem ISRUBBQ0001J: Drainage into shower cabin.\r\nItem ISRUBBQ0000J: Drainage through pop-up waste.', 'Shower_System/Steam_Accessories_&_Fittings/Closed_Cap_Steam_Outlet/B_Closed_Cap_Steam_Outlet.jpg', 'Body', '', '', 'ISRUBBQ0001J', 'Shower System-Steam, Accessories & Fittings', '', 'Size: 95x45x40 mm%Thread: 3/4%Connection diam.: Ø 10 mm', 'White', ''),
(41, 'Push-Push Plug for Tank', 'Plug for cleaning tank with innovative push-opening.', 'Whirlpool_System/Water_System/Pipes,_Fittings_&_Disinfection/Disinfection/Push_Push_Plug_for_Tank/B_Push_Push_Plug_for_Tank.jpg', 'Cover', '', '', 'ISJTAPPP0005', 'Whirlpool System-Water System-Pipes, Fittings & Disinfection-Disinfection', '', 'External diam.: Ø 50 mm%Hole diam.: Ø 40 mm', 'Chrome%White', ''),
(42, 'Plug for Tank', 'Plug for cleaning tank.', 'Whirlpool_System/Water_System/Pipes,_Fittings_&_Disinfection/Disinfection/Plug_for_Tank/B_Plug_for_Tank.jpg', 'Cover', '', '', 'ISRTI00N105', 'Whirlpool System-Water System-Pipes, Fittings & Disinfection-Disinfection', '', 'External diam.: Ø 49 mm%Hole diam.: Ø 40 mm', 'Chrome%White', ''),
(43, 'Slim Suction', 'PVC Body. Fitted with conncetion for safety valve. ABS Flat multi-hole cover. We recommend installation of 3F safety valve.', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Suctions/Suction_Slim/B_Suction_Slim.jpg', 'Cover', '', 'Adapter-Flat Sponge Gasket-Key-Safety Valve-U Seal Gasket', 'ISJPLSULIM005', 'Whirlpool System-Water System-Suctions-Suctions', 'Slim_Jet.pdf', 'Internal passage: Ø 40 mm%Hole: Ø 60 mm%Hole (with rubber gasket): Ø 61 mm%External cover: Ø 62 mm', 'Chrome%White', 'PVC & ABS'),
(44, 'Flat Jet', 'Body made of PVC. It can be adjusted by setting the direction and delivery of the nozzle, allowing a complete closing of the water spray. It is fitted with an anti-encrustration device. Installation with clamps. (No-glue).\r\nAverage delivery: 35/40 lt/min', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Flat_Jet/B_Flat_Jet.jpg', 'Body and Diameter-Cover-Nozzle-Flat Body for Glue-Y Body Joint-PVC Air Plug', 'Body and Diameter-Body/Body and Diameter-Diameter/Cover-Flat/Cover-Lux/Cover-Round/Nozzle-Flat/Nozzle-Flower', 'Flat Sponge Gasket-Key-U Seal Gasket', 'ISJNFLAT', 'Whirlpool System-Water System-Jets-Jets', '', 'Water inlet pipe: Ø 25 mm%Air inlet pipe: Ø 16 or 20 mm%Hole: Ø 60 mm%External cover plate: Ø 77 mm', 'Chrome%White', 'PVC'),
(45, 'Square Jet', 'For minimal square bathtubs, the square jet is really an exclusive and original design choice!\r\nAvailable for installation with clamps.', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Square_Jet/B_Square_Jet.jpg', 'Body and Diameter-Cover-Nozzle-Y Body Joint-PVC Air Plug', 'Body and Diameter-Body/Body and Diameter-Diameter', 'Flat Sponge Gasket-Key-U Seal Gasket', 'ISJNSQU', 'Whirlpool System-Water System-Jets-Jets', '', 'Water inlet diam.: Ø 25 mm%Air inlet diam.: Ø 16 or 20 mm%Hole: Ø 60 mm% External cover size 75x75 mm', 'Chrome%White', ''),
(46, 'Multijet', 'Body made of PVC, with adjustable nozzle that allows a complete closing of the water spray and helps scale elimination. The jet design grants a complete water drainage. For installation with clips only, without glue.\r\nAverage delivery: 35/40 lt/min', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Multi_Jet/B_Multijet.jpg', 'Body and Nozzle-Cover', 'Body and Nozzle-Body/Body and Nozzle-Nozzle', 'Flat Sponge Gasket-Key-U Seal Gasket', 'ISJMULJ', 'Whirlpool System-Water System-Jets-Jets', '', 'Hole: Ø 50 mm%External cover diam.: Ø 65 mm%Air inlet pipe: Ø 16 mm', 'Chrome%White', ''),
(47, 'Airjet Moon', 'Brand new Airjet of \"moon\" family. Made by cover and insert, it allows to create a bi-color configuration.', 'Whirlpool_System/Air_System/Airjet/Airjet_Moon/B_Airjet_Moon.png', 'Cover-Insert', '', '', 'MNAIRJ', 'Whirlpool System-Air System-Airjet', 'Moon_Family.pdf', '', '', ''),
(48, 'Sacitronic', 'It is an electromechanical control that operates the switching on and off of the pump and allows the manual regulation of the air in the jet circuit.\r\nIt is equipped with an integrated check valve and at its end a tee-piece for the connection to the jets\' air circuit is installed. This tee-piece is available both in Ø 20 mm and in Ø 16 mm.\r\nSacitronic is certified according to the safety regulations in force.', 'Whirlpool_System/Water_System/Controls/Sacitronic/B_Sacitronic.jpg-Whirlpool_System/Water_System/Controls/Sacitronic/Sacitronic_1.jpg', 'Cover', '', '', 'SACITRONIC', 'Whirlpool System-Water System-Controls', '', 'External cover: Ø 61 mm%Hole: Ø 46 mm', '', '');

-- --------------------------------------------------------

--
-- Struttura della tabella `ProdottoSingolo`
--

CREATE TABLE `ProdottoSingolo` (
  `id` int NOT NULL,
  `nome` varchar(255) NOT NULL,
  `descrizione` text,
  `immagine` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `codice_univoco` varchar(255) NOT NULL,
  `dimensioni` varchar(255) DEFAULT NULL,
  `finiture` varchar(255) DEFAULT NULL,
  `materiali` varchar(255) DEFAULT NULL,
  `navigazione` varchar(255) DEFAULT NULL,
  `pdf` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `ProdottoSingolo`
--

INSERT INTO `ProdottoSingolo` (`id`, `nome`, `descrizione`, `immagine`, `codice_univoco`, `dimensioni`, `finiture`, `materiali`, `navigazione`, `pdf`) VALUES
(52, 'Blower Eco 400W', 'Self-estinguishing blower for air system. Supplied with 2 mt cable 400 W, 230 V, 50/60 Hz, 230V,50/60 Hz', 'Whirlpool_System/Air_System/Blower/Blower/Blower_Silent_400W/B_Blower_Silent_400W.jpg-Whirlpool_System/Air_System/Blower/Blower/Blower_Silent_400W/Blower_Silent_400W_1.jpg', 'ECO2400', '', '', '', 'Whirlpool System-Air System-Blower-Blower', NULL),
(53, 'Blower Eco 700W', 'Self-estinguishing blower for air system. Supplied with 2 mt cable 700 W, 230 V, 50/60 Hz-700W, 230V,50/60 Hz', 'Whirlpool_System/Air_System/Blower/Blower/Blower_Silent_400W/B_Blower_Silent_400W.jpg-Whirlpool_System/Air_System/Blower/Blower/Blower_Silent_400W/Blower_Silent_400W_1.jpg', 'ECO2700', '', '', '', 'Whirlpool System-Air System-Blower-Blower', NULL),
(54, 'Blower Silent 400 W', 'Self-estinguishing TURBO HIGHLY SILENT blower for air-system. This blower has a double-layer case and a noise-absorbing filter integrated. that are making it the most silent and best performing motor available in the market Supplied with 2-mt cable, 400W, 230V, 50/60Hz.', 'Whirlpool_System/Air_System/Blower/Blower/Blower_Silent_400W/B_Blower_Silent_400W.jpg-Whirlpool_System/Air_System/Blower/Blower/Blower_Silent_400W/Blower_Silent_400W_1.jpg', 'MSN40010', '', '', '', 'Whirlpool System-Air System-Blower-Blower', NULL),
(55, 'Blower Silent 700 W', 'Self-estinguishing TURBO HIGHLY SILENT blower for air-system. This blower has a double-layer case and a noise-absorbing filter integrated. that are making it the most silent and best performing motor available in the market Supplied with 2-mt cable, 700W, 230V, 50/60Hz.', 'Whirlpool_System/Air_System/Blower/Blower/Blower_Silent_700W/B_Blower_Silent_700W.jpg-Whirlpool_System/Air_System/Blower/Blower/Blower_Silent_700W/Blower_Silent_700W_1.jpg', 'MSN70010', '', '', '', 'Whirlpool System-Air System-Blower-Blower', NULL),
(56, 'Blower 700 W Silent - SPA Version', 'This blower has been conceived for a powerful hydro-massage in spas Very silent, strong and really competitive in price.', 'Whirlpool_System/Air_System/Blower/Blower/Blower_Silent_400W/B_Blower_Silent_400W.jpg-Whirlpool_System/Air_System/Blower/Blower/Blower_Silent_400W/Blower_Silent_400W_1.jpg', 'MSN70010SPA', '', '', '', 'Whirlpool System-Air System-Blower-Blower', NULL),
(57, 'Blower Eco 700W + Switch', 'Self-estinguishing blower for air system + switch. Supplied with 2 mt cable 400 W, 230 V, 50/60 Hz-700W, 230V,50/60 Hz.', 'Whirlpool_System/Air_System/Blower/Blower/Blower_Eco_700W_with_Switch/B_Blower_Eco_700W_with_Switch.jpg-Whirlpool_System/Air_System/Blower/Blower/Blower_Eco_700W_with_Switch/Blower_Eco_700W_with_Switch_1.jpg', 'ECO2700SW', '', '', '', 'Whirlpool System-Air System-Blower-Blower', NULL),
(58, 'Blower Eco 400W + Switch', 'Self-estinguishing blower for air system + switch. Supplied with 2 mt cable 400 W, 230 V, 50/60 Hz-700W, 230V,50/60 Hz.', 'Whirlpool_System/Air_System/Blower/Blower/Blower_Eco_400W_with_Switch/B_Blower_Eco_400W_with_Switch.jpg-Whirlpool_System/Air_System/Blower/Blower/Blower_Eco_400W_with_Switch/Blower_Eco_400_with_Switch_1.jpg', 'ECO2400SW', '', '', '', 'Whirlpool System-Air System-Blower-Blower', NULL),
(59, 'Blower Safety Valve', '', 'Whirlpool_System/Air_System/Blower/Accessories_Blower/Blower_Safety_Valve/B_Blower_Safety_Valve.jpg', 'VNR32M32F32', '32/32 mm', '', '', 'Whirlpool System-Air System-Blower-Blower Accessories', NULL),
(60, 'Blower Spiral Pipe', 'Special flexible pipe for blower. Without couplings.', 'Whirlpool_System/Air_System/Blower/Accessories_Blower/Blower_Spiral_Pipe/B_Blower_Spiral_Pipe.jpg', 'TUBN2800', 'Diameter: Ø32 mm', '', '', 'Whirlpool System-Air System-Blower-Blower Accessories/Whirlpool System-Air System-Pipes & Fittings', NULL),
(61, 'Double S Syphon Small', '', 'Whirlpool_System/Air_System/Blower/Accessories_Blower/Syphon_H180/B_H180.jpg-Whirlpool_System/Air_System/Blower/Accessories_Blower/Syphon_H180/H180_1.jpg', 'SALH180N', 'H180 mm.', '', '', 'Whirlpool System-Air System-Blower-Blower Accessories', NULL),
(62, 'Double S Syphon Big', '', 'Whirlpool_System/Air_System/Blower/Accessories_Blower/Syphon_H400/B_H400.jpg-Whirlpool_System/Air_System/Blower/Accessories_Blower/Syphon_H400/H400_1.jpg', 'SALH400N', 'H400 mm.', '', '', 'Whirlpool System-Air System-Blower-Blower Accessories', NULL),
(63, 'Connecting Coupling', 'For installation with clamps.', 'Whirlpool_System/Air_System/Blower/Accessories_Blower/Connecting_Coupling/B_Connecting_Coupling.jpg', 'MANDIR3232', 'Ø 32 mm', '', '', 'Whirlpool System-Air System-Blower-Blower Accessories/Whirlpool System-Air System-Pipes & Fittings', NULL),
(64, 'Straight Coupling + Adapter', 'For installation with clamps.', 'Whirlpool_System/Air_System/Blower/Accessories_Blower/Straight_Coupling_with_Adapter/B_Straight_Coupling_with_Adapter.jpg', 'MANDIRFD32', 'Ø 32 mm', '', '', 'Whirlpool System-Air System-Blower-Blower Accessories/Whirlpool System-Air System-Pipes & Fittings', NULL),
(65, '90° Coupling + Adapter', 'For Installation with clamps.', 'Whirlpool_System/Air_System/Blower/Accessories_Blower/90°_Coupling_with_Adapter/B_90°_Coupling_with_Adapter.jpg', 'MAN90FD32', 'Ø 32 mm', '', '', 'Whirlpool System-Air System-Blower-Blower Accessories/Whirlpool System-Air System-Pipes & Fittings', NULL),
(66, 'Manifold 6 Outlet', '6-way airsystem manifold with integrated fast connecting couplings, positioned in two raws, in order to make it more compact.\r\nConnection pipe:     Ø mm. 32\r\nOutlets:                    Ø mm. 10', 'Whirlpool_System/Air_System/Manifols/Manifolds/Manifold_6_Outlet/B_Manifold_6_Outlet.jpg', 'DAARD10060', 'Connection pipe:     Ø mm. 32%Outlets:                    Ø mm. 10', '', '', 'Whirlpool System-Air System-Manifolds-Manifolds', NULL),
(67, 'Manifold 8 Outlet', '8-way airsystem manifold with integrated fast connecting couplings, positioned in two raws, in order to make it more compact.\r\nConnection pipe:     Ø mm. 32\r\nOutlets:                    Ø mm. 10', 'Whirlpool_System/Air_System/Manifols/Manifolds/Manifold_8_Outlet/B_Manifold_8_Outlet.jpg', 'DAARD10080', 'Connection pipe:     Ø mm. 32%Outlets:                    Ø mm. 10', '', '', 'Whirlpool System-Air System-Manifolds-Manifolds', NULL),
(68, 'Manifold 12 Outlet', '12-way airsystem manifold with integrated fast connecting couplings, positioned in two raws, in order to make it more compact.\r\nConnection pipe:     Ø mm. 32\r\nOutlets:                    Ø mm. 10', 'Whirlpool_System/Air_System/Manifols/Manifolds/Manifold_12_Outlet/B_Manifold_12_Outlet.jpg', 'DAARD10120', 'Connection pipe:     Ø mm. 32%Outlets:                    Ø mm. 10', '', '', 'Whirlpool System-Air System-Manifolds-Manifolds', NULL),
(69, 'Installation Plate', 'Manifold installation plate for:\r\nManifold 6 Outlet\r\nManifold 8 Outlet\r\nManifold 12 Outlet', 'Whirlpool_System/Air_System/Manifols/Accessories_Manifolds/Installation_Plate/B_Installation_Plate.jpg', 'SDAXX000000', '', '', '', 'Whirlpool System-Air System-Manifolds-Manifolds Accessories', NULL),
(70, 'Connecting Couplings', 'Connecting coupling and o-ring to allow the mounting of more manifolds together.', 'Whirlpool_System/Air_System/Manifols/Accessories_Manifolds/Connecting_Couplings/B_Connecting_Couplings.jpg', 'EGDAX00000', '', '', '', 'Whirlpool System-Air System-Manifolds-Manifolds Accessories', NULL),
(71, 'Non-Return Valve', 'Non-return valve to be assembled inside the air-system manifold.', 'Whirlpool_System/Air_System/Manifols/Accessories_Manifolds/Non_Return_Valve/B_Non_Return_Valve.jpg-Whirlpool_System/Air_System/Manifols/Accessories_Manifolds/Non_Return_Valve/Non_Return_Valve_1.jpg', 'VNRCOLL28', '', '', '', 'Whirlpool System-Air System-Manifolds-Manifolds Accessories', NULL),
(72, 'Brass Micro Airjet', 'Brass Micro Airjet Chrome + Adapter.', 'Whirlpool_System/Air_System/Airjet/Airjet_Micro/B_Airjet_Micro.jpg', 'ISJUGLBR05', 'Cover Ø 16 mm + central hole%Total Lenght: 55 mm%Lenght Without Adapter: Ø 53 mm%Adapter Fast Connecting: Ø 10 mm', '', '', 'Whirlpool System-Air System-Airjet', NULL),
(73, 'Airjet Slim', 'Slim airjet cover Ø 25 mm. Body made of nylon with fibre glass charge, with ABS cover and supplied with sealing.', 'Whirlpool_System/Air_System/Airjet/Airjet_Slim/B_Airjet_Slim.jpg', 'ISJUGL102SL5', 'Cover Ø 25 mm', '', '', 'Whirlpool System-Air System-Airjet', NULL),
(74, 'Fast Connection Fitting 90°', 'Fast Connection Fitting 90°', 'Whirlpool_System/Air_System/Pipes_&_Fittings/Airsystem_Fitting_90°/B_Airsystem_Fitting_90°.jpg-Whirlpool_System/Air_System/Pipes_&_Fittings/Airsystem_Fitting_90°/Airsystem_Fitting_90°_1.jpg', 'RR90N10000', '', '', '', 'Whirlpool System-Air System-Pipes & Fittings/Shower System-Shower Fittings', NULL),
(75, 'Fast Connection Fitting Tee', 'Fast Connection Fitting Tee', 'Whirlpool_System/Air_System/Pipes_&_Fittings/Airsystem_Fitting_Tee/B_Airsystem_Fitting_Tee.jpg-Whirlpool_System/Air_System/Pipes_&_Fittings/Airsystem_Fitting_Tee/Airsystem_Fitting_Tee_1.jpg', 'RRTEE10000', '', '', '', 'Whirlpool System-Air System-Pipes & Fittings/Shower System-Shower Fittings', NULL),
(76, 'Fast Connection Fitting Straight', 'Fast Connection Fitting Straight', 'Whirlpool_System/Air_System/Pipes_&_Fittings/Airsystem_Fitting_Straight/B_Airsystem_Fitting_Straight.jpg-Whirlpool_System/Air_System/Pipes_&_Fittings/Airsystem_Fitting_Straight/Airsystem_Fitting_Straight_1.jpg', 'RRDIR1000', '', '', '', 'Whirlpool System-Air System-Pipes & Fittings/Shower System-Shower Fittings', NULL),
(80, 'Air/Microjet Pipe', 'Rilsan-type half-rigid pipe for airystem and microjet kits.', 'Whirlpool_System/Air_System/Pipes_&_Fittings/AirMicro_Pipe/B_AirMicro_Pipe.jpg', 'TPECL10700', 'Internal diameter: Ø 7 mm%External diameter: Ø 10 mm', '', '', 'Whirlpool System-Air System-Pipes & Fittings/Shower System-Shower Fittings\r\n', NULL),
(81, 'Rauclair Pipe', 'Pipe for pneumatic push and cleaning system.', 'Whirlpool_System/Water_System/Pipes,_Fittings_&_Disinfection/Disinfection/Rauclair_Pipe/B_Rauclair_Pipe.jpg', 'ISRTURA0203', 'Internal diameter: Ø 3 mm', '', '', 'Whirlpool System-Air System-Controls-Pneumatic Push Accessories/Whirlpool System-Water System-Pipes, Fittings & Disinfection-Disinfection', NULL),
(84, 'Blower Silence Filter', 'An addictionl filter for blowers to get a more silence performance of motors.', 'Whirlpool_System/Air_System/Blower/Accessories_Blower/Blower_Silence_Filter/B_Blower_Silence_Filter.jpg-Whirlpool_System/Air_System/Blower/Accessories_Blower/Blower_Silence_Filter/Blower_Silence_Filter_1.jpg', 'SILBLO0000', '', '', '', 'Whirlpool System-Air System-Blower-Blower Accessories', NULL),
(86, 'Bifilar Clips', 'Bifilar clips made of steel.\r\n\r\nItem ISRFA000212 for air pipe Ø15x21\r\nItem ISRFA000221 for air pipe Ø15x21\r\nItem ISRFA000258 for jet air connection\r\nItem ISRFA000327 for water pipe Ø25x32\r\nItem ISRFA000415B for blower air pipe\r\nItem ISRFA000458 for suction coupling\r\nItem ISRFA000542 for suction coupling', 'Whirlpool_System/Water_System/Pipes,_Fittings_&_Disinfection/Pipes_&_Fittings/Inox_Bif._Clip_258_for_Pipe_Dia._Air_Jet_Air_Conn/Inox_Bif._Clip_258_for_Pipe_Dia._Air_Jet_Air_Conn..jpg', 'ISRFA000', '', '', 'Steel', 'Whirlpool System-Water System-Pipes, Fittings & Disinfection-Pipes & Fittings', NULL),
(88, 'Plastic Clips', 'Made of plastic.\r\n\r\nItem ISRFA000409P for pipe Ø 9x15 mm F\r\nItem ISRFA000415P for pipe Ø 15x21 mm J\r\nItem ISRFA000419P for pipe Ø 19x26 mm L\r\nItem ISRFA000425P for pipe Ø 25x32 mm\r\nItem ISRFA000432 for pipe Ø 32x40 mm R', 'Whirlpool_System/Water_System/Pipes,_Fittings_&_Disinfection/Pipes_&_Fittings/Plastic_Clip/B_Plastic_Clip.jpg', 'ISRFA0004', '', '', 'Plastic', 'Whirlpool System-Water System-Pipes, Fittings & Disinfection-Pipes & Fittings', NULL),
(89, 'Inox Clips', 'Made of 430 AISI steel.\r\n\r\nItem ISRFA000332 for pipe Ø 25x45 mm\r\nItem ISRFA000340 for pipe Ø 40x60 mm', 'Whirlpool_System/Water_System/Pipes,_Fittings_&_Disinfection/Pipes_&_Fittings/Inox_Clips/Inox_Clips.jpg', 'ISRFA0003', '', '', '430 AISI', 'Whirlpool System-Water System-Pipes, Fittings & Disinfection-Pipes & Fittings/Whirlpool System-Water System-Suctions-Suctions Accessories', NULL),
(90, 'Round H30 without Plate with D-100 Tight Flange', 'Shower drain round H30 with removable siphon.\r\nWithout plate with D-100 Tight Flange.\r\nShower tray hole: Ø 90 mm\r\nOutlet with connecting nut: Ø 40 mm\r\n\r\nFor more information take a look to the PDF below.', 'Shower_System/Shower_Drains/Shower_Drains/Round_Shower_Drain_H30_without_Plate_with_D100_Tight_Flange/B_Round_Shower_Drain_H30_without_Plate_with_D100_Tight_Flange.jpg', 'SD-9031100', '', '', '', 'Shower System-Shower Drains-Round', 'Round.pdf'),
(91, 'Round H50 without Plate with D-100 Tight Flange', 'Shower drain round H50 with removable siphon.\r\nWithout plate with D-100 Tight Flange.\r\nShower tray hole: Ø 90 mm\r\nOutlet with connecting nut: Ø 40 mm\r\n\r\nFor more information take a look to the PDF below.', 'Shower_System/Shower_Drains/Shower_Drains/Round_Shower_Drain_H50_without_Plate_with_D100_Tight_Flange/B_Round_Shower_Drain_H50_without_Plate_with_D100_Tight_Flange.jpg', 'SD-9051100', '', '', '', 'Shower System-Shower Drains-Round', 'Round.pdf'),
(92, 'Rectangular 3 Siphon Slim H25', 'Rectanguar shower drain with removable siphon.\r\n\r\nShower tray hole: 26x300 mm\r\nOutlet with connecting nut diam.: Ø 40 mm\r\n\r\nFor more information take a look to the PDF below.', 'Shower_System/Shower_Drains/Shower_Drains/Rectangular_3_Syphon_Shower_Drain__Slim_H25/B_Rectangular_3_Syphon_Shower_Drain__Slim_H25.jpg', 'SRHSLIM25-1', '', '', '', 'Shower System-Shower Drains-Rectangular 3 Siphon', 'Rectangular_3_Siphon_Slim_H25.pdf'),
(93, 'Non-Return valve', 'Non-return valve for air regulator; to be fixed with glue or clamp.', 'Whirlpool_System/Water_System/Pipes,_Fittings_&_Disinfection/Pipes_&_Fittings/Non_Return_Valve/B_Non_Return_Valve.jpg', 'ISNRV002020', 'Connection: Ø 20 mm', '', '', 'Whirlpool System-Water System-Pipes, Fittings & Disinfection-Pipes & Fittings', NULL),
(94, 'PVC Flex Pipe', 'Flex pipe for suction dia. 40 mm. Supplied in roll (1 roll = 30 mt)\r\nExternal diameter is subjected to changes and Sacith is disclaiming all responsibility for eventual modification in time of these external size.', 'Whirlpool_System/Water_System/Pipes,_Fittings_&_Disinfection/Pipes_&_Fittings/Flex_Pipe_PVC_Dia._32x40/Flex_Pipe_PVC_Dia._32x40.jpg', 'ISRTUFL0232', 'Internal Ø 32x40 mm', '', 'PVC', 'Whirlpool System-Water System-Pipes, Fittings & Disinfection-Pipes & Fittings/Whirlpool System-Water System-Suctions-Suctions Accessories', NULL),
(95, 'Adapter 45° GB', 'Adapter 45° for GB Size Drain', 'Shower_System/Shower_Drains/Accessories_Shower_Drains/Adapter_45°_for_GB_Size_Drain/B_Adapter_45°_for_GB_Size_Drain.jpg', 'ISRED5040SH', '', '', '', 'Shower System-Shower Drains-Shower Drains Accessories', NULL),
(96, 'Adapter 45° EU', 'Adapter 45° for EU Size Drain', 'Shower_System/Shower_Drains/Accessories_Shower_Drains/Adapter_45°_for_GB_Size_Drain/B_Adapter_45°_for_GB_Size_Drain.jpg', 'ISRED5040EU', '', '', '', 'Shower System-Shower Drains-Shower Drains Accessories', NULL),
(97, 'PVC Jet Plug', 'Optional PVC Plug for jet with 2 outlet body.\r\n\r\nItem ISETAP10020 for PVC jet\r\nItem ISRTA020016 for PVC minijet', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Accessories_Jet/PVC_Jet_Plug.jpg', 'ISRTAP', '', '', '', 'Whirlpool System-Water System-Jets-Jets Accessories', NULL),
(98, 'Flat Sponge Gasket for Jets', 'Flat sponge gasket for jets units.\r\n\r\nItem ISRGU016004 Ø 60 mm for regular jet glue\r\nItem ISRGU024044 Ø 44 mm for Minijet\r\nItem ISRGUA63494 Ø 63 mm for Multijet / Slim Jet / Line Jet', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Accessories_Jet/Flat_Sponge_Gasket(ISRGU016004).jpg', 'ISRGUJET', '', '', '', 'Whirlpool System-Water System-Jets-Jets Accessories', NULL),
(99, 'Keys for Jets', 'Keys for Jets.\r\n\r\nItem ISRCHBO0300 for Flat Jet\r\nItem ISRCHMJ0300 for Minijet, Square Jet\r\nItem ISRCHMUJ000 for Multi Jet\r\nItem ISJLINEKEY01 for Line Jet, Slim Jet', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Accessories_Jet/Keys.jpg', 'ISRCHJET', '', '', '', 'Whirlpool System-Water System-Jets-Jets Accessories', NULL),
(100, 'U Seal Gasket for Jets', 'U Seal Gasket for Jets.\r\n\r\nItem ISRGUFLAT000 for Flat Jet, Square Jet\r\nItem ISRGUMJR000 for Multi Jet', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Accessories_Suctions/U_Seal_Gasket(ISRGUFLAT000)/U_Seal_Gasket(ISRGUFLAT000).jpg', 'ISRGUSJET', '', '', '', 'Whirlpool System-Water System-Jets-Jets Accessories', NULL),
(101, 'Flat Sponge Gasket for Suctions', 'Flat sponge gasket for 3F Suctions and Slim Suction.', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Accessories_Suctions/Flat_Sponge_Gasket(ISRGU016004)/Flat_Sponge_Gasket(ISRGU016004).jpg', 'ISRGUSUC', '', '', '', 'Whirlpool System-Water System-Suctions-Suctions Accessories', NULL),
(102, 'Keys for Suctions', 'Keys for Suctions\r\n\r\nItem ISRCHBO0300 for 3F Suctions, Standard Suction\r\nItem ISJSUCKEYSL00 for Slim Suction', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Accessories_Jet/Keys.jpg', 'ISRCHSUC', '', '', '', 'Whirlpool System-Water System-Suctions-Suctions Accessories', NULL),
(103, 'U Seal Gasket for Suctions', 'U Seal Gasket for Suctions.\r\n\r\nItem ISRGUFLAT000 for 3F Suctions, Slim, Square and Standard Suction', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Accessories_Suctions/U_Seal_Gasket(ISRGUFLAT000)/U_Seal_Gasket(ISRGUFLAT000).jpg', 'ISRGUSSUC', '', '', '', 'Whirlpool System-Water System-Suctions-Suctions Accessories', NULL),
(104, 'Plastic Clamp', 'Made of plastic.\r\nInternal diam.: Ø 9 mm', 'Shower_System/Shower_Fittings/Plastic_Clamp/Plastic_Clamp.jpg', 'ISRFA000409', '', '', 'Plastic', 'Shower System-Shower Fittings', ''),
(105, 'PVC Retex Pipe', 'The external diameter of flexible pipes is subject to variations and Sacith is disclaimin any responsibility for eventual modifications in time of external sizes of pipes.\r\nPipe for shower jet.', 'Shower_System/Shower_Fittings/PVC_Retex_Pipe/PVC_Retex_Pipe.jpg', 'ISTURE0209', 'Internal diam.: Ø 9 mm', '', 'PVC Retex', 'Shower System-Shower Fittings', ''),
(106, 'DRM 60 Pump', 'Max H 8,1 m\r\nMax 250 lt/min\r\nAmp. 2,5\r\nHP 0,71\r\nKW 0,53\r\n\r\nThese pumps are specifically designed for whirlpools application. Compact shape and efficiency are the main characteristics of these pumps together with last generation technical solutions.\r\n\r\nAll models of pumps are available also with switch.\r\n\r\nCHARACTERISTICS:\r\n• Pump equipped with electrical feeding cable.\r\n• With fittings: straight union for suction and tee-piece for water delivery.\r\n\r\nPUMP DETAILS:\r\nClosed motor with external ventilation and aluminium box with cooling wings.\r\n• IP X5 protection.\r\n• Integrated overloading protection and automatic reset.\r\n• Self draining pump body made of Polypropilene PP30GF.\r\n• Impeller made of NORYL-PPOGFN.\r\n• Mechanical sealing made of graphite / ceramics.\r\n• NBR sealings.', 'Whirlpool_System/Water_System/Pumps/Pump/Pump_No_Switch.jpg', 'AMVC0600DRM', '', '', '', 'Whirlpool System-Water System-Pumps', ''),
(107, 'DRM 60 + Switch Pump', 'Max H 8,1 m\r\nMax 250 lt/min\r\nAmp. 2,5\r\nHP 0,71\r\nKW 0,53\r\n\r\nThese pumps are specifically designed for whirlpools application. Compact shape and efficiency are the main characteristics of these pumps together with last generation technical solutions.\r\n\r\nAll models of pumps are available also with switch.\r\n\r\nCHARACTERISTICS:\r\n• Pump equipped with electrical feeding cable.\r\n• With fittings: straight union for suction and tee-piece for water delivery.\r\n\r\nPUMP DETAILS:\r\nClosed motor with external ventilation and aluminium box with cooling wings.\r\n• IP X5 protection.\r\n• Integrated overloading protection and automatic reset.\r\n• Self draining pump body made of Polypropilene PP30GF.\r\n• Impeller made of NORYL-PPOGFN.\r\n• Mechanical sealing made of graphite / ceramics.\r\n• NBR sealings.', 'Whirlpool_System/Water_System/Pumps/Pump/Pump.jpg', 'AMVC0601DRM', '', '', '', 'Whirlpool System-Water System-Pumps', ''),
(108, 'DRM 80 Pump', 'Max H 9,5 m\r\nMax 295 lt/min\r\nAmp. 3,7\r\nHP 1,1\r\nKW 0,81\r\n\r\nThese pumps are specifically designed for whirlpools application. Compact shape and efficiency are the main characteristics of these pumps together with last generation technical solutions.\r\n\r\nAll models of pumps are available also with switch.\r\n\r\nCHARACTERISTICS:\r\n• Pump equipped with electrical feeding cable.\r\n• With fittings: straight union for suction and tee-piece for water delivery.\r\n\r\nPUMP DETAILS:\r\nClosed motor with external ventilation and aluminium box with cooling wings.\r\n• IP X5 protection.\r\n• Integrated overloading protection and automatic reset.\r\n• Self draining pump body made of Polypropilene PP30GF.\r\n• Impeller made of NORYL-PPOGFN.\r\n• Mechanical sealing made of graphite / ceramics.\r\n• NBR sealings.', 'Whirlpool_System/Water_System/Pumps/Pump/Pump_No_Switch.jpg', 'AMVC0800DRM', '', '', '', 'Whirlpool System-Water System-Pumps', ''),
(109, 'DRM 80 + Switch Pump', 'Max H 9,5 m\r\nMax 295 lt/min\r\nAmp. 3,7\r\nHP 1,1\r\nKW 0,81\r\n\r\nThese pumps are specifically designed for whirlpools application. Compact shape and efficiency are the main characteristics of these pumps together with last generation technical solutions.\r\n\r\nAll models of pumps are available also with switch.\r\n\r\nCHARACTERISTICS:\r\n• Pump equipped with electrical feeding cable.\r\n• With fittings: straight union for suction and tee-piece for water delivery.\r\n\r\nPUMP DETAILS:\r\nClosed motor with external ventilation and aluminium box with cooling wings.\r\n• IP X5 protection.\r\n• Integrated overloading protection and automatic reset.\r\n• Self draining pump body made of Polypropilene PP30GF.\r\n• Impeller made of NORYL-PPOGFN.\r\n• Mechanical sealing made of graphite / ceramics.\r\n• NBR sealings.', 'Whirlpool_System/Water_System/Pumps/Pump/Pump.jpg', 'AMVC0801DRM', '', '', '', 'Whirlpool System-Water System-Pumps', ''),
(110, 'DRM 120 Pump', 'Max H 12 m\r\nMax 420 lt/min\r\nAmp. 5,6\r\nHP 1,5\r\nKW 1,2\r\n\r\nThese pumps are specifically designed for whirlpools application. Compact shape and efficiency are the main characteristics of these pumps together with last generation technical solutions.\r\n\r\nAll models of pumps are available also with switch.\r\n\r\nCHARACTERISTICS:\r\n• Pump equipped with electrical feeding cable.\r\n• With fittings: straight union for suction and tee-piece for water delivery.\r\n\r\nPUMP DETAILS:\r\nClosed motor with external ventilation and aluminium box with cooling wings.\r\n• IP X5 protection.\r\n• Integrated overloading protection and automatic reset.\r\n• Self draining pump body made of Polypropilene PP30GF.\r\n• Impeller made of NORYL-PPOGFN.\r\n• Mechanical sealing made of graphite / ceramics.\r\n• NBR sealings.', 'Whirlpool_System/Water_System/Pumps/Pump/Pump_No_Switch.jpg', 'AMVC1200DRM', '', '', '', 'Whirlpool System-Water System-Pumps', ''),
(111, 'DRM 120 + Switch Pump', 'Max H 12 m\r\nMax 420 lt/min\r\nAmp. 5,6\r\nHP 1,5\r\nKW 1,2\r\n\r\nThese pumps are specifically designed for whirlpools application. Compact shape and efficiency are the main characteristics of these pumps together with last generation technical solutions.\r\n\r\nAll models of pumps are available also with switch.\r\n\r\nCHARACTERISTICS:\r\n• Pump equipped with electrical feeding cable.\r\n• With fittings: straight union for suction and tee-piece for water delivery.\r\n\r\nPUMP DETAILS:\r\nClosed motor with external ventilation and aluminium box with cooling wings.\r\n• IP X5 protection.\r\n• Integrated overloading protection and automatic reset.\r\n• Self draining pump body made of Polypropilene PP30GF.\r\n• Impeller made of NORYL-PPOGFN.\r\n• Mechanical sealing made of graphite / ceramics.\r\n• NBR sealings.', 'Whirlpool_System/Water_System/Pumps/Pump/Pump.jpg', 'AMVC1201DRM', '', '', '', 'Whirlpool System-Water System-Pumps', ''),
(112, 'Cleaning Nozzle', 'Made of solid brass.', 'Whirlpool_System/Water_System/Pipes,_Fittings_&_Disinfection/Disinfection/Cleaning_Nozzle/B_Cleaning_Nozzle.JPG-Whirlpool_System/Water_System/Pipes,_Fittings_&_Disinfection/Disinfection/Cleaning_Nozzle/Cleaning_Nozzle_1.jpg', 'ISJUGI30305', 'External diam.: Ø 20 mm%Hole: Ø 13 mm', 'Chrome', 'Brass', 'Whirlpool System-Water System-Pipes, Fittings & Disinfection-Disinfection', ''),
(113, 'Cleaning Tank', 'Capacity 1 liter. Made of Poliethylene. Tank and dosign pump holder made of zinc coated steel.\r\n\r\nItem ISRSI000200 Tank\r\nItem ISJSISU03ZI Holder', 'Whirlpool_System/Water_System/Pipes,_Fittings_&_Disinfection/Disinfection/Cleaning_Tank/B_Cleaning_Tank.jpg-Whirlpool_System/Water_System/Pipes,_Fittings_&_Disinfection/Disinfection/Cleaning_Tank/Cleaning_Tank_1.jpg', 'ISRSI000200', '', '', 'Poliethylene & Zinc coated steel', 'Whirlpool System-Water System-Pipes, Fittings & Disinfection-Disinfection', ''),
(114, 'Level Sensor', 'Self-setting electronic level sensor 1 mt long cable.', 'Whirlpool_System/Water_System/Pipes,_Fittings_&_Disinfection/Disinfection/Level_Sensor/B_Level_Sensor.jpg', 'ISMSLC0000N', '', '', '', 'Whirlpool System-Water System-Pipes, Fittings & Disinfection-Disinfection-Pipes & fittings/Whirlpool system-water system-basic hydro kit', ''),
(115, 'PVC Retex Pipe', 'Retex pipe different diameters. External diameter is subjetced to changes and Sacith is disclaiming all responsibility for eventual modifications in time of these external size.\r\n\r\nISRTURE0209 internal dia. 9 mm for shower jet\r\nISRTURE0215 internal dia. 15 mm for air minijet/multijet/flat jet\r\nISRTURE0219 internal dia. 19 mm for air maxi jet and air regulator\r\nISRTURE0223 internal dia. 25 mm for water line to jets\r\nISRTURE0338 dia 30x38 mm for microjet kit\r\n\r\n', 'Whirlpool_System/Water_System/Pipes,_Fittings_&_Disinfection/Pipes_&_Fittings/PVC_Retex_Pipe_Dia._30x38/PVC_Retex_Pipe_Dia._30x38.jpg', 'ISRTURE0', '', '', 'PVC', 'Whirlpool System-Water System-Pipes, Fittings & Disinfection-Pipes & Fittings', ''),
(116, 'Air reduction', 'Air reduction for microjet system. \r\n\r\nISRAJET2010M Air reduction Ø 20/10 mm for Maxi jet and Flat Jet\r\nISRAMJT1610M Air reduction Ø 16/10 mm for Minijet, Multijet, and Flat Jet', 'Whirlpool_System/Water_System/Pipes,_Fittings_&_Disinfection/Pipes_&_Fittings/Air_Reduction/Air_Reduction.jpg', 'ISRA', '', '', '', 'Whirlpool System-Water System-Pipes, Fittings & Disinfection-Pipes & Fittings', ''),
(117, 'Tee piece for air ', 'Tee piece for air to be installed with clamps.\r\n\r\nItem ISRTE001620 Ø 16/20/16 mm\r\nItem ISRTE202020 Ø 20/20/20 mm ', 'Whirlpool_System/Water_System/Pipes,_Fittings_&_Disinfection/Pipes_&_Fittings/Tee_Piece_for_Air/Tee_Piece_for_Air.jpg', 'ISRTE', '', '', '', 'Whirlpool Systems-Water System-Pipes, Fittings & Disinfection-Pipes & Fittings', ''),
(118, 'Tee for Micro Kit -  no glue', 'Special tee-piece for glue free connection to the pump with a deviation for the microjet kit. Tee-piece is installed directly onto the pump outlet without glue.', 'Whirlpool_System/Water_System/Pipes,_Fittings_&_Disinfection/Pipes_&_Fittings/Tee_for_Microjet_Kit_No_Glue/Tee_for_Microjet_Kit_No_Glue.jpg', 'ARTE25MJ32E', 'External: Ø 25x25x32', '', '', 'Whirlpool Systems-Water System-Pumps-Pumps Accessories', ''),
(119, 'Soft PVC coupling for pump/suction', 'Soft rubber coupling for pump/suction', 'Whirlpool_System/Water_System/Pumps/Pumps_Accessories/Soft_PVC_Coupling/Soft_PVC_Coupling.jpg', 'ARASMP000', '', '', 'PVC', 'Whirlpool Systems-Water System-Pumps-Pumps Accessories/Whirlpool System-Water System-Suctions-Suctions Accessories', ''),
(120, 'Smart Tee no glue + ring', 'Special Tee-piece for connection to the pump with clamps, without glue.', 'Whirlpool_System/Water_System/Pumps/Pumps_Accessories/Smart_Tee_No_Glue/B_Smart_Tee_No_Glue.JPG-Whirlpool_System/Water_System/Pumps/Pumps_Accessories/Smart_Tee_No_Glue/Smart_Tee_No_Glue_1.JPG', 'ISRLSMTAN25E', 'External: Ø 25 mm', '', '', 'Whirlpool Systems-Water System-Pumps-Pumps Accessories', ''),
(121, '45° Pump Elbow ', '45° Elbow for pump connection to suction, installation with clamps or glue.', 'Whirlpool_System/Water_System/Pumps/Pumps_Accessories/45°_Pump_Elbow/45°_Pump_Elbow.jpg', 'ISRASMG450', 'Internal: Ø 40 mm', '', '', 'Whirlpool Systems-Water System-Pumps-Pumps Accessories', ''),
(122, 'PVC Rigid pipe', 'PVC Rigid pipe for suction. Glue fitting.', 'Whirlpool_System/Water_System/Pipes,_Fittings_&_Disinfection/Pipes_&_Fittings/PVC_Rigid_Pipe/PVC_Rigid_Pipe.JPG', 'ISRTURI0240', 'External: Ø 40 mm', '', '', 'Whirlpool Systems-Water System-Pipes, Fittings & Disinfection-Pipes & Fittings/Whirlpool System-Water System-Suctions-Suctions Accessories', ''),
(123, 'Pneumatic Switch', '6A-250V micro-switch for pump and blower. Held with a screw.\r\nAir connection Ø 3 mm\r\nFixing hole Ø 14 mm', 'Whirlpool_System/Water_System/Pumps/Pumps_Accessories/Pneumatic_Switch/B_Pneumatic_Switch.JPG-Whirlpool_System/Water_System/Pumps/Pumps_Accessories/Pneumatic_Switch/Pneumatic_Switch_1.JPG', 'ISMSW010000', '', '', '', 'Whirlpool Systems-Water System-Pumps-Pumps Accessories', ''),
(124, 'Panel fixing bar', 'Bathtub panel fixing bar', 'Whirlpool_System/Water_System/Pipes,_Fittings_&_Disinfection/Pipes_&_Fittings/Panel_fixing_bar/Panel_fixing_bar.JPG', 'ISPHOLD000', '', '', '', 'Whirlpool Systems-Water System-Pipes, Fittings & Disinfection-Pipes & Fittings', ''),
(125, 'Panel fixing spring', 'Bathtub panel fixing spring', 'Whirlpool_System/Water_System/Pipes,_Fittings_&_Disinfection/Pipes_&_Fittings/Panel_fixing_spring/B_Panel_fixing_spring.JPG-Whirlpool_System/Water_System/Pipes,_Fittings_&_Disinfection/Pipes_&_Fittings/Panel_fixing_spring/Panel_fixing_spring_1.JPG', 'ISPSPRING00', '', '', '', 'Whirlpool Systems-Water System-Pipes, Fittings & Disinfection-Pipes & Fittings', ''),
(126, 'Flat Pneumatic Push Double Color \"Small\"', 'Flat pneumatic push, small external cover diameter and thin thickness. Double color chrome/white. It can be dismantled from the bath side.\r\nExternal cover Ø 46 mm\r\nHole Ø 40 mm', 'Whirlpool_System/Water_System/Controls/Flat_Pneumatic_Push_Small/Flat_Pneumatic_Push_Small.JPG', 'ISPSTSLDC00', 'External cover: Ø 46 mm', '', 'ABS', 'Whirlpool Systems-Water System-Controls', ''),
(127, 'PVC Elbow 90°', 'Suction elbow 90° for cement jointing.', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Accessories_Suctions/PVC_Elbow_90°/PVC_Elbow_90°.jpg', 'ISRGO900240', 'Ø 40 mm', '', 'PVC', 'Whirlpool System-Water System-Suctions-Suctions Accessories', ''),
(128, 'Fast Connecting Fitting Plug', 'Plug for fast connecting fitting Ø 10 mm', 'Whirlpool_System/Air_System/Manifols/Accessories_Manifolds/Fast_Connecting_Fitting_Plug/Fast_Connecting_Fitting_Plug.JPG', 'ISRASTAP10N', 'Ø 10 mm', '', '', 'Whirlpool System-Air System-Manifolds-Manifolds Accessories', ''),
(129, '3F Safety Valve ', 'Safety valve for 3F suction jet.', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Suctions/Suction_3F/Optional/Safety_Valve/Safety_Valve.jpg', 'ISJVAS01000', '', '', 'ABS', 'Whirlpool System-Water System-Suctions-Suctions Accessories', ''),
(130, 'Microjet Moon St', 'Brand new Microjet of \"moon\" family.\r\nUltra-flat design.', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Microjets/Microjet_Moon_St/B_Microjet_Moon_St.png', 'MNMCJPL05', '', 'Chrome', 'Brass', 'Whirlpool System-Water System-Microjets', 'Moon_Family.pdf'),
(131, 'Microjet Moon Bi', 'Brand new Microjet of \"moon\" family.\r\nUltra-flat design.\r\nMade by cover and insert, it allows to create a bi-color configuration.', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Microjets/Microjet_Moon_Bi/B_Microjet_Moon_Bi.png', 'MNMCJBI', '', 'Chrome', 'Brass', 'Whirlpool System-Water System-Microjets', 'Moon_Family.pdf');

-- --------------------------------------------------------

--
-- Struttura della tabella `StrutturaKit`
--

CREATE TABLE `StrutturaKit` (
  `id` int NOT NULL,
  `codice_kit` varchar(255) NOT NULL,
  `codice_prodottoSingolo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `codice_prodottoConfigurabile` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `titolo_configurazione` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `StrutturaKit`
--

INSERT INTO `StrutturaKit` (`id`, `codice_kit`, `codice_prodottoSingolo`, `codice_prodottoConfigurabile`, `titolo_configurazione`) VALUES
(43, 'ISKBAIR12E5', NULL, 'ISJUGL102P5', 'Airjet'),
(44, 'ISKBAIR12E5', 'ISJUGL102SL5', NULL, 'Airjet'),
(45, 'ISKBAIR12E5', 'ISJUGLBR05', NULL, 'Airjet'),
(46, 'ISKBAIR12E5', 'RR90N10000', NULL, 'Fast Connecting'),
(47, 'ISKBAIR12E5', 'RRTEE10000', NULL, 'Fast Connecting'),
(48, 'ISKBAIR12E5', 'RRDIR1000', NULL, 'Fast Connecting'),
(49, 'ISKBAIR12E5', 'DAARD10120', NULL, 'Fast Connecting Manifold'),
(50, 'ISKBAIR12E5', NULL, 'ISJCO6PLR10', 'Fast Connecting Manifold'),
(51, 'ISKBAIR12E5', 'DAARD10060', NULL, 'Fast Connecting Manifold'),
(52, 'ISKBAIR12E5', 'DAARD10080', NULL, 'Fast Connecting Manifold'),
(55, 'ISKBAIR12E5', 'ECO2700SW', NULL, 'Blower'),
(61, 'ISKBAIR12E5', 'ECO2400SW', NULL, 'Blower'),
(62, 'ISKBAIR12E5', NULL, 'ISPSTFLAT05', 'Pneumatic Push'),
(63, 'ISKBAIR12E5', NULL, 'ISPST020105', 'Pneumatic Push'),
(64, 'ISKBAIR12E5', 'SDAXX000000', NULL, 'Non Configurabili'),
(65, 'ISKBAIR12E5', 'SALH400N', NULL, 'Non Configurabili'),
(66, 'ISKBAIR12E5', 'MANDIR3232', NULL, 'Non Configurabili'),
(67, 'ISKBAIR12E5', 'MANDIRFD32', NULL, 'Non Configurabili'),
(68, 'ISKBAIR12E5', 'MAN90FD32', NULL, 'Non Configurabili'),
(69, 'ISKBAIR12E5', 'TPECL10700', NULL, 'Non Configurabili'),
(72, 'ISKBAIR12E5', 'TUBN2800', NULL, 'Non Configurabili'),
(73, 'ISKBAIR12E5', 'ISRTURA0203', NULL, 'Non Configurabili'),
(75, 'ISKBAIR12E5', 'SILBLO0000', NULL, 'Optional'),
(76, 'ISKBAIR12E5', 'SALH180N', NULL, 'Optional'),
(77, 'ISKBAIR12E5', 'VNR32M32F32', NULL, 'Optional'),
(78, 'ISKBAIR12E5', 'VNRCOLL28', NULL, 'Optional'),
(80, 'ISKMUL6V255', NULL, 'ISJPL3F0105', 'Suction'),
(81, 'ISKMUL6V255', NULL, 'ISJPL3FL105', 'Suction'),
(82, 'ISKMUL6V255', NULL, 'ISPL3FSQU05', 'Suction'),
(83, 'ISKMUL6V255', NULL, 'ISJPL040105', 'Suction'),
(84, 'ISKMUL6V255', NULL, 'ISJPLSULIM005', 'Suction'),
(85, 'ISKMUL6V255', NULL, 'ISJMULJ', 'Jet'),
(86, 'ISKMUL6V255', NULL, 'MNJ', 'Jet'),
(87, 'ISKMUL6V255', NULL, 'ISJLINEA005', 'Jet'),
(88, 'ISKMUL6V255', NULL, 'ISJBO020201', 'Jet'),
(89, 'ISKMUL6V255', NULL, 'ISJSLIMA005', 'Jet'),
(90, 'ISKMUL6V255', NULL, 'ISJNFLAT', 'Jet'),
(91, 'ISKMUL6V255', NULL, 'ISJNSQU', 'Jet'),
(92, 'ISKMUL6V255', NULL, 'ISPSTFLAT05', 'Pneumatic Push'),
(93, 'ISKMUL6V255', NULL, 'ISPST020105', 'Pneumatic Push'),
(94, 'ISKMUL6V255', NULL, 'ISPRFLAT05', 'Air Regulator'),
(95, 'ISKMUL6V255', NULL, 'ISPRNEW0105', 'Air Regulator'),
(96, 'ISKMUL6V255', NULL, 'ISPSREGFL05', 'Pneumatic Push'),
(104, 'ISKMUL6V255', 'ISRTURA0203', NULL, 'Non Configurabili'),
(105, 'ISKMUL6V255', 'ISRFA000', NULL, 'Non Configurabili'),
(106, 'ISKMUL6V255', 'ISRFA0003', NULL, 'Non Configurabili'),
(107, 'ISKMUL6V255', 'ISRTURE0', NULL, 'Non Configurabili'),
(108, 'ISKMUL6V255', 'ISRTE', NULL, 'Non Configurabili'),
(110, 'ISKMUL6V255', 'ARASMP000', NULL, 'Non Configurabili'),
(111, 'ISKMICJ6RA05', NULL, 'ISBOMRJOC5FL', 'Microjet Simple'),
(112, 'ISKMICJ6RA05', NULL, 'ISBOMRJOC5', 'Microjet Simple'),
(113, 'ISKMICJ6RA05', NULL, 'ISBOMRJP5FL', 'Microjet Fast Connection'),
(114, 'ISKMICJ6RA05', NULL, 'ISBOMRJP5', 'Microjet Fast Connection'),
(115, 'ISKMICJ6RA05', NULL, 'ISJCO6PLR10', 'Non Configurabili'),
(121, 'ISKMUL6V255', 'ISRTUFL0232', NULL, 'Non Configurabili'),
(122, 'ISKMICJ6RA05', 'ISRFA000', NULL, 'Non Configurabili'),
(125, 'ISKMUL6V255', 'AMVC0601DRM', NULL, 'Pump'),
(126, 'ISKMUL6V255', 'AMVC0600DRM', NULL, 'Pump'),
(127, 'ISKMUL6V255', 'AMVC0801DRM', NULL, 'Pump'),
(128, 'ISKMUL6V255', 'AMVC0800DRM', NULL, 'Pump'),
(129, 'ISKMUL6V255', 'AMVC1201DRM', NULL, 'Pump'),
(130, 'ISKMUL6V255', 'AMVC1200DRM', NULL, 'Pump'),
(131, 'ISKMICJ6RA05', 'DAARD10060', NULL, 'Manifold'),
(132, 'ISKMICJ6RA05', 'DAARD10080', NULL, 'Manifold'),
(133, 'ISKMICJ6RA05', 'DAARD10120', NULL, 'Manifold'),
(134, 'ISKMICJ6RA05', NULL, 'ISPRFLAT05', 'Air Regulator'),
(135, 'ISKMICJ6RA05', NULL, 'ISPRNEW0105', 'Air Regulator'),
(137, 'ISKMICJ6RA05', 'RR90N10000', NULL, 'Fittings'),
(138, 'ISKMICJ6RA05', 'RRTEE10000', NULL, 'Fittings'),
(139, 'ISKMICJ6RA05', 'RRDIR1000', NULL, 'Fittings'),
(140, 'ISKMICJ6RA05', 'ISRTURE0', NULL, 'Non Configurabili'),
(141, 'ISKMICJ6RA05', 'ARTE25MJ32E', NULL, 'Non Configurabili'),
(142, 'ISKMICJ6RA05', 'TPECL10700', NULL, 'Non Configurabili'),
(143, 'ISKMICJ6RA05', 'ISRA', NULL, 'Non Configurabili'),
(144, 'ISKMUL6V255', 'ISPSTSLDC00', NULL, 'Pneumatic Push'),
(145, 'ISKBAIR12E5', 'ISPSTSLDC00', NULL, 'Pneumatic Push');

-- --------------------------------------------------------

--
-- Struttura della tabella `StrutturaPC`
--

CREATE TABLE `StrutturaPC` (
  `id` int NOT NULL,
  `nome` varchar(255) NOT NULL,
  `immagine` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tipo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `titolo_configurazione` varchar(255) NOT NULL,
  `codice_pc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `StrutturaPC`
--

INSERT INTO `StrutturaPC` (`id`, `nome`, `immagine`, `tipo`, `titolo_configurazione`, `codice_pc`) VALUES
(11, 'ISJCO6PLR10: 6 Outlet Manifold', 'Whirlpool_System/Air_System/Manifols/Manifolds/Manifold_6_Outlet_Isj/Outlet/6_Outlet.jpg', '', 'Outlet', 'ISJCO6PLR10'),
(12, 'ISJCO66PLR10: Double 12 Outlet Manifold', 'Whirlpool_System/Air_System/Manifols/Manifolds/Manifold_6_Outlet_Isj/Outlet/12_Outlet.JPG', '', 'Outlet', 'ISJCO6PLR10'),
(13, 'ISJCO6PVC10: 6 Outlet PVC Manifold- suitable for glue', 'Whirlpool_System/Air_System/Manifols/Manifolds/Manifold_6_Outlet_Isj/Material/PVC.JPG', '', 'Material', 'ISJCO6PLR10'),
(14, 'ISJUGL102P5: Chome ABS Cover', 'Whirlpool_System/Air_System/Airjet/Airjet/Cover/Cover_Cromo.jpg', '', 'Cover', 'ISJUGL102P5'),
(15, 'ISJUGL102P1: White ABS Cover', 'Whirlpool_System/Air_System/Airjet/Airjet/Cover/Cover_Bianca.jpg', '', 'Cover', 'ISJUGL102P5'),
(16, 'ISPST020105: Chome Cover', 'Whirlpool_System/Air_System/Controls/Pneumatic_Push/Round_Pneumatic_Push/Cover/Cover_Chrome.jpg', '', 'Cover', 'ISPST020105'),
(17, 'ISPST020101: White Cover', 'Whirlpool_System/Air_System/Controls/Pneumatic_Push/Round_Pneumatic_Push/Cover/Cover_White.jpg', '', 'Cover', 'ISPST020105'),
(18, 'ISPSTFLAT05: Chome Cover', 'Whirlpool_System/Air_System/Controls/Pneumatic_Push/Flat_Pneumatic_Push/Cover/Cover_Chrome.jpg', '', 'Cover', 'ISPSTFLAT05'),
(19, 'ISPSTFLAT01: White Cover', 'Whirlpool_System/Air_System/Controls/Pneumatic_Push/Flat_Pneumatic_Push/Cover/Cover_White.jpg', '', 'Cover', 'ISPSTFLAT05'),
(20, 'ISPSTFLAT05S: Chrome Cover + Serigraphy', 'Whirlpool_System/Air_System/Controls/Pneumatic_Push/Flat_Pneumatic_Push/Serigraphy/Serigraphy.jpg', '', 'Serigraphy', 'ISPSTFLAT05'),
(21, 'ISPRNEW0105: Chrome Cover', 'Whirlpool_System/Water_System/Controls/Air_Regulator/Cover/Cover_Chrome.jpg', 'Finiture', 'Cover', 'ISPRNEW0105'),
(22, 'ISPRNEW0100: White Cover', 'Whirlpool_System/Water_System/Controls/Air_Regulator/Cover/Cover_White.jpg', 'Finiture', 'Cover', 'ISPRNEW0105'),
(23, 'ISPRFLAT05: Chrome Cover', 'Whirlpool_System/Water_System/Controls/Flat_Air_Regulator/Cover/Cover_Chrome.jpg', NULL, 'Cover', 'ISPRFLAT05'),
(24, 'ISPRFLAT05: White Cover', 'Whirlpool_System/Water_System/Controls/Flat_Air_Regulator/Cover/Cover_White.jpg', NULL, 'Cover', 'ISPRFLAT05'),
(25, 'ISPRFLAT05S: Chrome Cover with Serigraphy', 'Whirlpool_System/Water_System/Controls/Flat_Air_Regulator/Serigraphy/Serigraphy.jpg', NULL, 'Serigraphy', 'ISPRFLAT05'),
(27, 'ISPSREGFL05: Chrome Cover', 'Whirlpool_System/Water_System/Controls/Flat_Pneumatic_Control_All_In_One/Cover/Cover_Chrome.jpg', NULL, 'Cover', 'ISPSREGFL05'),
(28, 'ISPSREGFL05: White Cover', 'Whirlpool_System/Water_System/Controls/Flat_Pneumatic_Control_All_In_One/Cover/Cover_White.jpg', NULL, 'Cover', 'ISPSREGFL05'),
(29, 'ISPSREGFL05S: Chrome Cover with Serigraphy', 'Whirlpool_System/Water_System/Controls/Flat_Pneumatic_Control_All_In_One/Serigraphy/Serigraphy.jpg', NULL, 'Serigraphy', 'ISPSREGFL05'),
(32, 'ISBOMRJP5FL: Chrome Cover', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Microjets/Microjet_Flat/Microjet_Flat_P/Cover/Cover_Chrome.jpg', NULL, 'Cover', 'ISBOMRJP5FL'),
(33, 'ISBOMRJP1FL: White Cover', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Microjets/Microjet_Flat/Microjet_Flat_P/Cover/Cover_White.jpg', NULL, 'Cover', 'ISBOMRJP5FL'),
(34, 'ISBOMRJOC5FL: Chrome Cover', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Microjets/Microjet_Flat/Microjet_Flat_Oc/Cover/Cover_Chrome.jpg', NULL, 'Cover', 'ISBOMRJOC5FL'),
(35, 'ISBOMRJOC1FL: White Cover', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Microjets/Microjet_Flat/Microjet_Flat_Oc/Cover/Cover_White.jpg', NULL, 'Cover', 'ISBOMRJOC5FL'),
(36, 'ISBOMRJP5: Chrome Cover', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Microjets/Microjet_Tondo/Microjet_Tondo_P/Finitura_Placca/Placca_Cromo.jpg', NULL, 'Cover', 'ISBOMRJP5'),
(37, 'ISBOMRJP1: White Cover', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Microjets/Microjet_Tondo/Microjet_Tondo_P/Finitura_Placca/Placca_Bianco.jpg', NULL, 'Cover', 'ISBOMRJP5'),
(38, 'ISJPLINE05: Chrome Cover', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Line_Jet/Cover/Cover_Chrome.jpg', NULL, 'Cover', 'ISJLINEA005'),
(39, 'ISJPLINE01: White Cover', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Line_Jet/Cover/Cover_White.jpg', NULL, 'Cover', 'ISJLINEA005'),
(40, 'ISJRLINE01: White Nozzle', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Line_Jet/Nozzle/Nozzle_White.jpg', NULL, 'Nozzle', 'ISJLINEA005'),
(41, 'ISJRLINE05: Chrome Nozzle', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Line_Jet/Nozzle/Nozzle_Chrome.jpg', NULL, 'Nozzle', 'ISJLINEA005'),
(42, 'ISJLINEA005: Open Line Body', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Line_Jet/Body/Line_Body_Open.jpg', NULL, 'Body', 'ISJLINEA005'),
(43, 'ISJLINECS05: Blind Lh Line Body', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Line_Jet/Body/Line_Body_Blind_Lh.jpg', NULL, 'Body', 'ISJLINEA005'),
(44, 'ISJLINECD05: Blind Rt Line Body', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Line_Jet/Body/Line_Body_Blind_Rt.jpg', NULL, 'Body', 'ISJLINEA005'),
(45, 'ISRGUA63494: Flat Sponge Gasket', 'Whirlpool_System/Water_System/Pipes,_Fittings_&_Disinfection/Pipes_&_Fittings/Flat_Sponge_Gasket/Flat_Sponge_Gasket.jpg', NULL, 'Flat Sponge Gasket', 'ISJLINEA005'),
(46, 'ISJLINEKEY01: Key', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Line_Jet/Optional/Key/Key(ISJLINEKEY01).jpg', NULL, 'Key', 'ISJLINEA005'),
(47, 'ISJPLS20105: Chrome Cover', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Minijet_Skat/Cover/Cover_Chrome.jpg', NULL, 'Cover', 'ISJBO020201'),
(48, 'ISJPLS20101: White Cover', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Minijet_Skat/Cover/Cover_White.jpg', NULL, 'Cover', 'ISJBO020201'),
(49, 'ISJSES20105: Chrome Nozzle', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Minijet_Skat/Nozzle/Nozzle_Chrome.jpg', NULL, 'Nozzle', 'ISJBO020201'),
(50, 'ISJSES20101: White Nozzle', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Minijet_Skat/Nozzle/Nozzle_White.jpg', NULL, 'Nozzle', 'ISJBO020201'),
(51, 'ISRGU024044: Flat Sponge Gasket diam. 44', 'Whirlpool_System/Water_System/Pipes,_Fittings_&_Disinfection/Pipes_&_Fittings/Flat_Sponge_Gasket/Flat_Sponge_Gasket.jpg', NULL, 'Flat Sponge Gasket', 'ISJBO020201'),
(52, 'ISRTA024044: PVC Air Plug', NULL, NULL, 'PVC Air Plug', 'ISJBO020201'),
(53, 'ISTRCHMJ0300: Key', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Minijet_Skat/Optional/Chiave/Chiave(ISTRCHMJ0300).jpg', NULL, 'Key', 'ISJBO020201'),
(54, 'ISJSJOKMM05: Body 2 Outlet', 'Shower_System/Shower_Jets/Shower_Jet/Body/Body_Open.jpg', NULL, 'Body', 'ISJSJOKMM05'),
(55, 'ISJSJOKMM15: Body Blind 1 Outlet', 'Shower_System/Shower_Jets/Shower_Jet/Body/Body_1_Outlet_Blind.jpg', NULL, 'Body', 'ISJSJOKMM05'),
(57, 'ISJSMMPAV05: Body 2 Outlet', 'Shower_System/Shower_Jets/Minimal_Shower_Jet/Body/Body_Open.jpg', NULL, 'Body', 'ISJSMMPAV05'),
(58, 'ISJSMMPCV05: Body Blind 1 Outlet', 'Shower_System/Shower_Jets/Minimal_Shower_Jet/Body/Body_1_Outlet_Blind.jpg', NULL, 'Body', 'ISJSMMPAV05'),
(59, 'ISJBOMJ005: Cover Chrome', 'Shower_System/Shower_Jets/Micro_Shower_Jet/Cover/Cover_Chrome.jpg', NULL, 'Cover', 'ISJBOMJ005'),
(60, 'ISJBOMJ001: Cover White', 'Shower_System/Shower_Jets/Micro_Shower_Jet/Cover/Cover_White.jpg', NULL, 'Cover', 'ISJBOMJ005'),
(61, 'ISSHR00105: Cover Chrome', 'Shower_System/Shower_Jets/Round_Micro_Shower_Jet/Cover/Cover_Chrome.jpg', NULL, 'Cover', 'ISSHR00105'),
(62, 'ISSHR00101: Cover White', NULL, NULL, 'Cover', 'ISSHR00105'),
(63, 'ISSHRACT00: Body T Fitting for Shower Jet + Clip', 'Shower_System/Shower_Jets/Round_Micro_Shower_Jet/Body/Body_T.jpg', NULL, 'Body', 'ISSHR00105'),
(64, 'ISSHRACL00: Body L Fitting for Shower Jet + Clip', 'Shower_System/Shower_Jets/Round_Micro_Shower_Jet/Body/Body_L.jpg', NULL, 'Body', 'ISSHR00105'),
(65, 'ISNEBR0105: Cover Chrome', 'Shower_System/Shower_Jets/Round_Micro_Shower_Jet/Cover/Cover_Chrome.jpg', NULL, 'Cover', 'ISNEBR0105'),
(66, 'ISNEBR0101: Cover White', NULL, NULL, 'Cover', 'ISNEBR0105'),
(69, 'ISSHRACT00: Body Nebulizer T Fitting for Shower Jet + Clip', 'Shower_System/Shower_Jets/Round_Micro_Shower_Jet/Body/Body_T.jpg', NULL, 'Body', 'ISNEBR0105'),
(70, 'ISSHRACL00: Body Nebulizer L Fitting for Shower Jet + Clip', 'Shower_System/Shower_Jets/Round_Micro_Shower_Jet/Body/Body_L.jpg', NULL, 'Body', 'ISNEBR0105'),
(71, 'SD-9030AF: Body for Self Tapping Screw', 'Shower_System/Shower_Drains/Shower_Drains/Round_Shower_Drain_H50_without_Plate/Body_for_Self-Tapping_Screws/Body_for_Self-Tapping_Screws.JPG', NULL, 'Body for Self Tapping Screw', 'SD-9030'),
(73, 'SD-90PLSTD: Cover Standard SD-9030', 'Shower_System/Shower_Drains/Shower_Drains/Round_Shower_Drain_H30_with_Plate/Cover/Cover_Standard.jpg', NULL, 'Cover', 'SD-9030'),
(74, 'SD-90PLFLAT: Cover Flat SD-9030', 'Shower_System/Shower_Drains/Shower_Drains/Round_Shower_Drain_H30_with_Plate/Cover/Cover_Flat.jpg', NULL, 'Cover', 'SD-9030'),
(75, 'SD-GASKETFL: Flat Gasket SD-9030', 'Shower_System/Shower_Drains/Shower_Drains/Round_Shower_Drain_H50_without_Plate/Gasket/Gasket_Flat.JPG', NULL, 'Gasket', 'SD-9030'),
(76, 'SD-GASKETDL: Double Lip Gasket SD-9030', 'Shower_System/Shower_Drains/Shower_Drains/Round_Shower_Drain_H50_without_Plate/Gasket/Gasket_Double_Lip.JPG', NULL, 'Gasket', 'SD-9030'),
(77, 'SD-9031AF: Body for Self Tapping Screw', 'Shower_System/Shower_Drains/Shower_Drains/Round_Shower_Drain_H50_without_Plate/Body_for_Self-Tapping_Screws/Body_for_Self-Tapping_Screws.JPG', NULL, 'Body for Self Tapping Screw', 'SD-9031'),
(79, 'SD-GASKETFL: Flat Gasket SD-9031', 'Shower_System/Shower_Drains/Shower_Drains/Round_Shower_Drain_H50_without_Plate/Gasket/Gasket_Flat.JPG', NULL, 'Gasket', 'SD-9031'),
(80, 'SD-GASKETDL: Double Lip Gasket SD-9031', 'Shower_System/Shower_Drains/Shower_Drains/Round_Shower_Drain_H50_without_Plate/Gasket/Gasket_Double_Lip.JPG', NULL, 'Gasket', 'SD-9031'),
(81, 'SD-9050AF: Body for Self Tapping Screw', 'Shower_System/Shower_Drains/Shower_Drains/Round_Shower_Drain_H50_without_Plate/Body_for_Self-Tapping_Screws/Body_for_Self-Tapping_Screws.JPG', NULL, 'Body for Self Tapping Screw', 'SD-9050'),
(82, 'SD-9050SN: Body H50 with Joint', 'Shower_System/Shower_Drains/Shower_Drains/Round_Shower_Drain_H50_with_Plate/Body_H50_with_Joint/Body_H50_with_Joint.jpg', NULL, 'Body H50 with Joint', 'SD-9050'),
(83, 'SD-90PLSTD: Cover Standard SD-9050', 'Shower_System/Shower_Drains/Shower_Drains/Round_Shower_Drain_H50_with_Plate/Cover/Cover_Standard.jpg', NULL, 'Cover', 'SD-9050'),
(84, 'SD-90PLFLAT: Cover Flat SD-9050', 'Shower_System/Shower_Drains/Shower_Drains/Round_Shower_Drain_H50_with_Plate/Cover/Cover_Flat.jpg', NULL, 'Cover', 'SD-9050'),
(85, 'SD-GASKETFL: Flat Gasket SD-9050', 'Shower_System/Shower_Drains/Shower_Drains/Round_Shower_Drain_H50_without_Plate/Gasket/Gasket_Flat.JPG', NULL, 'Gasket', 'SD-9050'),
(86, 'SD-GASKETDL: Double Lip Gasket SD-9050', 'Shower_System/Shower_Drains/Shower_Drains/Round_Shower_Drain_H50_without_Plate/Gasket/Gasket_Double_Lip.JPG', NULL, 'Gasket', 'SD-9050'),
(87, 'SD-9051AF: Body for Self Tapping Screw', 'Shower_System/Shower_Drains/Shower_Drains/Round_Shower_Drain_H50_without_Plate/Body_for_Self-Tapping_Screws/Body_for_Self-Tapping_Screws.JPG', NULL, 'Body for Self Tapping Screw', 'SD-9051'),
(88, 'SD-9051SN: Body H50 with Joint', 'Shower_System/Shower_Drains/Shower_Drains/Round_Shower_Drain_H50_without_Plate/Body_H50_with_Joint/Body_H50_with_Joint.jpg', NULL, 'Body H50 with Joint', 'SD-9051'),
(90, 'SD-GASKETFL: Flat Gasket SD-9051', 'Shower_System/Shower_Drains/Shower_Drains/Round_Shower_Drain_H50_without_Plate/Gasket/Gasket_Flat.JPG', NULL, 'Gasket', 'SD-9051'),
(91, 'SD-GASKETDL: Double Lip Gasket SD-9051', 'Shower_System/Shower_Drains/Shower_Drains/Round_Shower_Drain_H50_without_Plate/Gasket/Gasket_Double_Lip.JPG', NULL, 'Gasket', 'SD-9051'),
(92, 'ISBOMRJOC5: Cover Chrome', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Microjets/Microjet_Tondo/Microjet_Tondo_Oc/Finitura_Placca/Placca_Cromo.jpg', NULL, 'Cover', 'ISBOMRJOC5'),
(93, 'ISBOMRJOC1: Cover White', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Microjets/Microjet_Tondo/Microjet_Tondo_Oc/Finitura_Placca/Placca_Bianco.jpg', NULL, 'Cover', 'ISBOMRJOC5'),
(94, 'PRH30-1SPAF: Body for Self Tapping Screw', 'Shower_System/Shower_Drains/Shower_Drains/Rectangular_2_Syphon_Shower_Drain_H30_with_Plate/Body_for_Self-Tapping_Screws/Body_for_Self-Tapping_Screws.JPG', NULL, 'Body for Self Tapping Screw', 'PRH30-1SP'),
(95, 'PRH-FLSTD: Standard Flange PRH30-1SP', 'Shower_System/Shower_Drains/Shower_Drains/Rectangular_2_Syphon_Shower_Drain_H50_without_Plate/Flange/Flage_Standard.JPG', NULL, 'Flange', 'PRH30-1SP'),
(96, 'PRH-FLSTR: Tight Flange PRH30-1SP', 'Shower_System/Shower_Drains/Shower_Drains/Rectangular_2_Syphon_Shower_Drain_H50_without_Plate/Flange/Flage_Tight.JPG', NULL, 'Flange', 'PRH30-1SP'),
(97, 'PRH-GASKETFL: Flat Gasket PRH30-1SP', 'Shower_System/Shower_Drains/Shower_Drains/Rectangular_2_Syphon_Shower_Drain_H50_without_Plate/Gasket/Gasket_Flat.JPG', NULL, 'Gasket', 'PRH30-1SP'),
(98, 'PRH-GASKETDL: Double Lip Gasket PRH30-1SP', 'Shower_System/Shower_Drains/Shower_Drains/Rectangular_2_Syphon_Shower_Drain_H50_without_Plate/Gasket/Gasket_Double_Lip.JPG', NULL, 'Gasket', 'PRH30-1SP'),
(99, 'PRH30-CPAH: Body for Self Tapping Screw', 'Shower_System/Shower_Drains/Shower_Drains/Rectangular_2_Syphon_Shower_Drain_H30_with_Plate/Body_for_Self-Tapping_Screws/Body_for_Self-Tapping_Screws.JPG', NULL, 'Body for Self Tapping Screw', 'PRH30-CP'),
(100, 'PRH-FLSTD: Standard Flange PRH30-CP', 'Shower_System/Shower_Drains/Shower_Drains/Rectangular_2_Syphon_Shower_Drain_H50_without_Plate/Flange/Flage_Standard.JPG', NULL, 'Flange', 'PRH30-CP'),
(101, 'PRH-FLSTR: Tight Flange PRH30-CP', 'Shower_System/Shower_Drains/Shower_Drains/Rectangular_2_Syphon_Shower_Drain_H50_without_Plate/Flange/Flage_Tight.JPG', NULL, 'Flange', 'PRH30-CP'),
(102, 'PRH-GASKETFL: Flat Gasket PRH30-CP', 'Shower_System/Shower_Drains/Shower_Drains/Rectangular_2_Syphon_Shower_Drain_H50_without_Plate/Gasket/Gasket_Flat.JPG', NULL, 'Gasket', 'PRH30-CP'),
(103, 'PRH-GASKETDL: Double Lip Gasket PRH30-CP', 'Shower_System/Shower_Drains/Shower_Drains/Rectangular_2_Syphon_Shower_Drain_H50_without_Plate/Gasket/Gasket_Double_Lip.JPG', NULL, 'Gasket', 'PRH30-CP'),
(104, 'PRH50-CPAF: Body for Self Tapping Screw', 'Shower_System/Shower_Drains/Shower_Drains/Rectangular_2_Syphon_Shower_Drain_H30_with_Plate/Body_for_Self-Tapping_Screws/Body_for_Self-Tapping_Screws.JPG', NULL, 'Body for Self Tapping Screw', 'PRH50-CP'),
(105, 'PRH-FLSTD: Standard Flange PRH50-CP', 'Shower_System/Shower_Drains/Shower_Drains/Rectangular_2_Syphon_Shower_Drain_H50_without_Plate/Flange/Flage_Standard.JPG', NULL, 'Flange', 'PRH50-CP'),
(106, 'PRH-FLSTR: Tight Flange PRH50-CP', 'Shower_System/Shower_Drains/Shower_Drains/Rectangular_2_Syphon_Shower_Drain_H50_without_Plate/Flange/Flage_Tight.JPG', NULL, 'Flange', 'PRH50-CP'),
(107, 'PRH-GASKETFL: Flat Gasket PRH50-CP', 'Shower_System/Shower_Drains/Shower_Drains/Rectangular_2_Syphon_Shower_Drain_H50_without_Plate/Gasket/Gasket_Flat.JPG', NULL, 'Gasket', 'PRH50-CP'),
(108, 'PRH-GASKETDL: Double Lip Gasket PRH50-CP', 'Shower_System/Shower_Drains/Shower_Drains/Rectangular_2_Syphon_Shower_Drain_H50_without_Plate/Gasket/Gasket_Double_Lip.JPG', NULL, 'Gasket', 'PRH50-CP'),
(109, 'PRH50-1AF: Body for Self Tapping Screw', 'Shower_System/Shower_Drains/Shower_Drains/Rectangular_2_Syphon_Shower_Drain_H30_with_Plate/Body_for_Self-Tapping_Screws/Body_for_Self-Tapping_Screws.JPG', NULL, 'Body for Self Tapping Screw', 'PRH50-1'),
(110, 'PRH-FLSTD: Standard Flange PRH50-1', 'Shower_System/Shower_Drains/Shower_Drains/Rectangular_2_Syphon_Shower_Drain_H50_without_Plate/Flange/Flage_Standard.JPG', NULL, 'Flange', 'PRH50-1'),
(111, 'PRH-FLSTR: Tight Flange PRH50-1', 'Shower_System/Shower_Drains/Shower_Drains/Rectangular_2_Syphon_Shower_Drain_H50_without_Plate/Flange/Flage_Tight.JPG', NULL, 'Flange', 'PRH50-1'),
(112, 'PRH-GASKETFL: Flat Gasket PRH50-1', 'Shower_System/Shower_Drains/Shower_Drains/Rectangular_2_Syphon_Shower_Drain_H50_without_Plate/Gasket/Gasket_Flat.JPG', NULL, 'Gasket', 'PRH50-1'),
(113, 'PRH-GASKETDL: Double Lip Gasket PRH50-1', 'Shower_System/Shower_Drains/Shower_Drains/Rectangular_2_Syphon_Shower_Drain_H50_without_Plate/Gasket/Gasket_Double_Lip.JPG', NULL, 'Gasket', 'PRH50-1'),
(114, 'SRH-FLSTD: Standard Flange SRH30-1', 'Shower_System/Shower_Drains/Shower_Drains/Rectangular_3_Syphon_Shower_Drain_H50/Flange/Flage_Standard.JPG', NULL, 'Flange', 'SRH30-1'),
(115, 'SRH-FLSTR: Tight Flange SRH30-1', 'Shower_System/Shower_Drains/Shower_Drains/Rectangular_3_Syphon_Shower_Drain_H50/Flange/Flage_Tight.JPG', NULL, 'Flange', 'SRH30-1'),
(116, 'SRH-GASKETFL: Flat Gasket SRH30-1', 'Shower_System/Shower_Drains/Shower_Drains/Rectangular_3_Syphon_Shower_Drain_H50/Gasket/Gasket_Flat.JPG', NULL, 'Gasket', 'SRH30-1'),
(117, 'SRH-GASKETDL: Double Lip Gasket SRH30-1', 'Shower_System/Shower_Drains/Shower_Drains/Rectangular_3_Syphon_Shower_Drain_H50/Gasket/Gasket_Double_Lip.JPG', NULL, 'Gasket', 'SRH30-1'),
(118, 'SRH-FLSTD: Standard Flange SRH50-1', 'Shower_System/Shower_Drains/Shower_Drains/Rectangular_3_Syphon_Shower_Drain_H50/Flange/Flage_Standard.JPG', NULL, 'Flange', 'SRH50-1'),
(119, 'SRH-FLSTR: Tight Flange SRH50-1', 'Shower_System/Shower_Drains/Shower_Drains/Rectangular_3_Syphon_Shower_Drain_H50/Flange/Flage_Tight.JPG', NULL, 'Flange', 'SRH50-1'),
(120, 'SRH-GASKETFL: Flat Gasket SRH50-1', 'Shower_System/Shower_Drains/Shower_Drains/Rectangular_3_Syphon_Shower_Drain_H50/Gasket/Gasket_Flat.JPG', NULL, 'Gasket', 'SRH50-1'),
(121, 'SRH-GASKETDL: Double Lip Gasket SRH50-1', 'Shower_System/Shower_Drains/Shower_Drains/Rectangular_3_Syphon_Shower_Drain_H50/Gasket/Gasket_Double_Lip.JPG', NULL, 'Gasket', 'SRH50-1'),
(124, 'ISJSLIMA005: Jet Body Open', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Slim_Jet/Body/Body_Line_Open.jpg', NULL, 'Body', 'ISJSLIMA005'),
(125, 'ISJSLIMCS05: Jet Body Blind Lh', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Slim_Jet/Body/Body_Line_Blind_Lh.jpg', NULL, 'Body', 'ISJSLIMA005'),
(126, 'ISJSLIMCD05: Jet Body Blind Rt', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Slim_Jet/Body/Body_Line_Blind_Rt.jpg', NULL, 'Body', 'ISJSLIMA005'),
(127, 'ISJRSLIM05: Chrome Nozzle', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Slim_Jet/Nozzle/Nozzle_Chrome.jpg', NULL, 'Nozzle', 'ISJSLIMA005'),
(128, 'ISJRSLIM01: White Nozzle', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Slim_Jet/Nozzle/Nozzle_White.jpg', NULL, 'Nozzle', 'ISJSLIMA005'),
(129, 'ISJPLSLIM0W: White Insert', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Slim_Jet/Insert/Insert_White.jpg', NULL, 'Insert', 'ISJSLIMA005'),
(130, 'ISJPLSLIM0C: Chrome Insert', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Slim_Jet/Insert/Insert_Chrome.jpg', NULL, 'Insert', 'ISJSLIMA005'),
(133, 'ISRGUA63494: Flat Sponge Gasket Slim', 'Whirlpool_System/Water_System/Pipes,_Fittings_&_Disinfection/Pipes_&_Fittings/Flat_Sponge_Gasket/Flat_Sponge_Gasket.jpg', NULL, 'Flate Sponge Gasket', 'ISJSLIMA005'),
(136, 'ISJLINEKEY01: Key Slim', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Slim_Jet/Optional/Key/Key(ISJLINEKEY01).jpg', NULL, 'Key', 'ISJSLIMA005'),
(137, 'ISJBO3F0200: Body Suction 3F', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Suctions/Suction_3F/Body/Body_Suction_3F/B_Body_Suction_3F.jpg', NULL, 'Body', 'ISJPL3F0105'),
(138, 'ISJBO3F0100: Body Suction 3F + Cleaning Membrane', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Suctions/Suction_3F/Body/Body_Suction_3F_with_Cleaning_Membrane/B_Body_Suction_3F_with_Cleaning_Membrane.jpg', NULL, 'Body', 'ISJPL3F0105'),
(139, 'ISJPL3F0105: Cover Chrome 3F', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Suctions/Suction_3F/Cover/Cover_Chrome.jpg', NULL, 'Cover', 'ISJPL3F0105'),
(140, 'ISJPL3F0101: Cover White 3F', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Suctions/Suction_3F/Cover/Cover_White.jpg', NULL, 'Cover', 'ISJPL3F0105'),
(141, 'ARRIS05040: Adapter', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Suctions/Suction_3F/Optional/Adapter/Adapter_5040(ARRIS05040).jpg', NULL, 'Adapter', 'ISJPL3F0105'),
(142, 'ISRGU016004: Flat Sponge Gasket 3F', 'Whirlpool_System/Water_System/Pipes,_Fittings_&_Disinfection/Pipes_&_Fittings/Flat_Sponge_Gasket/Flat_Sponge_Gasket.jpg', NULL, 'Flat Sponge Gasket', 'ISJPL3F0105'),
(143, 'ISRCHBO0300: Key 3F', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Suctions/Suction_3F/Optional/Key(ISRCHBO0300)/Key(ISRCHBO0300).jpg', NULL, 'Key', 'ISJPL3F0105'),
(144, 'ISJVAS01000: Safety Valve ABS', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Suctions/Suction_3F/Optional/Safety_Valve/Safety_Valve.jpg', NULL, 'Safety Valve', 'ISJPL3F0105'),
(145, 'ISRGUFLAT000: U Seal Gasket 3F', 'Whirlpool_System/Water_System/Pipes,_Fittings_&_Disinfection/Pipes_&_Fittings/U_Seal_Gasket/U_Seal_Gasket.jpg', NULL, 'U Seal Gasket', 'ISJPL3F0105'),
(147, 'ISJBO3F0200: Body Suction 3F Lux', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Suctions/Suction_3F/Body/Body_Suction_3F/B_Body_Suction_3F.jpg', NULL, 'Body', 'ISJPL3FL105'),
(148, 'ISJBO3F0100: Body Suction 3F Lux + Cleaning Membrane', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Suctions/Suction_3F/Body/Body_Suction_3F_with_Cleaning_Membrane/B_Body_Suction_3F_with_Cleaning_Membrane.jpg', NULL, 'Body', 'ISJPL3FL105'),
(149, 'ISJPL3F0105: Cover Chrome 3F Lux', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Suctions/Suction_3F_Lux/Cover/Cover_Chrome.jpg', NULL, 'Cover', 'ISJPL3FL105'),
(150, 'ISJPL3F0101: Cover White 3F Lux', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Suctions/Suction_3F_Lux/Cover/Cover_White.jpg', NULL, 'Cover', 'ISJPL3FL105'),
(151, 'ARRIS05040: Adapter Lux', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Suctions/Suction_3F/Optional/Adapter/Adapter_5040(ARRIS05040).jpg', NULL, 'Adapter', 'ISJPL3FL105'),
(152, 'ISRGU016004: Flat Sponge Gasket 3F Lux', 'Whirlpool_System/Water_System/Pipes,_Fittings_&_Disinfection/Pipes_&_Fittings/Flat_Sponge_Gasket/Flat_Sponge_Gasket.jpg', NULL, 'Flat Sponge Gasket', 'ISJPL3FL105'),
(153, 'ISRCHBO0300: Key 3F Lux', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Suctions/Suction_3F/Optional/Key(ISRCHBO0300)/Key(ISRCHBO0300).jpg', NULL, 'Key', 'ISJPL3FL105'),
(154, 'ISJVAS01000: Safety Valve ABS Lux', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Suctions/Suction_3F/Optional/Safety_Valve/Safety_Valve.jpg', NULL, 'Safety Valve', 'ISJPL3FL105'),
(155, 'ISRGUFLAT000: U Seal Gasket 3F Lux', 'Whirlpool_System/Water_System/Pipes,_Fittings_&_Disinfection/Pipes_&_Fittings/U_Seal_Gasket/U_Seal_Gasket.jpg', NULL, 'U Seal Gasket', 'ISJPL3FL105'),
(156, 'ISJBO3F0200: Body Suction 3F Square', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Suctions/Suction_3F_Square/Body/Body_Suction_3F/B_Body_Suction_3F.jpg', NULL, 'Body', 'ISPL3FSQU05'),
(157, 'ISPL3FSQU05: Chrome Cover', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Suctions/Suction_3F_Square/Cover/Cover_Chrome.jpg', NULL, 'Cover', 'ISPL3FSQU05'),
(158, 'ISPL3FSQU01: White Cover', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Suctions/Suction_3F_Square/Cover/Cover_White.jpg', NULL, 'Cover', 'ISPL3FSQU05'),
(159, 'ARRIS05040: Adapter Square', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Suctions/Suction_3F_Square/Optional/Adapter/Adapter_5040(ARRIS05040).jpg', NULL, 'Adapter', 'ISPL3FSQU05'),
(160, 'ISRGU016004: Flat Sponge Gasket 3F Square', 'Whirlpool_System/Water_System/Pipes,_Fittings_&_Disinfection/Pipes_&_Fittings/Flat_Sponge_Gasket/Flat_Sponge_Gasket.jpg', NULL, 'Flat Sponge Gasket', 'ISPL3FSQU05'),
(161, 'ISRCHBO0300: Key 3F Square', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Suctions/Suction_3F_Square/Optional/Key(ISRCHBO0300)/Key(ISRCHBO0300).jpg', NULL, 'Key', 'ISPL3FSQU05'),
(162, 'ISJVAS01000: Safety Valve ABS Square', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Suctions/Suction_3F_Square/Optional/Safety_Valve/Safety_Valve.jpg', NULL, 'Safety Valve', 'ISPL3FSQU05'),
(163, 'ISRGUFLAT000: U Seal Gasket 3F Square', 'Whirlpool_System/Water_System/Pipes,_Fittings_&_Disinfection/Pipes_&_Fittings/U_Seal_Gasket/U_Seal_Gasket.jpg', NULL, 'U Seal Gasket', 'ISPL3FSQU05'),
(164, 'ISJBOP40100: Body Suction Standard, internal passage Ø 50 mm', NULL, NULL, 'Body', 'ISJPL040105'),
(165, 'ISRCHBO0300: Key Suction Standard', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Suctions/Suction_Standard/Optional/Key(ISRCHBO0300)/Key(ISRCHBO0300).jpg', NULL, 'Key', 'ISJPL040105'),
(166, 'ISRGO900240: PVC Elbow 90°', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Suctions/Suction_Standard/Optional/PVC_Elbow_90°/PVC_Elbow_90°.jpg', NULL, 'PVC Elbow 90°', 'ISJPL040105'),
(167, 'ISRGUFLAT000: U Seal Gasket', 'Whirlpool_System/Water_System/Pipes,_Fittings_&_Disinfection/Pipes_&_Fittings/U_Seal_Gasket/U_Seal_Gasket.jpg', NULL, 'U Seal Gasket', 'ISJPL040105'),
(168, 'ISJPL040105: Chrome Cover', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Suctions/Suction_Standard/Cover/Cover_Chrome.jpg', NULL, 'Cover', 'ISJPL040105'),
(169, 'ISJPL040101: White Cover', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Suctions/Suction_Standard/Cover/Cover_White.jpg', NULL, 'Cover', 'ISJPL040105'),
(170, '1: Body 2 Outlet MNJ', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Moon_Jet/Corpo/Corpo_2Vie.png', NULL, 'Body', 'MNJ'),
(171, '2: Body Blind Rt MNJ', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Moon_Jet/Corpo/Corpo_Dx.png', NULL, 'Body', 'MNJ'),
(172, '3: Body Blind Lh MNJ', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Moon_Jet/Corpo/Corpo_Sx.png', NULL, 'Body', 'MNJ'),
(173, 'L: LED Light', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Moon_Jet/Sfera_Finitura/Sfera_Led.png', NULL, 'Light or No Light', 'MNJ'),
(174, 'N: No Light', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Moon_Jet/Sfera_Finitura/Sfera_Bianco.png', NULL, 'Light or No Light', 'MNJ'),
(177, 'Chrome Sphere', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Moon_Jet/Sfera_Finitura/Sfera_Cromo.jpg', NULL, 'Nozzle Type and Finiture-Sphere', 'MNJ'),
(178, 'White Sphere', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Moon_Jet/Sfera_Finitura/Sfera_Bianco.png', NULL, 'Nozzle Type and Finiture-Sphere', 'MNJ'),
(179, 'White Insert for Sphere', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Moon_Jet/Portasfera_Finitura/Portasfera_Bianco.png', NULL, 'Nozzle Type and Finiture-Insert', 'MNJ'),
(180, 'Chrome Insert for Sphere', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Moon_Jet/Portasfera_Finitura/Portasfera_Cromo.png', NULL, 'Nozzle Type and Finiture-Insert', 'MNJ'),
(181, 'Chrome Cone', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Moon_Jet/Cono_Finitura/Cono_Cromo.jpg', NULL, 'Nozzle Type and Finiture-Cone', 'MNJ'),
(182, 'White Cone', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Moon_Jet/Cono_Finitura/Cono_Bianco.png', NULL, 'Nozzle Type and Finiture-Cone', 'MNJ'),
(183, 'Plastic Chrome Cover', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Moon_Jet/Ghiera_Finitura/Ghiera_Cromo.png', NULL, 'Cover Material and Finiture-Plastic Cover', 'MNJ'),
(184, 'Plastic White Cover', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Moon_Jet/Ghiera_Finitura/Ghiera_Bianco.png', NULL, 'Cover Material and Finiture-Plastic Cover', 'MNJ'),
(185, 'AISI 304 Metal Cover', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Moon_Jet/Ghiera_Materiale/Ghiera_Tornita.png', NULL, 'Cover Material and Finiture-Metal Cover', 'MNJ'),
(187, 'ISRUBBQ0001: Body Standard', 'Shower_System/Steam_Accessories_&_Fittings/Bouquet_Steam_Outlet/Body/Body_Standard.jpg', NULL, 'Body', 'ISRUBBQ0001'),
(188, 'ISRUBBQ0000: Body Blind', 'Shower_System/Steam_Accessories_&_Fittings/Bouquet_Steam_Outlet/Body/Body_Blind.jpg', NULL, 'Body', 'ISRUBBQ0001'),
(189, 'ISRUBBQ0001J: Body Standard', 'Shower_System/Steam_Accessories_&_Fittings/Closed_Cap_Steam_Outlet/Body/Body_Standard.jpg', NULL, 'Body', 'ISRUBBQ0001J'),
(190, 'ISRUBBQ0000J: Body Blind', 'Shower_System/Steam_Accessories_&_Fittings/Closed_Cap_Steam_Outlet/Body/Body_Blind.jpg', NULL, 'Body', 'ISRUBBQ0001J'),
(191, 'ISJTAPPP0005: Chrome Cover', 'Whirlpool_System/Water_System/Pipes,_Fittings_&_Disinfection/Disinfection/Push_Push_Plug_for_Tank/Cover/Cover_Chrome.jpg', NULL, 'Cover', 'ISJTAPPP0005'),
(192, 'ISJTAPPP0001: White Cover', 'Whirlpool_System/Water_System/Pipes,_Fittings_&_Disinfection/Disinfection/Push_Push_Plug_for_Tank/Cover/Cover_White.jpg', NULL, 'Cover', 'ISJTAPPP0005'),
(193, 'ISRTI00N105: Chrome Cover', 'Whirlpool_System/Water_System/Pipes,_Fittings_&_Disinfection/Disinfection/Plug_for_Tank/Cover/Cover_Chrome.jpg', NULL, 'Cover', 'ISRTI00N105'),
(194, 'ISRTI00N101: White Cover', 'Whirlpool_System/Water_System/Pipes,_Fittings_&_Disinfection/Disinfection/Plug_for_Tank/Cover/Cover_White.jpg', NULL, 'Cover', 'ISRTI00N105'),
(196, 'ISJPLSULIM005: Chrome Cover', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Suctions/Suction_Slim/Cover/Cover_Chrome.jpg', NULL, 'Cover', 'ISJPLSULIM005'),
(197, 'ISJPLSULIM001: White Cover', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Suctions/Suction_Slim/Cover/Cover_White.jpg', NULL, 'Cover', 'ISJPLSULIM005'),
(198, 'ARRIS05040: Adapter Ø50-40', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Suctions/Suction_Slim/Optional/Adapter/Adapter_5040(ARRIS05040).jpg', NULL, 'Adapter', 'ISJPLSULIM005'),
(199, 'ISRGU016004: Flat Sponge Gasket Slim Suction', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Suctions/Suction_Slim/Optional/Flat_Sponge_Gasket/Flat_Sponge_Gasket(ISRGU016004).jpg', NULL, 'Flat Sponge Gasket', 'ISJPLSULIM005'),
(200, 'ISJLINEKEY01: Key Slim Suction', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Suctions/Suction_Slim/Optional/Key(ISJLINEKEY01)/Key(ISJLINEKEY01).jpg', NULL, 'Key', 'ISJPLSULIM005'),
(201, 'ISJVAS01000: Safety Valve Slim Suction', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Suctions/Suction_Slim/Optional/Safety_Valve/Safety_Valve.jpg', NULL, 'Safety Valve', 'ISJPLSULIM005'),
(202, 'ISRGUFLAT000: U Seal Gasket Slim Suction', 'Whirlpool_System/Water_System/Pipes,_Fittings_&_Disinfection/Pipes_&_Fittings/U_Seal_Gasket/U_Seal_Gasket.jpg', NULL, 'U Seal Gasket', 'ISJPLSULIM005'),
(203, 'Body Open', NULL, NULL, 'Body and Diameter-Body', 'ISJNFLAT'),
(204, 'Body Blind Lh', NULL, NULL, 'Body and Diameter-Body', 'ISJNFLAT'),
(205, 'Body Blind Rt', NULL, NULL, 'Body and Diameter-Body', 'ISJNFLAT'),
(206, 'Body Flat Ø 16 mm', NULL, NULL, 'Body and Diameter-Diameter', 'ISJNFLAT'),
(207, 'Body Flat Ø 20 mm', NULL, NULL, 'Body and Diameter-Diameter', 'ISJNFLAT'),
(209, 'Chrome Flat Cover', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Flat_Jet/Cover/Cover_Standard/Cover_Standard_Chrome.jpg', NULL, 'Cover-Flat', 'ISJNFLAT'),
(210, 'White Flat Cover', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Flat_Jet/Cover/Cover_Standard/Cover_Standard_White.jpg', NULL, 'Cover-Flat', 'ISJNFLAT'),
(211, 'Chrome Flat Nozzle', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Flat_Jet/Nozzle/Standard_Nozzle/Standard_Nozzle_Chrome.jpg', NULL, 'Nozzle-Flat', 'ISJNFLAT'),
(212, 'White Flat Nozzle', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Flat_Jet/Nozzle/Standard_Nozzle/Standard_Nozzle_White.jpg', NULL, 'Nozzle-Flat', 'ISJNFLAT'),
(213, 'ISJFLGLUE00: Flat Body for Glue', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Flat_Jet/Body/Flat_Glue_Body-Diameter/Flat_Glue_Body/Flat_Glue_Body_Open.jpg', NULL, 'Flat Body for Glue', 'ISJNFLAT'),
(214, 'ISJYFLATA01: Open Y Body Joint', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Flat_Jet/Body/Body_Y_Coupling/Body_Y_Coupling_Open.jpg', NULL, 'Y Body Joint', 'ISJNFLAT'),
(215, 'ISJYFLATC01: Blind Y Body Joint', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Flat_Jet/Body/Body_Y_Coupling/Body_Y_Coupling_Blind.jpg', NULL, 'Y Body Joint', 'ISJNFLAT'),
(216, 'ISRTAP10020: PVC Air Plug (for Glue Body)', NULL, NULL, 'PVC Air Plug', 'ISJNFLAT'),
(217, 'Chrome Flower Nozzle', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Flat_Jet/Nozzle/Flower_Nozzle/Flower_Nozzle_Chrome.jpg', NULL, 'Nozzle-Flower', 'ISJNFLAT'),
(218, 'White Flower Nozzle', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Flat_Jet/Nozzle/Flower_Nozzle/Flower_Nozzle_White.jpg', NULL, 'Nozzle-Flower', 'ISJNFLAT'),
(219, 'Chrome Round Cover', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Flat_Jet/Cover/Cover_Round/Cover_Round_Chrome.jpg', NULL, 'Cover-Round', 'ISJNFLAT'),
(220, 'White Round Cover', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Flat_Jet/Cover/Cover_Round/Cover_Round_White.jpg', NULL, 'Cover-Round', 'ISJNFLAT'),
(221, 'Chrome Lux Cover', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Flat_Jet/Cover/Cover_Lux/Cover_Lux_Chrome.jpg', NULL, 'Cover-Lux', 'ISJNFLAT'),
(222, 'White Lux Cover', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Flat_Jet/Cover/Cover_Lux/Cover_Lux_White.jpg', NULL, 'Cover-Lux', 'ISJNFLAT'),
(223, 'ISRGU016004: Flat Sponge Gasket Flat Jet', 'Whirlpool_System/Water_System/Pipes,_Fittings_&_Disinfection/Pipes_&_Fittings/Flat_Sponge_Gasket/Flat_Sponge_Gasket.jpg', NULL, 'Flat Sponge Gasket', 'ISJNFLAT'),
(224, 'ISRCHBO0300: Key Flat Jet', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Flat_Jet/Optional/Key/Key(ISRCHBO0300).jpg', NULL, 'Key', 'ISJNFLAT'),
(225, 'ISRGUFLAT000: U Seal Gasket Flat Jet', 'Whirlpool_System/Water_System/Pipes,_Fittings_&_Disinfection/Pipes_&_Fittings/U_Seal_Gasket/U_Seal_Gasket.jpg', NULL, 'U Seal Gasket', 'ISJNFLAT'),
(226, 'Body Open Square Jet', NULL, NULL, 'Body and Diameter-Body', 'ISJNSQU'),
(227, 'Body Blind Lh Square Jet', NULL, NULL, 'Body and Diameter-Body', 'ISJNSQU'),
(228, 'Body Blind Rt Square Jet', NULL, NULL, 'Body and Diameter-Body', 'ISJNSQU'),
(229, 'Body Ø 16 mm Square Jet', NULL, NULL, 'Body and Diameter-Diameter', 'ISJNSQU'),
(230, 'Body Ø 20 mm Square Jet', NULL, NULL, 'Body and Diameter-Diameter', 'ISJNSQU'),
(232, 'ISJPLSQU05: Chrome Cover Square Jet', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Square_Jet/Cover/Cover_Chrome.jpg', NULL, 'Cover', 'ISJNSQU'),
(233, 'ISJPLSQU01: White Cover Square Jet', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Square_Jet/Cover/Cover_White.jpg', NULL, 'Cover', 'ISJNSQU'),
(234, 'ISJROSQU05: Chrome Nozzle', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Square_Jet/Nozzle/Nozzle_Chrome.jpg', NULL, 'Nozzle', 'ISJNSQU'),
(235, 'ISJROSQU01: White Nozzle', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Square_Jet/Nozzle/Nozzle_White.jpg', NULL, 'Nozzle', 'ISJNSQU'),
(237, 'ISJYFLATA01: Open Y Body Joint Square Jet', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Square_Jet/Body/Body_Y_Coupling/Body_Y_Coupling_Open.jpg', NULL, 'Y Body Joint', 'ISJNSQU'),
(238, 'ISJYFLATC01: Blind Y Body Joint Square Jet', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Square_Jet/Body/Body_Y_Coupling/Body_Y_Coupling_Blind.jpg', NULL, 'Y Body Joint', 'ISJNSQU'),
(239, 'ISRTAP10020: PVC Air Plug (for Glue Body) Square Jet', NULL, NULL, 'PVC Air Plug', 'ISJNSQU'),
(240, 'ISRGU016004: Flat Sponge Gasket Square Jet', 'Whirlpool_System/Water_System/Pipes,_Fittings_&_Disinfection/Pipes_&_Fittings/Flat_Sponge_Gasket/Flat_Sponge_Gasket.jpg', NULL, 'Flat Sponge Gasket', 'ISJNSQU'),
(241, 'ISRCHBO0300: Key Square Jet', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Square_Jet/Optional/Key/Key(ISRCHBO0300).jpg', NULL, 'Key', 'ISJNSQU'),
(242, 'ISRGUFLAT000: U Seal Gasket Square Jet', 'Whirlpool_System/Water_System/Pipes,_Fittings_&_Disinfection/Pipes_&_Fittings/U_Seal_Gasket/U_Seal_Gasket.jpg', NULL, 'U Seal Gasket', 'ISJNSQU'),
(243, 'Body Open Multijet', NULL, NULL, 'Body and Nozzle-Body', 'ISJMULJ'),
(244, 'Body Blind Lh Multijet', NULL, NULL, 'Body and Nozzle-Body', 'ISJMULJ'),
(245, 'Body Blind Rt Multijet', NULL, NULL, 'Body and Nozzle-Body', 'ISJMULJ'),
(246, 'White Nozzle', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Multi_Jet/Body-Nozzle/Nozzle/Nozzle_White.jpg', NULL, 'Body and Nozzle-Nozzle', 'ISJMULJ'),
(247, 'Chrome Nozzle', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Multi_Jet/Body-Nozzle/Nozzle/Nozzle_Chrome.jpg', NULL, 'Body and Nozzle-Nozzle', 'ISJMULJ'),
(249, 'ISJPLMFL05: Chrome Cover Multijet', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Multi_Jet/Cover/Cover_Chrome.jpg', NULL, 'Cover', 'ISJMULJ'),
(250, 'ISJPLMFL01: White Cover Multijet', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Multi_Jet/Cover/Cover_White.jpg', NULL, 'Cover', 'ISJMULJ'),
(251, 'ISRGUA63494: Flat Sponge Gasket Multijet', 'Whirlpool_System/Water_System/Pipes,_Fittings_&_Disinfection/Pipes_&_Fittings/Flat_Sponge_Gasket/Flat_Sponge_Gasket.jpg', NULL, 'Flat Sponge Gasket', 'ISJMULJ'),
(252, 'ISTRCHMUJ000: Key Multijet', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Multi_Jet/Optional/Key/Key(ISTRCHMUJ000).jpg', NULL, 'Key', 'ISJMULJ'),
(253, 'ISRGUMJR000: U Seal Gasket Multijet', 'Whirlpool_System/Water_System/Pipes,_Fittings_&_Disinfection/Pipes_&_Fittings/U_Seal_Gasket/U_Seal_Gasket.jpg', NULL, 'U Seal Gasket', 'ISJMULJ'),
(254, 'MNAIRJPL05: Chrome Cover', 'Whirlpool_System/Air_System/Airjet/Airjet_Moon/Cover/Cover_Chrome.png', NULL, 'Cover', 'MNAIRJ'),
(255, 'MNAIRJPL01: White Cover', 'Whirlpool_System/Air_System/Airjet/Airjet_Moon/Cover/Cover_White.png', NULL, 'Cover', 'MNAIRJ'),
(256, 'MNAIRJUG05: Chrome Insert', 'Whirlpool_System/Air_System/Airjet/Airjet_Moon/Nozzle/Nozzle_Chrome.png', NULL, 'Insert', 'MNAIRJ'),
(257, 'MNAIRJUG01: White Insert', 'Whirlpool_System/Air_System/Airjet/Airjet_Moon/Nozzle/Nozzle_White.png', NULL, 'Insert', 'MNAIRJ'),
(258, 'SACITRONIC01: Standard Cover', NULL, NULL, 'Cover', 'SACITRONIC'),
(259, 'SACITRONIC02: New Cover', 'Whirlpool_System/Water_System/Controls/Sacitronic/Cover/Cover_New.png', NULL, 'Cover', 'SACITRONIC'),
(260, 'S: Silicone Application', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Moon_Jet/Silicone_Guarnizione/Silicone.png', NULL, 'Silicone or Gasket', 'MNJ'),
(261, 'G: Gasket Application', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Moon_Jet/Silicone_Guarnizione/Guarnizione.png', NULL, 'Silicone or Gasket', 'MNJ'),
(264, 'MNJKEY1: Internal Inspection Key', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Moon_Jet/Optional/Internal_Inspection_Key/Internal_Inspection_Key.png', NULL, 'Key', 'MNJ'),
(265, 'MNJKEY2: Ring Nut Tightening Key', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Moon_Jet/Optional/Ring_Nut_Tightening_Key/Ring_Nut_Tightening_Key.png', NULL, 'Key', 'MNJ'),
(266, 'MNJKEY3: Led System Key', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Moon_Jet/Optional/Led_System_Key/Led_System_Key.png', NULL, 'Key', 'MNJ'),
(267, 'MNJKEY4: Nozzle Key', 'Whirlpool_System/Water_System/Jets,_Suction_&_Sealings/Jets/Moon_Jet/Optional/Nozzle_Key/Nozzle_Key.png', NULL, 'Key', 'MNJ');

-- --------------------------------------------------------

--
-- Struttura della tabella `Utenti`
--

CREATE TABLE `Utenti` (
  `id` int NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `Utenti`
--

INSERT INTO `Utenti` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$T5do/0xhopseCNxaKJc6Lu41ypt9MxtDTIMRKL0rVUp.cmcvCx0MS');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `CodiceConfigurazioneComplessa`
--
ALTER TABLE `CodiceConfigurazioneComplessa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prodottoRiga1` (`prodottoRiga1`),
  ADD KEY `prodottoRiga2` (`prodottoRiga2`),
  ADD KEY `prodottoRiga3` (`prodottoRiga3`);

--
-- Indici per le tabelle `Kit`
--
ALTER TABLE `Kit`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codice_univoco` (`codice_univoco`);

--
-- Indici per le tabelle `ProdottoConfigurabile`
--
ALTER TABLE `ProdottoConfigurabile`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codice_base` (`codice_base`);

--
-- Indici per le tabelle `ProdottoSingolo`
--
ALTER TABLE `ProdottoSingolo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codice_univoco` (`codice_univoco`);

--
-- Indici per le tabelle `StrutturaKit`
--
ALTER TABLE `StrutturaKit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `codice_kit` (`codice_kit`),
  ADD KEY `codice_prodotto` (`codice_prodottoSingolo`),
  ADD KEY `codice_pck` (`codice_prodottoConfigurabile`);

--
-- Indici per le tabelle `StrutturaPC`
--
ALTER TABLE `StrutturaPC`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`),
  ADD KEY `codice_pc` (`codice_pc`);

--
-- Indici per le tabelle `Utenti`
--
ALTER TABLE `Utenti`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `CodiceConfigurazioneComplessa`
--
ALTER TABLE `CodiceConfigurazioneComplessa`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT per la tabella `Kit`
--
ALTER TABLE `Kit`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT per la tabella `ProdottoConfigurabile`
--
ALTER TABLE `ProdottoConfigurabile`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT per la tabella `ProdottoSingolo`
--
ALTER TABLE `ProdottoSingolo`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT per la tabella `StrutturaKit`
--
ALTER TABLE `StrutturaKit`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

--
-- AUTO_INCREMENT per la tabella `StrutturaPC`
--
ALTER TABLE `StrutturaPC`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=268;

--
-- AUTO_INCREMENT per la tabella `Utenti`
--
ALTER TABLE `Utenti`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `CodiceConfigurazioneComplessa`
--
ALTER TABLE `CodiceConfigurazioneComplessa`
  ADD CONSTRAINT `prodottoRiga1` FOREIGN KEY (`prodottoRiga1`) REFERENCES `StrutturaPC` (`nome`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `prodottoRiga2` FOREIGN KEY (`prodottoRiga2`) REFERENCES `StrutturaPC` (`nome`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `prodottoRiga3` FOREIGN KEY (`prodottoRiga3`) REFERENCES `StrutturaPC` (`nome`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Limiti per la tabella `StrutturaKit`
--
ALTER TABLE `StrutturaKit`
  ADD CONSTRAINT `codice_kit` FOREIGN KEY (`codice_kit`) REFERENCES `Kit` (`codice_univoco`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `codice_pck` FOREIGN KEY (`codice_prodottoConfigurabile`) REFERENCES `ProdottoConfigurabile` (`codice_base`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `codice_prodotto` FOREIGN KEY (`codice_prodottoSingolo`) REFERENCES `ProdottoSingolo` (`codice_univoco`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `StrutturaPC`
--
ALTER TABLE `StrutturaPC`
  ADD CONSTRAINT `codice_pc` FOREIGN KEY (`codice_pc`) REFERENCES `ProdottoConfigurabile` (`codice_base`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
