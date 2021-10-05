-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Апр 30 2021 г., 03:33
-- Версия сервера: 5.7.33-cll-lve
-- Версия PHP: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `d76696_ankas`
--

-- --------------------------------------------------------

--
-- Структура таблицы `brands`
--

CREATE TABLE `brands` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `brands`
--

INSERT INTO `brands` (`id`, `name`, `country`, `image`, `description`) VALUES
(1, 'Satronic / Honeywell', 'Великобритания', NULL, NULL),
(2, 'Elco', NULL, NULL, 'Оборудование «ELCO heating solutions» находится в авангарде технологий теплоснабжения. За девяносто с лишним лет бренд ELCO заслужил признание в Европе.\r\n\r\nБолее 1,7 миллионов конденсационных котлов, горелок и гелиосистем установлено по всей Европе. \r\n\r\nМы пионеры в сфере теплоснабжения и лидеры рынка в Швейцарии.\r\nВсе решения для теплоснабжения от ELCO насыщены интеллектом, а энергосберегающие технологии разрабатываются в соответствии с индивидуальными особенностями проекта. От консультации до обслуживания и эксплуатации все наши решения для теплоснабжения опираются на первоклассный сервис и постпродажную поддержку.'),
(3, 'Piusi', 'Италия', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '/images/default-image.png',
  `description` text COLLATE utf8mb4_unicode_ci,
  `description_short` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `name`, `published`, `image`, `description`, `description_short`, `created_at`, `updated_at`) VALUES
(1, 'Оборудование для мини АЗС', 1, '/images/categories/oborudovanie-dlya-mini-azs.jpg', '', '', '2020-12-18 21:26:07', '2021-01-30 09:46:21'),
(2, 'Запчасти для горелок', 1, '/images/categories/zapchasti-dlya-gorelok.jpg', '', '', '2020-12-18 21:26:07', '2020-12-18 21:26:07'),
(3, 'Насосы для горелок', 1, '/images/categories/nasosy-dlya-gorelok.jpg', '', '', '2020-12-18 21:28:39', '2020-12-18 21:26:07'),
(4, 'Топочные автоматы', 1, '/images/categories/topochnye-avtomaty.jpg', '', '', '2020-12-18 21:26:07', '2020-12-18 21:26:07'),
(7, 'Горелки для котлов отопления', 1, '/images/categories/gorelki.jpg', NULL, NULL, '2020-12-23 05:59:22', '2020-12-23 05:59:22');

-- --------------------------------------------------------

--
-- Структура таблицы `cys`
--

CREATE TABLE `cys` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `symbol` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `cys`
--

INSERT INTO `cys` (`id`, `name`, `code`, `symbol`) VALUES
(1, 'Рубль', 'RUB', 'руб.'),
(2, 'Доллар', 'USD', '$'),
(3, 'Евро', 'EUR', 'евро'),
(4, 'Тенге', 'KZT', 'тенге'),
(5, 'Юань', 'CNY', 'юаней'),
(6, 'Иена', 'JPY', 'иен');

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2020_12_15_110428_create_products_details_table', 1),
(2, '2020_12_15_120454_create_products_categories_table', 1),
(3, '2020_12_15_120508_create_categories_table', 1),
(4, '2020_12_15_120531_create_brands_table', 1),
(5, '2020_12_15_120600_create_cys_table', 1),
(6, '2020_12_15_120617_create_orders_products_table', 1),
(7, '2020_12_15_120632_create_orders_table', 1),
(8, '2020_12_16_050258_create_subcategories_table', 1),
(9, '2020_12_17_093518_create_users_table', 1),
(10, '2020_12_17_101019_create_rights_table', 1),
(11, '2020_12_17_104016_create_roles_table', 1),
(12, '2020_12_17_110403_create_role_rights_table', 1),
(13, '2020_12_21_063806_z_foreigns', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `third_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sum` int(11) NOT NULL DEFAULT '0',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Не оплачен',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `last_name`, `first_name`, `third_name`, `phone`, `email`, `sum`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Шилов', 'Данила', 'Анатольевич', '12344', 'sales@ankas.ru', 8700, 'Оплачен', '2020-12-23 04:49:19', '2020-12-23 06:01:56'),
(2, 'Д', 'Ш', 'А', '89080545234', 'das', 17400, 'Доставлен', '2020-12-24 14:40:16', '2020-12-24 14:41:22');

