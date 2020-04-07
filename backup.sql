-- MySQL dump 10.13  Distrib 5.7.29, for Linux (x86_64)
--
-- Host: localhost    Database: company_site
-- ------------------------------------------------------
-- Server version	5.7.29

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
-- Table structure for table `lesson`
--

DROP TABLE IF EXISTS `lesson`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lesson` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `homework` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attendance` tinyint(1) DEFAULT NULL,
  `mark` int(11) DEFAULT NULL,
  `mark_comment` longtext COLLATE utf8mb4_unicode_ci,
  `youtube_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_F87474F3B13E81D7` (`youtube_link`),
  KEY `IDX_F87474F3CB944F1A` (`student_id`),
  CONSTRAINT `FK_F87474F3CB944F1A` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lesson`
--

LOCK TABLES `lesson` WRITE;
/*!40000 ALTER TABLE `lesson` DISABLE KEYS */;
INSERT INTO `lesson` VALUES (1,7,'2020-04-06','5 строчек On TheWood...,\r\n Billi Badd -разобрать и играть под минус.\r\nБуквы -E.F - 4 СПОСОБА\r\nА DUR. -ля мажор\r\nfis- фа диез минор',0,7,'Над гаммами не работал.\r\nПьеса- небрежное отношение к ритму,хотя текст разобран.Соблюдать метр нужно\r\n,ты на ударных занимеэшься. Буквы нужно доводить до качества. это твоя техническая база. Под метроном.',NULL),(2,18,'2020-04-06','1.играть букву Е - руками (4 спос.) и ногой.\r\n2.Этюды Августини для барабанов 1-5.(под метроном) \r\n3 . Кевин Так- Малый бар.- этюд 11 и 12 в среднем темпе без остановок.\r\n4соло с 3 том- томами (2.6) - 4строчки- отрабатывать в медл.темпе.',0,9,'следить больше за руками',NULL),(3,19,'2020-04-06','1. 5-ти ударный ролл с обеих рук ,медленно и свободно под метроном.\r\n2.Буквы -A,B,C,D. -4 способа.\r\n3.Гамма -Ре мажор(D dur) чет.,восьм. триоли,шест. - арпеджио. медленно повторять все мажорные гаммы.\r\n Всё время следить за руками.Замок и угол на контроль.\r\n4.разучить -Джингл белз.',0,9,'не могу связаться  сегодня с вами.',NULL),(4,10,'2020-04-06','1.Буква E.K- 4 способа \r\n2.Этюд 15 м.б. под метрон. \r\n3.Шуберт - разбирать до конца (медленно на)Ф-но.',0,10,'хочу посмотреть видео 15 этюда и Буквы E ,K. Максим- занимайся понемногу каждый день.а то руки потеряют еластичность. Играй этюды и буквы.',NULL),(5,13,'2020-04-06','1.играть буквы E.F.G.H. -4 способа.Особенно двойками-расслабить руки и кисти.\r\n2Играть этюды на м.б.\r\n3.выучить ноты второй октавы -крепко.\r\n4 делать теоретич. задания и отпр. своим педагогам.',0,9,'Жду видео на вайбер с телефона.\r\nБуквы двойками.этюд вышлю конкретно тебе. Распечатай и учи',NULL),(6,5,'2020-04-06','1.Вторая пьеса на бар. под минус(рок)\r\n2.Гаммы -Си бемоль мажор (Д7) и соль минор (ум.вв.) подвижно . \r\n3.Смотреть Джоджо Мэера -Нога. искать свободные ощущения.\r\n4.хора стакк.-слушать.внимательно знаки и ритм.',1,10,'Внимательно считать. Заниматься на тренаж. ,больше. -не мешать другим шумом. Пьесу рвзбирать внимательно .по такту.',NULL),(7,11,'2020-04-06','1/A dur-a moll. D7/Ум.ВВ.\r\n2.бар.- Баллада.\r\n3.Галоп- учить до конца. не спешить.плечи и кисти расслаблять.\r\n4.свинг - упр. ,бендовые взбивки.соло  4с.\r\n5.этюды м.б. читать с удовольствием. Рудименты -один в день.',1,12,'Даже не знаю что сказать. Барабаны - здорово.Галоп- работать под метроном .спокойно.руки запоминают и ищут удобные траэктории.','https://www.youtube.com/embed/QSk6WusUUrI?'),(8,7,'2020-04-06','Гаммы ля мажор и фа диез минор остаются. септаккорды учить\r\n.Буквы G,H.\r\nЭтюд 17\r\nПьеса -6и7 строчки.\r\nбарабаны -видео Billi Badd/',NULL,NULL,NULL,NULL),(9,18,'2020-04-06','Этюды на бар.Августини 13 и14. \r\nБуква F 4спос.\r\nучить ноты .\r\nэтюд на м.б. - 11. с шестнадцатой паузой.',NULL,NULL,NULL,NULL),(10,19,'2020-04-06','5 ролли рафф.\r\n буква E.\r\nG мажор по схеме.\r\nэтюд  кевин так 16 и17.\r\nДжингл белз -учить .Учить ноты и их буквенные обозначения',NULL,NULL,NULL,NULL),(11,13,'2020-04-06','1)Этюд 17 на м.б.   2)буква H 4способа -5 минут способ.\r\n3)  ШЕСТИУДАРНЫЙ РОЛЛ.',NULL,NULL,NULL,NULL),(12,5,'2020-04-09','C dur .a moll D7..зм.ув. \r\nЭтюд 17 .\r\nСвинг -IVA\r\nХора стаккато 4строчки',NULL,NULL,NULL,NULL),(13,11,'2020-04-10','A dur. a moll.с септаккордами.2).   Галоп -играть медленно с динамикой под метроном.  Учиться чувствовать метр.3) свинг -соло с хетом. Играть таттовые упражнения с триольного раздела.4)этюд любой.',NULL,NULL,NULL,NULL),(14,20,'2020-04-07','Играть четверти,по 4 удара,учить ноты первой октавы- называть их и пробовать писать в тетради.\r\nРуки держать перед собой. Этюды скину на почту.',NULL,NULL,NULL,NULL),(15,12,'2020-04-07','Играть четверти. По 4 удара. Следить за руками всё время .по 5 минут каждое упр.\r\nУчить ноты первой октавы. писать в нотной тетради и называть вслух. Этюды вышлю на почту.',NULL,NULL,NULL,NULL),(16,6,'2020-04-07','Чепин -триольный раздел(однотактовые упр.) Гаммы одна мажорная одна минорная с д7 и ум.вв.Пьса на барабанах вторая .Ноты на почту вышлю.Буквы -EFGH',NULL,NULL,NULL,NULL),(17,17,'2020-04-07','Буквы EDFH - руками и ногой.по три минуты. Пьеса на установке Exit For Fridom.Ноты вышдб на почту.Этюд 5.',NULL,NULL,NULL,NULL),(18,9,'2020-04-07','Разучить на барабанах Exit for Fridom, Разобрать новую пьесу 8 тактов.Этюд на м.б. -любой,читать. Роллы 5-9 ударов. По 4 удара на педе -отрабатывать кистевой замах,свободный и с амплитудой. нотыEXIT FOR/// вышлю на почту.',NULL,NULL,NULL,NULL),(19,16,'2020-04-07','Играть букву -Е -4 спос.Этюд 7,11 - повторить, .на бараб. этюд - 6.7.8. Учить  ноты первой октавы и легко их читать.',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `lesson` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schedule_lesson`
--

