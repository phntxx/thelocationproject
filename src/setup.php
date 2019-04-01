<?php
  $newDatabasePDO = new PDO('mysql:host=database', 'root', 'tiger');

  try {
    $newDatabasePDO -> exec ('
      CREATE DATABASE thelocationproject_data;
    ') or die (print_r($newDatabasePDO -> errorInfo(), true));
  } catch (PDOException $e) {
    die("DB ERROR: ". $e->getMessage());
  }

  $newTablePDO = new PDO('mysql:host=database;dbname=thelocationproject_data', 'root', 'tiger');

  try {
    $newTablePDO -> exec ('
      CREATE TABLE `users` (
      `id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
      `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
      `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
      `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
      `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`), UNIQUE (`email`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
    ') or die (print_r($newTablePDO -> errorInfo(), true));
  } catch (PDOException $e) {
    die("DB ERROR: ". $e->getMessage());
  }

  try {
    $newTablePDO -> exec ('
      CREATE TABLE `users` (
        `id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
        `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
        `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
        `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`), UNIQUE (`email`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
    ') or die (print_r($newTablePDO -> errorInfo(), true));
  } catch (PDOException $e) {
    die("DB ERROR: ". $e->getMessage());
  }

  try {
    $newTablePDO -> exec ('
      CREATE TABLE `newsfeed` (
        `id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
        `headline` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
        `text` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
        `author` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
    ') or die (print_r($newTablePDO -> errorInfo(), true));
  } catch (PDOException $e) {
    die("DB ERROR: ". $e->getMessage());
  }

  try {
    $newTablePDO -> exec ('
      CREATE TABLE `comments` (
        `id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
        `related_id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
        `text` varchar(140) COLLATE utf8_unicode_ci NOT NULL,
        `author` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
    ') or die (print_r($newTablePDO -> errorInfo(), true));
  } catch (PDOException $e) {
    die("DB ERROR: ". $e->getMessage());
  }

?>