-- --------------------------------------------------------

--
-- Структура таблицы `orders_products`
--

CREATE TABLE `orders_products` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `count` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `orders_products`
--

INSERT INTO `orders_products` (`id`, `product_id`, `order_id`, `count`) VALUES
(1, 1, 1, 1),
(2, 1, 2, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `products_categories`
--

CREATE TABLE `products_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `products_detail_id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `products_categories`
--

INSERT INTO `products_categories` (`id`, `products_detail_id`, `category_id`) VALUES
(3, 1, 4),
(4, 2, 3),
(5, 3, 1),
(7, 6, 7);

-- --------------------------------------------------------

--
-- Структура таблицы `products_details`
--

CREATE TABLE `products_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `vendor_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand_id` int(10) UNSIGNED NOT NULL,
  `cy_id` int(10) UNSIGNED NOT NULL,
  `price` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT '1',
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `model` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `description_short` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `length` int(11) DEFAULT NULL,
  `width` int(11) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `products_details`
--

INSERT INTO `products_details` (`id`, `vendor_code`, `brand_id`, `cy_id`, `price`, `name`, `is_available`, `published`, `model`, `description`, `description_short`, `image`, `length`, `width`, `height`, `weight`, `created_at`, `updated_at`) VALUES
(1, '02524', 1, 1, 8700, 'Satronic / Honeywell TF 974 Rev.A', 1, 1, 'TF 974 Rev.A', '<p>Топочный автомат Satronic / Honeywell TF 974 Rev.A используется для управления и контроля одноступенчатыми жидкотопливными горелками с функцией подогрева, потребляющими до 30 кг дизеля в час. Менеджер сертифицирован по стандарту EN230. Применяется с приборами контроля горения пламени.</p>\r\n\r\n<p><b>Особенности</b></p>\r\n\r\n<p>Автомат горения способен работать с инфракрасными, ультрафиолетовыми датчиками, фоторезисторами. Используется для одноступенчатых горелок, предохранительное время 10 сек. Оснащен встроенной информационной системой неисправностей. На корпусе размещена кнопка для ручного сброса. Менеджер устанавливается в любом положении.</p>\r\n\r\n<p>Автоматика размещена внутри огнестойкого прозрачного пластикового корпуса с разъемным соединением. Работу менеджера обеспечивает синхронный электрический двигатель. Предусмотрен кулачковый переключатель, электросхемы, 12-контактный привод для контроля программной последовательности.</p>\r\n\r\n<p><b>Достоинства:</b></p>\r\n\r\n<ul>\r\n	<li>непрерывный контроль и управление работой горелки;</li>\r\n	<li>прочный огнестойкий корпус;</li>\r\n	<li>функция диагностики перед запуском;</li>\r\n	<li>защита от низкого напряжения;</li>\r\n	<li>срабатывание сигнала о неполадках;</li>\r\n	<li>удачный баланс цена – характеристики.</li>\r\n</ul>\r\n<p>На сайте можно купить Satronic / Honeywell арт. 02524 TF 974 Rev.A – сертифицированный, надежный аппарат для оснащения системы безопасности горелки и безаварийной эксплуатации системы отопления.</p> \r\n\r\n<p><b>Основные характеристики</b></p>\r\n<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>Предназначен для</td>\r\n			<td>для жидкотопливных горелок</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Тип горелки</td>\r\n			<td>Одноступенчатая</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Режим работы</td>\r\n			<td>прерывистый</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Время предварительной вентиляции</td>\r\n			<td>12 сек</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Предохранительное время</td>\r\n			<td>10 сек</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Время перед поджигом</td>\r\n			<td>12 сек</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Наличие цоколя</td>\r\n			<td>нет</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Расход топлива</td>\r\n			<td>30 кг/ч</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Альтернативный артикул</td>\r\n			<td>65320054</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', 'Топочный автомат Satronic / Honeywell TF 974 Rev.A используется для управления и контроля одноступенчатыми жидкотопливными горелками с функцией подогрева, потребляющими до 30 кг дизеля в час. Применяется с приборами контроля горения пламени.', '/images/products/honeywell-satronic-tf-974-reva-14020.jpg', NULL, NULL, NULL, NULL, '2020-12-20 12:00:00', '2020-12-20 12:00:00'),
(2, '3832637', 2, 1, 154000, 'Elco VG 1.85', 1, 1, 'VG 1.85', '<p><b>Основные характеристики</b></p>\r\n<table>\r\n	<tbody>\r\n		<tr>\r\n			<td>Вид горелки</td>\r\n			<td>Газовая</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Тип горелки</td>\r\n			<td>Одноступенчатая</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Мощность горелки</td>\r\n			<td>от 45 до 85 кВт</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Электропитание</td>\r\n			<td>230 В</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Электродвигатель</td>\r\n			<td>85 Bт</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Потребляемая электрическая мощность</td>\r\n			<td>195 W</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Класс пылевлагозащиты</td>\r\n			<td>IP 21</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Уровень шума</td>\r\n			<td>74 дБ</td>\r\n		</tr>\r\n		<tr>\r\n			<td>Рабочая температура</td>\r\n			<td>от -10 до ++60 °C</td>\r\n		</tr>\r\n	</tbody>\r\n</table>', NULL, '/images/products/elco-vg-185-6604.jpg', NULL, NULL, NULL, NULL, '2020-12-21 12:00:00', '2020-12-21 12:00:00'),
(3, 'F00385P0A', 3, 1, 38500, 'Piusi ST Panther 56 K33', 1, 1, 'ST Panther 56 K33', NULL, 'Piusi ST Panther 56 K33 F00385P0A Колонки этой модификации работают от источников питания на 220 В. Данная мини АЗС для перекачивания ДТ имеет мощность 37...', '/images/products/piusi-st-panther-56-k33-30.jpg', 35, 35, 27, 16, '2020-12-21 18:25:57', '2020-12-21 18:25:57'),
(4, 'еуьз', 1, 1, 32, 'temp', 1, 1, 'цу', NULL, NULL, '/images/default-image.png', 0, 0, 0, 0, '2020-12-22 07:30:52', '2020-12-22 07:30:52'),
(6, '3832637as', 2, 1, 155000, 'Газовая горелка Elco VG 1.85', 1, 1, 'VG 1.85', '<div class=\"b-good-specs__item row2\" style=\"margin: 0px -8px; padding: 4px 8px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-stretch: inherit; line-height: inherit; font-family: robotoregular, helvetica, sans-serif; font-size: 0px; vertical-align: baseline; box-sizing: border-box; cursor: pointer; color: #333333; background-color: #ffffff;\">\r\n<div class=\"b-good-specs__head\" style=\"margin: 0px; padding: 0px; border: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: 20px; font-family: inherit; font-size: 14px; vertical-align: top; width: 325.969px; color: #989898; display: inline-block;\">\r\n<div class=\"name g_tool_tip_container\" style=\"margin: 0px; padding: 0px; border: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: inherit; font-family: inherit; vertical-align: baseline;\">Вид горелки</div>\r\n</div>\r\n&nbsp;\r\n<div class=\"b-good-specs__content\" style=\"margin: 0px; padding: 0px; border: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: 20px; font-family: inherit; font-size: 14px; vertical-align: top; display: inline-block; width: 555.016px; color: #323232;\">Газовая</div>\r\n</div>\r\n<div class=\"b-good-specs__item row2\" style=\"margin: 0px -8px; padding: 4px 8px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-stretch: inherit; line-height: inherit; font-family: robotoregular, helvetica, sans-serif; font-size: 0px; vertical-align: baseline; box-sizing: border-box; cursor: pointer; color: #333333; background-color: #ffffff;\">\r\n<div class=\"b-good-specs__head\" style=\"margin: 0px; padding: 0px; border: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: 20px; font-family: inherit; font-size: 14px; vertical-align: top; width: 325.969px; color: #989898; display: inline-block;\">\r\n<div class=\"name g_tool_tip_container\" style=\"margin: 0px; padding: 0px; border: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: inherit; font-family: inherit; vertical-align: baseline;\">Тип горелки</div>\r\n</div>\r\n&nbsp;\r\n<div class=\"b-good-specs__content\" style=\"margin: 0px; padding: 0px; border: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: 20px; font-family: inherit; font-size: 14px; vertical-align: top; display: inline-block; width: 555.016px; color: #323232;\">Одноступенчатая</div>\r\n</div>\r\n<div class=\"b-good-specs__item row2\" style=\"margin: 0px -8px; padding: 4px 8px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-stretch: inherit; line-height: inherit; font-family: robotoregular, helvetica, sans-serif; font-size: 0px; vertical-align: baseline; box-sizing: border-box; cursor: pointer; color: #333333; background-color: #ffffff;\">\r\n<div class=\"b-good-specs__head\" style=\"margin: 0px; padding: 0px; border: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: 20px; font-family: inherit; font-size: 14px; vertical-align: top; width: 325.969px; color: #989898; display: inline-block;\">\r\n<div class=\"name g_tool_tip_container\" style=\"margin: 0px; padding: 0px; border: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: inherit; font-family: inherit; vertical-align: baseline;\">Мощность горелки</div>\r\n</div>\r\n&nbsp;\r\n<div class=\"b-good-specs__content\" style=\"margin: 0px; padding: 0px; border: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: 20px; font-family: inherit; font-size: 14px; vertical-align: top; display: inline-block; width: 555.016px; color: #323232;\">от 45 до 85 кВт</div>\r\n</div>\r\n<div class=\"b-good-specs__item row2\" style=\"margin: 0px -8px; padding: 4px 8px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-stretch: inherit; line-height: inherit; font-family: robotoregular, helvetica, sans-serif; font-size: 0px; vertical-align: baseline; box-sizing: border-box; cursor: pointer; color: #333333; background-color: #ffffff;\">\r\n<div class=\"b-good-specs__head\" style=\"margin: 0px; padding: 0px; border: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: 20px; font-family: inherit; font-size: 14px; vertical-align: top; width: 325.969px; color: #989898; display: inline-block;\">\r\n<div class=\"name g_tool_tip_container\" style=\"margin: 0px; padding: 0px; border: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: inherit; font-family: inherit; vertical-align: baseline;\">Электропитание</div>\r\n</div>\r\n&nbsp;\r\n<div class=\"b-good-specs__content\" style=\"margin: 0px; padding: 0px; border: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: 20px; font-family: inherit; font-size: 14px; vertical-align: top; display: inline-block; width: 555.016px; color: #323232;\">230 В</div>\r\n</div>\r\n<div class=\"b-good-specs__item row2\" style=\"margin: 0px -8px; padding: 4px 8px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-stretch: inherit; line-height: inherit; font-family: robotoregular, helvetica, sans-serif; font-size: 0px; vertical-align: baseline; box-sizing: border-box; cursor: pointer; color: #333333; background-color: #ffffff;\">\r\n<div class=\"b-good-specs__head\" style=\"margin: 0px; padding: 0px; border: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: 20px; font-family: inherit; font-size: 14px; vertical-align: top; width: 325.969px; color: #989898; display: inline-block;\">\r\n<div class=\"name g_tool_tip_container\" style=\"margin: 0px; padding: 0px; border: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: inherit; font-family: inherit; vertical-align: baseline;\">Электродвигатель&nbsp;<a class=\"b-good-specs__icon ttc-show_link\" style=\"margin: 0px 0px 0px 5px; padding: 0px; cursor: pointer; border: 1px solid #b1b1b1; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: 12px; font-family: inherit; vertical-align: baseline; display: inline-block; width: 12px; height: 12px; text-align: center; border-radius: 50%; position: relative; top: -2px; color: #b1b1b1 !important; font-size: 10px !important;\" title=\"Описание\" data-text=\" \">?</a></div>\r\n</div>\r\n&nbsp;\r\n<div class=\"b-good-specs__content\" style=\"margin: 0px; padding: 0px; border: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: 20px; font-family: inherit; font-size: 14px; vertical-align: top; display: inline-block; width: 555.016px; color: #323232;\">85 Bт</div>\r\n</div>\r\n<div class=\"b-good-specs__item row2\" style=\"margin: 0px -8px; padding: 4px 8px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-stretch: inherit; line-height: inherit; font-family: robotoregular, helvetica, sans-serif; font-size: 0px; vertical-align: baseline; box-sizing: border-box; cursor: pointer; color: #333333; background-color: #ffffff;\">\r\n<div class=\"b-good-specs__head\" style=\"margin: 0px; padding: 0px; border: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: 20px; font-family: inherit; font-size: 14px; vertical-align: top; width: 325.969px; color: #989898; display: inline-block;\">\r\n<div class=\"name g_tool_tip_container\" style=\"margin: 0px; padding: 0px; border: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: inherit; font-family: inherit; vertical-align: baseline;\">Потребляемая электрическая мощность</div>\r\n</div>\r\n&nbsp;\r\n<div class=\"b-good-specs__content\" style=\"margin: 0px; padding: 0px; border: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: 20px; font-family: inherit; font-size: 14px; vertical-align: top; display: inline-block; width: 555.016px; color: #323232;\">195 W</div>\r\n</div>\r\n<div class=\"b-good-specs__item row2\" style=\"margin: 0px -8px; padding: 4px 8px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-stretch: inherit; line-height: inherit; font-family: robotoregular, helvetica, sans-serif; font-size: 0px; vertical-align: baseline; box-sizing: border-box; cursor: pointer; color: #333333; background-color: #ffffff;\">\r\n<div class=\"b-good-specs__head\" style=\"margin: 0px; padding: 0px; border: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: 20px; font-family: inherit; font-size: 14px; vertical-align: top; width: 325.969px; color: #989898; display: inline-block;\">\r\n<div class=\"name g_tool_tip_container\" style=\"margin: 0px; padding: 0px; border: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: inherit; font-family: inherit; vertical-align: baseline;\">Класс пылевлагозащиты</div>\r\n</div>\r\n&nbsp;\r\n<div class=\"b-good-specs__content\" style=\"margin: 0px; padding: 0px; border: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: 20px; font-family: inherit; font-size: 14px; vertical-align: top; display: inline-block; width: 555.016px; color: #323232;\">IP 21</div>\r\n</div>\r\n<div class=\"b-good-specs__item row2\" style=\"margin: 0px -8px; padding: 4px 8px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-stretch: inherit; line-height: inherit; font-family: robotoregular, helvetica, sans-serif; font-size: 0px; vertical-align: baseline; box-sizing: border-box; cursor: pointer; color: #333333; background-color: #ffffff;\">\r\n<div class=\"b-good-specs__head\" style=\"margin: 0px; padding: 0px; border: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: 20px; font-family: inherit; font-size: 14px; vertical-align: top; width: 325.969px; color: #989898; display: inline-block;\">\r\n<div class=\"name g_tool_tip_container\" style=\"margin: 0px; padding: 0px; border: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: inherit; font-family: inherit; vertical-align: baseline;\">Уровень шума</div>\r\n</div>\r\n&nbsp;\r\n<div class=\"b-good-specs__content\" style=\"margin: 0px; padding: 0px; border: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: 20px; font-family: inherit; font-size: 14px; vertical-align: top; display: inline-block; width: 555.016px; color: #323232;\">74 дБ</div>\r\n</div>\r\n<div class=\"b-good-specs__item row2\" style=\"margin: 0px -8px; padding: 4px 8px; border: 0px; font-variant-numeric: inherit; font-variant-east-asian: inherit; font-stretch: inherit; line-height: inherit; font-family: robotoregular, helvetica, sans-serif; font-size: 0px; vertical-align: baseline; box-sizing: border-box; cursor: pointer; color: #333333; background-color: #ffffff;\">\r\n<div class=\"b-good-specs__head\" style=\"margin: 0px; padding: 0px; border: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: 20px; font-family: inherit; font-size: 14px; vertical-align: top; width: 325.969px; color: #989898; display: inline-block;\">\r\n<div class=\"name g_tool_tip_container\" style=\"margin: 0px; padding: 0px; border: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: inherit; font-family: inherit; vertical-align: baseline;\">Рабочая температура</div>\r\n</div>\r\n&nbsp;\r\n<div class=\"b-good-specs__content\" style=\"margin: 0px; padding: 0px; border: 0px; font-style: inherit; font-variant: inherit; font-weight: inherit; font-stretch: inherit; line-height: 20px; font-family: inherit; font-size: 14px; vertical-align: top; display: inline-block; width: 555.016px; color: #323232;\">от -10 до +60 &deg;C</div>\r\n</div>', NULL, '/images/products/elco-vg-185-6604.jpg', 0, 0, 0, 0, '2020-12-23 06:01:28', '2020-12-23 06:01:28');

-- --------------------------------------------------------

--
-- Структура таблицы `rights`
--

CREATE TABLE `rights` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `rights`
--

INSERT INTO `rights` (`id`, `name`, `description`) VALUES
(1, 'Добавить товар', ''),
(2, 'Изменить товар', ''),
(3, 'Удалить товар', ''),
(4, 'Добавить категорию', ''),
(5, 'Изменить категорию', ''),
(6, 'Удалить категорию', ''),
(7, 'Просмотреть все заказы', ''),
(8, 'Изменить статус заказа', '');

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`) VALUES
(1, 'Администратор', ''),
(2, 'Пользователь', ''),
(3, 'Менеджер', '');