DROP TABLE IF EXISTS `schedule_lesson`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schedule_lesson` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) DEFAULT NULL,
  `day_of_the_week` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time` time NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9A5530ECCB944F1A` (`student_id`),
  CONSTRAINT `FK_9A5530ECCB944F1A` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schedule_lesson`
--

LOCK TABLES `schedule_lesson` WRITE;
/*!40000 ALTER TABLE `schedule_lesson` DISABLE KEYS */;
INSERT INTO `schedule_lesson` VALUES (7,4,'3','15:30:00'),(8,4,'5','17:10:00'),(9,5,'1','19:10:00'),(10,5,'4','18:00:00'),(11,6,'2','16:20:00'),(12,6,'5','16:20:00'),(13,7,'1','13:50:00'),(14,7,'4','16:20:00'),(15,8,'3','18:50:00'),(16,8,'6','12:05:00'),(17,9,'2','18:00:00'),(18,9,'4','17:10:00'),(19,10,'1','16:20:00'),(20,10,'5','14:40:00'),(21,11,'1','19:55:00'),(22,11,'5','18:50:00'),(23,12,'2','14:40:00'),(24,12,'5','13:50:00'),(25,13,'1','18:00:00'),(26,13,'3','16:20:00'),(27,14,'3','18:00:00'),(28,14,'6','09:50:00'),(29,15,'3','17:10:00'),(30,15,'6','10:35:00'),(31,16,'2','18:45:00'),(32,16,'4','18:50:00'),(33,17,'2','17:10:00'),(34,17,'5','15:30:00'),(35,18,'1','14:40:00'),(36,18,'4','14:40:00'),(37,19,'1','15:30:00'),(38,19,'4','15:30:00'),(39,20,'2','13:50:00'),(40,20,'4','13:40:00');
/*!40000 ALTER TABLE `schedule_lesson` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student`
--

LOCK TABLES `student` WRITE;
/*!40000 ALTER TABLE `student` DISABLE KEYS */;
INSERT INTO `student` VALUES (4,'Безкровный Дмитрий','katrusya7@ukr.net','0984195397','ceb7b9336e767a6293a1a234f6b87863.jpeg'),(5,'Галаган Кирилл','ir_sh_ka@ukr.net','0677971579','e8d4a886c361f93db72c6743a49e1034.jpeg'),(6,'Лисун Иван','irinalisun@ukr.net','0939452788','667ba907fd8a9d3416594f81f7fcae19.jpeg'),(7,'Переверов Павел','Vvpereverova@gmail.com','0671220387','5a120b40cc0a4fb22c3dfcc9684c7986.jpeg'),(8,'Стеценко Лада','ladastecenko@gmail.com','0987975616','ffef2be27871858398b09ee39ea5115e.jpeg'),(9,'Могилев Павле','mogilevpavle23@ukr.net','0637041635','1cfb4c583b45862c62ae0459bcd5920a.jpeg'),(10,'Коротыш Максим','alenachrist@gmail.com','0934682423','c665b3b0832af70d85ea82da2f0854e8.jpeg'),(11,'Никитин Дмитрий','nikitinavi1758@gmail.com','0678409905','09a5a50021d171115e147ed31aad4061.jpeg'),(12,'Щельников Николай','kharchenko.s.w@gmail.com','0938627166','2c2e33c112f5f6f1fa7014de374e8923.jpeg'),(13,'Комаров Эльдар','ekomarov826@gmail.com','0634153520','8546703dbe3ea92f0b9fa49591ba0f3b.jpeg'),(14,'Кусюмов Матвей','nastoosia@gmail.com','0933399155','f372609a05b42fd668af17ff120b55f2.jpeg'),(15,'Кусюмов Назар','nazar.kusiumov@gmail.com','0636911250','a9d75b9880b23eb9b069368b51450a3f.jpeg'),(16,'Бакин Марк','bakina.lyudmila@gmail.com','0987405677','339ac8722f1b0e31a833832cf992961f.jpeg'),(17,'Мельник Алексей','alex.melnyk2006@gmail.com','0686521029','de08ad175725a83965722801f5945ad7.jpeg'),(18,'Коломиец Захарий','lyukltdd@gmail.com','0733407826','cd4c6e786f0430148e6108a57abc6d56.jpeg'),(19,'Рачек Алексей','olexijrachek@gmail.com','0939599530','0c13d107aba3c74075580774d532cf57.jpeg'),(20,'Лепский Тихон','Leps2009_82@ukr.net','0987512882','b2a535ca09e76e793e4a3765e117878c.jpeg');
/*!40000 ALTER TABLE `student` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) DEFAULT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`),
  UNIQUE KEY `UNIQ_8D93D649CB944F1A` (`student_id`),
  CONSTRAINT `FK_8D93D649CB944F1A` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (6,NULL,'admin@gmail.com','[\"ROLE_ADMIN\"]','$2y$13$seDlx8SUM4tUUmPqzmtG1eSWpwfKw2icGR.6ZWIRLzGyPsXUvc5uO'),(7,4,'katrusya7@ukr.net','[]','$2y$13$G8UlTJf6W8hLO.VV1UPtvuE8pFJ3YAkBeN0ihaKdPVm82YjsWyqmi'),(8,5,'ir_sh_ka@ukr.net','[]','$2y$13$brG23Mo8eeWiveJkit3AeeThEOIYDwjC3M8cgYKNvR82PediTOFhG'),(9,6,'irinalisun@ukr.net','[]','$2y$13$7p0KExgP1DI/5iUkUWiWSeb26y4GtU/uQ6SHmyo2OIRbrE5gBY9Fa'),(10,7,'Vvpereverova@gmail.com','[]','$2y$13$KHvkHQCqjfd5L0rIyyZhf.hOvTNUxK8HNzYn8zmCsMw3kcTXkIsbS'),(11,8,'ladastecenko@gmail.com','[]','$2y$13$s1yLYEL679nILhTPBViBnOUvx336dawwfvdSsjjZaH4KgvLWmHMrS'),(12,9,'olusk@i.ua','[]','$2y$13$ZroJX448AooJr4LJfVtz/.8XwraNHoMQHFWTEiOg4M3OHm3l0tx.u'),(13,10,'alenachrist@gmail.com','[]','$2y$13$oGAKA0uMIExMuErzzaArLuKfspHxGo8SLhWwdsWusOgnmGxb0rC8O'),(14,11,'nikitinavi1758@gmail.com','[]','$2y$13$ie2wku1Qj0NswIakX.uuC.WODmlx7TbtwRwHMkirM1QlMNj03rRwm'),(15,12,'kharchenko.s.w@gmail.com','[]','$2y$13$svunf37K3QhYNHdkZt6f7OwOeVLJs5eBcEVVJwBdU1GyZQ2FRHEHm'),(16,13,'ekomarov826@gmail.com','[]','$2y$13$REprSAC42Sbdx2YbAYVRZOvWyMrKnG0ZNGg8DXSv/8aVLfbVraLdu'),(17,14,'nastoosia@gmail.com','[]','$2y$13$.NsMOf30Ihh0bwga9h4KH.wK4UKjwvErpjJxEHpPqeflQppqOpXae'),(18,15,'nazar.kusiumov@gmail.com','[]','$2y$13$DyTOz8kSFx7Tq3.pw7FXYOSzHE/G5/PGpXUGOKxi07h7MunLW3iC6'),(19,16,'bakina.lyudmila@gmail.com','[]','$2y$13$HPF/hufVCegRUGFr6742Gecc7E3GjTmtU5NkyaHi2RPNvALNFaTsy'),(20,17,'alex.melnyk2006@gmail.com','[]','$2y$13$MQVUDjkaKvzOHo2pi5mXTOu3WVLq9XuM7Ew/IdvHhHI5LzSEDt.sa'),(21,18,'lyukltdd@gmail.com','[]','$2y$13$vligzZGCwCoBOMXbTZ94RuE3UdhZn/aaIEInQbbbquhWviElFY34K'),(22,19,'0939599530@gmail.com','[]','$2y$13$9Fvi62lG7RfoW0PvDgeQjuwyd05d670KjYtK1e2r7.kbHL2unn766'),(23,20,'0987512882@gmail.com','[]','$2y$13$lHGPXRo4BQwGO1iK7/JIhe7GoIOQbRvpKLENXVKsMIE/yDqUl43.6');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-04-07 11:49:58
