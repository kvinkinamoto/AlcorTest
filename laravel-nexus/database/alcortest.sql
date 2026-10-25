
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `alcortest` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `alcortest`;
DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('laravel-cache-356a192b7913b04c54574d18c28d46e6395428ab','i:1;',1792943307),('laravel-cache-356a192b7913b04c54574d18c28d46e6395428ab:timer','i:1792943307;',1792943307),('laravel-cache-5c785c036466adea360111aa28563bfd556b5fba','i:1;',1792957418),('laravel-cache-5c785c036466adea360111aa28563bfd556b5fba:timer','i:1792957418;',1792957418),('laravel-cache-export_cNUtDpT2XA','a:4:{s:8:\"progress\";i:100;s:9:\"processed\";i:3;s:6:\"status\";s:9:\"completed\";s:8:\"filePath\";s:43:\"exports/Employee_20261025_175015_DpT2XA.csv\";}',1792954215),('laravel-cache-filament:notifications:58cK3P2VPUc2bgG3AeRe4Gu7OvkZHgPXViJb8KaR','a:4:{i:0;a:2:{s:12:\"notification\";a:12:{s:2:\"id\";s:36:\"a3115dc8-ef38-4c64-94b7-1627e47e3c50\";s:7:\"actions\";a:0:{}s:4:\"body\";N;s:5:\"color\";N;s:8:\"duration\";i:6000;s:4:\"icon\";s:23:\"heroicon-o-check-circle\";s:9:\"iconColor\";s:7:\"success\";s:8:\"iconSize\";N;s:6:\"status\";s:7:\"success\";s:5:\"title\";s:16:\"Adjustment saved\";s:4:\"view\";N;s:8:\"viewData\";a:0:{}}s:5:\"batch\";s:40:\"1e69b9d5d08b2085e3aa51d4d86672feae0f2419\";}i:1;a:2:{s:12:\"notification\";a:12:{s:2:\"id\";s:36:\"a311604f-4053-4350-9084-7adc42175e99\";s:7:\"actions\";a:0:{}s:4:\"body\";N;s:5:\"color\";N;s:8:\"duration\";i:6000;s:4:\"icon\";s:23:\"heroicon-o-check-circle\";s:9:\"iconColor\";s:7:\"success\";s:8:\"iconSize\";N;s:6:\"status\";s:7:\"success\";s:5:\"title\";s:24:\"Line for 2026-10 created\";s:4:\"view\";N;s:8:\"viewData\";a:0:{}}s:5:\"batch\";s:40:\"7fd1f17b5fc83f6532c14df4ace7520fce792f1f\";}i:2;a:2:{s:12:\"notification\";a:12:{s:2:\"id\";s:36:\"a31160fd-987e-49c4-835a-92731b6d6e18\";s:7:\"actions\";a:0:{}s:4:\"body\";N;s:5:\"color\";N;s:8:\"duration\";i:6000;s:4:\"icon\";s:23:\"heroicon-o-check-circle\";s:9:\"iconColor\";s:7:\"success\";s:8:\"iconSize\";N;s:6:\"status\";s:7:\"success\";s:5:\"title\";s:16:\"Adjustment saved\";s:4:\"view\";N;s:8:\"viewData\";a:0:{}}s:5:\"batch\";s:40:\"068e30b982876d5181b806c1793379cd7be4c51a\";}i:3;a:2:{s:12:\"notification\";a:12:{s:2:\"id\";s:36:\"a3116112-c637-466f-8a1a-aa0668508913\";s:7:\"actions\";a:0:{}s:4:\"body\";N;s:5:\"color\";N;s:8:\"duration\";i:6000;s:4:\"icon\";s:23:\"heroicon-o-check-circle\";s:9:\"iconColor\";s:7:\"success\";s:8:\"iconSize\";N;s:6:\"status\";s:7:\"success\";s:5:\"title\";s:5:\"Saved\";s:4:\"view\";N;s:8:\"viewData\";a:0:{}}s:5:\"batch\";s:40:\"485623c14078f7a7a69ab7d9da66eca0e1636f0e\";}}',1792957603),('laravel-cache-livewire-rate-limiter:16d36dff9abd246c67dfac3e63b993a169af77e6','i:1;',1792949819),('laravel-cache-livewire-rate-limiter:16d36dff9abd246c67dfac3e63b993a169af77e6:timer','i:1792949819;',1792949819),('laravel-cache-spatie.permission.cache','a:3:{s:5:\"alias\";a:5:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"f\";s:12:\"display_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:142:{i:0;a:5:{s:1:\"a\";i:1;s:1:\"b\";s:19:\"auth_SHOW_SIDE_MENU\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:76:\"{\"en\": \"Auth: Show in Menu\", \"uk\": \"Auth: Показувати в меню\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:1;a:5:{s:1:\"a\";i:2;s:1:\"b\";s:10:\"auth_index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:71:\"{\"en\": \"Auth: List records\", \"uk\": \"Auth: Список записів\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:2;a:5:{s:1:\"a\";i:3;s:1:\"b\";s:11:\"auth_create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:72:\"{\"en\": \"Auth: Create record\", \"uk\": \"Auth: Створити запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:3;a:5:{s:1:\"a\";i:4;s:1:\"b\";s:10:\"auth_store\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:71:\"{\"en\": \"Auth: Store record\", \"uk\": \"Auth: Зберегти запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:4;a:5:{s:1:\"a\";i:5;s:1:\"b\";s:9:\"auth_edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:74:\"{\"en\": \"Auth: Edit record\", \"uk\": \"Auth: Редагувати запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:5;a:5:{s:1:\"a\";i:6;s:1:\"b\";s:11:\"auth_update\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:70:\"{\"en\": \"Auth: Update record\", \"uk\": \"Auth: Оновити запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:6;a:5:{s:1:\"a\";i:7;s:1:\"b\";s:11:\"auth_delete\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:72:\"{\"en\": \"Auth: Delete record\", \"uk\": \"Auth: Видалити запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:7;a:5:{s:1:\"a\";i:8;s:1:\"b\";s:20:\"auth_deletePermanent\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:83:\"{\"en\": \"Auth: Delete permanently\", \"uk\": \"Auth: Видалити назавжди\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:8;a:5:{s:1:\"a\";i:9;s:1:\"b\";s:12:\"auth_restore\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:75:\"{\"en\": \"Auth: Restore record\", \"uk\": \"Auth: Відновити запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:9;a:5:{s:1:\"a\";i:10;s:1:\"b\";s:16:\"auth_deleteGroup\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:71:\"{\"en\": \"Auth: Delete group\", \"uk\": \"Auth: Видалити групу\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:10;a:5:{s:1:\"a\";i:11;s:1:\"b\";s:15:\"auth_boolToggle\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:75:\"{\"en\": \"Auth: Toggle boolean\", \"uk\": \"Auth: Перемкнути стан\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:11;a:5:{s:1:\"a\";i:12;s:1:\"b\";s:13:\"auth_ordering\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:76:\"{\"en\": \"Auth: Change ordering\", \"uk\": \"Auth: Змінити порядок\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:12;a:5:{s:1:\"a\";i:13;s:1:\"b\";s:9:\"auth_view\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:76:\"{\"en\": \"Auth: View record\", \"uk\": \"Auth: Переглянути запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:13;a:5:{s:1:\"a\";i:14;s:1:\"b\";s:14:\"auth_duplicate\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:77:\"{\"en\": \"Auth: Duplicate record\", \"uk\": \"Auth: Дублювати запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:14;a:5:{s:1:\"a\";i:15;s:1:\"b\";s:19:\"auth_duplicateGroup\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:76:\"{\"en\": \"Auth: Duplicate group\", \"uk\": \"Auth: Дублювати групу\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:15;a:5:{s:1:\"a\";i:16;s:1:\"b\";s:16:\"auth_impersonate\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:54:\"{\"en\": \"Auth: Impersonate\", \"uk\": \"Auth: Impersonate\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:16;a:5:{s:1:\"a\";i:17;s:1:\"b\";s:25:\"permission_SHOW_SIDE_MENU\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:88:\"{\"en\": \"Permission: Show in Menu\", \"uk\": \"Permission: Показувати в меню\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:17;a:5:{s:1:\"a\";i:18;s:1:\"b\";s:16:\"permission_index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:83:\"{\"en\": \"Permission: List records\", \"uk\": \"Permission: Список записів\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:18;a:5:{s:1:\"a\";i:19;s:1:\"b\";s:17:\"permission_create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:84:\"{\"en\": \"Permission: Create record\", \"uk\": \"Permission: Створити запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:19;a:5:{s:1:\"a\";i:20;s:1:\"b\";s:16:\"permission_store\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:83:\"{\"en\": \"Permission: Store record\", \"uk\": \"Permission: Зберегти запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:20;a:5:{s:1:\"a\";i:21;s:1:\"b\";s:15:\"permission_edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:86:\"{\"en\": \"Permission: Edit record\", \"uk\": \"Permission: Редагувати запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:21;a:5:{s:1:\"a\";i:22;s:1:\"b\";s:17:\"permission_update\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:82:\"{\"en\": \"Permission: Update record\", \"uk\": \"Permission: Оновити запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:22;a:5:{s:1:\"a\";i:23;s:1:\"b\";s:17:\"permission_delete\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:84:\"{\"en\": \"Permission: Delete record\", \"uk\": \"Permission: Видалити запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:23;a:5:{s:1:\"a\";i:24;s:1:\"b\";s:26:\"permission_deletePermanent\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:95:\"{\"en\": \"Permission: Delete permanently\", \"uk\": \"Permission: Видалити назавжди\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:24;a:5:{s:1:\"a\";i:25;s:1:\"b\";s:18:\"permission_restore\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:87:\"{\"en\": \"Permission: Restore record\", \"uk\": \"Permission: Відновити запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:25;a:5:{s:1:\"a\";i:26;s:1:\"b\";s:22:\"permission_deleteGroup\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:83:\"{\"en\": \"Permission: Delete group\", \"uk\": \"Permission: Видалити групу\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:26;a:5:{s:1:\"a\";i:27;s:1:\"b\";s:21:\"permission_boolToggle\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:87:\"{\"en\": \"Permission: Toggle boolean\", \"uk\": \"Permission: Перемкнути стан\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:27;a:5:{s:1:\"a\";i:28;s:1:\"b\";s:19:\"permission_ordering\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:88:\"{\"en\": \"Permission: Change ordering\", \"uk\": \"Permission: Змінити порядок\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:28;a:5:{s:1:\"a\";i:29;s:1:\"b\";s:15:\"permission_view\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:88:\"{\"en\": \"Permission: View record\", \"uk\": \"Permission: Переглянути запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:29;a:5:{s:1:\"a\";i:30;s:1:\"b\";s:20:\"permission_duplicate\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:89:\"{\"en\": \"Permission: Duplicate record\", \"uk\": \"Permission: Дублювати запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:30;a:5:{s:1:\"a\";i:31;s:1:\"b\";s:25:\"permission_duplicateGroup\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:88:\"{\"en\": \"Permission: Duplicate group\", \"uk\": \"Permission: Дублювати групу\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:31;a:5:{s:1:\"a\";i:32;s:1:\"b\";s:22:\"permission_impersonate\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:66:\"{\"en\": \"Permission: Impersonate\", \"uk\": \"Permission: Impersonate\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:32;a:5:{s:1:\"a\";i:33;s:1:\"b\";s:19:\"role_SHOW_SIDE_MENU\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:76:\"{\"en\": \"Role: Show in Menu\", \"uk\": \"Role: Показувати в меню\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:33;a:5:{s:1:\"a\";i:34;s:1:\"b\";s:10:\"role_index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:71:\"{\"en\": \"Role: List records\", \"uk\": \"Role: Список записів\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:34;a:5:{s:1:\"a\";i:35;s:1:\"b\";s:11:\"role_create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:72:\"{\"en\": \"Role: Create record\", \"uk\": \"Role: Створити запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:35;a:5:{s:1:\"a\";i:36;s:1:\"b\";s:10:\"role_store\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:71:\"{\"en\": \"Role: Store record\", \"uk\": \"Role: Зберегти запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:36;a:5:{s:1:\"a\";i:37;s:1:\"b\";s:9:\"role_edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:74:\"{\"en\": \"Role: Edit record\", \"uk\": \"Role: Редагувати запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:37;a:5:{s:1:\"a\";i:38;s:1:\"b\";s:11:\"role_update\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:70:\"{\"en\": \"Role: Update record\", \"uk\": \"Role: Оновити запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:38;a:5:{s:1:\"a\";i:39;s:1:\"b\";s:11:\"role_delete\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:72:\"{\"en\": \"Role: Delete record\", \"uk\": \"Role: Видалити запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:39;a:5:{s:1:\"a\";i:40;s:1:\"b\";s:20:\"role_deletePermanent\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:83:\"{\"en\": \"Role: Delete permanently\", \"uk\": \"Role: Видалити назавжди\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:40;a:5:{s:1:\"a\";i:41;s:1:\"b\";s:12:\"role_restore\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:75:\"{\"en\": \"Role: Restore record\", \"uk\": \"Role: Відновити запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:41;a:5:{s:1:\"a\";i:42;s:1:\"b\";s:16:\"role_deleteGroup\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:71:\"{\"en\": \"Role: Delete group\", \"uk\": \"Role: Видалити групу\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:42;a:5:{s:1:\"a\";i:43;s:1:\"b\";s:15:\"role_boolToggle\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:75:\"{\"en\": \"Role: Toggle boolean\", \"uk\": \"Role: Перемкнути стан\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:43;a:5:{s:1:\"a\";i:44;s:1:\"b\";s:13:\"role_ordering\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:76:\"{\"en\": \"Role: Change ordering\", \"uk\": \"Role: Змінити порядок\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:44;a:5:{s:1:\"a\";i:45;s:1:\"b\";s:9:\"role_view\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:76:\"{\"en\": \"Role: View record\", \"uk\": \"Role: Переглянути запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:45;a:5:{s:1:\"a\";i:46;s:1:\"b\";s:14:\"role_duplicate\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:77:\"{\"en\": \"Role: Duplicate record\", \"uk\": \"Role: Дублювати запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:46;a:5:{s:1:\"a\";i:47;s:1:\"b\";s:19:\"role_duplicateGroup\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:76:\"{\"en\": \"Role: Duplicate group\", \"uk\": \"Role: Дублювати групу\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:47;a:5:{s:1:\"a\";i:48;s:1:\"b\";s:16:\"role_impersonate\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:54:\"{\"en\": \"Role: Impersonate\", \"uk\": \"Role: Impersonate\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:48;a:5:{s:1:\"a\";i:49;s:1:\"b\";s:19:\"user_SHOW_SIDE_MENU\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:76:\"{\"en\": \"User: Show in Menu\", \"uk\": \"User: Показувати в меню\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:49;a:5:{s:1:\"a\";i:50;s:1:\"b\";s:10:\"user_index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:71:\"{\"en\": \"User: List records\", \"uk\": \"User: Список записів\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:50;a:5:{s:1:\"a\";i:51;s:1:\"b\";s:11:\"user_create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:72:\"{\"en\": \"User: Create record\", \"uk\": \"User: Створити запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:51;a:5:{s:1:\"a\";i:52;s:1:\"b\";s:10:\"user_store\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:71:\"{\"en\": \"User: Store record\", \"uk\": \"User: Зберегти запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:52;a:5:{s:1:\"a\";i:53;s:1:\"b\";s:9:\"user_edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:74:\"{\"en\": \"User: Edit record\", \"uk\": \"User: Редагувати запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:53;a:5:{s:1:\"a\";i:54;s:1:\"b\";s:11:\"user_update\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:70:\"{\"en\": \"User: Update record\", \"uk\": \"User: Оновити запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:54;a:5:{s:1:\"a\";i:55;s:1:\"b\";s:11:\"user_delete\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:72:\"{\"en\": \"User: Delete record\", \"uk\": \"User: Видалити запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:55;a:5:{s:1:\"a\";i:56;s:1:\"b\";s:20:\"user_deletePermanent\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:83:\"{\"en\": \"User: Delete permanently\", \"uk\": \"User: Видалити назавжди\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:56;a:5:{s:1:\"a\";i:57;s:1:\"b\";s:12:\"user_restore\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:75:\"{\"en\": \"User: Restore record\", \"uk\": \"User: Відновити запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:57;a:5:{s:1:\"a\";i:58;s:1:\"b\";s:16:\"user_deleteGroup\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:71:\"{\"en\": \"User: Delete group\", \"uk\": \"User: Видалити групу\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:58;a:5:{s:1:\"a\";i:59;s:1:\"b\";s:15:\"user_boolToggle\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:75:\"{\"en\": \"User: Toggle boolean\", \"uk\": \"User: Перемкнути стан\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:59;a:5:{s:1:\"a\";i:60;s:1:\"b\";s:13:\"user_ordering\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:76:\"{\"en\": \"User: Change ordering\", \"uk\": \"User: Змінити порядок\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:60;a:5:{s:1:\"a\";i:61;s:1:\"b\";s:9:\"user_view\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:76:\"{\"en\": \"User: View record\", \"uk\": \"User: Переглянути запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:61;a:5:{s:1:\"a\";i:62;s:1:\"b\";s:14:\"user_duplicate\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:77:\"{\"en\": \"User: Duplicate record\", \"uk\": \"User: Дублювати запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:62;a:5:{s:1:\"a\";i:63;s:1:\"b\";s:19:\"user_duplicateGroup\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:76:\"{\"en\": \"User: Duplicate group\", \"uk\": \"User: Дублювати групу\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:63;a:5:{s:1:\"a\";i:64;s:1:\"b\";s:16:\"user_impersonate\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:54:\"{\"en\": \"User: Impersonate\", \"uk\": \"User: Impersonate\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:64;a:5:{s:1:\"a\";i:65;s:1:\"b\";s:3:\"ALL\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:13:\"{\"en\": \"All\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:65;a:5:{s:1:\"a\";i:66;s:1:\"b\";s:14:\"SHOW_SIDE_MENU\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:24:\"{\"en\": \"Show side menu\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:66;a:5:{s:1:\"a\";i:67;s:1:\"b\";s:5:\"INDEX\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:15:\"{\"en\": \"Index\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:67;a:5:{s:1:\"a\";i:68;s:1:\"b\";s:5:\"EDITE\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:15:\"{\"en\": \"Edite\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:68;a:5:{s:1:\"a\";i:69;s:1:\"b\";s:6:\"UPDATE\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:16:\"{\"en\": \"Update\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:69;a:5:{s:1:\"a\";i:70;s:1:\"b\";s:6:\"CREATE\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:16:\"{\"en\": \"Create\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:70;a:5:{s:1:\"a\";i:71;s:1:\"b\";s:5:\"STORE\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:15:\"{\"en\": \"Store\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:71;a:5:{s:1:\"a\";i:72;s:1:\"b\";s:6:\"DELETE\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:16:\"{\"en\": \"Delete\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:72;a:5:{s:1:\"a\";i:73;s:1:\"b\";s:7:\"RESTORE\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:17:\"{\"en\": \"Restore\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:73;a:5:{s:1:\"a\";i:74;s:1:\"b\";s:16:\"DELETE_PERMANENT\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:26:\"{\"en\": \"Delete permanent\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:74;a:5:{s:1:\"a\";i:75;s:1:\"b\";s:12:\"DELETE_GROUP\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:22:\"{\"en\": \"Delete group\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:75;a:5:{s:1:\"a\";i:76;s:1:\"b\";s:8:\"ORDERING\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:18:\"{\"en\": \"Ordering\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:76;a:5:{s:1:\"a\";i:77;s:1:\"b\";s:11:\"BOOL_TOGGLE\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:21:\"{\"en\": \"Bool toggle\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:77;a:5:{s:1:\"a\";i:78;s:1:\"b\";s:11:\"ADMIN_PANEL\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:21:\"{\"en\": \"Admin panel\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:78;a:5:{s:1:\"a\";i:111;s:1:\"b\";s:23:\"employee_SHOW_SIDE_MENU\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:84:\"{\"en\": \"Employee: Show in Menu\", \"uk\": \"Employee: Показувати в меню\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:79;a:5:{s:1:\"a\";i:112;s:1:\"b\";s:14:\"employee_index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:79:\"{\"en\": \"Employee: List records\", \"uk\": \"Employee: Список записів\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:80;a:5:{s:1:\"a\";i:113;s:1:\"b\";s:15:\"employee_create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:80:\"{\"en\": \"Employee: Create record\", \"uk\": \"Employee: Створити запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:81;a:5:{s:1:\"a\";i:114;s:1:\"b\";s:14:\"employee_store\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:79:\"{\"en\": \"Employee: Store record\", \"uk\": \"Employee: Зберегти запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:82;a:5:{s:1:\"a\";i:115;s:1:\"b\";s:13:\"employee_edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:82:\"{\"en\": \"Employee: Edit record\", \"uk\": \"Employee: Редагувати запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:83;a:5:{s:1:\"a\";i:116;s:1:\"b\";s:15:\"employee_update\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:78:\"{\"en\": \"Employee: Update record\", \"uk\": \"Employee: Оновити запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:84;a:5:{s:1:\"a\";i:117;s:1:\"b\";s:15:\"employee_delete\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:80:\"{\"en\": \"Employee: Delete record\", \"uk\": \"Employee: Видалити запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:85;a:5:{s:1:\"a\";i:118;s:1:\"b\";s:24:\"employee_deletePermanent\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:91:\"{\"en\": \"Employee: Delete permanently\", \"uk\": \"Employee: Видалити назавжди\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:86;a:5:{s:1:\"a\";i:119;s:1:\"b\";s:16:\"employee_restore\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:83:\"{\"en\": \"Employee: Restore record\", \"uk\": \"Employee: Відновити запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:87;a:5:{s:1:\"a\";i:120;s:1:\"b\";s:20:\"employee_deleteGroup\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:79:\"{\"en\": \"Employee: Delete group\", \"uk\": \"Employee: Видалити групу\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:88;a:5:{s:1:\"a\";i:121;s:1:\"b\";s:19:\"employee_boolToggle\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:83:\"{\"en\": \"Employee: Toggle boolean\", \"uk\": \"Employee: Перемкнути стан\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:89;a:5:{s:1:\"a\";i:122;s:1:\"b\";s:17:\"employee_ordering\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:84:\"{\"en\": \"Employee: Change ordering\", \"uk\": \"Employee: Змінити порядок\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:90;a:5:{s:1:\"a\";i:123;s:1:\"b\";s:13:\"employee_view\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:84:\"{\"en\": \"Employee: View record\", \"uk\": \"Employee: Переглянути запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:91;a:5:{s:1:\"a\";i:124;s:1:\"b\";s:18:\"employee_duplicate\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:85:\"{\"en\": \"Employee: Duplicate record\", \"uk\": \"Employee: Дублювати запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:92;a:5:{s:1:\"a\";i:125;s:1:\"b\";s:23:\"employee_duplicateGroup\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:84:\"{\"en\": \"Employee: Duplicate group\", \"uk\": \"Employee: Дублювати групу\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:93;a:5:{s:1:\"a\";i:126;s:1:\"b\";s:20:\"employee_impersonate\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:62:\"{\"en\": \"Employee: Impersonate\", \"uk\": \"Employee: Impersonate\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:94;a:5:{s:1:\"a\";i:127;s:1:\"b\";s:26:\"payrollLine_SHOW_SIDE_MENU\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:90:\"{\"en\": \"PayrollLine: Show in Menu\", \"uk\": \"PayrollLine: Показувати в меню\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:95;a:5:{s:1:\"a\";i:128;s:1:\"b\";s:17:\"payrollLine_index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:85:\"{\"en\": \"PayrollLine: List records\", \"uk\": \"PayrollLine: Список записів\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:96;a:5:{s:1:\"a\";i:129;s:1:\"b\";s:18:\"payrollLine_create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:86:\"{\"en\": \"PayrollLine: Create record\", \"uk\": \"PayrollLine: Створити запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:97;a:5:{s:1:\"a\";i:130;s:1:\"b\";s:17:\"payrollLine_store\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:85:\"{\"en\": \"PayrollLine: Store record\", \"uk\": \"PayrollLine: Зберегти запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:98;a:5:{s:1:\"a\";i:131;s:1:\"b\";s:16:\"payrollLine_edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:88:\"{\"en\": \"PayrollLine: Edit record\", \"uk\": \"PayrollLine: Редагувати запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:99;a:5:{s:1:\"a\";i:132;s:1:\"b\";s:18:\"payrollLine_update\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:84:\"{\"en\": \"PayrollLine: Update record\", \"uk\": \"PayrollLine: Оновити запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:100;a:5:{s:1:\"a\";i:133;s:1:\"b\";s:18:\"payrollLine_delete\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:86:\"{\"en\": \"PayrollLine: Delete record\", \"uk\": \"PayrollLine: Видалити запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:101;a:5:{s:1:\"a\";i:134;s:1:\"b\";s:27:\"payrollLine_deletePermanent\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:97:\"{\"en\": \"PayrollLine: Delete permanently\", \"uk\": \"PayrollLine: Видалити назавжди\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:102;a:5:{s:1:\"a\";i:135;s:1:\"b\";s:19:\"payrollLine_restore\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:89:\"{\"en\": \"PayrollLine: Restore record\", \"uk\": \"PayrollLine: Відновити запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:103;a:5:{s:1:\"a\";i:136;s:1:\"b\";s:23:\"payrollLine_deleteGroup\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:85:\"{\"en\": \"PayrollLine: Delete group\", \"uk\": \"PayrollLine: Видалити групу\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:104;a:5:{s:1:\"a\";i:137;s:1:\"b\";s:22:\"payrollLine_boolToggle\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:89:\"{\"en\": \"PayrollLine: Toggle boolean\", \"uk\": \"PayrollLine: Перемкнути стан\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:105;a:5:{s:1:\"a\";i:138;s:1:\"b\";s:20:\"payrollLine_ordering\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:90:\"{\"en\": \"PayrollLine: Change ordering\", \"uk\": \"PayrollLine: Змінити порядок\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:106;a:5:{s:1:\"a\";i:139;s:1:\"b\";s:16:\"payrollLine_view\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:90:\"{\"en\": \"PayrollLine: View record\", \"uk\": \"PayrollLine: Переглянути запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:107;a:5:{s:1:\"a\";i:140;s:1:\"b\";s:21:\"payrollLine_duplicate\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:91:\"{\"en\": \"PayrollLine: Duplicate record\", \"uk\": \"PayrollLine: Дублювати запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:108;a:5:{s:1:\"a\";i:141;s:1:\"b\";s:26:\"payrollLine_duplicateGroup\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:90:\"{\"en\": \"PayrollLine: Duplicate group\", \"uk\": \"PayrollLine: Дублювати групу\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:109;a:5:{s:1:\"a\";i:142;s:1:\"b\";s:23:\"payrollLine_impersonate\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:68:\"{\"en\": \"PayrollLine: Impersonate\", \"uk\": \"PayrollLine: Impersonate\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:110;a:5:{s:1:\"a\";i:143;s:1:\"b\";s:27:\"payrollaudit_SHOW_SIDE_MENU\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:92:\"{\"en\": \"PayrollAudit: Show in Menu\", \"uk\": \"PayrollAudit: Показувати в меню\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:111;a:5:{s:1:\"a\";i:144;s:1:\"b\";s:18:\"payrollaudit_index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:87:\"{\"en\": \"PayrollAudit: List records\", \"uk\": \"PayrollAudit: Список записів\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:112;a:5:{s:1:\"a\";i:145;s:1:\"b\";s:19:\"payrollaudit_create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:88:\"{\"en\": \"PayrollAudit: Create record\", \"uk\": \"PayrollAudit: Створити запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:113;a:5:{s:1:\"a\";i:146;s:1:\"b\";s:18:\"payrollaudit_store\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:87:\"{\"en\": \"PayrollAudit: Store record\", \"uk\": \"PayrollAudit: Зберегти запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:114;a:5:{s:1:\"a\";i:147;s:1:\"b\";s:17:\"payrollaudit_edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:90:\"{\"en\": \"PayrollAudit: Edit record\", \"uk\": \"PayrollAudit: Редагувати запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:115;a:5:{s:1:\"a\";i:148;s:1:\"b\";s:19:\"payrollaudit_update\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:86:\"{\"en\": \"PayrollAudit: Update record\", \"uk\": \"PayrollAudit: Оновити запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:116;a:5:{s:1:\"a\";i:149;s:1:\"b\";s:19:\"payrollaudit_delete\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:88:\"{\"en\": \"PayrollAudit: Delete record\", \"uk\": \"PayrollAudit: Видалити запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:117;a:5:{s:1:\"a\";i:150;s:1:\"b\";s:28:\"payrollaudit_deletePermanent\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:99:\"{\"en\": \"PayrollAudit: Delete permanently\", \"uk\": \"PayrollAudit: Видалити назавжди\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:118;a:5:{s:1:\"a\";i:151;s:1:\"b\";s:20:\"payrollaudit_restore\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:91:\"{\"en\": \"PayrollAudit: Restore record\", \"uk\": \"PayrollAudit: Відновити запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:119;a:5:{s:1:\"a\";i:152;s:1:\"b\";s:24:\"payrollaudit_deleteGroup\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:87:\"{\"en\": \"PayrollAudit: Delete group\", \"uk\": \"PayrollAudit: Видалити групу\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:120;a:5:{s:1:\"a\";i:153;s:1:\"b\";s:23:\"payrollaudit_boolToggle\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:91:\"{\"en\": \"PayrollAudit: Toggle boolean\", \"uk\": \"PayrollAudit: Перемкнути стан\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:121;a:5:{s:1:\"a\";i:154;s:1:\"b\";s:21:\"payrollaudit_ordering\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:92:\"{\"en\": \"PayrollAudit: Change ordering\", \"uk\": \"PayrollAudit: Змінити порядок\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:122;a:5:{s:1:\"a\";i:155;s:1:\"b\";s:17:\"payrollaudit_view\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:92:\"{\"en\": \"PayrollAudit: View record\", \"uk\": \"PayrollAudit: Переглянути запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:123;a:5:{s:1:\"a\";i:156;s:1:\"b\";s:22:\"payrollaudit_duplicate\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:93:\"{\"en\": \"PayrollAudit: Duplicate record\", \"uk\": \"PayrollAudit: Дублювати запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:124;a:5:{s:1:\"a\";i:157;s:1:\"b\";s:27:\"payrollaudit_duplicateGroup\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:92:\"{\"en\": \"PayrollAudit: Duplicate group\", \"uk\": \"PayrollAudit: Дублювати групу\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:125;a:5:{s:1:\"a\";i:158;s:1:\"b\";s:24:\"payrollaudit_impersonate\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:70:\"{\"en\": \"PayrollAudit: Impersonate\", \"uk\": \"PayrollAudit: Impersonate\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:126;a:5:{s:1:\"a\";i:159;s:1:\"b\";s:32:\"payrollAdjustment_SHOW_SIDE_MENU\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:102:\"{\"en\": \"PayrollAdjustment: Show in Menu\", \"uk\": \"PayrollAdjustment: Показувати в меню\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:127;a:5:{s:1:\"a\";i:160;s:1:\"b\";s:23:\"payrollAdjustment_index\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:97:\"{\"en\": \"PayrollAdjustment: List records\", \"uk\": \"PayrollAdjustment: Список записів\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:128;a:5:{s:1:\"a\";i:161;s:1:\"b\";s:24:\"payrollAdjustment_create\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:98:\"{\"en\": \"PayrollAdjustment: Create record\", \"uk\": \"PayrollAdjustment: Створити запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:129;a:5:{s:1:\"a\";i:162;s:1:\"b\";s:23:\"payrollAdjustment_store\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:97:\"{\"en\": \"PayrollAdjustment: Store record\", \"uk\": \"PayrollAdjustment: Зберегти запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:130;a:5:{s:1:\"a\";i:163;s:1:\"b\";s:22:\"payrollAdjustment_edit\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:100:\"{\"en\": \"PayrollAdjustment: Edit record\", \"uk\": \"PayrollAdjustment: Редагувати запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:131;a:5:{s:1:\"a\";i:164;s:1:\"b\";s:24:\"payrollAdjustment_update\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:96:\"{\"en\": \"PayrollAdjustment: Update record\", \"uk\": \"PayrollAdjustment: Оновити запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:132;a:5:{s:1:\"a\";i:165;s:1:\"b\";s:24:\"payrollAdjustment_delete\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:98:\"{\"en\": \"PayrollAdjustment: Delete record\", \"uk\": \"PayrollAdjustment: Видалити запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:133;a:5:{s:1:\"a\";i:166;s:1:\"b\";s:33:\"payrollAdjustment_deletePermanent\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:109:\"{\"en\": \"PayrollAdjustment: Delete permanently\", \"uk\": \"PayrollAdjustment: Видалити назавжди\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:134;a:5:{s:1:\"a\";i:167;s:1:\"b\";s:25:\"payrollAdjustment_restore\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:101:\"{\"en\": \"PayrollAdjustment: Restore record\", \"uk\": \"PayrollAdjustment: Відновити запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:135;a:5:{s:1:\"a\";i:168;s:1:\"b\";s:29:\"payrollAdjustment_deleteGroup\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:97:\"{\"en\": \"PayrollAdjustment: Delete group\", \"uk\": \"PayrollAdjustment: Видалити групу\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:136;a:5:{s:1:\"a\";i:169;s:1:\"b\";s:28:\"payrollAdjustment_boolToggle\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:101:\"{\"en\": \"PayrollAdjustment: Toggle boolean\", \"uk\": \"PayrollAdjustment: Перемкнути стан\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:137;a:5:{s:1:\"a\";i:170;s:1:\"b\";s:26:\"payrollAdjustment_ordering\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:102:\"{\"en\": \"PayrollAdjustment: Change ordering\", \"uk\": \"PayrollAdjustment: Змінити порядок\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:138;a:5:{s:1:\"a\";i:171;s:1:\"b\";s:22:\"payrollAdjustment_view\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:102:\"{\"en\": \"PayrollAdjustment: View record\", \"uk\": \"PayrollAdjustment: Переглянути запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:139;a:5:{s:1:\"a\";i:172;s:1:\"b\";s:27:\"payrollAdjustment_duplicate\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:103:\"{\"en\": \"PayrollAdjustment: Duplicate record\", \"uk\": \"PayrollAdjustment: Дублювати запис\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:140;a:5:{s:1:\"a\";i:173;s:1:\"b\";s:32:\"payrollAdjustment_duplicateGroup\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:102:\"{\"en\": \"PayrollAdjustment: Duplicate group\", \"uk\": \"PayrollAdjustment: Дублювати групу\"}\";s:1:\"r\";a:1:{i:0;i:1;}}i:141;a:5:{s:1:\"a\";i:174;s:1:\"b\";s:29:\"payrollAdjustment_impersonate\";s:1:\"c\";s:3:\"web\";s:1:\"f\";s:80:\"{\"en\": \"PayrollAdjustment: Impersonate\", \"uk\": \"PayrollAdjustment: Impersonate\"}\";s:1:\"r\";a:1:{i:0;i:1;}}}s:5:\"roles\";a:1:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"b\";s:11:\"super-admin\";s:1:\"c\";s:3:\"web\";s:1:\"f\";N;}}}',1793043760);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `employees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employees` (
  `id` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency` char(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'USD',
  `base_salary` decimal(14,2) NOT NULL,
  `benefits_deduction` decimal(14,2) NOT NULL DEFAULT '0.00',
  `bonus` decimal(14,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `employees` WRITE;
/*!40000 ALTER TABLE `employees` DISABLE KEYS */;
INSERT INTO `employees` VALUES ('anna','Anna Koval','USD',1300.00,0.00,0.00,'2026-10-25 15:52:08','2026-10-18 07:00:00'),('bohdan','Bohdan Melnyk','USD',2400.00,0.00,0.00,'2026-10-25 15:52:08','2026-10-25 15:52:08'),('olena','Olena Shevchenko','USD',1850.50,0.00,100.00,'2026-10-25 15:52:08','2026-10-25 15:52:08');
/*!40000 ALTER TABLE `employees` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(6,'2025_01_01_000000_create_nexus_tables',2),(7,'2025_01_02_000000_create_nexus_dashboard_layouts_table',2),(8,'2025_01_03_000000_create_widget_instances_table',2),(9,'2025_01_03_000001_create_widget_assignments_table',2),(10,'2025_01_04_000000_add_is_system_to_nexus_modules_table',2),(11,'2026_09_07_000000_add_unique_module_key_to_nexus_module_settings_table',2),(12,'2026_10_23_091814_create_permission_tables',2),(13,'2026_10_23_091824_create_notifications_table',2),(14,'2026_10_23_091815_user_create_user_addresses_table',3),(15,'2026_10_23_091817_user_user_add_profile_columns_to_users_table',3),(16,'2026_10_23_091815_permission_permission_add_display_field',4),(17,'2026_10_23_091815_role_role_add_display_field',5),(20,'2026_10_24_000000_create_payroll_tables',8),(24,'2026_10_23_101829_create_payroll_adjustments_table',12),(32,'2026_10_26_000000_create_event_sourced_payroll_tables',16),(33,'2026_10_23_101825_create_employees_table',17),(34,'2026_10_23_101827_create_payroll_lines_table',17),(35,'2026_10_23_101828_create_payroll_audits_table',17);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` VALUES (1,'App\\Models\\User',1);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `nexus_dashboard_layouts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `nexus_dashboard_layouts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `layout` json NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nexus_dashboard_layouts_user_id_unique` (`user_id`),
  CONSTRAINT `nexus_dashboard_layouts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `nexus_dashboard_layouts` WRITE;
/*!40000 ALTER TABLE `nexus_dashboard_layouts` DISABLE KEYS */;
/*!40000 ALTER TABLE `nexus_dashboard_layouts` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `nexus_module_relations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `nexus_module_relations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `module_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `microservice` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `endpoint` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fields` json DEFAULT NULL,
  `async_save` tinyint(1) NOT NULL DEFAULT '0',
  `is_lazy_load` tinyint(1) NOT NULL DEFAULT '0',
  `is_display_in_table` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `nexus_module_relations_module_id_foreign` (`module_id`),
  CONSTRAINT `nexus_module_relations_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `nexus_modules` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `nexus_module_relations` WRITE;
/*!40000 ALTER TABLE `nexus_module_relations` DISABLE KEYS */;
/*!40000 ALTER TABLE `nexus_module_relations` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `nexus_module_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `nexus_module_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `module_id` bigint unsigned NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nexus_module_settings_module_id_key_unique` (`module_id`,`key`),
  CONSTRAINT `nexus_module_settings_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `nexus_modules` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `nexus_module_settings` WRITE;
/*!40000 ALTER TABLE `nexus_module_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `nexus_module_settings` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `nexus_modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `nexus_modules` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `config` json DEFAULT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `is_system` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nexus_modules_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `nexus_modules` WRITE;
/*!40000 ALTER TABLE `nexus_modules` DISABLE KEYS */;
INSERT INTO `nexus_modules` VALUES (1,'auth',NULL,1,1,'2026-10-23 07:18:31','2026-10-23 07:18:31'),(2,'User',NULL,1,1,'2026-10-23 07:19:13','2026-10-23 07:19:13'),(3,'permission',NULL,1,1,'2026-10-23 07:19:32','2026-10-23 07:19:32'),(4,'role',NULL,1,1,'2026-10-23 07:19:32','2026-10-23 07:19:32'),(7,'Employee',NULL,1,0,'2026-10-23 08:21:45','2026-10-23 08:21:45'),(8,'PayrollLine',NULL,1,0,'2026-10-23 08:21:47','2026-10-23 08:21:47'),(9,'PayrollAudit',NULL,1,0,'2026-10-23 08:21:49','2026-10-23 08:21:49'),(10,'PayrollAdjustment',NULL,1,0,'2026-10-23 08:21:52','2026-10-23 08:21:52');
/*!40000 ALTER TABLE `nexus_modules` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `nexus_plugins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `nexus_plugins` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `target` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `config` json DEFAULT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nexus_plugins_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `nexus_plugins` WRITE;
/*!40000 ALTER TABLE `nexus_plugins` DISABLE KEYS */;
/*!40000 ALTER TABLE `nexus_plugins` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `nexus_user_table_preferences`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `nexus_user_table_preferences` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `module` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `visible_columns` json DEFAULT NULL,
  `filters` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nexus_user_table_preferences_user_id_module_unique` (`user_id`,`module`),
  CONSTRAINT `nexus_user_table_preferences_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `nexus_user_table_preferences` WRITE;
/*!40000 ALTER TABLE `nexus_user_table_preferences` DISABLE KEYS */;
/*!40000 ALTER TABLE `nexus_user_table_preferences` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint unsigned NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
INSERT INTO `notifications` VALUES ('00bcf5cb-0e11-4dc3-8c79-aa46c33fdb14','Nodex\\Nexus\\Notifications\\ModuleInstalledNotification','App\\Models\\User',1,'{\"title\":\"Module installed\",\"body\":\"The \\\"employee\\\" module was installed.\"}',NULL,'2026-10-25 15:52:15','2026-10-25 15:52:15'),('0d635081-6a8b-40d6-928b-cd5a5d5db39b','Nodex\\Nexus\\Notifications\\ModuleInstalledNotification','App\\Models\\User',1,'{\"title\":\"Module installed\",\"body\":\"The \\\"PayrollAdjustment\\\" module was installed.\"}',NULL,'2026-10-25 13:43:34','2026-10-25 13:43:34'),('3deb7633-94e0-4f19-881a-121f78a5d6f5','Nodex\\Nexus\\Notifications\\ModuleInstalledNotification','App\\Models\\User',1,'{\"title\":\"Module installed\",\"body\":\"The \\\"payrollLine\\\" module was installed.\"}',NULL,'2026-10-25 15:52:19','2026-10-25 15:52:19'),('5baa49d8-72dc-4b53-b7a0-01bdb543d0e1','Nodex\\Nexus\\Notifications\\ModuleInstalledNotification','App\\Models\\User',1,'{\"title\":\"Module installed\",\"body\":\"The \\\"PayrollLine\\\" module was installed.\"}',NULL,'2026-10-25 12:43:19','2026-10-25 12:43:19'),('632df442-1318-4ba2-bea6-7e1752869a39','Nodex\\Nexus\\Notifications\\ModuleInstalledNotification','App\\Models\\User',1,'{\"title\":\"Module installed\",\"body\":\"The \\\"user\\\" module was installed.\"}',NULL,'2026-10-25 15:52:23','2026-10-25 15:52:23'),('6da9e0f5-c783-4fad-a57a-c32169e3775d','Nodex\\Nexus\\Notifications\\ModuleInstalledNotification','App\\Models\\User',1,'{\"title\":\"Module installed\",\"body\":\"The \\\"Employee\\\" module was installed.\"}',NULL,'2026-10-23 08:21:46','2026-10-23 08:21:46'),('78699f0d-cd67-456c-a73e-795231b86043','Nodex\\Nexus\\Notifications\\ModuleInstalledNotification','App\\Models\\User',1,'{\"title\":\"Module installed\",\"body\":\"The \\\"payrollAudit\\\" module was installed.\"}',NULL,'2026-10-25 15:52:18','2026-10-25 15:52:18'),('8d849529-0e5f-49b3-b349-86fb55dfa236','Nodex\\Nexus\\Notifications\\ModuleInstalledNotification','App\\Models\\User',1,'{\"title\":\"Module installed\",\"body\":\"The \\\"PayrollAdjustment\\\" module was installed.\"}',NULL,'2026-10-25 12:49:41','2026-10-25 12:49:41'),('94f3b0e6-1e0f-4bb5-9f98-28bf455ca0ff','Nodex\\Nexus\\Notifications\\ModuleInstalledNotification','App\\Models\\User',1,'{\"title\":\"Module installed\",\"body\":\"The \\\"permission\\\" module was installed.\"}',NULL,'2026-10-25 15:52:20','2026-10-25 15:52:20'),('96994bc2-1656-4a16-85e4-7c0113a6adf5','Nodex\\Nexus\\Notifications\\ModuleInstalledNotification','App\\Models\\User',1,'{\"title\":\"Module installed\",\"body\":\"The \\\"PayrollAdjustment\\\" module was installed.\"}',NULL,'2026-10-23 08:21:52','2026-10-23 08:21:52'),('9f9013fe-0549-4730-a212-cf72dd8d48a9','Nodex\\Nexus\\Notifications\\ModuleInstalledNotification','App\\Models\\User',1,'{\"title\":\"Module installed\",\"body\":\"The \\\"payrollAdjustment\\\" module was installed.\"}',NULL,'2026-10-25 15:52:16','2026-10-25 15:52:16'),('bc727afd-5ec5-405c-a58d-a9812b6c17e1','Nodex\\Nexus\\Notifications\\ModuleInstalledNotification','App\\Models\\User',1,'{\"title\":\"Module installed\",\"body\":\"The \\\"PayrollAudit\\\" module was installed.\"}',NULL,'2026-10-25 12:43:21','2026-10-25 12:43:21'),('bec240a1-6706-4572-8e1e-c21d710166f4','Nodex\\Nexus\\Notifications\\ModuleInstalledNotification','App\\Models\\User',1,'{\"title\":\"Module installed\",\"body\":\"The \\\"PayrollAudit\\\" module was installed.\"}',NULL,'2026-10-23 08:21:50','2026-10-23 08:21:50'),('c19968d4-ad0b-421b-b970-3054580964a6','Nodex\\Nexus\\Notifications\\ModuleInstalledNotification','App\\Models\\User',1,'{\"title\":\"Module installed\",\"body\":\"The \\\"PayrollAdjustment\\\" module was installed.\"}',NULL,'2026-10-25 12:43:24','2026-10-25 12:43:24'),('e17ddcad-0f3d-4f2d-8062-fffb05d100d8','Nodex\\Nexus\\Notifications\\ModuleInstalledNotification','App\\Models\\User',1,'{\"title\":\"Module installed\",\"body\":\"The \\\"PayrollLine\\\" module was installed.\"}',NULL,'2026-10-23 08:21:48','2026-10-23 08:21:48'),('ebf8729c-3817-451a-80ca-ffd30a62dc19','Nodex\\Nexus\\Notifications\\ModuleInstalledNotification','App\\Models\\User',1,'{\"title\":\"Module installed\",\"body\":\"The \\\"Employee\\\" module was installed.\"}',NULL,'2026-10-25 12:43:16','2026-10-25 12:43:16'),('f8451bb5-733c-4f8d-b043-c7f85dfcd8c0','Nodex\\Nexus\\Notifications\\ModuleInstalledNotification','App\\Models\\User',1,'{\"title\":\"Module installed\",\"body\":\"The \\\"auth\\\" module was installed.\"}',NULL,'2026-10-25 15:52:14','2026-10-25 15:52:14'),('f9fba2d5-f35d-43e9-87d3-e675e9c94041','Nodex\\Nexus\\Notifications\\ModuleInstalledNotification','App\\Models\\User',1,'{\"title\":\"Module installed\",\"body\":\"The \\\"role\\\" module was installed.\"}',NULL,'2026-10-25 15:52:21','2026-10-25 15:52:21');
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `nx_employees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `nx_employees` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency` char(3) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'USD',
  `base_salary` decimal(14,2) NOT NULL,
  `benefits_deduction` decimal(14,2) NOT NULL DEFAULT '0.00',
  `bonus` decimal(14,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `nx_employees` WRITE;
/*!40000 ALTER TABLE `nx_employees` DISABLE KEYS */;
INSERT INTO `nx_employees` VALUES (1,'Anna Koval','USD',1300.00,0.00,0.00,'2026-10-25 15:52:24','2026-10-21 07:00:00'),(2,'Bohdan Melnyk','USD',2400.00,0.00,0.00,'2026-10-25 15:52:24','2026-10-25 15:52:24'),(3,'Olena Shevchenko','USD',1850.50,0.00,100.00,'2026-10-25 15:52:24','2026-10-25 15:52:24');
/*!40000 ALTER TABLE `nx_employees` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `nx_payroll_line_events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `nx_payroll_line_events` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `payroll_line_id` bigint unsigned NOT NULL,
  `event_no` int unsigned NOT NULL,
  `kind` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(14,2) NOT NULL,
  `balance_after` decimal(14,2) NOT NULL,
  `applied` tinyint(1) DEFAULT NULL,
  `sequence` int unsigned DEFAULT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `actor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `idempotency_key` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `occurred_at` datetime(6) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nx_payroll_line_events_payroll_line_id_event_no_unique` (`payroll_line_id`,`event_no`),
  UNIQUE KEY `nx_payroll_line_events_payroll_line_id_idempotency_key_unique` (`payroll_line_id`,`idempotency_key`),
  KEY `nx_payroll_line_events_payroll_line_id_occurred_at_index` (`payroll_line_id`,`occurred_at`),
  CONSTRAINT `nx_payroll_line_events_payroll_line_id_foreign` FOREIGN KEY (`payroll_line_id`) REFERENCES `nx_payroll_lines` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `nx_payroll_line_events` WRITE;
/*!40000 ALTER TABLE `nx_payroll_line_events` DISABLE KEYS */;
INSERT INTO `nx_payroll_line_events` VALUES (1,1,1,'calculation',1000.00,1000.00,1,NULL,NULL,NULL,NULL,'2026-10-18 09:00:00.000000'),(2,1,2,'calculation',1050.00,1050.00,1,NULL,NULL,NULL,NULL,'2026-10-19 09:00:00.000000'),(3,1,3,'adjustment',-45.55,1004.45,NULL,1,'Employee declined dental benefit; reversing deduction','Olena (payroll specialist)',NULL,'2026-10-20 09:00:00.000000'),(4,1,4,'calculation',1300.00,1004.45,0,NULL,'Line already has manual adjustments',NULL,NULL,'2026-10-21 09:00:00.000000'),(5,1,5,'adjustment',100.10,1104.55,NULL,2,'Late correction: missed approved overtime bonus','Olena (payroll specialist)',NULL,'2026-10-22 09:00:00.000000'),(6,1,6,'adjustment',-0.10,1104.45,NULL,3,'Minor rounding adjustment','Olena (payroll specialist)',NULL,'2026-10-23 09:00:00.000000'),(7,1,7,'adjustment',-0.20,1104.25,NULL,4,'Second minor rounding adjustment','Olena (payroll specialist)',NULL,'2026-10-24 09:00:00.000000'),(8,1,8,'adjustment',0.20,1104.45,NULL,5,'Correcting mistake in adjustment #4','Olena (payroll specialist)',NULL,'2026-10-25 09:00:00.000000'),(9,2,1,'calculation',2400.00,2400.00,1,NULL,NULL,NULL,NULL,'2026-10-25 17:52:24.000000'),(10,3,1,'calculation',1950.50,1950.50,1,NULL,NULL,NULL,NULL,'2026-10-25 17:52:24.000000');
/*!40000 ALTER TABLE `nx_payroll_line_events` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`%`*/ /*!50003 TRIGGER `nx_payroll_line_events_no_update` BEFORE UPDATE ON `nx_payroll_line_events` FOR EACH ROW SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'nx_payroll_line_events is append-only: updates are not allowed' */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`%`*/ /*!50003 TRIGGER `nx_payroll_line_events_no_delete` BEFORE DELETE ON `nx_payroll_line_events` FOR EACH ROW SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'nx_payroll_line_events is append-only: deletes are not allowed' */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
DROP TABLE IF EXISTS `nx_payroll_lines`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `nx_payroll_lines` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` bigint unsigned NOT NULL,
  `period` char(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency` char(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `system_value` decimal(14,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nx_payroll_lines_employee_id_period_unique` (`employee_id`,`period`),
  CONSTRAINT `nx_payroll_lines_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `nx_employees` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `nx_payroll_lines` WRITE;
/*!40000 ALTER TABLE `nx_payroll_lines` DISABLE KEYS */;
INSERT INTO `nx_payroll_lines` VALUES (1,1,'2026-10','USD','Anna Koval — 2026-10',1050.00,'2026-10-18 07:00:00','2026-10-19 07:00:00'),(2,2,'2026-10','USD','Bohdan Melnyk — 2026-10',2400.00,'2026-10-25 15:52:24','2026-10-25 15:52:24'),(3,3,'2026-10','USD','Olena Shevchenko — 2026-10',1950.50,'2026-10-25 15:52:24','2026-10-25 15:52:24');
/*!40000 ALTER TABLE `nx_payroll_lines` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `payroll_audit_entries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payroll_audit_entries` (
  `line_id` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `event_no` int unsigned NOT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount_cents` bigint NOT NULL,
  `balance_cents` bigint NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `actor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adjustment_no` int unsigned DEFAULT NULL,
  `occurred_at` datetime(6) NOT NULL,
  PRIMARY KEY (`line_id`,`event_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `payroll_audit_entries` WRITE;
/*!40000 ALTER TABLE `payroll_audit_entries` DISABLE KEYS */;
INSERT INTO `payroll_audit_entries` VALUES ('anna:2026-10',1,'system_calculated',100000,100000,NULL,NULL,NULL,'2026-10-14 09:00:00.000000'),('anna:2026-10',2,'system_calculated',105000,105000,NULL,NULL,NULL,'2026-10-16 09:00:00.000000'),('anna:2026-10',3,'adjustment',-4555,100445,'Employee declined dental benefit; reversing deduction','Olena (payroll specialist)',1,'2026-10-17 09:00:00.000000'),('anna:2026-10',4,'system_ignored',130000,100445,'Line already has manual adjustments',NULL,NULL,'2026-10-19 09:00:00.000000'),('anna:2026-10',5,'adjustment',10010,110455,'Late correction: missed approved overtime bonus','Olena (payroll specialist)',2,'2026-10-20 09:00:00.000000'),('anna:2026-10',6,'adjustment',-10,110445,'Minor rounding adjustment','Olena (payroll specialist)',3,'2026-10-21 09:00:00.000000'),('anna:2026-10',7,'adjustment',-20,110425,'Second minor rounding adjustment','Olena (payroll specialist)',4,'2026-10-22 09:00:00.000000'),('anna:2026-10',8,'adjustment',20,110445,'Correcting mistake in adjustment #4','Olena (payroll specialist)',5,'2026-10-23 09:00:00.000000'),('bohdan:2026-10',1,'system_calculated',240000,240000,NULL,NULL,NULL,'2026-10-25 17:52:08.940505'),('olena:2026-10',1,'system_calculated',195050,195050,NULL,NULL,NULL,'2026-10-25 17:52:08.953039');
/*!40000 ALTER TABLE `payroll_audit_entries` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `payroll_events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payroll_events` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `stream_id` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `version` int unsigned NOT NULL,
  `event_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` json NOT NULL,
  `occurred_at` datetime(6) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `payroll_events_stream_id_version_unique` (`stream_id`,`version`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `payroll_events` WRITE;
/*!40000 ALTER TABLE `payroll_events` DISABLE KEYS */;
INSERT INTO `payroll_events` VALUES (1,'anna:2026-10',1,'LineCalculated','{\"line\": \"anna:2026-10\", \"value\": \"1000.00\", \"currency\": \"USD\"}','2026-10-14 09:00:00.000000'),(2,'anna:2026-10',2,'SystemValueRecalculated','{\"line\": \"anna:2026-10\", \"value\": \"1050.00\", \"currency\": \"USD\"}','2026-10-16 09:00:00.000000'),(3,'anna:2026-10',3,'AdjustmentAdded','{\"key\": null, \"line\": \"anna:2026-10\", \"actor\": \"Olena (payroll specialist)\", \"amount\": \"-45.55\", \"number\": 1, \"comment\": \"Employee declined dental benefit; reversing deduction\", \"currency\": \"USD\"}','2026-10-17 09:00:00.000000'),(4,'anna:2026-10',4,'RecalculationIgnored','{\"line\": \"anna:2026-10\", \"value\": \"1300.00\", \"currency\": \"USD\"}','2026-10-19 09:00:00.000000'),(5,'anna:2026-10',5,'AdjustmentAdded','{\"key\": null, \"line\": \"anna:2026-10\", \"actor\": \"Olena (payroll specialist)\", \"amount\": \"100.10\", \"number\": 2, \"comment\": \"Late correction: missed approved overtime bonus\", \"currency\": \"USD\"}','2026-10-20 09:00:00.000000'),(6,'anna:2026-10',6,'AdjustmentAdded','{\"key\": null, \"line\": \"anna:2026-10\", \"actor\": \"Olena (payroll specialist)\", \"amount\": \"-0.10\", \"number\": 3, \"comment\": \"Minor rounding adjustment\", \"currency\": \"USD\"}','2026-10-21 09:00:00.000000'),(7,'anna:2026-10',7,'AdjustmentAdded','{\"key\": null, \"line\": \"anna:2026-10\", \"actor\": \"Olena (payroll specialist)\", \"amount\": \"-0.20\", \"number\": 4, \"comment\": \"Second minor rounding adjustment\", \"currency\": \"USD\"}','2026-10-22 09:00:00.000000'),(8,'anna:2026-10',8,'AdjustmentAdded','{\"key\": null, \"line\": \"anna:2026-10\", \"actor\": \"Olena (payroll specialist)\", \"amount\": \"0.20\", \"number\": 5, \"comment\": \"Correcting mistake in adjustment #4\", \"currency\": \"USD\"}','2026-10-23 09:00:00.000000'),(9,'bohdan:2026-10',1,'LineCalculated','{\"line\": \"bohdan:2026-10\", \"value\": \"2400.00\", \"currency\": \"USD\"}','2026-10-25 17:52:08.940505'),(10,'olena:2026-10',1,'LineCalculated','{\"line\": \"olena:2026-10\", \"value\": \"1950.50\", \"currency\": \"USD\"}','2026-10-25 17:52:08.953039');
/*!40000 ALTER TABLE `payroll_events` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`%`*/ /*!50003 TRIGGER `payroll_events_no_update` BEFORE UPDATE ON `payroll_events` FOR EACH ROW SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'payroll_events is append-only: updates are not allowed' */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`%`*/ /*!50003 TRIGGER `payroll_events_no_delete` BEFORE DELETE ON `payroll_events` FOR EACH ROW SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'payroll_events is append-only: deletes are not allowed' */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
DROP TABLE IF EXISTS `payroll_line_views`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payroll_line_views` (
  `line_id` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `employee_id` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `period` char(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency` char(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `system_value_cents` bigint NOT NULL,
  `current_value_cents` bigint NOT NULL,
  `frozen` tinyint(1) NOT NULL DEFAULT '0',
  `adjustment_count` int unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`line_id`),
  KEY `payroll_line_views_employee_id_period_index` (`employee_id`,`period`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `payroll_line_views` WRITE;
/*!40000 ALTER TABLE `payroll_line_views` DISABLE KEYS */;
INSERT INTO `payroll_line_views` VALUES ('anna:2026-10','anna','2026-10','USD',105000,110445,1,5),('bohdan:2026-10','bohdan','2026-10','USD',240000,240000,0,0),('olena:2026-10','olena','2026-10','USD',195050,195050,0,0);
/*!40000 ALTER TABLE `payroll_line_views` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `display_name` json DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=175 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'auth_SHOW_SIDE_MENU','web','2026-10-23 07:19:31','2026-10-23 07:19:31','{\"en\": \"Auth: Show in Menu\", \"uk\": \"Auth: Показувати в меню\"}'),(2,'auth_index','web','2026-10-23 07:19:31','2026-10-23 07:19:31','{\"en\": \"Auth: List records\", \"uk\": \"Auth: Список записів\"}'),(3,'auth_create','web','2026-10-23 07:19:31','2026-10-23 07:19:31','{\"en\": \"Auth: Create record\", \"uk\": \"Auth: Створити запис\"}'),(4,'auth_store','web','2026-10-23 07:19:31','2026-10-23 07:19:31','{\"en\": \"Auth: Store record\", \"uk\": \"Auth: Зберегти запис\"}'),(5,'auth_edit','web','2026-10-23 07:19:31','2026-10-23 07:19:31','{\"en\": \"Auth: Edit record\", \"uk\": \"Auth: Редагувати запис\"}'),(6,'auth_update','web','2026-10-23 07:19:31','2026-10-23 07:19:31','{\"en\": \"Auth: Update record\", \"uk\": \"Auth: Оновити запис\"}'),(7,'auth_delete','web','2026-10-23 07:19:31','2026-10-23 07:19:31','{\"en\": \"Auth: Delete record\", \"uk\": \"Auth: Видалити запис\"}'),(8,'auth_deletePermanent','web','2026-10-23 07:19:31','2026-10-23 07:19:31','{\"en\": \"Auth: Delete permanently\", \"uk\": \"Auth: Видалити назавжди\"}'),(9,'auth_restore','web','2026-10-23 07:19:31','2026-10-23 07:19:31','{\"en\": \"Auth: Restore record\", \"uk\": \"Auth: Відновити запис\"}'),(10,'auth_deleteGroup','web','2026-10-23 07:19:31','2026-10-23 07:19:31','{\"en\": \"Auth: Delete group\", \"uk\": \"Auth: Видалити групу\"}'),(11,'auth_boolToggle','web','2026-10-23 07:19:31','2026-10-23 07:19:31','{\"en\": \"Auth: Toggle boolean\", \"uk\": \"Auth: Перемкнути стан\"}'),(12,'auth_ordering','web','2026-10-23 07:19:31','2026-10-23 07:19:31','{\"en\": \"Auth: Change ordering\", \"uk\": \"Auth: Змінити порядок\"}'),(13,'auth_view','web','2026-10-23 07:19:31','2026-10-23 07:19:31','{\"en\": \"Auth: View record\", \"uk\": \"Auth: Переглянути запис\"}'),(14,'auth_duplicate','web','2026-10-23 07:19:31','2026-10-23 07:19:31','{\"en\": \"Auth: Duplicate record\", \"uk\": \"Auth: Дублювати запис\"}'),(15,'auth_duplicateGroup','web','2026-10-23 07:19:31','2026-10-23 07:19:31','{\"en\": \"Auth: Duplicate group\", \"uk\": \"Auth: Дублювати групу\"}'),(16,'auth_impersonate','web','2026-10-23 07:19:31','2026-10-23 07:19:31','{\"en\": \"Auth: Impersonate\", \"uk\": \"Auth: Impersonate\"}'),(17,'permission_SHOW_SIDE_MENU','web','2026-10-23 07:19:32','2026-10-23 07:19:32','{\"en\": \"Permission: Show in Menu\", \"uk\": \"Permission: Показувати в меню\"}'),(18,'permission_index','web','2026-10-23 07:19:32','2026-10-23 07:19:32','{\"en\": \"Permission: List records\", \"uk\": \"Permission: Список записів\"}'),(19,'permission_create','web','2026-10-23 07:19:32','2026-10-23 07:19:32','{\"en\": \"Permission: Create record\", \"uk\": \"Permission: Створити запис\"}'),(20,'permission_store','web','2026-10-23 07:19:32','2026-10-23 07:19:32','{\"en\": \"Permission: Store record\", \"uk\": \"Permission: Зберегти запис\"}'),(21,'permission_edit','web','2026-10-23 07:19:32','2026-10-23 07:19:32','{\"en\": \"Permission: Edit record\", \"uk\": \"Permission: Редагувати запис\"}'),(22,'permission_update','web','2026-10-23 07:19:32','2026-10-23 07:19:32','{\"en\": \"Permission: Update record\", \"uk\": \"Permission: Оновити запис\"}'),(23,'permission_delete','web','2026-10-23 07:19:32','2026-10-23 07:19:32','{\"en\": \"Permission: Delete record\", \"uk\": \"Permission: Видалити запис\"}'),(24,'permission_deletePermanent','web','2026-10-23 07:19:32','2026-10-23 07:19:32','{\"en\": \"Permission: Delete permanently\", \"uk\": \"Permission: Видалити назавжди\"}'),(25,'permission_restore','web','2026-10-23 07:19:32','2026-10-23 07:19:32','{\"en\": \"Permission: Restore record\", \"uk\": \"Permission: Відновити запис\"}'),(26,'permission_deleteGroup','web','2026-10-23 07:19:32','2026-10-23 07:19:32','{\"en\": \"Permission: Delete group\", \"uk\": \"Permission: Видалити групу\"}'),(27,'permission_boolToggle','web','2026-10-23 07:19:32','2026-10-23 07:19:32','{\"en\": \"Permission: Toggle boolean\", \"uk\": \"Permission: Перемкнути стан\"}'),(28,'permission_ordering','web','2026-10-23 07:19:32','2026-10-23 07:19:32','{\"en\": \"Permission: Change ordering\", \"uk\": \"Permission: Змінити порядок\"}'),(29,'permission_view','web','2026-10-23 07:19:32','2026-10-23 07:19:32','{\"en\": \"Permission: View record\", \"uk\": \"Permission: Переглянути запис\"}'),(30,'permission_duplicate','web','2026-10-23 07:19:32','2026-10-23 07:19:32','{\"en\": \"Permission: Duplicate record\", \"uk\": \"Permission: Дублювати запис\"}'),(31,'permission_duplicateGroup','web','2026-10-23 07:19:32','2026-10-23 07:19:32','{\"en\": \"Permission: Duplicate group\", \"uk\": \"Permission: Дублювати групу\"}'),(32,'permission_impersonate','web','2026-10-23 07:19:32','2026-10-23 07:19:32','{\"en\": \"Permission: Impersonate\", \"uk\": \"Permission: Impersonate\"}'),(33,'role_SHOW_SIDE_MENU','web','2026-10-23 07:19:32','2026-10-23 07:19:32','{\"en\": \"Role: Show in Menu\", \"uk\": \"Role: Показувати в меню\"}'),(34,'role_index','web','2026-10-23 07:19:32','2026-10-23 07:19:32','{\"en\": \"Role: List records\", \"uk\": \"Role: Список записів\"}'),(35,'role_create','web','2026-10-23 07:19:32','2026-10-23 07:19:32','{\"en\": \"Role: Create record\", \"uk\": \"Role: Створити запис\"}'),(36,'role_store','web','2026-10-23 07:19:32','2026-10-23 07:19:32','{\"en\": \"Role: Store record\", \"uk\": \"Role: Зберегти запис\"}'),(37,'role_edit','web','2026-10-23 07:19:32','2026-10-23 07:19:32','{\"en\": \"Role: Edit record\", \"uk\": \"Role: Редагувати запис\"}'),(38,'role_update','web','2026-10-23 07:19:32','2026-10-23 07:19:32','{\"en\": \"Role: Update record\", \"uk\": \"Role: Оновити запис\"}'),(39,'role_delete','web','2026-10-23 07:19:32','2026-10-23 07:19:32','{\"en\": \"Role: Delete record\", \"uk\": \"Role: Видалити запис\"}'),(40,'role_deletePermanent','web','2026-10-23 07:19:32','2026-10-23 07:19:32','{\"en\": \"Role: Delete permanently\", \"uk\": \"Role: Видалити назавжди\"}'),(41,'role_restore','web','2026-10-23 07:19:32','2026-10-23 07:19:32','{\"en\": \"Role: Restore record\", \"uk\": \"Role: Відновити запис\"}'),(42,'role_deleteGroup','web','2026-10-23 07:19:32','2026-10-23 07:19:32','{\"en\": \"Role: Delete group\", \"uk\": \"Role: Видалити групу\"}'),(43,'role_boolToggle','web','2026-10-23 07:19:32','2026-10-23 07:19:32','{\"en\": \"Role: Toggle boolean\", \"uk\": \"Role: Перемкнути стан\"}'),(44,'role_ordering','web','2026-10-23 07:19:32','2026-10-23 07:19:32','{\"en\": \"Role: Change ordering\", \"uk\": \"Role: Змінити порядок\"}'),(45,'role_view','web','2026-10-23 07:19:32','2026-10-23 07:19:32','{\"en\": \"Role: View record\", \"uk\": \"Role: Переглянути запис\"}'),(46,'role_duplicate','web','2026-10-23 07:19:32','2026-10-23 07:19:32','{\"en\": \"Role: Duplicate record\", \"uk\": \"Role: Дублювати запис\"}'),(47,'role_duplicateGroup','web','2026-10-23 07:19:32','2026-10-23 07:19:32','{\"en\": \"Role: Duplicate group\", \"uk\": \"Role: Дублювати групу\"}'),(48,'role_impersonate','web','2026-10-23 07:19:32','2026-10-23 07:19:32','{\"en\": \"Role: Impersonate\", \"uk\": \"Role: Impersonate\"}'),(49,'user_SHOW_SIDE_MENU','web','2026-10-23 07:19:32','2026-10-23 07:19:32','{\"en\": \"User: Show in Menu\", \"uk\": \"User: Показувати в меню\"}'),(50,'user_index','web','2026-10-23 07:19:32','2026-10-23 07:19:32','{\"en\": \"User: List records\", \"uk\": \"User: Список записів\"}'),(51,'user_create','web','2026-10-23 07:19:32','2026-10-23 07:19:32','{\"en\": \"User: Create record\", \"uk\": \"User: Створити запис\"}'),(52,'user_store','web','2026-10-23 07:19:32','2026-10-23 07:19:32','{\"en\": \"User: Store record\", \"uk\": \"User: Зберегти запис\"}'),(53,'user_edit','web','2026-10-23 07:19:32','2026-10-23 07:19:32','{\"en\": \"User: Edit record\", \"uk\": \"User: Редагувати запис\"}'),(54,'user_update','web','2026-10-23 07:19:32','2026-10-23 07:19:32','{\"en\": \"User: Update record\", \"uk\": \"User: Оновити запис\"}'),(55,'user_delete','web','2026-10-23 07:19:32','2026-10-23 07:19:32','{\"en\": \"User: Delete record\", \"uk\": \"User: Видалити запис\"}'),(56,'user_deletePermanent','web','2026-10-23 07:19:32','2026-10-23 07:19:32','{\"en\": \"User: Delete permanently\", \"uk\": \"User: Видалити назавжди\"}'),(57,'user_restore','web','2026-10-23 07:19:32','2026-10-23 07:19:32','{\"en\": \"User: Restore record\", \"uk\": \"User: Відновити запис\"}'),(58,'user_deleteGroup','web','2026-10-23 07:19:32','2026-10-23 07:19:32','{\"en\": \"User: Delete group\", \"uk\": \"User: Видалити групу\"}'),(59,'user_boolToggle','web','2026-10-23 07:19:32','2026-10-23 07:19:32','{\"en\": \"User: Toggle boolean\", \"uk\": \"User: Перемкнути стан\"}'),(60,'user_ordering','web','2026-10-23 07:19:32','2026-10-23 07:19:32','{\"en\": \"User: Change ordering\", \"uk\": \"User: Змінити порядок\"}'),(61,'user_view','web','2026-10-23 07:19:32','2026-10-23 07:19:32','{\"en\": \"User: View record\", \"uk\": \"User: Переглянути запис\"}'),(62,'user_duplicate','web','2026-10-23 07:19:32','2026-10-23 07:19:32','{\"en\": \"User: Duplicate record\", \"uk\": \"User: Дублювати запис\"}'),(63,'user_duplicateGroup','web','2026-10-23 07:19:32','2026-10-23 07:19:32','{\"en\": \"User: Duplicate group\", \"uk\": \"User: Дублювати групу\"}'),(64,'user_impersonate','web','2026-10-23 07:19:32','2026-10-23 07:19:32','{\"en\": \"User: Impersonate\", \"uk\": \"User: Impersonate\"}'),(65,'ALL','web','2026-10-23 07:19:34','2026-10-23 07:19:34','{\"en\": \"All\"}'),(66,'SHOW_SIDE_MENU','web','2026-10-23 07:19:34','2026-10-23 07:19:34','{\"en\": \"Show side menu\"}'),(67,'INDEX','web','2026-10-23 07:19:34','2026-10-23 07:19:34','{\"en\": \"Index\"}'),(68,'EDITE','web','2026-10-23 07:19:34','2026-10-23 07:19:34','{\"en\": \"Edite\"}'),(69,'UPDATE','web','2026-10-23 07:19:34','2026-10-23 07:19:34','{\"en\": \"Update\"}'),(70,'CREATE','web','2026-10-23 07:19:34','2026-10-23 07:19:34','{\"en\": \"Create\"}'),(71,'STORE','web','2026-10-23 07:19:34','2026-10-23 07:19:34','{\"en\": \"Store\"}'),(72,'DELETE','web','2026-10-23 07:19:34','2026-10-23 07:19:34','{\"en\": \"Delete\"}'),(73,'RESTORE','web','2026-10-23 07:19:34','2026-10-23 07:19:34','{\"en\": \"Restore\"}'),(74,'DELETE_PERMANENT','web','2026-10-23 07:19:34','2026-10-23 07:19:34','{\"en\": \"Delete permanent\"}'),(75,'DELETE_GROUP','web','2026-10-23 07:19:34','2026-10-23 07:19:34','{\"en\": \"Delete group\"}'),(76,'ORDERING','web','2026-10-23 07:19:34','2026-10-23 07:19:34','{\"en\": \"Ordering\"}'),(77,'BOOL_TOGGLE','web','2026-10-23 07:19:34','2026-10-23 07:19:34','{\"en\": \"Bool toggle\"}'),(78,'ADMIN_PANEL','web','2026-10-23 07:19:34','2026-10-23 07:19:34','{\"en\": \"Admin panel\"}'),(111,'employee_SHOW_SIDE_MENU','web','2026-10-23 08:21:45','2026-10-23 08:21:45','{\"en\": \"Employee: Show in Menu\", \"uk\": \"Employee: Показувати в меню\"}'),(112,'employee_index','web','2026-10-23 08:21:45','2026-10-23 08:21:45','{\"en\": \"Employee: List records\", \"uk\": \"Employee: Список записів\"}'),(113,'employee_create','web','2026-10-23 08:21:45','2026-10-23 08:21:45','{\"en\": \"Employee: Create record\", \"uk\": \"Employee: Створити запис\"}'),(114,'employee_store','web','2026-10-23 08:21:45','2026-10-23 08:21:45','{\"en\": \"Employee: Store record\", \"uk\": \"Employee: Зберегти запис\"}'),(115,'employee_edit','web','2026-10-23 08:21:45','2026-10-23 08:21:45','{\"en\": \"Employee: Edit record\", \"uk\": \"Employee: Редагувати запис\"}'),(116,'employee_update','web','2026-10-23 08:21:45','2026-10-23 08:21:45','{\"en\": \"Employee: Update record\", \"uk\": \"Employee: Оновити запис\"}'),(117,'employee_delete','web','2026-10-23 08:21:45','2026-10-23 08:21:45','{\"en\": \"Employee: Delete record\", \"uk\": \"Employee: Видалити запис\"}'),(118,'employee_deletePermanent','web','2026-10-23 08:21:45','2026-10-23 08:21:45','{\"en\": \"Employee: Delete permanently\", \"uk\": \"Employee: Видалити назавжди\"}'),(119,'employee_restore','web','2026-10-23 08:21:45','2026-10-23 08:21:45','{\"en\": \"Employee: Restore record\", \"uk\": \"Employee: Відновити запис\"}'),(120,'employee_deleteGroup','web','2026-10-23 08:21:45','2026-10-23 08:21:45','{\"en\": \"Employee: Delete group\", \"uk\": \"Employee: Видалити групу\"}'),(121,'employee_boolToggle','web','2026-10-23 08:21:45','2026-10-23 08:21:45','{\"en\": \"Employee: Toggle boolean\", \"uk\": \"Employee: Перемкнути стан\"}'),(122,'employee_ordering','web','2026-10-23 08:21:45','2026-10-23 08:21:45','{\"en\": \"Employee: Change ordering\", \"uk\": \"Employee: Змінити порядок\"}'),(123,'employee_view','web','2026-10-23 08:21:45','2026-10-23 08:21:45','{\"en\": \"Employee: View record\", \"uk\": \"Employee: Переглянути запис\"}'),(124,'employee_duplicate','web','2026-10-23 08:21:45','2026-10-23 08:21:45','{\"en\": \"Employee: Duplicate record\", \"uk\": \"Employee: Дублювати запис\"}'),(125,'employee_duplicateGroup','web','2026-10-23 08:21:45','2026-10-23 08:21:45','{\"en\": \"Employee: Duplicate group\", \"uk\": \"Employee: Дублювати групу\"}'),(126,'employee_impersonate','web','2026-10-23 08:21:45','2026-10-23 08:21:45','{\"en\": \"Employee: Impersonate\", \"uk\": \"Employee: Impersonate\"}'),(127,'payrollLine_SHOW_SIDE_MENU','web','2026-10-23 08:21:47','2026-10-23 08:21:47','{\"en\": \"PayrollLine: Show in Menu\", \"uk\": \"PayrollLine: Показувати в меню\"}'),(128,'payrollLine_index','web','2026-10-23 08:21:47','2026-10-23 08:21:47','{\"en\": \"PayrollLine: List records\", \"uk\": \"PayrollLine: Список записів\"}'),(129,'payrollLine_create','web','2026-10-23 08:21:47','2026-10-23 08:21:47','{\"en\": \"PayrollLine: Create record\", \"uk\": \"PayrollLine: Створити запис\"}'),(130,'payrollLine_store','web','2026-10-23 08:21:47','2026-10-23 08:21:47','{\"en\": \"PayrollLine: Store record\", \"uk\": \"PayrollLine: Зберегти запис\"}'),(131,'payrollLine_edit','web','2026-10-23 08:21:47','2026-10-23 08:21:47','{\"en\": \"PayrollLine: Edit record\", \"uk\": \"PayrollLine: Редагувати запис\"}'),(132,'payrollLine_update','web','2026-10-23 08:21:47','2026-10-23 08:21:47','{\"en\": \"PayrollLine: Update record\", \"uk\": \"PayrollLine: Оновити запис\"}'),(133,'payrollLine_delete','web','2026-10-23 08:21:47','2026-10-23 08:21:47','{\"en\": \"PayrollLine: Delete record\", \"uk\": \"PayrollLine: Видалити запис\"}'),(134,'payrollLine_deletePermanent','web','2026-10-23 08:21:47','2026-10-23 08:21:47','{\"en\": \"PayrollLine: Delete permanently\", \"uk\": \"PayrollLine: Видалити назавжди\"}'),(135,'payrollLine_restore','web','2026-10-23 08:21:47','2026-10-23 08:21:47','{\"en\": \"PayrollLine: Restore record\", \"uk\": \"PayrollLine: Відновити запис\"}'),(136,'payrollLine_deleteGroup','web','2026-10-23 08:21:47','2026-10-23 08:21:47','{\"en\": \"PayrollLine: Delete group\", \"uk\": \"PayrollLine: Видалити групу\"}'),(137,'payrollLine_boolToggle','web','2026-10-23 08:21:47','2026-10-23 08:21:47','{\"en\": \"PayrollLine: Toggle boolean\", \"uk\": \"PayrollLine: Перемкнути стан\"}'),(138,'payrollLine_ordering','web','2026-10-23 08:21:47','2026-10-23 08:21:47','{\"en\": \"PayrollLine: Change ordering\", \"uk\": \"PayrollLine: Змінити порядок\"}'),(139,'payrollLine_view','web','2026-10-23 08:21:47','2026-10-23 08:21:47','{\"en\": \"PayrollLine: View record\", \"uk\": \"PayrollLine: Переглянути запис\"}'),(140,'payrollLine_duplicate','web','2026-10-23 08:21:47','2026-10-23 08:21:47','{\"en\": \"PayrollLine: Duplicate record\", \"uk\": \"PayrollLine: Дублювати запис\"}'),(141,'payrollLine_duplicateGroup','web','2026-10-23 08:21:47','2026-10-23 08:21:47','{\"en\": \"PayrollLine: Duplicate group\", \"uk\": \"PayrollLine: Дублювати групу\"}'),(142,'payrollLine_impersonate','web','2026-10-23 08:21:47','2026-10-23 08:21:47','{\"en\": \"PayrollLine: Impersonate\", \"uk\": \"PayrollLine: Impersonate\"}'),(143,'payrollaudit_SHOW_SIDE_MENU','web','2026-10-23 08:21:49','2026-10-23 08:21:49','{\"en\": \"PayrollAudit: Show in Menu\", \"uk\": \"PayrollAudit: Показувати в меню\"}'),(144,'payrollaudit_index','web','2026-10-23 08:21:49','2026-10-23 08:21:49','{\"en\": \"PayrollAudit: List records\", \"uk\": \"PayrollAudit: Список записів\"}'),(145,'payrollaudit_create','web','2026-10-23 08:21:49','2026-10-23 08:21:49','{\"en\": \"PayrollAudit: Create record\", \"uk\": \"PayrollAudit: Створити запис\"}'),(146,'payrollaudit_store','web','2026-10-23 08:21:49','2026-10-23 08:21:49','{\"en\": \"PayrollAudit: Store record\", \"uk\": \"PayrollAudit: Зберегти запис\"}'),(147,'payrollaudit_edit','web','2026-10-23 08:21:50','2026-10-23 08:21:50','{\"en\": \"PayrollAudit: Edit record\", \"uk\": \"PayrollAudit: Редагувати запис\"}'),(148,'payrollaudit_update','web','2026-10-23 08:21:50','2026-10-23 08:21:50','{\"en\": \"PayrollAudit: Update record\", \"uk\": \"PayrollAudit: Оновити запис\"}'),(149,'payrollaudit_delete','web','2026-10-23 08:21:50','2026-10-23 08:21:50','{\"en\": \"PayrollAudit: Delete record\", \"uk\": \"PayrollAudit: Видалити запис\"}'),(150,'payrollaudit_deletePermanent','web','2026-10-23 08:21:50','2026-10-23 08:21:50','{\"en\": \"PayrollAudit: Delete permanently\", \"uk\": \"PayrollAudit: Видалити назавжди\"}'),(151,'payrollaudit_restore','web','2026-10-23 08:21:50','2026-10-23 08:21:50','{\"en\": \"PayrollAudit: Restore record\", \"uk\": \"PayrollAudit: Відновити запис\"}'),(152,'payrollaudit_deleteGroup','web','2026-10-23 08:21:50','2026-10-23 08:21:50','{\"en\": \"PayrollAudit: Delete group\", \"uk\": \"PayrollAudit: Видалити групу\"}'),(153,'payrollaudit_boolToggle','web','2026-10-23 08:21:50','2026-10-23 08:21:50','{\"en\": \"PayrollAudit: Toggle boolean\", \"uk\": \"PayrollAudit: Перемкнути стан\"}'),(154,'payrollaudit_ordering','web','2026-10-23 08:21:50','2026-10-23 08:21:50','{\"en\": \"PayrollAudit: Change ordering\", \"uk\": \"PayrollAudit: Змінити порядок\"}'),(155,'payrollaudit_view','web','2026-10-23 08:21:50','2026-10-23 08:21:50','{\"en\": \"PayrollAudit: View record\", \"uk\": \"PayrollAudit: Переглянути запис\"}'),(156,'payrollaudit_duplicate','web','2026-10-23 08:21:50','2026-10-23 08:21:50','{\"en\": \"PayrollAudit: Duplicate record\", \"uk\": \"PayrollAudit: Дублювати запис\"}'),(157,'payrollaudit_duplicateGroup','web','2026-10-23 08:21:50','2026-10-23 08:21:50','{\"en\": \"PayrollAudit: Duplicate group\", \"uk\": \"PayrollAudit: Дублювати групу\"}'),(158,'payrollaudit_impersonate','web','2026-10-23 08:21:50','2026-10-23 08:21:50','{\"en\": \"PayrollAudit: Impersonate\", \"uk\": \"PayrollAudit: Impersonate\"}'),(159,'payrollAdjustment_SHOW_SIDE_MENU','web','2026-10-23 08:21:52','2026-10-23 08:21:52','{\"en\": \"PayrollAdjustment: Show in Menu\", \"uk\": \"PayrollAdjustment: Показувати в меню\"}'),(160,'payrollAdjustment_index','web','2026-10-23 08:21:52','2026-10-23 08:21:52','{\"en\": \"PayrollAdjustment: List records\", \"uk\": \"PayrollAdjustment: Список записів\"}'),(161,'payrollAdjustment_create','web','2026-10-23 08:21:52','2026-10-23 08:21:52','{\"en\": \"PayrollAdjustment: Create record\", \"uk\": \"PayrollAdjustment: Створити запис\"}'),(162,'payrollAdjustment_store','web','2026-10-23 08:21:52','2026-10-23 08:21:52','{\"en\": \"PayrollAdjustment: Store record\", \"uk\": \"PayrollAdjustment: Зберегти запис\"}'),(163,'payrollAdjustment_edit','web','2026-10-23 08:21:52','2026-10-23 08:21:52','{\"en\": \"PayrollAdjustment: Edit record\", \"uk\": \"PayrollAdjustment: Редагувати запис\"}'),(164,'payrollAdjustment_update','web','2026-10-23 08:21:52','2026-10-23 08:21:52','{\"en\": \"PayrollAdjustment: Update record\", \"uk\": \"PayrollAdjustment: Оновити запис\"}'),(165,'payrollAdjustment_delete','web','2026-10-23 08:21:52','2026-10-23 08:21:52','{\"en\": \"PayrollAdjustment: Delete record\", \"uk\": \"PayrollAdjustment: Видалити запис\"}'),(166,'payrollAdjustment_deletePermanent','web','2026-10-23 08:21:52','2026-10-23 08:21:52','{\"en\": \"PayrollAdjustment: Delete permanently\", \"uk\": \"PayrollAdjustment: Видалити назавжди\"}'),(167,'payrollAdjustment_restore','web','2026-10-23 08:21:52','2026-10-23 08:21:52','{\"en\": \"PayrollAdjustment: Restore record\", \"uk\": \"PayrollAdjustment: Відновити запис\"}'),(168,'payrollAdjustment_deleteGroup','web','2026-10-23 08:21:52','2026-10-23 08:21:52','{\"en\": \"PayrollAdjustment: Delete group\", \"uk\": \"PayrollAdjustment: Видалити групу\"}'),(169,'payrollAdjustment_boolToggle','web','2026-10-23 08:21:52','2026-10-23 08:21:52','{\"en\": \"PayrollAdjustment: Toggle boolean\", \"uk\": \"PayrollAdjustment: Перемкнути стан\"}'),(170,'payrollAdjustment_ordering','web','2026-10-23 08:21:52','2026-10-23 08:21:52','{\"en\": \"PayrollAdjustment: Change ordering\", \"uk\": \"PayrollAdjustment: Змінити порядок\"}'),(171,'payrollAdjustment_view','web','2026-10-23 08:21:52','2026-10-23 08:21:52','{\"en\": \"PayrollAdjustment: View record\", \"uk\": \"PayrollAdjustment: Переглянути запис\"}'),(172,'payrollAdjustment_duplicate','web','2026-10-23 08:21:52','2026-10-23 08:21:52','{\"en\": \"PayrollAdjustment: Duplicate record\", \"uk\": \"PayrollAdjustment: Дублювати запис\"}'),(173,'payrollAdjustment_duplicateGroup','web','2026-10-23 08:21:52','2026-10-23 08:21:52','{\"en\": \"PayrollAdjustment: Duplicate group\", \"uk\": \"PayrollAdjustment: Дублювати групу\"}'),(174,'payrollAdjustment_impersonate','web','2026-10-23 08:21:52','2026-10-23 08:21:52','{\"en\": \"PayrollAdjustment: Impersonate\", \"uk\": \"PayrollAdjustment: Impersonate\"}');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `pure_audit_entry`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pure_audit_entry` (
  `line_id` varchar(120) NOT NULL,
  `event_no` int unsigned NOT NULL,
  `type` enum('system_calculated','system_ignored','adjustment') NOT NULL,
  `amount_cents` bigint NOT NULL,
  `balance_cents` bigint NOT NULL,
  `comment` text,
  `actor` varchar(255) DEFAULT NULL,
  `adjustment_no` int unsigned DEFAULT NULL,
  `occurred_at` datetime(6) NOT NULL,
  PRIMARY KEY (`line_id`,`event_no`),
  KEY `occurred` (`line_id`,`occurred_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `pure_audit_entry` WRITE;
/*!40000 ALTER TABLE `pure_audit_entry` DISABLE KEYS */;
INSERT INTO `pure_audit_entry` VALUES ('anna:2026-10',1,'system_calculated',100000,100000,NULL,NULL,NULL,'2026-10-14 09:00:00.000000'),('anna:2026-10',2,'system_calculated',105000,105000,NULL,NULL,NULL,'2026-10-16 09:00:00.000000'),('anna:2026-10',3,'adjustment',-4555,100445,'Employee declined dental benefit; reversing deduction','Olena (payroll specialist)',1,'2026-10-17 09:00:00.000000'),('anna:2026-10',4,'system_ignored',130000,100445,'Line already has manual adjustments',NULL,NULL,'2026-10-19 09:00:00.000000'),('anna:2026-10',5,'adjustment',10010,110455,'Late correction: missed approved overtime bonus','Olena (payroll specialist)',2,'2026-10-20 09:00:00.000000'),('anna:2026-10',6,'adjustment',-10,110445,'Minor rounding adjustment','Olena (payroll specialist)',3,'2026-10-21 09:00:00.000000'),('anna:2026-10',7,'adjustment',-20,110425,'Second minor rounding adjustment','Olena (payroll specialist)',4,'2026-10-22 09:00:00.000000'),('anna:2026-10',8,'adjustment',20,110445,'Correcting mistake in adjustment #4','Olena (payroll specialist)',5,'2026-10-23 09:00:00.000000'),('bohdan:2026-10',1,'system_calculated',240000,240000,NULL,NULL,NULL,'2026-10-24 09:00:00.000000'),('olena:2026-10',1,'system_calculated',185050,185050,NULL,NULL,NULL,'2026-10-25 09:00:00.000000');
/*!40000 ALTER TABLE `pure_audit_entry` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `pure_employees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pure_employees` (
  `id` varchar(64) NOT NULL,
  `name` varchar(255) NOT NULL,
  `currency` char(3) NOT NULL,
  `base_salary_cents` bigint NOT NULL,
  `benefits_deduction_cents` bigint NOT NULL DEFAULT '0',
  `bonus_cents` bigint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `pure_employees` WRITE;
/*!40000 ALTER TABLE `pure_employees` DISABLE KEYS */;
INSERT INTO `pure_employees` VALUES ('anna','Anna Koval','USD',130000,0,0),('bohdan','Bohdan Melnyk','USD',240000,0,0),('olena','Olena Shevchenko','USD',185050,0,0);
/*!40000 ALTER TABLE `pure_employees` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `pure_events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pure_events` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `stream_id` varchar(120) NOT NULL,
  `version` int unsigned NOT NULL,
  `event_type` varchar(100) NOT NULL,
  `payload` json NOT NULL,
  `occurred_at` datetime(6) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `stream_version` (`stream_id`,`version`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `pure_events` WRITE;
/*!40000 ALTER TABLE `pure_events` DISABLE KEYS */;
INSERT INTO `pure_events` VALUES (1,'anna:2026-10',1,'LineCalculated','{\"line\": \"anna:2026-10\", \"value\": \"1000.00\", \"currency\": \"USD\"}','2026-10-14 09:00:00.000000'),(2,'anna:2026-10',2,'SystemValueRecalculated','{\"line\": \"anna:2026-10\", \"value\": \"1050.00\", \"currency\": \"USD\"}','2026-10-16 09:00:00.000000'),(3,'anna:2026-10',3,'AdjustmentAdded','{\"key\": null, \"line\": \"anna:2026-10\", \"actor\": \"Olena (payroll specialist)\", \"amount\": \"-45.55\", \"number\": 1, \"comment\": \"Employee declined dental benefit; reversing deduction\", \"currency\": \"USD\"}','2026-10-17 09:00:00.000000'),(4,'anna:2026-10',4,'RecalculationIgnored','{\"line\": \"anna:2026-10\", \"value\": \"1300.00\", \"currency\": \"USD\"}','2026-10-19 09:00:00.000000'),(5,'anna:2026-10',5,'AdjustmentAdded','{\"key\": null, \"line\": \"anna:2026-10\", \"actor\": \"Olena (payroll specialist)\", \"amount\": \"100.10\", \"number\": 2, \"comment\": \"Late correction: missed approved overtime bonus\", \"currency\": \"USD\"}','2026-10-20 09:00:00.000000'),(6,'anna:2026-10',6,'AdjustmentAdded','{\"key\": null, \"line\": \"anna:2026-10\", \"actor\": \"Olena (payroll specialist)\", \"amount\": \"-0.10\", \"number\": 3, \"comment\": \"Minor rounding adjustment\", \"currency\": \"USD\"}','2026-10-21 09:00:00.000000'),(7,'anna:2026-10',7,'AdjustmentAdded','{\"key\": null, \"line\": \"anna:2026-10\", \"actor\": \"Olena (payroll specialist)\", \"amount\": \"-0.20\", \"number\": 4, \"comment\": \"Second minor rounding adjustment\", \"currency\": \"USD\"}','2026-10-22 09:00:00.000000'),(8,'anna:2026-10',8,'AdjustmentAdded','{\"key\": null, \"line\": \"anna:2026-10\", \"actor\": \"Olena (payroll specialist)\", \"amount\": \"0.20\", \"number\": 5, \"comment\": \"Correcting mistake in adjustment #4\", \"currency\": \"USD\"}','2026-10-23 09:00:00.000000'),(9,'bohdan:2026-10',1,'LineCalculated','{\"line\": \"bohdan:2026-10\", \"value\": \"2400.00\", \"currency\": \"USD\"}','2026-10-24 09:00:00.000000'),(10,'olena:2026-10',1,'LineCalculated','{\"line\": \"olena:2026-10\", \"value\": \"1850.50\", \"currency\": \"USD\"}','2026-10-25 09:00:00.000000');
/*!40000 ALTER TABLE `pure_events` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`%`*/ /*!50003 TRIGGER `pure_events_no_update` BEFORE UPDATE ON `pure_events` FOR EACH ROW SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'events is append-only: updates are not allowed' */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`%`*/ /*!50003 TRIGGER `pure_events_no_delete` BEFORE DELETE ON `pure_events` FOR EACH ROW SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'events is append-only: deletes are not allowed' */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
DROP TABLE IF EXISTS `pure_line_view`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pure_line_view` (
  `line_id` varchar(120) NOT NULL,
  `employee_id` varchar(64) NOT NULL,
  `period` char(7) NOT NULL,
  `currency` char(3) NOT NULL,
  `system_value_cents` bigint NOT NULL,
  `current_value_cents` bigint NOT NULL,
  `frozen` tinyint(1) NOT NULL DEFAULT '0',
  `adjustment_count` int unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`line_id`),
  KEY `employee_period` (`employee_id`,`period`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `pure_line_view` WRITE;
/*!40000 ALTER TABLE `pure_line_view` DISABLE KEYS */;
INSERT INTO `pure_line_view` VALUES ('anna:2026-10','anna','2026-10','USD',105000,110445,1,5),('bohdan:2026-10','bohdan','2026-10','USD',240000,240000,0,0),('olena:2026-10','olena','2026-10','USD',185050,185050,0,0);
/*!40000 ALTER TABLE `pure_line_view` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(7,1),(8,1),(9,1),(10,1),(11,1),(12,1),(13,1),(14,1),(15,1),(16,1),(17,1),(18,1),(19,1),(20,1),(21,1),(22,1),(23,1),(24,1),(25,1),(26,1),(27,1),(28,1),(29,1),(30,1),(31,1),(32,1),(33,1),(34,1),(35,1),(36,1),(37,1),(38,1),(39,1),(40,1),(41,1),(42,1),(43,1),(44,1),(45,1),(46,1),(47,1),(48,1),(49,1),(50,1),(51,1),(52,1),(53,1),(54,1),(55,1),(56,1),(57,1),(58,1),(59,1),(60,1),(61,1),(62,1),(63,1),(64,1),(65,1),(66,1),(67,1),(68,1),(69,1),(70,1),(71,1),(72,1),(73,1),(74,1),(75,1),(76,1),(77,1),(78,1),(111,1),(112,1),(113,1),(114,1),(115,1),(116,1),(117,1),(118,1),(119,1),(120,1),(121,1),(122,1),(123,1),(124,1),(125,1),(126,1),(127,1),(128,1),(129,1),(130,1),(131,1),(132,1),(133,1),(134,1),(135,1),(136,1),(137,1),(138,1),(139,1),(140,1),(141,1),(142,1),(143,1),(144,1),(145,1),(146,1),(147,1),(148,1),(149,1),(150,1),(151,1),(152,1),(153,1),(154,1),(155,1),(156,1),(157,1),(158,1),(159,1),(160,1),(161,1),(162,1),(163,1),(164,1),(165,1),(166,1),(167,1),(168,1),(169,1),(170,1),(171,1),(172,1),(173,1),(174,1);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `display_name` json DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'super-admin','web','2026-10-23 07:22:38','2026-10-23 07:22:38',NULL);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('0c7F2poUQaOCOdu1QJQWAonShEZorRJ7a4si8z9U',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Electron/44.9.3 Safari/537.36 MSIX','eyJfdG9rZW4iOiJsSWtBaUk3enF2SnVab2tmeVA2amRoWjI3ZWNWcWs5OUR4TjVzeXR6IiwiZmlsYW1lbnQiOnsibm90aWZpY2F0aW9ucyI6eyJtYWlsYm94IjoiMzEzZDc2YTFjMjRlMWM3YTRhMTFlODQzZjZhYjk3YjIwZjMyOTBkMmQ1ODhlYjRhZWQ0MDRmZWViNDA0YzY2MSJ9fSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792950320),('1YYSV3uFsekrnR8rDsenMoYR4fT7yALuvAqHzEaf',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Electron/44.9.3 Safari/537.36 MSIX','eyJfdG9rZW4iOiJXZTRacHJnN1RzdVBPRmd1ckNtMTRSMGRZbllQdldDWWhGakpMTEZCIiwiZmlsYW1lbnQiOnsibm90aWZpY2F0aW9ucyI6eyJtYWlsYm94IjoiNmE3M2JlNTVmMmZhN2I0MGRmNzQxYTg1ZWUxMGYyM2Q1NGIyZDNjZmE3MDgwYzgyYzNhMDE0ODczYTI1YTVhNSJ9fSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792950244),('1ZXQQIp7kQHaF9iZSRn02OLvb4UoHke9psmBZ23v',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Electron/44.9.3 Safari/537.36 MSIX','eyJfdG9rZW4iOiJLbDN1NHRIa3pZV3Jaam1NRTFENmpqV0dXRG16OTNpY3VOeEpua3dUIiwiZmlsYW1lbnQiOnsibm90aWZpY2F0aW9ucyI6eyJtYWlsYm94IjoiZGFiOGYwMTZmMGUyMWU0YTNlY2ZlMzA2N2IyMDcwZjE3ZGE0MTJjNGEyMTMzZjBmMDUwZjYxOTZlZWI0MDAzNCJ9fSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792950199),('3iv2qeQvjSJJSsvGJNR2CPWwUorLEclh9RtU7tH5',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Electron/44.9.3 Safari/537.36 MSIX','eyJfdG9rZW4iOiJWWDZmVHgySnQyWmNtQVZRNFZ1YWNUSUdQS2RkZk1uRXRvTThyU3RHIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792950170),('4mcUTaXuIDGbOG9D0VbyZBuZPyKBdia4401c4Ms8',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Electron/44.9.3 Safari/537.36 MSIX','eyJfdG9rZW4iOiJnVWd4b0EwaXg2MWw0WnJPNGRwc3dJN0MxZGhnVHVDem1kTWlwbUhxIiwiZmlsYW1lbnQiOnsibm90aWZpY2F0aW9ucyI6eyJtYWlsYm94IjoiZDg0MzI0OGMwNTBmN2MzMzRmYzMxMGYyYTJmZmIyMWQyNDAzMjU4OGJhZTczOTVjMmVjOWE2MDZmY2NkMTRkMyJ9fSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792950231),('4ZBDRHdBwDaC0ETlenqXKWeWdL2T1OwQfkFTKBZ9',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Electron/44.9.3 Safari/537.36 MSIX','eyJfdG9rZW4iOiIwTFNRQWM4QlYwSzJqc2dxbkdVQktaSzJPNG5US3NlZkoxQ24wMG90IiwiZmlsYW1lbnQiOnsibm90aWZpY2F0aW9ucyI6eyJtYWlsYm94IjoiZTA0NzFlMmE1ODQwMTY3M2RlNzY2NTgwYzA0NDg3MGZhNzM0MDEzMzAyZmZlODQxZjNiZTE4MzllMTQzODY1ZiJ9fSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792950274),('6s5LvRFUdA3mvPUsRb54qileVAqQ7KF8KzcDsRhp',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Electron/44.9.3 Safari/537.36 MSIX','eyJfdG9rZW4iOiJxSE1jRjl1ZTN3WGdWbVhWZUZBT2lBYjFpbjNCWlpDNmpGMTRNekhSIiwiZmlsYW1lbnQiOnsibm90aWZpY2F0aW9ucyI6eyJtYWlsYm94IjoiMDE5ZTc3ZGJhMGJkYTY1NjFmY2QwOTJlOTliYTA2MzVlNDQwN2Q4MDc2ZWE1MjZjNDdkYzE0Yjg5ZDExYjk3MyJ9fSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792950177),('7nHMjYVHI70jUJIOBqZ86bK1MjwrwJGFnrT49f1u',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Electron/44.9.3 Safari/537.36 MSIX','eyJfdG9rZW4iOiJaVzlHQnBiaGJmc0FPbk9sOFZMTXVVQm51MjZ2SUc5QVRicmtvRGpxIiwiZmlsYW1lbnQiOnsibm90aWZpY2F0aW9ucyI6eyJtYWlsYm94IjoiZjgyY2RlZjBlMjZkZmMxYmEwNzA3Njc0Y2FiMTNhMGU5MzVlMGY0YjEwOTA4YjcwYjBiZDg3YjlmOTJhYzgxMyJ9fSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792950286),('8VK7Db8o60HDtH4m274LbQW6DVV8qbakez9XOuoU',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Electron/44.9.3 Safari/537.36 MSIX','eyJfdG9rZW4iOiJzWnAyVVdrOHo3NFpTNXFOODE5UTkwRGJjancxNk9XZXJ6SklXWTJFIiwiZmlsYW1lbnQiOnsibm90aWZpY2F0aW9ucyI6eyJtYWlsYm94IjoiNGQ0Yjc5MWM5MzZmYmQ1YjY5M2M1MTc2NTVkODEwZGU5Y2JlZjJhMTIzYzUxYjI0NTExYjA5MGZjNGQ1OTJhYyJ9fSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792950211),('AEsPSKL2uWB5363R9NVBRumGvrEAwNRxQj5BT5uk',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Electron/44.9.3 Safari/537.36 MSIX','eyJfdG9rZW4iOiI0UGM2a3F6U1BHbnAyQ1d3MXRYOGxNSGJQRkNJZGVNQlBXZmFMV0JvIiwiZmlsYW1lbnQiOnsibm90aWZpY2F0aW9ucyI6eyJtYWlsYm94IjoiYjc4ODEwNGU4NTI3MDQyNWMyOTg0NzE1MWRiNzY2NTNmNzIzMjZhYjVlYjdlY2I0ZTkwZTFiMGM1NTRhM2Q3OSJ9fSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792950235),('AWCpaTgqcBagAqMNomWNIjnJ1qVMdMtEYqHmfdwp',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Electron/44.9.3 Safari/537.36 MSIX','eyJfdG9rZW4iOiJ5NFNTUzVPMFB2czNaYVdudEt2SFY1QmpOdWdIS0x4S3lqZEZDMnVYIiwiZmlsYW1lbnQiOnsibm90aWZpY2F0aW9ucyI6eyJtYWlsYm94IjoiMzNhZGJkNTY1NjQwMGRkMDM0MTllZWFkOWU5ZWQyYzI4OTQxYzgzZjVjYjU0ZjNiYzQyNzhlNmNjYTJjNDY2MyJ9fSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792950311),('Cxys73fi4J1dxZ1J74c8gzM39naYxvXrViJlm3Qo',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Electron/44.9.3 Safari/537.36 MSIX','eyJfdG9rZW4iOiIzdVdDV1Boek81SzMyb1NLaTJZaXVUMmY3WUZFNkQzUDhXaUtKdUltIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792950169),('D5Z7FQHomACGNngbA894H8X6Uj8FmEI8myREHyiJ',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Electron/44.9.3 Safari/537.36 MSIX','eyJfdG9rZW4iOiJVMmJmdDZ1QUhOc3lxbDJRblE0MG13WmJlYzJzNnJMcW05NEhzbDQ0IiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792950341),('DS65RjMBz8pExcRAsGvYTcqhLIEn4XYIGbebdSIe',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Electron/44.9.3 Safari/537.36 MSIX','eyJfdG9rZW4iOiJrMlRtbFlVWVJXZmVhbGVoYlh6Smh0TFJjRUZpeXBDd2RzSjFaaVZLIiwiZmlsYW1lbnQiOnsibm90aWZpY2F0aW9ucyI6eyJtYWlsYm94IjoiM2UwNmU2ZTA3OGMzYjEwNTNjNTYzYmE2MTE3YjE5M2U5YzkxMmM1ZWY0ZjdjMDIyNmUyNzRiOGZlZTVhZDc4NyJ9fSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792950257),('Dw76wCfHOIXJIZluskeU6dXqFPcIZyfYAwrHlzOg',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Electron/44.9.3 Safari/537.36 MSIX','eyJfdG9rZW4iOiJnU3hkcXMxbUN2ekRsaXFZU1dPZmtUbWtMY2J2MlJPeDVUb0dGaEJHIiwiZmlsYW1lbnQiOnsibm90aWZpY2F0aW9ucyI6eyJtYWlsYm94IjoiNTY3MzAxNzkxYWI4ZTM2NzI1MzFhOTZkZTVhZjE1NWNiNzkxNzg5NGIyYzJmMTgwZDQzZWMwMmU1NmIxOTZlMiJ9fSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792950198),('EM9dhLfRU3Qt5DeKdlnhDpmw0EUn01bAPFfjsxVB',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Electron/44.9.3 Safari/537.36 MSIX','eyJfdG9rZW4iOiJoU1BCbFdrdzdqMVFiMWxuYjVtRW9VZnN6TXdzSlJib21oMHhrWVhDIiwiZmlsYW1lbnQiOnsibm90aWZpY2F0aW9ucyI6eyJtYWlsYm94IjoiMDQ1MTc2ZThjNWFlMjY5MmZjOWU2OGI5MzA0OGE4ZWYyOGVkNzYzNzcwOTNmNWQ2M2U2MjE4ZDFhYWJiMWJjOCJ9fSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792950223),('epznAiMN5mhBfmVYTD4zTLfzJJL3E9VCBin8A0ob',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Electron/44.9.3 Safari/537.36 MSIX','eyJfdG9rZW4iOiJXT09vRmQwcWE5eTBKZWY3Rm9yck1JZWY2eWUyd0FRSGFtdlpLUTc4IiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792950215),('eQFvRo6iYZZ3jehfI8mc4AKUW9Vf06rx3lPiNluM',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Safari/537.36 MSIX','eyJfdG9rZW4iOiJ0aUhRTjE3dnpzaGh4U2NtSWRSZ3Rvc3Qzcm5UU0hkNThkd3BsemF3IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9hZG1pblwvUGF5cm9sbEF1ZGl0XC9hY3Rpb25cL2luZGV4P2VtcGxveWVlPTEmZnJvbT0yMDI2LTEwLTIwJnBlcmlvZD0mdG89MjAyNi0xMC0yMiIsInJvdXRlIjoibmV4dXMubW9kdWxlLmFjdGlvbiJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX0sInVybCI6W10sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjoxLCJwYXNzd29yZF9oYXNoX3dlYiI6IjNhMGI5ZjRjNTQxNzY3YWE1MmQwOTVjNGMxNWIyNzkyNzc5MjE2MDc1OGViYTQxZjg2M2E2YmNiMTU4ZWI3OTAifQ==',1792950683),('eRZStpz1j8P3d54LehR2L3y3fEF0WybCYhIAvLhL',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Safari/537.36 MSIX','eyJfdG9rZW4iOiJwRWNMenpvV2RVd05Fcm5vcmg3bHFhZ1JjdHIwWmJBamQxSVVaVUc2IiwiZmlsYW1lbnQiOnsibm90aWZpY2F0aW9ucyI6eyJtYWlsYm94IjoiNThjSzNQMlZQVWMyYmdHM0FlUmU0R3U3T3ZrWkhnUFhWaUpiOEthUiJ9LCJ0YWJsZXMiOnsiOTE4ODZmZGNjOWEzMjFjNmM5MzIwZmE5YzcxOWU2YTg5M2RiYTMwZjdlNjk2YzRkNzAyNjI4YmYxMDdiYmZiNCI6eyJjb2x1bW5zIjpbeyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6Im5hbWUiLCJsYWJlbCI6Ik5hbWUiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoiY3VycmVuY3kiLCJsYWJlbCI6IkN1cnJlbmN5IiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6ImJhc2Vfc2FsYXJ5IiwibGFiZWwiOiJCYXNlIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6ImJlbmVmaXRzX2RlZHVjdGlvbiIsImxhYmVsIjoiQmVuZWZpdHMiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoiYm9udXMiLCJsYWJlbCI6IkJvbnVzIiwiaXNIaWRkZW4iOmZhbHNlLCJpc1RvZ2dsZWQiOnRydWUsImlzVG9nZ2xlYWJsZSI6ZmFsc2UsImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI6bnVsbH0seyJ0eXBlIjoiY29sdW1uIiwibmFtZSI6InBheXJvbGxfbGluZXNfY291bnQiLCJsYWJlbCI6IlBlcmlvZHMiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfV19LCI4OTVkMzViZDlhMzM3NzQ4MWI3OGY2YWIzMzEwMDg2NTk3ZTg1OTJmMDA0NTEyMzIwNTYxZTk2ZmIyZThhNTEzIjp7ImNvbHVtbnMiOlt7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoicGVyaW9kIiwibGFiZWwiOiJQZXJpb2QiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoic3lzdGVtX3ZhbHVlIiwibGFiZWwiOiJTeXN0ZW0gdmFsdWUiLCJpc0hpZGRlbiI6ZmFsc2UsImlzVG9nZ2xlZCI6dHJ1ZSwiaXNUb2dnbGVhYmxlIjpmYWxzZSwiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjpudWxsfSx7InR5cGUiOiJjb2x1bW4iLCJuYW1lIjoiY3VycmVudF92YWx1ZSIsImxhYmVsIjoiQ3VycmVudCB2YWx1ZSIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJmcm96ZW4iLCJsYWJlbCI6IkZyb3plbiIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9LHsidHlwZSI6ImNvbHVtbiIsIm5hbWUiOiJhZGp1c3RtZW50X2NvdW50IiwibGFiZWwiOiJBZGp1c3RtZW50cyIsImlzSGlkZGVuIjpmYWxzZSwiaXNUb2dnbGVkIjp0cnVlLCJpc1RvZ2dsZWFibGUiOmZhbHNlLCJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiOm51bGx9XX19fSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAxXC9hZG1pblwvcGF5cm9sbC1hdWRpdD9lbXBsb3llZT0wMU01VDJKQUM5WldXUjU1TjhBQ0NKMk1XSiIsInJvdXRlIjoiZmlsYW1lbnQuYWRtaW4ucGFnZXMucGF5cm9sbC1hdWRpdCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjoxLCJwYXNzd29yZF9oYXNoX3dlYiI6IjRjZDcwZGRhNjJlMzMwMDRmZjcwNDNiNmQ3NTVhMDA2YzgwMTA3OGUzZmFiYjhlZTkxNDllZThlOTM4YWJmNTAifQ==',1792950440),('fKC0LR5pbGhplix9hu7hnN26nvyzlpamz0FN6kdT',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJOa0hZd3pjYzhtVlNIS080bVNTbXdvVUJJWncxVzBjYkI2QmNwUThNIiwidXJsIjpbXSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC9sYXJhdmVsLW5leHVzXC9hZG1pblwvUGF5cm9sbEFkanVzdG1lbnRcL2FjdGlvblwvY3JlYXRlIiwicm91dGUiOiJuZXh1cy5tb2R1bGUuYWN0aW9uIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjEsInBhc3N3b3JkX2hhc2hfd2ViIjoiZDEzMjNhNThmYTExMzQzN2Y1MmU0MzdhYzEyYTVkYzgxYjI2MDFjNjZjYzhhMDAyOGE1MmE2MDMyYzEzZTMzNCJ9',1792957363),('gHJuRXbO3kqvsSA92ZyUTTD7EXDENBEwvjVWcdOK',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Electron/44.9.3 Safari/537.36 MSIX','eyJfdG9rZW4iOiJwVTRyNjJjNGQ4SFJNelJxdmxqcWVaMWlVOVNmWGg4TWNVcnEzVkJHIiwiZmlsYW1lbnQiOnsibm90aWZpY2F0aW9ucyI6eyJtYWlsYm94IjoiMmM1MmNkMGRjZjRkYTljNzNkZDVkNDI4NTFjZjBiNTU3ZTJkZjc1M2MzYmZjMTk1YmM0NTEwZGIxNmZiZDY4ZiJ9fSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792950227),('HG7cXhm5I6JQ7PgyQbcEr4VZQl4S0lPVkibEQ6wJ',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Electron/44.9.3 Safari/537.36 MSIX','eyJfdG9rZW4iOiJ4NjAzVnNBY0c1dnVhbmVHeG85ZW02OEYyR0tWUEU0aURDVlJlVnI0IiwiZmlsYW1lbnQiOnsibm90aWZpY2F0aW9ucyI6eyJtYWlsYm94IjoiODJkMTE3YjcyNDQ0MWRjZjNjOGE5OTQ0NWIwODI4MDQ0NzY5YjUwYzRlMTllZmU1ODkwMTM0OTI1YWQ0OTRlNyJ9fSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792950189),('J5nWU6fjCVLo7iuvMDlwXeuvfoRnatTZ8KmB1Psl',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Electron/44.9.3 Safari/537.36 MSIX','eyJfdG9rZW4iOiJrYWxpd0w3bjNobnFnSG1SME5IR0ZTVEFVaXZ0QURXTG5FYnROckFMIiwiZmlsYW1lbnQiOnsibm90aWZpY2F0aW9ucyI6eyJtYWlsYm94IjoiMGVkOTA1ODY0OWZiZTU2MGZlMmFhMjUxMTgyMTc2NzVmM2IxMWY4ZGFmMzU3ODM2ZDljY2M0MmNjZmFlNDZhOSJ9fSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792950228),('JV7355cFeViWqqTOkDA1n6MMmLNqXPIfmGQPQTSQ',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Electron/44.9.3 Safari/537.36 MSIX','eyJfdG9rZW4iOiI1SW5oUG83NFMyaE9TWlNHN0JMNHhOczNrWHhCRXk2eDdyS3huZ1FOIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792950163),('JygCjEYMDAxB66n0nSMhy14OT0Nl2c4KbXv5gZnP',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Electron/44.9.3 Safari/537.36 MSIX','eyJfdG9rZW4iOiIwZTZ5a212Wlo0c3hUWklLNlBNVkNmcXFHOTF3WW9mR2VKM0dJZ055IiwiZmlsYW1lbnQiOnsibm90aWZpY2F0aW9ucyI6eyJtYWlsYm94IjoiOGJmN2VhMjNhOTE4MGNlNGM5YzkxMzExZjFlNjU0ZmZhNThmZGJhMmNjNzRjNTA4ZmI2MGM1OTAwMzc1ZWQ3NSJ9fSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792950191),('kn7zHlKCxfv1QROLoVkMc98WvmHH3NdmIOmkir3V',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Electron/44.9.3 Safari/537.36 MSIX','eyJfdG9rZW4iOiJER2RxY1RZdkRwcjRaZU1WajEyb2JXenZOY3F4d2NXbktOM0MwUkJ1IiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792950232),('KrTCKtuCS4JXu89eKzuRbOH0UXKwJ97zLAnvP3jv',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Electron/44.9.3 Safari/537.36 MSIX','eyJfdG9rZW4iOiI2aGpERVpYNndUbVh2SGFqZzlsS1VmNkM3bWw5MlJ2bnYydnlDdGxqIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792950173),('LNSW63Oe3Kglolzo7xLPgIo50bvzvcCb9Diot0BP',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Electron/44.9.3 Safari/537.36 MSIX','eyJfdG9rZW4iOiJyYTRDa3l2ZGpVNlNMZmxGQmhWNDhicnFUemhKdXNwcjJjNE12OG5FIiwiZmlsYW1lbnQiOnsibm90aWZpY2F0aW9ucyI6eyJtYWlsYm94IjoiODNjYmM1NGRkOTFjNGRiYzJmNmI2MWYyMTlhZGU4YmU2NGZkNzkwNmEzMTM4OTlkMDUxMzVjYjYwOTQwY2IzZSJ9fSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792950307),('lRNWOh3c73padQvdae1B2lBDTpzzW7rp1RI2VcNU',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Electron/44.9.3 Safari/537.36 MSIX','eyJfdG9rZW4iOiJlWlJ4T1J3WWhsTFE0c29NYXM1ZVdWS3hJTHQxTURYWDlOa2U4cUZuIiwiZmlsYW1lbnQiOnsibm90aWZpY2F0aW9ucyI6eyJtYWlsYm94IjoiNzkwNjY2MmRhMGZmZmNhMDc3MjIzMzJlYTUzOWE4OGQ2YTNiNTIxMTFjZjMzNmJlNWFiNTNiYjRjYjM5YTk0ZSJ9fSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792950327),('lW8B1CLgP1Dqh22lAVKjhhyz0X2WuLeqlLYQEsyZ',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Electron/44.9.3 Safari/537.36 MSIX','eyJfdG9rZW4iOiJpWTEyZU5nRTZhbVNGeDRSY3FvUVNtYVBjb1JadW9YNTVDN3FhRDRJIiwiZmlsYW1lbnQiOnsibm90aWZpY2F0aW9ucyI6eyJtYWlsYm94IjoiMjljZTM3ZTJhNzM2NmZiOGUwMDRiYmNmZDBhZjViYTUzZTExODY1MGE0YWRmNDQzZDc4MzczYzM0Y2Y0ZjdmOCJ9fSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792950278),('M1t22tWB2kyKOasxdYreUYBVt2pfJWujo5Mu5L7f',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Electron/44.9.3 Safari/537.36 MSIX','eyJfdG9rZW4iOiJPcXNmdVlYZFBEdjhHNzllRXdCQU9NN09PMDdvanAzY3pmbm9uQ2UwIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792950166),('MMe73Dynj8ZFVIix4KBsGTk9oD4iCP1aoirwQqVc',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Electron/44.9.3 Safari/537.36 MSIX','eyJfdG9rZW4iOiJFZTFNUUJHemxaVnlxSTdFYUZBY2VNUHJ5Y2J2TE9Jd0tQVlpPQWNsIiwiZmlsYW1lbnQiOnsibm90aWZpY2F0aW9ucyI6eyJtYWlsYm94IjoiZTAwZGIwMDg2NWFiNjc3YmZjMTNhOWUzMGZiMjkyZThjMTgyMDJjODE2MmI2MmMwNGFiYzI0YzQ3ZTcwNGUzZSJ9fSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792950203),('mNB5ZoAEK8aylWhiZF90XGV6XIFL3yTdCGZXwZB4',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Electron/44.9.3 Safari/537.36 MSIX','eyJfdG9rZW4iOiJUQzZxc2lJem9pUnIzd0c4eG9VM0YwaXhhZlExdDhRTGxwOHFPa0tFIiwiZmlsYW1lbnQiOnsibm90aWZpY2F0aW9ucyI6eyJtYWlsYm94IjoiNzFhZmYzYzlmZjQ1OWU1YzUxNDA1MmEwNWVmNDQyM2JkNjgzMDliNjFjMGE2NWU2MDIyNDIyNzE0YTIwYTE2NiJ9fSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792949601),('MrWSCFSJvFGilqb1sqIgVAh76TVlnMSkxgV0Xtx9',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Electron/44.9.3 Safari/537.36 MSIX','eyJfdG9rZW4iOiJkaGxDclB4UkEwdzZ2bVQxRWpKeWVURWl0cnhlRUdKSExlN3ZTWGtoIiwiZmlsYW1lbnQiOnsibm90aWZpY2F0aW9ucyI6eyJtYWlsYm94IjoiM2MyMTNmNmRiZDQ0ODlhNGI2Njk0YmFiOTBmNDNiOTI0MmJmMzU0NzhiZWMxOWJhZDM2MjY4Yjk2NTkxZmVkOSJ9fSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792950341),('niub3ORG0hiNMRdN3UuyuH2YtM7khcQpYlinlj33',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Electron/44.9.3 Safari/537.36 MSIX','eyJfdG9rZW4iOiI0V1d2Z1Y4SHNIODJ1U0kwV3pMRm5uSGttc3hteWhzdUFNYkNyNGNsIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792950267),('nXhAoFJkF4DJvZjJbcVpUNNbPidLBbAYWxCtiVUf',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Electron/44.9.3 Safari/537.36 MSIX','eyJfdG9rZW4iOiJrNGJXMGVkYmo2TXhDbjR6bXFKaWRHMEtJVjlrM0dFdVV5R1JaRUp0IiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792950269),('Ny4mjkfhxaksCNjkS9a8uP1MAyADchIhnVDYn8Ht',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Electron/44.9.3 Safari/537.36 MSIX','eyJfdG9rZW4iOiJYdzVncFlFaktCWElPNXZ5ZlpQV3dTcUg5dms3WENsTVUzQU1WZUFZIiwiZmlsYW1lbnQiOnsibm90aWZpY2F0aW9ucyI6eyJtYWlsYm94IjoiN2E4NDI1ODgyMmY3Zjg0NTVkMWYzNGM3MjVhYTBkODUzYjYwZmE0YWEyNGZhNjM1OWE5OGQzODc3OTNmMDQyOSJ9fSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792950180),('NYf6NaFKNCwOIIqaRsnrkEOqCffEHeisE6X2BFrr',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Electron/44.9.3 Safari/537.36 MSIX','eyJfdG9rZW4iOiI5Zm1tZ1VWQ1h6NEdvdnV0dWJqTFhZcGRYNFJSbTl6S1V6VGFpaWZJIiwiZmlsYW1lbnQiOnsibm90aWZpY2F0aW9ucyI6eyJtYWlsYm94IjoiYTI0MDBkNTc2NTZjZDQyMjE3YmJiMDBhMjM0ODJlYjg5NmRlZTlmZmE4MjBkMDhiZTczZDE4ZWE2NTg3ZDQ4OSJ9fSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792950218),('oEloHiXvbvsRkgmOk09CkbZr5rOhCBxvXKSF8KJK',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Electron/44.9.3 Safari/537.36 MSIX','eyJfdG9rZW4iOiJreE5HcmYzR3U3SnJQMzJ2d3hQTU9td04yQjZSaFZFV1djMjJ0NGdQIiwiZmlsYW1lbnQiOnsibm90aWZpY2F0aW9ucyI6eyJtYWlsYm94IjoiZTVkYmQxNjQxMmQ3N2I3NmU0M2QyMWY3M2I5ZmZlZWJhMWZiYzIxMzVjOTRmOWYzMmIyYjQ2YmEzNWZlOGNiMSJ9fSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792950282),('oKeMW10h6O56qEQ6ZNFFYolrwlUFRzpXHY3Ceop4',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Electron/44.9.3 Safari/537.36 MSIX','eyJfdG9rZW4iOiJxR3FtdnNNQVV5dVBwV1hwRzEwdk9UTEhhWlp0aHRUVm83Z2gxakdHIiwiZmlsYW1lbnQiOnsibm90aWZpY2F0aW9ucyI6eyJtYWlsYm94IjoiYTdlMWFiMzczNzhhYTlhZWUyYmUyNzAwNDEwMTU4MGVhNmE0Njg3NTAzYTcyMzhhMjk0NGJhYWJhZTQyYWFlNCJ9fSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792950319),('oNeMLWAdqhka6bo2Yg8Fk7AwFeAjWoCcQ4UpLc2c',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Electron/44.9.3 Safari/537.36 MSIX','eyJfdG9rZW4iOiJJUWpzcW40b3RaTEVZMEo0S2NiVE1PZmJzVklqaDVrQUk0U2RNZDk0IiwiZmlsYW1lbnQiOnsibm90aWZpY2F0aW9ucyI6eyJtYWlsYm94IjoiOWZmOTAyMGY5NDc0Njk2OGEwN2UzNmQ0ZTNmYTcwMmE3M2RlNjVlYjMxZDdlMTBjYmFiMjA4M2U1ZTI5MGU0YSJ9fSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792950315),('P81icoZfvQ6hh77Uob9uwtwzPvUpvWy5KCHi42Gy',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Electron/44.9.3 Safari/537.36 MSIX','eyJfdG9rZW4iOiJ1MG5wcUxuTEYxYlRkdXdicGNzZ2ViQUZpRlllZndrZlBOSUxtVlRpIiwiZmlsYW1lbnQiOnsibm90aWZpY2F0aW9ucyI6eyJtYWlsYm94IjoiOTNjOTcxMDllNTdmZTU4YjU1YjM1NDY0NjFkZjZiOTc1YTlkMGQwMGI3NzI0ZmNhMzMzNDE1MmQ0N2IwM2RjMyJ9fSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792950181),('PTNtEGe7Ir5ZiGkmR8tGA84cux6ZaiM3znhAWvlo',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Electron/44.9.3 Safari/537.36 MSIX','eyJfdG9rZW4iOiJjaUE5OFY4NWU4dUozUGdIa09zSDFWUWZoV3lQMDNUc1ZQUlBRNGgxIiwiZmlsYW1lbnQiOnsibm90aWZpY2F0aW9ucyI6eyJtYWlsYm94IjoiMzlhZmI0YzI0NjBkNDBjMWEzMGQzYmQ1NGQxOGJhOWM2ZjFmYmJjM2U2MzA2YmUwZDA5ZmQ3ZDM2OGE1YjI5MiJ9fSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792950280),('QHe88QN9jz0NkU7svAyFYVhnMvxpDoIIEYi4IqUZ',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Electron/44.9.3 Safari/537.36 MSIX','eyJfdG9rZW4iOiJSMlhzV0VwczFPMzMzYmhsU0VwZW5PSDh5Q0pFdWd2aHBsYnU2TFdmIiwiZmlsYW1lbnQiOnsibm90aWZpY2F0aW9ucyI6eyJtYWlsYm94IjoiNTYyMmRhMzY3ZTFlMTdkYzk5YTIzMGNlMDE5MzE3YmM3ZWU5ZjE3MGY5NTQyZjE3Y2U0OGRmYWQ2YzQ4NzdlZCJ9fSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792950204),('qYsnODURjFCUPGzZgdKKmSVV08U6zTYnEvnhf0gR',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Electron/44.9.3 Safari/537.36 MSIX','eyJfdG9rZW4iOiJVd3llS3U0dkxmd2NUZzg0TFUxNmp6S0pIcDUzaGE5MUk3Z1ZpRTBOIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792950239),('rfnTn6ng4Zwm6mdjTqMngDvjjy06lEbhhGOeMXKu',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Electron/44.9.3 Safari/537.36 MSIX','eyJfdG9rZW4iOiJtZnFPeklPV3dFRTdlSURDQThhMUkyNXljVVV4STZSOXdadlVjMVc1IiwiZmlsYW1lbnQiOnsibm90aWZpY2F0aW9ucyI6eyJtYWlsYm94IjoiYmEyYjIwMDU1NjJmMTQwMDBmYzhiMDJlY2ZkNjU3MThiYzA4MDQ5MWYxMjM3NmY5ZDY4NzI4M2M3MWNhNGQ5OSJ9fSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792950194),('rR6A52DdGrmVRXrbvWkvKZRgTefAOeCvlIFsWaOX',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Electron/44.9.3 Safari/537.36 MSIX','eyJfdG9rZW4iOiJyaGJIMnRnMWQzekx5aHNySGhmZnQ1a0xsNXlSSU5aRXdpYllNbE5IIiwiZmlsYW1lbnQiOnsibm90aWZpY2F0aW9ucyI6eyJtYWlsYm94IjoiYTViNGRiYWNiMzY2NzFkNGU5OTI3YTdhMDEwY2JmYzM4NDdjOTU2ZmZhODhkYjE3NTI0OWQyOGZlMTJmMWMwMiJ9fSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792950312),('sEdf61HLENYco803P4SKAz1uxbgDidPnddz0XD37',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Electron/44.9.3 Safari/537.36 MSIX','eyJfdG9rZW4iOiJDZ1oyQjlqZUoxQnFHeDhjZXRZWExoWmNxQm9zREVUNXpmSHNZeW9JIiwiZmlsYW1lbnQiOnsibm90aWZpY2F0aW9ucyI6eyJtYWlsYm94IjoiODA3ZDZmMjNhNWMwNWQwZWJkZGJlMWE2ZGU4NWRiMzk1NWZkOGJlYWI2ZGEwOTgxN2VhM2MxN2FkM2ZhODA4ZCJ9fSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792950336),('sqWlkUXnaQ1lrhoXXA1pDXbVLnfRnrixnQK4SlTr',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Electron/44.9.3 Safari/537.36 MSIX','eyJfdG9rZW4iOiJhMjZrcmZXM1RvSHh0RzV0TGlTRldOOWMzcWxZRHZlZGc1cjB6bVUxIiwiZmlsYW1lbnQiOnsibm90aWZpY2F0aW9ucyI6eyJtYWlsYm94IjoiMmUyOWQ5M2RkOWRhMzdhZGFjMmYyMzJlMDJjNmE0OWYxNGNlNjQ2YTcyMjVhZjQwYWIzNzJiZDc5NzUzOGNlOSJ9fSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792950208),('ThscVhibyXlj2UVnjoc2y86n6ldRkT4BPev07lYO',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Electron/44.9.3 Safari/537.36 MSIX','eyJfdG9rZW4iOiJkWFJEeG9mTzVBcjEwZk10QlkzT2VQc1lyS2FaY1NZRjB0Y1F1U0FpIiwiZmlsYW1lbnQiOnsibm90aWZpY2F0aW9ucyI6eyJtYWlsYm94IjoiYTgwNDQ5NjVlNTgyM2VkYjA5NDhlMzZjZDhkYjQ0ZmIzYzE2OGUyZjVmMzQ0ZDQ1OGQ1ZWU3ZmQzOTRhMzY4ZSJ9fSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792950195),('TsgpBLXFpCbXhpODZdF7PvdJRQok1YLOpqPR9Xa3',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Electron/44.9.3 Safari/537.36 MSIX','eyJfdG9rZW4iOiIyVDVNcjdnUGU4c044RElFek9qTEt0TE9kd0lOTnVoN1lPQzh5cHByIiwiZmlsYW1lbnQiOnsibm90aWZpY2F0aW9ucyI6eyJtYWlsYm94IjoiMzMzMjYwOGIyZTk5MjdlMDBiMzQyMzFlNWZmNDcwYTYzNTMwODBkNzM3OWU3NmRmOGEyYzM2NWJiZmYzYTVmYSJ9fSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792950323),('UiqUCxoaJNRxVobEVmCxoS2dsZycBGFXfqXPwKeJ',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Electron/44.9.3 Safari/537.36 MSIX','eyJfdG9rZW4iOiI3SGI3RmlZQ216a21GUjJCZFJtRDIxMWU0R0pyQ1hPbW9qcFkxTGJsIiwiZmlsYW1lbnQiOnsibm90aWZpY2F0aW9ucyI6eyJtYWlsYm94IjoiMzExYjI5YjcxNmVmZDllNmNmOWI5ZTY3M2I1MzU0NzA3YWM1OTk1ODYwYWI2OTRmZmYxMmUxNTFmNDM2NmIxMCJ9fSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792949604),('uW7SD67DV498zlI8IYaaDnXv5OIPvMgktCU702jH',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Electron/44.9.3 Safari/537.36 MSIX','eyJfdG9rZW4iOiJzWUxHRHlqZUw2dzU5cGkyTjB2U3pURW1tWm5NNUlNYkV1RWt6NElKIiwiZmlsYW1lbnQiOnsibm90aWZpY2F0aW9ucyI6eyJtYWlsYm94IjoiM2ZjMGQwMmIwYTdiN2I5MmJmMzVjNDM5MjRlN2JkY2UyM2MxZjE3NmZkOTJkNWFlZTcwYjQwNDQ2ZDUyMzBjYiJ9fSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792950331),('VdXqA4BwEtandd2FC383AA8MdkdRNxKW2Zj9LreF',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Electron/44.9.3 Safari/537.36 MSIX','eyJfdG9rZW4iOiJ5NUNucGZPQmttcm83aUhsVzd6bFVFZnJvUGcyYTdBbmFNU3diY0g0IiwiZmlsYW1lbnQiOnsibm90aWZpY2F0aW9ucyI6eyJtYWlsYm94IjoiMmIxYTlhYmRkZWM5ZGU5ZGRjN2FlNjhmYjY1MGQ4MWFjNTNjMTc1ZGUyMWUzOGJlYjg0OGFhYzBmNjBjNzRkYSJ9fSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792950337),('vIBOMhYmetseGMQ21CF03LKHnqzvB7UmuoWVcypM',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Electron/44.9.3 Safari/537.36 MSIX','eyJfdG9rZW4iOiJCV0pmRHNCMTU3WGNQWGd5UVlCWHZacU96enVmYUhOYzNLZ2hKMlhjIiwiZmlsYW1lbnQiOnsibm90aWZpY2F0aW9ucyI6eyJtYWlsYm94IjoiYThlYWI1N2JlNDRmMDAwMTNjODNhZjExNDVjOGUyMDBhMTBiMzliNjRkZTc4NWFiZjRjNjk2YzAzZDMzNjhjYSJ9fSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792950184),('VxTjMD3y8e8oQ6QmszUBd2r7QroXqLIRaY2R00Td',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Electron/44.9.3 Safari/537.36 MSIX','eyJfdG9rZW4iOiJZa1lGU28yMXJiZWFpVjJOYkNVUlZKT2VObFBJbXdpM0VYOWhBcUFCIiwiZmlsYW1lbnQiOnsibm90aWZpY2F0aW9ucyI6eyJtYWlsYm94IjoiNThlNDYxZTcxMTkwMjIzOTYxYjNhMDQ2NmU0MmQ3MWRmN2RhOTdhODliOTEyMDc2ZmJjOTE2MTIyMWYwOTZiNCJ9fSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792950185),('WBSQ0FkcBFb4WhzVgGIvebZ8G9KWqlr9tXs2Rd3k',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Electron/44.9.3 Safari/537.36 MSIX','eyJfdG9rZW4iOiJoS2dlRTB3UVlHMklhTDUxczlweXVzV3pacVhITHJGQTVNNVhYSjlKIiwiZmlsYW1lbnQiOnsibm90aWZpY2F0aW9ucyI6eyJtYWlsYm94IjoiMzliOGE3NWM0MDFkZjRjZmNlOGY4YTMxMmU0YzNhY2JiNzk1OTdhYTJjODNhMTM0NDVjZGMzNzFlNjY2NDgxNSJ9fSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792950303),('WBX0oHhzgZ5EfuDQv2w0tpAf5zwroPj3DksiebZj',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Electron/44.9.3 Safari/537.36 MSIX','eyJfdG9rZW4iOiJkQ1BHOXVmY0ZxRnZoN2RGM2hjWWE2M25IZjMyeWRDajJmN09lT1lVIiwiZmlsYW1lbnQiOnsibm90aWZpY2F0aW9ucyI6eyJtYWlsYm94IjoiNDRkNjFlMDZiMDQ4OWFkOTgwNzY3NWQ4MDYwYjFiMzAyNTJiNWRkNDA0MmE2NmJiNDQ3M2Y0YzYwMjVlMDg5YyJ9fSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792950246),('wKYPI9By9w0o9rCB53NhHjDFA1TXG2MIR82usdRG',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Electron/44.9.3 Safari/537.36 MSIX','eyJfdG9rZW4iOiJnYmJCYlBmRE5GeTVTUHowSGd0ODJQYlpFaW1MUVR6bjdJWmZTMm9WIiwiZmlsYW1lbnQiOnsibm90aWZpY2F0aW9ucyI6eyJtYWlsYm94IjoiYWZiMjdjNzQ4OWEzZjdlNWZlMzdmODlkMzI2MzQ0MDJmNTBkNjhlNDIwMDg0NDgyZTFhYTZiNTA3OTA3MjkzMSJ9fSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792950247),('WQZOpHRa3ZaeztWYmADOkWxzSQLY9rwiTJS3umTn',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Electron/44.9.3 Safari/537.36 MSIX','eyJfdG9rZW4iOiI0UHhMdVhIdkN4MFNicHFZeUtkeHRjVHRDTkV4dU5iMjBmQWVxNHdNIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792950223),('y7ognjA8XcOGCRkdfivUuyq4Jfy5jCNvtfdc7djX',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJwdjd4MGZjaVV5c1luTVVMdktER0xmM0pNQ2ZRQXY2VVc4Yk11U0p3IiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC9sYXJhdmVsLW5leHVzXC9hZG1pblwvUGF5cm9sbEFkanVzdG1lbnRcL2FjdGlvblwvY3JlYXRlIiwicm91dGUiOiJuZXh1cy5tb2R1bGUuYWN0aW9uIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjEsInBhc3N3b3JkX2hhc2hfd2ViIjoiNWRkOWM1OWE2ODhkOTE4NDcyMTFkODc1OTY5N2I1MDQyMzY4MTJmNTgxNjYxOWNmNjg3NWZkMDM2ZDMwZjQ5ZiJ9',1792948946),('yEll07krK9pGoIPdLPY5G2vJTLF7TjkM1uurxPaZ',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Safari/537.36 MSIX','eyJfdG9rZW4iOiJuQzVNM055a2FGSndNVXk1S09lS3NEM0dweUU5Wnoyb1JBNjFHSVZKIiwiZmlsYW1lbnQiOnsibm90aWZpY2F0aW9ucyI6eyJtYWlsYm94IjoiMjA4YTFkM2VhMWFmZTdjYmI4NmYwM2IzZDA1MThiMzQxNzZjNTg0ZTlmNDM1MTk0NDZjMjc5YTRmMWE5NjQyNSJ9fSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAxXC9hZG1pbiIsInJvdXRlIjoiZmlsYW1lbnQuYWRtaW4ucGFnZXMuZGFzaGJvYXJkIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfSwidXJsIjp7ImludGVuZGVkIjoiaHR0cDpcL1wvbG9jYWxob3N0OjgwMDFcL2FkbWluIn19',1792950162),('ynA5iTXT0mLbfuoRMudny0MtnHQjXBEkCoNgqnVN',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Electron/44.9.3 Safari/537.36 MSIX','eyJfdG9rZW4iOiJTekFuN3Ztb2Q3SU9PdjB3dmlmdFlYZW9WUW5HS3JIc2libTkwTWN2IiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792950302),('Z9gCMX3d9s3uJ1W2sXHLScY0JDcN2eerx3kv77iS',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/3.6556.2 Chrome/152.0.7977.167 Electron/44.9.3 Safari/537.36 MSIX','eyJfdG9rZW4iOiJTTW5reWFVVkNUQlR1U0lvTkdlbDJybW54TUNMWFZJQ2FTdTVMNjh2IiwiZmlsYW1lbnQiOnsibm90aWZpY2F0aW9ucyI6eyJtYWlsYm94IjoiN2Y0MTkxMmE3YjhlMDE3MzBmMTczNDc2NDlhMmQ2NDBhZjNhZDA5ZjNhZGVmZjU4MWY5YzUwNTQ4NjA3YTYzYiJ9fSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119fQ==',1792950207);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `user_addresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_addresses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `street` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `house` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apartment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_main` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_addresses_user_id_foreign` (`user_id`),
  CONSTRAINT `user_addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `user_addresses` WRITE;
/*!40000 ALTER TABLE `user_addresses` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_addresses` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `middle_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Olena (payroll specialist)',NULL,'admin@example.com',NULL,'$2y$12$5TMtkPN4VR.jX59kZE/s1.KxbpRocFY1z3nAwbMfwBEF6zoeUS4we',NULL,'2026-10-23 07:22:38','2026-10-25 15:52:08',NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `widget_assignments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `widget_assignments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `widget_instance_id` bigint unsigned NOT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `target_template` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `widget_assignments_widget_instance_id_foreign` (`widget_instance_id`),
  KEY `widget_position_template_idx` (`position`,`target_template`,`is_active`),
  CONSTRAINT `widget_assignments_widget_instance_id_foreign` FOREIGN KEY (`widget_instance_id`) REFERENCES `widget_instances` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `widget_assignments` WRITE;
/*!40000 ALTER TABLE `widget_assignments` DISABLE KEYS */;
/*!40000 ALTER TABLE `widget_assignments` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `widget_instances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `widget_instances` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `widget_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `widget_class` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `widget_view` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `config` json DEFAULT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `widget_instances_widget_key_index` (`widget_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `widget_instances` WRITE;
/*!40000 ALTER TABLE `widget_instances` DISABLE KEYS */;
/*!40000 ALTER TABLE `widget_instances` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

