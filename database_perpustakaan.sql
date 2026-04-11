-- PERPUSTAKAAN DIGITAL EXPORT
-- Generated: 2026-03-22 19:01:29

CREATE DATABASE IF NOT EXISTS `perpustakaan_digital`;
USE `perpustakaan_digital`;

SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `books`;
CREATE TABLE `books` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `publisher` varchar(255) DEFAULT NULL,
  `isbn` varchar(255) DEFAULT NULL,
  `year` year(4) DEFAULT NULL,
  `category_id` bigint(20) unsigned NOT NULL,
  `shelf_location` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `cover` varchar(255) DEFAULT NULL,
  `pdf_file` varchar(255) DEFAULT NULL,
  `pages` int(11) DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 1,
  `total_stock` int(11) NOT NULL DEFAULT 1,
  `status` enum('available','unavailable') NOT NULL DEFAULT 'available',
  `views` int(11) NOT NULL DEFAULT 0,
  `rating` decimal(3,2) NOT NULL DEFAULT 0.00,
  `rating_count` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `books_slug_unique` (`slug`),
  UNIQUE KEY `books_isbn_unique` (`isbn`),
  KEY `books_category_id_foreign` (`category_id`),
  CONSTRAINT `books_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `books` (`id`, `title`, `slug`, `author`, `publisher`, `isbn`, `year`, `category_id`, `shelf_location`, `description`, `cover`, `pdf_file`, `pages`, `stock`, `total_stock`, `status`, `views`, `rating`, `rating_count`, `created_at`, `updated_at`) VALUES ('1', 'Clean Code', 'clean-code-fFWI0', 'Robert C. Martin', 'Prentice Hall', NULL, '2008', '1', NULL, 'Panduan menulis kode yang bersih dan terstruktur.', NULL, NULL, '464', '2', '3', 'available', '0', '0.00', '0', '2026-03-22 23:38:26', '2026-03-22 23:38:26');
INSERT INTO `books` (`id`, `title`, `slug`, `author`, `publisher`, `isbn`, `year`, `category_id`, `shelf_location`, `description`, `cover`, `pdf_file`, `pages`, `stock`, `total_stock`, `status`, `views`, `rating`, `rating_count`, `created_at`, `updated_at`) VALUES ('2', 'Laravel: Up & Running', 'laravel-up-running-kjtAl', 'Matt Stauffer', 'O\'Reilly', NULL, '2023', '1', NULL, 'Panduan lengkap framework Laravel.', NULL, NULL, '610', '2', '2', 'available', '0', '0.00', '0', '2026-03-22 23:38:26', '2026-03-22 23:38:26');
INSERT INTO `books` (`id`, `title`, `slug`, `author`, `publisher`, `isbn`, `year`, `category_id`, `shelf_location`, `description`, `cover`, `pdf_file`, `pages`, `stock`, `total_stock`, `status`, `views`, `rating`, `rating_count`, `created_at`, `updated_at`) VALUES ('3', 'A Brief History of Time', 'a-brief-history-of-time-SFZ1T', 'Stephen Hawking', 'Bantam Books', NULL, '1988', '2', NULL, 'Perjalanan ilmiah memahami alam semesta.', NULL, NULL, '212', '2', '2', 'available', '0', '0.00', '0', '2026-03-22 23:38:26', '2026-03-22 23:38:26');
INSERT INTO `books` (`id`, `title`, `slug`, `author`, `publisher`, `isbn`, `year`, `category_id`, `shelf_location`, `description`, `cover`, `pdf_file`, `pages`, `stock`, `total_stock`, `status`, `views`, `rating`, `rating_count`, `created_at`, `updated_at`) VALUES ('4', 'Sapiens', 'sapiens-vFiYc', 'Yuval Noah Harari', 'Harvill Secker', NULL, '2011', '3', NULL, 'Sejarah singkat umat manusia.', NULL, NULL, '443', '4', '4', 'available', '0', '0.00', '0', '2026-03-22 23:38:26', '2026-03-22 23:38:26');
INSERT INTO `books` (`id`, `title`, `slug`, `author`, `publisher`, `isbn`, `year`, `category_id`, `shelf_location`, `description`, `cover`, `pdf_file`, `pages`, `stock`, `total_stock`, `status`, `views`, `rating`, `rating_count`, `created_at`, `updated_at`) VALUES ('5', 'Laskar Pelangi', 'laskar-pelangi-v71i3', 'Andrea Hirata', 'Bentang', NULL, '2005', '4', NULL, 'Novel inspiratif tentang perjuangan anak-anak di Belitung.', NULL, NULL, '529', '5', '5', 'available', '0', '0.00', '0', '2026-03-22 23:38:26', '2026-03-22 23:38:26');
INSERT INTO `books` (`id`, `title`, `slug`, `author`, `publisher`, `isbn`, `year`, `category_id`, `shelf_location`, `description`, `cover`, `pdf_file`, `pages`, `stock`, `total_stock`, `status`, `views`, `rating`, `rating_count`, `created_at`, `updated_at`) VALUES ('6', 'Zero to One', 'zero-to-one-QMNYf', 'Peter Thiel', 'Crown Business', NULL, '2014', '6', NULL, 'Panduan membangun startup dari nol.', NULL, NULL, '224', '3', '3', 'available', '0', '0.00', '0', '2026-03-22 23:38:26', '2026-03-22 23:38:26');
INSERT INTO `books` (`id`, `title`, `slug`, `author`, `publisher`, `isbn`, `year`, `category_id`, `shelf_location`, `description`, `cover`, `pdf_file`, `pages`, `stock`, `total_stock`, `status`, `views`, `rating`, `rating_count`, `created_at`, `updated_at`) VALUES ('7', 'Atomic Habits', 'atomic-habits-NLpsv', 'James Clear', 'Avery', NULL, '2018', '5', NULL, 'Cara membangun kebiasaan kecil yang berdampak besar.', NULL, NULL, '320', '4', '4', 'available', '0', '0.00', '0', '2026-03-22 23:38:26', '2026-03-22 23:38:26');
INSERT INTO `books` (`id`, `title`, `slug`, `author`, `publisher`, `isbn`, `year`, `category_id`, `shelf_location`, `description`, `cover`, `pdf_file`, `pages`, `stock`, `total_stock`, `status`, `views`, `rating`, `rating_count`, `created_at`, `updated_at`) VALUES ('8', 'The Psychology of Money', 'the-psychology-of-money-1VH4z', 'Morgan Housel', 'Harriman House', NULL, '2020', '6', NULL, 'Cara berpikir tentang uang dan kekayaan.', NULL, NULL, '256', '3', '3', 'available', '0', '0.00', '0', '2026-03-22 23:38:26', '2026-03-22 23:38:26');

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `color` varchar(7) NOT NULL DEFAULT '#6366f1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `color`, `created_at`, `updated_at`) VALUES ('1', 'Teknologi', 'teknologi', 'Buku seputar teknologi dan IT', '#6366f1', '2026-03-22 23:38:26', '2026-03-22 23:38:26');
INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `color`, `created_at`, `updated_at`) VALUES ('2', 'Sains', 'sains', 'Buku ilmu pengetahuan alam', '#0ea5e9', '2026-03-22 23:38:26', '2026-03-22 23:38:26');
INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `color`, `created_at`, `updated_at`) VALUES ('3', 'Sejarah', 'sejarah', 'Buku sejarah dan budaya', '#f59e0b', '2026-03-22 23:38:26', '2026-03-22 23:38:26');
INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `color`, `created_at`, `updated_at`) VALUES ('4', 'Sastra', 'sastra', 'Novel dan karya sastra', '#ec4899', '2026-03-22 23:38:26', '2026-03-22 23:38:26');
INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `color`, `created_at`, `updated_at`) VALUES ('5', 'Pendidikan', 'pendidikan', 'Buku pelajaran dan pendidikan', '#10b981', '2026-03-22 23:38:26', '2026-03-22 23:38:26');
INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `color`, `created_at`, `updated_at`) VALUES ('6', 'Bisnis', 'bisnis', 'Manajemen dan kewirausahaan', '#8b5cf6', '2026-03-22 23:38:26', '2026-03-22 23:38:26');

DROP TABLE IF EXISTS `loans`;
CREATE TABLE `loans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `loan_code` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `book_id` bigint(20) unsigned NOT NULL,
  `loan_date` date NOT NULL,
  `due_date` date NOT NULL,
  `return_date` date DEFAULT NULL,
  `status` enum('borrowed','returned','overdue') NOT NULL DEFAULT 'borrowed',
  `notes` text DEFAULT NULL,
  `fine` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `loans_loan_code_unique` (`loan_code`),
  KEY `loans_user_id_foreign` (`user_id`),
  KEY `loans_book_id_foreign` (`book_id`),
  CONSTRAINT `loans_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  CONSTRAINT `loans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `loans` (`id`, `loan_code`, `user_id`, `book_id`, `loan_date`, `due_date`, `return_date`, `status`, `notes`, `fine`, `created_at`, `updated_at`) VALUES ('1', 'LN-XBESSWY9', '2', '1', '2026-03-17', '2026-03-31', NULL, 'borrowed', NULL, '0', '2026-03-22 23:38:26', '2026-03-22 23:38:26');
