// PLIK DB

CREATE TABLE `secrets` (
  `uuid` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sekret` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `klucz` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data_wygasniecia` datetime DEFAULT NULL,
  `typ` varchar(4) NOT NULL DEFAULT 'once',
  PRIMARY KEY (`uuid`),
  UNIQUE KEY `uuid` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
