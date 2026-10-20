CREATE TABLE `universities` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `slug` varchar(160) UNIQUE NOT NULL COMMENT 'dipakai di URL: /universitas/{slug}',
  `logo_path` varchar(255),
  `description` text,
  `primary_color` char(7) NOT NULL DEFAULT '#8E1EA2' COMMENT 'hex, jadi --university-primary',
  `secondary_color` char(7) NOT NULL DEFAULT '#C654C3' COMMENT 'hex, jadi --university-secondary',
  `city` varchar(100),
  `address` varchar(255),
  `website` varchar(255),
  `email` varchar(150),
  `phone` varchar(30),
  `status` ENUM ('active', 'inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp,
  `updated_at` timestamp,
  `deleted_at` timestamp COMMENT 'soft delete'
);

CREATE TABLE `users` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `university_id` bigint COMMENT 'NULL untuk super_admin & member; WAJIB terisi untuk university_admin (validasi di aplikasi)',
  `name` varchar(150) NOT NULL,
  `email` varchar(150) UNIQUE NOT NULL,
  `email_verified_at` timestamp,
  `password` varchar(255) NOT NULL COMMENT 'hash Laravel',
  `role` ENUM ('super_admin', 'university_admin', 'member') NOT NULL DEFAULT 'member',
  `status` ENUM ('active', 'suspended') NOT NULL DEFAULT 'active',
  `avatar_path` varchar(255),
  `remember_token` varchar(100),
  `created_at` timestamp,
  `updated_at` timestamp,
  `deleted_at` timestamp COMMENT 'soft delete'
);

CREATE TABLE `categories` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `slug` varchar(120) UNIQUE NOT NULL,
  `description` varchar(255),
  `icon` varchar(50) COMMENT 'nama icon Lucide',
  `is_active` boolean NOT NULL DEFAULT true,
  `created_at` timestamp,
  `updated_at` timestamp
);

CREATE TABLE `posts` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `university_id` bigint NOT NULL COMMENT 'scope utama: semua query admin difilter kolom ini',
  `category_id` bigint NOT NULL,
  `author_id` bigint NOT NULL COMMENT 'user yang membuat (university_admin / super_admin)',
  `reviewed_by` bigint COMMENT 'super_admin yang mereview terakhir',
  `title` varchar(255) NOT NULL,
  `slug` varchar(280) NOT NULL,
  `excerpt` varchar(500),
  `body` longtext NOT NULL,
  `cover_image_path` varchar(255),
  `event_start` datetime COMMENT 'opsional, untuk event/lomba/seminar',
  `event_end` datetime,
  `location` varchar(200),
  `status` ENUM ('draft', 'pending', 'approved', 'rejected', 'published', 'archived') NOT NULL DEFAULT 'draft',
  `submitted_at` timestamp,
  `reviewed_at` timestamp,
  `published_at` timestamp,
  `view_count` int NOT NULL DEFAULT 0,
  `created_at` timestamp,
  `updated_at` timestamp,
  `deleted_at` timestamp COMMENT 'soft delete'
);

CREATE TABLE `post_reviews` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `post_id` bigint NOT NULL,
  `actor_id` bigint NOT NULL COMMENT 'user yang melakukan aksi',
  `action` ENUM ('submitted', 'approved', 'rejected', 'published', 'archived') NOT NULL,
  `note` text COMMENT 'alasan penolakan / catatan revisi',
  `created_at` timestamp
);

CREATE TABLE `bookmarks` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `user_id` bigint NOT NULL,
  `post_id` bigint NOT NULL,
  `created_at` timestamp
);

CREATE TABLE `activity_logs` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `user_id` bigint,
  `university_id` bigint,
  `action` varchar(100) NOT NULL COMMENT 'contoh: post.created, university.updated',
  `subject_type` varchar(100),
  `subject_id` bigint,
  `properties` json COMMENT 'data sebelum/sesudah perubahan',
  `ip_address` varchar(45),
  `user_agent` varchar(255),
  `created_at` timestamp
);

CREATE INDEX `universities_index_0` ON `universities` (`status`);

CREATE INDEX `universities_index_1` ON `universities` (`city`);

CREATE INDEX `users_index_2` ON `users` (`role`, `status`);

CREATE INDEX `users_index_3` ON `users` (`university_id`);

CREATE UNIQUE INDEX `posts_index_4` ON `posts` (`university_id`, `slug`);

CREATE INDEX `posts_index_5` ON `posts` (`university_id`, `status`);

CREATE INDEX `posts_index_6` ON `posts` (`status`, `published_at`);

CREATE INDEX `posts_index_7` ON `posts` (`category_id`);

CREATE INDEX `posts_index_8` ON `posts` (`author_id`);

CREATE INDEX `post_reviews_index_9` ON `post_reviews` (`post_id`, `created_at`);

CREATE UNIQUE INDEX `bookmarks_index_10` ON `bookmarks` (`user_id`, `post_id`);

CREATE INDEX `activity_logs_index_11` ON `activity_logs` (`user_id`);

CREATE INDEX `activity_logs_index_12` ON `activity_logs` (`university_id`);

CREATE INDEX `activity_logs_index_13` ON `activity_logs` (`subject_type`, `subject_id`);

CREATE INDEX `activity_logs_index_14` ON `activity_logs` (`created_at`);

ALTER TABLE `posts` COMMENT = 'Hanya status = published yang tampil di public website';

ALTER TABLE `post_reviews` COMMENT = 'Riwayat approval; admin bisa melihat alasan konten ditolak';

ALTER TABLE `bookmarks` COMMENT = 'Opsional: fitur favorit anggota';

ALTER TABLE `users` ADD FOREIGN KEY (`university_id`) REFERENCES `universities` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `posts` ADD FOREIGN KEY (`university_id`) REFERENCES `universities` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

ALTER TABLE `posts` ADD FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

ALTER TABLE `posts` ADD FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

ALTER TABLE `posts` ADD FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `post_reviews` ADD FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `post_reviews` ADD FOREIGN KEY (`actor_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

ALTER TABLE `bookmarks` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `bookmarks` ADD FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `activity_logs` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `activity_logs` ADD FOREIGN KEY (`university_id`) REFERENCES `universities` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
