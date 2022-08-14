-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th8 13, 2022 lúc 05:01 PM
-- Phiên bản máy phục vụ: 10.4.22-MariaDB
-- Phiên bản PHP: 8.0.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `el_center2`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admin`
--

CREATE TABLE `admin` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'admin, manage',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Đang đổ dữ liệu cho bảng `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `password`, `role`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin', 'admin@gmail.com', '$2y$10$bRy0vzuk7jgbsRRcMTG69uQLfEvVAbSNv4QYPlxQJV0gWqVmFHUPG', 'admin', NULL, '2022-08-06 16:58:10', '2022-08-06 16:58:10', NULL),
(2, 'Manager', 'manager@gmail.com', '$2y$10$uii4exofTP80sxJYm6jwEOw4.GhiKMFZLVk6rlcRLpIzeDVi3qLr6', 'manage', NULL, '2022-08-06 16:58:10', '2022-08-06 16:58:10', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `blog_categories`
--

CREATE TABLE `blog_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Đang đổ dữ liệu cho bảng `blog_categories`
--

INSERT INTO `blog_categories` (`id`, `name`, `description`, `slug`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'ha noi hom nay nang qua', 'ha noi hom nay nang quaha noi hom nay nang quaha noi hom nay nang quaha noi hom nay nang quaha noi hom nay nang qua', 'ha-noi-hom-nay-nang-qua', '2022-07-20 14:53:54', '2022-07-27 16:11:55', NULL),
(3, 'https://www.youtube.com', 'https://www.youtube.com', 'httpswwwyoutubecom', '2022-07-25 16:37:53', '2022-08-12 14:19:53', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `blog_posts`
--

CREATE TABLE `blog_posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Đang đổ dữ liệu cho bảng `blog_posts`
--

INSERT INTO `blog_posts` (`id`, `title`, `thumbnail`, `slug`, `description`, `content`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Bài 1', 'backend/upload/post/1658845282_2.webp', 'bai-1', 'Bài viết số 1 này tôi nói về tình yêuBài viết số 1 này tôi nói về tình yêu', 'Nội dung bài viết', '2022-07-26 13:56:44', '2022-08-12 03:16:02', '2022-08-12 03:16:02'),
(2, 'Bài viết số 3', 'backend/upload/post/1660276858_image_2022-08-12_110021316.png', 'bai-viet-so-3', 'Nhận xét của học viên', '<p><span style=\"color: rgb(20, 32, 47);\">\"</span><em style=\"color: rgb(20, 32, 47);\">Là một kỹ sư công nghệ thông tin, suốt ngày làm việc trong văn phòng với máy tính, ít được giao tiếp. Vì vậy, khả năng nói tiếng Anh của mình rất yếu. Nhưng qua lớp học giao tiếp này và cộng thêm vốn từ vựng tiếng Anh của ngành công nghệ thông tin khi đọc tài liệu mình thể tự tin giao tiếp với mọi người. Phương pháp học dễ hiểu và hiểu quả. Bạn cũng có thể “bắt chước” phương pháp học này để học các ngoại ngữ khác\".&nbsp;</em><span style=\"color: rgb(20, 32, 47);\">–Huỳnh Quang Long – kỹ sư Công nghệ thông tin.</span></p>', '2022-07-26 13:57:22', '2022-08-12 04:01:19', NULL),
(3, 'ttt1 3', 'backend/upload/post/1658845282_2.webp', 'ttt1-3', 'Noi dung bai viet so 3', '<p>eeeeee1</p>', '2022-07-26 14:16:58', '2022-08-12 03:01:03', '2022-08-12 03:01:03'),
(4, 'Bài viết số 2', 'backend/upload/post/1660273251_English-4093-1577240389.jpg', 'bai-viet-so-2', 'Tiếng anh cho người bận rộn', '<p class=\"ql-align-justify\"><strong>TỰ TIN GIAO TIẾP TIẾNG ANH</strong>&nbsp;<img src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/tf4/1/16/2728.png\" alt=\"✨\" height=\"16\" width=\"16\"></p><p class=\"ql-align-justify\"><img src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/t84/1/16/1f381.png\" alt=\"🎁\" height=\"16\" width=\"16\">&nbsp;Thiết kế riêng&nbsp;<strong>CHO NGƯỜI MẤT GỐC</strong></p><p class=\"ql-align-justify\"><img src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/t50/1/16/1f525.png\" alt=\"🔥\" height=\"16\" width=\"16\">&nbsp;Bạn muốn tự tin giao tiếp Tiếng Anh trôi chảy với người nước ngoài?</p><p class=\"ql-align-justify\"><img src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/t50/1/16/1f525.png\" alt=\"🔥\" height=\"16\" width=\"16\">&nbsp;Bạn muốn nâng cao trình độ Anh ngữ phục vụ học tập và nộp hồ sơ học bổng du học?</p><p class=\"ql-align-justify\"><img src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/t50/1/16/1f525.png\" alt=\"🔥\" height=\"16\" width=\"16\">&nbsp;Bạn muốn cải thiện kỹ năng sử dụng Tiếng Anh trong môi trường làm việc để tăng chức hay nâng mức lương?</p><p class=\"ql-align-justify\"><img src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/t50/1/16/1f525.png\" alt=\"🔥\" height=\"16\" width=\"16\">&nbsp;EL Center sẽ cung cấp cho bạn giải pháp học tiếng Anh toàn diện, đặc biệt cho những bạn mất gốc tiếng Anh.</p><p class=\"ql-align-justify\"><img src=\"https://static.xx.fbcdn.net/images/emoji.php/v9/t50/1/16/1f525.png\" alt=\"🔥\" height=\"16\" width=\"16\">&nbsp;Không chỉ đem đến những kiến thức từ cơ bản đến chuyên sâu, đội ngũ giáo viên bản ngữ của chúng tôi sẽ giúp bạn khôi phục sự tự tin trong giao tiếp tiếng Anh, giúp bạn nhanh chóng thành công.</p><p class=\"ql-align-justify\"><br></p><p><br></p>', '2022-07-26 14:27:55', '2022-08-12 03:38:02', NULL),
(5, 'Bài viết số 1', 'backend/upload/post/1660272323_toeic-500x333.png', 'bai-viet-so-1', 'Luyện thi toeic', '<p><span style=\"color: rgb(10, 10, 10);\"><img src=\"https://atpacademy.vn/wp-content/uploads/2021/01/1f6d1.png\" alt=\"🛑\" height=\"16\" width=\"16\"></span>&nbsp;TĂNG ĐIỂM VÈO VÈO VỚI LỚP TOEIC CẤP TỐC&nbsp;<span style=\"color: rgb(10, 10, 10);\"><img src=\"https://atpacademy.vn/wp-content/uploads/2021/01/203c.png\" alt=\"‼️\" height=\"16\" width=\"16\"></span></p><p>&gt;&gt;&gt; CAM KẾT ĐẦU RA – Học lại FREE nếu không đạt mục tiêu &lt;&lt;&lt;</p><p>Lớp học HOT nhất lại chuẩn bị khai giảng, lớp TOEIC Cấp tốc, TOEIC Special được mệnh danh là&nbsp;<span style=\"color: rgb(10, 10, 10);\"><img src=\"https://atpacademy.vn/wp-content/uploads/2021/01/2728.png\" alt=\"✨\" height=\"16\" width=\"16\"></span>&nbsp;Lớp học tăng điểm nhanh nhất thời đại&nbsp;<span style=\"color: rgb(10, 10, 10);\"><img src=\"https://atpacademy.vn/wp-content/uploads/2021/01/2728.png\" alt=\"✨\" height=\"16\" width=\"16\"></span></p><p>++ Tăng từ 80 – 100 điểm sau 03 tuần đầu tiên, 150-200 điểm cho tháng tiếp theo.</p><p><span style=\"color: rgb(10, 10, 10);\"><img src=\"https://atpacademy.vn/wp-content/uploads/2021/01/1f530.png\" alt=\"🔰\" height=\"16\" width=\"16\"></span>Với hệ thống đề thi được cập nhật mới hàng tuần – sát với đề thi thật tại IIG</p><p><span style=\"color: rgb(10, 10, 10);\"><img src=\"https://atpacademy.vn/wp-content/uploads/2021/01/1f530.png\" alt=\"🔰\" height=\"16\" width=\"16\"></span>Cùng các giảng viên dày dặn kinh nghiệm, nhiệt tình giảng dạy</p><p><span style=\"color: rgb(10, 10, 10);\"><img src=\"https://atpacademy.vn/wp-content/uploads/2021/01/1f530.png\" alt=\"🔰\" height=\"16\" width=\"16\"></span>Thời gian học LINH ĐỘNG: Sáng – chiều -tối</p><p><span style=\"color: rgb(10, 10, 10);\"><img src=\"https://atpacademy.vn/wp-content/uploads/2021/01/1f530.png\" alt=\"🔰\" height=\"16\" width=\"16\"></span>Được HỌC BÙ khi bận</p><p><span style=\"color: rgb(10, 10, 10);\"><img src=\"https://atpacademy.vn/wp-content/uploads/2021/01/1f530.png\" alt=\"🔰\" height=\"16\" width=\"16\"></span>&nbsp;Học phí lại còn hạt dẻ</p><p><br></p>', '2022-07-26 14:32:17', '2022-08-12 03:37:54', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `branches`
--

CREATE TABLE `branches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Đang đổ dữ liệu cho bảng `branches`
--

INSERT INTO `branches` (`id`, `name`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'Đà Nẵng - Quận Ngũ Hành Sơn', '54 Lê Văn Hiến', '2022-07-27 13:49:40', '2022-08-11 08:12:24', NULL),
(3, 'Đà Nẵng - Quận Thanh Khê', '423 Nguyễn Văn Linh', '2022-07-27 13:53:46', '2022-08-11 08:14:39', NULL),
(5, 'Đà Nẵng - Quận Hải Châu', '90 Đường 2/9', '2022-08-11 08:14:31', '2022-08-11 08:14:31', NULL),
(6, 'Đà Nẵng - Quận Sơn Trà', '23 Lê Đức Thọ', '2022-08-11 08:16:00', '2022-08-11 08:16:00', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE `cart` (
  `user_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Đang đổ dữ liệu cho bảng `cart`
--

INSERT INTO `cart` (`user_id`, `class_id`) VALUES
(13, 5);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `certificates`
--

CREATE TABLE `certificates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Đang đổ dữ liệu cho bảng `certificates`
--

INSERT INTO `certificates` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Chứng chỉ TOEIC', 'Chứng chỉ TOEIC', '2022-08-06 16:58:14', '2022-08-06 16:58:14'),
(2, 'Chứng chỉ TOEFL.', 'Chứng chỉ TOEFL.', '2022-08-06 16:58:14', '2022-08-06 16:58:14'),
(3, 'Chứng chỉ IELTS.', 'Chứng chỉ IELTS.', '2022-08-06 16:58:14', '2022-08-06 16:58:14'),
(4, 'Chứng chỉ FCE.', 'Chứng chỉ FCE.', '2022-08-06 16:58:14', '2022-08-06 16:58:14'),
(5, 'Chứng chỉ Cambridge ESOL.', 'Chứng chỉ Cambridge ESOL.', '2022-08-06 16:58:14', '2022-08-06 16:58:14'),
(6, 'Chứng chỉ SAT.', 'Chứng chỉ SAT.', '2022-08-06 16:58:14', '2022-08-06 16:58:14');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `classes`
--

CREATE TABLE `classes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Đang đổ dữ liệu cho bảng `classes`
--

INSERT INTO `classes` (`id`, `title`, `slug`, `thumbnail`, `note`, `qty`, `start_date`, `end_date`, `course_id`, `room_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'Lớp mầm', 'lop-mam', 'backend/upload/class/1659284558_1.jpg', 'Lớp mầm', 11, '2022-08-01', '2022-10-01', 1, 1, '2022-07-31 15:03:17', '2022-08-11 08:42:20', '2022-08-11 08:42:20'),
(3, 'Lớp lớn', 'lop-lon', 'backend/upload/class/1659284615_1.jpg', 'Lớp lớn', 22, '2022-08-02', '2022-10-02', 1, 2, '2022-07-31 15:03:42', '2022-08-11 08:42:24', '2022-08-11 08:42:24'),
(4, 'Lớp CB', 'lop-cb', 'backend/upload/class/1660207570_22-02-2022_11_22_12_top-5-cach-de-tre-hoc-tieng-anh-qua-hinh-anh-hieu-qua-nhat-1.jfif', 'Lớp cơ bản', 30, '2022-08-01', '2022-08-03', 5, 3, '2022-07-31 16:24:03', '2022-08-11 09:24:44', NULL),
(5, 'Lớp TC1', 'lop-tc1', 'backend/upload/class/1660207660_5a7bb2bf60f27.jpg', 'Lớp trung cấp', 30, '2022-01-03', '2022-03-07', 3, 1, '2022-07-31 16:24:27', '2022-08-11 09:24:57', NULL),
(6, 'Lớp B', 'lop-b', 'backend/upload/class/1660207820_English-4093-1577240389.jpg', 'Ghi chú Lớp A2-2', 30, '2022-05-01', '2022-07-06', 2, 2, '2022-07-31 16:24:49', '2022-08-11 09:05:04', NULL),
(7, 'Lớp CB1', 'lop-cb1', 'backend/upload/class/1660208727_English-4093-1577240389.jpg', 'Lớp cơ bản', 20, '2022-08-01', '2023-08-01', 5, 6, '2022-07-31 16:25:13', '2022-08-11 09:24:29', NULL),
(8, 'Lớp HS1', 'lop-hs1', 'backend/upload/class/1660208764_cac-phuong-phap-hoc-tieng-anh-noi-tieng.png', 'Ghi chú lớp 5', 25, '2022-08-01', '2023-08-01', 6, 7, '2022-07-31 16:25:37', '2022-08-11 09:06:04', NULL),
(9, 'Lớp HS2', 'lop-hs2', 'backend/upload/class/1660402872_1.jpg', 'Lớp học sinh', 25, '2022-04-02', '2022-08-05', 6, 8, '2022-07-31 16:26:09', '2022-08-13 15:01:12', NULL),
(10, 'Lớp GT', 'lop-gt', 'backend/upload/class/1660402836_5.jpg', 'Ghi chú lớp 7', 2, '2022-04-09', '2022-11-12', 7, 13, '2022-07-31 16:26:36', '2022-08-13 15:00:36', NULL),
(11, 'Lớp CC', 'lop-cc', 'backend/upload/class/1660402861_1.jpg', 'Lớp cao cấp', 20, '2022-05-04', '2022-08-08', 1, 8, '2022-07-31 16:26:57', '2022-08-13 15:01:01', NULL),
(12, 'Lớp TC', 'lop-tc', 'backend/upload/class/1660319722_1.jpg', 'Lớp trung cấp', 20, '2022-08-01', '2023-08-01', 3, 11, '2022-07-31 16:27:16', '2022-08-12 15:55:23', NULL),
(13, 'Lớp 10', 'lop-10', 'backend/upload/class/1660402810_2.jpg', 'Ghi chú Lớp 10', 10, '2022-07-09', '2022-10-11', 4, 12, '2022-07-31 16:27:38', '2022-08-13 15:00:10', NULL),
(14, 'Lớp GT2', 'lop-gt2', 'backend/upload/class/1660402795_3.jpg', 'Lớp giao tiếp 1-1', 2, '2022-08-08', '2022-08-10', 7, 10, '2022-07-31 16:27:59', '2022-08-13 14:59:55', NULL),
(15, 'Lớp B1', 'lop-b1', 'backend/upload/class/1660402718_1.jpg', 'Lớp giao tiếp cho người đi làm', 20, '2022-08-01', '2022-08-03', 4, 13, '2022-07-31 16:28:21', '2022-08-13 14:58:38', NULL),
(16, 'Lớp SV', 'lop-sv', 'backend/upload/class/1660271989__MG_8932(1).jpg', 'Lớp dành cho sinh viên', 24, '2022-12-06', '2023-03-07', 8, 7, '2022-08-12 02:39:49', '2022-08-12 02:39:49', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `class_schedules`
--

CREATE TABLE `class_schedules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `class_id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` bigint(20) UNSIGNED NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `time_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Đang đổ dữ liệu cho bảng `class_schedules`
--

INSERT INTO `class_schedules` (`id`, `class_id`, `teacher_id`, `room_id`, `time_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(7, 4, 2, 1, 1, '2022-08-11 09:19:07', '2022-08-11 09:19:07', NULL),
(8, 5, 3, 1, 2, '2022-08-11 09:19:26', '2022-08-11 09:19:26', NULL),
(9, 6, 4, 2, 4, '2022-08-11 09:20:03', '2022-08-11 09:20:03', NULL),
(10, 7, 5, 6, 3, '2022-08-11 09:20:23', '2022-08-11 09:20:23', NULL),
(11, 8, 6, 4, 2, '2022-08-11 09:20:47', '2022-08-11 09:20:47', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `class_schedule_details`
--

CREATE TABLE `class_schedule_details` (
  `schedule_id` bigint(20) UNSIGNED NOT NULL,
  `day_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Đang đổ dữ liệu cho bảng `class_schedule_details`
--

INSERT INTO `class_schedule_details` (`schedule_id`, `day_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(7, '2', '2022-08-11 09:19:07', '2022-08-11 09:19:07', NULL),
(7, '4', '2022-08-11 09:19:07', '2022-08-11 09:19:07', NULL),
(7, '6', '2022-08-11 09:19:07', '2022-08-11 09:19:07', NULL),
(8, '2', '2022-08-11 09:19:26', '2022-08-11 09:19:26', NULL),
(8, '4', '2022-08-11 09:19:26', '2022-08-11 09:19:26', NULL),
(8, '5', '2022-08-11 09:19:26', '2022-08-11 09:19:26', NULL),
(9, '3', '2022-08-11 09:20:03', '2022-08-11 09:20:03', NULL),
(9, '4', '2022-08-11 09:20:03', '2022-08-11 09:20:03', NULL),
(9, '6', '2022-08-11 09:20:03', '2022-08-11 09:20:03', NULL),
(10, '2', '2022-08-11 09:20:23', '2022-08-11 09:20:23', NULL),
(10, '3', '2022-08-11 09:20:23', '2022-08-11 09:20:23', NULL),
(10, '7', '2022-08-11 09:20:23', '2022-08-11 09:20:23', NULL),
(11, '6', '2022-08-11 09:20:47', '2022-08-11 09:20:47', NULL),
(11, '7', '2022-08-11 09:20:47', '2022-08-11 09:20:47', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fullName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Đang đổ dữ liệu cho bảng `contacts`
--

INSERT INTO `contacts` (`id`, `fullName`, `email`, `subject`, `message`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Nguyễn vắn sơn', 'xyz@gmail.com', 'chu de 1', 'noi dung 2x', 0, '2022-07-27 15:51:31', '2022-07-27 15:51:31'),
(3, 'Duy', 'duyykr@gmail.com', 'lỗi', 'testing', 0, '2022-08-10 08:31:12', '2022-08-10 08:31:12'),
(4, 'Duy', 'duyykr@gmail.com', 'Liên hệ tôi', 'Liên hệ tôi qua sđt này 092141248', 0, '2022-08-12 08:38:40', '2022-08-12 08:38:40');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `courses`
--

CREATE TABLE `courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number_of_hours` int(11) NOT NULL,
  `lectures` int(11) NOT NULL,
  `rate` double(8,2) NOT NULL DEFAULT 5.00,
  `start_date` date NOT NULL,
  `utilities` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `price` double NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `level_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Đang đổ dữ liệu cho bảng `courses`
--

INSERT INTO `courses` (`id`, `title`, `thumbnail`, `slug`, `description`, `content`, `number_of_hours`, `lectures`, `rate`, `start_date`, `utilities`, `price`, `status`, `user_id`, `level_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Khóa cao cấp', 'backend/upload/course/1660208310_English-4093-1577240389.jpg', 'khoa-cao-cap', 'Có khả năng giao tiếp tiếng Anh tốt, đọc hiểu tốt.', '<p><span style=\"color: rgb(51, 51, 51);\">Ở&nbsp;cấp độ này, bạn có thể vượt ra ngoài các kỹ năng ngôn ngữ hàng ngày để hiểu và giải thích các tình huống phức tạp hơn bằng tiếng Anh. Bạn có thể dẫn dắt một cuộc trò chuyện tương đối dài mà không cần chuẩn bị trước</span></p>', 20, 15, 5.00, '2022-02-05', NULL, 5000000, 0, 1, 4, '2022-07-31 16:19:09', '2022-08-11 08:59:44', NULL),
(2, 'Khóa giao tiếp cho người đi làm', 'backend/upload/course/1660206933_images.jfif', 'khoa-giao-tiep-cho-nguoi-di-lam', 'Khóa này dạy những kĩ năng giao tiếp với công việc', '<p>Dạy kĩ năng giao tiếp cấp tốc cho người đi làm</p>', 80, 12, 5.00, '2022-02-23', NULL, 1500000, 0, 1, 3, '2022-07-31 16:19:42', '2022-08-11 08:53:54', NULL),
(3, 'Khóa trung cấp', 'backend/upload/course/1660206697_hoc-tieng-anh-co-ban-o-da-nang.jpg', 'khoa-trung-cap', 'Có khả năng hiểu và giao tiếp tiếng anh ở mức độ khá', '<p><span style=\"color: rgb(51, 51, 51);\">Ở trình độ này, bạn đã hiểu rõ hơn về các quy tắc ngữ pháp và từ vựng, &nbsp;Bạn có thể nói hoặc viết về các chủ đề đang được nghiên cứu và trả lời các câu hỏi đơn giản về các chủ đề này.</span></p>', 15, 15, 5.00, '2022-01-20', NULL, 2500000, 0, 1, 3, '2022-07-31 16:20:12', '2022-08-11 08:59:56', NULL),
(4, 'Khóa học giao tiếp', 'backend/upload/course/1660206348_cach-chon-trung-tam-tieng-anh-ha-noi-tot-nhat-cho-ban.jpg', 'khoa-hoc-giao-tiep', 'Trình độ cơ bản. Khả năng giao tiếp tiếng Anh ở mức độ trung bình.', '<p>Lớp cơ bản dạy về khả năng giao tiếp </p>', 20, 10, 5.00, '2022-01-02', NULL, 1000000, 0, 1, 1, '2022-07-31 16:21:27', '2022-08-11 08:51:41', NULL),
(5, 'Khóa học cơ bản', 'backend/upload/course/1660402734_4.jpg', 'khoa-hoc-co-ban', 'Trình độ cơ bản. Khả năng giao tiếp tiếng Anh ở mức độ trung bình.', '<p>Lớp cơ bản dạy về khả năng giao tiếp tiếng anh </p>', 20, 10, 5.00, '2022-01-01', NULL, 10000000, 0, 1, 1, '2022-08-01 15:31:27', '2022-08-13 14:59:22', NULL),
(6, 'Khóa học cho học sinh', 'backend/upload/course/1660208270_5a7bb2bf60f27.jpg', 'khoa-hoc-cho-hoc-sinh', 'Khóa này dành cho học sinh', '<p>Trình độ cơ bản, phù hợp với mọi lứa tuổi, chương trình trên lớp.</p>', 20, 15, 5.00, '2022-03-11', NULL, 3000000, 0, 1, 2, '2022-08-11 08:40:41', '2022-08-11 08:59:28', NULL),
(7, 'Khóa học giao tiếp 1-1', 'backend/upload/course/1660208646_134734666_meo-ren-luyen-ky-nang-giao-tiep-1.jpg', 'khoa-hoc-giao-tiep-1-1', 'Đây là khóa dạy kĩ năng giao tiếp 1-1', '<p>Giúp nâng cao kĩ năng giao tiếp với người nước ngoài</p>', 12, 6, 5.00, '2022-06-09', NULL, 4000000, 0, 1, 2, '2022-08-11 09:04:06', '2022-08-11 09:04:16', NULL),
(8, 'Khóa học cho sinh viên', 'backend/upload/course/1660271827_hoc-tieng-anh-o-dau-thi-tot.jpg', 'khoa-hoc-cho-sinh-vien', 'Khóa dành cho các bạn sinh viên đại học', '<p>Giúp nâng cao trình độ, kĩ năng tiếng anh cho các bạn sinh viên.</p>', 80, 12, 5.00, '2022-09-09', NULL, 4500000, 0, 1, 3, '2022-08-12 02:37:07', '2022-08-12 02:37:07', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `degrees`
--

CREATE TABLE `degrees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Đang đổ dữ liệu cho bảng `degrees`
--

INSERT INTO `degrees` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Cử nhân', 'Cử nhân', '2022-08-06 16:58:14', '2022-08-06 16:58:14'),
(2, 'Thạc sĩ', 'Thạc sĩ', '2022-08-06 16:58:14', '2022-08-06 16:58:14'),
(3, 'Tiến sĩ', 'Tiến sĩ', '2022-08-06 16:58:14', '2022-08-06 16:58:14');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `levels`
--

CREATE TABLE `levels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Đang đổ dữ liệu cho bảng `levels`
--

INSERT INTO `levels` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Level 1', 'Level 1', '2022-07-26 16:58:02', '2022-07-26 16:58:02'),
(2, 'Level 2', 'Level 2', '2022-07-26 16:58:02', '2022-07-26 16:58:02'),
(3, 'Level 3', 'Level 3', '2022-07-26 16:58:02', '2022-07-26 16:58:02'),
(4, 'Level 4', 'Level 4', '2022-07-26 16:58:02', '2022-07-26 16:58:02');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(6, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(7, '2022_07_24_000001_create_admin_table', 1),
(8, '2022_07_24_000002_create_user_table', 1),
(10, '2022_07_24_000004_create_test_result_table', 1),
(13, '2022_07_25_000001_create_degrees_table', 2),
(14, '2022_07_25_000002_create_certificates_table', 2),
(16, '2022_07_10_000001_create_question_table', 3),
(19, '2022_07_25_225843_create_blog_categories_table', 4),
(21, '2022_07_26_233106_create_blog_posts_table', 5),
(26, '2022_07_26_083433_create_teacher_table', 6),
(27, '2022_07_26_093431_create_teacher_certificate_table', 6),
(29, '2022_07_27_000001_create_courses_table', 7),
(32, '2022_07_27_000002_create_branches_table', 8),
(33, '2022_07_27_000003_create_rooms_table', 8),
(35, '2022_07_27_000005_create_contacts_table', 9),
(37, '2022_07_28_000002_create_courses_table', 10),
(39, '2022_07_28_000001_create_levels_table', 11),
(44, '2022_07_29_000001_create_classes_table', 12),
(53, '2022_08_01_01_create_orders_table', 13),
(58, '2022_08_02_01_create_cart_table', 14),
(60, '2022_08_02_03_add_phone_user_table', 15),
(62, '2022_08_02_02_create_order_detail_table', 16),
(64, '2022_08_03_01_add_field_order_table', 17),
(69, '2022_08_06_01_create_class_schedules_table', 18),
(70, '2022_08_06_02_create_class_schedule_details_table', 18),
(72, '2022_08_13_01_add_otp_user_table', 19);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(4) NOT NULL,
  `total` decimal(15,2) NOT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fullName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(13) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `sale` int(11) NOT NULL DEFAULT 0,
  `total_final` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `status`, `total`, `note`, `fullName`, `phone`, `email`, `user_id`, `created_at`, `updated_at`, `deleted_at`, `sale`, `total_final`) VALUES
(4, 2, '2500000.00', 'Thanh toán hóa đơn phí dich vụ', 'sau', '0964047666', 'sau@gmail.com', 4, '2022-08-02 14:36:41', '2022-08-02 14:37:25', NULL, 0, '2500000.00'),
(6, 2, '3000000.00', 'Thanh toán hóa đơn phí dich vụ', 'hai', '0964047663', 'hai@gmail.com', 3, '2022-08-03 12:22:19', '2022-08-03 12:22:39', NULL, 0, '2700000.00'),
(9, 3, '6000000.00', 'Thanh toán hóa đơn phí dich vụ', 'hai', '0964047663', 'hai@gmail.com', 3, '2022-08-04 15:42:08', '2022-08-04 15:42:08', NULL, 10, '5400000.00'),
(10, 2, '2500000.00', 'Thanh toán hóa đơn phí dich vụ', 'hai', '0964047663', 'hai@gmail.com', 3, '2022-08-05 14:26:20', '2022-08-05 14:26:41', NULL, 0, '2500000.00'),
(11, 2, '3000000.00', 'Thanh toán hóa đơn phí dich vụ', 'mai cao hoang duy', '0906260100', 'duyykr@gmail.com', 9, '2022-08-07 03:25:16', '2022-08-07 03:27:00', NULL, 0, '3000000.00'),
(12, 3, '4500000.00', 'Thanh toán hóa đơn phí dich vụ', 'mai cao hoang duy', '0906260100', 'duyykr@gmail.com', 9, '2022-08-12 07:27:35', '2022-08-12 07:27:35', NULL, 0, '4500000.00'),
(13, 3, '5000000.00', 'Thanh toán hóa đơn phí dich vụ', 'mai cao hoang duy', '0906260100', 'duyykr@gmail.com', 9, '2022-08-12 07:57:24', '2022-08-12 07:57:24', NULL, 10, '4500000.00'),
(14, 2, '4500000.00', 'Thanh toán hóa đơn phí dich vụ', 'Trương đình nhật', '0921453246', 'nhat@gmail.com', 14, '2022-08-12 08:30:03', '2022-08-12 08:33:19', NULL, 0, '4500000.00'),
(15, 3, '4500000.00', 'Thanh toán hóa đơn phí dich vụ', 'mai cao hoang duy', '0909482342', 'talacanhsat0@gmail.com', 17, '2022-08-12 14:14:54', '2022-08-12 14:14:54', NULL, 0, '4500000.00'),
(16, 3, '4500000.00', 'Thanh toán hóa đơn phí dich vụ', 'mai cao hoang duy', '0909482342', 'talacanhsat0@gmail.com', 17, '2022-08-12 14:15:38', '2022-08-12 14:15:38', NULL, 0, '4500000.00'),
(17, 3, '4500000.00', 'Thanh toán hóa đơn phí dich vụ', 'mai cao hoang duy', '0909482342', 'talacanhsat0@gmail.com', 17, '2022-08-12 14:16:32', '2022-08-12 14:16:32', NULL, 0, '4500000.00'),
(18, 3, '4500000.00', 'Thanh toán hóa đơn phí dich vụ', 'mai cao hoang duy', '0909482342', 'talacanhsat0@gmail.com', 17, '2022-08-12 14:17:47', '2022-08-12 14:17:47', NULL, 0, '4500000.00'),
(19, 3, '4000000.00', 'Thanh toán hóa đơn phí dich vụ', 'mai cao hoang duy', '0909482342', 'talacanhsat0@gmail.com', 17, '2022-08-12 14:25:07', '2022-08-12 14:25:07', NULL, 0, '4000000.00'),
(20, 3, '4000000.00', 'Thanh toán hóa đơn phí dich vụ', 'Sơn Nguyễn', '0964047002', 'ba@gmail.com', 19, '2022-08-13 13:11:07', '2022-08-13 13:11:07', NULL, 0, '4000000.00'),
(21, 3, '4500000.00', 'Thanh toán hóa đơn phí dich vụ', 'Sơn Nguyễn', '0964047002', 'ba@gmail.com', 19, '2022-08-13 14:53:48', '2022-08-13 14:53:48', NULL, 0, '4500000.00'),
(22, 3, '4500000.00', 'Thanh toán hóa đơn phí dich vụ', 'Sơn Nguyễn', '0964047002', 'ba@gmail.com', 19, '2022-08-13 14:55:59', '2022-08-13 14:55:59', NULL, 0, '4500000.00'),
(23, 2, '4000000.00', 'Thanh toán hóa đơn phí dich vụ', 'Sơn Nguyễn', '0964047002', 'ba@gmail.com', 19, '2022-08-13 14:56:47', '2022-08-13 14:57:14', NULL, 0, '4000000.00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_detail`
--

CREATE TABLE `order_detail` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(4) NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `class_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Đang đổ dữ liệu cho bảng `order_detail`
--

INSERT INTO `order_detail` (`id`, `status`, `order_id`, `class_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 4, 3, '2022-08-02 14:36:41', '2022-08-02 14:36:41', NULL),
(2, 2, 4, 4, '2022-08-02 14:36:41', '2022-08-02 14:36:41', NULL),
(3, 2, 5, 14, '2022-08-03 12:03:16', '2022-08-03 12:03:37', NULL),
(4, 2, 6, 4, '2022-08-03 12:22:19', '2022-08-03 12:22:39', NULL),
(5, 2, 6, 5, '2022-08-03 12:22:19', '2022-08-03 12:22:39', NULL),
(6, 3, 7, 13, '2022-08-03 12:24:12', '2022-08-03 12:24:12', NULL),
(7, 2, 8, 4, '2022-08-03 12:25:57', '2022-08-03 12:26:41', NULL),
(8, 2, 8, 3, '2022-08-03 12:25:57', '2022-08-03 12:26:41', NULL),
(9, 3, 9, 13, '2022-08-04 15:42:08', '2022-08-04 15:42:08', NULL),
(10, 3, 9, 14, '2022-08-04 15:42:08', '2022-08-04 15:42:08', NULL),
(11, 2, 10, 9, '2022-08-05 14:26:20', '2022-08-05 14:26:41', NULL),
(12, 2, 11, 13, '2022-08-07 03:25:16', '2022-08-07 03:27:00', NULL),
(13, 3, 12, 16, '2022-08-12 07:27:35', '2022-08-12 07:27:35', NULL),
(14, 3, 13, 10, '2022-08-12 07:57:24', '2022-08-12 07:57:24', NULL),
(15, 3, 13, 13, '2022-08-12 07:57:24', '2022-08-12 07:57:24', NULL),
(16, 2, 14, 16, '2022-08-12 08:30:03', '2022-08-12 08:33:19', NULL),
(17, 3, 15, 16, '2022-08-12 14:14:54', '2022-08-12 14:14:54', NULL),
(18, 3, 16, 16, '2022-08-12 14:15:38', '2022-08-12 14:15:38', NULL),
(19, 3, 17, 16, '2022-08-12 14:16:32', '2022-08-12 14:16:32', NULL),
(20, 3, 18, 16, '2022-08-12 14:17:47', '2022-08-12 14:17:47', NULL),
(21, 3, 19, 10, '2022-08-12 14:25:07', '2022-08-12 14:25:07', NULL),
(22, 3, 20, 10, '2022-08-13 13:11:07', '2022-08-13 13:11:07', NULL),
(23, 3, 21, 16, '2022-08-13 14:53:48', '2022-08-13 14:53:48', NULL),
(24, 3, 22, 16, '2022-08-13 14:55:59', '2022-08-13 14:55:59', NULL),
(25, 2, 23, 10, '2022-08-13 14:56:47', '2022-08-13 14:57:14', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_histories`
--

CREATE TABLE `order_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `total` double NOT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fullName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `creator_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `question`
--

CREATE TABLE `question` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `da_a` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `da_b` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `da_c` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `da_d` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `da` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Đang đổ dữ liệu cho bảng `question`
--

INSERT INTO `question` (`id`, `question`, `da_a`, `da_b`, `da_c`, `da_d`, `da`, `created_at`, `updated_at`, `deleted_at`) VALUES
(999, 'What does the man imply when he says, “I’ll look at it myself”?', 'He likes to work alone.', 'He had the same problem.', 'He knows enough to help the woman.', 'He is not in his office right now.', 'a', '2022-08-11 07:19:33', '2022-08-11 07:19:33', NULL),
(1000, 'What seems to be the problem?', 'The new version hasn’t come out yet', 'The woman is not good at calculation.', 'Some numbers don’t add up correctly.', 'An accountant gave the wrong data.', 'b', '2022-08-11 07:20:10', '2022-08-11 07:20:10', NULL),
(1001, 'What are the speakers discussing?', 'A budget report', 'A financial spreadsheet', 'A computer technician', 'A business loan', 'd', '2022-08-11 07:20:42', '2022-08-11 07:20:42', NULL),
(1002, 'According to the woman, what will take place in Hamburg?', 'A bicycle competition', 'A film festival', 'A professional conference', 'A museum opening', 'c', '2022-08-11 07:21:23', '2022-08-11 07:21:23', NULL),
(1003, 'Why is the man going to Hamburg?', '(A) To meet with some clients', '(B) To purchase some real estate', '(C) To attend a family celebration', '(D) To be trained for a competition', 'a', '2022-08-11 07:22:00', '2022-08-11 07:22:00', NULL),
(1004, '999', 'Buy a monthly pass', 'Take a later train', 'Rent a bicycle', 'Pay less for the same ticket', 'b', '2022-08-11 07:22:39', '2022-08-11 07:22:39', NULL),
(1005, 'Who is Mr. Richardson?', 'A magazine editor', 'A geologist', 'An art donor', 'A public relations employee', 'c', '2022-08-11 07:23:15', '2022-08-11 07:23:15', NULL),
(1006, 'What is Mr. Richardson doing right now?', 'Showing the museum around to visitors', 'Filling out some paperwork', 'Giving a lecture to his students', 'Meeting with some local artists', 'a', '2022-08-11 07:23:42', '2022-08-11 07:23:42', NULL),
(1007, 'What is the woman asked to do?', 'Explore the museum on her own', 'Receive a visitor’s pass', 'Go to the exhibit room', 'Wait in his office', 'b', '2022-08-11 07:24:11', '2022-08-11 07:24:11', NULL),
(1008, 'According to the man, why does the woman have to see him?', 'To complete some documents', 'To submit a certification', 'To celebrate an anniversary', 'To start working', 'a', '2022-08-11 07:26:38', '2022-08-11 07:26:38', NULL),
(1009, 'What does the woman mean when she says, “It’s a relief to gg hear the news”?', 'She’s been sick for the last few days.', 'She had applied for this company before.', 'She is working for a newspaper company.', 'She was worried she might not get the job.', 'd', '2022-08-11 07:27:09', '2022-08-11 07:27:09', NULL),
(1010, 'Where most likely are the speakers?', 'At a bus stop', 'In an auto repair shop', 'In an office', 'On the road', 'b', '2022-08-11 07:27:46', '2022-08-11 07:27:46', NULL),
(1011, 'According to the woman, when does she expect to be back?', 'By 5 p.m.', 'By 6 p.m.', 'By 6:30 p.m.', 'By 8 p.m.', 'a', '2022-08-11 07:28:12', '2022-08-11 07:28:12', NULL),
(1012, 'What does the woman ask the man to do?', 'Order more parts', 'Drop her keys off', 'Close the shop later than usual', 'Notify any change', 'c', '2022-08-11 07:28:49', '2022-08-11 07:28:49', NULL),
(1013, 'Why did the woman invite the man?', 'To request a refund', 'To sign a business contract', 'To obtain more information', 'To rent some equipment', 'b', '2022-08-11 07:29:32', '2022-08-11 07:29:32', NULL),
(1014, 'What kind of company does the woman work for?', 'A shipping company', 'A heavy equipment company', 'A real estate agency', 'A law firm', 'd', '2022-08-11 07:34:45', '2022-08-11 07:34:45', NULL),
(1015, 'What is the woman most likely to do next?', 'Give a lecture', 'Prepare for shipment', 'Answer the questions', 'Sign a contract', 'b', '2022-08-11 07:35:21', '2022-08-11 07:35:21', NULL),
(1016, 'Some species of rare animals are in…………….of extinction', 'danger', 'dangerous', 'dangerously', 'endanger', 'b', '2022-08-11 07:38:36', '2022-08-11 07:38:36', NULL),
(1017, 'computer is one of the most important…………………of the 20th century', 'Inventings', 'inventories', 'inventions', 'inventor', 'c', '2022-08-11 07:39:20', '2022-08-11 07:39:20', NULL),
(1018, 'What does the man offer to do?', 'Send some samples through mail', 'Give some discounts on a new product', 'Process an urgent order', 'Give a product demonstration', 'a', '2022-08-11 07:42:10', '2022-08-11 07:42:10', NULL),
(1019, 'What is the man having difficulty doing?', 'Contacting the technical support', 'Getting permission from a supervisor', 'Winning a contract from a client', 'Accessing some information', 'b', '2022-08-11 07:44:25', '2022-08-11 07:44:25', NULL),
(1020, 'Who does the man say he has requested help from?', 'A software programmer', 'The technology department', 'An overseas manager', 'The accounting department', 'c', '2022-08-11 07:45:06', '2022-08-11 07:45:06', NULL),
(1021, 'What does the woman say she will do?', 'Revise some document', 'Prepare a sales presentation', 'Post a memo on the board', 'Send an e-mail', 'a', '2022-08-11 07:45:34', '2022-08-11 07:45:34', NULL),
(1022, 'What are the speakers mainly discussing?', 'Updating software', 'Lack of staff', 'Medical surgeries', 'Laboratory equipment', 'a', '2022-08-11 07:46:01', '2022-08-11 07:46:01', NULL),
(1023, 'What is the man surprised at?', 'A deadline has been extended.', 'More teachers were hired.', 'A purchase has been approved.', 'Tuition has been increased.', 'd', '2022-08-11 07:46:27', '2022-08-11 07:46:27', NULL),
(1024, 'What does the man mean when he says, “it would be much easier”?', 'Students these days are much smarter than before.', 'New equipment will be very helpful in teaching students.', 'Medical advances in the industry have been amazing.', 'Hospital staff has to be trained to provide better services.', 'b', '2022-08-11 07:46:55', '2022-08-11 07:46:55', NULL),
(1025, 'What is the store planning to do?', 'Introduce a new product', 'Manufacture new tiles', 'Survey customers', 'Lower the product prices', 'c', '2022-08-11 07:47:29', '2022-08-11 07:47:29', NULL),
(1026, 'What is the woman concerned about?', 'The packaging might be weak.', 'The environmentalist might complain.', 'A product will not sell well.', 'Customers will call the authority.', 'c', '2022-08-11 07:48:02', '2022-08-11 07:48:02', NULL),
(1027, 'What type of business most likely is Digital Solutions?', 'An online retailer', 'A software developer', 'A graphic design company', 'A recording studio', 'c', '2022-08-11 07:48:34', '2022-08-11 07:48:34', NULL),
(1028, 'Why has the firm’s stock value risen?', 'Its product has been very successful.', 'Its operations have moved overseas.', 'It was awarded a major contract.', 'It has teamed up with another business.', 'a', '2022-08-11 07:49:00', '2022-08-11 07:49:00', NULL),
(1029, 'What will probably happen in October?', 'Personnel will begin working.', 'A team will be assembled.', 'A department will be shut down.', 'Employees will create a database.', 'd', '2022-08-11 07:49:35', '2022-08-11 07:49:35', NULL),
(1030, 'The software-------------- that New-Tech offers remove security risks and improve the performance of computers.', 'increments', 'enhancements', 'certificates', 'exceptions', 'd', '2022-08-11 07:50:08', '2022-08-11 07:50:08', NULL),
(1031, 'Mr. Evans took a taxi to avoid being late, but the theater show had-------------- begun by the time he arrived.', 'usually', 'seldom', 'hourly', 'already', 'b', '2022-08-11 07:50:34', '2022-08-11 07:50:34', NULL),
(1032, 'Notices-------------- residents of possible power outages were mailed out a week before crews began work on the power lines.', 'inform', 'information', 'informed', 'informing', 'c', '2022-08-11 07:51:04', '2022-08-11 07:51:04', NULL),
(1033, 'Mr. Clemon’s work was so impressive that he was made a senior manager-------------- only six months with the company.', 'on', 'after', 'while', 'owing to', 'b', '2022-08-11 07:51:28', '2022-08-11 07:51:28', NULL),
(1034, 'In anticipation of an increase in visitors during the summer holiday, the Shoreline Inn decided to--------------hire additional housekeeping staff.', 'adversely', 'uncontrollably', 'temporarily', 'relatively', 'a', '2022-08-11 07:51:49', '2022-08-11 07:51:49', NULL),
(1035, 'Although a graduate degree is a requirement for the position, none of -------------- who responded to the job announcement have one. (A) they', 'they', 'these', 'themselves', 'those', 'c', '2022-08-11 07:52:14', '2022-08-11 07:52:14', NULL),
(1036, 'Travel writer Arthur Chaplin will give a short presentation tomorrow -------------- the trip described in his new book, Walking in Peru.', 'along', 'regarding', 'in exchange for', 'by means of', 'd', '2022-08-11 07:52:37', '2022-08-11 07:52:37', NULL),
(1037, 'Local water quality is-------------- to improve once the sewage treatment center is upgraded.', 'grown', 'limited', 'bound', 'acquired', 'c', '2022-08-11 07:53:04', '2022-08-11 07:53:04', NULL),
(1038, 'Charles Kapoor was not considered a suitable candidate for a financial analyst position-------------- he possessed exceptional investment experience.', 'accordingly', 'in spite of', 'as if', 'even though', 'b', '2022-08-11 07:53:32', '2022-08-11 07:53:32', NULL),
(1039, 'The tour bus did not stop at Sheffield Stadium, so its passengers could only take pictures as they drove-------------- it.', 'until', 'past', 'onto', 'within', 'a', '2022-08-11 07:53:59', '2022-08-11 07:53:59', NULL),
(1040, 'Mercer Incorporated carefully goes over -------------- its customer surveys and market research before making important decisions.', 'as well as', 'both', 'between', 'neither', 'c', '2022-08-11 07:54:25', '2022-08-11 07:54:25', NULL),
(1041, 'For the purpose of increasing sales, Mendelbaum Electronics is giving a prize to-------------- is the 100th person to buy a refrigerator.', 'whichever', 'another', 'whoever', 'someone', 'a', '2022-08-11 07:54:51', '2022-08-11 07:54:51', NULL),
(1042, 'McCarten Bank updated its website to increase the amount of information available to customers ________ in investment options.', 'interest', 'interests', 'interested', 'interesting', 'a', '2022-08-11 07:55:53', '2022-08-11 07:55:53', NULL),
(1043, 'Dr. Torreton’s research shows that his new treatment could lessen patient ________ on costly medicines.', 'reliance', 'relies', 'reliant', 'relied', 'd', '2022-08-11 07:56:19', '2022-08-11 07:56:19', NULL),
(1044, '________ the extraordinary success of the publication Town & Around, the company’s total revenue rose 7 percent last quarter.', 'According to', 'Similarly', 'Unless', 'Due to', 'b', '2022-08-11 07:56:52', '2022-08-11 07:56:52', NULL),
(1045, 'Walters Management Systems ________ new policies on its hiring process last month.', 'performed', 'implemented', 'achieved', 'convinced', 'b', '2022-08-11 07:57:15', '2022-08-11 07:57:15', NULL),
(1046, 'Unfortunately, Meyers’ X23 air conditioning unit failed to meet the government’s new energy-efficiency standards, and ________ did the company’s X24 model.', 'same', 'either', 'so', 'rather', 'c', '2022-08-11 07:57:40', '2022-08-11 07:57:40', NULL),
(1047, 'Meflin Information System is________ of your interest in our services to update your company’s computer network.', 'willing', 'appreciative', 'ulfilled', 'decisive', 'd', '2022-08-11 07:58:03', '2022-08-11 07:58:03', NULL),
(1048, 'Dr. Zischler has ________ about conducting the new research because of budget cuts in his department.', 'specializations', 'indications', 'reservations', 'reductions', 'b', '2022-08-11 07:58:32', '2022-08-11 07:58:32', NULL),
(1049, '________ reserve tickets for Sunday’s dance performance, you must call the Eidinger Theater box office before noon on Friday.', 'As to', 'Furthermore', 'In order to', 'As a result of', 'a', '2022-08-11 07:58:58', '2022-08-11 07:58:58', NULL),
(1050, 'Worsdale System’s ________ Web browser has been praised by users and reviewers worldwide.', 'frequent', 'estimated', 'innovative', 'reluctant', 'c', '2022-08-11 07:59:20', '2022-08-11 07:59:20', NULL),
(1051, '________ the conference on organizational effectiveness, the keynote speaker discussed the merits of mentoring programs for new employees.', 'Although', 'When', 'During', 'Afterward', 'c', '2022-08-11 07:59:46', '2022-08-11 07:59:46', NULL),
(1052, 'Before General Mills was named one of the best small businesses in the region, the company ________ expanding its operations nationwide.', 'does not consider', 'were not considered', 'will not consider', 'had not considered', 'a', '2022-08-11 08:00:08', '2022-08-11 08:00:08', NULL),
(1053, 'Mr. Pullman has asked for_________ time to turn in his report because he requires some additional information.', 'any', 'a few', 'more', 'many', 'c', '2022-08-11 08:01:16', '2022-08-11 08:01:16', NULL),
(1054, 'Mayor David Lee’s introduction of Senator Laura Moncton_________ her speech, giving an overview of her track record of political reforms.', 'required', 'preceded', 'performed', 'accomplished', 'd', '2022-08-11 08:01:40', '2022-08-11 08:01:40', NULL),
(1055, 'Album sales for rock band Trifecta have been low _________ their concert tickets have been selling out.', 'if only', 'as long as', 'even though', 'provided that', 'a', '2022-08-11 08:02:01', '2022-08-11 08:02:01', NULL),
(1056, 'Ms. Davies could only hear _________ of what was discussed since the restaurant chosen for the meeting was so noisy.', 'fragments', 'excerpts', 'summaries', 'shares', 'b', '2022-08-11 08:02:25', '2022-08-11 08:02:25', NULL),
(1057, 'There were_________ malfunctions with the agency’s updated software, so management decided to use the old version temporarily.', 'competent', 'cautious', 'persistent', 'imperative', 'c', '2022-08-11 08:02:48', '2022-08-11 08:02:48', NULL),
(1058, 'In an emergency, an alarm in Hamley Towers will sound, indicating that everyone inside must_________ the building immediately.', 'oppose', 'dismiss', 'vacate', 'assemble', 'b', '2022-08-11 08:03:10', '2022-08-11 08:03:10', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rooms`
--

CREATE TABLE `rooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Đang đổ dữ liệu cho bảng `rooms`
--

INSERT INTO `rooms` (`id`, `name`, `description`, `branch_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Phòng ĐN-101', 'Phòng 101', 2, '2022-07-27 14:03:58', '2022-08-11 08:43:50', NULL),
(2, 'Phòng ĐN-102', 'Phòng 102', 6, '2022-07-27 14:05:48', '2022-08-11 08:17:45', NULL),
(3, 'Phòng ĐN-201', 'Phòng 201', 3, '2022-07-31 16:14:42', '2022-08-11 08:17:33', NULL),
(4, 'Phòng ĐN-202', 'Phòng 202', 5, '2022-07-31 16:14:51', '2022-08-11 08:17:22', NULL),
(6, 'Phòng ĐN-204', 'Phòng 204', 6, '2022-07-31 16:15:05', '2022-08-11 08:16:59', NULL),
(7, 'Phòng ĐN-205', 'Phòng 205', 3, '2022-07-31 16:15:15', '2022-08-11 08:16:43', NULL),
(8, 'Phòng ĐN-301', 'Phòng 301', 5, '2022-07-31 16:16:32', '2022-08-11 08:16:29', NULL),
(9, 'Phòng ĐN-302', 'Phòng 302', 2, '2022-07-31 16:16:42', '2022-08-11 08:16:19', NULL),
(10, 'Phòng ĐN-303', 'Phòng 303', 6, '2022-07-31 16:16:50', '2022-08-11 08:16:11', NULL),
(11, 'Phòng ĐN-304', 'Phòng 304', 5, '2022-07-31 16:16:57', '2022-08-11 08:15:19', NULL),
(12, 'Phòng ĐN-401', 'Phòng 401', 3, '2022-07-31 16:17:06', '2022-08-11 08:15:10', NULL),
(13, 'Phòng ĐN-402', 'Phòng 402', 2, '2022-07-31 16:17:13', '2022-08-11 08:15:01', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `teacher`
--

CREATE TABLE `teacher` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '$2y$10$f47EoYwQsCnGQ7eX7Nqabexz1fxCbkoNmoalOhvV89FfzCTZOMahS',
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birthday` date NOT NULL,
  `degree_id` int(11) NOT NULL,
  `gender` tinyint(1) NOT NULL DEFAULT 2,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Đang đổ dữ liệu cho bảng `teacher`
--

INSERT INTO `teacher` (`id`, `name`, `email`, `password`, `phone`, `birthday`, `degree_id`, `gender`, `address`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'Nguyen Van E', 'teacher2@gmail.com', '$2y$10$f47EoYwQsCnGQ7eX7Nqabexz1fxCbkoNmoalOhvV89FfzCTZOMahS', '0964047698', '1995-05-12', 1, 1, NULL, '2022-07-26 16:21:20', '2022-08-12 02:40:43', NULL),
(3, 'Nguyen Van D', 'teacher3@gmail.com3', '$2y$10$f47EoYwQsCnGQ7eX7Nqabexz1fxCbkoNmoalOhvV89FfzCTZOMahS', '0964047693', '1995-07-03', 3, 2, NULL, '2022-07-26 16:22:10', '2022-08-12 02:15:02', NULL),
(4, 'Nguyen Van C', 'teacher4@gmail.com', '$2y$10$f47EoYwQsCnGQ7eX7Nqabexz1fxCbkoNmoalOhvV89FfzCTZOMahS', '0964047694', '1994-04-04', 2, 1, NULL, '2022-07-31 15:23:13', '2022-08-12 02:14:38', NULL),
(5, 'Nguyen Van B', 'teacher5@gmail.com', '$2y$10$f47EoYwQsCnGQ7eX7Nqabexz1fxCbkoNmoalOhvV89FfzCTZOMahS', '0964047695', '1995-05-05', 1, 1, NULL, '2022-07-31 15:24:19', '2022-08-12 02:14:21', NULL),
(6, 'Nguyen Van A', 'teacher6@gmail.com', '$2y$10$f47EoYwQsCnGQ7eX7Nqabexz1fxCbkoNmoalOhvV89FfzCTZOMahS', '0964047696', '1995-01-01', 3, 2, NULL, '2022-07-31 15:27:08', '2022-08-12 02:14:11', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `teacher_certificate`
--

CREATE TABLE `teacher_certificate` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `certificate_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Đang đổ dữ liệu cho bảng `teacher_certificate`
--

INSERT INTO `teacher_certificate` (`id`, `teacher_id`, `certificate_id`) VALUES
(38, 6, 2),
(39, 5, 2),
(41, 4, 6),
(42, 3, 2),
(43, 2, 4),
(44, 2, 5);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `test_result`
--

CREATE TABLE `test_result` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `question_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_da` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Đáp án của user',
  `question_da` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Đáp án đúng cho câu hỏi',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Đang đổ dữ liệu cho bảng `test_result`
--

INSERT INTO `test_result` (`id`, `user_id`, `question_id`, `user_da`, `question_da`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '4', '15', 'a', 'b', '2022-08-02 14:39:49', '2022-08-02 14:39:51', NULL),
(2, '4', '46', NULL, 'd', '2022-08-02 14:39:49', '2022-08-02 14:39:49', NULL),
(3, '4', '50', NULL, 'c', '2022-08-02 14:39:49', '2022-08-02 14:39:49', NULL),
(4, '4', '72', NULL, 'c', '2022-08-02 14:39:49', '2022-08-02 14:39:49', NULL),
(5, '4', '85', NULL, 'c', '2022-08-02 14:39:49', '2022-08-02 14:39:49', NULL),
(6, '4', '96', NULL, 'b', '2022-08-02 14:39:49', '2022-08-02 14:39:49', NULL),
(7, '4', '110', NULL, 'd', '2022-08-02 14:39:49', '2022-08-02 14:39:49', NULL),
(8, '4', '136', NULL, 'd', '2022-08-02 14:39:49', '2022-08-02 14:39:49', NULL),
(9, '4', '137', NULL, 'd', '2022-08-02 14:39:49', '2022-08-02 14:39:49', NULL),
(10, '4', '138', NULL, 'c', '2022-08-02 14:39:49', '2022-08-02 14:39:49', NULL),
(11, '4', '139', NULL, 'c', '2022-08-02 14:39:49', '2022-08-02 14:39:49', NULL),
(12, '4', '140', NULL, 'c', '2022-08-02 14:39:49', '2022-08-02 14:39:49', NULL),
(13, '4', '154', NULL, 'b', '2022-08-02 14:39:49', '2022-08-02 14:39:49', NULL),
(14, '4', '190', NULL, 'c', '2022-08-02 14:39:49', '2022-08-02 14:39:49', NULL),
(15, '4', '239', NULL, 'c', '2022-08-02 14:39:49', '2022-08-02 14:39:49', NULL),
(16, '4', '270', NULL, 'd', '2022-08-02 14:39:49', '2022-08-02 14:39:49', NULL),
(17, '4', '304', NULL, 'd', '2022-08-02 14:39:49', '2022-08-02 14:39:49', NULL),
(18, '4', '305', NULL, 'a', '2022-08-02 14:39:49', '2022-08-02 14:39:49', NULL),
(19, '4', '319', NULL, 'c', '2022-08-02 14:39:49', '2022-08-02 14:39:49', NULL),
(20, '4', '324', NULL, 'a', '2022-08-02 14:39:49', '2022-08-02 14:39:49', NULL),
(21, '4', '332', NULL, 'a', '2022-08-02 14:39:49', '2022-08-02 14:39:49', NULL),
(22, '4', '334', NULL, 'c', '2022-08-02 14:39:49', '2022-08-02 14:39:49', NULL),
(23, '4', '341', NULL, 'b', '2022-08-02 14:39:49', '2022-08-02 14:39:49', NULL),
(24, '4', '342', NULL, 'd', '2022-08-02 14:39:49', '2022-08-02 14:39:49', NULL),
(25, '4', '353', NULL, 'd', '2022-08-02 14:39:49', '2022-08-02 14:39:49', NULL),
(26, '4', '364', NULL, 'a', '2022-08-02 14:39:49', '2022-08-02 14:39:49', NULL),
(27, '4', '365', NULL, 'a', '2022-08-02 14:39:49', '2022-08-02 14:39:49', NULL),
(28, '4', '369', NULL, 'c', '2022-08-02 14:39:49', '2022-08-02 14:39:49', NULL),
(29, '4', '371', NULL, 'c', '2022-08-02 14:39:49', '2022-08-02 14:39:49', NULL),
(30, '4', '425', NULL, 'a', '2022-08-02 14:39:49', '2022-08-02 14:39:49', NULL),
(31, '4', '452', NULL, 'b', '2022-08-02 14:39:49', '2022-08-02 14:39:49', NULL),
(32, '4', '485', NULL, 'c', '2022-08-02 14:39:49', '2022-08-02 14:39:49', NULL),
(33, '4', '536', NULL, 'd', '2022-08-02 14:39:49', '2022-08-02 14:39:49', NULL),
(34, '4', '547', NULL, 'c', '2022-08-02 14:39:49', '2022-08-02 14:39:49', NULL),
(35, '4', '553', NULL, 'd', '2022-08-02 14:39:49', '2022-08-02 14:39:49', NULL),
(36, '4', '563', NULL, 'd', '2022-08-02 14:39:49', '2022-08-02 14:39:49', NULL),
(37, '4', '572', NULL, 'd', '2022-08-02 14:39:49', '2022-08-02 14:39:49', NULL),
(38, '4', '580', NULL, 'd', '2022-08-02 14:39:49', '2022-08-02 14:39:49', NULL),
(39, '4', '612', NULL, 'a', '2022-08-02 14:39:49', '2022-08-02 14:39:49', NULL),
(40, '4', '620', NULL, 'c', '2022-08-02 14:39:49', '2022-08-02 14:39:49', NULL),
(41, '4', '669', NULL, 'b', '2022-08-02 14:39:49', '2022-08-02 14:39:49', NULL),
(42, '4', '712', NULL, 'd', '2022-08-02 14:39:49', '2022-08-02 14:39:49', NULL),
(43, '4', '715', NULL, 'c', '2022-08-02 14:39:49', '2022-08-02 14:39:49', NULL),
(44, '4', '769', NULL, 'b', '2022-08-02 14:39:49', '2022-08-02 14:39:49', NULL),
(45, '4', '786', NULL, 'd', '2022-08-02 14:39:49', '2022-08-02 14:39:49', NULL),
(46, '4', '832', NULL, 'd', '2022-08-02 14:39:49', '2022-08-02 14:39:49', NULL),
(47, '4', '838', NULL, 'b', '2022-08-02 14:39:49', '2022-08-02 14:39:49', NULL),
(48, '4', '852', NULL, 'd', '2022-08-02 14:39:49', '2022-08-02 14:39:49', NULL),
(49, '4', '854', NULL, 'a', '2022-08-02 14:39:49', '2022-08-02 14:39:49', NULL),
(50, '4', '860', NULL, 'b', '2022-08-02 14:39:49', '2022-08-02 14:39:49', NULL),
(51, '4', '864', NULL, 'd', '2022-08-02 14:39:49', '2022-08-02 14:39:49', NULL),
(52, '4', '865', NULL, 'b', '2022-08-02 14:39:49', '2022-08-02 14:39:49', NULL),
(53, '4', '879', NULL, 'd', '2022-08-02 14:39:49', '2022-08-02 14:39:49', NULL),
(54, '4', '887', NULL, 'a', '2022-08-02 14:39:49', '2022-08-02 14:39:49', NULL),
(55, '4', '907', NULL, 'b', '2022-08-02 14:39:49', '2022-08-02 14:39:49', NULL),
(56, '4', '908', NULL, 'c', '2022-08-02 14:39:49', '2022-08-02 14:39:49', NULL),
(57, '4', '910', NULL, 'c', '2022-08-02 14:39:49', '2022-08-02 14:39:49', NULL),
(58, '4', '912', NULL, 'c', '2022-08-02 14:39:49', '2022-08-02 14:39:49', NULL),
(59, '4', '952', NULL, 'b', '2022-08-02 14:39:49', '2022-08-02 14:39:49', NULL),
(60, '4', '989', NULL, 'b', '2022-08-02 14:39:49', '2022-08-02 14:39:49', NULL),
(61, '3', '23', 'a', 'b', '2022-08-04 16:33:39', '2022-08-04 16:33:41', NULL),
(62, '3', '29', 'a', 'a', '2022-08-04 16:33:39', '2022-08-04 16:33:42', NULL),
(63, '3', '39', 'a', 'a', '2022-08-04 16:33:39', '2022-08-04 16:33:43', NULL),
(64, '3', '46', 'a', 'd', '2022-08-04 16:33:39', '2022-08-04 16:33:44', NULL),
(65, '3', '63', 'a', 'b', '2022-08-04 16:33:39', '2022-08-04 16:33:45', NULL),
(66, '3', '64', 'a', 'd', '2022-08-04 16:33:39', '2022-08-04 16:33:46', NULL),
(67, '3', '109', 'a', 'c', '2022-08-04 16:33:39', '2022-08-04 16:33:47', NULL),
(68, '3', '145', 'a', 'd', '2022-08-04 16:33:39', '2022-08-04 16:33:48', NULL),
(69, '3', '163', 'a', 'a', '2022-08-04 16:33:39', '2022-08-04 16:33:51', NULL),
(70, '3', '164', 'a', 'b', '2022-08-04 16:33:39', '2022-08-04 16:33:52', NULL),
(71, '3', '165', 'a', 'b', '2022-08-04 16:33:39', '2022-08-04 16:33:53', NULL),
(72, '3', '171', 'a', 'b', '2022-08-04 16:33:39', '2022-08-04 16:33:54', NULL),
(73, '3', '180', 'a', 'b', '2022-08-04 16:33:39', '2022-08-04 16:33:55', NULL),
(74, '3', '197', 'a', 'a', '2022-08-04 16:33:39', '2022-08-04 16:33:56', NULL),
(75, '3', '230', 'a', 'b', '2022-08-04 16:33:39', '2022-08-04 16:33:58', NULL),
(76, '3', '233', NULL, 'b', '2022-08-04 16:33:39', '2022-08-04 16:33:39', NULL),
(77, '3', '296', NULL, 'a', '2022-08-04 16:33:39', '2022-08-04 16:33:39', NULL),
(78, '3', '307', NULL, 'a', '2022-08-04 16:33:39', '2022-08-04 16:33:39', NULL),
(79, '3', '316', NULL, 'c', '2022-08-04 16:33:39', '2022-08-04 16:33:39', NULL),
(80, '3', '321', NULL, 'b', '2022-08-04 16:33:39', '2022-08-04 16:33:39', NULL),
(81, '3', '336', NULL, 'b', '2022-08-04 16:33:39', '2022-08-04 16:33:39', NULL),
(82, '3', '356', NULL, 'd', '2022-08-04 16:33:39', '2022-08-04 16:33:39', NULL),
(83, '3', '384', NULL, 'b', '2022-08-04 16:33:39', '2022-08-04 16:33:39', NULL),
(84, '3', '396', NULL, 'c', '2022-08-04 16:33:39', '2022-08-04 16:33:39', NULL),
(85, '3', '403', NULL, 'a', '2022-08-04 16:33:39', '2022-08-04 16:33:39', NULL),
(86, '3', '432', NULL, 'c', '2022-08-04 16:33:39', '2022-08-04 16:33:39', NULL),
(87, '3', '437', NULL, 'c', '2022-08-04 16:33:39', '2022-08-04 16:33:39', NULL),
(88, '3', '441', NULL, 'c', '2022-08-04 16:33:39', '2022-08-04 16:33:39', NULL),
(89, '3', '450', NULL, 'a', '2022-08-04 16:33:39', '2022-08-04 16:33:39', NULL),
(90, '3', '462', NULL, 'a', '2022-08-04 16:33:39', '2022-08-04 16:33:39', NULL),
(91, '3', '473', NULL, 'd', '2022-08-04 16:33:39', '2022-08-04 16:33:39', NULL),
(92, '3', '485', NULL, 'c', '2022-08-04 16:33:39', '2022-08-04 16:33:39', NULL),
(93, '3', '555', NULL, 'd', '2022-08-04 16:33:39', '2022-08-04 16:33:39', NULL),
(94, '3', '564', NULL, 'c', '2022-08-04 16:33:39', '2022-08-04 16:33:39', NULL),
(95, '3', '595', NULL, 'd', '2022-08-04 16:33:39', '2022-08-04 16:33:39', NULL),
(96, '3', '600', NULL, 'c', '2022-08-04 16:33:39', '2022-08-04 16:33:39', NULL),
(97, '3', '618', NULL, 'b', '2022-08-04 16:33:39', '2022-08-04 16:33:39', NULL),
(98, '3', '619', NULL, 'd', '2022-08-04 16:33:39', '2022-08-04 16:33:39', NULL),
(99, '3', '624', NULL, 'c', '2022-08-04 16:33:39', '2022-08-04 16:33:39', NULL),
(100, '3', '627', NULL, 'b', '2022-08-04 16:33:39', '2022-08-04 16:33:39', NULL),
(101, '3', '634', NULL, 'c', '2022-08-04 16:33:39', '2022-08-04 16:33:39', NULL),
(102, '3', '667', NULL, 'd', '2022-08-04 16:33:39', '2022-08-04 16:33:39', NULL),
(103, '3', '670', NULL, 'd', '2022-08-04 16:33:39', '2022-08-04 16:33:39', NULL),
(104, '3', '685', NULL, 'd', '2022-08-04 16:33:39', '2022-08-04 16:33:39', NULL),
(105, '3', '726', NULL, 'c', '2022-08-04 16:33:39', '2022-08-04 16:33:39', NULL),
(106, '3', '748', NULL, 'd', '2022-08-04 16:33:39', '2022-08-04 16:33:39', NULL),
(107, '3', '754', NULL, 'a', '2022-08-04 16:33:39', '2022-08-04 16:33:39', NULL),
(108, '3', '759', NULL, 'b', '2022-08-04 16:33:39', '2022-08-04 16:33:39', NULL),
(109, '3', '763', NULL, 'a', '2022-08-04 16:33:39', '2022-08-04 16:33:39', NULL),
(110, '3', '774', NULL, 'b', '2022-08-04 16:33:39', '2022-08-04 16:33:39', NULL),
(111, '3', '778', NULL, 'a', '2022-08-04 16:33:39', '2022-08-04 16:33:39', NULL),
(112, '3', '787', NULL, 'b', '2022-08-04 16:33:39', '2022-08-04 16:33:39', NULL),
(113, '3', '796', NULL, 'b', '2022-08-04 16:33:39', '2022-08-04 16:33:39', NULL),
(114, '3', '833', NULL, 'b', '2022-08-04 16:33:39', '2022-08-04 16:33:39', NULL),
(115, '3', '854', NULL, 'a', '2022-08-04 16:33:39', '2022-08-04 16:33:39', NULL),
(116, '3', '883', NULL, 'c', '2022-08-04 16:33:39', '2022-08-04 16:33:39', NULL),
(117, '3', '917', NULL, 'd', '2022-08-04 16:33:39', '2022-08-04 16:33:39', NULL),
(118, '3', '933', NULL, 'b', '2022-08-04 16:33:39', '2022-08-04 16:33:39', NULL),
(119, '3', '941', NULL, 'b', '2022-08-04 16:33:39', '2022-08-04 16:33:39', NULL),
(120, '3', '973', NULL, 'd', '2022-08-04 16:33:39', '2022-08-04 16:33:39', NULL),
(121, '9', '10', 'a', 'b', '2022-08-07 03:23:44', '2022-08-07 03:23:49', NULL),
(122, '9', '37', 'd', 'a', '2022-08-07 03:23:44', '2022-08-07 03:23:50', NULL),
(123, '9', '43', 'c', 'c', '2022-08-07 03:23:44', '2022-08-07 03:23:51', NULL),
(124, '9', '48', 'c', 'a', '2022-08-07 03:23:44', '2022-08-07 03:23:52', NULL),
(125, '9', '54', 'c', 'd', '2022-08-07 03:23:44', '2022-08-07 03:23:52', NULL),
(126, '9', '69', 'b', 'b', '2022-08-07 03:23:44', '2022-08-07 03:23:53', NULL),
(127, '9', '80', 'b', 'a', '2022-08-07 03:23:44', '2022-08-07 03:23:54', NULL),
(128, '9', '125', 'c', 'b', '2022-08-07 03:23:44', '2022-08-07 03:23:57', NULL),
(129, '9', '126', 'b', 'a', '2022-08-07 03:23:44', '2022-08-07 03:23:57', NULL),
(130, '9', '141', 'b', 'd', '2022-08-07 03:23:44', '2022-08-07 03:23:58', NULL),
(131, '9', '159', 'b', 'c', '2022-08-07 03:23:44', '2022-08-07 03:24:00', NULL),
(132, '9', '170', NULL, 'd', '2022-08-07 03:23:44', '2022-08-07 03:23:44', NULL),
(133, '9', '197', 'b', 'c', '2022-08-07 03:23:44', '2022-08-07 03:24:02', NULL),
(134, '9', '206', 'c', 'a', '2022-08-07 03:23:44', '2022-08-07 03:24:03', NULL),
(135, '9', '207', 'b', 'b', '2022-08-07 03:23:44', '2022-08-07 03:24:04', NULL),
(136, '9', '214', NULL, 'c', '2022-08-07 03:23:44', '2022-08-07 03:23:44', NULL),
(137, '9', '217', NULL, 'a', '2022-08-07 03:23:44', '2022-08-07 03:23:44', NULL),
(138, '9', '241', NULL, 'a', '2022-08-07 03:23:44', '2022-08-07 03:23:44', NULL),
(139, '9', '277', NULL, 'a', '2022-08-07 03:23:44', '2022-08-07 03:23:44', NULL),
(140, '9', '281', NULL, 'd', '2022-08-07 03:23:44', '2022-08-07 03:23:44', NULL),
(141, '9', '302', NULL, 'd', '2022-08-07 03:23:44', '2022-08-07 03:23:44', NULL),
(142, '9', '324', NULL, 'a', '2022-08-07 03:23:44', '2022-08-07 03:23:44', NULL),
(143, '9', '328', NULL, 'c', '2022-08-07 03:23:44', '2022-08-07 03:23:44', NULL),
(144, '9', '340', NULL, 'd', '2022-08-07 03:23:44', '2022-08-07 03:23:44', NULL),
(145, '9', '381', NULL, 'd', '2022-08-07 03:23:44', '2022-08-07 03:23:44', NULL),
(146, '9', '382', NULL, 'a', '2022-08-07 03:23:44', '2022-08-07 03:23:44', NULL),
(147, '9', '402', NULL, 'c', '2022-08-07 03:23:44', '2022-08-07 03:23:44', NULL),
(148, '9', '427', NULL, 'b', '2022-08-07 03:23:44', '2022-08-07 03:23:44', NULL),
(149, '9', '447', NULL, 'b', '2022-08-07 03:23:44', '2022-08-07 03:23:44', NULL),
(150, '9', '454', NULL, 'a', '2022-08-07 03:23:44', '2022-08-07 03:23:44', NULL),
(151, '9', '563', NULL, 'c', '2022-08-07 03:23:44', '2022-08-07 03:23:44', NULL),
(152, '9', '577', NULL, 'b', '2022-08-07 03:23:44', '2022-08-07 03:23:44', NULL),
(153, '9', '580', NULL, 'd', '2022-08-07 03:23:44', '2022-08-07 03:23:44', NULL),
(154, '9', '585', NULL, 'b', '2022-08-07 03:23:44', '2022-08-07 03:23:44', NULL),
(155, '9', '611', NULL, 'a', '2022-08-07 03:23:44', '2022-08-07 03:23:44', NULL),
(156, '9', '630', NULL, 'd', '2022-08-07 03:23:44', '2022-08-07 03:23:44', NULL),
(157, '9', '636', NULL, 'c', '2022-08-07 03:23:44', '2022-08-07 03:23:44', NULL),
(158, '9', '649', NULL, 'b', '2022-08-07 03:23:44', '2022-08-07 03:23:44', NULL),
(159, '9', '661', NULL, 'c', '2022-08-07 03:23:44', '2022-08-07 03:23:44', NULL),
(160, '9', '667', NULL, 'a', '2022-08-07 03:23:44', '2022-08-07 03:23:44', NULL),
(161, '9', '684', NULL, 'a', '2022-08-07 03:23:44', '2022-08-07 03:23:44', NULL),
(162, '9', '699', NULL, 'a', '2022-08-07 03:23:44', '2022-08-07 03:23:44', NULL),
(163, '9', '708', NULL, 'c', '2022-08-07 03:23:44', '2022-08-07 03:23:44', NULL),
(164, '9', '715', NULL, 'b', '2022-08-07 03:23:44', '2022-08-07 03:23:44', NULL),
(165, '9', '720', NULL, 'b', '2022-08-07 03:23:44', '2022-08-07 03:23:44', NULL),
(166, '9', '740', NULL, 'b', '2022-08-07 03:23:44', '2022-08-07 03:23:44', NULL),
(167, '9', '742', NULL, 'd', '2022-08-07 03:23:44', '2022-08-07 03:23:44', NULL),
(168, '9', '751', NULL, 'c', '2022-08-07 03:23:44', '2022-08-07 03:23:44', NULL),
(169, '9', '769', NULL, 'b', '2022-08-07 03:23:44', '2022-08-07 03:23:44', NULL),
(170, '9', '787', NULL, 'a', '2022-08-07 03:23:44', '2022-08-07 03:23:44', NULL),
(171, '9', '806', NULL, 'a', '2022-08-07 03:23:44', '2022-08-07 03:23:44', NULL),
(172, '9', '855', NULL, 'b', '2022-08-07 03:23:44', '2022-08-07 03:23:44', NULL),
(173, '9', '859', NULL, 'a', '2022-08-07 03:23:44', '2022-08-07 03:23:44', NULL),
(174, '9', '873', NULL, 'b', '2022-08-07 03:23:44', '2022-08-07 03:23:44', NULL),
(175, '9', '878', NULL, 'c', '2022-08-07 03:23:44', '2022-08-07 03:23:44', NULL),
(176, '9', '891', NULL, 'd', '2022-08-07 03:23:44', '2022-08-07 03:23:44', NULL),
(177, '9', '904', NULL, 'd', '2022-08-07 03:23:44', '2022-08-07 03:23:44', NULL),
(178, '9', '933', NULL, 'a', '2022-08-07 03:23:44', '2022-08-07 03:23:44', NULL),
(179, '9', '973', NULL, 'b', '2022-08-07 03:23:44', '2022-08-07 03:23:44', NULL),
(180, '9', '982', NULL, 'c', '2022-08-07 03:23:44', '2022-08-07 03:23:44', NULL),
(181, '12', '999', NULL, 'a', '2022-08-11 08:05:34', '2022-08-11 08:05:34', NULL),
(182, '12', '1000', NULL, 'b', '2022-08-11 08:05:34', '2022-08-11 08:05:34', NULL),
(183, '12', '1001', NULL, 'd', '2022-08-11 08:05:34', '2022-08-11 08:05:34', NULL),
(184, '12', '1002', NULL, 'c', '2022-08-11 08:05:34', '2022-08-11 08:05:34', NULL),
(185, '12', '1003', NULL, 'a', '2022-08-11 08:05:34', '2022-08-11 08:05:34', NULL),
(186, '12', '1004', NULL, 'b', '2022-08-11 08:05:34', '2022-08-11 08:05:34', NULL),
(187, '12', '1005', NULL, 'c', '2022-08-11 08:05:34', '2022-08-11 08:05:34', NULL),
(188, '12', '1006', NULL, 'a', '2022-08-11 08:05:34', '2022-08-11 08:05:34', NULL),
(189, '12', '1007', NULL, 'b', '2022-08-11 08:05:34', '2022-08-11 08:05:34', NULL),
(190, '12', '1008', NULL, 'a', '2022-08-11 08:05:34', '2022-08-11 08:05:34', NULL),
(191, '12', '1009', NULL, 'd', '2022-08-11 08:05:34', '2022-08-11 08:05:34', NULL),
(192, '12', '1010', NULL, 'b', '2022-08-11 08:05:34', '2022-08-11 08:05:34', NULL),
(193, '12', '1011', NULL, 'a', '2022-08-11 08:05:34', '2022-08-11 08:05:34', NULL),
(194, '12', '1012', NULL, 'c', '2022-08-11 08:05:34', '2022-08-11 08:05:34', NULL),
(195, '12', '1013', NULL, 'b', '2022-08-11 08:05:34', '2022-08-11 08:05:34', NULL),
(196, '12', '1014', NULL, 'd', '2022-08-11 08:05:34', '2022-08-11 08:05:34', NULL),
(197, '12', '1015', NULL, 'b', '2022-08-11 08:05:34', '2022-08-11 08:05:34', NULL),
(198, '12', '1016', NULL, 'b', '2022-08-11 08:05:34', '2022-08-11 08:05:34', NULL),
(199, '12', '1017', NULL, 'c', '2022-08-11 08:05:34', '2022-08-11 08:05:34', NULL),
(200, '12', '1018', NULL, 'a', '2022-08-11 08:05:34', '2022-08-11 08:05:34', NULL),
(201, '12', '1019', NULL, 'b', '2022-08-11 08:05:34', '2022-08-11 08:05:34', NULL),
(202, '12', '1020', NULL, 'c', '2022-08-11 08:05:34', '2022-08-11 08:05:34', NULL),
(203, '12', '1021', NULL, 'a', '2022-08-11 08:05:34', '2022-08-11 08:05:34', NULL),
(204, '12', '1022', NULL, 'a', '2022-08-11 08:05:34', '2022-08-11 08:05:34', NULL),
(205, '12', '1023', NULL, 'd', '2022-08-11 08:05:34', '2022-08-11 08:05:34', NULL),
(206, '12', '1024', NULL, 'b', '2022-08-11 08:05:34', '2022-08-11 08:05:34', NULL),
(207, '12', '1025', NULL, 'c', '2022-08-11 08:05:34', '2022-08-11 08:05:34', NULL),
(208, '12', '1026', NULL, 'c', '2022-08-11 08:05:34', '2022-08-11 08:05:34', NULL),
(209, '12', '1027', NULL, 'c', '2022-08-11 08:05:34', '2022-08-11 08:05:34', NULL),
(210, '12', '1028', NULL, 'a', '2022-08-11 08:05:34', '2022-08-11 08:05:34', NULL),
(211, '12', '1029', NULL, 'd', '2022-08-11 08:05:34', '2022-08-11 08:05:34', NULL),
(212, '12', '1030', NULL, 'd', '2022-08-11 08:05:34', '2022-08-11 08:05:34', NULL),
(213, '12', '1031', NULL, 'b', '2022-08-11 08:05:34', '2022-08-11 08:05:34', NULL),
(214, '12', '1032', NULL, 'c', '2022-08-11 08:05:34', '2022-08-11 08:05:34', NULL),
(215, '12', '1033', NULL, 'b', '2022-08-11 08:05:34', '2022-08-11 08:05:34', NULL),
(216, '12', '1034', NULL, 'a', '2022-08-11 08:05:34', '2022-08-11 08:05:34', NULL),
(217, '12', '1035', NULL, 'c', '2022-08-11 08:05:34', '2022-08-11 08:05:34', NULL),
(218, '12', '1036', NULL, 'd', '2022-08-11 08:05:34', '2022-08-11 08:05:34', NULL),
(219, '12', '1037', NULL, 'c', '2022-08-11 08:05:34', '2022-08-11 08:05:34', NULL),
(220, '12', '1038', NULL, 'b', '2022-08-11 08:05:34', '2022-08-11 08:05:34', NULL),
(221, '12', '1039', NULL, 'a', '2022-08-11 08:05:34', '2022-08-11 08:05:34', NULL),
(222, '12', '1040', NULL, 'c', '2022-08-11 08:05:34', '2022-08-11 08:05:34', NULL),
(223, '12', '1041', NULL, 'a', '2022-08-11 08:05:34', '2022-08-11 08:05:34', NULL),
(224, '12', '1042', NULL, 'a', '2022-08-11 08:05:34', '2022-08-11 08:05:34', NULL),
(225, '12', '1043', NULL, 'd', '2022-08-11 08:05:34', '2022-08-11 08:05:34', NULL),
(226, '12', '1044', NULL, 'b', '2022-08-11 08:05:34', '2022-08-11 08:05:34', NULL),
(227, '12', '1045', NULL, 'b', '2022-08-11 08:05:34', '2022-08-11 08:05:34', NULL),
(228, '12', '1046', NULL, 'c', '2022-08-11 08:05:34', '2022-08-11 08:05:34', NULL),
(229, '12', '1047', NULL, 'd', '2022-08-11 08:05:34', '2022-08-11 08:05:34', NULL),
(230, '12', '1048', NULL, 'b', '2022-08-11 08:05:34', '2022-08-11 08:05:34', NULL),
(231, '12', '1049', NULL, 'a', '2022-08-11 08:05:34', '2022-08-11 08:05:34', NULL),
(232, '12', '1050', NULL, 'c', '2022-08-11 08:05:34', '2022-08-11 08:05:34', NULL),
(233, '12', '1051', NULL, 'c', '2022-08-11 08:05:34', '2022-08-11 08:05:34', NULL),
(234, '12', '1052', NULL, 'a', '2022-08-11 08:05:34', '2022-08-11 08:05:34', NULL),
(235, '12', '1053', NULL, 'c', '2022-08-11 08:05:34', '2022-08-11 08:05:34', NULL),
(236, '12', '1054', NULL, 'd', '2022-08-11 08:05:34', '2022-08-11 08:05:34', NULL),
(237, '12', '1055', NULL, 'a', '2022-08-11 08:05:34', '2022-08-11 08:05:34', NULL),
(238, '12', '1056', NULL, 'b', '2022-08-11 08:05:34', '2022-08-11 08:05:34', NULL),
(239, '12', '1057', NULL, 'c', '2022-08-11 08:05:34', '2022-08-11 08:05:34', NULL),
(240, '12', '1058', NULL, 'b', '2022-08-11 08:05:34', '2022-08-11 08:05:34', NULL),
(241, '13', '999', NULL, 'a', '2022-08-12 08:13:49', '2022-08-12 08:13:49', NULL),
(242, '13', '1000', NULL, 'b', '2022-08-12 08:13:49', '2022-08-12 08:13:49', NULL),
(243, '13', '1001', NULL, 'd', '2022-08-12 08:13:49', '2022-08-12 08:13:49', NULL),
(244, '13', '1002', NULL, 'c', '2022-08-12 08:13:49', '2022-08-12 08:13:49', NULL),
(245, '13', '1003', NULL, 'a', '2022-08-12 08:13:49', '2022-08-12 08:13:49', NULL),
(246, '13', '1004', NULL, 'b', '2022-08-12 08:13:49', '2022-08-12 08:13:49', NULL),
(247, '13', '1005', NULL, 'c', '2022-08-12 08:13:49', '2022-08-12 08:13:49', NULL),
(248, '13', '1006', NULL, 'a', '2022-08-12 08:13:49', '2022-08-12 08:13:49', NULL),
(249, '13', '1007', NULL, 'b', '2022-08-12 08:13:49', '2022-08-12 08:13:49', NULL),
(250, '13', '1008', NULL, 'a', '2022-08-12 08:13:49', '2022-08-12 08:13:49', NULL),
(251, '13', '1009', NULL, 'd', '2022-08-12 08:13:49', '2022-08-12 08:13:49', NULL),
(252, '13', '1010', NULL, 'b', '2022-08-12 08:13:49', '2022-08-12 08:13:49', NULL),
(253, '13', '1011', NULL, 'a', '2022-08-12 08:13:49', '2022-08-12 08:13:49', NULL),
(254, '13', '1012', NULL, 'c', '2022-08-12 08:13:49', '2022-08-12 08:13:49', NULL),
(255, '13', '1013', NULL, 'b', '2022-08-12 08:13:49', '2022-08-12 08:13:49', NULL),
(256, '13', '1014', NULL, 'd', '2022-08-12 08:13:49', '2022-08-12 08:13:49', NULL),
(257, '13', '1015', NULL, 'b', '2022-08-12 08:13:49', '2022-08-12 08:13:49', NULL),
(258, '13', '1016', NULL, 'b', '2022-08-12 08:13:49', '2022-08-12 08:13:49', NULL),
(259, '13', '1017', NULL, 'c', '2022-08-12 08:13:49', '2022-08-12 08:13:49', NULL),
(260, '13', '1018', NULL, 'a', '2022-08-12 08:13:49', '2022-08-12 08:13:49', NULL),
(261, '13', '1019', NULL, 'b', '2022-08-12 08:13:49', '2022-08-12 08:13:49', NULL),
(262, '13', '1020', NULL, 'c', '2022-08-12 08:13:49', '2022-08-12 08:13:49', NULL),
(263, '13', '1021', NULL, 'a', '2022-08-12 08:13:49', '2022-08-12 08:13:49', NULL),
(264, '13', '1022', NULL, 'a', '2022-08-12 08:13:49', '2022-08-12 08:13:49', NULL),
(265, '13', '1023', NULL, 'd', '2022-08-12 08:13:49', '2022-08-12 08:13:49', NULL),
(266, '13', '1024', NULL, 'b', '2022-08-12 08:13:49', '2022-08-12 08:13:49', NULL),
(267, '13', '1025', NULL, 'c', '2022-08-12 08:13:49', '2022-08-12 08:13:49', NULL),
(268, '13', '1026', NULL, 'c', '2022-08-12 08:13:49', '2022-08-12 08:13:49', NULL),
(269, '13', '1027', NULL, 'c', '2022-08-12 08:13:49', '2022-08-12 08:13:49', NULL),
(270, '13', '1028', NULL, 'a', '2022-08-12 08:13:49', '2022-08-12 08:13:49', NULL),
(271, '13', '1029', NULL, 'd', '2022-08-12 08:13:49', '2022-08-12 08:13:49', NULL),
(272, '13', '1030', NULL, 'd', '2022-08-12 08:13:49', '2022-08-12 08:13:49', NULL),
(273, '13', '1031', NULL, 'b', '2022-08-12 08:13:49', '2022-08-12 08:13:49', NULL),
(274, '13', '1032', NULL, 'c', '2022-08-12 08:13:49', '2022-08-12 08:13:49', NULL),
(275, '13', '1033', NULL, 'b', '2022-08-12 08:13:49', '2022-08-12 08:13:49', NULL),
(276, '13', '1034', NULL, 'a', '2022-08-12 08:13:49', '2022-08-12 08:13:49', NULL),
(277, '13', '1035', NULL, 'c', '2022-08-12 08:13:49', '2022-08-12 08:13:49', NULL),
(278, '13', '1036', NULL, 'd', '2022-08-12 08:13:49', '2022-08-12 08:13:49', NULL),
(279, '13', '1037', NULL, 'c', '2022-08-12 08:13:49', '2022-08-12 08:13:49', NULL),
(280, '13', '1038', NULL, 'b', '2022-08-12 08:13:49', '2022-08-12 08:13:49', NULL),
(281, '13', '1039', NULL, 'a', '2022-08-12 08:13:49', '2022-08-12 08:13:49', NULL),
(282, '13', '1040', NULL, 'c', '2022-08-12 08:13:49', '2022-08-12 08:13:49', NULL),
(283, '13', '1041', NULL, 'a', '2022-08-12 08:13:49', '2022-08-12 08:13:49', NULL),
(284, '13', '1042', NULL, 'a', '2022-08-12 08:13:49', '2022-08-12 08:13:49', NULL),
(285, '13', '1043', NULL, 'd', '2022-08-12 08:13:49', '2022-08-12 08:13:49', NULL),
(286, '13', '1044', NULL, 'b', '2022-08-12 08:13:49', '2022-08-12 08:13:49', NULL),
(287, '13', '1045', NULL, 'b', '2022-08-12 08:13:49', '2022-08-12 08:13:49', NULL),
(288, '13', '1046', NULL, 'c', '2022-08-12 08:13:49', '2022-08-12 08:13:49', NULL),
(289, '13', '1047', NULL, 'd', '2022-08-12 08:13:49', '2022-08-12 08:13:49', NULL),
(290, '13', '1048', NULL, 'b', '2022-08-12 08:13:49', '2022-08-12 08:13:49', NULL),
(291, '13', '1049', NULL, 'a', '2022-08-12 08:13:49', '2022-08-12 08:13:49', NULL),
(292, '13', '1050', NULL, 'c', '2022-08-12 08:13:49', '2022-08-12 08:13:49', NULL),
(293, '13', '1051', NULL, 'c', '2022-08-12 08:13:49', '2022-08-12 08:13:49', NULL),
(294, '13', '1052', NULL, 'a', '2022-08-12 08:13:49', '2022-08-12 08:13:49', NULL),
(295, '13', '1053', NULL, 'c', '2022-08-12 08:13:49', '2022-08-12 08:13:49', NULL),
(296, '13', '1054', NULL, 'd', '2022-08-12 08:13:49', '2022-08-12 08:13:49', NULL),
(297, '13', '1055', NULL, 'a', '2022-08-12 08:13:49', '2022-08-12 08:13:49', NULL),
(298, '13', '1056', NULL, 'b', '2022-08-12 08:13:49', '2022-08-12 08:13:49', NULL),
(299, '13', '1057', NULL, 'c', '2022-08-12 08:13:49', '2022-08-12 08:13:49', NULL),
(300, '13', '1058', NULL, 'b', '2022-08-12 08:13:49', '2022-08-12 08:13:49', NULL),
(301, '14', '999', 'a', 'a', '2022-08-12 08:16:58', '2022-08-12 08:17:46', NULL),
(302, '14', '1000', 'b', 'b', '2022-08-12 08:16:58', '2022-08-12 08:17:57', NULL),
(303, '14', '1001', 'd', 'd', '2022-08-12 08:16:58', '2022-08-12 08:18:02', NULL),
(304, '14', '1002', 'c', 'c', '2022-08-12 08:16:58', '2022-08-12 08:18:10', NULL),
(305, '14', '1003', 'a', 'a', '2022-08-12 08:16:58', '2022-08-12 08:18:10', NULL),
(306, '14', '1004', 'b', 'b', '2022-08-12 08:16:58', '2022-08-12 08:18:11', NULL),
(307, '14', '1005', 'c', 'c', '2022-08-12 08:16:58', '2022-08-12 08:18:25', NULL),
(308, '14', '1006', 'a', 'a', '2022-08-12 08:16:58', '2022-08-12 08:18:25', NULL),
(309, '14', '1007', 'b', 'b', '2022-08-12 08:16:58', '2022-08-12 08:18:26', NULL),
(310, '14', '1008', 'a', 'a', '2022-08-12 08:16:58', '2022-08-12 08:18:36', NULL),
(311, '14', '1009', 'd', 'd', '2022-08-12 08:16:58', '2022-08-12 08:18:37', NULL),
(312, '14', '1010', 'b', 'b', '2022-08-12 08:16:58', '2022-08-12 08:18:38', NULL),
(313, '14', '1011', 'a', 'a', '2022-08-12 08:16:58', '2022-08-12 08:18:49', NULL),
(314, '14', '1012', 'c', 'c', '2022-08-12 08:16:58', '2022-08-12 08:18:50', NULL),
(315, '14', '1013', 'b', 'b', '2022-08-12 08:16:58', '2022-08-12 08:18:51', NULL),
(316, '14', '1014', 'd', 'd', '2022-08-12 08:16:58', '2022-08-12 08:18:56', NULL),
(317, '14', '1015', 'b', 'b', '2022-08-12 08:16:58', '2022-08-12 08:19:23', NULL),
(318, '14', '1016', 'b', 'b', '2022-08-12 08:16:58', '2022-08-12 08:19:24', NULL),
(319, '14', '1017', 'c', 'c', '2022-08-12 08:16:58', '2022-08-12 08:19:25', NULL),
(320, '14', '1018', 'a', 'a', '2022-08-12 08:16:58', '2022-08-12 08:19:26', NULL),
(321, '14', '1019', 'b', 'b', '2022-08-12 08:16:58', '2022-08-12 08:19:36', NULL),
(322, '14', '1020', 'c', 'c', '2022-08-12 08:16:58', '2022-08-12 08:19:38', NULL),
(323, '14', '1021', 'a', 'a', '2022-08-12 08:16:58', '2022-08-12 08:19:39', NULL),
(324, '14', '1022', 'a', 'a', '2022-08-12 08:16:58', '2022-08-12 08:19:40', NULL),
(325, '14', '1023', 'c', 'd', '2022-08-12 08:16:58', '2022-08-12 08:19:47', NULL),
(326, '14', '1024', 'b', 'b', '2022-08-12 08:16:58', '2022-08-12 08:19:48', NULL),
(327, '14', '1025', 'c', 'c', '2022-08-12 08:16:58', '2022-08-12 08:19:49', NULL),
(328, '14', '1026', 'c', 'c', '2022-08-12 08:16:58', '2022-08-12 08:19:50', NULL),
(329, '14', '1027', 'c', 'c', '2022-08-12 08:16:58', '2022-08-12 08:19:52', NULL),
(330, '14', '1028', 'a', 'a', '2022-08-12 08:16:58', '2022-08-12 08:19:56', NULL),
(331, '14', '1029', 'd', 'd', '2022-08-12 08:16:58', '2022-08-12 08:20:16', NULL),
(332, '14', '1030', 'd', 'd', '2022-08-12 08:16:58', '2022-08-12 08:20:17', NULL),
(333, '14', '1031', 'b', 'b', '2022-08-12 08:16:58', '2022-08-12 08:20:18', NULL),
(334, '14', '1032', 'c', 'c', '2022-08-12 08:16:58', '2022-08-12 08:20:19', NULL),
(335, '14', '1033', 'b', 'b', '2022-08-12 08:16:58', '2022-08-12 08:20:41', NULL),
(336, '14', '1034', 'a', 'a', '2022-08-12 08:16:58', '2022-08-12 08:20:42', NULL),
(337, '14', '1035', 'c', 'c', '2022-08-12 08:16:58', '2022-08-12 08:20:43', NULL),
(338, '14', '1036', 'd', 'd', '2022-08-12 08:16:58', '2022-08-12 08:20:44', NULL),
(339, '14', '1037', 'c', 'c', '2022-08-12 08:16:58', '2022-08-12 08:20:52', NULL),
(340, '14', '1038', 'b', 'b', '2022-08-12 08:16:58', '2022-08-12 08:20:54', NULL),
(341, '14', '1039', 'a', 'a', '2022-08-12 08:16:58', '2022-08-12 08:21:05', NULL),
(342, '14', '1040', 'c', 'c', '2022-08-12 08:16:58', '2022-08-12 08:21:06', NULL),
(343, '14', '1041', 'a', 'a', '2022-08-12 08:16:58', '2022-08-12 08:21:06', NULL),
(344, '14', '1042', 'b', 'a', '2022-08-12 08:16:58', '2022-08-12 08:21:11', NULL),
(345, '14', '1043', 'b', 'd', '2022-08-12 08:16:58', '2022-08-12 08:21:09', NULL),
(346, '14', '1044', 'c', 'b', '2022-08-12 08:16:58', '2022-08-12 08:21:28', NULL),
(347, '14', '1045', 'c', 'b', '2022-08-12 08:16:58', '2022-08-12 08:21:26', NULL),
(348, '14', '1046', 'b', 'c', '2022-08-12 08:16:58', '2022-08-12 08:21:27', NULL),
(349, '14', '1047', 'b', 'd', '2022-08-12 08:16:58', '2022-08-12 08:21:25', NULL),
(350, '14', '1048', 'b', 'b', '2022-08-12 08:16:58', '2022-08-12 08:21:24', NULL),
(351, '14', '1049', 'c', 'a', '2022-08-12 08:16:58', '2022-08-12 08:21:23', NULL),
(352, '14', '1050', 'a', 'c', '2022-08-12 08:16:58', '2022-08-12 08:21:23', NULL),
(353, '14', '1051', 'b', 'c', '2022-08-12 08:16:58', '2022-08-12 08:21:22', NULL),
(354, '14', '1052', 'c', 'a', '2022-08-12 08:16:58', '2022-08-12 08:21:21', NULL),
(355, '14', '1053', 'd', 'c', '2022-08-12 08:16:58', '2022-08-12 08:21:20', NULL),
(356, '14', '1054', 'a', 'd', '2022-08-12 08:16:58', '2022-08-12 08:21:20', NULL),
(357, '14', '1055', 'b', 'a', '2022-08-12 08:16:58', '2022-08-12 08:21:18', NULL),
(358, '14', '1056', 'a', 'b', '2022-08-12 08:16:58', '2022-08-12 08:21:17', NULL),
(359, '14', '1057', 'c', 'c', '2022-08-12 08:16:58', '2022-08-12 08:21:17', NULL),
(360, '14', '1058', 'b', 'b', '2022-08-12 08:16:58', '2022-08-12 08:21:16', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
--

CREATE TABLE `user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_test` int(11) NOT NULL DEFAULT 2 COMMENT '1: Đã test, 2: Chưa test',
  `time_test_start` datetime DEFAULT NULL COMMENT 'Thời gian bắt đầu bài test',
  `time_test_end` datetime DEFAULT NULL COMMENT 'Thời gian hoàn thành bài test',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Đang đổ dữ liệu cho bảng `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `status_test`, `time_test_start`, `time_test_end`, `remember_token`, `created_at`, `updated_at`, `deleted_at`, `phone`, `otp`) VALUES
(1, 'user', 'user1@gmail.com', '$2y$10$bRy0vzuk7jgbsRRcMTG69uQLfEvVAbSNv4QYPlxQJV0gWqVmFHUPG', 2, NULL, NULL, NULL, '2022-07-26 16:58:02', '2022-08-13 05:47:14', NULL, '0964047661', ''),
(2, 'mot', 'yeuemtenthai@gmail.com', '$2y$10$.rOJkZdPwk3.iy2sgi6lb.zBR3NoVeu2lF5MSKCPJiRdsBYj1sQNy', 2, NULL, NULL, NULL, '2022-08-01 16:15:34', '2022-08-13 06:01:53', NULL, '0964047662', ''),
(3, 'hai', 'hai@gmail.com', '$2y$10$PQgDKKL0SY9aSdoSHjvqMOkEGUinRo.NvGtYbE1V0nWDSoTtlOulu', 1, '2022-08-04 23:33:39', '2022-08-05 00:18:39', NULL, '2022-08-01 16:16:39', '2022-08-04 16:34:04', NULL, '0964047663', NULL),
(4, 'sau', 'sau@gmail.com', '$2y$10$7q4iFLjW2y1XmeRa9s4mT.yDeiMxMBXo7cFeF5n6esCuOLgzZqahW', 1, '2022-08-02 21:39:49', '2022-08-02 22:24:49', NULL, '2022-08-02 14:24:59', '2022-08-02 14:39:53', NULL, '0964047666', NULL),
(5, 'bay1', 'bay@gmail.com', '$2y$10$XsdDJmnjpXry7CKytRr67.nl/fnn6qHrzuEFk3IyQkkeUZelZHbLu', 2, NULL, NULL, NULL, '2022-08-04 13:20:54', '2022-08-04 13:29:52', NULL, '0123456789', NULL),
(7, 'Sơn Nguyễn', 'vanson297.nguyen@gmail.com', '$2y$10$L2j06EmN52vkAHA/SINdfeEXYH..YeuYY.7FOGp/GOCvgXXtx8MHq', 2, NULL, NULL, NULL, '2022-08-05 14:18:41', '2022-08-05 14:18:41', NULL, '0964047698', NULL),
(8, 'tam', 'tam@gmail.com', '$2y$10$oeuziHfsm63OqJAsWlZE5OGCxPQwOYRpBBed8m7tKc3mC.gKCMK7O', 2, NULL, NULL, NULL, '2022-08-05 14:20:15', '2022-08-05 14:20:15', NULL, '0968047888', NULL),
(9, 'mai cao hoang duy', 'duyykr@gmail.com', '$2y$10$K442g7cYLXDLMWvVXwtX0u.gcSWh7X1SDx9JyJs.Zd3NYpn.SstkS', 1, '2022-08-07 10:23:44', '2022-08-07 11:08:44', NULL, '2022-08-07 03:23:04', '2022-08-07 03:24:08', NULL, '0906260100', NULL),
(10, 'mai cao hoang duy', 'khanhhung141198@gmail.com', '$2y$10$3x4huv0tmnUufZ3yIEDExetox0dfMD8PoVEy6MBsKerqJBbMDqYfu', 2, NULL, NULL, NULL, '2022-08-11 07:31:58', '2022-08-11 07:31:58', NULL, '0964365965', NULL),
(11, 'mai cao hoang duy', 'khanhhung1411985@gmail.com', '$2y$10$Sc6O9qa23EWnUTK.utQA7OhZVwhCHRtYNI1iOhEiqpLqrxneTd1bK', 2, '2022-08-11 14:32:35', '2022-08-11 15:17:35', NULL, '2022-08-11 07:32:20', '2022-08-11 07:32:35', NULL, '0964365964', NULL),
(13, 'Nguyen Van B', 'nguyenvan@gmail.com', '$2y$10$45qVASrPxddUscCsPkoCAe0JKJuSiSC6tHOQJDMTOsTOzJ4rXIZfO', 1, '2022-08-12 15:13:49', '2022-08-12 15:58:49', NULL, '2022-08-12 08:12:35', '2022-08-12 08:15:04', NULL, '0921453243', NULL),
(14, 'Trương đình nhật', 'nhat@gmail.com', '$2y$10$rFX4uqhtFZvcxH19XGDBQeS9nz8Chpft5twJ.yCUCI17hWfXeWm4W', 1, '2022-08-12 15:16:58', '2022-08-12 16:01:58', NULL, '2022-08-12 08:16:47', '2022-08-12 08:21:30', NULL, '0921453246', NULL),
(15, 'Trương đình nhật', 'dinhnhat882k@gmail.com', '$2y$10$KM.GocHp5J1Jbnyes64RAuHmIcEA.MpQLYjOBjV4YvfH3z0N1OMWy', 2, NULL, NULL, NULL, '2022-08-12 08:59:44', '2022-08-12 08:59:44', NULL, '0942137424', NULL),
(16, 'mai cao hoang duy', 'duymchde140035@fpt.edu.vn', '$2y$10$UkJpFaMQ6g2Tf8I7t5DKl.RyPy2PPceTEH7MLabNza1fYxfZTh7Ba', 2, NULL, NULL, NULL, '2022-08-12 09:04:22', '2022-08-12 09:04:22', NULL, '0902142144', NULL),
(17, 'mai cao hoang duy', 'talacanhsat0@gmail.com', '$2y$10$vGrJ7B7GhYrRUOdiENAF2.tFuvdObwzrQ3PQqJiSbkttSq67/Q1C2', 2, NULL, NULL, NULL, '2022-08-12 14:11:35', '2022-08-12 14:11:35', NULL, '0909482342', NULL),
(18, 'nguyen khanh hung', 'hungnkde150004@fpt.edu.vn', '$2y$10$4jlHe6BfXVNwYkiWwXTcBewHPbiOz9FVkAFn9RO3qzdHlHjzO1kSW', 2, NULL, NULL, NULL, '2022-08-12 14:35:28', '2022-08-13 06:03:47', NULL, '0940048245', NULL),
(19, 'Sơn Nguyễn', 'ba@gmail.com', '$2y$10$JL9bFYH1ctAyAdH5saZfhu8djES9OR67zeWXlkN3IJKNOSeHsiFD6', 2, NULL, NULL, NULL, '2022-08-13 12:22:44', '2022-08-13 12:22:44', NULL, '0964047002', NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `admin_email_unique` (`email`) USING BTREE;

--
-- Chỉ mục cho bảng `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Chỉ mục cho bảng `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Chỉ mục cho bảng `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Chỉ mục cho bảng `certificates`
--
ALTER TABLE `certificates`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Chỉ mục cho bảng `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Chỉ mục cho bảng `class_schedules`
--
ALTER TABLE `class_schedules`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Chỉ mục cho bảng `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Chỉ mục cho bảng `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Chỉ mục cho bảng `degrees`
--
ALTER TABLE `degrees`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Chỉ mục cho bảng `levels`
--
ALTER TABLE `levels`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Chỉ mục cho bảng `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Chỉ mục cho bảng `order_histories`
--
ALTER TABLE `order_histories`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Chỉ mục cho bảng `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Chỉ mục cho bảng `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Chỉ mục cho bảng `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `teacher_email_unique` (`email`) USING BTREE,
  ADD UNIQUE KEY `teacher_phone_unique` (`phone`) USING BTREE;

--
-- Chỉ mục cho bảng `teacher_certificate`
--
ALTER TABLE `teacher_certificate`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Chỉ mục cho bảng `test_result`
--
ALTER TABLE `test_result`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `user_email_unique` (`email`) USING BTREE,
  ADD UNIQUE KEY `user_phone_unique` (`phone`) USING BTREE;

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `admin`
--
ALTER TABLE `admin`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `blog_categories`
--
ALTER TABLE `blog_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `branches`
--
ALTER TABLE `branches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `certificates`
--
ALTER TABLE `certificates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `classes`
--
ALTER TABLE `classes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT cho bảng `class_schedules`
--
ALTER TABLE `class_schedules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT cho bảng `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `degrees`
--
ALTER TABLE `degrees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT cho bảng `levels`
--
ALTER TABLE `levels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT cho bảng `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT cho bảng `order_histories`
--
ALTER TABLE `order_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `question`
--
ALTER TABLE `question`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1059;

--
-- AUTO_INCREMENT cho bảng `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `teacher`
--
ALTER TABLE `teacher`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `teacher_certificate`
--
ALTER TABLE `teacher_certificate`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT cho bảng `test_result`
--
ALTER TABLE `test_result`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=361;

--
-- AUTO_INCREMENT cho bảng `user`
--
ALTER TABLE `user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
