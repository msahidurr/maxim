-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 09, 2018 at 08:57 AM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 7.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `maxpronewerp`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `getBookinAndBuyerDeatils` (IN `booking_order_id` VARCHAR(247))  NO SQL
SELECT mb.erp_code,mb.item_code,mb.item_price,mb.item_description, mb.orderDate,mb.orderNo,mb.shipmentDate,mb.poCatNo,mb.others_color ,GROUP_CONCAT(mb.item_size) as itemSize,GROUP_CONCAT(mb.gmts_color) as gmtsColor,GROUP_CONCAT(mb.item_quantity) as quantity, mbd.* from mxp_booking mb INNER JOIN mxp_bookingBuyer_details mbd on(mbd.booking_order_id = mb.booking_order_id) WHERE mb.booking_order_id = booking_order_id GROUP BY mb.item_code ORDER BY id ASC$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getProductSizeQuantity` (IN `product_code` VARCHAR(247), IN `order_id` VARCHAR(247))  select mo.item_code,mo.oss,mo.style, mp.unit_price, mp.weight_qty, mp.erp_code, GROUP_CONCAT(mo.item_size) as item_size, GROUP_CONCAT(mo.quantity) as quantity, mo.order_id from mxp_order mo INNER JOIN mxp_product mp on(mo.item_code = mp.product_code) where mo.item_code = product_code AND mo.order_id = order_id GROUP by mo.item_code$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getProductSizeQuantitybyPrice` (IN `booking_order_id` VARCHAR(100))  NO SQL
SELECT mb.erp_code,mb.item_code,mb.item_price,mb.orderDate,mb.orderNo,mb.shipmentDate,mb.poCatNo,mb.others_color ,GROUP_CONCAT(mb.item_size) as itemSize,GROUP_CONCAT(mb.gmts_color) as gmtsColor,GROUP_CONCAT(mb.item_quantity) as quantity, mbd.* from mxp_booking mb INNER JOIN mxp_bookingBuyer_details mbd on(mbd.booking_order_id = mb.booking_order_id) INNER JOIN mxp_product mp on( mb.item_code = mp.product_code) WHERE mb.booking_order_id = booking_order_id GROUP BY mb.item_code$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getProductSizeQuantityWithConcat` (IN `product_code` VARCHAR(247))  NO SQL
SELECT mp.erp_code,mp.unit_price,mp.product_name,mp.product_description ,GROUP_CONCAT(mps.product_size order by product_size) as size,GROUP_CONCAT(mgs.color_name) as color   FROM mxp_product mp 
LEFT JOIN mxp_productSize mps ON (mps.product_code = mp.product_code)
LEFT JOIN mxp_gmts_color mgs ON (mgs.item_code = mps.product_code)
WHERE mp.product_code = product_code GROUP BY mps.product_code, mgs.item_code$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_all_role_list_by_group_id` (IN `grp_id` INT(11))  SELECT GROUP_CONCAT(DISTINCT(c.name)) as c_name,r.* FROM mxp_role r join mxp_companies c on(c.id=r.company_id)
where c.group_id=grp_id GROUP BY r.cm_group_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_all_translation` ()  SELECT tr.*,tk.translation_key FROM mxp_translation_keys tk INNER JOIN mxp_translations tr ON(tr.translation_key_id=tk.translation_key_id)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_all_translation_with_limit` (IN `startedAt` INT(11), IN `limits` INT(11))  SELECT tr.*,tk.translation_key, ml.lan_name FROM mxp_translation_keys tk INNER JOIN
 mxp_translations tr ON(tr.translation_key_id=tk.translation_key_id) 
 INNER JOIN mxp_languages ml ON(ml.lan_code=tr.lan_code)order by tk.translation_key_id desc limit startedAt,limits$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_child_menu_list` (IN `p_parent_menu_id` INT(11), IN `role_id` INT(11), IN `comp_id` INT(11))  if(comp_id !='') then
SELECT m.* FROM mxp_user_role_menu rm inner JOIN mxp_menu m ON(m.menu_id=rm.menu_id) WHERE rm.role_id=role_id AND rm.company_id=comp_id AND m.parent_id=p_parent_menu_id order by m.order_id ASC;
else
SELECT m.* FROM mxp_user_role_menu rm inner JOIN mxp_menu m ON(m.menu_id=rm.menu_id) WHERE rm.role_id=role_id AND m.parent_id=p_parent_menu_id order by m.order_id ASC;
end if$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_companies_by_group_id` (IN `grp_id` INT(11))  select * from mxp_companies where group_id=grp_id and is_active = 1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_permission` (IN `role_id` INT(11), IN `route` VARCHAR(120), IN `comp_id` INT(11))  if(comp_id !='')then
SELECT COUNT(*) as cnt FROM mxp_user_role_menu rm inner JOIN mxp_menu m ON(m.menu_id=rm.menu_id) WHERE m.route_name=route AND rm.role_id=role_id AND rm.company_id=comp_id;
else
SELECT COUNT(*) as cnt FROM mxp_user_role_menu rm inner JOIN mxp_menu m ON(m.menu_id=rm.menu_id) WHERE m.route_name=route AND rm.role_id=role_id ;
end if$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_roles_by_company_id` (IN `cmpny_id` INT(11), IN `cm_grp_id` INT(11))  SELECT rl.name as roleName, cm.name as companyName, cm.id as company_id, rl.cm_group_id, rl.is_active FROM mxp_role rl INNER JOIN mxp_companies cm ON(rl.company_id=cm.id) where cm.group_id = `cmpny_id` and rl.cm_group_id = `cm_grp_id`$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_searched_trans_key` (IN `_key` VARCHAR(255))  SELECT distinct(tk.translation_key),tk.translation_key_id, tk.is_active FROM mxp_translation_keys tk
 inner join mxp_translations tr on(tk.translation_key_id = tr.translation_key_id)
 WHERE tk.translation_key LIKE CONCAT('%', _key , '%')$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_translations_by_key_id` (IN `key_id` INT)  select translation_id, translation, lan_code from mxp_translations
 where translation_key_id= `key_id` and is_active = 1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_translations_by_locale` (IN `locale_code` VARCHAR(255))  SELECT tr.translation,tk.translation_key FROM mxp_translation_keys tk INNER JOIN mxp_translations tr ON(tr.translation_key_id=tk.translation_key_id)
WHERE tr.lan_code=locale_code$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_translation_by_key_id` (IN `tr_key_id` INT(11))  SELECT tr.translation,tk.translation_key,tk.translation_key_id,tk.is_active,ln.lan_name FROM mxp_translation_keys tk INNER JOIN mxp_translations tr ON(tr.translation_key_id=tk.translation_key_id)
INNER JOIN mxp_languages ln ON(ln.lan_code=tr.lan_code)
WHERE tr.translation_key_id=tr_key_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_user_menu_by_role` (IN `role_id` INT(11), IN `comp_id` INT(11))  if(comp_id !='') then
SELECT m.* FROM mxp_user_role_menu rm inner JOIN mxp_menu m ON(m.menu_id=rm.menu_id) WHERE rm.role_id=role_id AND rm.company_id=comp_id;
else
SELECT m.* FROM mxp_user_role_menu rm inner JOIN mxp_menu m ON(m.menu_id=rm.menu_id) WHERE rm.role_id=role_id;
end if$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_100000_create_password_resets_table', 1),
(2, '2018_01_11_075242_create_languages_table', 1),
(3, '2018_01_12_081050_create_role_table', 1),
(4, '2018_01_12_084141_create_menu_table', 1),
(5, '2018_01_12_122539_add_column_to_mxp_role', 2),
(6, '2018_01_13_100521_create_mxp_users_table', 2),
(7, '2018_01_15_064427_create_mxp_translation_keys', 3),
(8, '2018_01_15_064518_create_mxp_translations', 3),
(9, '2018_01_15_073009_create_mxp_user_role_menu', 4),
(10, '2018_01_15_081551_update_language_table', 5),
(11, '2018_01_15_130417_create_mxp_trans_keys_table', 6),
(12, '2018_01_15_081806_create_mxp_users_table', 7),
(13, '2018_01_15_095153_add_type_column_after_last_name_of_mxp_users', 7),
(14, '2018_01_16_055331_create_mxp_translation_keys_table', 8),
(15, '2018_01_16_060235_create_mxp_translation_keys_table', 9),
(16, '2018_01_16_064618_update_mxp_translation_keys_table', 10),
(17, '2018_01_22_104053_update_mxp_users_table', 11),
(18, '2018_01_26_060729_add_companyId_to_roles_and_role_menus', 11),
(19, '2018_01_25_130557_create_companies_table', 12),
(20, '2018_01_26_054823_drop_company_column_from_mxp_users_table', 12),
(21, '2018_01_26_071103_add_column_to_mxp_user_table', 13),
(22, '2018_01_26_075012_create_store_pro_get_company_by_group_id', 14),
(24, '2018_01_27_130037_create_store_pro_get_roles_by_company_id', 16),
(25, '2018_01_30_081529_update_mxp_role', 17),
(26, '2018_01_30_093232_create_store_pro_get_all_companies_of_same_name_by_group_id', 17),
(27, '2018_01_30_105605_update_mxp_translations', 17),
(46, '2018_02_06_100944_create_mxp_taxvats_table', 18),
(47, '2018_02_06_103251_create_mxp_taxvat_cals_table', 18),
(48, '2018_04_04_053741_create_mxp_accounts_heads_table', 19),
(49, '2018_04_05_093858_create_store_procedure_get_all_acc_class', 20),
(50, '2018_04_05_123858_create_mxp_acc_head_sub_classes_table', 20),
(51, '2018_04_06_060320_create_store_pro_get_all_sub_class_name', 20),
(52, '2018_04_06_070031_create_store_pro_get_all_chart_of_accounts', 20),
(53, '2018_04_05_125024_create_mxp_chart_of_acc_heads_table', 21),
(78, '2018_01_27_110718_update_mxp_role_table', 22),
(79, '2018_04_10_112500_create_party_product_tablee', 22),
(82, '2018_04_12_130615_create_page_footer_table', 22),
(83, '2018_04_12_130725_create_page_report_footer_table', 22),
(84, '2018_04_16_070741_create_brand_table', 22),
(89, '2018_04_16_095019_create_productSize_table', 23),
(143, '2018_04_11_065758_create_party_table', 24),
(145, '2018_04_23_111907_create_excel_emport_table', 24),
(146, '2018_04_25_164456_create_bill_table', 24),
(147, '2018_05_04_081744_create_challan_table', 24),
(148, '2018_05_04_121456_create_multiple_challan_table', 24),
(150, '2018_05_25_071327_create_order_input_new_table', 24),
(152, '2018_06_06_065708_create_gmts_color_table', 24),
(166, '2018_04_12_130515_create_page_header_table', 25),
(221, '2018_06_21_064357_create_pi_format_data_table_info', 27),
(239, '2018_06_01_090140_create_new_booking_list_table', 28),
(240, '2018_06_08_045630_booking_buyer_deatils_table_create', 28),
(241, '2018_06_23_094814_create_booking_challan_table', 28),
(244, '2018_05_07_060534_create_mxp_ipo_table', 29),
(245, '2018_06_23_131029_create_booking_multiple_challan_table', 29);

-- --------------------------------------------------------

--
-- Table structure for table `mxp_accounts_heads`
--

CREATE TABLE `mxp_accounts_heads` (
  `accounts_heads_id` int(10) UNSIGNED NOT NULL,
  `head_name_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_deleted` tinyint(4) NOT NULL,
  `is_active` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mxp_accounts_heads`
--

