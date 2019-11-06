-- MySQL dump 10.13  Distrib 5.7.25, for Linux (x86_64)
--
-- Host: localhost    Database: budgets
-- ------------------------------------------------------
-- Server version	5.7.25-0ubuntu0.18.04.2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `budgets`
--

DROP TABLE IF EXISTS `budgets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `budgets` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cycle_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `budgets_cycle_id_foreign` (`cycle_id`),
  CONSTRAINT `budgets_cycle_id_foreign` FOREIGN KEY (`cycle_id`) REFERENCES `cycles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `budgets`
--

LOCK TABLES `budgets` WRITE;
/*!40000 ALTER TABLE `budgets` DISABLE KEYS */;
INSERT INTO `budgets` VALUES (1,1,'2019-11-04 22:13:50','2019-11-04 22:13:50');
/*!40000 ALTER TABLE `budgets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cycles`
--

DROP TABLE IF EXISTS `cycles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cycles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `initialized_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `finalized_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cycles`
--

LOCK TABLES `cycles` WRITE;
/*!40000 ALTER TABLE `cycles` DISABLE KEYS */;
INSERT INTO `cycles` VALUES (1,'2019-11-04 22:11:09','2020-01-04 22:11:09',1,'2019-11-04 22:11:09','2019-11-04 22:11:09');
/*!40000 ALTER TABLE `cycles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `department_item`
--

DROP TABLE IF EXISTS `department_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `department_item` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `department_id` bigint(20) unsigned NOT NULL,
  `item_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `department_item_department_id_foreign` (`department_id`),
  KEY `department_item_item_id_foreign` (`item_id`),
  CONSTRAINT `department_item_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `department_item_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `department_item`
--

LOCK TABLES `department_item` WRITE;
/*!40000 ALTER TABLE `department_item` DISABLE KEYS */;
INSERT INTO `department_item` VALUES (1,1,1,NULL,NULL);
/*!40000 ALTER TABLE `department_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `departments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departments`
--

LOCK TABLES `departments` WRITE;
/*!40000 ALTER TABLE `departments` DISABLE KEYS */;
INSERT INTO `departments` VALUES (1,'Docentes','2019-11-04 22:14:10','2019-11-04 22:14:10');
/*!40000 ALTER TABLE `departments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `budget_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `items_budget_id_foreign` (`budget_id`),
  CONSTRAINT `items_budget_id_foreign` FOREIGN KEY (`budget_id`) REFERENCES `budgets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `items`
--

LOCK TABLES `items` WRITE;
/*!40000 ALTER TABLE `items` DISABLE KEYS */;
INSERT INTO `items` VALUES (1,1,'2019-11-04 22:14:05','2019-11-04 22:14:05');
/*!40000 ALTER TABLE `items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=331 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (319,'2014_10_12_000000_create_users_table',1),(320,'2014_10_12_100000_create_password_resets_table',1),(321,'2019_08_05_234350_create_cycles_table',1),(322,'2019_09_02_192314_create_budgets_table',1),(323,'2019_09_03_172906_create_specifications_table',1),(324,'2019_09_03_175949_create_items_table',1),(325,'2019_09_18_180403_create_departments_table',1),(326,'2019_09_19_155701_create_department_item_table',1),(327,'2019_09_28_163354_create_quotations_table',1),(328,'2019_10_02_175141_create_notifications_table',1),(329,'2019_10_17_141115_create_roles_table',1),(330,'2019_10_17_141525_create_role_user_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint(20) unsigned NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
INSERT INTO `notifications` VALUES ('5252050c-7996-420f-a41a-9fb80caa3f61','App\\Notifications\\NewQuotation','App\\User',1,'{\"link\":\"quotations-show\",\"text\":\"Ha creado una cotizaci\\u00f3n el usuario Santiago\",\"data\":{\"description\":\"una prueba mas\",\"qty\":\"100.00\",\"archive\":\"c4apB4IE64uXHNuYPvi2rV4Q3aJFU2kBMXPlmCzK.png\",\"status\":\"PENDIENTE\",\"id\":1,\"iva\":0,\"total\":100,\"cycle_id\":1,\"item_id\":\"1\",\"department_id\":\"1\"},\"notifiable\":{\"id\":1,\"name\":\"Santiago\",\"email\":\"santi_shy@hotmail.com\",\"email_verified_at\":null,\"created_at\":\"2019-11-04 22:11:10\",\"updated_at\":\"2019-11-04 22:11:10\"}}','2019-11-04 23:20:57','2019-11-04 22:15:16','2019-11-04 23:20:57'),('5dc3fa48-062d-49e8-a598-f586584e1417','App\\Notifications\\NewQuotation','App\\User',3,'{\"link\":\"quotations-show\",\"text\":\"Ha creado una cotizaci\\u00f3n el usuario Santiago\",\"data\":{\"description\":\"fafsafa\",\"qty\":\"100\",\"archive\":\"wcwrH0AHP10iaEogHxko1EKTlVfqioT4QcSM9AGY.jpeg\",\"status\":\"PENDIENTE\",\"id\":2,\"iva\":0,\"total\":100,\"cycle_id\":1,\"item_id\":\"1\",\"department_id\":\"1\"},\"notifiable\":{\"id\":3,\"name\":\"Santiago\",\"email\":\"autorizador@gmail.com\",\"email_verified_at\":null,\"created_at\":\"2019-11-04 22:11:11\",\"updated_at\":\"2019-11-04 22:11:11\"}}',NULL,'2019-11-04 23:24:19','2019-11-04 23:24:19'),('9563ac29-8666-4a26-b012-f1c746a9edca','App\\Notifications\\NewQuotation','App\\User',1,'{\"link\":\"quotations-show\",\"text\":\"Ha creado una cotizaci\\u00f3n el usuario Santiago\",\"data\":{\"description\":\"fafsafa\",\"qty\":\"100\",\"archive\":\"wcwrH0AHP10iaEogHxko1EKTlVfqioT4QcSM9AGY.jpeg\",\"status\":\"PENDIENTE\",\"id\":2,\"iva\":0,\"total\":100,\"cycle_id\":1,\"item_id\":\"1\",\"department_id\":\"1\"},\"notifiable\":{\"id\":1,\"name\":\"Santiago\",\"email\":\"santi_shy@hotmail.com\",\"email_verified_at\":null,\"created_at\":\"2019-11-04 22:11:10\",\"updated_at\":\"2019-11-04 22:11:10\"}}','2019-11-04 23:24:33','2019-11-04 23:24:16','2019-11-04 23:24:33'),('abbed0c7-b9f5-4842-9478-05fbd1249255','App\\Notifications\\NewQuotation','App\\User',3,'{\"link\":\"quotations-show\",\"text\":\"Ha creado una cotizaci\\u00f3n el usuario Santiago\",\"data\":{\"description\":\"una prueba mas\",\"qty\":\"100.00\",\"archive\":\"c4apB4IE64uXHNuYPvi2rV4Q3aJFU2kBMXPlmCzK.png\",\"status\":\"PENDIENTE\",\"id\":1,\"iva\":0,\"total\":100,\"cycle_id\":1,\"item_id\":\"1\",\"department_id\":\"1\"},\"notifiable\":{\"id\":3,\"name\":\"Santiago\",\"email\":\"autorizador@gmail.com\",\"email_verified_at\":null,\"created_at\":\"2019-11-04 22:11:11\",\"updated_at\":\"2019-11-04 22:11:11\"}}','2019-11-04 22:15:36','2019-11-04 22:15:20','2019-11-04 22:15:36');
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quotations`
--

DROP TABLE IF EXISTS `quotations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `quotations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `qty` double(8,2) NOT NULL,
  `description` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `iva` enum('','1') COLLATE utf8mb4_unicode_ci NOT NULL,
  `cycle_id` bigint(20) NOT NULL,
  `archive` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `department_id` bigint(20) unsigned NOT NULL,
  `item_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `quotations_user_id_foreign` (`user_id`),
  CONSTRAINT `quotations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quotations`
--

LOCK TABLES `quotations` WRITE;
/*!40000 ALTER TABLE `quotations` DISABLE KEYS */;
INSERT INTO `quotations` VALUES (1,100.00,'una prueba mas','1',1,'quotations/c4apB4IE64uXHNuYPvi2rV4Q3aJFU2kBMXPlmCzK.png','RECHAZADA',2,1,1,'2019-11-04 22:15:12','2019-11-05 15:37:31'),(2,100.00,'fafsafa','1',1,'quotations/wcwrH0AHP10iaEogHxko1EKTlVfqioT4QcSM9AGY.jpeg','ACEPTADA',2,1,1,'2019-11-04 23:24:12','2019-11-05 15:39:59');
/*!40000 ALTER TABLE `quotations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_user`
--

DROP TABLE IF EXISTS `role_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_user`
--

LOCK TABLES `role_user` WRITE;
/*!40000 ALTER TABLE `role_user` DISABLE KEYS */;
INSERT INTO `role_user` VALUES (1,1,1,NULL,NULL),(2,2,2,NULL,NULL),(3,3,3,NULL,NULL);
/*!40000 ALTER TABLE `role_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'admin','Administrador del sitio','Administra todo el sitio','2019-11-04 22:11:10','2019-11-04 22:11:10'),(2,'cotizador','Crea cotizaciones','Crea cotizaciones para los autorizadores.','2019-11-04 22:11:10','2019-11-04 22:11:10'),(3,'autorizador','Autoriza las cotizaciones','Autoriza las cotizaciones, puede cambiar su status a rechazado o aceptado.','2019-11-04 22:11:11','2019-11-04 22:11:11');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `specifications`
--

DROP TABLE IF EXISTS `specifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `specifications` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `specificationable_id` bigint(20) unsigned NOT NULL,
  `specificationable_type` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cycle_id` bigint(20) NOT NULL,
  `qty` double(8,2) NOT NULL DEFAULT '0.00',
  `concept` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `specifications`
--

LOCK TABLES `specifications` WRITE;
/*!40000 ALTER TABLE `specifications` DISABLE KEYS */;
INSERT INTO `specifications` VALUES (1,1,'App\\Budget',1,495000.00,'Equipo de computo','2019-11-04 22:13:50','2019-11-04 22:14:05'),(2,1,'App\\Item',1,4900.00,'mouse','2019-11-04 22:14:05','2019-11-05 15:37:31');
/*!40000 ALTER TABLE `specifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Santiago','santi_shy@hotmail.com',NULL,'$2y$10$can4abE/2i2hu1VkovAhxOskGKkHRysKoA78cjFYIfsUH.W9ZtRxC',NULL,'2019-11-04 22:11:10','2019-11-04 22:11:10'),(2,'Santiago','santiagomartinochoaestrada@gmail.com',NULL,'$2y$10$AVQTHw2K82nGCvfM2vRJdOGOFttdx4cyiyVDuw6WlhkNaBh85uw8.',NULL,'2019-11-04 22:11:10','2019-11-04 22:11:10'),(3,'Santiago','autorizador@gmail.com',NULL,'$2y$10$0JRNiTtArVNncQwnrza7W.dLhOPh48Zmptyraz1tFEgZPAVjnQJu2',NULL,'2019-11-04 22:11:11','2019-11-04 22:11:11');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-11-05 23:51:08
