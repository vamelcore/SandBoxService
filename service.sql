-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Хост: localhost:3306
-- Время создания: Май 23 2016 г., 17:18
-- Версия сервера: 5.5.49-0ubuntu0.14.04.1
-- Версия PHP: 5.5.9-1ubuntu4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `glushitelservice`
--

-- --------------------------------------------------------

--
-- Структура таблицы `akciya`
--

CREATE TABLE IF NOT EXISTS `akciya` (
  `ID` int(10) NOT NULL,
  `ID_kateg` int(11) NOT NULL,
  `ID_tov` int(11) NOT NULL,
  `ID_oper` int(11) NOT NULL,
  `ID_tp` int(11) NOT NULL,
  `cena` varchar(100) NOT NULL,
  `voznag` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `beznal`
--

CREATE TABLE IF NOT EXISTS `beznal` (
  `ID` int(10) NOT NULL,
  `ID_scheta` int(10) NOT NULL,
  `ID_prodaja` int(10) NOT NULL,
  `data` varchar(100) NOT NULL,
  `magazine` varchar(100) NOT NULL,
  `summa` varchar(100) NOT NULL,
  `izmenenie` varchar(100) NOT NULL,
  `user` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `diff_cena`
--

CREATE TABLE IF NOT EXISTS `diff_cena` (
  `ID` int(10) NOT NULL,
  `ID_magazina` varchar(100) NOT NULL,
  `ID_tovara` varchar(100) NOT NULL,
  `new_cena` varchar(100) NOT NULL,
  `new_bonus` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `kassa`
--

CREATE TABLE IF NOT EXISTS `kassa` (
  `ID` int(10) NOT NULL,
  `ID_prodaja` int(10) NOT NULL,
  `data` varchar(100) NOT NULL,
  `magazine` varchar(100) NOT NULL,
  `vkasse` varchar(100) NOT NULL,
  `inkas` varchar(100) NOT NULL,
  `user` varchar(100) NOT NULL,
  `sec_data` varchar(100) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1382 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `magazinu`
--

CREATE TABLE IF NOT EXISTS `magazinu` (
  `ID` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `tab_show` varchar(5) NOT NULL,
  `perv_prod` varchar(5) NOT NULL,
  `terminal` varchar(5) NOT NULL,
  `add` varchar(100) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `magazinu`
--

INSERT INTO `magazinu` (`ID`, `name`, `tab_show`, `perv_prod`, `terminal`, `add`) VALUES
(1, 'GlushitelServise ', '111', '0', 'k', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `operatoru`
--

CREATE TABLE IF NOT EXISTS `operatoru` (
  `ID` int(10) NOT NULL,
  `oper` varchar(100) NOT NULL,
  `priznak` varchar(100) NOT NULL,
  `schet` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `otchet`
--

CREATE TABLE IF NOT EXISTS `otchet` (
  `ID` int(10) NOT NULL,
  `ID_prodaja` int(10) NOT NULL,
  `data` varchar(100) NOT NULL,
  `magazin` varchar(100) NOT NULL,
  `ID_operatora` varchar(100) NOT NULL,
  `fio` varchar(100) NOT NULL,
  `nomer_abon` varchar(100) NOT NULL,
  `kontakt_nomer` varchar(100) NOT NULL,
  `paket` varchar(100) NOT NULL,
  `kluch_evdo` varchar(100) NOT NULL,
  `avans` varchar(100) NOT NULL,
  `oplata` varchar(100) NOT NULL,
  `ostatok` varchar(100) NOT NULL,
  `oborudov` varchar(100) NOT NULL,
  `sec_data` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=567 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `payment_2chast`
--

CREATE TABLE IF NOT EXISTS `payment_2chast` (
  `ID` int(10) NOT NULL,
  `poryadok` varchar(100) NOT NULL,
  `nomer` varchar(100) NOT NULL,
  `l_s` varchar(100) NOT NULL,
  `fio_abonenta` varchar(200) NOT NULL,
  `podklucheno` varchar(200) NOT NULL,
  `akciya` varchar(200) NOT NULL,
  `diler` varchar(200) NOT NULL,
  `opisanie` varchar(200) NOT NULL,
  `data` varchar(100) NOT NULL,
  `data_otkl` varchar(100) NOT NULL,
  `region` varchar(200) NOT NULL,
  `tip` varchar(200) NOT NULL,
  `oficialn_diler` varchar(200) NOT NULL,
  `vtoraya_chast_voznag` varchar(100) NOT NULL,
  `sec_data` varchar(10) NOT NULL,
  `filename` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `payment_dilers`
--

CREATE TABLE IF NOT EXISTS `payment_dilers` (
  `ID` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `procent` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `payment_neokup`
--

CREATE TABLE IF NOT EXISTS `payment_neokup` (
  `ID` int(10) NOT NULL,
  `nomer` varchar(100) NOT NULL,
  `l_s` varchar(100) NOT NULL,
  `fio_abonenta` varchar(200) NOT NULL,
  `podklucheno` varchar(200) NOT NULL,
  `akciya` varchar(200) NOT NULL,
  `diler` varchar(200) NOT NULL,
  `opisanie` varchar(200) NOT NULL,
  `data` varchar(200) NOT NULL,
  `data_otkl` varchar(200) NOT NULL,
  `region` varchar(200) NOT NULL,
  `tip` varchar(200) NOT NULL,
  `oficialn_diler` varchar(200) NOT NULL,
  `uderjano` varchar(100) NOT NULL,
  `sec_data` varchar(10) NOT NULL,
  `filename` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `payment_ottok`
--

CREATE TABLE IF NOT EXISTS `payment_ottok` (
  `ID` int(10) NOT NULL,
  `region` varchar(200) NOT NULL,
  `oficialn_diler` varchar(200) NOT NULL,
  `diler` varchar(200) NOT NULL,
  `abonent` varchar(200) NOT NULL,
  `lic_schet` varchar(100) NOT NULL,
  `nomer_tel` varchar(100) NOT NULL,
  `tp_pri_podkl` varchar(200) NOT NULL,
  `tip_tp` varchar(200) NOT NULL,
  `data_podkl` varchar(200) NOT NULL,
  `akciya` varchar(200) NOT NULL,
  `tp_pri_otkl` varchar(200) NOT NULL,
  `data_otkl` varchar(200) NOT NULL,
  `uderjat_za_ottok` varchar(100) NOT NULL,
  `sec_data` varchar(10) NOT NULL,
  `filename` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `payment_podkl`
--

CREATE TABLE IF NOT EXISTS `payment_podkl` (
  `ID` int(10) NOT NULL,
  `nomer` varchar(100) NOT NULL,
  `l_s` varchar(100) NOT NULL,
  `fio_abonenta` varchar(200) NOT NULL,
  `podklucheno` varchar(200) NOT NULL,
  `akciya` varchar(200) NOT NULL,
  `diler` varchar(200) NOT NULL,
  `opisanie` varchar(200) NOT NULL,
  `data` varchar(200) NOT NULL,
  `region` varchar(200) NOT NULL,
  `tip` varchar(200) NOT NULL,
  `oficialn_diler` varchar(200) NOT NULL,
  `proekt` varchar(200) NOT NULL,
  `gruppa_voznag` varchar(200) NOT NULL,
  `kateg_voznag` varchar(200) NOT NULL,
  `tip_voznag` varchar(200) NOT NULL,
  `systema_nalog` varchar(200) NOT NULL,
  `voznagrajdenie` varchar(100) NOT NULL,
  `dop_bonus` varchar(100) NOT NULL,
  `router` varchar(100) NOT NULL,
  `sec_data` varchar(10) NOT NULL,
  `filename` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `payment_router`
--

CREATE TABLE IF NOT EXISTS `payment_router` (
  `ID` int(10) NOT NULL,
  `data` varchar(100) NOT NULL,
  `cena` varchar(100) NOT NULL,
  `l_s` varchar(100) NOT NULL,
  `nomer_telefona` varchar(100) NOT NULL,
  `data_opl_scheta` varchar(100) NOT NULL,
  `klient` varchar(200) NOT NULL,
  `terminal` varchar(200) NOT NULL,
  `diler` varchar(200) NOT NULL,
  `oficialn_diler` varchar(200) NOT NULL,
  `polzovatel` varchar(200) NOT NULL,
  `god` varchar(10) NOT NULL,
  `mesyac` varchar(10) NOT NULL,
  `den` varchar(10) NOT NULL,
  `region_po_dileru` varchar(200) NOT NULL,
  `region_po_nomeru` varchar(200) NOT NULL,
  `summa_nalogu` varchar(200) NOT NULL,
  `tip_voznagrajdeniya` varchar(200) NOT NULL,
  `voznagrajdenie` varchar(100) NOT NULL,
  `sec_data` varchar(10) NOT NULL,
  `filename` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `payment_trafik`
--

CREATE TABLE IF NOT EXISTS `payment_trafik` (
  `ID` int(10) NOT NULL,
  `region` varchar(200) NOT NULL,
  `oficialn_diler` varchar(200) NOT NULL,
  `diler` varchar(200) NOT NULL,
  `lic_schet` varchar(100) NOT NULL,
  `abonent` varchar(200) NOT NULL,
  `telefon` varchar(100) NOT NULL,
  `tarif_plan` varchar(200) NOT NULL,
  `data_podkl` varchar(100) NOT NULL,
  `bonus` varchar(100) NOT NULL,
  `internet_trafik` varchar(100) NOT NULL,
  `akciya` varchar(100) NOT NULL,
  `paket_v_otchot_mes` varchar(200) NOT NULL,
  `sec_data` varchar(10) NOT NULL,
  `filename` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `payment_vosstanov`
--

CREATE TABLE IF NOT EXISTS `payment_vosstanov` (
  `ID` int(10) NOT NULL,
  `region` varchar(200) NOT NULL,
  `oficialn_diler` varchar(200) NOT NULL,
  `nomer_telefona` varchar(100) NOT NULL,
  `l_s` varchar(100) NOT NULL,
  `data_podkl` varchar(100) NOT NULL,
  `torgovaya_tochka` varchar(200) NOT NULL,
  `klient` varchar(200) NOT NULL,
  `usluga` varchar(200) NOT NULL,
  `operator` varchar(200) NOT NULL,
  `bonus` varchar(100) NOT NULL,
  `sec_data` varchar(10) NOT NULL,
  `filename` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `peremeschenie`
--

CREATE TABLE IF NOT EXISTS `peremeschenie` (
  `ID` int(10) NOT NULL,
  `data` varchar(100) DEFAULT NULL,
  `kateg` varchar(100) NOT NULL,
  `tovar` varchar(100) DEFAULT NULL,
  `kolichestvo` varchar(100) DEFAULT NULL,
  `peremescheno_otkuda` varchar(100) DEFAULT NULL,
  `peremescheno_kuda` varchar(100) DEFAULT NULL,
  `sec_data` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `plan`
--

CREATE TABLE IF NOT EXISTS `plan` (
  `ID` int(10) NOT NULL,
  `ID_magazina` int(10) NOT NULL,
  `naimenov` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `plane` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `plan`
--

INSERT INTO `plan` (`ID`, `ID_magazina`, `naimenov`, `name`, `plane`) VALUES
(1, 1, 'Терминалы', 'term', 0),
(2, 1, 'Аксесуары', 'acses', 0),
(4, 1, 'Подключения', 'podkl', 0),
(5, 1, 'Стартовые', 'starpak', 0),
(6, 1, 'Бонус к выполнению плана', 'bonus', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `prase`
--

CREATE TABLE IF NOT EXISTS `prase` (
  `ID` int(100) NOT NULL,
  `ID_kategorii` int(100) NOT NULL,
  `tovar` varchar(100) NOT NULL,
  `cena` varchar(100) NOT NULL,
  `voznag` varchar(100) NOT NULL DEFAULT '----'
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `prihodu`
--

CREATE TABLE IF NOT EXISTS `prihodu` (
  `ID` int(10) NOT NULL,
  `data` varchar(100) NOT NULL,
  `ID_magazina` int(10) NOT NULL,
  `ID_kategorii` int(10) NOT NULL,
  `ID_tovara` int(10) NOT NULL,
  `kol_prihoda` varchar(100) NOT NULL,
  `primech` varchar(100) NOT NULL,
  `user` varchar(100) NOT NULL,
  `sec_data` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=988 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `prodaja`
--

CREATE TABLE IF NOT EXISTS `prodaja` (
  `ID` int(10) NOT NULL,
  `data` varchar(100) NOT NULL,
  `b` varchar(2) NOT NULL,
  `magazin` varchar(100) NOT NULL,
  `kategoria` varchar(100) NOT NULL,
  `naimenovanie` varchar(100) NOT NULL,
  `serialnum` varchar(100) NOT NULL,
  `shtrihkod` varchar(100) NOT NULL,
  `voznag_za_jelezo` varchar(100) NOT NULL,
  `stoimost` varchar(100) NOT NULL,
  `procent_prod` varchar(10) NOT NULL,
  `operator` varchar(100) DEFAULT NULL,
  `tarifn_plan` varchar(100) DEFAULT NULL,
  `voznag_za_tp` varchar(100) DEFAULT NULL,
  `oplata_tp_podkluchenie` varchar(100) DEFAULT NULL,
  `kluch_evdo` varchar(100) DEFAULT NULL,
  `kontakt_nomer_tel` varchar(100) DEFAULT NULL,
  `FIO` varchar(200) DEFAULT NULL,
  `abonent_nomer` varchar(100) DEFAULT NULL,
  `mesto_polz` varchar(100) DEFAULT NULL,
  `skidka` varchar(100) DEFAULT NULL,
  `sebestoimost` varchar(10) DEFAULT NULL,
  `add` varchar(500) DEFAULT NULL,
  `user` varchar(100) NOT NULL,
  `akciya` varchar(5) NOT NULL,
  `sposob_opl` varchar(5) NOT NULL,
  `printer_ID` varchar(10) NOT NULL,
  `sec_data` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=680 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `rahunok`
--

CREATE TABLE IF NOT EXISTS `rahunok` (
  `ID` int(10) NOT NULL,
  `date` varchar(100) NOT NULL,
  `ID_operatora` int(10) NOT NULL,
  `rahunok` varchar(100) NOT NULL,
  `sec_data` varchar(100) NOT NULL,
  `user` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=257 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `rashodu`
--

CREATE TABLE IF NOT EXISTS `rashodu` (
  `ID` int(10) NOT NULL,
  `p_m` varchar(5) NOT NULL,
  `ID_magazina` int(10) NOT NULL,
  `primech` varchar(200) NOT NULL,
  `summ` varchar(100) NOT NULL,
  `sec_data` varchar(100) NOT NULL,
  `data` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `remontu`
--

CREATE TABLE IF NOT EXISTS `remontu` (
  `ID` int(10) NOT NULL,
  `magazin` varchar(100) NOT NULL,
  `data_priema` varchar(100) DEFAULT NULL,
  `nomer_tel` varchar(100) DEFAULT NULL,
  `model` varchar(100) DEFAULT NULL,
  `prichina_remonta` varchar(200) DEFAULT NULL,
  `garantiya` varchar(10) DEFAULT NULL,
  `stoimost` varchar(100) DEFAULT NULL,
  `zacluchenie` varchar(100) DEFAULT NULL,
  `sec_data` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `sebestoim`
--

CREATE TABLE IF NOT EXISTS `sebestoim` (
  `ID` int(10) NOT NULL,
  `ID_magazina` int(10) NOT NULL,
  `ID_tovara` int(10) NOT NULL,
  `kolichestvo` varchar(100) NOT NULL,
  `sebestoimost` varchar(100) NOT NULL,
  `data` varchar(100) NOT NULL,
  `sys_data` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=166 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `serialnum`
--

CREATE TABLE IF NOT EXISTS `serialnum` (
  `ID` int(10) NOT NULL,
  `ID_ketegorii` int(10) NOT NULL,
  `ID_tovara` int(10) NOT NULL,
  `ID_shtrihkoda` int(10) NOT NULL,
  `serial_number` varchar(100) NOT NULL,
  `date_time_change` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `shoutbox`
--

CREATE TABLE IF NOT EXISTS `shoutbox` (
  `id` int(5) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user` varchar(25) NOT NULL,
  `message` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `shtrihkod`
--

CREATE TABLE IF NOT EXISTS `shtrihkod` (
  `ID` int(10) NOT NULL,
  `ID_ketegorii` int(10) NOT NULL,
  `ID_tovara` int(10) NOT NULL,
  `shtrih` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `sklad_kategorii`
--

CREATE TABLE IF NOT EXISTS `sklad_kategorii` (
  `ID` int(10) NOT NULL,
  `kateg` varchar(100) NOT NULL,
  `add` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `sklad_tovaru`
--

CREATE TABLE IF NOT EXISTS `sklad_tovaru` (
  `ID` int(10) NOT NULL,
  `ID_magazina` int(10) NOT NULL,
  `ID_kategorii` int(10) NOT NULL,
  `ID_tovara` int(10) NOT NULL,
  `kol_posl_prihoda` varchar(100) NOT NULL,
  `data_posl_prihoda` varchar(100) NOT NULL,
  `kolichestvo` int(5) NOT NULL,
  `add` varchar(100) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `sysconfig`
--

CREATE TABLE IF NOT EXISTS `sysconfig` (
  `ID` int(10) NOT NULL,
  `param` varchar(100) NOT NULL,
  `value` varchar(500) NOT NULL,
  `enabled` varchar(5) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `sysconfig`
--

INSERT INTO `sysconfig` (`ID`, `param`, `value`, `enabled`) VALUES
(1, 'pay_message', 'Уважаемые пользователи, не забывайте, пожалуйста, выполнять оплату до каждого 1-го числа последующего месяца.</br> &nbsp;&nbsp;&nbsp;Поскольку с наступлением нового месяца восстановление доступа к базе данных может занять несколько часов!', 'yes'),
(2, 'site_redirect', 'http://sand-box.pp.ua/payment_info_for_sand-box/', 'no');

-- --------------------------------------------------------

--
-- Структура таблицы `tarifplan`
--

CREATE TABLE IF NOT EXISTS `tarifplan` (
  `ID` int(10) NOT NULL,
  `ID_oper` int(10) NOT NULL,
  `tarifplan` varchar(100) NOT NULL,
  `stoim_podkl` varchar(100) NOT NULL,
  `voznagtp` varchar(100) NOT NULL DEFAULT '----'
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `timezone`
--

CREATE TABLE IF NOT EXISTS `timezone` (
  `ID` int(3) NOT NULL,
  `time_zone` varchar(100) CHARACTER SET latin1 NOT NULL,
  `prim` varchar(100) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `timezone`
--

INSERT INTO `timezone` (`ID`, `time_zone`, `prim`) VALUES
(1, 'summer', '');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `ID` int(10) NOT NULL,
  `login` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `AED` varchar(50) NOT NULL,
  `VOT` varchar(50) NOT NULL,
  `storepriv` varchar(50) NOT NULL,
  `allpriv` varchar(1) NOT NULL,
  `kassapriv` varchar(1) NOT NULL,
  `rollpriv` varchar(1) NOT NULL,
  `sebespriv` varchar(1) NOT NULL,
  `kontpriv` varchar(1) NOT NULL,
  `adminpriv` varchar(10) NOT NULL,
  `rootpriv` varchar(10) NOT NULL,
  `fio_usera` varchar(100) NOT NULL,
  `stavka` varchar(100) NOT NULL,
  `bonus_stavka` varchar(5) NOT NULL,
  `proc_stavka` varchar(5) NOT NULL,
  `vozvrat_voznag` varchar(5) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1100 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`ID`, `login`, `password`, `AED`, `VOT`, `storepriv`, `allpriv`, `kassapriv`, `rollpriv`, `sebespriv`, `kontpriv`, `adminpriv`, `rootpriv`, `fio_usera`, `stavka`, `bonus_stavka`, `proc_stavka`, `vozvrat_voznag`) VALUES
(1001, 'admin', '25f9e794323b453885f5181f1b624d0b', '11111100000', '111111000', '1', '1', '1', '1', '1', '0', '1', '1', '', '0', '0', '0', '0');

-- --------------------------------------------------------

--
-- Структура таблицы `vozvratu`
--

CREATE TABLE IF NOT EXISTS `vozvratu` (
  `ID` int(10) NOT NULL,
  `magazin` varchar(100) NOT NULL,
  `data` varchar(100) DEFAULT NULL,
  `t_a` varchar(5) DEFAULT NULL,
  `kategoria` varchar(100) NOT NULL,
  `naimenovanie` varchar(100) DEFAULT NULL,
  `esn` varchar(100) DEFAULT NULL,
  `kolichestvo` varchar(10) DEFAULT NULL,
  `data_pokupki_vozvr_ob` varchar(100) DEFAULT NULL,
  `summa_nal` varchar(100) DEFAULT NULL,
  `summa_bez_nal` varchar(100) DEFAULT NULL,
  `sebestoim` varchar(100) DEFAULT NULL,
  `prichina_vozvrata` varchar(200) DEFAULT NULL,
  `per_14_dney` varchar(5) DEFAULT NULL,
  `obmen_na` varchar(100) DEFAULT NULL,
  `daln_dvijenie_vozvr_tov` varchar(100) DEFAULT NULL,
  `primechanie` varchar(200) DEFAULT NULL,
  `flag` varchar(10) NOT NULL DEFAULT 'false',
  `sec_data` varchar(100) NOT NULL,
  `kto_pvinyal` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `zarplata`
--

CREATE TABLE IF NOT EXISTS `zarplata` (
  `ID` int(10) NOT NULL,
  `ID_prodaja` int(10) NOT NULL,
  `ID_magazina` int(10) NOT NULL,
  `ID_usera` int(10) NOT NULL,
  `data` varchar(100) DEFAULT NULL,
  `vremya` varchar(100) NOT NULL,
  `polniy_den` varchar(100) DEFAULT NULL,
  `polov_dnya` varchar(100) DEFAULT NULL,
  `voznag_za_tp` varchar(100) DEFAULT NULL,
  `prodaja` varchar(100) DEFAULT NULL,
  `procent` varchar(10) DEFAULT NULL,
  `k_oplate` varchar(100) DEFAULT NULL,
  `vudano` varchar(100) DEFAULT NULL,
  `shtraf` varchar(100) DEFAULT NULL,
  `bonus` varchar(100) DEFAULT NULL,
  `user` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1374 DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `akciya`
--
ALTER TABLE `akciya`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `beznal`
--
ALTER TABLE `beznal`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `diff_cena`
--
ALTER TABLE `diff_cena`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `kassa`
--
ALTER TABLE `kassa`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `magazinu`
--
ALTER TABLE `magazinu`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `operatoru`
--
ALTER TABLE `operatoru`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `otchet`
--
ALTER TABLE `otchet`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `payment_2chast`
--
ALTER TABLE `payment_2chast`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `payment_dilers`
--
ALTER TABLE `payment_dilers`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `payment_neokup`
--
ALTER TABLE `payment_neokup`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `payment_ottok`
--
ALTER TABLE `payment_ottok`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `payment_podkl`
--
ALTER TABLE `payment_podkl`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `payment_router`
--
ALTER TABLE `payment_router`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `payment_trafik`
--
ALTER TABLE `payment_trafik`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `payment_vosstanov`
--
ALTER TABLE `payment_vosstanov`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `peremeschenie`
--
ALTER TABLE `peremeschenie`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `plan`
--
ALTER TABLE `plan`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `prase`
--
ALTER TABLE `prase`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `prihodu`
--
ALTER TABLE `prihodu`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `prodaja`
--
ALTER TABLE `prodaja`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `rahunok`
--
ALTER TABLE `rahunok`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `rashodu`
--
ALTER TABLE `rashodu`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `remontu`
--
ALTER TABLE `remontu`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `sebestoim`
--
ALTER TABLE `sebestoim`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `serialnum`
--
ALTER TABLE `serialnum`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `shoutbox`
--
ALTER TABLE `shoutbox`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `shtrihkod`
--
ALTER TABLE `shtrihkod`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `sklad_kategorii`
--
ALTER TABLE `sklad_kategorii`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `sklad_tovaru`
--
ALTER TABLE `sklad_tovaru`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `sysconfig`
--
ALTER TABLE `sysconfig`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `tarifplan`
--
ALTER TABLE `tarifplan`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `timezone`
--
ALTER TABLE `timezone`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `vozvratu`
--
ALTER TABLE `vozvratu`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `zarplata`
--
ALTER TABLE `zarplata`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `akciya`
--
ALTER TABLE `akciya`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `beznal`
--
ALTER TABLE `beznal`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `diff_cena`
--
ALTER TABLE `diff_cena`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `kassa`
--
ALTER TABLE `kassa`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1382;
--
-- AUTO_INCREMENT для таблицы `magazinu`
--
ALTER TABLE `magazinu`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `operatoru`
--
ALTER TABLE `operatoru`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT для таблицы `otchet`
--
ALTER TABLE `otchet`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=567;
--
-- AUTO_INCREMENT для таблицы `payment_2chast`
--
ALTER TABLE `payment_2chast`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `payment_dilers`
--
ALTER TABLE `payment_dilers`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `payment_neokup`
--
ALTER TABLE `payment_neokup`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `payment_ottok`
--
ALTER TABLE `payment_ottok`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `payment_podkl`
--
ALTER TABLE `payment_podkl`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `payment_router`
--
ALTER TABLE `payment_router`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `payment_trafik`
--
ALTER TABLE `payment_trafik`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `payment_vosstanov`
--
ALTER TABLE `payment_vosstanov`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `peremeschenie`
--
ALTER TABLE `peremeschenie`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `plan`
--
ALTER TABLE `plan`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT для таблицы `prase`
--
ALTER TABLE `prase`
  MODIFY `ID` int(100) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=104;
--
-- AUTO_INCREMENT для таблицы `prihodu`
--
ALTER TABLE `prihodu`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=988;
--
-- AUTO_INCREMENT для таблицы `prodaja`
--
ALTER TABLE `prodaja`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=680;
--
-- AUTO_INCREMENT для таблицы `rahunok`
--
ALTER TABLE `rahunok`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=257;
--
-- AUTO_INCREMENT для таблицы `rashodu`
--
ALTER TABLE `rashodu`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `remontu`
--
ALTER TABLE `remontu`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `sebestoim`
--
ALTER TABLE `sebestoim`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=166;
--
-- AUTO_INCREMENT для таблицы `serialnum`
--
ALTER TABLE `serialnum`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `shoutbox`
--
ALTER TABLE `shoutbox`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `shtrihkod`
--
ALTER TABLE `shtrihkod`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `sklad_kategorii`
--
ALTER TABLE `sklad_kategorii`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT для таблицы `sklad_tovaru`
--
ALTER TABLE `sklad_tovaru`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=104;
--
-- AUTO_INCREMENT для таблицы `sysconfig`
--
ALTER TABLE `sysconfig`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `tarifplan`
--
ALTER TABLE `tarifplan`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT для таблицы `timezone`
--
ALTER TABLE `timezone`
  MODIFY `ID` int(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1100;
--
-- AUTO_INCREMENT для таблицы `vozvratu`
--
ALTER TABLE `vozvratu`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `zarplata`
--
ALTER TABLE `zarplata`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1374;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