INSERT INTO `mxp_accounts_heads` (`accounts_heads_id`, `head_name_type`, `account_code`, `company_id`, `group_id`, `user_id`, `is_deleted`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Assets', '1010-01', 0, 1, 1, 0, 1, '2018-04-07 03:00:21', '2018-04-07 03:00:56'),
(2, 'Expenses', '1010-02', 0, 1, 1, 0, 1, '2018-04-07 03:01:33', '2018-04-07 03:01:33'),
(3, 'Liability', '1010-03', 0, 1, 1, 0, 1, '2018-04-07 03:02:11', '2018-04-07 03:02:11'),
(4, 'Income', '1010-04', 0, 1, 1, 0, 1, '2018-04-07 03:02:25', '2018-04-07 03:02:25');

-- --------------------------------------------------------

--
-- Table structure for table `mxp_accounts_sub_heads`
--

CREATE TABLE `mxp_accounts_sub_heads` (
  `accounts_sub_heads_id` int(10) UNSIGNED NOT NULL,
  `accounts_heads_id` int(11) UNSIGNED NOT NULL,
  `sub_head` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_deleted` tinyint(4) NOT NULL,
  `is_active` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mxp_accounts_sub_heads`
--

INSERT INTO `mxp_accounts_sub_heads` (`accounts_sub_heads_id`, `accounts_heads_id`, `sub_head`, `company_id`, `group_id`, `user_id`, `is_deleted`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 'current asset', 0, 1, 1, 1, 1, '2018-04-05 06:24:28', '2018-04-07 03:03:12'),
(2, 1, 'Current Assets', 0, 1, 1, 0, 1, '2018-04-07 03:03:25', '2018-04-07 03:03:25'),
(3, 1, 'Non Current Assets', 0, 1, 1, 0, 1, '2018-04-07 03:05:40', '2018-04-07 03:05:40'),
(4, 3, 'Current Liabilities', 0, 1, 1, 0, 1, '2018-04-07 03:06:03', '2018-04-07 03:06:03'),
(5, 2, 'Ordinary Expense', 0, 1, 1, 0, 1, '2018-04-07 03:06:37', '2018-04-07 03:06:37'),
(6, 4, 'Ordinary Income', 0, 1, 1, 0, 1, '2018-04-07 03:07:09', '2018-04-07 03:07:09');

-- --------------------------------------------------------

--
-- Table structure for table `mxp_acc_classes`
--

CREATE TABLE `mxp_acc_classes` (
  `mxp_acc_classes_id` int(10) UNSIGNED NOT NULL,
  `head_class_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `accounts_heads_id` int(10) UNSIGNED NOT NULL,
  `accounts_sub_heads_id` int(10) UNSIGNED NOT NULL,
  `company_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_deleted` tinyint(4) NOT NULL,
  `is_active` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mxp_acc_classes`
--

INSERT INTO `mxp_acc_classes` (`mxp_acc_classes_id`, `head_class_name`, `accounts_heads_id`, `accounts_sub_heads_id`, `company_id`, `group_id`, `user_id`, `is_deleted`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Cash & cash equivalents', 1, 2, 0, 1, 1, 0, 1, '2018-04-07 03:07:51', '2018-04-07 03:07:51'),
(2, 'Receivables', 1, 2, 0, 1, 1, 0, 1, '2018-04-07 03:08:23', '2018-04-07 03:08:23'),
(3, 'Dircet Expenses', 2, 5, 0, 1, 1, 0, 1, '2018-04-07 03:08:55', '2018-04-07 03:08:55'),
(4, 'Income from Services', 4, 6, 0, 1, 1, 0, 1, '2018-04-07 03:09:23', '2018-04-07 03:09:23');

-- --------------------------------------------------------

--
-- Table structure for table `mxp_booking`
--

CREATE TABLE `mxp_booking` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `booking_order_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `erp_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_size` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_quantity` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `matarial` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gmts_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `others_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orderDate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orderNo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipmentDate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `poCatNo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mxp_booking`
--

INSERT INTO `mxp_booking` (`id`, `user_id`, `booking_order_id`, `erp_code`, `item_code`, `item_size`, `item_description`, `item_quantity`, `item_price`, `matarial`, `gmts_color`, `others_color`, `orderDate`, `orderNo`, `shipmentDate`, `poCatNo`, `created_at`, `updated_at`) VALUES
(1, 49, 'INVO-23062018-Mi-0001', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU L CN 175/96A', '2L.ML-TA.001', '1234', '0.002', NULL, NULL, '0', NULL, NULL, NULL, NULL, '2018-06-23 06:18:01', '2018-06-23 06:18:01'),
(2, 49, 'INVO-23062018-Mi-0001', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU M CN 170/92M', '2L.ML-TA.001', '1234', '0.002', NULL, NULL, '0', NULL, NULL, NULL, NULL, '2018-06-23 06:18:01', '2018-06-23 06:18:01'),
(3, 49, 'INVO-23062018-Mi-0001', 'X-C0-C-32-E', 'CTO00029 ( ZK011A ) : PLASTIC TOGGOLE BEADS', 'ANTIQUE BRASS', '0', '2', '0.3', NULL, 'SEAL GREY', 'CORD COLOR', NULL, NULL, NULL, NULL, '2018-06-23 06:18:01', '2018-06-23 06:18:01'),
(4, 49, 'INVO-23062018-Mi-0001', 'X-C0-C-32-E', 'CTO00029 ( ZK011A ) : PLASTIC TOGGOLE BEADS', 'DARK STEEL', '0', '2', '0.3', NULL, 'SEAL GREY', 'CORD COLOR', NULL, NULL, NULL, NULL, '2018-06-23 06:18:01', '2018-06-23 06:18:01'),
(5, 49, 'INVO-23062018-CSF-0002', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU L CN 175/96A', '2L.ML-TA.001', '1234', '0.002', NULL, NULL, '0', '2018-06-23', '111111', '2018-06-28', '12', '2018-06-23 07:20:39', '2018-06-23 07:20:39'),
(6, 49, 'INVO-23062018-CSF-0002', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU M CN 170/92M', '2L.ML-TA.001', '1234', '0.002', NULL, NULL, '0', '2018-06-23', '111111', '2018-06-28', '12', '2018-06-23 07:20:39', '2018-06-23 07:20:39'),
(7, 49, 'INVO-23062018-CSF-0002', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU S CN 165/88A', '2L.ML-TA.001', '1234', '0.002', NULL, NULL, '0', '2018-06-23', '111111', '2018-06-28', '12', '2018-06-23 07:20:39', '2018-06-23 07:20:39'),
(8, 49, 'INVO-23062018-CSF-0002', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU XS CN 160/84A', '2L.ML-TA.001', '1234', '0.002', NULL, NULL, '0', '2018-06-23', '111111', '2018-06-28', '12', '2018-06-23 07:20:39', '2018-06-23 07:20:39'),
(9, 49, 'INVO-23062018-CSF-0002', '22322', 'CSO04369 - REGETTA GREAT', '4XL', '0', '122', '0.6', NULL, 'DARK KHAKI', '0', '2018-06-23', '111111', '2018-06-28', '12', '2018-06-23 07:20:39', '2018-06-23 07:20:39'),
(10, 49, 'INVO-23062018-CSF-0002', '22322', 'CSO04369 - REGETTA GREAT', '5XL', '0', '122', '0.6', NULL, 'DARK KHAKI', '0', '2018-06-23', '111111', '2018-06-28', '12', '2018-06-23 07:20:39', '2018-06-23 07:20:39'),
(11, 49, 'INVO-23062018-CSF-0002', '22322', 'CSO04369 - REGETTA GREAT', 'm', '0', '122', '0.6', NULL, 'DARK KHAKI', '0', '2018-06-23', '111111', '2018-06-28', '12', '2018-06-23 07:20:39', '2018-06-23 07:20:39'),
(12, 49, 'INVO-23062018-CSF-0003', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU L CN 175/96A', '2L.ML-TA.001', '122', '0.002', NULL, NULL, '0', '2018-06-23', '111111', '2018-06-28', '12', '2018-06-23 07:24:55', '2018-06-23 07:24:55'),
(13, 49, 'INVO-23062018-CSF-0003', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU L CN 175/96A', '2L.ML-TA.001', '1225', '0.002', NULL, NULL, '0', '2018-06-23', '111111', '2018-06-28', '12', '2018-06-23 07:24:55', '2018-06-23 07:24:55'),
(14, 49, 'INVO-23062018-CSF-0003', '22322', 'CSO04369 - REGETTA GREAT', '4XL', '0', '1234', '0.6', NULL, 'NAVY', '0', '2018-06-23', '111111', '2018-06-28', '12', '2018-06-23 07:24:55', '2018-06-23 07:24:55'),
(15, 49, 'INVO-23062018-CSF-0003', '22322', 'CSO04369 - REGETTA GREAT', '5XL', '0', '1234', '0.6', NULL, 'NAVY', '0', '2018-06-23', '111111', '2018-06-28', '12', '2018-06-23 07:24:55', '2018-06-23 07:24:55'),
(16, 49, 'INVO-25062018-CSF-0004', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU L CN 175/96A', '2L.ML-TA.001', '1234', '0.002', NULL, NULL, '0', '2018-06-19', '111111', '2018-06-27', '111111', '2018-06-24 22:53:31', '2018-06-24 22:53:31'),
(17, 49, 'INVO-25062018-CSF-0004', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU M CN 170/92M', '2L.ML-TA.001', '1234', '0.002', NULL, NULL, '0', '2018-06-19', '111111', '2018-06-27', '111111', '2018-06-24 22:53:31', '2018-06-24 22:53:31'),
(18, 49, 'INVO-25062018-ACL-0005', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU L CN 175/96A', '2L.ML-TA.001', '2', '0.002', NULL, NULL, '0', '2018-06-28', '111111', '2018-06-27', '111111', '2018-06-24 22:57:41', '2018-06-24 22:57:41'),
(19, 49, 'INVO-25062018-ACL-0005', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU M CN 170/92M', '2L.ML-TA.001', '2', '0.002', NULL, NULL, '0', '2018-06-28', '111111', '2018-06-27', '111111', '2018-06-24 22:57:41', '2018-06-24 22:57:41'),
(20, 49, 'INVO-25062018-ACL-0005', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU S CN 165/88A', '2L.ML-TA.001', '2', '0.002', NULL, NULL, '0', '2018-06-28', '111111', '2018-06-27', '111111', '2018-06-24 22:57:41', '2018-06-24 22:57:41'),
(21, 49, 'INVO-25062018-ACL-0005', '04-0ST2LMLTA001X-01', '2L.ML-TA.001', 'EF M CN 170/92M', 'aaa', '1234', '.08', NULL, NULL, '0', '2018-06-28', '111111', '2018-06-27', '111111', '2018-06-24 22:57:41', '2018-06-24 22:57:41'),
(22, 49, 'INVO-25062018-ACL-0005', '04-0ST2LMLTA001X-01', '2L.ML-TA.001', 'EF L CN 175/96A', 'aaa', '1234', '.08', NULL, NULL, '0', '2018-06-28', '111111', '2018-06-27', '111111', '2018-06-24 22:57:41', '2018-06-24 22:57:41'),
(23, 49, 'INVO-25062018-ACL-0005', '04-0ST2LMLTA001X-01', '2L.ML-TA.001', 'EF S CN 165/88A', 'aaa', '1234', '.08', NULL, NULL, '0', '2018-06-28', '111111', '2018-06-27', '111111', '2018-06-24 22:57:41', '2018-06-24 22:57:41'),
(24, 49, 'INVO-05072018-Mi-0006', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU L CN 175/96A', '2L.ML-TA.001', '120', '0.002', NULL, NULL, '0', NULL, NULL, NULL, NULL, '2018-07-05 02:54:44', '2018-07-05 02:54:44'),
(25, 49, 'INVO-05072018-Mi-0006', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU M CN 170/92M', '2L.ML-TA.001', '130', '0.002', NULL, NULL, '0', NULL, NULL, NULL, NULL, '2018-07-05 02:54:44', '2018-07-05 02:54:44'),
(26, 49, 'INVO-05072018-Mi-0006', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU S CN 165/88A', '2L.ML-TA.001', '140', '0.002', NULL, NULL, '0', NULL, NULL, NULL, NULL, '2018-07-05 02:54:44', '2018-07-05 02:54:44'),
(27, 49, 'INVO-05072018-CSF-0007', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU L CN 175/96A', '2L.ML-TA.001', '110', '0.002', NULL, NULL, '0', NULL, NULL, NULL, NULL, '2018-07-05 03:29:47', '2018-07-05 03:29:47'),
(28, 49, 'INVO-05072018-CSF-0007', '04-0ST2LMLTA001X-01', '2L.ML-TA.001', 'EF L CN 175/96A', 'aaa', '130', '.08', NULL, NULL, '0', NULL, NULL, NULL, NULL, '2018-07-05 03:29:47', '2018-07-05 03:29:47'),
(29, 49, 'INVO-05072018-CD-0008', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU L CN 175/96A', '2L.ML-TA.001', '110', '0.002', NULL, NULL, '0', '2018-07-05', '1', '2018-07-05', '12', '2018-07-05 06:03:07', '2018-07-05 06:03:07'),
(30, 49, 'INVO-05072018-CD-0008', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU M CN 170/92M', '2L.ML-TA.001', '120', '0.002', NULL, NULL, '0', '2018-07-05', '1', '2018-07-05', '12', '2018-07-05 06:03:07', '2018-07-05 06:03:07'),
(31, 49, 'INVO-05072018-CD-0008', '04-0ST2LMLTA001X-01', '2L.ML-TA.001', 'EF L CN 175/96A', 'aaa', '130', '.08', NULL, NULL, '0', '2018-07-05', '1', '2018-07-05', '12', '2018-07-05 06:03:07', '2018-07-05 06:03:07'),
(32, 49, 'INVO-05072018-CD-0008', '04-0ST2LMLTA001X-01', '2L.ML-TA.001', 'EF M CN 170/92M', 'aaa', '140', '.08', NULL, NULL, '0', '2018-07-05', '1', '2018-07-05', '12', '2018-07-05 06:03:07', '2018-07-05 06:03:07'),
(33, 49, 'INVO-05072018-CSF-0009', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU L CN 175/96A', '2L.ML-TA.001', '100', '0.002', NULL, NULL, '0', NULL, NULL, NULL, NULL, '2018-07-05 06:12:08', '2018-07-05 06:12:08'),
(34, 49, 'INVO-05072018-CSF-0009', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU M CN 170/92M', '2L.ML-TA.001', '100', '0.002', NULL, NULL, '0', NULL, NULL, NULL, NULL, '2018-07-05 06:12:08', '2018-07-05 06:12:08'),
(35, 49, 'INVO-05072018-CSF-0009', '04-0ST2LMLTA001X-01', '2L.ML-TA.001', 'EF L CN 175/96A', 'aaa', '100', '.08', NULL, NULL, '0', NULL, NULL, NULL, NULL, '2018-07-05 06:12:08', '2018-07-05 06:12:08'),
(36, 49, 'INVO-05072018-CSF-0009', '04-0ST2LMLTA001X-01', '2L.ML-TA.001', 'EF M CN 170/92M', 'aaa', '100', '.08', NULL, NULL, '0', NULL, NULL, NULL, NULL, '2018-07-05 06:12:08', '2018-07-05 06:12:08'),
(37, 49, 'INVO-05072018-CSF-0010', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU L CN 175/96A', '2L.ML-TA.001', '100', '0.002', NULL, NULL, '0', NULL, NULL, NULL, NULL, '2018-07-05 06:13:53', '2018-07-05 06:13:53'),
(38, 49, 'INVO-05072018-CSF-0010', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU M CN 170/92M', '2L.ML-TA.001', '100', '0.002', NULL, NULL, '0', NULL, NULL, NULL, NULL, '2018-07-05 06:13:54', '2018-07-05 06:13:54'),
(39, 49, 'INVO-05072018-CSF-0010', '04-0ST2LMLTA001X-01', '2L.ML-TA.001', 'EF L CN 175/96A', 'aaa', '100', '.08', NULL, NULL, '0', NULL, NULL, NULL, NULL, '2018-07-05 06:13:54', '2018-07-05 06:13:54'),
(40, 49, 'INVO-05072018-CSF-0010', '04-0ST2LMLTA001X-01', '2L.ML-TA.001', 'EF M CN 170/92M', 'aaa', '100', '.08', NULL, NULL, '0', NULL, NULL, NULL, NULL, '2018-07-05 06:13:54', '2018-07-05 06:13:54'),
(41, 49, 'INVO-05072018-CSF-0011', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU M CN 170/92M', '2L.ML-TA.001', '100', '0.002', NULL, NULL, '0', NULL, NULL, NULL, NULL, '2018-07-05 06:16:12', '2018-07-05 06:16:12'),
(42, 49, 'INVO-05072018-CSF-0011', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU M CN 170/92M', '2L.ML-TA.001', '100', '0.002', NULL, NULL, '0', NULL, NULL, NULL, NULL, '2018-07-05 06:16:12', '2018-07-05 06:16:12'),
(43, 49, 'INVO-05072018-CSF-0012', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU L CN 175/96A', '2L.ML-TA.001', '100', '0.002', NULL, NULL, '0', NULL, NULL, NULL, NULL, '2018-07-05 06:17:55', '2018-07-05 06:17:55'),
(44, 49, 'INVO-05072018-CSF-0012', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU M CN 170/92M', '2L.ML-TA.001', '100', '0.002', NULL, NULL, '0', NULL, NULL, NULL, NULL, '2018-07-05 06:17:55', '2018-07-05 06:17:55'),
(45, 49, 'INVO-05072018-CSF-0012', '04-0ST2LMLTA001X-01', '2L.ML-TA.001', 'EF L CN 175/96A', 'aaa', '100', '.08', NULL, NULL, '0', NULL, NULL, NULL, NULL, '2018-07-05 06:17:55', '2018-07-05 06:17:55'),
(46, 49, 'INVO-05072018-CSF-0012', '04-0ST2LMLTA001X-01', '2L.ML-TA.001', 'EF M CN 170/92M', 'aaa', '100', '.08', NULL, NULL, '0', NULL, NULL, NULL, NULL, '2018-07-05 06:17:55', '2018-07-05 06:17:55'),
(47, 49, 'INVO-06072018-CSF-0013', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU L CN 175/96A', '2L.ML-TA.001', '110', '0.002', NULL, NULL, '0', NULL, NULL, NULL, NULL, '2018-07-06 06:18:07', '2018-07-06 06:18:07'),
(48, 49, 'INVO-06072018-CSF-0013', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU M CN 170/92M', '2L.ML-TA.001', '120', '0.002', NULL, NULL, '0', NULL, NULL, NULL, NULL, '2018-07-06 06:18:07', '2018-07-06 06:18:07'),
(49, 49, 'INVO-06072018-CSF-0013', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU S CN 165/88A', '2L.ML-TA.001', '130', '0.002', NULL, NULL, '0', NULL, NULL, NULL, NULL, '2018-07-06 06:18:08', '2018-07-06 06:18:08'),
(50, 49, 'INVO-07072018-Mi-0014', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU L CN 175/96A', '2L.ML-TA.001', '110', '0.002', NULL, NULL, '0', '2018-07-11', '01', '2018-07-25', '111', '2018-07-06 22:23:46', '2018-07-06 22:23:46'),
(51, 49, 'INVO-07072018-Mi-0014', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU M CN 170/92M', '2L.ML-TA.001', '110', '0.002', NULL, NULL, '0', '2018-07-11', '01', '2018-07-25', '111', '2018-07-06 22:23:46', '2018-07-06 22:23:46'),
(52, 49, 'INVO-07072018-Mi-0014', '04-0ST2LMLTA001X-01', '2L.ML-TA.001', 'EF L CN 175/96A', 'aaa', '130', '.08', NULL, NULL, '0', '2018-07-11', '01', '2018-07-25', '111', '2018-07-06 22:23:46', '2018-07-06 22:23:46'),
(53, 49, 'INVO-07072018-Mi-0014', '04-0ST2LMLTA001X-01', '2L.ML-TA.001', 'EF M CN 170/92M', 'aaa', '140', '.08', NULL, NULL, '0', '2018-07-11', '01', '2018-07-25', '111', '2018-07-06 22:23:46', '2018-07-06 22:23:46'),
(54, 49, 'INVO-07072018-CSF-0015', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU L CN 175/96A', '2L.ML-TA.001', '2000', '0.08', NULL, NULL, '0', '2018-07-07', '008', '2018-07-24', '7655434', '2018-07-06 23:52:02', '2018-07-06 23:52:02'),
(55, 49, 'INVO-07072018-CSF-0015', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU M CN 170/92M', '2L.ML-TA.001', '600', '0.0802', NULL, NULL, '0', '2018-07-07', '008', '2018-07-24', '7655434', '2018-07-06 23:52:02', '2018-07-06 23:52:02'),
(56, 49, 'INVO-07072018-CSF-0015', '04-0ST2LMLTA001X-01', '2L.ML-TA.001', 'EF L CN 175/96A', 'aaa', '300', '.08', NULL, NULL, '0', '2018-07-07', '008', '2018-07-24', '7655434', '2018-07-06 23:52:02', '2018-07-06 23:52:02');

-- --------------------------------------------------------

--
-- Table structure for table `mxp_bookingBuyer_details`
--

CREATE TABLE `mxp_bookingBuyer_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `booking_order_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Company_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `C_sort_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `buyer_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_part1_invoice` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_part2_invoice` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attention_invoice` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_invoice` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone_invoice` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fax_invoice` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_part1_delivery` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_part2_delivery` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attention_delivery` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_delivery` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone_delivery` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fax_delivery` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mxp_bookingBuyer_details`
--

INSERT INTO `mxp_bookingBuyer_details` (`id`, `user_id`, `booking_order_id`, `Company_name`, `C_sort_name`, `buyer_name`, `address_part1_invoice`, `address_part2_invoice`, `attention_invoice`, `mobile_invoice`, `telephone_invoice`, `fax_invoice`, `address_part1_delivery`, `address_part2_delivery`, `attention_delivery`, `mobile_delivery`, `telephone_delivery`, `fax_delivery`, `created_at`, `updated_at`) VALUES
(1, 49, 'INVO-23062018-Mi-0001', 'Maxpro It', 'Mi', 'Ostin\'s', 'Section -1', 'Section-2', 'md Hanif', '01792828282', NULL, NULL, 'Section-1', 'Section-2', 'Md hanif', '01792828282', NULL, NULL, '2018-06-23 06:18:01', '2018-06-23 06:18:01'),
(2, 49, 'INVO-23062018-CSF-0002', 'CSF GARMENTS (PVT.) LTD', 'CSF', 'REGATTA', 'DELUXE HOUSE #3 (3rd-6th floor)', '209/227, KULGAON, BALUCHARA, CHITTAGAON-4214,BANGLADESH', 'Mr. Mohibul', '+8801984464601', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-06-23 07:20:39', '2018-06-23 07:20:39'),
(3, 49, 'INVO-23062018-CSF-0003', 'CSF GARMENTS (PVT.) LTD', 'CSF', 'REGATTA', 'DELUXE HOUSE #3 (3rd-6th floor)', '209/227, KULGAON, BALUCHARA, CHITTAGAON-4214,BANGLADESH', 'Mr. Mohibul', '+8801984464601', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-06-23 07:24:55', '2018-06-23 07:24:55'),
(4, 49, 'INVO-25062018-CSF-0004', 'CSF GARMENTS (PVT.) LTD', 'CSF', 'REGATTA', 'DELUXE HOUSE #3 (3rd-6th floor)', '209/227, KULGAON, BALUCHARA, CHITTAGAON-4214,BANGLADESH', 'Mr. Mohibul', '+8801984464601', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-06-24 22:53:31', '2018-06-24 22:53:31'),
(5, 49, 'INVO-25062018-ACL-0005', 'ALPHA CLOTHING LTD', 'ACL', 'REGATTA', 'Section -1', 'Section- 2', 'aaaa', '01685-696806', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-06-24 22:57:41', '2018-06-24 22:57:41'),
(6, 49, 'INVO-05072018-Mi-0006', 'Maxpro It', 'Mi', 'Ostin\'s', 'Section -1', 'Section-2', 'md Hanif', '01792828282', NULL, NULL, 'Section-1', 'Section-2', 'Md hanif', '01792828282', NULL, NULL, '2018-07-05 02:54:43', '2018-07-05 02:54:43'),
(7, 49, 'INVO-05072018-CSF-0007', 'CSF GARMENTS (PVT.) LTD', 'CSF', 'REGATTA', 'DELUXE HOUSE #3 (3rd-6th floor)', '209/227, KULGAON, BALUCHARA, CHITTAGAON-4214,BANGLADESH', 'Mr. Mohibul', '+8801984464601', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-07-05 03:29:46', '2018-07-05 03:29:46'),
(8, 49, 'INVO-05072018-CD-0008', 'Capital Design', 'CD', 'CRAGHOPPERS', 'UNI GEARS LTD', 'BADSHAMIAH SCHOOL ROAD KHAILKUR,BOARD BAZAR GAZIPUR-1702,BANGLADESH PHONE: +88 02 9293760', 'MR. SHEHAB', '+88-09610864328', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-07-05 06:03:07', '2018-07-05 06:03:07'),
(9, 49, 'INVO-05072018-CSF-0009', 'CSF GARMENTS (PVT.) LTD', 'CSF', 'REGATTA', 'DELUXE HOUSE #3 (3rd-6th floor)', '209/227, KULGAON, BALUCHARA, CHITTAGAON-4214,BANGLADESH', 'Mr. Mohibul', '+8801984464601', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-07-05 06:12:08', '2018-07-05 06:12:08'),
(10, 49, 'INVO-05072018-CSF-0010', 'CSF GARMENTS (PVT.) LTD', 'CSF', 'REGATTA', 'DELUXE HOUSE #3 (3rd-6th floor)', '209/227, KULGAON, BALUCHARA, CHITTAGAON-4214,BANGLADESH', 'Mr. Mohibul', '+8801984464601', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-07-05 06:13:53', '2018-07-05 06:13:53'),
(11, 49, 'INVO-05072018-CSF-0011', 'CSF GARMENTS (PVT.) LTD', 'CSF', 'REGATTA', 'DELUXE HOUSE #3 (3rd-6th floor)', '209/227, KULGAON, BALUCHARA, CHITTAGAON-4214,BANGLADESH', 'Mr. Mohibul', '+8801984464601', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-07-05 06:16:12', '2018-07-05 06:16:12'),
(12, 49, 'INVO-05072018-CSF-0012', 'CSF GARMENTS (PVT.) LTD', 'CSF', 'REGATTA', 'DELUXE HOUSE #3 (3rd-6th floor)', '209/227, KULGAON, BALUCHARA, CHITTAGAON-4214,BANGLADESH', 'Mr. Mohibul', '+8801984464601', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-07-05 06:17:54', '2018-07-05 06:17:54'),
(13, 49, 'INVO-06072018-CSF-0013', 'CSF GARMENTS (PVT.) LTD', 'CSF', 'REGATTA', 'DELUXE HOUSE #3 (3rd-6th floor)', '209/227, KULGAON, BALUCHARA, CHITTAGAON-4214,BANGLADESH', 'Mr. Mohibul', '+8801984464601', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-07-06 06:18:07', '2018-07-06 06:18:07'),
(14, 49, 'INVO-07072018-Mi-0014', 'Maxpro It', 'Mi', 'Ostin\'s', 'Section -1', 'Section-2', 'md Hanif', '01792828282', NULL, NULL, 'Section-1', 'Section-2', 'Md hanif', '01792828282', NULL, NULL, '2018-07-06 22:23:46', '2018-07-06 22:23:46'),
(15, 49, 'INVO-07072018-CSF-0015', 'CSF GARMENTS (PVT.) LTD', 'CSF', 'REGATTA', 'DELUXE HOUSE #3 (3rd-6th floor)', '209/227, KULGAON, BALUCHARA, CHITTAGAON-4214,BANGLADESH', 'Mr. Mohibul', '+8801984464601', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-07-06 23:52:01', '2018-07-06 23:52:01');

-- --------------------------------------------------------

--
-- Table structure for table `mxp_booking_challan`
--

CREATE TABLE `mxp_booking_challan` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `booking_order_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `erp_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_size` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_quantity` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `matarial` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gmts_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `others_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orderDate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orderNo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipmentDate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `poCatNo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mxp_booking_challan`
--

INSERT INTO `mxp_booking_challan` (`id`, `user_id`, `booking_order_id`, `erp_code`, `item_code`, `item_size`, `item_description`, `item_quantity`, `item_price`, `matarial`, `gmts_color`, `others_color`, `orderDate`, `orderNo`, `shipmentDate`, `poCatNo`, `created_at`, `updated_at`) VALUES
(1, 49, 'INVO-23062018-Mi-0001', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU L CN 175/96A,EU M CN 170/92M', '2L.ML-TA.001', '0,0', '0.002', NULL, NULL, '0', NULL, NULL, NULL, NULL, '2018-06-23 06:18:01', '2018-06-23 06:51:09'),
(2, 49, 'INVO-23062018-Mi-0001', 'X-C0-C-32-E', 'CTO00029 ( ZK011A ) : PLASTIC TOGGOLE BEADS', 'ANTIQUE BRASS,DARK STEEL', '0', '0,0', '0.3', NULL, 'SEAL GREY,SEAL GREY', 'CORD COLOR', NULL, NULL, NULL, NULL, '2018-06-23 06:18:01', '2018-06-23 06:51:09'),
(3, 49, 'INVO-23062018-CSF-0002', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU L CN 175/96A,EU M CN 170/92M,EU S CN 165/88A,EU XS CN 160/84A', '2L.ML-TA.001', '0,0,0,0', '0.002', NULL, NULL, '0', '2018-06-23', '111111', '2018-06-28', '12', '2018-06-23 07:20:39', '2018-06-23 07:21:55'),
(4, 49, 'INVO-23062018-CSF-0002', '22322', 'CSO04369 - REGETTA GREAT', '4XL,5XL,m', '0', '0,0,0', '0.6', NULL, 'DARK KHAKI,DARK KHAKI,DARK KHAKI', '0', '2018-06-23', '111111', '2018-06-28', '12', '2018-06-23 07:20:40', '2018-06-23 07:21:32'),
(5, 49, 'INVO-23062018-CSF-0003', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU L CN 175/96A,EU L CN 175/96A', '2L.ML-TA.001', '0', '0.002', NULL, NULL, '0', '2018-06-23', '111111', '2018-06-28', '12', '2018-06-23 07:24:55', '2018-06-23 07:25:26'),
(6, 49, 'INVO-23062018-CSF-0003', '22322', 'CSO04369 - REGETTA GREAT', '4XL,5XL', '0', '0,0', '0.6', NULL, 'NAVY,NAVY', '0', '2018-06-23', '111111', '2018-06-28', '12', '2018-06-23 07:24:56', '2018-06-24 22:48:55'),
(7, 49, 'INVO-25062018-CSF-0004', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU L CN 175/96A,EU M CN 170/92M', '2L.ML-TA.001', '0,0', '0.002', NULL, NULL, '0', '2018-06-19', '111111', '2018-06-27', '111111', '2018-06-24 22:53:31', '2018-06-24 22:54:41'),
(8, 49, 'INVO-25062018-ACL-0005', '04-0ST2LMLTA001X-01', '2L.ML-TA.001', 'EF M CN 170/92M,EF L CN 175/96A,EF S CN 165/88A', 'aaa', '1234,1234,1234', '.08', NULL, NULL, '0', '2018-06-28', '111111', '2018-06-27', '111111', '2018-06-24 22:57:41', '2018-06-24 22:57:41'),
(9, 49, 'INVO-25062018-ACL-0005', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU L CN 175/96A,EU M CN 170/92M,EU S CN 165/88A', '2L.ML-TA.001', '2,2,2', '0.002', NULL, NULL, '0', '2018-06-28', '111111', '2018-06-27', '111111', '2018-06-24 22:57:42', '2018-06-24 22:57:42'),
(10, 49, 'INVO-05072018-Mi-0006', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU L CN 175/96A,EU M CN 170/92M,EU S CN 165/88A', '2L.ML-TA.001', '120,130,140', '0.002', NULL, NULL, '0', NULL, NULL, NULL, NULL, '2018-07-05 02:54:44', '2018-07-05 02:54:44'),
(11, 49, 'INVO-05072018-CSF-0007', '04-0ST2LMLTA001X-01', '2L.ML-TA.001', 'EF L CN 175/96A', 'aaa', '-68', '.08', NULL, NULL, '0', NULL, NULL, NULL, NULL, '2018-07-05 03:29:47', '2018-07-05 06:01:34'),
(12, 49, 'INVO-05072018-CSF-0007', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU L CN 175/96A', '2L.ML-TA.001', '-77', '0.002', NULL, NULL, '0', NULL, NULL, NULL, NULL, '2018-07-05 03:29:47', '2018-07-05 06:01:34'),
(13, 49, 'INVO-05072018-CD-0008', '04-0ST2LMLTA001X-01', '2L.ML-TA.001', 'EF L CN 175/96A,EF M CN 170/92M', 'aaa', '60,70', '.08', NULL, NULL, '0', '2018-07-05', '1', '2018-07-05', '12', '2018-07-05 06:03:07', '2018-07-05 06:10:56'),
(14, 49, 'INVO-05072018-CD-0008', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU L CN 175/96A,EU M CN 170/92M', '2L.ML-TA.001', '40,50', '0.002', NULL, NULL, '0', '2018-07-05', '1', '2018-07-05', '12', '2018-07-05 06:03:07', '2018-07-05 06:10:56'),
(15, 49, 'INVO-05072018-CSF-0009', '04-0ST2LMLTA001X-01', '2L.ML-TA.001', 'EF L CN 175/96A,EF M CN 170/92M', 'aaa', '90,0', '.08', NULL, NULL, '0', NULL, NULL, NULL, NULL, '2018-07-05 06:12:08', '2018-07-05 06:12:46'),
(16, 49, 'INVO-05072018-CSF-0009', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU L CN 175/96A,EU M CN 170/92M', '2L.ML-TA.001', '0,0', '0.002', NULL, NULL, '0', NULL, NULL, NULL, NULL, '2018-07-05 06:12:08', '2018-07-05 06:12:46'),
(17, 49, 'INVO-05072018-CSF-0010', '04-0ST2LMLTA001X-01', '2L.ML-TA.001', 'EF L CN 175/96A,EF M CN 170/92M', 'aaa', '90,0', '.08', NULL, NULL, '0', NULL, NULL, NULL, NULL, '2018-07-05 06:13:54', '2018-07-05 06:14:32'),
(18, 49, 'INVO-05072018-CSF-0010', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU L CN 175/96A,EU M CN 170/92M', '2L.ML-TA.001', '0,0', '0.002', NULL, NULL, '0', NULL, NULL, NULL, NULL, '2018-07-05 06:13:54', '2018-07-05 06:14:32'),
(19, 49, 'INVO-05072018-CSF-0011', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU M CN 170/92M,EU M CN 170/92M', '2L.ML-TA.001', '100,100', '0.002', NULL, NULL, '0', NULL, NULL, NULL, NULL, '2018-07-05 06:16:12', '2018-07-05 06:16:12'),
(20, 49, 'INVO-05072018-CSF-0012', '04-0ST2LMLTA001X-01', '2L.ML-TA.001', 'EF L CN 175/96A,EF M CN 170/92M', 'aaa', '90,0', '.08', NULL, NULL, '0', NULL, NULL, NULL, NULL, '2018-07-05 06:17:55', '2018-07-05 06:18:27'),
(21, 49, 'INVO-05072018-CSF-0012', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU L CN 175/96A,EU M CN 170/92M', '2L.ML-TA.001', '0,0', '0.002', NULL, NULL, '0', NULL, NULL, NULL, NULL, '2018-07-05 06:17:55', '2018-07-05 06:18:27'),
(22, 49, 'INVO-06072018-CSF-0013', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU L CN 175/96A,EU M CN 170/92M,EU S CN 165/88A', '2L.ML-TA.001', '90,90,0', '0.002', NULL, NULL, '0', NULL, NULL, NULL, NULL, '2018-07-06 06:18:08', '2018-07-06 06:19:35'),
(23, 49, 'INVO-07072018-Mi-0014', '04-0ST2LMLTA001X-01', '2L.ML-TA.001', 'EF L CN 175/96A,EF M CN 170/92M', 'aaa', '120,130', '.08', NULL, NULL, '0', '2018-07-11', '01', '2018-07-25', '111', '2018-07-06 22:23:46', '2018-07-06 22:25:40'),
(24, 49, 'INVO-07072018-Mi-0014', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU L CN 175/96A,EU M CN 170/92M', '2L.ML-TA.001', '100,0', '0.002', NULL, NULL, '0', '2018-07-11', '01', '2018-07-25', '111', '2018-07-06 22:23:46', '2018-07-06 22:25:40'),
(25, 49, 'INVO-07072018-CSF-0015', '04-0ST2LMLTA001X-01', '2L.ML-TA.001', 'EF L CN 175/96A', 'aaa', '100', '.08', NULL, NULL, '0', '2018-07-07', '008', '2018-07-24', '7655434', '2018-07-06 23:52:02', '2018-07-07 00:06:10'),
(26, 49, 'INVO-07072018-CSF-0015', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU L CN 175/96A,EU M CN 170/92M', '2L.ML-TA.001', '1000,300', '0.08', NULL, NULL, '0', '2018-07-07', '008', '2018-07-24', '7655434', '2018-07-06 23:52:02', '2018-07-07 00:06:10');

-- --------------------------------------------------------

--
-- Table structure for table `mxp_booking_multipleChallan`
--

CREATE TABLE `mxp_booking_multipleChallan` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `challan_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `booking_order_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `erp_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_size` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_quantity` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `matarial` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gmts_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `others_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orderDate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orderNo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipmentDate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `poCatNo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mxp_booking_multipleChallan`
--

INSERT INTO `mxp_booking_multipleChallan` (`id`, `user_id`, `challan_id`, `booking_order_id`, `erp_code`, `item_code`, `item_size`, `item_description`, `item_quantity`, `item_price`, `matarial`, `gmts_color`, `others_color`, `orderDate`, `orderNo`, `shipmentDate`, `poCatNo`, `status`, `created_at`, `updated_at`) VALUES
(1, 49, 'M-CHA-05072018-CSF-0001', 'INVO-05072018-CSF-0007', '04-0ST2LMLTA001X-01', '2L.ML-TA.001', 'EF L CN 175/96A', 'aaa', '-57', '.08', NULL, NULL, '0', NULL, NULL, NULL, NULL, 'create', '2018-07-05 06:01:07', '2018-07-05 06:01:07'),
(2, 49, 'M-CHA-05072018-CSF-0001', 'INVO-05072018-CSF-0007', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU L CN 175/96A', '2L.ML-TA.001', '-66', '0.002', NULL, NULL, '0', NULL, NULL, NULL, NULL, 'create', '2018-07-05 06:01:07', '2018-07-05 06:01:07'),
(3, 49, 'M-CHA-05072018-CSF-0003', 'INVO-05072018-CSF-0007', '04-0ST2LMLTA001X-01', '2L.ML-TA.001', 'EF L CN 175/96A', 'aaa', '-68', '.08', NULL, NULL, '0', NULL, NULL, NULL, NULL, 'create', '2018-07-05 06:01:34', '2018-07-05 06:01:34'),
(4, 49, 'M-CHA-05072018-CSF-0003', 'INVO-05072018-CSF-0007', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU L CN 175/96A', '2L.ML-TA.001', '-77', '0.002', NULL, NULL, '0', NULL, NULL, NULL, NULL, 'create', '2018-07-05 06:01:34', '2018-07-05 06:01:34'),
(5, 49, 'M-CHA-05072018-CD-0005', 'INVO-05072018-CD-0008', '04-0ST2LMLTA001X-01', '2L.ML-TA.001', 'EF L CN 175/96A,EF M CN 170/92M', 'aaa', '120,130', '.08', NULL, NULL, '0', '2018-07-05', '1', '2018-07-05', '12', 'create', '2018-07-05 06:03:56', '2018-07-05 06:03:56'),
(6, 49, 'M-CHA-05072018-CD-0005', 'INVO-05072018-CD-0008', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU L CN 175/96A,EU M CN 170/92M', '2L.ML-TA.001', '100,110', '0.002', NULL, NULL, '0', '2018-07-05', '1', '2018-07-05', '12', 'create', '2018-07-05 06:03:56', '2018-07-05 06:03:56'),
(7, 49, 'M-CHA-05072018-CD-0007', 'INVO-05072018-CD-0008', '04-0ST2LMLTA001X-01', '2L.ML-TA.001', 'EF L CN 175/96A,EF M CN 170/92M', 'aaa', '110,120', '.08', NULL, NULL, '0', '2018-07-05', '1', '2018-07-05', '12', 'create', '2018-07-05 06:04:45', '2018-07-05 06:04:45'),
(8, 49, 'M-CHA-05072018-CD-0007', 'INVO-05072018-CD-0008', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU L CN 175/96A,EU M CN 170/92M', '2L.ML-TA.001', '90,100', '0.002', NULL, NULL, '0', '2018-07-05', '1', '2018-07-05', '12', 'create', '2018-07-05 06:04:45', '2018-07-05 06:04:45'),
(9, 49, 'M-CHA-05072018-CD-0009', 'INVO-05072018-CD-0008', '04-0ST2LMLTA001X-01', '2L.ML-TA.001', 'EF L CN 175/96A,EF M CN 170/92M', 'aaa', '100,110', '.08', NULL, NULL, '0', '2018-07-05', '1', '2018-07-05', '12', 'create', '2018-07-05 06:05:52', '2018-07-05 06:05:52'),
(10, 49, 'M-CHA-05072018-CD-0009', 'INVO-05072018-CD-0008', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU L CN 175/96A,EU M CN 170/92M', '2L.ML-TA.001', '80,90', '0.002', NULL, NULL, '0', '2018-07-05', '1', '2018-07-05', '12', 'create', '2018-07-05 06:05:52', '2018-07-05 06:05:52'),
(11, 49, 'M-CHA-05072018-CD-0011', 'INVO-05072018-CD-0008', '04-0ST2LMLTA001X-01', '2L.ML-TA.001', 'EF L CN 175/96A,EF M CN 170/92M', 'aaa', '90,100', '.08', NULL, NULL, '0', '2018-07-05', '1', '2018-07-05', '12', 'create', '2018-07-05 06:06:03', '2018-07-05 06:06:03'),
(12, 49, 'M-CHA-05072018-CD-0011', 'INVO-05072018-CD-0008', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU L CN 175/96A,EU M CN 170/92M', '2L.ML-TA.001', '70,80', '0.002', NULL, NULL, '0', '2018-07-05', '1', '2018-07-05', '12', 'create', '2018-07-05 06:06:03', '2018-07-05 06:06:03'),
(13, 49, 'M-CHA-05072018-CD-0013', 'INVO-05072018-CD-0008', '04-0ST2LMLTA001X-01', '2L.ML-TA.001', 'EF L CN 175/96A,EF M CN 170/92M', 'aaa', '80,90', '.08', NULL, NULL, '0', '2018-07-05', '1', '2018-07-05', '12', 'create', '2018-07-05 06:07:28', '2018-07-05 06:07:28'),
(14, 49, 'M-CHA-05072018-CD-0013', 'INVO-05072018-CD-0008', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU L CN 175/96A,EU M CN 170/92M', '2L.ML-TA.001', '60,70', '0.002', NULL, NULL, '0', '2018-07-05', '1', '2018-07-05', '12', 'create', '2018-07-05 06:07:28', '2018-07-05 06:07:28'),
(15, 49, 'M-CHA-05072018-CD-0015', 'INVO-05072018-CD-0008', '04-0ST2LMLTA001X-01', '2L.ML-TA.001', 'EF L CN 175/96A,EF M CN 170/92M', 'aaa', '70,80', '.08', NULL, NULL, '0', '2018-07-05', '1', '2018-07-05', '12', 'create', '2018-07-05 06:09:16', '2018-07-05 06:09:16'),
(16, 49, 'M-CHA-05072018-CD-0015', 'INVO-05072018-CD-0008', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU L CN 175/96A,EU M CN 170/92M', '2L.ML-TA.001', '50,60', '0.002', NULL, NULL, '0', '2018-07-05', '1', '2018-07-05', '12', 'create', '2018-07-05 06:09:16', '2018-07-05 06:09:16'),
(17, 49, 'M-CHA-05072018-CD-0017', 'INVO-05072018-CD-0008', '04-0ST2LMLTA001X-01', '2L.ML-TA.001', 'EF L CN 175/96A,EF M CN 170/92M', 'aaa', '60,70', '.08', NULL, NULL, '0', '2018-07-05', '1', '2018-07-05', '12', 'create', '2018-07-05 06:10:56', '2018-07-05 06:10:56'),
(18, 49, 'M-CHA-05072018-CD-0017', 'INVO-05072018-CD-0008', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU L CN 175/96A,EU M CN 170/92M', '2L.ML-TA.001', '40,50', '0.002', NULL, NULL, '0', '2018-07-05', '1', '2018-07-05', '12', 'create', '2018-07-05 06:10:56', '2018-07-05 06:10:56'),
(19, 49, 'M-CHA-05072018-CSF-0019', 'INVO-05072018-CSF-0009', '04-0ST2LMLTA001X-01', '2L.ML-TA.001', 'EF L CN 175/96A,EF M CN 170/92M', 'aaa', '90,0', '.08', NULL, NULL, '0', NULL, NULL, NULL, NULL, 'create', '2018-07-05 06:12:46', '2018-07-05 06:12:46'),
(20, 49, 'M-CHA-05072018-CSF-0019', 'INVO-05072018-CSF-0009', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU L CN 175/96A,EU M CN 170/92M', '2L.ML-TA.001', '0,0', '0.002', NULL, NULL, '0', NULL, NULL, NULL, NULL, 'create', '2018-07-05 06:12:46', '2018-07-05 06:12:46'),
(21, 49, 'M-CHA-05072018-CSF-0021', 'INVO-05072018-CSF-0010', '04-0ST2LMLTA001X-01', '2L.ML-TA.001', 'EF L CN 175/96A,EF M CN 170/92M', 'aaa', '90,0', '.08', NULL, NULL, '0', NULL, NULL, NULL, NULL, 'create', '2018-07-05 06:14:32', '2018-07-05 06:14:32'),
(22, 49, 'M-CHA-05072018-CSF-0021', 'INVO-05072018-CSF-0010', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU L CN 175/96A,EU M CN 170/92M', '2L.ML-TA.001', '0,0', '0.002', NULL, NULL, '0', NULL, NULL, NULL, NULL, 'create', '2018-07-05 06:14:32', '2018-07-05 06:14:32');

-- --------------------------------------------------------

--
-- Table structure for table `mxp_brand`
--

CREATE TABLE `mxp_brand` (
  `brand_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `brand_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mxp_brand`
--

INSERT INTO `mxp_brand` (`brand_id`, `user_id`, `brand_name`, `action`, `status`, `created_at`, `updated_at`) VALUES
(1, 49, 'dhamaka', 'update', '1', '2018-04-17 00:15:44', '2018-05-10 06:07:04'),
(2, 49, 'abc', 'create', '1', '2018-04-17 01:31:00', '2018-04-17 01:31:00'),
(3, 49, 'apex', 'create', '1', '2018-04-17 02:24:38', '2018-04-17 02:24:38'),
(4, 49, 'branda', 'create', '1', '2018-07-06 23:18:03', '2018-07-06 23:18:03');

-- --------------------------------------------------------

--
-- Table structure for table `mxp_challan`
--

CREATE TABLE `mxp_challan` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bill_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `erp_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `oss` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `style` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_size` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit_price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `party_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_buyer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attention_invoice` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_invoice` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `count_challan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mxp_companies`
--

CREATE TABLE `mxp_companies` (
  `id` int(10) UNSIGNED NOT NULL,
  `group_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mxp_companies`
--

INSERT INTO `mxp_companies` (`id`, `group_id`, `name`, `description`, `address`, `phone`, `is_active`, `created_at`, `updated_at`) VALUES
(10, 1, 'Company-A', 'dsddsd', 'sddsd', '01673197093', 1, '2018-01-29 06:39:19', '2018-01-29 06:39:19'),
(11, 2, 'Company-B', 'dsddsd', 'sddsd', '0167319709377', 1, '2018-01-29 06:39:31', '2018-01-29 06:39:31'),
(13, 38, 'sumit power-23-A', 'fhfhdhf', '445fdfdf', '01674898148', 1, '2018-01-31 02:57:49', '2018-01-31 02:57:49'),
(14, 38, 'sumit power-23-B', 'fhfhdhf', '445fdfdf', '01674898148', 1, '2018-01-31 02:57:58', '2018-01-31 02:57:58'),
(15, 42, 'New Company', 'Descrip', 'dhaka', '1234567890', 1, '2018-02-09 02:06:45', '2018-02-09 02:06:45'),
(16, 42, 'New Company 2', 'description', 'Bangladesh', '1234567', 1, '2018-02-09 02:09:04', '2018-02-09 02:09:04'),
(17, 49, '1st Company', 'rgfdegfwe', 'xsdsds', '01792755683', 1, '2018-05-03 02:39:47', '2018-05-19 01:19:23'),
(18, 49, 'S Companuyq', 'sfg sfds sdf s', 'sdvgdf dfg dfg dfg', '1234567890', 1, '2018-05-10 00:06:27', '2018-05-10 00:06:27');

-- --------------------------------------------------------

--
-- Table structure for table `mxp_gmts_color`
--

CREATE TABLE `mxp_gmts_color` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `action` int(6) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mxp_gmts_color`
--

INSERT INTO `mxp_gmts_color` (`id`, `user_id`, `item_code`, `color_name`, `status`, `created_at`, `updated_at`, `action`) VALUES
(3, 49, 'CSO04369 - REGETTA GREAT', 'SEAL GREY', 'update', '2018-06-06 01:48:42', '2018-06-08 01:54:43', 1),
(7, 49, 'CSO04369 - REGETTA GREAT', 'NAVY', 'update', '2018-06-06 02:37:43', '2018-06-08 01:54:55', 1),
(11, 49, 'CSO04369 - REGETTA GREAT', 'DARK KHAKI', 'create', '2018-06-08 01:55:14', '2018-06-08 01:55:14', 1),
(12, 49, 'CSO04369 - REGETTA GREAT', 'BLACK (BLACK BACKING)', 'create', '2018-06-08 01:55:50', '2018-06-08 01:55:50', 1),
(13, 49, 'CTO00029 ( ZK011A ) : PLASTIC TOGGOLE BEADS', 'SEAL GREY', 'update', '2018-06-08 02:03:52', '2018-06-08 02:04:02', 1),
(14, 49, 'CTO00029 ( ZK011A ) : PLASTIC TOGGOLE BEADS', 'NAVY', 'create', '2018-06-08 02:04:16', '2018-06-08 02:04:16', 1),
(15, 49, 'CTO00029 ( ZK011A ) : PLASTIC TOGGOLE BEADS', 'DARK KHAKI', 'create', '2018-06-08 02:04:29', '2018-06-08 02:04:29', 1),
(16, 49, 'CTO00029 ( ZK011A ) : PLASTIC TOGGOLE BEADS', 'BLACK (BLACK BACKING)', 'create', '2018-06-08 02:04:37', '2018-06-08 02:04:37', 1),
(17, 49, '5250', 'gren', 'create', '2018-06-13 02:06:04', '2018-06-13 02:06:04', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mxp_header`
--

CREATE TABLE `mxp_header` (
  `header_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `header_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `header_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `header_fontsize` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `header_fontstyle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `header_colour` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo_allignment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cell_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attention` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mxp_header`
--

INSERT INTO `mxp_header` (`header_id`, `user_id`, `header_type`, `header_title`, `header_fontsize`, `header_fontstyle`, `header_colour`, `logo`, `logo_allignment`, `address1`, `address2`, `address3`, `cell_number`, `attention`, `status`, `action`, `created_at`, `updated_at`) VALUES
(1, 49, '11', 'Maxim Label & packaging Bangladesh Pvt; Ltd', 'x-small', 'normal', 'blue', NULL, NULL, 'Mollik Tower, 11F', '13-14 Zoo Road Mirpur-1', 'Dhaka, Bangladesh', '0170000001', 'MS.Rita / Mr.Shovon', '', 'create', '2018-06-10 23:07:08', '2018-06-10 23:07:08'),
(2, 49, '12', 'Maxim Label & packaging Bangladesh Pvt; Ltd', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 'create', '2018-06-22 23:33:41', '2018-06-22 23:33:41');

-- --------------------------------------------------------

--
-- Table structure for table `mxp_ipo`
--

CREATE TABLE `mxp_ipo` (
  `id` int(10) UNSIGNED NOT NULL,
  `ipo_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `booking_order_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `initial_increase` int(11) NOT NULL,
  `erp_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_size` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_quantity` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `matarial` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gmts_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `others_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orderDate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orderNo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipmentDate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `poCatNo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mxp_ipo`
--

INSERT INTO `mxp_ipo` (`id`, `ipo_id`, `user_id`, `booking_order_id`, `initial_increase`, `erp_code`, `item_code`, `item_size`, `item_description`, `item_quantity`, `item_price`, `matarial`, `gmts_color`, `others_color`, `orderDate`, `orderNo`, `shipmentDate`, `poCatNo`, `status`, `created_at`, `updated_at`) VALUES
(1, 'RGA06072018-ACL-02-36153', 49, 'INVO-05072018-CSF-0012', 2, '04-0ST2LMLTA001X-01', '2L.ML-TA.001', 'EF L CN 175/96A,EF M CN 170/92M', 'aaa', '100,100', '.08', NULL, NULL, '0', NULL, NULL, NULL, NULL, 'create', '2018-07-06 06:10:05', '2018-07-06 06:10:05'),
(2, 'RGA06072018-ACL-02-36153', 49, 'INVO-05072018-CSF-0012', 2, '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU L CN 175/96A,EU M CN 170/92M', '2L.ML-TA.001', '100,100', '0.002', NULL, NULL, '0', NULL, NULL, NULL, NULL, 'create', '2018-07-06 06:10:05', '2018-07-06 06:10:05'),
(3, 'RGA06072018-ACL-02-33774', 49, 'INVO-06072018-CSF-0013', 3, '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU L CN 175/96A,EU M CN 170/92M,EU S CN 165/88A', '2L.ML-TA.001', '110,120,130', '0.002', NULL, NULL, '0', NULL, NULL, NULL, NULL, 'create', '2018-07-06 06:20:23', '2018-07-06 06:20:23'),
(4, 'RGA07072018-ACL-02-66523', 49, 'INVO-07072018-Mi-0014', 3, '04-0ST2LMLTA001X-01', '2L.ML-TA.001', 'EF L CN 175/96A,EF M CN 170/92M', 'aaa', '130,140', '.08', NULL, NULL, '0', '2018-07-11', '01', '2018-07-25', '111', 'create', '2018-07-06 22:24:57', '2018-07-06 22:24:57'),
(5, 'RGA07072018-ACL-02-66523', 49, 'INVO-07072018-Mi-0014', 3, '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU L CN 175/96A,EU M CN 170/92M', '2L.ML-TA.001', '110,110', '0.002', NULL, NULL, '0', '2018-07-11', '01', '2018-07-25', '111', 'create', '2018-07-06 22:24:57', '2018-07-06 22:24:57'),
(6, 'RGA07072018-ACL-02-48084', 49, 'INVO-25062018-ACL-0005', 3, '04-0ST2LMLTA001X-01', '2L.ML-TA.001', 'EF M CN 170/92M,EF L CN 175/96A,EF S CN 165/88A', 'aaa', '1234,1234,1234', '.08', NULL, NULL, '0', '2018-06-28', '111111', '2018-06-27', '111111', 'create', '2018-07-06 22:40:04', '2018-07-06 22:40:04'),
(7, 'RGA07072018-ACL-02-48084', 49, 'INVO-25062018-ACL-0005', 3, '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU L CN 175/96A,EU M CN 170/92M,EU S CN 165/88A', '2L.ML-TA.001', '2,2,2', '0.002', NULL, NULL, '0', '2018-06-28', '111111', '2018-06-27', '111111', 'create', '2018-07-06 22:40:04', '2018-07-06 22:40:04'),
(8, 'RGA07072018-ACL-02-93469', 49, 'INVO-07072018-CSF-0015', 2, '04-0ST2LMLTA001X-01', '2L.ML-TA.001', 'EF L CN 175/96A', 'aaa', '300', '.08', NULL, NULL, '0', '2018-07-07', '008', '2018-07-24', '7655434', 'create', '2018-07-07 00:19:16', '2018-07-07 00:19:16'),
(9, 'RGA07072018-ACL-02-93469', 49, 'INVO-07072018-CSF-0015', 2, '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'EU L CN 175/96A,EU M CN 170/92M', '2L.ML-TA.001', '2000,600', '0.08', NULL, NULL, '0', '2018-07-07', '008', '2018-07-24', '7655434', 'create', '2018-07-07 00:19:17', '2018-07-07 00:19:17');

-- --------------------------------------------------------

--
-- Table structure for table `mxp_languages`
--

CREATE TABLE `mxp_languages` (
  `id` int(10) UNSIGNED NOT NULL,
  `lan_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lan_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mxp_languages`
--

INSERT INTO `mxp_languages` (`id`, `lan_name`, `lan_code`, `created_at`, `updated_at`, `is_active`) VALUES
(1, 'English', 'en', '2018-03-06 00:10:25', '2018-03-06 00:10:25', 1),
(2, 'বাংলা', 'bn', '2018-03-06 00:10:57', '2018-03-06 00:10:57', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mxp_maximBill`
--

CREATE TABLE `mxp_maximBill` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bill_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `erp_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `oss` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `style` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_size` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit_price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `party_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_buyer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attention_invoice` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_invoice` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mxp_maximBill`
--

INSERT INTO `mxp_maximBill` (`id`, `user_id`, `order_id`, `bill_id`, `erp_code`, `item_code`, `oss`, `style`, `item_size`, `quantity`, `unit_price`, `total_price`, `party_id`, `name_buyer`, `name`, `sort_name`, `address`, `attention_invoice`, `mobile_invoice`, `status`, `created_at`, `updated_at`) VALUES
(1, 49, '5b2a4291e1189', 'INV-20180620-Mi-001', '21-OST2LHTCR001X-02', '2L.HT-CR.001', 'abc', 'fff', NULL, '22', '1.01', '1.0201', '123', 'Ostin\'s', 'Maxpro It', 'Mi', 'Section -1Section-2', 'md Hanif', '01792828282', 'create', '2018-06-20 06:03:31', '2018-06-20 06:03:31'),
(2, 49, '5b2a4291e1189', 'INV-20180620-Mi-001', '04-0ST2LMLTA001X-01', '2L.ML-TA.001', 'abc', 'tt', 'EF M CN 170/92M,EF L CN 175/96A,EF S CN 165/88A', '1201,1200,1202', '.08', '0.0064', '123', 'Ostin\'s', 'Maxpro It', 'Mi', 'Section -1Section-2', 'md Hanif', '01792828282', 'create', '2018-06-20 06:03:31', '2018-06-20 06:03:31'),
(3, 49, '5b2a4291e1189', 'INV-20180620-Mi-001', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'abc', NULL, 'EU S CN 165/88A,EU L CN 175/96A,EU XS CN 160/84A,EU M CN 170/92M', '2001,2003,2000,2002', '0.002', '0.000004', '123', 'Ostin\'s', 'Maxpro It', 'Mi', 'Section -1Section-2', 'md Hanif', '01792828282', 'create', '2018-06-20 06:03:31', '2018-06-20 06:03:31'),
(4, 49, '5b2a4291e1189', 'INV-20180620-Mi-001', '05-OST2LHTCR001X-02', '2L.SLT-TA.001', 'abc', NULL, 'EG L KN 175/96,EG L CN 175/96A', '1001,1000', '.05', '0.0025000000000000005', '123', 'Ostin\'s', 'Maxpro It', 'Mi', 'Section -1Section-2', 'md Hanif', '01792828282', 'create', '2018-06-20 06:03:31', '2018-06-20 06:03:31'),
(5, 49, '5b2cc4ba18a40', 'INV-20180622-ACL-002', '21-OST2LHTCR001X-02', '2L.HT-CR.001', 'abc', 'fff', NULL, '22', '1.01', '1.0201', '3232', 'REGATTA', 'ALPHA CLOTHING LTD', 'ACL', 'Section -1Section- 2', 'aaaa', '01685-696806', 'create', '2018-06-22 03:43:23', '2018-06-22 03:43:23'),
(6, 49, '5b2cc4ba18a40', 'INV-20180622-ACL-002', '04-0ST2LMLTA001X-01', '2L.ML-TA.001', 'abc', 'tt', 'EF M CN 170/92M,EF L CN 175/96A,EF S CN 165/88A', '1201,1200,1202', '.08', '0.0064', '3232', 'REGATTA', 'ALPHA CLOTHING LTD', 'ACL', 'Section -1Section- 2', 'aaaa', '01685-696806', 'create', '2018-06-22 03:43:23', '2018-06-22 03:43:23'),
(7, 49, '5b2cc4ba18a40', 'INV-20180622-ACL-002', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'abc', NULL, 'EU S CN 165/88A,EU L CN 175/96A,EU XS CN 160/84A,EU M CN 170/92M', '2001,2003,2000,2002', '0.002', '0.000004', '3232', 'REGATTA', 'ALPHA CLOTHING LTD', 'ACL', 'Section -1Section- 2', 'aaaa', '01685-696806', 'create', '2018-06-22 03:43:23', '2018-06-22 03:43:23'),
(8, 49, '5b2cc4ba18a40', 'INV-20180622-ACL-002', '05-OST2LHTCR001X-02', '2L.SLT-TA.001', 'abc', NULL, 'EG L KN 175/96,EG L CN 175/96A', '1001,1000', '.05', '0.0025000000000000005', '3232', 'REGATTA', 'ALPHA CLOTHING LTD', 'ACL', 'Section -1Section- 2', 'aaaa', '01685-696806', 'create', '2018-06-22 03:43:23', '2018-06-22 03:43:23');

-- --------------------------------------------------------

--
-- Table structure for table `mxp_menu`
--

CREATE TABLE `mxp_menu` (
  `menu_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `route_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` int(11) DEFAULT '0',
  `is_active` int(11) NOT NULL,
  `order_id` int(11) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mxp_menu`
--

INSERT INTO `mxp_menu` (`menu_id`, `name`, `route_name`, `description`, `parent_id`, `is_active`, `order_id`, `created_at`, `updated_at`) VALUES
(3, 'LANGUAGE', 'language-chooser_view', 'Change Language', 0, 1, 0, NULL, NULL),
(4, 'DASHBOARD', 'dashboard_view', 'Super admin Dashboard', 0, 1, 1, NULL, NULL),
(5, 'SETTINGS', '', 'Settings', 0, 1, 2, NULL, NULL),
(6, 'ROLE', '', 'Role Management ', 0, 1, 2, NULL, NULL),
(7, 'ADD ROLE ACTION', 'add_role_action', 'Add new Role', 0, 1, 0, NULL, NULL),
(8, 'Role List', 'role_list_view', 'Role List and manage option', 6, 1, 2, NULL, NULL),
(9, 'ROLE UPDATE FORM', 'role_update_view', 'Show role update Form', 0, 1, 2, NULL, NULL),
(10, 'ROLE DELETE ACTION', 'role_delete_action', 'Delete role', 0, 1, 0, NULL, NULL),
(11, 'UPDATE ROLE ACTION', 'role_update_action', 'Update Role', 0, 1, 0, NULL, NULL),
(12, 'Role Permission ', 'role_permission_view', 'Set Route Access to Role', 6, 1, 3, NULL, NULL),
(13, 'PERMISSION ROLE ACTION', 'role_permission_action', 'Set Route Access to Role', 0, 1, 0, NULL, NULL),
(16, 'ROLE PERMISSION FORM', 'role_permission_update_view', '0', 0, 1, 0, NULL, NULL),
(18, 'Create User', 'create_user_view', 'User Create Form', 5, 1, 1, NULL, NULL),
(19, 'CREATE USER ACTION', 'create_user_action', '', 0, 1, 0, NULL, NULL),
(20, 'User List', 'user_list_view', '', 5, 1, 2, NULL, NULL),
(21, 'USER UPDATE FORM', 'company_user_update_view', '', 0, 1, 0, NULL, NULL),
(22, 'UPDATE USER ACTION', 'company_user_update_action', '', 0, 1, 0, NULL, NULL),
(23, 'DELETE USER ACTION', 'company_user_delete_action', '', 0, 1, 0, NULL, NULL),
(24, 'Manage Langulage', 'manage_language', 'language add and view', 3, 1, 0, NULL, NULL),
(25, 'ADD LANGUAGE ACTION', 'create_locale_action', 'add language', 0, 1, 0, NULL, NULL),
(26, 'UPDATE LOCALE ACTION', 'update_locale_action', 'update language', 0, 1, 0, NULL, NULL),
(27, 'Manage Translation', 'manage_translation', 'manage transaltion', 3, 1, 2, NULL, NULL),
(28, 'CREATE TRANSLATION ACTION', 'create_translation_action', 'create translation', 0, 1, 0, NULL, NULL),
(29, 'UPDATE TRANSLATION ACTION', 'update_translation_action', 'update translation', 0, 1, 0, NULL, NULL),
(30, 'POST UPDATE TRANSLATION ACTION', 'update_translation_key_action', 'post update translaion', 0, 1, 0, NULL, NULL),
(31, 'DELETE TRANSLATION ACTION', 'delete_translation_action', 'delete translation', 0, 1, 0, NULL, NULL),
(32, 'Upload Language File', 'update_language', 'upload language file', 3, 1, 3, NULL, NULL),
(33, 'USER', '', 'User Management', 0, 1, 1, NULL, NULL),
(34, 'Add New Role', 'add_role_view', 'New role adding form', 6, 1, 1, NULL, NULL),
(35, 'Open Company Acc', 'create_company_acc_view', 'Company Account Opening Form', 5, 1, 3, NULL, NULL),
(36, 'OPEN COMPANY ACCOUNT', 'create_company_acc_action', 'Company Acc opening Action', 5, 1, 2, NULL, NULL),
(37, 'Company List', 'company_list_view', 'Company List View', 5, 1, 4, NULL, NULL),
(38, 'PRODUCT', '', 'Product management', 0, 1, 0, NULL, NULL),
(67, 'Add Client', 'client_com_add_view', '', 0, 1, 0, NULL, NULL),
(68, 'CLIENT ADD', 'client_com_add_action', '', 0, 1, 0, NULL, NULL),
(69, 'Client Update', 'client_com_update_view', '', 0, 1, 0, NULL, NULL),
(70, 'CLIENT UPDATE ACTION', 'client_com_update_action', '', 0, 1, 0, NULL, NULL),
(71, 'CLIENT DELETE ACTION', 'client_com_delete_action', '', 0, 1, 0, NULL, NULL),
(72, 'Client List', 'client_com_list_view', 'Show Client List', 5, 1, 5, NULL, NULL),
(75, 'management', '', '', 0, 1, 4, NULL, NULL),
(76, 'Product List', 'product_list_view', '', 75, 1, 1, NULL, NULL),
(78, 'party list', 'party_list_view', '', 75, 1, 0, NULL, NULL),
(83, 'page', '', '', 0, 1, 0, NULL, NULL),
(84, 'page header', 'page_header_view', '', 83, 1, 0, NULL, NULL),
(85, 'page footer', 'page_footer_view', '', 83, 1, 2, NULL, NULL),
(86, 'report footer', 'report_footer_view', '', 83, 1, 3, NULL, NULL),
(87, 'brand', 'brand_list_view', '', 75, 1, 3, NULL, NULL),
(88, 'Product_size', 'product_size_view', '', 75, 1, 4, NULL, NULL),
(89, 'PRINT', '', 'there r all print file avialbe', 0, 1, 0, NULL, NULL),
(90, 'Bill_copy', 'bill_copy_view', '', 89, 1, 1, NULL, NULL),
(91, 'all_bill_view', 'all_bill_view', '', 89, 1, 3, NULL, NULL),
(92, 'challan_boxing_list', 'challan_boxing_list_view', '', 89, 1, 4, NULL, NULL),
(93, 'order_list_view', 'order_list_view', '', 89, 1, 2, NULL, NULL),
(94, 'ipo_view', 'ipo_view', '', 89, 1, 5, NULL, NULL),
(95, 'Order Input', 'order_input_view', '', 89, 1, 0, NULL, NULL),
(96, 'GMTS Color', 'gmts_color_view', '', 75, 1, 5, NULL, NULL),
(97, 'Production', '', '', 0, 1, 0, NULL, NULL),
(98, 'Booking', 'booking_list_view', '', 97, 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Mxp_multipleChallan`
--

CREATE TABLE `Mxp_multipleChallan` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `challan_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `checking_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bill_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `erp_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `oss` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `style` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_size` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit_price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `party_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_buyer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attention_invoice` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_invoice` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `incrementValue` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Mxp_multipleChallan`
--

INSERT INTO `Mxp_multipleChallan` (`id`, `user_id`, `challan_id`, `checking_id`, `bill_id`, `erp_code`, `item_code`, `oss`, `style`, `item_size`, `quantity`, `unit_price`, `total_price`, `party_id`, `name_buyer`, `name`, `sort_name`, `address`, `attention_invoice`, `mobile_invoice`, `incrementValue`, `status`, `created_at`, `updated_at`) VALUES
(41, 49, 'CHA-20180705--001', 'CHK-20180705--001', NULL, '04-0ST2LMLTA001X-01', '2L.ML-TA.001', NULL, NULL, 'EF L CN 175/96A,EF M CN 170/92M', '10,10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '001', 'create', '2018-07-05 06:18:27', '2018-07-05 06:18:27'),
(42, 49, 'CHA-20180705--001', 'CHK-20180705--001', NULL, '04-OST2LSLTA001X-01', '2L.SL-TA.001', NULL, NULL, 'EU L CN 175/96A,EU M CN 170/92M', '10,10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '001', 'create', '2018-07-05 06:18:28', '2018-07-05 06:18:28'),
(43, 49, 'CHA-20180706--002', 'CHK-20180706--002', NULL, '04-OST2LSLTA001X-01', '2L.SL-TA.001', NULL, NULL, 'EU L CN 175/96A,EU M CN 170/92M,EU S CN 165/88A', '10,12,13', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '002', 'create', '2018-07-06 06:18:46', '2018-07-06 06:18:46'),
(44, 49, 'CHA-20180706--003', 'CHK-20180706--003', NULL, '04-OST2LSLTA001X-01', '2L.SL-TA.001', NULL, NULL, 'EU L CN 175/96A,EU M CN 170/92M,EU S CN 165/88A', '10,8,17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '003', 'create', '2018-07-06 06:19:12', '2018-07-06 06:19:12'),
(45, 49, 'CHA-20180706--004', 'CHK-20180706--004', NULL, '04-OST2LSLTA001X-01', '2L.SL-TA.001', NULL, NULL, 'EU L CN 175/96A,EU M CN 170/92M,EU S CN 165/88A', '0,10,10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '004', 'create', '2018-07-06 06:19:35', '2018-07-06 06:19:35'),
(46, 49, 'CHA-20180707--005', 'CHK-20180707--005', NULL, '04-0ST2LMLTA001X-01', '2L.ML-TA.001', NULL, NULL, 'EF L CN 175/96A,EF M CN 170/92M', '10,10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '005', 'create', '2018-07-06 22:25:40', '2018-07-06 22:25:40'),
(47, 49, 'CHA-20180707--005', 'CHK-20180707--005', NULL, '04-OST2LSLTA001X-01', '2L.SL-TA.001', NULL, NULL, 'EU L CN 175/96A,EU M CN 170/92M', '10,10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '005', 'create', '2018-07-06 22:25:40', '2018-07-06 22:25:40'),
(48, 49, 'CHA-20180707--006', 'CHK-20180707--006', NULL, '04-0ST2LMLTA001X-01', '2L.ML-TA.001', NULL, NULL, 'EF L CN 175/96A', '200', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '006', 'create', '2018-07-07 00:06:10', '2018-07-07 00:06:10'),
(49, 49, 'CHA-20180707--006', 'CHK-20180707--006', NULL, '04-OST2LSLTA001X-01', '2L.SL-TA.001', NULL, NULL, 'EU L CN 175/96A,EU M CN 170/92M', '1000,300', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '006', 'create', '2018-07-07 00:06:10', '2018-07-07 00:06:10');

-- --------------------------------------------------------

--
-- Table structure for table `mxp_order`
--

CREATE TABLE `mxp_order` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `erp_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `oss` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `style` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_size` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `incrementValue` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mxp_order`
--

INSERT INTO `mxp_order` (`id`, `user_id`, `order_id`, `erp_code`, `item_code`, `oss`, `style`, `item_size`, `quantity`, `incrementValue`, `created_at`, `updated_at`) VALUES
(1, 49, '5b2a4291e1189', '21-OST2LHTCR001X-02', '2L.HT-CR.001', 'abc', 'fff', NULL, '22', '001', '2018-06-20 06:03:30', '2018-06-20 06:03:30'),
(2, 49, '5b2a4291e1189', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'abc', 'fff', 'EU XS CN 160/84A', '2000', '001', '2018-06-20 06:03:30', '2018-06-20 06:03:30'),
(3, 49, '5b2a4291e1189', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'abc', NULL, 'EU S CN 165/88A', '2001', '001', '2018-06-20 06:03:30', '2018-06-20 06:03:30'),
(4, 49, '5b2a4291e1189', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'abc', 'tt', 'EU M CN 170/92M', '2002', '001', '2018-06-20 06:03:30', '2018-06-20 06:03:30'),
(5, 49, '5b2a4291e1189', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'abc', 'tt', 'EU L CN 175/96A', '2003', '001', '2018-06-20 06:03:30', '2018-06-20 06:03:30'),
(6, 49, '5b2a4291e1189', '04-0ST2LMLTA001X-01', '2L.ML-TA.001', 'abc', 'tt', 'EF L CN 175/96A', '1200', '001', '2018-06-20 06:03:30', '2018-06-20 06:03:30'),
(7, 49, '5b2a4291e1189', '04-0ST2LMLTA001X-01', '2L.ML-TA.001', 'abc', 'tt', 'EF M CN 170/92M', '1201', '001', '2018-06-20 06:03:30', '2018-06-20 06:03:30'),
(8, 49, '5b2a4291e1189', '04-0ST2LMLTA001X-01', '2L.ML-TA.001', 'abc', NULL, 'EF S CN 165/88A', '1202', '001', '2018-06-20 06:03:30', '2018-06-20 06:03:30'),
(9, 49, '5b2a4291e1189', '05-0ST2LMLTA001X-01', '2L.SLT-TA.001', 'abc', NULL, 'EG L CN 175/96A', '1000', '001', '2018-06-20 06:03:31', '2018-06-20 06:03:31'),
(10, 49, '5b2a4291e1189', '05-0ST2LMLTA001X-01', '2L.SLT-TA.001', 'abc', NULL, 'EG L KN 175/96', '1001', '001', '2018-06-20 06:03:31', '2018-06-20 06:03:31'),
(11, 49, '5b2cc4ba18a40', '21-OST2LHTCR001X-02', '2L.HT-CR.001', 'abc', 'fff', NULL, '22', '002', '2018-06-22 03:43:22', '2018-06-22 03:43:22'),
(12, 49, '5b2cc4ba18a40', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'abc', 'fff', 'EU XS CN 160/84A', '2000', '002', '2018-06-22 03:43:22', '2018-06-22 03:43:22'),
(13, 49, '5b2cc4ba18a40', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'abc', NULL, 'EU S CN 165/88A', '2001', '002', '2018-06-22 03:43:22', '2018-06-22 03:43:22'),
(14, 49, '5b2cc4ba18a40', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'abc', 'tt', 'EU M CN 170/92M', '2002', '002', '2018-06-22 03:43:22', '2018-06-22 03:43:22'),
(15, 49, '5b2cc4ba18a40', '04-OST2LSLTA001X-01', '2L.SL-TA.001', 'abc', 'tt', 'EU L CN 175/96A', '2003', '002', '2018-06-22 03:43:22', '2018-06-22 03:43:22'),
(16, 49, '5b2cc4ba18a40', '04-0ST2LMLTA001X-01', '2L.ML-TA.001', 'abc', 'tt', 'EF L CN 175/96A', '1200', '002', '2018-06-22 03:43:23', '2018-06-22 03:43:23'),
(17, 49, '5b2cc4ba18a40', '04-0ST2LMLTA001X-01', '2L.ML-TA.001', 'abc', 'tt', 'EF M CN 170/92M', '1201', '002', '2018-06-22 03:43:23', '2018-06-22 03:43:23'),
(18, 49, '5b2cc4ba18a40', '04-0ST2LMLTA001X-01', '2L.ML-TA.001', 'abc', NULL, 'EF S CN 165/88A', '1202', '002', '2018-06-22 03:43:23', '2018-06-22 03:43:23'),
(19, 49, '5b2cc4ba18a40', '05-0ST2LMLTA001X-01', '2L.SLT-TA.001', 'abc', NULL, 'EG L CN 175/96A', '1000', '002', '2018-06-22 03:43:23', '2018-06-22 03:43:23'),
(20, 49, '5b2cc4ba18a40', '05-0ST2LMLTA001X-01', '2L.SLT-TA.001', 'abc', NULL, 'EG L KN 175/96', '1001', '002', '2018-06-22 03:43:23', '2018-06-22 03:43:23');

-- --------------------------------------------------------

--
-- Table structure for table `mxp_order_input`
--

CREATE TABLE `mxp_order_input` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `erp_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `oss` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `style` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_size` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit_price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `incrementValue` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mxp_pageFooter`
--

CREATE TABLE `mxp_pageFooter` (
  `footer_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `action` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mxp_pageHeader`
--

CREATE TABLE `mxp_pageHeader` (
  `header_id` int(11) NOT NULL,
  `aaaa` text NOT NULL,
  `aaaav` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mxp_party`
--

CREATE TABLE `mxp_party` (
  `id` int(10) UNSIGNED NOT NULL,
  `party_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_buyer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_part1_invoice` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_part2_invoice` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attention_invoice` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_invoice` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone_invoice` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fax_invoice` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_part1_delivery` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_part2_delivery` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attention_delivery` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_delivery` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone_delivery` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fax_delivery` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mxp_party`
--

INSERT INTO `mxp_party` (`id`, `party_id`, `user_id`, `name`, `sort_name`, `name_buyer`, `address_part1_invoice`, `address_part2_invoice`, `attention_invoice`, `mobile_invoice`, `telephone_invoice`, `fax_invoice`, `address_part1_delivery`, `address_part2_delivery`, `attention_delivery`, `mobile_delivery`, `telephone_delivery`, `fax_delivery`, `description_1`, `description_2`, `description_3`, `created_at`, `updated_at`, `status`) VALUES
(2, '00122', '49', 'CSF GARMENTS (PVT.) LTD', 'CSF', 'REGATTA', 'DELUXE HOUSE #3 (3rd-6th floor)', '209/227, KULGAON, BALUCHARA, CHITTAGAON-4214,BANGLADESH', 'Mr. Mohibul', '+8801984464601', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-06-21 00:35:45', '2018-06-21 00:35:45', NULL),
(3, '6545342', '49', 'Capital Design', 'CD', 'CRAGHOPPERS', 'UNI GEARS LTD', 'BADSHAMIAH SCHOOL ROAD KHAILKUR,BOARD BAZAR GAZIPUR-1702,BANGLADESH PHONE: +88 02 9293760', 'MR. SHEHAB', '+88-09610864328', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-06-21 00:38:43', '2018-06-21 00:38:43', NULL),
(4, '3232', '49', 'ALPHA CLOTHING LTD', 'ACL', 'REGATTA', 'Section -1', 'Section- 2', 'aaaa', '01685-696806', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-06-21 06:55:51', '2018-06-21 06:55:51', NULL),
(5, 'xyz', '49', 'maximumregada', 'rga', 'abc', 'mirpur', 'dhaka', 'abced', '123466', '2345678', NULL, 'village: kalikabari danggapara, Union : Boro Chondipur (5), Post :Havra', 'dhakaq', NULL, '1234567', '2345678', NULL, NULL, NULL, NULL, '2018-07-06 23:14:04', '2018-07-06 23:14:04', NULL),
(6, '123456', '49', 'abc', 'abc', 'aaa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-07-09 00:41:38', '2018-07-09 00:57:10', '1');

-- --------------------------------------------------------

--
-- Table structure for table `mxp_piFormat_data_info`
--

CREATE TABLE `mxp_piFormat_data_info` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `buyer_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mxp_piFormat_data_info`
--

INSERT INTO `mxp_piFormat_data_info` (`id`, `code`, `buyer_name`, `created_at`, `updated_at`) VALUES
(1, '1001', 'Craghoppers', '2018-06-20 18:00:00', '2018-06-20 18:00:00'),
(2, '1002', 'regatta', '2018-06-21 18:00:00', '2018-06-21 18:00:00'),
(3, '1003', 'DARE2B dare2b', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mxp_product`
--

CREATE TABLE `mxp_product` (
  `product_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brand` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `erp_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit_price` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `weight_qty` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `weight_amt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_4` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `action` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mxp_product`
--

INSERT INTO `mxp_product` (`product_id`, `user_id`, `product_code`, `product_name`, `product_description`, `brand`, `erp_code`, `unit_price`, `weight_qty`, `weight_amt`, `description_1`, `description_2`, `description_3`, `description_4`, `status`, `created_at`, `updated_at`, `action`) VALUES
(1, 49, '2L.HT-CR.001', NULL, 'sadsads', 'dhamaka', '21-OST2LHTCR001X-02', '1.01', '7400', '097', 'asdasd', 'asdasd', 'asdasd', 'sadasd', '1', '2018-04-17 00:19:18', '2018-06-11 00:30:32', 'create'),
(2, 49, '2L.ML-TA.001', NULL, 'aaa', 'abc', '04-0ST2LMLTA001X-01', '.08', '120', 'aaa', NULL, NULL, NULL, NULL, '1', '2018-04-17 02:11:23', '2018-06-11 00:30:38', 'create'),
(4, 49, '2L.SL-TA.001', NULL, '2L.ML-TA.001', 'abc', '04-OST2LSLTA001X-01', '0.002', '098', '5', NULL, NULL, NULL, NULL, '1', '2018-04-18 00:59:33', '2018-06-11 00:30:44', 'create'),
(5, 49, '2L.SLT-TA.001', NULL, 'nai', 'abc', '05-OST2LHTCR001X-02', '.05', NULL, NULL, NULL, NULL, NULL, NULL, '1', '2018-04-27 04:59:09', '2018-06-11 00:30:52', 'create'),
(7, 49, 'CSO04369 - REGETTA GREAT', NULL, NULL, 'dhamaka', '22322', '0.6', NULL, NULL, NULL, NULL, NULL, NULL, '1', '2018-06-04 02:50:11', '2018-06-10 23:47:11', 'create'),
(8, 49, 'CTO00029 ( ZK011A ) : PLASTIC TOGGOLE BEADS', 'CORD COLOR', NULL, 'dhamaka', 'X-C0-C-32-E', '0.3', NULL, NULL, NULL, NULL, NULL, NULL, '1', '2018-06-08 02:02:03', '2018-06-08 02:02:03', 'create'),
(9, 49, '5250', 'Other Colors', 'hhh', 'abc', 'jhhl', '0.9', NULL, NULL, NULL, NULL, NULL, NULL, '1', '2018-06-13 01:43:22', '2018-06-13 02:09:12', 'create'),
(10, 49, 'productcode', 'productName', 'this is description', 'branda', 'erpcode', '.8', '100', '.5', NULL, NULL, NULL, NULL, '1', '2018-07-06 23:25:41', '2018-07-06 23:25:41', 'create');

-- --------------------------------------------------------

--
-- Table structure for table `mxp_productSize`
--

CREATE TABLE `mxp_productSize` (
  `proSize_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_size` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mxp_productSize`
--

INSERT INTO `mxp_productSize` (`proSize_id`, `user_id`, `product_code`, `product_size`, `status`, `action`, `created_at`, `updated_at`) VALUES
(1, 49, '2L.SL-TA.001', 'EU L CN 175/96A', '0', 'update', '2018-04-25 11:22:44', '2018-05-22 23:39:44'),
(2, 49, '2L.SL-TA.001', 'EU M CN 170/92M', '1', 'create', '2018-04-25 11:22:53', '2018-04-25 11:22:53'),
(3, 49, '2L.SL-TA.001', 'EU S CN 165/88A', '1', 'create', '2018-04-25 11:22:59', '2018-04-25 11:22:59'),
(4, 49, '2L.SL-TA.001', 'EU XS CN 160/84A', '1', 'update', '2018-04-25 11:23:06', '2018-05-15 01:57:02'),
(5, 49, '2L.HT-CR.001', 'EF L CN 175/96A', '1', 'update', '2018-04-25 11:23:36', '2018-04-27 03:49:51'),
(6, 49, '2L.ML-TA.001', 'EF L CN 175/96A', '1', 'create', '2018-04-27 00:04:10', '2018-04-27 00:04:10'),
(7, 49, '2L.ML-TA.001', 'EF M CN 170/92M', '1', 'create', '2018-04-27 00:04:36', '2018-04-27 00:04:36'),
(8, 49, '2L.ML-TA.001', 'EF S CN 165/88A', '1', 'create', '2018-04-27 00:05:06', '2018-04-27 00:05:06'),
(9, 49, '2L.SLT-TA.001', 'EG L CN 175/96A', '1', 'create', '2018-04-27 04:59:26', '2018-04-27 04:59:26'),
(10, 49, '2L.SLT-TA.001', 'EG L KN 175/96', '1', 'update', '2018-04-27 05:00:03', '2018-04-27 05:00:21'),
(11, 49, '2L.SLT-TA.001', 'EF L CN 175/96A3', '1', 'create', '2018-05-16 05:18:59', '2018-05-16 05:18:59'),
(12, 49, 'CSO04369 - REGETTA GREAT', 'S', '1', 'create', '2018-06-04 02:50:29', '2018-06-04 02:50:29'),
(13, 49, 'CSO04369 - REGETTA GREAT', 'm', '1', 'update', '2018-06-04 02:50:42', '2018-06-20 05:23:22'),
(14, 49, 'CSO04369 - REGETTA GREAT', 'XL', '1', 'create', '2018-06-04 02:51:00', '2018-06-04 02:51:00'),
(15, 49, 'CSO04369 - REGETTA GREAT', 'XLL', '1', 'create', '2018-06-04 02:51:09', '2018-06-04 02:51:09'),
(16, 49, 'CSO04369 - REGETTA GREAT', '4XL', '1', 'create', '2018-06-04 02:51:44', '2018-06-04 02:51:44'),
(17, 49, 'CSO04369 - REGETTA GREAT', '5XL', '1', 'create', '2018-06-04 02:52:19', '2018-06-04 02:52:19'),
(18, 49, 'CTO00029 ( ZK011A ) : PLASTIC TOGGOLE BEADS', 'DARK STEEL', '1', 'create', '2018-06-08 02:02:39', '2018-06-08 02:02:39'),
(19, 49, 'CTO00029 ( ZK011A ) : PLASTIC TOGGOLE BEADS', 'ANTIQUE BRASS', '1', 'create', '2018-06-08 02:03:25', '2018-06-08 02:03:25'),
(20, 49, '5250', '1212', '1', 'create', '2018-06-13 01:50:35', '2018-06-13 01:50:35'),
(21, 49, '2L.HT-CR.001', '2', '1', 'create', '2018-07-06 23:28:48', '2018-07-06 23:28:48');

-- --------------------------------------------------------

--
-- Table structure for table `mxp_reportFooter`
--

CREATE TABLE `mxp_reportFooter` (
  `re_footer_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `reportName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_2` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_3` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_4` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_5` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `siginingPerson_1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `siginingPersonSeal_1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `siginingSignature_1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `siginingPerson_2` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `siginingSignature_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `siginingPersonSeal_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `action` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mxp_reportFooter`
--

INSERT INTO `mxp_reportFooter` (`re_footer_id`, `user_id`, `reportName`, `description_1`, `description_2`, `description_3`, `description_4`, `description_5`, `siginingPerson_1`, `siginingPersonSeal_1`, `siginingSignature_1`, `siginingPerson_2`, `siginingSignature_2`, `siginingPersonSeal_2`, `status`, `created_at`, `updated_at`, `action`) VALUES
(2, 49, 'challan report', '', '', '', '', '', '', NULL, NULL, '', NULL, NULL, '1', '2018-04-17 00:14:14', '2018-06-22 23:01:12', 'create');

-- --------------------------------------------------------

--
-- Table structure for table `mxp_role`
--

CREATE TABLE `mxp_role` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` int(11) NOT NULL,
  `cm_group_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mxp_role`
--

INSERT INTO `mxp_role` (`id`, `name`, `company_id`, `cm_group_id`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'super_admin', 0, '', 1, '2018-01-14 20:58:10', '2018-01-25 04:51:10'),
(20, 'sales mnager for company-A', 10, '', 1, '2018-01-29 06:40:01', '2018-01-29 06:40:01'),
(21, 'sales mnager for company-B', 11, '', 1, '2018-01-29 06:40:16', '2018-01-29 06:40:16'),
(22, 'C-a', 10, '', 1, '2018-01-31 02:33:42', '2018-01-31 02:33:42'),
(23, 'Sals Manager_aa', 10, '', 1, '2018-01-31 02:45:42', '2018-01-31 02:45:42'),
(24, 'Sals Manager_aa', 12, '', 1, '2018-01-31 02:45:42', '2018-01-31 02:45:42'),
(25, 'sumit-role-a', 13, '', 1, '2018-01-31 02:58:27', '2018-01-31 02:58:27'),
(26, 'sumit-role-b', 14, '', 1, '2018-01-31 02:58:38', '2018-01-31 02:58:38'),
(27, 'Manager', 10, '', 1, '2018-03-05 13:01:40', '2018-03-05 13:01:40'),
(29, 'test', 10, '', 1, '2018-04-09 01:57:41', '2018-04-09 01:57:41'),
(30, 'role', 17, '34721', 1, '2018-05-03 02:40:21', '2018-05-03 02:40:21'),
(31, 'S Com ROle', 18, '32352', 1, '2018-05-10 00:08:52', '2018-05-10 00:08:52'),
(32, 'subAdmin', 18, '23551', 1, '2018-05-18 00:02:52', '2018-05-18 00:02:52'),
(33, 'admin', 18, '23506', 1, '2018-05-18 00:03:06', '2018-05-18 00:03:06'),
(34, 'asasas', 17, '13547', 1, '2018-05-19 01:18:47', '2018-05-19 01:18:47');

-- --------------------------------------------------------

--
-- Table structure for table `mxp_translations`
--

CREATE TABLE `mxp_translations` (
  `translation_id` int(10) UNSIGNED NOT NULL,
  `translation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `translation_key_id` int(11) DEFAULT NULL,
  `lan_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `same_trans_key_id` int(11) NOT NULL,
  `is_active` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mxp_translations`
--

INSERT INTO `mxp_translations` (`translation_id`, `translation`, `translation_key_id`, `lan_code`, `same_trans_key_id`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'BD Maxim Online', 1, 'en', 0, 1, '2018-03-05 18:12:49', '2018-07-08 23:58:37'),
(2, 'বিডি ম্যাক্সিম অনলাইন', 1, 'bn', 0, 1, '2018-03-05 18:12:49', '2018-07-08 23:58:37'),
(3, 'Log In', 2, 'en', 0, 1, '2018-03-05 20:38:51', '2018-03-05 20:39:11'),
(4, 'লগ ইন', 2, 'bn', 0, 1, '2018-03-05 20:38:51', '2018-03-05 20:39:11'),
(5, 'Registration', 3, 'en', 0, 1, '2018-03-05 20:39:27', '2018-03-05 20:41:56'),
(6, 'নিবন্ধন করুন', 3, 'bn', 0, 1, '2018-03-05 20:39:27', '2018-03-05 20:41:56'),
(7, 'Whoops!', 4, 'en', 0, 1, '2018-03-05 20:54:56', '2018-03-05 21:04:24'),
(8, 'উপস!', 4, 'bn', 0, 1, '2018-03-05 20:54:56', '2018-03-05 21:04:24'),
(9, 'There were some problems with your input.', 5, 'en', 0, 1, '2018-03-05 20:56:52', '2018-03-05 21:03:46'),
(10, 'আপনার ইনপুট সঙ্গে কিছু সমস্যা ছিল।', 5, 'bn', 0, 1, '2018-03-05 20:56:52', '2018-03-05 21:03:46'),
(11, 'Or you are not active yet.', 6, 'en', 0, 1, '2018-03-05 20:57:04', '2018-03-05 21:03:01'),
(12, 'অথবা আপনি এখনো সক্রিয় নন', 6, 'bn', 0, 1, '2018-03-05 20:57:04', '2018-03-05 21:03:01'),
(13, 'E-Mail Address', 7, 'en', 0, 1, '2018-03-05 20:57:14', '2018-03-05 20:59:25'),
(14, 'ই-মেইল ঠিকানা', 7, 'bn', 0, 1, '2018-03-05 20:57:14', '2018-03-05 20:59:25'),
(15, 'Password', 8, 'en', 0, 1, '2018-03-05 20:57:22', '2018-03-05 21:00:01'),
(16, 'পাসওয়ার্ড', 8, 'bn', 0, 1, '2018-03-05 20:57:22', '2018-03-05 21:00:01'),
(17, 'Remember me?', 9, 'en', 0, 1, '2018-03-05 20:57:31', '2018-03-05 21:02:15'),
(18, 'আমাকে মনে রাখুন?', 9, 'bn', 0, 1, '2018-03-05 20:57:31', '2018-03-05 21:02:15'),
(19, 'Forgot Your Password?', 10, 'en', 0, 1, '2018-03-05 20:57:39', '2018-03-05 21:00:39'),
(20, 'আপনি কি পাসওয়ার্ড ভুলে গেছেন?', 10, 'bn', 0, 1, '2018-03-05 20:57:39', '2018-03-05 21:00:39'),
(21, 'Dashboard', 11, 'en', 0, 1, '2018-03-05 23:23:51', '2018-03-05 23:32:59'),
(22, 'ড্যাশবোর্ড', 11, 'bn', 0, 1, '2018-03-05 23:23:51', '2018-03-05 23:32:59'),
(23, 'Language List', 12, 'en', 0, 1, '2018-03-05 23:34:35', '2018-03-05 23:35:06'),
(24, 'ভাষা তালিকা', 12, 'bn', 0, 1, '2018-03-05 23:34:35', '2018-03-05 23:35:06'),
(25, 'Serial no.', 13, 'en', 0, 1, '2018-03-05 23:36:43', '2018-03-05 23:37:54'),
(26, 'ক্রমিক নং', 13, 'bn', 0, 1, '2018-03-05 23:36:44', '2018-03-05 23:37:54'),
(27, 'Language Title', 14, 'en', 0, 1, '2018-03-05 23:38:13', '2018-03-05 23:38:37'),
(28, 'ভাষা শিরোনাম', 14, 'bn', 0, 1, '2018-03-05 23:38:13', '2018-03-05 23:38:37'),
(29, 'Language Code', 15, 'en', 0, 1, '2018-03-05 23:38:47', '2018-03-05 23:39:11'),
(30, 'ভাষা কোড', 15, 'bn', 0, 1, '2018-03-05 23:38:47', '2018-03-05 23:39:11'),
(31, 'Status', 16, 'en', 0, 1, '2018-03-05 23:39:23', '2018-03-05 23:40:25'),
(32, 'সাময়িক অবস্থা', 16, 'bn', 0, 1, '2018-03-05 23:39:23', '2018-03-05 23:40:25'),
(33, 'Action', 17, 'en', 0, 1, '2018-03-05 23:40:40', '2018-03-05 23:42:00'),
(34, 'ক্রিয়াকলাপ', 17, 'bn', 0, 1, '2018-03-05 23:40:40', '2018-03-05 23:42:00'),
(35, 'Active', 18, 'en', 0, 1, '2018-03-05 23:43:00', '2018-03-05 23:43:27'),
(36, 'সক্রিয়', 18, 'bn', 0, 1, '2018-03-05 23:43:00', '2018-03-05 23:43:27'),
(37, 'Inactive', 19, 'en', 0, 1, '2018-03-05 23:43:47', '2018-03-05 23:44:13'),
(38, 'নিষ্ক্রিয়', 19, 'bn', 0, 1, '2018-03-05 23:43:47', '2018-03-05 23:44:13'),
(39, 'Add Locale', 20, 'en', 0, 1, '2018-03-05 23:58:03', '2018-03-05 23:59:51'),
(40, 'স্থান যোগ করুন', 20, 'bn', 0, 1, '2018-03-05 23:58:03', '2018-03-05 23:59:52'),
(41, 'edit', 21, 'en', 0, 1, '2018-03-06 00:00:03', '2018-03-06 00:01:53'),
(42, 'পরিবর্তন করুন', 21, 'bn', 0, 1, '2018-03-06 00:00:03', '2018-03-06 00:01:53'),
(43, 'Add new Language', 22, 'en', 0, 1, '2018-03-06 00:14:26', '2018-03-06 00:15:12'),
(44, 'নতুন ভাষা যোগ করুন', 22, 'bn', 0, 1, '2018-03-06 00:14:26', '2018-03-06 00:15:12'),
(45, 'Add Language', 23, 'en', 0, 1, '2018-03-06 00:15:45', '2018-03-06 00:16:16'),
(46, 'ভাষা যোগ করুন', 23, 'bn', 0, 1, '2018-03-06 00:15:45', '2018-03-06 00:16:16'),
(47, 'Enter Language Title', 24, 'en', 0, 1, '2018-03-06 00:16:49', '2018-03-06 00:17:21'),
(48, 'ভাষা শিরোনাম লিখুন', 24, 'bn', 0, 1, '2018-03-06 00:16:49', '2018-03-06 00:17:21'),
(49, 'Enter Language Code', 25, 'en', 0, 1, '2018-03-06 00:17:31', '2018-03-06 00:17:54'),
(50, 'ভাষা কোড লিখুন', 25, 'bn', 0, 1, '2018-03-06 00:17:31', '2018-03-06 00:17:54'),
(51, 'Save', 26, 'en', 0, 1, '2018-03-06 00:18:57', '2018-03-06 00:19:17'),
(52, 'সংরক্ষণ করুন', 26, 'bn', 0, 1, '2018-03-06 00:18:57', '2018-03-06 00:19:17'),
(53, 'Update Locale', 27, 'en', 0, 1, '2018-03-06 00:23:12', '2018-03-06 00:28:13'),
(54, 'লোকেল আপডেট করুন', 27, 'bn', 0, 1, '2018-03-06 00:23:12', '2018-03-06 00:28:13'),
(55, 'Update Language Title', 28, 'en', 0, 1, '2018-03-06 00:28:35', '2018-03-06 00:29:18'),
(56, 'ভাষা শিরোনাম আপডেট করুন', 28, 'bn', 0, 1, '2018-03-06 00:28:36', '2018-03-06 00:29:18'),
(57, 'Update Language Code', 29, 'en', 0, 1, '2018-03-06 00:29:32', '2018-03-06 00:29:55'),
(58, 'ভাষা কোড আপডেট করুন', 29, 'bn', 0, 1, '2018-03-06 00:29:32', '2018-03-06 00:29:55'),
(59, 'Update', 30, 'en', 0, 1, '2018-03-06 00:30:07', '2018-03-06 00:30:52'),
(60, 'পরিবর্তন করুন', 30, 'bn', 0, 1, '2018-03-06 00:30:07', '2018-03-06 00:30:52'),
(61, 'Update Language', 31, 'en', 0, 1, '2018-03-06 00:32:05', '2018-03-06 00:32:45'),
(62, 'ভাষা আপডেট করুন', 31, 'bn', 0, 1, '2018-03-06 00:32:05', '2018-03-06 00:32:45'),
(63, 'Comfirm! you want to upload translation file..', 32, 'en', 0, 1, '2018-03-06 00:34:41', '2018-03-06 00:36:01'),
(64, 'নিশ্চিত করুন! আপনি অনুবাদ ফাইল আপলোড করতে চান ..', 32, 'bn', 0, 1, '2018-03-06 00:34:41', '2018-03-06 00:36:01'),
(65, 'Upload', 33, 'en', 0, 1, '2018-03-06 00:36:42', '2018-03-06 00:37:14'),
(66, 'আপলোড', 33, 'bn', 0, 1, '2018-03-06 00:36:42', '2018-03-06 00:37:14'),
(67, 'Translation List', 34, 'en', 0, 1, '2018-03-06 00:39:26', '2018-03-06 00:49:15'),
(68, 'অনুবাদ তালিকা', 34, 'bn', 0, 1, '2018-03-06 00:39:26', '2018-03-06 00:49:15'),
(69, 'Add new key', 35, 'en', 0, 1, '2018-03-06 00:49:29', '2018-03-06 00:51:01'),
(70, 'নতুন টীকা যোগ করুন', 35, 'bn', 0, 1, '2018-03-06 00:49:29', '2018-03-06 00:51:01'),
(71, 'Search the translation key....', 36, 'en', 0, 1, '2018-03-06 00:51:16', '2018-03-06 00:52:27'),
(72, 'অনুবাদ টীকা অনুসন্ধান করুন ....', 36, 'bn', 0, 1, '2018-03-06 00:51:16', '2018-03-06 00:52:27'),
(73, 'Translation key', 37, 'en', 0, 1, '2018-03-06 00:52:45', '2018-03-06 00:54:17'),
(74, 'অনুবাদ টীকা', 37, 'bn', 0, 1, '2018-03-06 00:52:45', '2018-03-06 00:54:17'),
(75, 'Translation', 38, 'en', 0, 1, '2018-03-06 00:54:31', '2018-03-06 00:55:09'),
(76, 'অনুবাদ', 38, 'bn', 0, 1, '2018-03-06 00:54:31', '2018-03-06 00:55:09'),
(77, 'Language', 39, 'en', 0, 1, '2018-03-06 00:55:21', '2018-03-06 00:55:50'),
(78, 'ভাষা', 39, 'bn', 0, 1, '2018-03-06 00:55:21', '2018-03-06 00:55:50'),
(79, 'Delete', 40, 'en', 0, 1, '2018-03-06 00:56:29', '2018-03-06 00:56:51'),
(80, 'বাদ দিন', 40, 'bn', 0, 1, '2018-03-06 00:56:29', '2018-03-06 00:56:51'),
(81, 'Add new translation key', 41, 'en', 0, 1, '2018-03-06 01:07:29', '2018-03-06 01:08:09'),
(82, 'নতুন অনুবাদ টীকা যোগ করুন', 41, 'bn', 0, 1, '2018-03-06 01:07:29', '2018-03-06 01:08:09'),
(83, 'Enter Translation key', 42, 'en', 0, 1, '2018-03-06 01:08:20', '2018-03-06 01:09:01'),
(84, 'অনুবাদ টীকা প্রবেশ করান', 42, 'bn', 0, 1, '2018-03-06 01:08:20', '2018-03-06 01:09:01'),
(85, 'Update Translation', 43, 'en', 0, 1, '2018-03-06 01:18:54', '2018-03-06 01:19:29'),
(86, 'অনুবাদ আপডেট করুন', 43, 'bn', 0, 1, '2018-03-06 01:18:54', '2018-03-06 01:19:29'),
(87, 'Update Translation key', 44, 'en', 0, 1, '2018-03-06 01:19:50', '2018-03-06 01:20:39'),
(88, 'অনুবাদ টীকা আপডেট করুন', 44, 'bn', 0, 1, '2018-03-06 01:19:50', '2018-03-06 01:20:39'),
(89, 'LANGUAGE', 45, 'en', 0, 1, '2018-03-06 19:21:58', '2018-03-06 19:27:49'),
(90, 'ভাষা', 45, 'bn', 0, 1, '2018-03-06 19:21:58', '2018-03-06 19:27:49'),
(91, 'Manage Language', 46, 'en', 0, 1, '2018-03-06 19:23:15', '2018-03-06 19:24:25'),
(92, 'ভাষা পরিচালনা করুন', 46, 'bn', 0, 1, '2018-03-06 19:23:15', '2018-03-06 19:24:25'),
(93, 'Manage Translation', 47, 'en', 0, 1, '2018-03-06 19:24:37', '2018-03-06 19:25:16'),
(94, 'অনুবাদ পরিচালনা করুন', 47, 'bn', 0, 1, '2018-03-06 19:24:37', '2018-03-06 19:25:17'),
(95, 'Upload Language File', 48, 'en', 0, 1, '2018-03-06 19:25:41', '2018-03-06 19:26:18'),
(96, 'ভাষা ফাইল আপলোড করুন', 48, 'bn', 0, 1, '2018-03-06 19:25:41', '2018-03-06 19:26:18'),
(97, 'ROLE', 49, 'en', 0, 1, '2018-03-06 19:26:59', '2018-03-06 19:27:26'),
(98, 'ভূমিকা', 49, 'bn', 0, 1, '2018-03-06 19:26:59', '2018-03-06 19:27:26'),
(99, 'Add New Role', 50, 'en', 0, 1, '2018-03-06 19:28:03', '2018-03-06 19:29:56'),
(100, 'নতুন ভূমিকা যোগ করুন', 50, 'bn', 0, 1, '2018-03-06 19:28:03', '2018-03-06 19:29:56'),
(101, 'Role List', 51, 'en', 0, 1, '2018-03-06 19:30:11', '2018-03-06 19:30:35'),
(102, 'ভূমিকা তালিকা', 51, 'bn', 0, 1, '2018-03-06 19:30:11', '2018-03-06 19:30:36'),
(103, 'Role Permission', 52, 'en', 0, 1, '2018-03-06 19:30:45', '2018-03-06 19:31:10'),
(104, 'ভূমিকা অনুমতি', 52, 'bn', 0, 1, '2018-03-06 19:30:45', '2018-03-06 19:31:10'),
(105, 'SETTINGS', 53, 'en', 0, 1, '2018-03-06 19:31:22', '2018-03-06 19:31:55'),
(106, 'সেটিংস', 53, 'bn', 0, 1, '2018-03-06 19:31:22', '2018-03-06 19:31:55'),
(107, 'Open Company Account', 54, 'en', 0, 1, '2018-03-06 19:32:15', '2018-03-06 19:34:08'),
(108, 'কোম্পানি অ্যাকাউন্ট খোলা', 54, 'bn', 0, 1, '2018-03-06 19:32:15', '2018-03-06 19:34:08'),
(109, 'Company List', 55, 'en', 0, 1, '2018-03-06 19:34:19', '2018-03-06 19:34:45'),
(110, 'কোম্পানি তালিকা', 55, 'bn', 0, 1, '2018-03-06 19:34:19', '2018-03-06 19:34:45'),
(111, 'Create User', 56, 'en', 0, 1, '2018-03-06 19:34:56', '2018-03-06 19:36:05'),
(112, 'নতুন ব্যবহারকারী সংযোজন', 56, 'bn', 0, 1, '2018-03-06 19:34:56', '2018-03-06 19:36:05'),
(113, 'Create User', 57, 'en', 0, 1, '2018-03-06 19:36:15', '2018-03-06 19:38:03'),
(114, 'নতুন ব্যবহারকারী সংযোজন', 57, 'bn', 0, 1, '2018-03-06 19:36:15', '2018-03-06 19:38:03'),
(115, 'User List', 58, 'en', 0, 1, '2018-03-06 19:39:56', '2018-03-06 19:40:22'),
(116, 'ব্যবহারকারীর তালিকা', 58, 'bn', 0, 1, '2018-03-06 19:39:56', '2018-03-06 19:40:22'),
(117, 'Client List', 59, 'en', 0, 1, '2018-03-06 19:40:33', '2018-03-06 19:41:36'),
(118, 'গ্রাহকের তালিকা', 59, 'bn', 0, 1, '2018-03-06 19:40:33', '2018-03-06 19:41:36'),
(119, 'PRODUCT', 60, 'en', 0, 1, '2018-03-06 19:41:56', '2018-03-06 19:42:18'),
(120, 'পণ্য', 60, 'bn', 0, 1, '2018-03-06 19:41:56', '2018-03-06 19:42:18'),
(121, 'Product\'s Unit', 61, 'en', 0, 1, '2018-03-06 19:42:32', '2018-03-06 19:48:13'),
(122, 'পণ্যের একক', 61, 'bn', 0, 1, '2018-03-06 19:42:32', '2018-03-06 19:48:13'),
(123, 'Product Group', 62, 'en', 0, 1, '2018-03-06 19:48:24', '2018-03-06 19:48:54'),
(124, 'পণ্যের গ্রুপ', 62, 'bn', 0, 1, '2018-03-06 19:48:25', '2018-03-06 19:48:54'),
(125, 'Product Entry', 63, 'en', 0, 1, '2018-03-06 19:49:03', '2018-03-06 19:50:00'),
(126, 'পণ্য সংযোজন', 63, 'bn', 0, 1, '2018-03-06 19:49:03', '2018-03-06 19:50:00'),
(127, 'Product Packing', 64, 'en', 0, 1, '2018-03-06 19:50:09', '2018-03-06 19:50:39'),
(128, 'পণ্য প্যাকেজিং', 64, 'bn', 0, 1, '2018-03-06 19:50:09', '2018-03-06 19:50:39'),
(129, 'Purchase', 65, 'en', 0, 1, '2018-03-06 19:50:54', '2018-03-06 19:51:38'),
(130, 'ক্রয়', 65, 'bn', 0, 1, '2018-03-06 19:50:54', '2018-03-06 19:51:38'),
(131, 'Purchase List', 66, 'en', 0, 1, '2018-03-06 19:51:47', '2018-03-06 19:52:14'),
(132, 'ক্রয় তালিকা', 66, 'bn', 0, 1, '2018-03-06 19:51:48', '2018-03-06 19:52:14'),
(133, 'Update Stock', 67, 'en', 0, 1, '2018-03-06 19:52:27', '2018-03-06 19:53:39'),
(134, 'আপডেট স্টক', 67, 'bn', 0, 1, '2018-03-06 19:52:27', '2018-03-06 19:53:40'),
(135, 'Vat Tax List', 68, 'en', 0, 1, '2018-03-06 19:53:48', '2018-03-06 19:54:15'),
(136, 'ভ্যাট ট্যাক্স তালিকা', 68, 'bn', 0, 1, '2018-03-06 19:53:48', '2018-03-06 19:54:15'),
(137, 'Sale List', 69, 'en', 0, 1, '2018-03-06 19:54:25', '2018-03-06 19:54:55'),
(138, 'বিক্রয় তালিকা', 69, 'bn', 0, 1, '2018-03-06 19:54:25', '2018-03-06 19:54:55'),
(139, 'Save Sale', 70, 'en', 0, 1, '2018-03-06 19:55:15', '2018-03-06 19:56:07'),
(140, 'বিক্রয় যোগ করুন', 70, 'bn', 0, 1, '2018-03-06 19:55:15', '2018-03-06 19:56:07'),
(141, 'Inventory Report', 71, 'en', 0, 1, '2018-03-06 19:56:45', '2018-03-06 19:57:12'),
(142, 'পরিসংখ্যা প্রতিবেদন', 71, 'bn', 0, 1, '2018-03-06 19:56:45', '2018-03-06 19:57:12'),
(143, 'STOCK MANAGEMENT', 72, 'en', 0, 1, '2018-03-06 19:57:21', '2018-03-06 19:57:51'),
(144, 'স্টক ব্যবস্থাপনা', 72, 'bn', 0, 1, '2018-03-06 19:57:21', '2018-03-06 19:57:51'),
(145, 'Store', 73, 'en', 0, 1, '2018-03-06 19:58:01', '2018-03-06 19:58:42'),
(146, 'ভাণ্ডার', 73, 'bn', 0, 1, '2018-03-06 19:58:01', '2018-03-06 19:58:42'),
(147, 'Stock', 74, 'en', 0, 1, '2018-03-06 19:58:53', '2018-03-06 19:59:16'),
(148, 'স্টক', 74, 'bn', 0, 1, '2018-03-06 19:58:53', '2018-03-06 19:59:17'),
(151, 'Company/Client Name', 76, 'en', 0, 1, '2018-03-06 20:57:06', '2018-03-06 20:57:55'),
(152, 'কোম্পানী / গ্রাহকের নাম', 76, 'bn', 0, 1, '2018-03-06 20:57:06', '2018-03-06 20:57:55'),
(153, 'Role Name', 77, 'en', 0, 1, '2018-03-06 21:05:38', '2018-03-06 21:06:30'),
(154, 'ভূমিকার নাম', 77, 'bn', 0, 1, '2018-03-06 21:05:38', '2018-03-06 21:06:30'),
(155, 'Select Company/Client', 78, 'en', 0, 1, '2018-03-06 21:06:59', '2018-03-06 21:07:40'),
(156, 'কোম্পানী / ক্লায়েন্ট নির্বাচন করুন', 78, 'bn', 0, 1, '2018-03-06 21:06:59', '2018-03-06 21:07:40'),
(157, 'Select Role', 79, 'en', 0, 1, '2018-03-06 21:08:51', '2018-03-06 21:09:15'),
(158, 'ভূমিকা নির্বাচন করুন', 79, 'bn', 0, 1, '2018-03-06 21:08:51', '2018-03-06 21:09:15'),
(159, 'Select All', 80, 'en', 0, 1, '2018-03-06 21:11:57', '2018-03-06 21:12:22'),
(160, 'সব নির্বাচন করুন', 80, 'bn', 0, 1, '2018-03-06 21:11:57', '2018-03-06 21:12:23'),
(161, 'Unselect all', 81, 'en', 0, 1, '2018-03-06 21:12:36', '2018-03-06 21:12:57'),
(162, 'সরিয়ে ফেলুন সব', 81, 'bn', 0, 1, '2018-03-06 21:12:36', '2018-03-06 21:12:57'),
(163, 'SET', 82, 'en', 0, 1, '2018-03-06 21:14:03', '2018-03-06 21:14:34'),
(164, 'নিযুক্ত করা', 82, 'bn', 0, 1, '2018-03-06 21:14:03', '2018-03-06 21:14:34'),
(165, 'Assign Role', 83, 'en', 0, 1, '2018-03-06 21:15:41', '2018-03-06 21:16:07'),
(166, 'ভূমিকা অর্পণ', 83, 'bn', 0, 1, '2018-03-06 21:15:41', '2018-03-06 21:16:07'),
(167, 'Role Permission List', 84, 'en', 0, 1, '2018-03-06 21:19:23', '2018-03-06 21:19:45'),
(168, 'ভূমিকা অনুমতি তালিকা', 84, 'bn', 0, 1, '2018-03-06 21:19:23', '2018-03-06 21:19:45'),
(169, 'Permitted Route List', 85, 'en', 0, 1, '2018-03-06 21:19:57', '2018-03-06 21:20:30'),
(170, 'অনুমোদিত রুট তালিকা', 85, 'bn', 0, 1, '2018-03-06 21:19:57', '2018-03-06 21:20:30'),
(171, 'Update Role', 86, 'en', 0, 1, '2018-03-06 21:36:58', '2018-03-06 21:37:20'),
(172, 'আপডেট ভূমিকা', 86, 'bn', 0, 1, '2018-03-06 21:36:58', '2018-03-06 21:37:20'),
(173, 'Add Stock', 87, 'en', 0, 1, '2018-03-06 22:00:58', '2018-03-06 22:01:24'),
(174, 'স্টক যোগ করুন', 87, 'bn', 0, 1, '2018-03-06 22:00:58', '2018-03-06 22:01:24'),
(175, 'Product Name', 88, 'en', 0, 1, '2018-03-06 22:01:41', '2018-04-10 04:09:15'),
(176, 'পণ্য  নাম', 88, 'bn', 0, 1, '2018-03-06 22:01:41', '2018-04-10 04:09:15'),
(177, 'Product/Particular Group', 89, 'en', 0, 1, '2018-03-06 22:02:40', '2018-03-06 22:03:10'),
(178, 'পণ্য / বিশেষ গ্রুপ', 89, 'bn', 0, 1, '2018-03-06 22:02:40', '2018-03-06 22:03:10'),
(179, 'Quantity', 90, 'en', 0, 1, '2018-03-06 22:03:38', '2018-03-06 22:04:05'),
(180, 'পরিমাণ', 90, 'bn', 0, 1, '2018-03-06 22:03:38', '2018-03-06 22:04:05'),
(181, 'Select Location', 91, 'en', 0, 1, '2018-03-06 22:04:43', '2018-03-06 22:05:00'),
(182, 'স্থান নির্বাচন করুন', 91, 'bn', 0, 1, '2018-03-06 22:04:43', '2018-03-06 22:05:01'),
(187, 'Add new Store', 94, 'en', 0, 1, '2018-03-06 22:21:41', '2018-03-06 22:22:04'),
(188, 'নতুন স্টোর যোগ করুন', 94, 'bn', 0, 1, '2018-03-06 22:21:41', '2018-03-06 22:22:04'),
(189, 'Add store', 95, 'en', 0, 1, '2018-03-06 22:22:14', '2018-03-06 22:22:58'),
(190, 'স্টোর যোগ করুন', 95, 'bn', 0, 1, '2018-03-06 22:22:14', '2018-03-06 22:22:58'),
(191, 'Enter Store Name', 96, 'en', 0, 1, '2018-03-06 22:23:21', '2018-03-06 22:23:42'),
(192, 'স্টোর নাম লিখুন', 96, 'bn', 0, 1, '2018-03-06 22:23:21', '2018-03-06 22:23:42'),
(193, 'Enter Store Location', 97, 'en', 0, 1, '2018-03-06 22:23:51', '2018-03-06 22:24:16'),
(194, 'দোকানের অবস্থান লিখুন', 97, 'bn', 0, 1, '2018-03-06 22:23:51', '2018-03-06 22:24:16'),
(195, 'Update Store', 98, 'en', 0, 1, '2018-03-06 22:27:47', '2018-03-06 22:28:16'),
(196, 'আপডেট স্টোর', 98, 'bn', 0, 1, '2018-03-06 22:27:47', '2018-03-06 22:28:16'),
(199, 'Store List', 100, 'en', 0, 1, '2018-03-06 22:34:46', '2018-03-06 22:36:17'),
(200, 'স্টোর তালিকা', 100, 'bn', 0, 1, '2018-03-06 22:34:46', '2018-03-06 22:36:17'),
(201, 'Store Name', 101, 'en', 0, 1, '2018-03-06 22:36:32', '2018-03-06 22:37:16'),
(202, 'স্টোরের নাম', 101, 'bn', 0, 1, '2018-03-06 22:36:32', '2018-03-06 22:37:16'),
(203, 'Store Location', 102, 'en', 0, 1, '2018-03-06 22:37:36', '2018-03-06 22:38:13'),
(204, 'স্টোরের অবস্থান', 102, 'bn', 0, 1, '2018-03-06 22:37:36', '2018-03-06 22:38:13'),
(205, 'List of Responsible people', 103, 'en', 0, 1, '2018-03-06 22:45:51', '2018-03-06 22:46:15'),
(206, 'দায়ী ব্যক্তিদের তালিকা', 103, 'bn', 0, 1, '2018-03-06 22:45:51', '2018-03-06 22:46:15'),
(207, 'Company/Client Phone Number', 104, 'en', 0, 1, '2018-03-07 21:50:23', '2018-03-07 21:51:13'),
(208, 'কোম্পানী / ক্লায়েন্ট ফোন নম্বর', 104, 'bn', 0, 1, '2018-03-07 21:50:23', '2018-03-07 21:51:13'),
(209, 'Company/Client Address', 105, 'en', 0, 1, '2018-03-07 21:51:29', '2018-03-07 21:51:58'),
(210, 'কোম্পানী / ক্লায়েন্ট ঠিকানা', 105, 'bn', 0, 1, '2018-03-07 21:51:29', '2018-03-07 21:51:58'),
(211, 'Company/Client Description', 106, 'en', 0, 1, '2018-03-07 21:52:22', '2018-03-07 21:52:55'),
(212, 'কোম্পানি / ক্লায়েন্ট বর্ণনা', 106, 'bn', 0, 1, '2018-03-07 21:52:22', '2018-03-07 21:52:55'),
(213, 'Employee Name', 107, 'en', 0, 1, '2018-03-07 23:00:58', '2018-03-07 23:02:22'),
(214, 'কর্মকর্তার নাম', 107, 'bn', 0, 1, '2018-03-07 23:00:58', '2018-03-07 23:02:22'),
(215, 'Personal Phone Number', 108, 'en', 0, 1, '2018-03-07 23:02:33', '2018-03-07 23:03:02'),
(216, 'ব্যক্তিগত ফোন নম্বর', 108, 'bn', 0, 1, '2018-03-07 23:02:33', '2018-03-07 23:03:02'),
(217, 'Employee Address', 109, 'en', 0, 1, '2018-03-07 23:03:16', '2018-03-07 23:03:38'),
(218, 'কর্মচারী ঠিকানা', 109, 'bn', 0, 1, '2018-03-07 23:03:16', '2018-03-07 23:03:38'),
(219, 'Password Confirmation', 110, 'en', 0, 1, '2018-03-07 23:03:52', '2018-03-07 23:04:14'),
(220, 'পাসওয়ার্ড নিশ্চিতকরণ', 110, 'bn', 0, 1, '2018-03-07 23:03:52', '2018-03-07 23:04:14'),
(221, 'Search', 111, 'en', 0, 1, '2018-03-07 23:11:42', '2018-03-07 23:11:59'),
(222, 'অনুসন্ধান', 111, 'bn', 0, 1, '2018-03-07 23:11:43', '2018-03-07 23:11:59'),
(223, 'Company', 112, 'en', 0, 1, '2018-03-07 23:21:05', '2018-03-07 23:21:36'),
(224, 'কোম্পানি', 112, 'bn', 0, 1, '2018-03-07 23:21:05', '2018-03-07 23:21:36'),
(225, 'Add Client/Company', 113, 'en', 0, 1, '2018-03-07 23:52:58', '2018-03-07 23:53:35'),
(226, 'ক্লায়েন্ট / কোম্পানি যোগ করুন', 113, 'bn', 0, 1, '2018-03-07 23:52:58', '2018-03-07 23:53:35'),
(227, 'Update Company/Client', 114, 'en', 0, 1, '2018-03-08 17:19:08', '2018-03-08 17:27:08'),
(228, 'আপডেট কোম্পানী / ক্লায়েন্ট', 114, 'bn', 0, 1, '2018-03-08 17:19:08', '2018-03-08 17:27:08'),
(229, 'Add Packet', 115, 'en', 0, 1, '2018-03-09 17:02:11', '2018-03-09 17:02:56'),
(230, 'প্যাকেট যোগ করুন', 115, 'bn', 0, 1, '2018-03-09 17:02:11', '2018-03-09 17:02:56'),
(231, 'Select Unit', 116, 'en', 0, 1, '2018-03-09 17:04:20', '2018-03-09 17:04:45'),
(232, 'ইউনিট নির্বাচন করুন', 116, 'bn', 0, 1, '2018-03-09 17:04:20', '2018-03-09 17:04:45'),
(233, 'Packet Name', 117, 'en', 0, 1, '2018-03-09 17:06:17', '2018-03-09 17:06:34'),
(234, 'প্যাকেট নাম', 117, 'bn', 0, 1, '2018-03-09 17:06:17', '2018-03-09 17:06:34'),
(235, 'Unit Quantity', 118, 'en', 0, 1, '2018-03-09 17:07:27', '2018-03-09 17:07:48'),
(236, 'একক পরিমাণ', 118, 'bn', 0, 1, '2018-03-09 17:07:27', '2018-03-09 17:07:48'),
(237, 'Update Packet', 119, 'en', 0, 1, '2018-03-09 17:13:42', '2018-03-09 17:14:04'),
(238, 'আপডেট প্যাকেট', 119, 'bn', 0, 1, '2018-03-09 17:13:42', '2018-03-09 17:14:04'),
(239, 'Unit', 120, 'en', 0, 1, '2018-03-09 17:18:32', '2018-03-09 17:18:51'),
(240, 'একক', 120, 'bn', 0, 1, '2018-03-09 17:18:32', '2018-03-09 17:18:51'),
(241, 'Packet List', 121, 'en', 0, 1, '2018-03-09 17:24:19', '2018-03-09 17:24:43'),
(242, 'প্যাকেট তালিকা', 121, 'bn', 0, 1, '2018-03-09 17:24:19', '2018-03-09 17:24:43'),
(243, 'Add new Product', 122, 'en', 0, 1, '2018-03-09 17:52:50', '2018-03-09 17:53:11'),
(244, 'নতুন পণ্য যোগ করুন', 122, 'bn', 0, 1, '2018-03-09 17:52:50', '2018-03-09 17:53:11'),
(245, 'Add Product', 123, 'en', 0, 1, '2018-03-09 17:53:19', '2018-03-09 17:53:41'),
(246, 'পণ্য যোগ করুন', 123, 'bn', 0, 1, '2018-03-09 17:53:19', '2018-03-09 17:53:41'),
(247, 'Packet details', 124, 'en', 0, 1, '2018-03-09 17:56:43', '2018-03-09 17:56:59'),
(248, 'প্যাকেট বিস্তারিত', 124, 'bn', 0, 1, '2018-03-09 17:56:43', '2018-03-09 17:56:59'),
(249, 'Product Code', 125, 'en', 0, 1, '2018-03-09 18:02:50', '2018-03-09 18:03:28'),
(250, 'পণ্য কোড', 125, 'bn', 0, 1, '2018-03-09 18:02:50', '2018-03-09 18:03:28'),
(251, 'Update Product', 126, 'en', 0, 1, '2018-03-09 18:09:32', '2018-03-09 18:10:24'),
(252, 'আপডেট পণ্য', 126, 'bn', 0, 1, '2018-03-09 18:09:33', '2018-03-09 18:10:24'),
(253, 'Edit product', 127, 'en', 0, 1, '2018-03-09 18:10:38', '2018-03-09 18:11:58'),
(254, 'পণ্য সংস্করণ', 127, 'bn', 0, 1, '2018-03-09 18:10:38', '2018-03-09 18:11:58'),
(255, 'Product Group Name', 128, 'en', 0, 1, '2018-03-09 18:26:17', '2018-03-09 18:26:37'),
(256, 'পণ্য গ্রুপ নাম', 128, 'bn', 0, 1, '2018-03-09 18:26:17', '2018-03-09 18:26:37'),
(257, 'Add product group', 129, 'en', 0, 1, '2018-03-09 18:26:52', '2018-03-09 18:27:11'),
(258, 'পণ্য গ্রুপ যোগ করুন', 129, 'bn', 0, 1, '2018-03-09 18:26:52', '2018-03-09 18:27:11'),
(259, 'Add new product group', 130, 'en', 0, 1, '2018-03-09 18:27:22', '2018-03-09 18:27:45'),
(260, 'নতুন পণ্য গ্রুপ যোগ করুন', 130, 'bn', 0, 1, '2018-03-09 18:27:22', '2018-03-09 18:27:45'),
(261, 'Update Product Group', 131, 'en', 0, 1, '2018-03-09 18:34:53', '2018-03-09 18:35:12'),
(262, 'আপডেট পণ্য গ্রুপ', 131, 'bn', 0, 1, '2018-03-09 18:34:53', '2018-03-09 18:35:12'),
(263, 'Edit product group', 132, 'en', 0, 1, '2018-03-09 18:35:57', '2018-03-09 18:36:25'),
(264, 'পণ্য গ্রুপ সম্পাদনা করুন', 132, 'bn', 0, 1, '2018-03-09 18:35:57', '2018-03-09 18:36:25'),
(265, 'Product Group List', 133, 'en', 0, 1, '2018-03-09 18:39:48', '2018-03-09 18:40:05'),
(266, 'পণ্য গ্রুপ তালিকা', 133, 'bn', 0, 1, '2018-03-09 18:39:48', '2018-03-09 18:40:05'),
(267, 'Unit name', 134, 'en', 0, 1, '2018-03-09 19:00:04', '2018-03-09 19:00:25'),
(268, 'ইউনিটের নাম', 134, 'bn', 0, 1, '2018-03-09 19:00:04', '2018-03-09 19:00:25'),
(269, 'Add unit', 135, 'en', 0, 1, '2018-03-09 19:00:51', '2018-03-09 19:01:55'),
(270, 'ইউনিট যোগ করুন', 135, 'bn', 0, 1, '2018-03-09 19:00:51', '2018-03-09 19:01:55'),
(271, 'Add new Unit', 136, 'en', 0, 1, '2018-03-09 19:02:17', '2018-03-09 19:02:40'),
(272, 'নতুন ইউনিট যোগ করুন', 136, 'bn', 0, 1, '2018-03-09 19:02:17', '2018-03-09 19:02:40'),
(273, 'Update Unit', 137, 'en', 0, 1, '2018-03-09 19:04:46', '2018-03-09 19:05:07'),
(274, 'আপডেট ইউনিট', 137, 'bn', 0, 1, '2018-03-09 19:04:46', '2018-03-09 19:05:07'),
(275, 'Edit Unit', 138, 'en', 0, 1, '2018-03-09 19:05:18', '2018-03-09 19:05:36'),
(276, 'ইউনিট সম্পাদনা করুন', 138, 'bn', 0, 1, '2018-03-09 19:05:18', '2018-03-09 19:05:37'),
(277, 'Company Name', 139, 'en', 0, 1, '2018-03-09 19:09:56', '2018-06-21 00:33:35'),
(278, 'কোমপানির নাম', 139, 'bn', 0, 1, '2018-03-09 19:09:56', '2018-06-21 00:33:35'),
(279, 'Add Vat Tax', 140, 'en', 0, 1, '2018-03-09 19:11:03', '2018-03-09 19:11:22'),
(280, 'ভ্যাট ট্যাক্স যোগ করুন', 140, 'bn', 0, 1, '2018-03-09 19:11:03', '2018-03-09 19:11:22'),
(281, 'Select Product', 141, 'en', 0, 1, '2018-03-09 19:13:30', '2018-03-09 19:20:25'),
(282, 'পণ্য নির্বাচন করুন', 141, 'bn', 0, 1, '2018-03-09 19:13:30', '2018-03-09 19:20:25'),
(283, 'Report', 142, 'en', 0, 1, '2018-03-09 19:18:16', '2018-03-09 19:18:36'),
(284, 'প্রতিবেদন', 142, 'bn', 0, 1, '2018-03-09 19:18:16', '2018-03-09 19:18:36'),
(285, 'Available Quantity', 143, 'en', 0, 1, '2018-03-09 19:24:36', '2018-03-09 19:25:10'),
(286, 'উপলব্ধ পরিমাণ', 143, 'bn', 0, 1, '2018-03-09 19:24:36', '2018-03-09 19:25:10'),
(287, 'Sale Quantity', 144, 'en', 0, 1, '2018-03-09 19:25:47', '2018-03-09 19:26:05'),
(288, 'বিক্রয় পরিমাণ', 144, 'bn', 0, 1, '2018-03-09 19:25:47', '2018-03-09 19:26:05'),
(289, 'Total Quantity', 145, 'en', 0, 1, '2018-03-09 19:26:25', '2018-03-09 19:26:44'),
(290, 'মোট পরিমাণ', 145, 'bn', 0, 1, '2018-03-09 19:26:25', '2018-03-09 19:26:44'),
(291, 'Select Invoice', 146, 'en', 0, 1, '2018-03-09 19:44:45', '2018-03-09 19:45:42'),
(292, 'চালান নির্বাচন করুন', 146, 'bn', 0, 1, '2018-03-09 19:44:45', '2018-03-09 19:45:42'),
(293, 'Search date....', 147, 'en', 0, 1, '2018-03-09 19:45:57', '2018-03-09 19:46:17'),
(294, 'তারিখ অনুসন্ধান করুন ....', 147, 'bn', 0, 1, '2018-03-09 19:45:57', '2018-03-09 19:46:17'),
(295, 'Date', 148, 'en', 0, 1, '2018-03-09 19:47:32', '2018-03-09 19:47:48'),
(296, 'তারিখ', 148, 'bn', 0, 1, '2018-03-09 19:47:32', '2018-03-09 19:47:48'),
(297, 'Challan No', 149, 'en', 0, 1, '2018-03-09 19:48:38', '2018-03-09 19:49:45'),
(298, 'চালান নং', 149, 'bn', 0, 1, '2018-03-09 19:48:38', '2018-03-09 19:49:45'),
(299, 'Quantity/Kg', 150, 'en', 0, 1, '2018-03-09 19:50:42', '2018-03-09 19:50:58'),
(300, 'পরিমাণ / কেজি', 150, 'bn', 0, 1, '2018-03-09 19:50:42', '2018-03-09 19:50:58'),
(301, 'Unit Price/Kg', 151, 'en', 0, 1, '2018-03-09 19:51:26', '2018-03-09 19:51:44'),
(302, 'ইউনিট মূল্য / কেজি', 151, 'bn', 0, 1, '2018-03-09 19:51:26', '2018-03-09 19:51:45'),
(303, 'Total Up to Date Amount', 152, 'en', 0, 1, '2018-03-09 19:52:14', '2018-03-09 19:54:53'),
(304, 'সর্বমোট পরিমাণ', 152, 'bn', 0, 1, '2018-03-09 19:52:14', '2018-03-09 19:54:53'),
(305, 'User List', 153, 'en', 0, 1, '2018-03-11 17:00:41', '2018-03-11 17:01:04'),
(306, 'ব্যবহারকারীর তালিকা', 153, 'bn', 0, 1, '2018-03-11 17:00:41', '2018-03-11 17:01:04'),
(307, 'Local purchase', 154, 'en', 0, 1, '2018-03-21 01:37:13', '2018-03-21 01:37:34'),
(308, NULL, 154, 'bn', 0, 1, '2018-03-21 01:37:13', '2018-03-21 01:37:34'),
(309, 'LC Purchase', 155, 'en', 0, 1, '2018-03-21 01:54:39', '2018-03-21 01:55:01'),
(310, NULL, 155, 'bn', 0, 1, '2018-03-21 01:54:39', '2018-03-21 01:55:01'),
(311, 'view result', 156, 'en', 0, 1, '2018-04-02 06:48:56', '2018-04-02 06:49:13'),
(312, NULL, 156, 'bn', 0, 1, '2018-04-02 06:48:57', '2018-04-02 06:49:14'),
(313, 'Management', 157, 'en', 0, 1, '2018-04-10 00:01:48', '2018-04-16 06:00:36'),
(314, 'ম্যানেজমেন্ট', 157, 'bn', 0, 1, '2018-04-10 00:01:48', '2018-04-16 06:00:36'),
(315, 'Product List', 158, 'en', 0, 1, '2018-04-10 00:38:18', '2018-05-03 04:01:02'),
(316, 'পণ্য তালিকা', 158, 'bn', 0, 1, '2018-04-10 00:38:18', '2018-05-03 04:01:02'),
(317, 'Product Description', 159, 'en', 0, 1, '2018-04-10 04:32:01', '2018-05-13 23:26:06'),
(318, 'পণ্যের বর্ণনা', 159, 'bn', 0, 1, '2018-04-10 04:32:01', '2018-05-13 23:26:06'),
(319, 'Brand', 160, 'en', 0, 1, '2018-04-10 04:34:38', '2018-05-13 23:26:45'),
(320, 'তরবার', 160, 'bn', 0, 1, '2018-04-10 04:34:38', '2018-05-13 23:26:45'),
(321, 'ERP Code', 161, 'en', 0, 1, '2018-04-10 04:41:38', '2018-05-13 23:27:40'),
(322, 'ইআরপি কোড', 161, 'bn', 0, 1, '2018-04-10 04:41:38', '2018-05-13 23:27:40'),
(323, 'Unit Price', 162, 'en', 0, 1, '2018-04-10 04:43:37', '2018-05-13 23:28:07'),
(324, 'একক দাম', 162, 'bn', 0, 1, '2018-04-10 04:43:37', '2018-05-13 23:28:07'),
(325, 'Weight Qty', 163, 'en', 0, 1, '2018-04-10 04:46:17', '2018-05-13 23:28:27'),
(326, 'ওজন পরিমাণ', 163, 'bn', 0, 1, '2018-04-10 04:46:18', '2018-05-13 23:28:27'),
(327, 'Weight Amt', 164, 'en', 0, 1, '2018-04-10 04:46:54', '2018-05-13 23:29:01'),
(328, 'ওজন পরিমাণ', 164, 'bn', 0, 1, '2018-04-10 04:46:54', '2018-05-13 23:29:01'),
(329, 'Description 1', 165, 'en', 0, 1, '2018-04-10 04:51:05', '2018-04-10 04:52:20'),
(330, 'বিবরণ 1', 165, 'bn', 0, 1, '2018-04-10 04:51:05', '2018-04-10 04:52:20'),
(331, 'Description 2', 166, 'en', 0, 1, '2018-04-10 04:51:29', '2018-04-10 04:55:18'),
(332, 'বিবরণ 2', 166, 'bn', 0, 1, '2018-04-10 04:51:29', '2018-04-10 04:55:18'),
(333, 'Description 3', 167, 'en', 0, 1, '2018-04-10 04:54:30', '2018-04-10 04:55:30'),
(334, 'বিবরণ 3', 167, 'bn', 0, 1, '2018-04-10 04:54:30', '2018-04-10 04:55:30'),
(335, 'Description 4', 168, 'en', 0, 1, '2018-04-10 04:54:44', '2018-04-10 04:56:56'),
(336, 'বিবরণ 4', 168, 'bn', 0, 1, '2018-04-10 04:54:44', '2018-04-10 04:56:56'),
(337, 'Vendor', 169, 'en', 0, 1, '2018-04-12 00:30:29', '2018-07-09 00:02:01'),
(338, 'বিক্রেতা', 169, 'bn', 0, 1, '2018-04-12 00:30:29', '2018-07-09 00:02:01'),
(339, 'Vendor ID', 170, 'en', 0, 1, '2018-04-12 00:34:45', '2018-07-09 00:31:28'),
(340, 'বিক্রেতা সনাক্তকরন সংখ্যা', 170, 'bn', 0, 1, '2018-04-12 00:34:45', '2018-07-09 00:31:28'),
(341, 'Buyer name', 171, 'en', 0, 1, '2018-04-12 00:35:35', '2018-07-09 00:32:09'),
(342, 'ক্রেতা নাম', 171, 'bn', 0, 1, '2018-04-12 00:35:35', '2018-07-09 00:32:09'),
(343, 'Address -1', 172, 'en', 0, 1, '2018-04-12 00:36:08', '2018-05-11 00:48:16'),
(344, 'ঠিকানা 1', 172, 'bn', 0, 1, '2018-04-12 00:36:08', '2018-05-11 00:48:16'),
(345, 'Address -2', 173, 'en', 0, 1, '2018-04-12 00:37:03', '2018-05-11 00:48:41'),
(346, 'ঠিকানা 2', 173, 'bn', 0, 1, '2018-04-12 00:37:03', '2018-05-11 00:48:41'),
(347, 'Attention', 174, 'en', 0, 1, '2018-04-12 00:38:52', '2018-05-11 00:49:08'),
(348, 'মনোযোগ', 174, 'bn', 0, 1, '2018-04-12 00:38:52', '2018-05-11 00:49:08'),
(349, 'Mobile', 175, 'en', 0, 1, '2018-04-12 00:39:26', '2018-05-11 00:49:33'),
(350, 'মোবাইল', 175, 'bn', 0, 1, '2018-04-12 00:39:26', '2018-05-11 00:49:33'),
(351, 'Telephone', 176, 'en', 0, 1, '2018-04-12 00:40:01', '2018-05-11 00:49:58'),
(352, 'টেলিফোন', 176, 'bn', 0, 1, '2018-04-12 00:40:01', '2018-05-11 00:49:58'),
(353, 'Fax', 177, 'en', 0, 1, '2018-04-12 00:40:51', '2018-05-11 00:50:28'),
(354, 'ফ্যাক্স', 177, 'bn', 0, 1, '2018-04-12 00:40:51', '2018-05-11 00:50:28'),
(355, 'Address -1', 178, 'en', 0, 1, '2018-04-12 00:41:25', '2018-05-11 00:51:57'),
(356, 'ঠিকানা 1', 178, 'bn', 0, 1, '2018-04-12 00:41:25', '2018-05-11 00:51:57'),
(357, 'Address -2', 179, 'en', 0, 1, '2018-04-12 00:41:54', '2018-05-11 00:52:16'),
(358, 'ঠিকানা 2', 179, 'bn', 0, 1, '2018-04-12 00:41:54', '2018-05-11 00:52:17'),
(359, 'Attention', 180, 'en', 0, 1, '2018-04-12 00:42:23', '2018-05-11 00:52:39'),
(360, 'মনোযোগ', 180, 'bn', 0, 1, '2018-04-12 00:42:23', '2018-05-11 00:52:39'),
(361, 'Mobile', 181, 'en', 0, 1, '2018-04-12 00:42:51', '2018-05-11 00:53:11'),
(362, 'মোবাইল', 181, 'bn', 0, 1, '2018-04-12 00:42:51', '2018-05-11 00:53:11'),
(363, 'Telephone', 182, 'en', 0, 1, '2018-04-12 00:43:14', '2018-05-11 00:53:34'),
(364, 'টেলিফোন', 182, 'bn', 0, 1, '2018-04-12 00:43:14', '2018-05-11 00:53:35'),
(365, 'Fax', 183, 'en', 0, 1, '2018-04-12 00:43:40', '2018-05-11 00:54:00'),
(366, 'ফ্যাক্স', 183, 'bn', 0, 1, '2018-04-12 00:43:40', '2018-05-11 00:54:00'),
(367, 'Description -1', 184, 'en', 0, 1, '2018-04-12 00:44:02', '2018-04-12 00:44:17'),
(368, NULL, 184, 'bn', 0, 1, '2018-04-12 00:44:02', '2018-04-12 00:44:17'),
(369, 'Description -2', 185, 'en', 0, 1, '2018-04-12 00:44:29', '2018-04-12 00:44:41'),
(370, NULL, 185, 'bn', 0, 1, '2018-04-12 00:44:29', '2018-04-12 00:44:41'),
(371, 'Description -3', 186, 'en', 0, 1, '2018-04-12 00:44:53', '2018-04-12 00:45:07'),
(372, NULL, 186, 'bn', 0, 1, '2018-04-12 00:44:53', '2018-04-12 00:45:07'),
(373, 'Add vendor', 187, 'en', 0, 1, '2018-04-12 01:09:15', '2018-07-09 00:02:54'),
(374, 'বিক্রেতা যোগ করুন', 187, 'bn', 0, 1, '2018-04-12 01:09:16', '2018-07-09 00:02:55'),
(375, 'Page header', 188, 'en', 0, 1, '2018-04-12 04:03:01', '2018-04-16 05:59:47'),
(376, 'পেজের উপরের অংশ', 188, 'bn', 0, 1, '2018-04-12 04:03:01', '2018-04-16 05:59:47'),
(377, 'Header Title', 189, 'en', 0, 1, '2018-04-12 04:16:18', '2018-05-11 02:33:53'),
(378, 'শিরোলেখ শিরোনাম', 189, 'bn', 0, 1, '2018-04-12 04:16:18', '2018-05-11 02:33:53'),
(379, 'Header font size', 190, 'en', 0, 1, '2018-04-12 04:19:01', '2018-04-12 04:19:22'),
(380, NULL, 190, 'bn', 0, 1, '2018-04-12 04:19:01', '2018-04-12 04:19:22'),
(381, 'Font style', 191, 'en', 0, 1, '2018-04-12 04:21:39', '2018-04-16 06:10:57'),
(382, 'ফন্ট শৈলী', 191, 'bn', 0, 1, '2018-04-12 04:21:39', '2018-04-16 06:10:57'),
(383, 'Header color', 192, 'en', 0, 1, '2018-04-12 04:26:04', '2018-04-12 04:26:12'),
(384, NULL, 192, 'bn', 0, 1, '2018-04-12 04:26:04', '2018-04-12 04:26:12'),
(385, 'Address -1', 193, 'en', 0, 1, '2018-04-12 04:26:24', '2018-04-16 06:15:11'),
(386, 'ঠিকানা 1', 193, 'bn', 0, 1, '2018-04-12 04:26:24', '2018-04-16 06:15:11'),
(387, 'Address -3', 194, 'en', 0, 1, '2018-04-12 04:29:35', '2018-05-10 23:27:52'),
(388, 'ঠিকানা 3', 194, 'bn', 0, 1, '2018-04-12 04:29:35', '2018-05-10 23:27:52'),
(389, 'Header logo aligment', 195, 'en', 0, 1, '2018-04-12 04:30:05', '2018-04-12 04:55:00'),
(390, NULL, 195, 'bn', 0, 1, '2018-04-12 04:30:05', '2018-04-12 04:55:00'),
(391, 'Address -2', 196, 'en', 0, 1, '2018-04-12 04:30:39', '2018-05-10 23:27:38'),
(392, 'ঠিকানা 2', 196, 'bn', 0, 1, '2018-04-12 04:30:39', '2018-05-10 23:27:38'),
(393, 'Logo', 197, 'en', 0, 1, '2018-04-12 04:31:04', '2018-04-16 07:57:34'),
(394, 'লোগো', 197, 'bn', 0, 1, '2018-04-12 04:31:04', '2018-04-16 07:57:34'),
(395, 'Page', 198, 'en', 0, 1, '2018-04-12 05:31:26', '2018-04-16 06:01:07'),
(396, 'পৃষ্ঠা', 198, 'bn', 0, 1, '2018-04-12 05:31:26', '2018-04-16 06:01:07'),
(397, 'Page footer', 199, 'en', 0, 1, '2018-04-12 05:38:56', '2018-05-03 03:59:42'),
(398, 'পৃষ্ঠার পাদলেখ', 199, 'bn', 0, 1, '2018-04-12 05:38:56', '2018-05-03 03:59:43'),
(399, 'Add Page Footer Title', 200, 'en', 0, 1, '2018-04-12 06:07:56', '2018-05-11 02:45:21'),
(400, 'পৃষ্ঠার শিরোনাম শিরোনাম যোগ করুন', 200, 'bn', 0, 1, '2018-04-12 06:07:57', '2018-05-11 02:45:21'),
(401, 'Add a title', 201, 'en', 0, 1, '2018-04-12 06:09:53', '2018-04-12 06:10:06'),
(402, NULL, 201, 'bn', 0, 1, '2018-04-12 06:09:53', '2018-04-12 06:10:06'),
(403, 'Enter footer title', 202, 'en', 0, 0, '2018-04-12 06:10:56', '2018-05-10 23:30:10'),
(404, 'পাদচরণ শিরোনাম লিখুন', 202, 'bn', 0, 0, '2018-04-12 06:10:56', '2018-05-10 23:30:10'),
(405, 'Update footer title', 203, 'en', 0, 1, '2018-04-13 02:05:45', '2018-05-11 02:44:39'),
(406, 'পাদলেখ শিরোনাম আপডেট করুন', 203, 'bn', 0, 1, '2018-04-13 02:05:45', '2018-05-11 02:44:39'),
(407, 'Report footer', 204, 'en', 0, 1, '2018-04-13 02:35:41', '2018-05-03 03:57:07'),
(408, 'পাদটীকা প্রতিবেদন করুন', 204, 'bn', 0, 1, '2018-04-13 02:35:42', '2018-05-03 03:57:07'),
(409, 'Add report', 205, 'en', 0, 1, '2018-04-13 04:43:27', '2018-05-10 23:36:24'),
(410, 'রিপোর্ট যোগ করুন', 205, 'bn', 0, 1, '2018-04-13 04:43:27', '2018-05-10 23:36:24'),
(411, 'Report Name', 206, 'en', 0, 1, '2018-04-13 04:44:39', '2018-04-16 00:13:17'),
(412, 'প্রতিবেদন নাম', 206, 'bn', 0, 1, '2018-04-13 04:44:39', '2018-04-16 00:13:17'),
(413, 'Description -3', 207, 'en', 0, 1, '2018-04-13 04:48:23', '2018-04-13 04:48:33'),
(414, NULL, 207, 'bn', 0, 1, '2018-04-13 04:48:23', '2018-04-13 04:48:33'),
(415, 'Description -1', 208, 'en', 0, 1, '2018-04-13 04:49:10', '2018-04-13 04:49:16'),
(416, NULL, 208, 'bn', 0, 1, '2018-04-13 04:49:10', '2018-04-13 04:49:16'),
(417, 'Description -4', 209, 'en', 0, 1, '2018-04-13 04:50:50', '2018-04-13 04:51:01'),
(418, NULL, 209, 'bn', 0, 1, '2018-04-13 04:50:50', '2018-04-13 04:51:01'),
(419, 'Description -2', 210, 'en', 0, 1, '2018-04-13 04:51:12', '2018-04-13 04:51:19'),
(420, NULL, 210, 'bn', 0, 1, '2018-04-13 04:51:12', '2018-04-13 04:51:19'),
(421, 'Description -5', 211, 'en', 0, 1, '2018-04-13 04:51:28', '2018-04-13 04:51:37'),
(422, NULL, 211, 'bn', 0, 1, '2018-04-13 04:51:29', '2018-04-13 04:51:37'),
(423, 'Sigining Person -1', 212, 'en', 0, 1, '2018-04-13 04:56:18', '2018-04-16 00:15:35'),
(424, 'সাইন ইন ব্যক্তি -1', 212, 'bn', 0, 1, '2018-04-13 04:56:18', '2018-04-16 00:15:35'),
(425, 'Sigining Person -2', 213, 'en', 0, 1, '2018-04-13 04:56:26', '2018-04-16 00:15:43'),
(426, 'সাইন ইন ব্যক্তি -2', 213, 'bn', 0, 1, '2018-04-13 04:56:26', '2018-04-16 00:15:43'),
(427, 'Signature', 214, 'en', 0, 1, '2018-04-13 07:03:30', '2018-04-16 00:14:17'),
(428, 'স্বাক্ষর', 214, 'bn', 0, 1, '2018-04-13 07:03:30', '2018-04-16 00:14:17'),
(429, 'Seal', 215, 'en', 0, 1, '2018-04-13 07:04:58', '2018-04-16 00:13:38'),
(430, 'সীল', 215, 'bn', 0, 1, '2018-04-13 07:04:58', '2018-04-16 00:13:39'),
(431, 'Name', 216, 'en', 0, 1, '2018-04-13 07:26:33', '2018-04-13 07:26:52'),
(432, 'নাম', 216, 'bn', 0, 1, '2018-04-13 07:26:33', '2018-04-13 07:26:52'),
(433, 'Brand List', 217, 'en', 0, 1, '2018-04-16 00:43:54', '2018-04-16 00:44:17'),
(434, 'ব্র্যান্ড তালিকা', 217, 'bn', 0, 1, '2018-04-16 00:43:54', '2018-04-16 00:44:17'),
(435, 'Add Brand', 218, 'en', 0, 1, '2018-04-16 01:36:20', '2018-04-16 01:36:40'),
(436, 'ব্র্যান্ড যোগ করুন', 218, 'bn', 0, 1, '2018-04-16 01:36:20', '2018-04-16 01:36:40'),
(437, 'Brand Name', 219, 'en', 0, 1, '2018-04-16 01:42:14', '2018-04-16 01:42:42'),
(438, 'পরিচিতিমুলক নাম', 219, 'bn', 0, 1, '2018-04-16 01:42:14', '2018-04-16 01:42:42'),
(439, 'Product size list', 220, 'en', 0, 1, '2018-04-16 02:25:24', '2018-06-05 22:35:38'),
(440, 'পণ্য আকার তালিকা', 220, 'bn', 0, 1, '2018-04-16 02:25:24', '2018-06-05 22:35:38'),
(441, 'Add Product Size', 221, 'en', 0, 1, '2018-04-16 04:19:18', '2018-04-16 04:19:42'),
(442, 'পণ্য আকার যোগ করুন', 221, 'bn', 0, 1, '2018-04-16 04:19:18', '2018-04-16 04:19:42'),
(443, 'Size', 222, 'en', 0, 1, '2018-04-16 04:21:37', '2018-04-16 04:21:56'),
(444, 'আয়তন', 222, 'bn', 0, 1, '2018-04-16 04:21:37', '2018-04-16 04:21:56'),
(445, 'Add Size', 223, 'en', 0, 1, '2018-04-16 04:23:26', '2018-04-16 04:23:47'),
(446, 'আকার জুড়ুন', 223, 'bn', 0, 1, '2018-04-16 04:23:26', '2018-04-16 04:23:47'),
(447, 'Font Size', 224, 'en', 0, 1, '2018-04-16 06:09:18', '2018-04-16 06:09:53'),
(448, 'অক্ষরের আকার', 224, 'bn', 0, 1, '2018-04-16 06:09:18', '2018-04-16 06:09:54'),
(449, 'Font Color', 225, 'en', 0, 1, '2018-04-16 06:11:24', '2018-04-16 06:12:18'),
(450, 'ফন্টের রং', 225, 'bn', 0, 1, '2018-04-16 06:11:24', '2018-04-16 06:12:19'),
(451, 'Logo Alignment', 226, 'en', 0, 1, '2018-04-16 06:12:38', '2018-04-17 02:22:44'),
(452, 'লোগো সংলগ্ন', 226, 'bn', 0, 1, '2018-04-16 06:12:38', '2018-04-17 02:22:44'),
(453, 'Print file', 227, 'en', 0, 1, '2018-04-17 05:31:18', '2018-04-17 05:31:50'),
(454, 'মুদ্রণ ফাইল', 227, 'bn', 0, 1, '2018-04-17 05:31:18', '2018-04-17 05:31:50'),
(455, 'Order Entry', 228, 'en', 0, 1, '2018-04-17 05:32:54', '2018-05-09 04:24:57'),
(456, 'অর্ডার এন্ট্রি', 228, 'bn', 0, 1, '2018-04-17 05:32:54', '2018-05-09 04:24:57'),
(457, 'Search bill', 229, 'en', 0, 1, '2018-04-25 22:24:36', '2018-05-03 00:39:41'),
(458, 'অনুসন্ধান বিল', 229, 'bn', 0, 1, '2018-04-25 22:24:36', '2018-05-03 00:39:41'),
(459, 'Search bill', 230, 'en', 0, 1, '2018-05-03 00:37:53', '2018-05-03 00:42:01'),
(460, 'অনুসন্ধান বিল', 230, 'bn', 0, 1, '2018-05-03 00:37:53', '2018-05-03 00:42:01'),
(461, 'Invo No', 231, 'en', 0, 1, '2018-05-03 00:43:16', '2018-05-03 00:45:04'),
(462, 'ইনভো সংখ্যা', 231, 'bn', 0, 1, '2018-05-03 00:43:16', '2018-05-03 00:45:04'),
(463, 'Search', 232, 'en', 0, 1, '2018-05-03 02:54:24', '2018-05-03 02:54:42'),
(464, 'অনুসন্ধান', 232, 'bn', 0, 1, '2018-05-03 02:54:24', '2018-05-03 02:54:42'),
(465, 'Genarate', 233, 'en', 0, 1, '2018-05-03 02:59:29', '2018-05-03 03:00:12'),
(466, 'জেনারেট করুন', 233, 'bn', 0, 1, '2018-05-03 02:59:29', '2018-05-03 03:00:12'),
(467, 'New Challan Create', 234, 'en', 0, 1, '2018-05-03 03:48:13', '2018-05-07 00:29:58'),
(468, 'নতুন চালান তৈরি করুন', 234, 'bn', 0, 1, '2018-05-03 03:48:13', '2018-05-07 00:29:58'),
(469, 'Challan Search', 235, 'en', 0, 1, '2018-05-06 23:53:37', '2018-05-06 23:56:13'),
(470, 'চালান অনুসন্ধান', 235, 'bn', 0, 1, '2018-05-06 23:53:37', '2018-05-06 23:56:13'),
(471, 'Challan No', 236, 'en', 0, 1, '2018-05-06 23:58:00', '2018-05-07 00:01:36'),
(472, 'চালান সংখ্যা', 236, 'bn', 0, 1, '2018-05-06 23:58:00', '2018-05-07 00:01:36'),
(473, 'Order List', 237, 'en', 0, 1, '2018-05-07 00:53:50', '2018-05-07 00:54:20'),
(474, 'অর্ডার তালিকা', 237, 'bn', 0, 1, '2018-05-07 00:53:50', '2018-05-07 00:54:20'),
(475, 'Order List', 238, 'en', 0, 1, '2018-05-07 01:00:57', '2018-05-07 01:01:34'),
(476, 'অর্ডার তালিকা', 238, 'bn', 0, 1, '2018-05-07 01:00:57', '2018-05-07 01:01:34'),
(477, 'Create IPO', 239, 'en', 0, 1, '2018-05-07 01:58:13', '2018-05-07 01:59:32'),
(478, 'আইপিও তৈরি করুন', 239, 'bn', 0, 1, '2018-05-07 01:58:13', '2018-05-07 01:59:32'),
(479, 'Initial Increase', 240, 'en', 0, 1, '2018-05-07 02:01:49', '2018-05-07 02:02:28'),
(480, 'প্রাথমিক বৃদ্ধি', 240, 'bn', 0, 1, '2018-05-07 02:01:49', '2018-05-07 02:02:28'),
(481, 'Update Header', 241, 'en', 0, 1, '2018-05-10 03:00:27', '2018-05-10 03:01:24'),
(482, 'হেডার আপডেট করুন', 241, 'bn', 0, 1, '2018-05-10 03:00:27', '2018-05-10 03:01:25'),
(483, 'Report footer list', 242, 'en', 0, 1, '2018-05-10 23:31:45', '2018-05-10 23:32:22'),
(484, 'পাদলেখ তালিকাটি প্রতিবেদন করুন', 242, 'bn', 0, 1, '2018-05-10 23:31:46', '2018-05-10 23:32:22'),
(485, 'Update report', 243, 'en', 0, 1, '2018-05-10 23:37:20', '2018-05-10 23:37:48'),
(486, 'আপডেট রিপোর্ট', 243, 'bn', 0, 1, '2018-05-10 23:37:20', '2018-05-10 23:37:48'),
(487, 'Update brand', 244, 'en', 0, 1, '2018-05-11 00:34:47', '2018-05-11 00:36:44'),
(488, 'ব্র্যান্ড আপডেট করুন', 244, 'bn', 0, 1, '2018-05-11 00:34:47', '2018-05-11 00:36:45'),
(489, 'Brand List', 245, 'en', 0, 1, '2018-05-11 00:37:57', '2018-05-11 00:38:16'),
(490, 'ব্র্যান্ড তালিকা', 245, 'bn', 0, 1, '2018-05-11 00:37:57', '2018-05-11 00:38:16'),
(491, 'Vendor List', 246, 'en', 0, 1, '2018-05-11 00:41:44', '2018-07-09 00:03:52'),
(492, 'বিক্রেতা তালিকা', 246, 'bn', 0, 1, '2018-05-11 00:41:44', '2018-07-09 00:03:52'),
(493, 'Status', 247, 'en', 0, 1, '2018-05-11 00:45:50', '2018-05-11 00:46:05'),
(494, 'অবস্থা', 247, 'bn', 0, 1, '2018-05-11 00:45:50', '2018-05-11 00:46:05'),
(495, 'Invoice', 248, 'en', 0, 1, '2018-05-11 00:46:18', '2018-05-11 00:46:37'),
(496, 'চালান', 248, 'bn', 0, 1, '2018-05-11 00:46:18', '2018-05-11 00:46:37'),
(497, 'Shipment', 249, 'en', 0, 1, '2018-05-11 00:46:44', '2018-07-09 00:15:26'),
(498, 'Shipment', 249, 'bn', 0, 1, '2018-05-11 00:46:45', '2018-07-09 00:15:27'),
(499, 'Company Sort name', 250, 'en', 0, 1, '2018-05-11 00:55:04', '2018-06-21 00:34:12'),
(500, 'কোম্পানি সাজানোর নাম', 250, 'bn', 0, 1, '2018-05-11 00:55:05', '2018-06-21 00:34:12'),
(501, 'Header list', 251, 'en', 0, 1, '2018-05-11 02:29:51', '2018-05-11 02:30:16'),
(502, 'শিরোনাম তালিকা', 251, 'bn', 0, 1, '2018-05-11 02:29:51', '2018-05-11 02:30:16'),
(503, 'Add header', 252, 'en', 0, 1, '2018-05-11 02:31:28', '2018-05-11 02:31:43'),
(504, 'শিরোলেখ যোগ করুন', 252, 'bn', 0, 1, '2018-05-11 02:31:28', '2018-05-11 02:31:43'),
(505, 'Address', 253, 'en', 0, 1, '2018-05-11 02:40:55', '2018-05-11 02:41:13'),
(506, 'ঠিকানা', 253, 'bn', 0, 1, '2018-05-11 02:40:55', '2018-05-11 02:41:13'),
(507, 'Footer Title', 254, 'en', 0, 1, '2018-05-11 02:43:38', '2018-05-11 02:43:55'),
(508, 'পাদটীকা শিরোনাম', 254, 'bn', 0, 1, '2018-05-11 02:43:38', '2018-05-11 02:43:55'),
(509, 'Update party', 255, 'en', 0, 1, '2018-05-11 02:47:49', '2018-05-11 02:48:07'),
(510, 'পার্টি আপডেট করুন', 255, 'bn', 0, 1, '2018-05-11 02:47:49', '2018-05-11 02:48:07'),
(511, 'Product List', 256, 'en', 0, 1, '2018-05-11 02:49:33', '2018-05-11 02:49:52'),
(512, 'পণ্য তালিকা', 256, 'bn', 0, 1, '2018-05-11 02:49:33', '2018-05-11 02:49:52'),
(513, 'Product size list', 257, 'en', 0, 1, '2018-05-13 23:30:27', '2018-05-13 23:30:45'),
(514, 'পণ্য আকার তালিকা', 257, 'bn', 0, 1, '2018-05-13 23:30:27', '2018-05-13 23:30:45'),
(515, 'Order Input', 258, 'en', 0, 1, '2018-05-16 00:09:31', '2018-05-16 00:10:04'),
(516, 'অর্ডার ইনপুট', 258, 'bn', 0, 1, '2018-05-16 00:09:31', '2018-05-16 00:10:04'),
(517, 'Task', 259, 'en', 0, 1, '2018-06-05 22:36:08', '2018-06-05 22:36:37'),
(518, 'কার্য', 259, 'bn', 0, 1, '2018-06-05 22:36:08', '2018-06-05 22:36:37'),
(519, 'GMTS color', 260, 'en', 0, 1, '2018-06-05 23:27:03', '2018-06-05 23:27:44'),
(520, 'জিএমএসএস রং', 260, 'bn', 0, 1, '2018-06-05 23:27:03', '2018-06-05 23:27:44'),
(521, 'GMTS Color List', 261, 'en', 0, 1, '2018-06-05 23:34:38', '2018-06-05 23:35:46'),
(522, 'জিএমএসএস রঙ তালিকা', 261, 'bn', 0, 1, '2018-06-05 23:34:38', '2018-06-05 23:35:46'),
(523, 'Add Color', 262, 'en', 0, 1, '2018-06-05 23:42:36', '2018-06-05 23:42:54'),
(524, 'রঙ যোগ করুন', 262, 'bn', 0, 1, '2018-06-05 23:42:36', '2018-06-05 23:42:54'),
(525, 'Add GMTS Color', 263, 'en', 0, 1, '2018-06-05 23:54:08', '2018-06-05 23:54:37'),
(526, 'GMTS রঙ যোগ করুন', 263, 'bn', 0, 1, '2018-06-05 23:54:08', '2018-06-05 23:54:37'),
(527, 'Color', 264, 'en', 0, 1, '2018-06-06 01:57:57', '2018-06-06 01:58:08'),
(528, 'Color', 264, 'bn', 0, 1, '2018-06-06 01:57:57', '2018-06-06 01:58:08'),
(529, 'Update GMTS color', 265, 'en', 0, 1, '2018-06-06 02:33:37', '2018-06-06 02:34:02'),
(530, 'আপডেট GMTS রঙ', 265, 'bn', 0, 1, '2018-06-06 02:33:37', '2018-06-06 02:34:02'),
(531, 'Update color', 266, 'en', 0, 1, '2018-06-06 02:34:28', '2018-06-06 02:34:49'),
(532, 'রঙ আপডেট করুন', 266, 'bn', 0, 1, '2018-06-06 02:34:28', '2018-06-06 02:34:49'),
(533, 'Header Type', 267, 'en', 0, 1, '2018-06-08 02:58:26', '2018-06-08 02:58:49'),
(534, 'শিরোলেখ প্রকার', 267, 'bn', 0, 1, '2018-06-08 02:58:26', '2018-06-08 02:58:49'),
(535, 'Cell Number', 268, 'en', 0, 1, '2018-06-08 03:06:08', '2018-06-08 03:06:29'),
(536, 'সেল নম্বর', 268, 'bn', 0, 1, '2018-06-08 03:06:08', '2018-06-08 03:06:29'),
(537, 'Attention', 269, 'en', 0, 1, '2018-06-08 03:06:38', '2018-06-08 03:07:02'),
(538, 'মনোযোগ', 269, 'bn', 0, 1, '2018-06-08 03:06:38', '2018-06-08 03:07:02'),
(539, 'Production', 270, 'en', 0, 1, '2018-06-20 06:29:05', '2018-06-20 06:29:17'),
(540, 'Production', 270, 'bn', 0, 1, '2018-06-20 06:29:05', '2018-06-20 06:29:17'),
(541, 'Booking List', 271, 'en', 0, 1, '2018-06-20 06:29:40', '2018-06-20 06:29:51'),
(542, 'Booking List', 271, 'bn', 0, 1, '2018-06-20 06:29:40', '2018-06-20 06:29:51'),
(543, 'Booking List', 272, 'en', 0, 1, '2018-06-21 04:07:20', '2018-06-21 04:07:35'),
(544, 'Booking List', 272, 'bn', 0, 1, '2018-06-21 04:07:20', '2018-06-21 04:07:35');

-- --------------------------------------------------------

--
-- Table structure for table `mxp_translation_keys`
--

CREATE TABLE `mxp_translation_keys` (
  `translation_key_id` int(10) UNSIGNED NOT NULL,
  `is_active` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `translation_key` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mxp_translation_keys`
--

INSERT INTO `mxp_translation_keys` (`translation_key_id`, `is_active`, `created_at`, `updated_at`, `translation_key`) VALUES
(1, 1, '2018-03-05 18:12:49', '2018-03-05 18:12:49', 'company_name'),
(2, 1, '2018-03-05 20:38:51', '2018-03-05 20:38:51', 'login_label'),
(3, 1, '2018-03-05 20:39:27', '2018-03-05 20:39:27', 'register_label'),
(4, 1, '2018-03-05 20:54:56', '2018-03-05 20:54:56', 'validationerror_woops'),
(5, 1, '2018-03-05 20:56:52', '2018-03-05 20:56:52', 'validationerror_there_were_some_problems_with_your_input'),
(6, 1, '2018-03-05 20:57:04', '2018-03-05 20:57:04', 'validationerror_or_you_are_not_active_yet'),
(7, 1, '2018-03-05 20:57:14', '2018-03-05 20:57:14', 'enter_email_address'),
(8, 1, '2018-03-05 20:57:22', '2018-03-05 20:57:22', 'enter_password'),
(9, 1, '2018-03-05 20:57:31', '2018-03-05 20:57:31', 'login_rememberme_label'),
(10, 1, '2018-03-05 20:57:39', '2018-03-05 20:57:39', 'forgot_your_password'),
(11, 1, '2018-03-05 23:23:50', '2018-03-05 23:23:50', 'dashboard_label'),
(12, 1, '2018-03-05 23:34:35', '2018-03-05 23:34:35', 'language_list_label'),
(13, 1, '2018-03-05 23:36:43', '2018-03-05 23:36:43', 'serial_no_label'),
(14, 1, '2018-03-05 23:38:13', '2018-03-05 23:38:13', 'language_title_label'),
(15, 1, '2018-03-05 23:38:47', '2018-03-05 23:38:47', 'language_code_label'),
(16, 1, '2018-03-05 23:39:23', '2018-03-05 23:39:23', 'status_label'),
(17, 1, '2018-03-05 23:40:40', '2018-03-05 23:40:40', 'action_label'),
(18, 1, '2018-03-05 23:43:00', '2018-03-05 23:43:00', 'action_active_label'),
(19, 1, '2018-03-05 23:43:47', '2018-03-05 23:43:47', 'action_inactive_label'),
(20, 1, '2018-03-05 23:58:03', '2018-03-05 23:58:03', 'add_locale_button'),
(21, 1, '2018-03-06 00:00:03', '2018-03-06 00:00:03', 'edit_button'),
(22, 1, '2018-03-06 00:14:26', '2018-03-06 00:14:26', 'add_new_language_label'),
(23, 1, '2018-03-06 00:15:45', '2018-03-06 00:15:45', 'add_language_label'),
(24, 1, '2018-03-06 00:16:49', '2018-03-06 00:16:49', 'enter_language_title'),
(25, 1, '2018-03-06 00:17:31', '2018-03-06 00:17:31', 'enter_language_code'),
(26, 1, '2018-03-06 00:18:57', '2018-03-06 00:18:57', 'save_button'),
(27, 1, '2018-03-06 00:23:12', '2018-03-06 00:23:12', 'update_locale_label'),
(28, 1, '2018-03-06 00:28:35', '2018-03-06 00:28:35', 'update_language_title'),
(29, 1, '2018-03-06 00:29:32', '2018-03-06 00:29:32', 'update_language_code'),
(30, 1, '2018-03-06 00:30:07', '2018-03-06 00:30:07', 'update_button'),
(31, 1, '2018-03-06 00:32:05', '2018-03-06 00:32:05', 'update_language_label'),
(32, 1, '2018-03-06 00:34:41', '2018-03-06 00:34:41', 'mxp_upload_file_rechecking_label'),
(33, 1, '2018-03-06 00:36:42', '2018-03-06 00:36:42', 'upload_button'),
(34, 1, '2018-03-06 00:39:26', '2018-03-06 00:39:26', 'translation_list_label'),
(35, 1, '2018-03-06 00:49:29', '2018-03-06 00:49:29', 'add_new_key_label'),
(36, 1, '2018-03-06 00:51:16', '2018-03-06 00:51:16', 'search_the_translation_key_placeholder'),
(37, 1, '2018-03-06 00:52:45', '2018-03-06 00:52:45', 'translation_key_label'),
(38, 1, '2018-03-06 00:54:31', '2018-03-06 00:54:31', 'translation_label'),
(39, 1, '2018-03-06 00:55:21', '2018-03-06 00:55:21', 'language_label'),
(40, 1, '2018-03-06 00:56:29', '2018-03-06 00:56:29', 'delete_button'),
(41, 1, '2018-03-06 01:07:29', '2018-03-06 01:07:29', 'add_new_translation_key_label'),
(42, 1, '2018-03-06 01:08:20', '2018-03-06 01:08:20', 'enter_translation_key'),
(43, 1, '2018-03-06 01:18:54', '2018-03-06 01:18:54', 'update_translation_label'),
(44, 1, '2018-03-06 01:19:50', '2018-03-06 01:19:50', 'update_translation_key_label'),
(45, 1, '2018-03-06 19:21:58', '2018-03-06 19:21:58', 'mxp_menu_language'),
(46, 1, '2018-03-06 19:23:15', '2018-03-06 19:23:15', 'mxp_menu_manage_langulage'),
(47, 1, '2018-03-06 19:24:37', '2018-03-06 19:24:37', 'mxp_menu_manage_translation'),
(48, 1, '2018-03-06 19:25:41', '2018-03-06 19:25:41', 'mxp_menu_upload_language_file'),
(49, 1, '2018-03-06 19:26:59', '2018-03-06 19:26:59', 'mxp_menu_role'),
(50, 1, '2018-03-06 19:28:03', '2018-03-06 19:28:03', 'mxp_menu_add_new_role'),
(51, 1, '2018-03-06 19:30:11', '2018-03-06 19:30:11', 'mxp_menu_role_list'),
(52, 1, '2018-03-06 19:30:45', '2018-03-06 19:30:45', 'mxp_menu_role_permission_'),
(53, 1, '2018-03-06 19:31:22', '2018-03-06 19:31:22', 'mxp_menu_settings'),
(54, 1, '2018-03-06 19:32:15', '2018-03-06 19:32:15', 'mxp_menu_open_company_acc'),
(55, 1, '2018-03-06 19:34:19', '2018-03-06 19:34:19', 'mxp_menu_company_list'),
(56, 1, '2018-03-06 19:34:56', '2018-03-06 19:34:56', 'mxp_menu_open_company_account'),
(57, 1, '2018-03-06 19:36:15', '2018-03-06 19:36:15', 'mxp_menu_create_user'),
(58, 1, '2018-03-06 19:39:56', '2018-03-06 19:39:56', 'mxp_menu_user_list'),
(59, 1, '2018-03-06 19:40:33', '2018-03-06 19:40:33', 'mxp_menu_client_list'),
(60, 1, '2018-03-06 19:41:56', '2018-03-06 19:41:56', 'mxp_menu_product'),
(61, 1, '2018-03-06 19:42:32', '2018-03-06 19:42:32', 'mxp_menu_unit'),
(62, 1, '2018-03-06 19:48:24', '2018-03-06 19:48:24', 'mxp_menu_product_group'),
(63, 1, '2018-03-06 19:49:03', '2018-03-06 19:49:03', 'mxp_menu_product_entry'),
(64, 1, '2018-03-06 19:50:09', '2018-03-06 19:50:09', 'mxp_menu_product_packing'),
(65, 1, '2018-03-06 19:50:54', '2018-03-06 19:50:54', 'mxp_menu_purchase'),
(66, 1, '2018-03-06 19:51:47', '2018-03-06 19:51:47', 'mxp_menu_purchase_list'),
(67, 1, '2018-03-06 19:52:27', '2018-03-06 19:52:27', 'mxp_menu_update_stocks_action'),
(68, 1, '2018-03-06 19:53:48', '2018-03-06 19:53:48', 'mxp_menu_vat_tax_list'),
(69, 1, '2018-03-06 19:54:25', '2018-03-06 19:54:25', 'mxp_menu_sale_list'),
(70, 1, '2018-03-06 19:55:15', '2018-03-06 19:55:15', 'mxp_menu_save_sale_'),
(71, 1, '2018-03-06 19:56:45', '2018-03-06 19:56:45', 'mxp_menu_inventory_report'),
(72, 1, '2018-03-06 19:57:21', '2018-03-06 19:57:21', 'mxp_menu_stock_management'),
(73, 1, '2018-03-06 19:58:01', '2018-03-06 19:58:01', 'mxp_menu_store'),
(74, 1, '2018-03-06 19:58:53', '2018-03-06 19:58:53', 'mxp_menu_stock'),
(76, 1, '2018-03-06 20:57:06', '2018-03-06 20:57:06', 'company_name_label'),
(77, 1, '2018-03-06 21:05:38', '2018-03-06 21:05:38', 'role_name_placeholder'),
(78, 1, '2018-03-06 21:06:59', '2018-03-06 21:06:59', 'select_company_option_label'),
(79, 1, '2018-03-06 21:08:51', '2018-03-06 21:08:51', 'select_role_option_label'),
(80, 1, '2018-03-06 21:11:57', '2018-03-06 21:11:57', 'select_all_label'),
(81, 1, '2018-03-06 21:12:36', '2018-03-06 21:12:36', 'unselect_all_label'),
(82, 1, '2018-03-06 21:14:03', '2018-03-06 21:14:03', 'set_button'),
(83, 1, '2018-03-06 21:15:41', '2018-03-06 21:15:41', 'heading_role_assign_label'),
(84, 1, '2018-03-06 21:19:23', '2018-03-06 21:19:23', 'heading_role_permission_list_label'),
(85, 1, '2018-03-06 21:19:57', '2018-03-06 21:19:57', 'option_permitted_route_list_label'),
(86, 1, '2018-03-06 21:36:58', '2018-03-06 21:36:58', 'heading_update_role_label'),
(87, 1, '2018-03-06 22:00:58', '2018-03-06 22:00:58', 'heading_add_stock_label'),
(88, 1, '2018-03-06 22:01:41', '2018-03-06 22:01:41', 'product_name_label'),
(89, 1, '2018-03-06 22:02:40', '2018-03-06 22:02:40', 'product_group_label'),
(90, 1, '2018-03-06 22:03:37', '2018-03-06 22:03:37', 'quantity_label'),
(91, 1, '2018-03-06 22:04:43', '2018-03-06 22:04:43', 'option_select_location_label'),
(94, 1, '2018-03-06 22:21:41', '2018-03-06 22:21:41', 'heading_add_new_stock_label'),
(95, 1, '2018-03-06 22:22:14', '2018-03-06 22:22:14', 'add_stock_label'),
(96, 1, '2018-03-06 22:23:21', '2018-03-06 22:23:21', 'enter_store_name_label'),
(97, 1, '2018-03-06 22:23:51', '2018-03-06 22:23:51', 'enter_store_location_label'),
(98, 1, '2018-03-06 22:27:47', '2018-03-06 22:27:47', 'heading_update_store_label'),
(100, 1, '2018-03-06 22:34:46', '2018-03-06 22:34:46', 'heading_store_list_label'),
(101, 1, '2018-03-06 22:36:32', '2018-03-06 22:36:32', 'store_name_label'),
(102, 1, '2018-03-06 22:37:36', '2018-03-06 22:37:36', 'store_location_label'),
(103, 1, '2018-03-06 22:45:51', '2018-03-06 22:45:51', 'list_of_responsible_person_label'),
(104, 1, '2018-03-07 21:50:23', '2018-03-07 21:50:23', 'company_phone_number_label'),
(105, 1, '2018-03-07 21:51:29', '2018-03-07 21:51:29', 'company_address_label'),
(106, 1, '2018-03-07 21:52:22', '2018-03-07 21:52:22', 'company_description_label'),
(107, 1, '2018-03-07 23:00:57', '2018-03-07 23:00:57', 'employee_name_label'),
(108, 1, '2018-03-07 23:02:33', '2018-03-07 23:02:33', 'personal_phone_number_label'),
(109, 1, '2018-03-07 23:03:16', '2018-03-07 23:03:16', 'employee_address_label'),
(110, 1, '2018-03-07 23:03:52', '2018-03-07 23:03:52', 'password_confirmation_label'),
(111, 1, '2018-03-07 23:11:42', '2018-03-07 23:11:42', 'search_placeholder'),
(112, 1, '2018-03-07 23:21:05', '2018-03-07 23:21:05', 'company_label'),
(113, 1, '2018-03-07 23:52:58', '2018-03-07 23:52:58', 'add_company_label'),
(114, 1, '2018-03-08 17:19:08', '2018-03-08 17:19:08', 'update_company_button'),
(115, 1, '2018-03-09 17:02:10', '2018-03-09 17:02:10', 'add_packet_button'),
(116, 1, '2018-03-09 17:04:20', '2018-03-09 17:04:20', 'option_select_unit_label'),
(117, 1, '2018-03-09 17:06:17', '2018-03-09 17:06:17', 'packet_name_label'),
(118, 1, '2018-03-09 17:07:27', '2018-03-09 17:07:27', 'unit_quantity_label'),
(119, 1, '2018-03-09 17:13:41', '2018-03-09 17:13:41', 'update_packet_button'),
(120, 1, '2018-03-09 17:18:32', '2018-03-09 17:18:32', 'unit_label'),
(121, 1, '2018-03-09 17:24:19', '2018-03-09 17:24:19', 'heading_packet_list'),
(122, 1, '2018-03-09 17:52:50', '2018-03-09 17:52:50', 'heading_add_new_packet_label'),
(123, 1, '2018-03-09 17:53:19', '2018-03-09 17:53:19', 'add_packet_label'),
(124, 1, '2018-03-09 17:56:43', '2018-03-09 17:56:43', 'packet_details_label'),
(125, 1, '2018-03-09 18:02:50', '2018-03-09 18:02:50', 'product_code_label'),
(126, 1, '2018-03-09 18:09:32', '2018-03-09 18:09:32', 'heading_update_product_label'),
(127, 1, '2018-03-09 18:10:38', '2018-03-09 18:10:38', 'edit_product_label'),
(128, 1, '2018-03-09 18:26:17', '2018-03-09 18:26:17', 'product_group_name_label'),
(129, 1, '2018-03-09 18:26:52', '2018-03-09 18:26:52', 'add_product_group_label'),
(130, 1, '2018-03-09 18:27:22', '2018-03-09 18:27:22', 'add_new_product_group_label'),
(131, 1, '2018-03-09 18:34:53', '2018-03-09 18:34:53', 'edit_new_product_group_label'),
(132, 1, '2018-03-09 18:35:57', '2018-03-09 18:35:57', 'edit_product_group_label'),
(133, 1, '2018-03-09 18:39:48', '2018-03-09 18:39:48', 'heading_product_group_list_label'),
(134, 1, '2018-03-09 19:00:04', '2018-03-09 19:00:04', 'unit_name_label'),
(135, 1, '2018-03-09 19:00:51', '2018-03-09 19:00:51', 'add_unit_label'),
(136, 1, '2018-03-09 19:02:17', '2018-03-09 19:02:17', 'add_new_unit_label'),
(137, 1, '2018-03-09 19:04:46', '2018-03-09 19:04:46', 'update_unit_label'),
(138, 1, '2018-03-09 19:05:17', '2018-03-09 19:05:17', 'edit_unit_label'),
(139, 1, '2018-03-09 19:09:55', '2018-03-09 19:09:55', 'party_name_label'),
(140, 1, '2018-03-09 19:11:03', '2018-03-09 19:11:03', 'add_vat_tax_label'),
(141, 1, '2018-03-09 19:13:30', '2018-03-09 19:13:30', 'option_select_product_label'),
(142, 1, '2018-03-09 19:18:16', '2018-03-09 19:18:16', 'heading_report_label'),
(143, 1, '2018-03-09 19:24:36', '2018-03-09 19:24:36', 'available_quantity_label'),
(144, 1, '2018-03-09 19:25:47', '2018-03-09 19:25:47', 'sale_quantity_label'),
(145, 1, '2018-03-09 19:26:25', '2018-03-09 19:26:25', 'total_quantity_label'),
(146, 1, '2018-03-09 19:44:45', '2018-03-09 19:44:45', 'option_select_invoice_label'),
(147, 1, '2018-03-09 19:45:57', '2018-03-09 19:45:57', 'search_date_placeholder'),
(148, 1, '2018-03-09 19:47:32', '2018-03-09 19:47:32', 'date_label'),
(149, 1, '2018-03-09 19:48:38', '2018-03-09 19:48:38', 'invoice_no_label'),
(150, 1, '2018-03-09 19:50:42', '2018-03-09 19:50:42', 'quantity_per_kg_label'),
(151, 1, '2018-03-09 19:51:26', '2018-03-09 19:51:26', 'unit_price_per_kg_label'),
(152, 1, '2018-03-09 19:52:14', '2018-03-09 19:52:14', 'total_uptodate_quantity_label'),
(153, 1, '2018-03-11 17:00:41', '2018-03-11 17:00:41', 'heading_user_list_label'),
(154, 1, '2018-03-21 01:37:13', '2018-03-21 01:37:13', 'mxp_menu_local_purchase'),
(155, 1, '2018-03-21 01:54:39', '2018-03-21 01:54:39', 'mxp_menu_lc_purchase'),
(156, 1, '2018-04-02 06:48:56', '2018-04-02 06:48:56', 'mxp_view_btn'),
(157, 1, '2018-04-10 00:01:48', '2018-04-10 00:01:48', 'mxp_menu_management'),
(158, 1, '2018-04-10 00:38:18', '2018-04-10 00:38:18', 'mxp_menu_product_list'),
(159, 1, '2018-04-10 04:32:01', '2018-04-10 04:32:01', 'product_description_label'),
(160, 1, '2018-04-10 04:34:38', '2018-04-10 04:34:38', 'product_brand_label'),
(161, 1, '2018-04-10 04:41:38', '2018-04-10 04:41:38', 'product_erp_code_label'),
(162, 1, '2018-04-10 04:43:37', '2018-04-10 04:43:37', 'product_unit_price_label'),
(163, 1, '2018-04-10 04:46:17', '2018-04-10 04:46:17', 'product_weight_qty_label'),
(164, 1, '2018-04-10 04:46:54', '2018-04-10 04:46:54', 'product_weight_amt_label'),
(165, 1, '2018-04-10 04:51:05', '2018-04-10 04:51:05', 'product_description1_label'),
(166, 1, '2018-04-10 04:51:29', '2018-04-10 04:51:29', 'product_description2_label'),
(167, 1, '2018-04-10 04:54:29', '2018-04-10 04:54:29', 'product_description3_label'),
(168, 1, '2018-04-10 04:54:44', '2018-04-10 04:54:44', 'product_description4_label'),
(169, 1, '2018-04-12 00:30:29', '2018-04-12 00:30:29', 'mxp_menu_party_list'),
(170, 1, '2018-04-12 00:34:45', '2018-04-12 00:34:45', 'party_id_label'),
(171, 1, '2018-04-12 00:35:35', '2018-04-12 00:35:35', 'name_buyer_label'),
(172, 1, '2018-04-12 00:36:08', '2018-04-12 00:36:08', 'address_part_1_invoice_label'),
(173, 1, '2018-04-12 00:37:02', '2018-04-12 00:37:02', 'address_part_2_invoice_label'),
(174, 1, '2018-04-12 00:38:52', '2018-04-12 00:38:52', 'attention_invoice_label'),
(175, 1, '2018-04-12 00:39:26', '2018-04-12 00:39:26', 'mobile_invoice_label'),
(176, 1, '2018-04-12 00:40:01', '2018-04-12 00:40:01', 'telephone_invoice_label'),
(177, 1, '2018-04-12 00:40:51', '2018-04-12 00:40:51', 'fax_invoice_label'),
(178, 1, '2018-04-12 00:41:25', '2018-04-12 00:41:25', 'address_part1_delivery_label'),
(179, 1, '2018-04-12 00:41:54', '2018-04-12 00:41:54', 'address_part2_delivery_label'),
(180, 1, '2018-04-12 00:42:23', '2018-04-12 00:42:23', 'attention_delivery_label'),
(181, 1, '2018-04-12 00:42:51', '2018-04-12 00:42:51', 'mobile_delivery_label'),
(182, 1, '2018-04-12 00:43:13', '2018-04-12 00:43:13', 'telephone_delivery_label'),
(183, 1, '2018-04-12 00:43:40', '2018-04-12 00:43:40', 'fax_delivery_label'),
(184, 1, '2018-04-12 00:44:02', '2018-04-12 00:44:02', 'description1_label'),
(185, 1, '2018-04-12 00:44:29', '2018-04-12 00:44:29', 'description2_label'),
(186, 1, '2018-04-12 00:44:53', '2018-04-12 00:44:53', 'description3_label'),
(187, 1, '2018-04-12 01:09:15', '2018-04-12 01:09:15', 'add_party_label'),
(188, 1, '2018-04-12 04:03:01', '2018-04-12 04:03:01', 'mxp_menu_page_header'),
(189, 1, '2018-04-12 04:16:18', '2018-04-12 04:16:18', 'header_title_label'),
(190, 1, '2018-04-12 04:19:01', '2018-04-12 04:19:01', 'header_fontsize_label'),
(191, 1, '2018-04-12 04:21:38', '2018-04-12 04:21:38', 'header_font_style_label'),
(192, 1, '2018-04-12 04:26:04', '2018-04-12 04:26:04', 'header_color_label'),
(193, 1, '2018-04-12 04:26:24', '2018-04-12 04:26:24', 'header_address1_label'),
(194, 1, '2018-04-12 04:29:35', '2018-04-12 04:29:35', 'header_address3_label'),
(195, 1, '2018-04-12 04:30:05', '2018-04-12 04:30:05', 'header_logo_aligment_label'),
(196, 1, '2018-04-12 04:30:39', '2018-04-12 04:30:39', 'header_address2_label'),
(197, 1, '2018-04-12 04:31:03', '2018-04-12 04:31:03', 'header_logo_label'),
(198, 1, '2018-04-12 05:31:25', '2018-04-12 05:31:25', 'mxp_menu_page'),
(199, 1, '2018-04-12 05:38:56', '2018-04-12 05:38:56', 'mxp_menu_page_footer'),
(200, 1, '2018-04-12 06:07:56', '2018-04-12 06:07:56', 'add_page_footer_title_label'),
(201, 1, '2018-04-12 06:09:53', '2018-04-12 06:09:53', 'page_footer_title_label'),
(202, 0, '2018-04-12 06:10:56', '2018-04-12 06:10:56', 'enter_title_label'),
(203, 1, '2018-04-13 02:05:45', '2018-04-13 02:05:45', 'update_page_footer_title_label'),
(204, 1, '2018-04-13 02:35:41', '2018-04-13 02:35:41', 'mxp_menu_report_footer'),
(205, 1, '2018-04-13 04:43:27', '2018-04-13 04:43:27', 'add_report_footer_label'),
(206, 1, '2018-04-13 04:44:39', '2018-04-13 04:44:39', 'report_name_label'),
(207, 1, '2018-04-13 04:48:23', '2018-04-13 04:48:23', 're_fo_des3_label'),
(208, 1, '2018-04-13 04:49:10', '2018-04-13 04:49:10', 're_fo_des1_label'),
(209, 1, '2018-04-13 04:50:50', '2018-04-13 04:50:50', 're_fo_des4_label'),
(210, 1, '2018-04-13 04:51:12', '2018-04-13 04:51:12', 're_fo_des2_label'),
(211, 1, '2018-04-13 04:51:28', '2018-04-13 04:51:28', 're_fo_des5_label'),
(212, 1, '2018-04-13 04:56:18', '2018-04-13 04:56:18', 're_fo_siginingPerson_1_label'),
(213, 1, '2018-04-13 04:56:26', '2018-04-13 04:56:26', 're_fo_siginingPerson_2_label'),
(214, 1, '2018-04-13 07:03:29', '2018-04-13 07:03:29', 'person_1_signature'),
(215, 1, '2018-04-13 07:04:58', '2018-04-13 07:04:58', 'persion_seal_label'),
(216, 1, '2018-04-13 07:26:33', '2018-04-13 07:26:33', 'person_name_label'),
(217, 1, '2018-04-16 00:43:54', '2018-04-16 00:43:54', 'mxp_menu_brand'),
(218, 1, '2018-04-16 01:36:20', '2018-04-16 01:36:20', 'add_brand_label'),
(219, 1, '2018-04-16 01:42:14', '2018-04-16 01:42:14', 'brand_name_label'),
(220, 1, '2018-04-16 02:25:24', '2018-04-16 02:25:24', 'mxp_menu_product_size'),
(221, 1, '2018-04-16 04:19:18', '2018-04-16 04:19:18', 'add_product_size_label'),
(222, 1, '2018-04-16 04:21:37', '2018-04-16 04:21:37', 'product_size_label'),
(223, 1, '2018-04-16 04:23:26', '2018-04-16 04:23:26', 'add_size_label'),
(224, 1, '2018-04-16 06:09:18', '2018-04-16 06:09:18', 'header_font_size_label'),
(225, 1, '2018-04-16 06:11:24', '2018-04-16 06:11:24', 'header_colour_label'),
(226, 1, '2018-04-16 06:12:38', '2018-04-16 06:12:38', 'logo_allignment_label'),
(227, 1, '2018-04-17 05:31:18', '2018-04-17 05:31:18', 'mxp_menu_print'),
(228, 1, '2018-04-17 05:32:54', '2018-04-17 05:32:54', 'mxp_menu_bill_copy'),
(229, 1, '2018-04-25 22:24:35', '2018-04-25 22:24:35', 'mxp_menu_all_bill_view'),
(230, 1, '2018-05-03 00:37:53', '2018-05-03 00:37:53', 'add_searchbill_label'),
(231, 1, '2018-05-03 00:43:16', '2018-05-03 00:43:16', 'bill_invo_no_label'),
(232, 1, '2018-05-03 02:54:24', '2018-05-03 02:54:24', 'search_button'),
(233, 1, '2018-05-03 02:59:29', '2018-05-03 02:59:29', 'genarate_bill_button'),
(234, 1, '2018-05-03 03:48:13', '2018-05-03 03:48:13', 'mxp_menu_challan_boxing_list'),
(235, 1, '2018-05-06 23:53:37', '2018-05-06 23:53:37', 'mxp_menu_multiple_challan_search'),
(236, 1, '2018-05-06 23:58:00', '2018-05-06 23:58:00', 'challan_no_label'),
(237, 1, '2018-05-07 00:53:50', '2018-05-07 00:53:50', 'mxp_menu_order_list_view'),
(238, 1, '2018-05-07 01:00:57', '2018-05-07 01:00:57', 'mxp_menu_order_list'),
(239, 1, '2018-05-07 01:58:12', '2018-05-07 01:58:12', 'mxp_menu_ipo_view'),
(240, 1, '2018-05-07 02:01:49', '2018-05-07 02:01:49', 'initial_increase_label'),
(241, 1, '2018-05-10 03:00:27', '2018-05-10 03:00:27', 'update_ueader'),
(242, 1, '2018-05-10 23:31:45', '2018-05-10 23:31:45', 'report_footer_list'),
(243, 1, '2018-05-10 23:37:20', '2018-05-10 23:37:20', 'update_report_footer_label'),
(244, 1, '2018-05-11 00:34:47', '2018-05-11 00:34:47', 'update_brand_label'),
(245, 1, '2018-05-11 00:37:57', '2018-05-11 00:37:57', 'brand_list_label'),
(246, 1, '2018-05-11 00:41:44', '2018-05-11 00:41:44', 'party_list_label'),
(247, 1, '2018-05-11 00:45:50', '2018-05-11 00:45:50', 'header_status_label'),
(248, 1, '2018-05-11 00:46:18', '2018-05-11 00:46:18', 'invoice_label'),
(249, 1, '2018-05-11 00:46:44', '2018-05-11 00:46:44', 'delivery_label'),
(250, 1, '2018-05-11 00:55:04', '2018-05-11 00:55:04', 'sort_name_label'),
(251, 1, '2018-05-11 02:29:51', '2018-05-11 02:29:51', 'header_list_label'),
(252, 1, '2018-05-11 02:31:28', '2018-05-11 02:31:28', 'add_header_label'),
(253, 1, '2018-05-11 02:40:55', '2018-05-11 02:40:55', 'header_address_label'),
(254, 1, '2018-05-11 02:43:38', '2018-05-11 02:43:38', 'footer_title_label'),
(255, 1, '2018-05-11 02:47:49', '2018-05-11 02:47:49', 'update_party_label'),
(256, 1, '2018-05-11 02:49:32', '2018-05-11 02:49:32', 'product_list_label'),
(257, 1, '2018-05-13 23:30:27', '2018-05-13 23:30:27', 'product_size_list'),
(258, 1, '2018-05-16 00:09:31', '2018-05-16 00:09:31', 'mxp_menu_order_input'),
(259, 1, '2018-06-05 22:36:08', '2018-06-05 22:36:08', 'task_label'),
(260, 1, '2018-06-05 23:27:03', '2018-06-05 23:27:03', 'mxp_menu_gmts_color'),
(261, 1, '2018-06-05 23:34:38', '2018-06-05 23:34:38', 'Gmts_color_list_label'),
(262, 1, '2018-06-05 23:42:36', '2018-06-05 23:42:36', 'add_color_label'),
(263, 1, '2018-06-05 23:54:08', '2018-06-05 23:54:08', 'add_gmts_color_label'),
(264, 1, '2018-06-06 01:57:57', '2018-06-06 01:57:57', 'gmts_color_label'),
(265, 1, '2018-06-06 02:33:37', '2018-06-06 02:33:37', 'update_gmts_color_label'),
(266, 1, '2018-06-06 02:34:28', '2018-06-06 02:34:28', 'update_color_label'),
(267, 1, '2018-06-08 02:58:26', '2018-06-08 02:58:26', 'header_type_label'),
(268, 1, '2018-06-08 03:06:08', '2018-06-08 03:06:08', 'header_cell_number_label'),
(269, 1, '2018-06-08 03:06:38', '2018-06-08 03:06:38', 'header_attention_label'),
(270, 1, '2018-06-20 06:29:05', '2018-06-20 06:29:05', 'mxp_menu_production'),
(271, 1, '2018-06-20 06:29:40', '2018-06-20 06:29:40', 'mxp_menu_booking'),
(272, 1, '2018-06-21 04:07:20', '2018-06-21 04:07:20', 'mxp_menu_booking_list');

-- --------------------------------------------------------

--
-- Table structure for table `mxp_users`
--

CREATE TABLE `mxp_users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `middle_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_id` int(100) NOT NULL DEFAULT '0',
  `company_id` int(11) NOT NULL DEFAULT '0',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `user_role_id` int(11) DEFAULT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  `verification_token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mxp_users`
--

INSERT INTO `mxp_users` (`user_id`, `first_name`, `middle_name`, `last_name`, `address`, `type`, `group_id`, `company_id`, `email`, `password`, `phone_no`, `remember_token`, `is_active`, `user_role_id`, `verified`, `verification_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'middle', 'last', NULL, 'super_admin', 0, 0, 'sajibg7@gmail.com', '$2y$10$BIvmvrQf1a5G3mrmHlrN9ulYV1fKtgUoJaK968BJ2foPBTkVjWn7S', '123456789', 'W2BAkJhItN3JPmGRSuvUaiFcHEpKQiVdVv2w8P8gVyvXmNvtPUxyNIRnmaPr', 1, 1, 0, '0', '2018-01-15 01:37:15', '2018-03-05 13:29:32'),
(24, 'Beximco user', 'moinul', 'sajibg', NULL, 'super_admin', 0, 0, 'sajibg7+1@gmail.com', '$2y$10$voCXiMsv.R.X.pl6F8DbnuFyIiwyhrpYB.na/FITZNz7ZIGyLVmfC', '01674898148', '5zesn2ucLuXz1fN1tVBETDkjrIEBqG38fFiglfuVQzr4BcAbECNiV67d3xKI', 1, 1, 0, '0', '2018-01-29 06:36:28', '2018-01-29 06:36:28'),
(26, 'company-a-user', NULL, NULL, NULL, 'company_user', 1, 11, 'sajibg7+3@gmail.com', '$2y$10$gxTBxp.V1v2TJphLkJWmLuqIwhdNu0WxUZSDgnkNyc0D/.YnhCkc2', '12143234235', 'TezCzw56wUjAeVkvits9Zkaj5ZVLjRNYAauQDTh0DmT6AdtSiXY5Qs8CcGPu', 1, 21, 0, '0', '2018-01-29 06:44:07', '2018-01-29 06:44:07'),
(27, 'Sumit Power user', 'moinul', 'sajibg', NULL, 'super_admin', 0, 0, 'sajibg7+4@gmail.com', '$2y$10$DYvlonHYz7onBx3U743LoeSQX166D4Y.EFxJDI33WfbUFuHvvUrZ.', '01674898148', 'kcraPAbsogfCaWXXzizdBCRSYOIqrplPy77x3qrT', 0, 1, 0, '0', '2018-01-30 00:16:13', '2018-01-30 00:16:13'),
(36, 'Sumit Power user-2', 'moinul', 'sajibg', NULL, 'super_admin', 0, 0, 'sajibg7+5@gmail.com', '$2y$10$9PUEtsR3rv82eJ7TFyG/wOEuTtbXUbcTJWZ0Wz1EBFRnNLqzHROje', '01674898148', 'kcraPAbsogfCaWXXzizdBCRSYOIqrplPy77x3qrT', 0, 1, 0, '0', '2018-01-30 00:32:37', '2018-01-30 00:32:37'),
(38, 'Sumit Power user-22', 'moinul', 'sajibg', NULL, 'super_admin', 0, 0, 'sajibg7+23@gmail.com', '$2y$10$0.jZXV4ihdxJKIqI3STDb.4QB3.fd2szjsQLUCeijhVXSyuzQw0gy', '01674898148', 'DORz0nqgyRNUEPWahczArNAlVYTil0mFXMniff6BAaVmMLjO2sywBn0BvHS5', 1, 1, 0, '0', '2018-01-31 02:56:31', '2018-01-31 02:56:31'),
(39, 'mxp_name', NULL, NULL, NULL, 'company_user', 38, 13, 'sajibg7+77@gmail.com', '$2y$10$O4ZTP39xhT2NtkYcAE1I1u3ZVfn/CA4PC5954PJVYP92yQ1e3oJSG', '2222222222', 'zJ9Fq0pgJp1Ffo1AljnyQS2IHKDKgD59zDokr5ufo7wzNjjNAG5zHgX2w9kw', 1, 25, 0, '0', '2018-01-31 03:00:36', '2018-01-31 03:00:36'),
(40, 'mxp_name', NULL, NULL, NULL, 'company_user', 38, 14, 'sajibg7+78@gmail.com', '$2y$10$/RIWK3dmNz5i0RO6p.b8h.fIgPVOukwUUVdydW4zuqjDYZgnuFT3y', '2222222222', 'CMIeb4F5GnV3Gvzeq6n7FvUwdCN8DM1NPoEwkVaHyLwYPSnc7U2P52xLfX1R', 1, 26, 0, '0', '2018-01-31 03:00:53', '2018-01-31 03:00:53'),
(41, 'Beximco', NULL, NULL, '56,gazipur', 'client_com', 1, 10, 'beximco@beximco.com', NULL, '21321564654687987', NULL, 1, NULL, 0, '0', '2018-02-02 06:14:45', '2018-02-02 06:14:45'),
(42, 'New Admin', 'Middle', 'Last', NULL, 'super_admin', 0, 0, 'newadmin@mail.com', '$2y$10$x1yzwN3LXrb8fkXSCg9Roeu.EBlSQpJf1U.ouqzdOi1F5z2robRd2', '1234567890', 'I500mFPOncDcawx0KwHnzx35J0rH1TUOIT6m4omT', 1, 1, 0, '0', '2018-02-09 01:58:04', '2018-02-09 01:58:04'),
(43, 'New Client', NULL, NULL, NULL, 'client_com', 42, 16, 'newclient@mail.com', NULL, '1234567890', NULL, 1, NULL, 0, '0', '2018-02-09 02:09:35', '2018-02-09 02:09:35'),
(48, 'test user', NULL, NULL, NULL, 'company_user', 1, 10, 'sajibg7+09@gmail.com', '$2y$10$NItNEFuZfxtXosv7iRoU0utNjKMIijcYPFTj5J/r26AY86hZg2w6W', '123456', NULL, 1, 29, 0, '0', '2018-04-09 01:58:28', '2018-04-09 01:58:28'),
(49, 'shohidur', NULL, 'Rahman', NULL, 'super_admin', 0, 0, 'sohidurr49@gmail.com', '$2y$10$.JwEQcEC.OTXRG4aP/PsU.iomnby.5ndA35BeOVrh2Mb03x1LMlsS', '01792755683', '4VcjPJPoO08pIt7q33giXmcRE0rhCQVyZKb1D1ukc6dy2DB5KJk3YqIozWR3', 1, 1, 0, '0', '2018-04-09 04:17:47', '2018-04-09 04:17:47'),
(50, 'Shohid', NULL, NULL, NULL, 'company_user', 49, 18, 'test111@mail.com', '$2y$10$lhlWW/5g71MYtdPWgcGLbOlCEzeVRcVlhmab7KGhHEI7.n2EtmC.O', '1234567890', 'I0QouznQ2v43e8SflagFdAzhvPGLvm3328IZLS76Yt1PZJny12BmolxXhNg9', 1, 31, 0, '0', '2018-05-10 00:10:17', '2018-05-10 00:10:17');

-- --------------------------------------------------------

--
-- Table structure for table `mxp_user_role_menu`
--

CREATE TABLE `mxp_user_role_menu` (
  `role_menu_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL DEFAULT '0',
  `is_active` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mxp_user_role_menu`
--

INSERT INTO `mxp_user_role_menu` (`role_menu_id`, `role_id`, `menu_id`, `company_id`, `is_active`, `created_at`, `updated_at`) VALUES
(185, 1, 25, 0, 0, '2018-01-26 12:24:42', '2018-01-26 12:24:42'),
(186, 1, 7, 0, 1, '2018-01-26 12:24:42', '2018-01-26 12:24:42'),
(187, 1, 34, 0, 1, '2018-01-26 12:24:42', '2018-01-26 12:24:42'),
(188, 1, 28, 0, 1, '2018-01-26 12:24:42', '2018-01-26 12:24:42'),
(189, 1, 19, 0, 1, '2018-01-26 12:24:42', '2018-01-26 12:24:42'),
(190, 1, 37, 0, 1, '2018-01-26 12:24:42', '2018-01-26 12:24:42'),
(191, 1, 18, 0, 1, '2018-01-26 12:24:42', '2018-01-26 12:24:42'),
(192, 1, 4, 0, 1, '2018-01-26 12:24:42', '2018-01-26 12:24:42'),
(193, 1, 31, 0, 1, '2018-01-26 12:24:42', '2018-01-26 12:24:42'),
(194, 1, 23, 0, 1, '2018-01-26 12:24:42', '2018-01-26 12:24:42'),
(195, 1, 3, 0, 1, '2018-01-26 12:24:43', '2018-01-26 12:24:43'),
(196, 1, 24, 0, 1, '2018-01-26 12:24:43', '2018-01-26 12:24:43'),
(197, 1, 27, 0, 1, '2018-01-26 12:24:43', '2018-01-26 12:24:43'),
(198, 1, 36, 0, 1, '2018-01-26 12:24:43', '2018-01-26 12:24:43'),
(199, 1, 35, 0, 1, '2018-01-26 12:24:43', '2018-01-26 12:24:43'),
(200, 1, 13, 0, 1, '2018-01-26 12:24:43', '2018-01-26 12:24:43'),
(201, 1, 30, 0, 1, '2018-01-26 12:24:43', '2018-01-26 12:24:43'),
(202, 1, 6, 0, 1, '2018-01-26 12:24:43', '2018-01-26 12:24:43'),
(203, 1, 10, 0, 1, '2018-01-26 12:24:43', '2018-01-26 12:24:43'),
(204, 1, 16, 0, 1, '2018-01-26 12:24:43', '2018-01-26 12:24:43'),
(205, 1, 9, 0, 1, '2018-01-26 12:24:43', '2018-01-26 12:24:43'),
(206, 1, 8, 0, 1, '2018-01-26 12:24:43', '2018-01-26 12:24:43'),
(207, 1, 12, 0, 1, '2018-01-26 12:24:43', '2018-01-26 12:24:43'),
(208, 1, 5, 0, 1, '2018-01-26 12:24:43', '2018-01-26 12:24:43'),
(209, 1, 26, 0, 1, '2018-01-26 12:24:43', '2018-01-26 12:24:43'),
(210, 1, 11, 0, 1, '2018-01-26 12:24:43', '2018-01-26 12:24:43'),
(211, 1, 29, 0, 1, '2018-01-26 12:24:43', '2018-01-26 12:24:43'),
(212, 1, 22, 0, 1, '2018-01-26 12:24:43', '2018-01-26 12:24:43'),
(213, 1, 33, 0, 1, '2018-01-26 12:24:43', '2018-01-26 12:24:43'),
(214, 1, 21, 0, 1, '2018-01-26 12:24:43', '2018-01-26 12:24:43'),
(313, 21, 4, 0, 1, '2018-01-28 12:42:45', '2018-01-28 12:42:45'),
(314, 21, 31, 0, 1, '2018-01-28 12:42:46', '2018-01-28 12:42:46'),
(315, 21, 3, 0, 1, '2018-01-28 12:42:46', '2018-01-28 12:42:46'),
(316, 21, 24, 0, 1, '2018-01-28 12:42:46', '2018-01-28 12:42:46'),
(317, 21, 27, 0, 1, '2018-01-28 12:42:46', '2018-01-28 12:42:46'),
(318, 21, 5, 0, 1, '2018-01-28 12:42:46', '2018-01-28 12:42:46'),
(319, 21, 32, 0, 1, '2018-01-28 12:42:46', '2018-01-28 12:42:46'),
(349, 26, 34, 14, 1, '2018-01-30 09:00:07', '2018-01-30 09:00:07'),
(350, 26, 13, 14, 1, '2018-01-30 09:00:07', '2018-01-30 09:00:07'),
(351, 26, 6, 14, 1, '2018-01-30 09:00:07', '2018-01-30 09:00:07'),
(352, 26, 10, 14, 1, '2018-01-30 09:00:07', '2018-01-30 09:00:07'),
(353, 26, 16, 14, 1, '2018-01-30 09:00:08', '2018-01-30 09:00:08'),
(354, 26, 9, 14, 1, '2018-01-30 09:00:08', '2018-01-30 09:00:08'),
(355, 26, 8, 14, 1, '2018-01-30 09:00:08', '2018-01-30 09:00:08'),
(356, 26, 12, 14, 1, '2018-01-30 09:00:08', '2018-01-30 09:00:08'),
(357, 26, 11, 14, 1, '2018-01-30 09:00:08', '2018-01-30 09:00:08'),
(358, 25, 19, 13, 1, '2018-01-30 10:23:24', '2018-01-30 10:23:24'),
(359, 25, 37, 13, 1, '2018-01-30 10:23:24', '2018-01-30 10:23:24'),
(360, 25, 18, 13, 1, '2018-01-30 10:23:24', '2018-01-30 10:23:24'),
(361, 25, 5, 13, 1, '2018-01-30 10:23:24', '2018-01-30 10:23:24'),
(362, 25, 22, 13, 1, '2018-01-30 10:23:24', '2018-01-30 10:23:24'),
(363, 25, 33, 13, 1, '2018-01-30 10:23:25', '2018-01-30 10:23:25'),
(364, 25, 21, 13, 1, '2018-01-30 10:23:25', '2018-01-30 10:23:25'),
(365, 25, 20, 13, 1, '2018-01-30 10:23:25', '2018-01-30 10:23:25'),
(366, 1, 32, 0, 1, NULL, NULL),
(367, 1, 20, 0, 1, '2018-01-30 10:23:25', '2018-01-30 10:23:25'),
(401, 1, 38, 0, 1, NULL, NULL),
(402, 1, 39, 0, 1, NULL, NULL),
(403, 1, 40, 0, 1, NULL, NULL),
(404, 1, 41, 0, 1, NULL, NULL),
(405, 1, 42, 0, 1, NULL, NULL),
(406, 1, 43, 0, 1, NULL, NULL),
(407, 1, 44, 0, 1, NULL, NULL),
(414, 1, 52, 0, 1, '2018-01-31 06:00:00', '2018-01-31 06:00:00'),
(415, 1, 53, 0, 1, '2018-01-31 06:00:00', '2018-01-31 06:00:00'),
(416, 1, 54, 0, 1, '2018-01-31 06:00:00', '2018-01-31 06:00:00'),
(417, 1, 55, 0, 1, '2018-01-31 06:00:00', '2018-01-31 06:00:00'),
(418, 1, 56, 0, 1, '2018-01-31 06:00:00', '2018-01-31 06:00:00'),
(419, 1, 54, 0, 1, '2018-01-31 06:00:00', '2018-01-31 06:00:00'),
(420, 1, 57, 0, 1, '2018-01-31 06:00:00', '2018-01-31 06:00:00'),
(421, 1, 58, 0, 1, '2018-01-31 06:00:00', '2018-01-31 06:00:00'),
(422, 1, 59, 0, 1, '2018-01-31 06:00:00', '2018-01-31 06:00:00'),
(423, 1, 60, 0, 1, '2018-01-31 06:00:00', '2018-01-31 06:00:00'),
(424, 1, 61, 0, 1, NULL, NULL),
(425, 1, 62, 0, 1, NULL, NULL),
(426, 1, 63, 0, 1, NULL, NULL),
(427, 1, 64, 0, 1, NULL, NULL),
(428, 1, 65, 0, 1, NULL, NULL),
(429, 1, 66, 0, 1, NULL, NULL),
(430, 1, 67, 0, 1, NULL, NULL),
(431, 1, 68, 0, 1, NULL, NULL),
(432, 1, 69, 0, 1, NULL, NULL),
(433, 1, 70, 0, 1, NULL, NULL),
(434, 1, 71, 0, 1, NULL, NULL),
(435, 1, 72, 0, 1, NULL, NULL),
(482, 1, 73, 0, 1, NULL, NULL),
(486, 1, 77, 0, 1, NULL, NULL),
(487, 1, 78, 0, 1, NULL, NULL),
(488, 1, 79, 0, 1, NULL, NULL),
(489, 1, 80, 0, 1, NULL, NULL),
(490, 1, 81, 0, 1, NULL, NULL),
(491, 1, 82, 0, 1, NULL, NULL),
(492, 1, 83, 0, 1, NULL, NULL),
(493, 1, 88, 0, 1, NULL, NULL),
(494, 1, 89, 0, 1, NULL, NULL),
(495, 1, 90, 0, 1, NULL, NULL),
(496, 1, 91, 0, 1, NULL, NULL),
(497, 1, 92, 0, 1, NULL, NULL),
(498, 1, 84, 0, 1, NULL, NULL),
(499, 1, 93, 0, 1, NULL, NULL),
(500, 1, 94, 0, 1, NULL, NULL),
(501, 1, 95, 0, 1, NULL, NULL),
(502, 1, 96, 0, 1, NULL, NULL),
(503, 1, 97, 0, 1, NULL, NULL),
(504, 1, 98, 0, 1, NULL, NULL),
(505, 1, 99, 0, 1, NULL, NULL),
(506, 1, 100, 0, 1, NULL, NULL),
(507, 1, 101, 0, 1, NULL, NULL),
(508, 1, 102, 0, 1, NULL, NULL),
(509, 27, 102, 10, 1, '2018-04-02 00:40:56', '2018-04-02 00:40:56'),
(510, 27, 98, 10, 1, '2018-04-02 00:40:56', '2018-04-02 00:40:56'),
(511, 27, 43, 10, 1, '2018-04-02 00:40:56', '2018-04-02 00:40:56'),
(512, 27, 25, 10, 1, '2018-04-02 00:40:56', '2018-04-02 00:40:56'),
(513, 27, 57, 10, 1, '2018-04-02 00:40:56', '2018-04-02 00:40:56'),
(514, 27, 90, 10, 1, '2018-04-02 00:40:56', '2018-04-02 00:40:56'),
(515, 27, 67, 10, 1, '2018-04-02 00:40:56', '2018-04-02 00:40:56'),
(516, 27, 56, 10, 1, '2018-04-02 00:40:56', '2018-04-02 00:40:56'),
(517, 27, 54, 10, 1, '2018-04-02 00:40:56', '2018-04-02 00:40:56'),
(518, 27, 53, 10, 1, '2018-04-02 00:40:56', '2018-04-02 00:40:56'),
(519, 27, 44, 10, 1, '2018-04-02 00:40:56', '2018-04-02 00:40:56'),
(520, 27, 41, 10, 1, '2018-04-02 00:40:56', '2018-04-02 00:40:56'),
(521, 27, 40, 10, 1, '2018-04-02 00:40:56', '2018-04-02 00:40:56'),
(522, 27, 89, 10, 1, '2018-04-02 00:40:56', '2018-04-02 00:40:56'),
(523, 27, 68, 10, 1, '2018-04-02 00:40:56', '2018-04-02 00:40:56'),
(524, 27, 71, 10, 1, '2018-04-02 00:40:57', '2018-04-02 00:40:57'),
(525, 27, 70, 10, 1, '2018-04-02 00:40:57', '2018-04-02 00:40:57'),
(526, 27, 28, 10, 1, '2018-04-02 00:40:57', '2018-04-02 00:40:57'),
(527, 27, 19, 10, 1, '2018-04-02 00:40:57', '2018-04-02 00:40:57'),
(528, 27, 72, 10, 1, '2018-04-02 00:40:57', '2018-04-02 00:40:57'),
(529, 27, 69, 10, 1, '2018-04-02 00:40:57', '2018-04-02 00:40:57'),
(530, 27, 18, 10, 1, '2018-04-02 00:40:57', '2018-04-02 00:40:57'),
(531, 27, 4, 10, 1, '2018-04-02 00:40:57', '2018-04-02 00:40:57'),
(532, 27, 58, 10, 1, '2018-04-02 00:40:57', '2018-04-02 00:40:57'),
(533, 27, 66, 10, 1, '2018-04-02 00:40:57', '2018-04-02 00:40:57'),
(534, 27, 31, 10, 1, '2018-04-02 00:40:57', '2018-04-02 00:40:57'),
(535, 27, 63, 10, 1, '2018-04-02 00:40:57', '2018-04-02 00:40:57'),
(536, 27, 91, 10, 1, '2018-04-02 00:40:57', '2018-04-02 00:40:57'),
(537, 27, 99, 10, 1, '2018-04-02 00:40:57', '2018-04-02 00:40:57'),
(538, 27, 101, 10, 1, '2018-04-02 00:40:57', '2018-04-02 00:40:57'),
(539, 27, 3, 10, 1, '2018-04-02 00:40:57', '2018-04-02 00:40:57'),
(540, 27, 100, 10, 1, '2018-04-02 00:40:57', '2018-04-02 00:40:57'),
(541, 27, 73, 10, 1, '2018-04-02 00:40:57', '2018-04-02 00:40:57'),
(542, 27, 24, 10, 1, '2018-04-02 00:40:57', '2018-04-02 00:40:57'),
(543, 27, 27, 10, 1, '2018-04-02 00:40:57', '2018-04-02 00:40:57'),
(544, 27, 30, 10, 1, '2018-04-02 00:40:57', '2018-04-02 00:40:57'),
(545, 27, 38, 10, 1, '2018-04-02 00:40:57', '2018-04-02 00:40:57'),
(546, 27, 74, 10, 1, '2018-04-02 00:40:57', '2018-04-02 00:40:57'),
(547, 27, 76, 10, 1, '2018-04-02 00:40:57', '2018-04-02 00:40:57'),
(548, 27, 52, 10, 1, '2018-04-02 00:40:57', '2018-04-02 00:40:57'),
(549, 27, 42, 10, 1, '2018-04-02 00:40:57', '2018-04-02 00:40:57'),
(550, 27, 55, 10, 1, '2018-04-02 00:40:57', '2018-04-02 00:40:57'),
(551, 27, 75, 10, 1, '2018-04-02 00:40:57', '2018-04-02 00:40:57'),
(552, 27, 92, 10, 1, '2018-04-02 00:40:57', '2018-04-02 00:40:57'),
(553, 27, 6, 10, 1, '2018-04-02 00:40:57', '2018-04-02 00:40:57'),
(554, 27, 8, 10, 1, '2018-04-02 00:40:58', '2018-04-02 00:40:58'),
(555, 27, 93, 10, 1, '2018-04-02 00:40:58', '2018-04-02 00:40:58'),
(556, 27, 5, 10, 1, '2018-04-02 00:40:58', '2018-04-02 00:40:58'),
(557, 27, 83, 10, 1, '2018-04-02 00:40:58', '2018-04-02 00:40:58'),
(558, 27, 79, 10, 1, '2018-04-02 00:40:58', '2018-04-02 00:40:58'),
(559, 27, 82, 10, 1, '2018-04-02 00:40:58', '2018-04-02 00:40:58'),
(560, 27, 81, 10, 1, '2018-04-02 00:40:58', '2018-04-02 00:40:58'),
(561, 27, 96, 10, 1, '2018-04-02 00:40:58', '2018-04-02 00:40:58'),
(562, 27, 97, 10, 1, '2018-04-02 00:40:58', '2018-04-02 00:40:58'),
(563, 27, 84, 10, 1, '2018-04-02 00:40:58', '2018-04-02 00:40:58'),
(564, 27, 77, 10, 1, '2018-04-02 00:40:58', '2018-04-02 00:40:58'),
(565, 27, 78, 10, 1, '2018-04-02 00:40:58', '2018-04-02 00:40:58'),
(566, 27, 80, 10, 1, '2018-04-02 00:40:58', '2018-04-02 00:40:58'),
(567, 27, 26, 10, 1, '2018-04-02 00:40:58', '2018-04-02 00:40:58'),
(568, 27, 60, 10, 1, '2018-04-02 00:40:58', '2018-04-02 00:40:58'),
(569, 27, 65, 10, 1, '2018-04-02 00:40:58', '2018-04-02 00:40:58'),
(570, 27, 95, 10, 1, '2018-04-02 00:40:58', '2018-04-02 00:40:58'),
(571, 27, 29, 10, 1, '2018-04-02 00:40:58', '2018-04-02 00:40:58'),
(572, 27, 62, 10, 1, '2018-04-02 00:40:58', '2018-04-02 00:40:58'),
(573, 27, 33, 10, 1, '2018-04-02 00:40:58', '2018-04-02 00:40:58'),
(574, 27, 39, 10, 1, '2018-04-02 00:40:58', '2018-04-02 00:40:58'),
(575, 27, 64, 10, 1, '2018-04-02 00:40:58', '2018-04-02 00:40:58'),
(576, 27, 94, 10, 1, '2018-04-02 00:40:58', '2018-04-02 00:40:58'),
(577, 27, 61, 10, 1, '2018-04-02 00:40:58', '2018-04-02 00:40:58'),
(578, 27, 32, 10, 1, '2018-04-02 00:40:58', '2018-04-02 00:40:58'),
(579, 27, 20, 10, 1, '2018-04-02 00:40:58', '2018-04-02 00:40:58'),
(580, 27, 59, 10, 1, '2018-04-02 00:40:58', '2018-04-02 00:40:58'),
(581, 27, 88, 10, 1, '2018-04-02 00:40:58', '2018-04-02 00:40:58'),
(728, 20, 102, 10, 1, '2018-04-02 00:51:20', '2018-04-02 00:51:20'),
(729, 20, 98, 10, 1, '2018-04-02 00:51:20', '2018-04-02 00:51:20'),
(730, 20, 43, 10, 1, '2018-04-02 00:51:21', '2018-04-02 00:51:21'),
(731, 20, 25, 10, 1, '2018-04-02 00:51:21', '2018-04-02 00:51:21'),
(732, 20, 57, 10, 1, '2018-04-02 00:51:21', '2018-04-02 00:51:21'),
(733, 20, 90, 10, 1, '2018-04-02 00:51:21', '2018-04-02 00:51:21'),
(734, 20, 67, 10, 1, '2018-04-02 00:51:21', '2018-04-02 00:51:21'),
(735, 20, 56, 10, 1, '2018-04-02 00:51:21', '2018-04-02 00:51:21'),
(736, 20, 54, 10, 1, '2018-04-02 00:51:21', '2018-04-02 00:51:21'),
(737, 20, 53, 10, 1, '2018-04-02 00:51:21', '2018-04-02 00:51:21'),
(738, 20, 44, 10, 1, '2018-04-02 00:51:21', '2018-04-02 00:51:21'),
(739, 20, 41, 10, 1, '2018-04-02 00:51:21', '2018-04-02 00:51:21'),
(740, 20, 40, 10, 1, '2018-04-02 00:51:21', '2018-04-02 00:51:21'),
(741, 20, 89, 10, 1, '2018-04-02 00:51:21', '2018-04-02 00:51:21'),
(742, 20, 68, 10, 1, '2018-04-02 00:51:21', '2018-04-02 00:51:21'),
(743, 20, 71, 10, 1, '2018-04-02 00:51:21', '2018-04-02 00:51:21'),
(744, 20, 70, 10, 1, '2018-04-02 00:51:21', '2018-04-02 00:51:21'),
(745, 20, 28, 10, 1, '2018-04-02 00:51:21', '2018-04-02 00:51:21'),
(746, 20, 19, 10, 1, '2018-04-02 00:51:21', '2018-04-02 00:51:21'),
(747, 20, 72, 10, 1, '2018-04-02 00:51:21', '2018-04-02 00:51:21'),
(748, 20, 69, 10, 1, '2018-04-02 00:51:21', '2018-04-02 00:51:21'),
(749, 20, 18, 10, 1, '2018-04-02 00:51:21', '2018-04-02 00:51:21'),
(750, 20, 4, 10, 1, '2018-04-02 00:51:21', '2018-04-02 00:51:21'),
(751, 20, 58, 10, 1, '2018-04-02 00:51:21', '2018-04-02 00:51:21'),
(752, 20, 66, 10, 1, '2018-04-02 00:51:21', '2018-04-02 00:51:21'),
(753, 20, 31, 10, 1, '2018-04-02 00:51:21', '2018-04-02 00:51:21'),
(754, 20, 63, 10, 1, '2018-04-02 00:51:21', '2018-04-02 00:51:21'),
(755, 20, 91, 10, 1, '2018-04-02 00:51:21', '2018-04-02 00:51:21'),
(756, 20, 99, 10, 1, '2018-04-02 00:51:21', '2018-04-02 00:51:21'),
(757, 20, 101, 10, 1, '2018-04-02 00:51:21', '2018-04-02 00:51:21'),
(758, 20, 3, 10, 1, '2018-04-02 00:51:21', '2018-04-02 00:51:21'),
(759, 20, 100, 10, 1, '2018-04-02 00:51:22', '2018-04-02 00:51:22'),
(760, 20, 73, 10, 1, '2018-04-02 00:51:22', '2018-04-02 00:51:22'),
(761, 20, 24, 10, 1, '2018-04-02 00:51:22', '2018-04-02 00:51:22'),
(762, 20, 27, 10, 1, '2018-04-02 00:51:22', '2018-04-02 00:51:22'),
(763, 20, 30, 10, 1, '2018-04-02 00:51:22', '2018-04-02 00:51:22'),
(764, 20, 38, 10, 1, '2018-04-02 00:51:22', '2018-04-02 00:51:22'),
(765, 20, 74, 10, 1, '2018-04-02 00:51:22', '2018-04-02 00:51:22'),
(766, 20, 76, 10, 1, '2018-04-02 00:51:22', '2018-04-02 00:51:22'),
(767, 20, 52, 10, 1, '2018-04-02 00:51:22', '2018-04-02 00:51:22'),
(768, 20, 42, 10, 1, '2018-04-02 00:51:22', '2018-04-02 00:51:22'),
(769, 20, 55, 10, 1, '2018-04-02 00:51:22', '2018-04-02 00:51:22'),
(770, 20, 75, 10, 1, '2018-04-02 00:51:22', '2018-04-02 00:51:22'),
(771, 20, 92, 10, 1, '2018-04-02 00:51:22', '2018-04-02 00:51:22'),
(772, 20, 6, 10, 1, '2018-04-02 00:51:22', '2018-04-02 00:51:22'),
(773, 20, 8, 10, 1, '2018-04-02 00:51:22', '2018-04-02 00:51:22'),
(774, 20, 93, 10, 1, '2018-04-02 00:51:22', '2018-04-02 00:51:22'),
(775, 20, 5, 10, 1, '2018-04-02 00:51:22', '2018-04-02 00:51:22'),
(776, 20, 83, 10, 1, '2018-04-02 00:51:22', '2018-04-02 00:51:22'),
(777, 20, 79, 10, 1, '2018-04-02 00:51:22', '2018-04-02 00:51:22'),
(778, 20, 82, 10, 1, '2018-04-02 00:51:22', '2018-04-02 00:51:22'),
(779, 20, 81, 10, 1, '2018-04-02 00:51:22', '2018-04-02 00:51:22'),
(780, 20, 96, 10, 1, '2018-04-02 00:51:22', '2018-04-02 00:51:22'),
(781, 20, 97, 10, 1, '2018-04-02 00:51:22', '2018-04-02 00:51:22'),
(782, 20, 84, 10, 1, '2018-04-02 00:51:22', '2018-04-02 00:51:22'),
(783, 20, 77, 10, 1, '2018-04-02 00:51:22', '2018-04-02 00:51:22'),
(784, 20, 78, 10, 1, '2018-04-02 00:51:22', '2018-04-02 00:51:22'),
(785, 20, 80, 10, 1, '2018-04-02 00:51:22', '2018-04-02 00:51:22'),
(786, 20, 26, 10, 1, '2018-04-02 00:51:22', '2018-04-02 00:51:22'),
(787, 20, 60, 10, 1, '2018-04-02 00:51:23', '2018-04-02 00:51:23'),
(788, 20, 65, 10, 1, '2018-04-02 00:51:23', '2018-04-02 00:51:23'),
(789, 20, 95, 10, 1, '2018-04-02 00:51:23', '2018-04-02 00:51:23'),
(790, 20, 29, 10, 1, '2018-04-02 00:51:23', '2018-04-02 00:51:23'),
(791, 20, 62, 10, 1, '2018-04-02 00:51:23', '2018-04-02 00:51:23'),
(792, 20, 33, 10, 1, '2018-04-02 00:51:23', '2018-04-02 00:51:23'),
(793, 20, 39, 10, 1, '2018-04-02 00:51:23', '2018-04-02 00:51:23'),
(794, 20, 64, 10, 1, '2018-04-02 00:51:23', '2018-04-02 00:51:23'),
(795, 20, 94, 10, 1, '2018-04-02 00:51:23', '2018-04-02 00:51:23'),
(796, 20, 61, 10, 1, '2018-04-02 00:51:23', '2018-04-02 00:51:23'),
(797, 20, 32, 10, 1, '2018-04-02 00:51:23', '2018-04-02 00:51:23'),
(798, 20, 20, 10, 1, '2018-04-02 00:51:23', '2018-04-02 00:51:23'),
(799, 20, 59, 10, 1, '2018-04-02 00:51:23', '2018-04-02 00:51:23'),
(800, 20, 88, 10, 1, '2018-04-02 00:51:23', '2018-04-02 00:51:23'),
(801, 1, 103, 0, 1, NULL, NULL),
(802, 1, 104, 0, 1, NULL, NULL),
(805, 1, 105, 0, 1, NULL, NULL),
(806, 1, 105, 0, 1, NULL, NULL),
(807, 1, 105, 0, 1, NULL, NULL),
(808, 1, 105, 0, 1, NULL, NULL),
(809, 1, 105, 0, 1, NULL, NULL),
(810, 1, 105, 0, 1, NULL, NULL),
(811, 1, 106, 0, 1, NULL, NULL),
(812, 1, 107, 0, 1, NULL, NULL),
(813, 1, 108, 0, 1, NULL, NULL),
(814, 1, 109, 0, 1, NULL, NULL),
(815, 1, 110, 0, 1, NULL, NULL),
(816, 1, 111, 0, 1, NULL, NULL),
(817, 1, 112, 0, 1, NULL, NULL),
(818, 1, 113, 0, 1, NULL, NULL),
(819, 1, 114, 0, 1, NULL, NULL),
(820, 1, 115, 0, 1, NULL, NULL),
(821, 1, 116, 0, 1, NULL, NULL),
(822, 1, 116, 0, 1, NULL, NULL),
(823, 1, 118, 0, 1, NULL, NULL),
(824, 1, 119, 0, 1, NULL, NULL),
(825, 1, 120, 0, 1, NULL, NULL),
(826, 1, 121, 0, 1, NULL, NULL),
(827, 1, 122, 0, 1, NULL, NULL),
(828, 1, 123, 0, 1, NULL, NULL),
(829, 1, 124, 0, 1, NULL, NULL),
(830, 1, 125, 0, 1, NULL, NULL),
(831, 1, 126, 0, 1, NULL, NULL),
(832, 1, 127, 0, 1, NULL, NULL),
(833, 1, 128, 0, 1, NULL, NULL),
(834, 1, 129, 0, 1, NULL, NULL),
(835, 1, 130, 0, 1, NULL, NULL),
(836, 1, 131, 0, 1, NULL, NULL),
(837, 1, 132, 0, 1, NULL, NULL),
(838, 1, 133, 0, 1, NULL, NULL),
(839, 1, 134, 0, 1, NULL, NULL),
(840, 1, 135, 0, 1, NULL, NULL),
(841, 1, 136, 0, 1, NULL, NULL),
(842, 1, 137, 0, 1, NULL, NULL),
(843, 1, 138, 0, 1, NULL, NULL),
(844, 29, 25, 10, 1, '2018-04-09 01:57:55', '2018-04-09 01:57:55'),
(845, 29, 67, 10, 1, '2018-04-09 01:57:56', '2018-04-09 01:57:56'),
(846, 29, 68, 10, 1, '2018-04-09 01:57:56', '2018-04-09 01:57:56'),
(847, 29, 71, 10, 1, '2018-04-09 01:57:56', '2018-04-09 01:57:56'),
(848, 29, 70, 10, 1, '2018-04-09 01:57:56', '2018-04-09 01:57:56'),
(849, 29, 28, 10, 1, '2018-04-09 01:57:57', '2018-04-09 01:57:57'),
(850, 29, 19, 10, 1, '2018-04-09 01:57:57', '2018-04-09 01:57:57'),
(851, 29, 72, 10, 1, '2018-04-09 01:57:57', '2018-04-09 01:57:57'),
(852, 29, 69, 10, 1, '2018-04-09 01:57:57', '2018-04-09 01:57:57'),
(853, 29, 18, 10, 1, '2018-04-09 01:57:57', '2018-04-09 01:57:57'),
(854, 29, 4, 10, 1, '2018-04-09 01:57:57', '2018-04-09 01:57:57'),
(855, 29, 31, 10, 1, '2018-04-09 01:57:57', '2018-04-09 01:57:57'),
(856, 29, 3, 10, 1, '2018-04-09 01:57:57', '2018-04-09 01:57:57'),
(857, 29, 24, 10, 1, '2018-04-09 01:57:57', '2018-04-09 01:57:57'),
(858, 29, 27, 10, 1, '2018-04-09 01:57:57', '2018-04-09 01:57:57'),
(859, 29, 30, 10, 1, '2018-04-09 01:57:57', '2018-04-09 01:57:57'),
(860, 29, 38, 10, 1, '2018-04-09 01:57:57', '2018-04-09 01:57:57'),
(861, 29, 6, 10, 1, '2018-04-09 01:57:57', '2018-04-09 01:57:57'),
(862, 29, 8, 10, 1, '2018-04-09 01:57:58', '2018-04-09 01:57:58'),
(863, 29, 5, 10, 1, '2018-04-09 01:57:58', '2018-04-09 01:57:58'),
(864, 29, 26, 10, 1, '2018-04-09 01:57:58', '2018-04-09 01:57:58'),
(865, 29, 29, 10, 1, '2018-04-09 01:57:58', '2018-04-09 01:57:58'),
(866, 29, 33, 10, 1, '2018-04-09 01:57:58', '2018-04-09 01:57:58'),
(867, 29, 32, 10, 1, '2018-04-09 01:57:58', '2018-04-09 01:57:58'),
(868, 29, 20, 10, 1, '2018-04-09 01:57:58', '2018-04-09 01:57:58'),
(869, 1, 73, 0, 1, NULL, NULL),
(870, 1, 74, 0, 1, NULL, NULL),
(871, 1, 75, 0, 1, NULL, NULL),
(872, 1, 76, 0, 1, NULL, NULL),
(885, 1, 85, 0, 1, NULL, NULL),
(886, 1, 86, 0, 1, NULL, NULL),
(887, 1, 87, 0, 1, NULL, NULL),
(1023, 31, 90, 18, 1, '2018-05-10 02:03:27', '2018-05-10 02:03:27'),
(1024, 31, 4, 18, 1, '2018-05-10 02:03:27', '2018-05-10 02:03:27'),
(1025, 31, 38, 18, 1, '2018-05-10 02:03:27', '2018-05-10 02:03:27'),
(1026, 31, 88, 18, 1, '2018-05-10 02:03:27', '2018-05-10 02:03:27'),
(1027, 31, 91, 18, 1, '2018-05-10 02:03:27', '2018-05-10 02:03:27'),
(1028, 31, 87, 18, 1, '2018-05-10 02:03:27', '2018-05-10 02:03:27'),
(1029, 31, 92, 18, 1, '2018-05-10 02:03:27', '2018-05-10 02:03:27'),
(1030, 31, 94, 18, 1, '2018-05-10 02:03:27', '2018-05-10 02:03:27'),
(1031, 31, 75, 18, 1, '2018-05-10 02:03:27', '2018-05-10 02:03:27'),
(1032, 31, 93, 18, 1, '2018-05-10 02:03:28', '2018-05-10 02:03:28'),
(1033, 31, 83, 18, 1, '2018-05-10 02:03:28', '2018-05-10 02:03:28'),
(1034, 31, 85, 18, 1, '2018-05-10 02:03:28', '2018-05-10 02:03:28'),
(1035, 31, 84, 18, 1, '2018-05-10 02:03:28', '2018-05-10 02:03:28'),
(1036, 31, 89, 18, 1, '2018-05-10 02:03:28', '2018-05-10 02:03:28'),
(1037, 31, 86, 18, 1, '2018-05-10 02:03:28', '2018-05-10 02:03:28'),
(1038, 30, 25, 17, 1, '2018-05-16 01:57:34', '2018-05-16 01:57:34'),
(1039, 30, 67, 17, 1, '2018-05-16 01:57:34', '2018-05-16 01:57:34'),
(1040, 30, 90, 17, 1, '2018-05-16 01:57:34', '2018-05-16 01:57:34'),
(1041, 30, 68, 17, 1, '2018-05-16 01:57:34', '2018-05-16 01:57:34'),
(1042, 30, 71, 17, 1, '2018-05-16 01:57:34', '2018-05-16 01:57:34'),
(1043, 30, 70, 17, 1, '2018-05-16 01:57:34', '2018-05-16 01:57:34'),
(1044, 30, 28, 17, 1, '2018-05-16 01:57:34', '2018-05-16 01:57:34'),
(1045, 30, 19, 17, 1, '2018-05-16 01:57:34', '2018-05-16 01:57:34'),
(1046, 30, 72, 17, 1, '2018-05-16 01:57:34', '2018-05-16 01:57:34'),
(1047, 30, 69, 17, 1, '2018-05-16 01:57:35', '2018-05-16 01:57:35'),
(1048, 30, 18, 17, 1, '2018-05-16 01:57:35', '2018-05-16 01:57:35'),
(1049, 30, 4, 17, 1, '2018-05-16 01:57:35', '2018-05-16 01:57:35'),
(1050, 30, 31, 17, 1, '2018-05-16 01:57:35', '2018-05-16 01:57:35'),
(1051, 30, 3, 17, 1, '2018-05-16 01:57:35', '2018-05-16 01:57:35'),
(1052, 30, 24, 17, 1, '2018-05-16 01:57:35', '2018-05-16 01:57:35'),
(1053, 30, 27, 17, 1, '2018-05-16 01:57:35', '2018-05-16 01:57:35'),
(1054, 30, 95, 17, 1, '2018-05-16 01:57:35', '2018-05-16 01:57:35'),
(1055, 30, 30, 17, 1, '2018-05-16 01:57:35', '2018-05-16 01:57:35'),
(1056, 30, 89, 17, 1, '2018-05-16 01:57:35', '2018-05-16 01:57:35'),
(1057, 30, 38, 17, 1, '2018-05-16 01:57:35', '2018-05-16 01:57:35'),
(1058, 30, 76, 17, 1, '2018-05-16 01:57:35', '2018-05-16 01:57:35'),
(1059, 30, 88, 17, 1, '2018-05-16 01:57:35', '2018-05-16 01:57:35'),
(1060, 30, 6, 17, 1, '2018-05-16 01:57:35', '2018-05-16 01:57:35'),
(1061, 30, 8, 17, 1, '2018-05-16 01:57:35', '2018-05-16 01:57:35'),
(1062, 30, 5, 17, 1, '2018-05-16 01:57:35', '2018-05-16 01:57:35'),
(1063, 30, 26, 17, 1, '2018-05-16 01:57:35', '2018-05-16 01:57:35'),
(1064, 30, 29, 17, 1, '2018-05-16 01:57:35', '2018-05-16 01:57:35'),
(1065, 30, 33, 17, 1, '2018-05-16 01:57:35', '2018-05-16 01:57:35'),
(1066, 30, 32, 17, 1, '2018-05-16 01:57:35', '2018-05-16 01:57:35'),
(1067, 30, 20, 17, 1, '2018-05-16 01:57:35', '2018-05-16 01:57:35'),
(1068, 30, 91, 17, 1, '2018-05-16 01:57:35', '2018-05-16 01:57:35'),
(1069, 30, 87, 17, 1, '2018-05-16 01:57:35', '2018-05-16 01:57:35'),
(1070, 30, 92, 17, 1, '2018-05-16 01:57:35', '2018-05-16 01:57:35'),
(1071, 30, 94, 17, 1, '2018-05-16 01:57:35', '2018-05-16 01:57:35'),
(1072, 30, 75, 17, 1, '2018-05-16 01:57:36', '2018-05-16 01:57:36'),
(1073, 30, 93, 17, 1, '2018-05-16 01:57:36', '2018-05-16 01:57:36'),
(1074, 30, 83, 17, 1, '2018-05-16 01:57:36', '2018-05-16 01:57:36'),
(1075, 30, 85, 17, 1, '2018-05-16 01:57:36', '2018-05-16 01:57:36'),
(1076, 30, 84, 17, 1, '2018-05-16 01:57:36', '2018-05-16 01:57:36'),
(1077, 30, 78, 17, 1, '2018-05-16 01:57:36', '2018-05-16 01:57:36'),
(1078, 30, 86, 17, 1, '2018-05-16 01:57:36', '2018-05-16 01:57:36');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mxp_accounts_heads`
--
ALTER TABLE `mxp_accounts_heads`
  ADD PRIMARY KEY (`accounts_heads_id`);

--
-- Indexes for table `mxp_accounts_sub_heads`
--
ALTER TABLE `mxp_accounts_sub_heads`
  ADD PRIMARY KEY (`accounts_sub_heads_id`);

--
-- Indexes for table `mxp_acc_classes`
--
ALTER TABLE `mxp_acc_classes`
  ADD PRIMARY KEY (`mxp_acc_classes_id`);

--
-- Indexes for table `mxp_booking`
--
ALTER TABLE `mxp_booking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mxp_bookingBuyer_details`
--
ALTER TABLE `mxp_bookingBuyer_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mxp_booking_challan`
--
ALTER TABLE `mxp_booking_challan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mxp_booking_multipleChallan`
--
ALTER TABLE `mxp_booking_multipleChallan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mxp_brand`
--
ALTER TABLE `mxp_brand`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `mxp_challan`
--
ALTER TABLE `mxp_challan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mxp_companies`
--
ALTER TABLE `mxp_companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mxp_gmts_color`
--
ALTER TABLE `mxp_gmts_color`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mxp_header`
--
ALTER TABLE `mxp_header`
  ADD PRIMARY KEY (`header_id`);

--
-- Indexes for table `mxp_ipo`
--
ALTER TABLE `mxp_ipo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mxp_languages`
--
ALTER TABLE `mxp_languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mxp_maximBill`
--
ALTER TABLE `mxp_maximBill`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mxp_menu`
--
ALTER TABLE `mxp_menu`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indexes for table `Mxp_multipleChallan`
--
ALTER TABLE `Mxp_multipleChallan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mxp_order`
--
ALTER TABLE `mxp_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mxp_order_input`
--
ALTER TABLE `mxp_order_input`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mxp_pageFooter`
--
ALTER TABLE `mxp_pageFooter`
  ADD PRIMARY KEY (`footer_id`);

--
-- Indexes for table `mxp_pageHeader`
--
ALTER TABLE `mxp_pageHeader`
  ADD PRIMARY KEY (`header_id`);

--
-- Indexes for table `mxp_party`
--
ALTER TABLE `mxp_party`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mxp_piFormat_data_info`
--
ALTER TABLE `mxp_piFormat_data_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mxp_product`
--
ALTER TABLE `mxp_product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `mxp_productSize`
--
ALTER TABLE `mxp_productSize`
  ADD PRIMARY KEY (`proSize_id`);

--
-- Indexes for table `mxp_reportFooter`
--
ALTER TABLE `mxp_reportFooter`
  ADD PRIMARY KEY (`re_footer_id`);

--
-- Indexes for table `mxp_role`
--
ALTER TABLE `mxp_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mxp_translations`
--
ALTER TABLE `mxp_translations`
  ADD PRIMARY KEY (`translation_id`);

--
-- Indexes for table `mxp_translation_keys`
--
ALTER TABLE `mxp_translation_keys`
  ADD PRIMARY KEY (`translation_key_id`);

--
-- Indexes for table `mxp_users`
--
ALTER TABLE `mxp_users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `mxp_user_role_menu`
--
ALTER TABLE `mxp_user_role_menu`
  ADD PRIMARY KEY (`role_menu_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=246;

--
-- AUTO_INCREMENT for table `mxp_accounts_heads`
--
ALTER TABLE `mxp_accounts_heads`
  MODIFY `accounts_heads_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `mxp_accounts_sub_heads`
--
ALTER TABLE `mxp_accounts_sub_heads`
  MODIFY `accounts_sub_heads_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `mxp_acc_classes`
--
ALTER TABLE `mxp_acc_classes`
  MODIFY `mxp_acc_classes_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `mxp_booking`
--
ALTER TABLE `mxp_booking`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `mxp_bookingBuyer_details`
--
ALTER TABLE `mxp_bookingBuyer_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `mxp_booking_challan`
--
ALTER TABLE `mxp_booking_challan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `mxp_booking_multipleChallan`
--
ALTER TABLE `mxp_booking_multipleChallan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `mxp_brand`
--
ALTER TABLE `mxp_brand`
  MODIFY `brand_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `mxp_challan`
--
ALTER TABLE `mxp_challan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mxp_companies`
--
ALTER TABLE `mxp_companies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `mxp_gmts_color`
--
ALTER TABLE `mxp_gmts_color`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `mxp_header`
--
ALTER TABLE `mxp_header`
  MODIFY `header_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `mxp_ipo`
--
ALTER TABLE `mxp_ipo`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `mxp_languages`
--
ALTER TABLE `mxp_languages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `mxp_maximBill`
--
ALTER TABLE `mxp_maximBill`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `mxp_menu`
--
ALTER TABLE `mxp_menu`
  MODIFY `menu_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `Mxp_multipleChallan`
--
ALTER TABLE `Mxp_multipleChallan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `mxp_order`
--
ALTER TABLE `mxp_order`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `mxp_order_input`
--
ALTER TABLE `mxp_order_input`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mxp_pageFooter`
--
ALTER TABLE `mxp_pageFooter`
  MODIFY `footer_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mxp_pageHeader`
--
ALTER TABLE `mxp_pageHeader`
  MODIFY `header_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mxp_party`
--
ALTER TABLE `mxp_party`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `mxp_piFormat_data_info`
--
ALTER TABLE `mxp_piFormat_data_info`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `mxp_product`
--
ALTER TABLE `mxp_product`
  MODIFY `product_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `mxp_productSize`
--
ALTER TABLE `mxp_productSize`
  MODIFY `proSize_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `mxp_reportFooter`
--
ALTER TABLE `mxp_reportFooter`
  MODIFY `re_footer_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `mxp_role`
--
ALTER TABLE `mxp_role`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `mxp_translations`
--
ALTER TABLE `mxp_translations`
  MODIFY `translation_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=545;

--
-- AUTO_INCREMENT for table `mxp_translation_keys`
--
ALTER TABLE `mxp_translation_keys`
  MODIFY `translation_key_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=273;

--
-- AUTO_INCREMENT for table `mxp_users`
--
ALTER TABLE `mxp_users`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `mxp_user_role_menu`
--
ALTER TABLE `mxp_user_role_menu`
  MODIFY `role_menu_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1079;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