INSERT INTO `loans` (`id`, `loan_code`, `user_id`, `book_id`, `loan_date`, `due_date`, `return_date`, `status`, `notes`, `fine`, `created_at`, `updated_at`) VALUES ('2', 'LN-JATM5SXB', '3', '1', '2026-03-13', '2026-03-20', NULL, 'overdue', NULL, '0', '2026-03-23 00:33:24', '2026-03-23 00:54:30');

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('1', '2026_03_21_000000_create_users_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('2', '2026_03_21_000001_create_categories_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('3', '2026_03_21_000002_create_books_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('4', '2026_03_21_000003_create_loans_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('5', '2026_03_21_000004_create_reviews_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('6', '2026_03_21_000005_create_wishlists_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('7', '2026_03_21_173029_create_password_reset_tokens_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('8', '2026_03_21_185417_create_settings_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('9', '2026_03_21_201000_add_shelf_location_to_books_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('10', '2026_03_22_080739_add_gender_to_users_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('11', '2026_03_22_214925_add_petugas_and_kepala_roles_to_users_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('12', '2026_03_23_004516_rename_member_role_to_anggota', '2');

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `reviews`;
CREATE TABLE `reviews` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `book_id` bigint(20) unsigned NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `reviews_user_id_book_id_unique` (`user_id`,`book_id`),
  KEY `reviews_book_id_foreign` (`book_id`),
  CONSTRAINT `reviews_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES ('1', 'app_name', 'Perpustakaan Digital', '2026-03-23 00:51:07', '2026-03-23 00:51:07');
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES ('2', 'loan_limit', '3', '2026-03-23 00:51:07', '2026-03-23 00:51:07');
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES ('3', 'fine_per_day', '1000', '2026-03-23 00:51:07', '2026-03-23 00:51:07');
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES ('4', 'app_logo', 'logos/xCaUa2I0SWsRrYM423avjdKHf7MhWfcgZwPNS4kE.png', '2026-03-23 00:51:07', '2026-03-23 00:51:07');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `member_id` varchar(255) DEFAULT NULL,
  `role` enum('admin','anggota','petugas','kepala') NOT NULL DEFAULT 'anggota',
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `avatar` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_member_id_unique` (`member_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `address`, `gender`, `member_id`, `role`, `status`, `avatar`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('1', 'Kepala Perpustakaan', 'admin@perpustakaan.id', '08123456789', NULL, NULL, 'ADM-000001', 'admin', 'active', NULL, NULL, '$2y$12$uXBa7aoEOOoELIKbc9k.9OzWx9Q7dBD2iR/R7P/cGvV85TpsXwaP.', NULL, '2026-03-22 23:38:24', '2026-03-22 23:38:24');
INSERT INTO `users` (`id`, `name`, `email`, `phone`, `address`, `gender`, `member_id`, `role`, `status`, `avatar`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('2', 'Petugas Perpustakaan', 'petugas@perpustakaan.id', '08987654321', NULL, NULL, 'STF-000001', 'petugas', 'active', NULL, NULL, '$2y$12$Lcu18e2bF8HHIyBD3UIEV.vg2bNtR5NTGXOandStMTZTTQHKq2.AC', NULL, '2026-03-22 23:38:25', '2026-03-22 23:38:25');
INSERT INTO `users` (`id`, `name`, `email`, `phone`, `address`, `gender`, `member_id`, `role`, `status`, `avatar`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('3', 'Budi Santoso', 'budi@gmail.com', NULL, NULL, NULL, 'MBR-SPUYOC', 'anggota', 'active', NULL, NULL, '$2y$12$lqzgjy32j2/tPSO4w5P9OORI8IOhmYRw6nLqVo7Y1pohaZ9mampca', NULL, '2026-03-22 23:38:25', '2026-03-22 23:38:25');

DROP TABLE IF EXISTS `wishlists`;
CREATE TABLE `wishlists` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `book_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `wishlists_user_id_book_id_unique` (`user_id`,`book_id`),
  KEY `wishlists_book_id_foreign` (`book_id`),
  CONSTRAINT `wishlists_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  CONSTRAINT `wishlists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


SET FOREIGN_KEY_CHECKS=1;