-- --------------------------------------------------------

--
-- Структура таблицы `role_rights`
--

CREATE TABLE `role_rights` (
  `id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `right_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `role_rights`
--

INSERT INTO `role_rights` (`id`, `role_id`, `right_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 7),
(8, 1, 8),
(9, 3, 7),
(10, 3, 8);

-- --------------------------------------------------------

--
-- Структура таблицы `subcategories`
--

CREATE TABLE `subcategories` (
  `id` int(10) UNSIGNED NOT NULL,
  `parent_category_id` int(10) UNSIGNED NOT NULL,
  `child_category_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `subcategories`
--

INSERT INTO `subcategories` (`id`, `parent_category_id`, `child_category_id`) VALUES
(1, 2, 3),
(2, 2, 4),
(3, 2, 7);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '$2y$10$1hfOSbh2EURZ5TYOCfgkHeN.1BZR.ChgYQ6R0H2oVOM2OSAQtGdVS',
  `role_id` int(10) UNSIGNED NOT NULL DEFAULT '2',
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `third_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `role_id`, `first_name`, `last_name`, `third_name`, `phone`, `created_at`, `updated_at`) VALUES
(1, 'sales@ankas.ru', '$2y$10$1hfOSbh2EURZ5TYOCfgkHeN.1BZR.ChgYQ6R0H2oVOM2OSAQtGdVS', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(2, '12345dan123456@gmail.com', '$2y$10$gtwXEh3jzGU6r6x42ckYEOO1ytOaEUjOY81RjY8GfPFVmN3TjvsgO', 2, 'Данила', 'Шилов', 'Анатольевич', '89080914337', NULL, NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `cys`
--
ALTER TABLE `cys`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `orders_products`
--
ALTER TABLE `orders_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_products_product_id_foreign` (`product_id`),
  ADD KEY `orders_products_order_id_foreign` (`order_id`);

--
-- Индексы таблицы `products_categories`
--
ALTER TABLE `products_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_categories_products_detail_id_foreign` (`products_detail_id`),
  ADD KEY `products_categories_category_id_foreign` (`category_id`);

--
-- Индексы таблицы `products_details`
--
ALTER TABLE `products_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_details_vendor_code_unique` (`vendor_code`),
  ADD KEY `products_details_brand_id_foreign` (`brand_id`),
  ADD KEY `products_details_cy_id_foreign` (`cy_id`);

--
-- Индексы таблицы `rights`
--
ALTER TABLE `rights`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rights_name_unique` (`name`);

--
-- Индексы таблицы `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `role_rights`
--
ALTER TABLE `role_rights`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_rights_role_id_foreign` (`role_id`),
  ADD KEY `role_rights_right_id_foreign` (`right_id`);

--
-- Индексы таблицы `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subcategories_parent_category_id_foreign` (`parent_category_id`),
  ADD KEY `subcategories_child_category_id_foreign` (`child_category_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `cys`
--
ALTER TABLE `cys`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `orders_products`
--
ALTER TABLE `orders_products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `products_categories`
--
ALTER TABLE `products_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `products_details`
--
ALTER TABLE `products_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `rights`
--
ALTER TABLE `rights`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `role_rights`
--
ALTER TABLE `role_rights`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `orders_products`
--
ALTER TABLE `orders_products`
  ADD CONSTRAINT `orders_products_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products_details` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `products_categories`
--
ALTER TABLE `products_categories`
  ADD CONSTRAINT `products_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_categories_products_detail_id_foreign` FOREIGN KEY (`products_detail_id`) REFERENCES `products_details` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `products_details`
--
ALTER TABLE `products_details`
  ADD CONSTRAINT `products_details_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_details_cy_id_foreign` FOREIGN KEY (`cy_id`) REFERENCES `cys` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `role_rights`
--
ALTER TABLE `role_rights`
  ADD CONSTRAINT `role_rights_right_id_foreign` FOREIGN KEY (`right_id`) REFERENCES `rights` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_rights_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `subcategories`
--
ALTER TABLE `subcategories`
  ADD CONSTRAINT `subcategories_child_category_id_foreign` FOREIGN KEY (`child_category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `subcategories_parent_category_id_foreign` FOREIGN KEY (`parent_category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
