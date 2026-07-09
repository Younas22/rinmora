-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2023 at 07:33 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `track_order`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog_categories`
--

CREATE TABLE `blog_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog_categories`
--

INSERT INTO `blog_categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(2, 'web development', '2023-01-16 07:15:16', '2023-01-16 07:15:16'),
(3, 'web design', '2023-01-16 07:16:35', '2023-01-16 07:16:35');

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
--

CREATE TABLE `blog_posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `featured_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('published','draft') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog_posts`
--

INSERT INTO `blog_posts` (`id`, `category_id`, `title`, `slug`, `body`, `featured_image`, `user_id`, `status`, `created_at`, `updated_at`) VALUES
(2, 3, 'Web Development and SEO: How to Optimize Your Website', 'web-development-seo-optimize-website', '<p>When it comes to building a website, web development and SEO are two key components that go hand in hand. Without SEO, your website may not be visible to potential customers, and without web development, your website may not be user-friendly or visually appealing. In this guide, we&#39;ll explore how web development and SEO work together to optimize your website and improve your online presence.</p>\r\n\r\n<p>First, let&#39;s talk about user experience. User experience, or UX, is the overall experience of a person using a website. Good UX design focuses on making the website easy to navigate, visually appealing, and user-friendly. By focusing on UX, you can improve the chances of visitors staying on your website and potentially converting into customers. When it comes to SEO, user experience is important because search engines, such as Google, consider user engagement as a ranking factor. This means that websites that provide a good user experience will be ranked higher in search engine results.</p>\r\n\r\n<p>Another important aspect of SEO is content creation. Search engines favor websites that have high-quality, relevant, and regularly updated content. By creating content that is relevant to your target audience, you can improve your search engine ranking and attract more visitors to your website. When it comes to web development, content creation is important because it helps to ensure that your website has a clear and consistent message.</p>\r\n\r\n<p>Technical optimization is another important aspect of SEO. This includes optimizing the code of your website, making sure your website is mobile-friendly, and ensuring that your website loads quickly. By optimizing your website&#39;s code, you can improve its performance and make it more search engine friendly. When it comes to web development, technical optimization is important because it ensures that your website is built using the latest technologies and best practices.</p>\r\n\r\n<p>Finally, backlinks are an important aspect of SEO. Backlinks are links from other websites that point to your website. Search engines consider backlinks as a sign of trust and authority, and websites with more backlinks will generally have a higher search engine ranking. When it comes to web development</p>\r\n\r\n<p>, backlinks are important because they can be used to drive traffic to your website. By building relationships with other websites and creating high-quality content, you can attract natural backlinks to your website, which can help to improve your search engine ranking.</p>\r\n\r\n<p>It&#39;s also important to note that SEO is an ongoing process. It&#39;s not something that can be set and forget. You need to continuously monitor and adjust your website to make sure it is up to date with the latest SEO best practices and that it is constantly improving its search engine ranking. This is why it is important to work with a web development team that understands the importance of SEO and can integrate it into the development process.</p>\r\n\r\n<p>In conclusion, web development and SEO are two key components that go hand in hand. By focusing on user experience, content creation, technical optimization, and backlinks, you can optimize your website and improve your online presence. Remember that SEO is an ongoing process and it is important to work with a web development team that understands the importance of SEO and can integrate it into the development process. By following these best practices and utilizing the latest technologies and techniques, you can build a website that is not only visually appealing and user-friendly, but also optimized for search engines and able to drive more traffic and convert more visitors into customers.</p>\r\n<quillbot-extension-portal></quillbot-extension-portal>', 'http://localhost/track_order/storage/app/all_images/FvCqQV16tAFxISS6ETSzPmPQn0io1TINe97jDMzN.jpg', 1, 'published', '2023-01-15 09:16:16', '2023-01-27 23:22:36'),
(4, 2, 'Web Development for Small Businesses: How to Get Started', 'web-development-small-businesses-get-started', '<p>Web development for small businesses is an essential part of building an online presence and growing your business. In today&#39;s digital age, having a website is not just an option, it&#39;s a necessity. A website is a cost-effective and easy way to reach a larger audience and make it easier for customers to find your business.</p>\r\n\r\n<p>Starting a website for your small business can seem overwhelming, but it doesn&#39;t have to be. With the right tools and resources, you can create a website that is user-friendly, visually appealing, and tailored to your business needs. In this guide, we will walk you through the process of starting a web development project for your small business.</p>\r\n\r\n<p>First and foremost, it&#39;s important to understand the different types of web development. There are two main types: front-end development and back-end development. Front-end development is the process of designing and building the user interface of your website, while back-end development is the process of building the functionality of your website.</p>\r\n\r\n<p>For small businesses, it&#39;s recommended to start with front-end development. This includes designing the layout, creating the color scheme, and building the basic functionality of your website. The most popular front-end development tools include HTML, CSS, and JavaScript. These tools are essential for creating a visually appealing website that is easy to navigate.</p>\r\n\r\n<p>Once you have a basic understanding of front-end development, you can start building the functionality of your website. This includes adding forms, buttons, and other interactive elements. The most popular back-end development tools include PHP, Ruby on Rails, and Python. These tools allow you to build a functional website that can handle user input and interact with databases.</p>\r\n\r\n<p>When it comes to choosing a content management system (CMS) for&nbsp;</p>\r\n\r\n<p>your small business website, there are many options available. A CMS is a software that allows you to create and manage the content of your website without needing to know how to code. Some popular options include WordPress, Joomla, and Drupal. WordPress is a great option for small businesses because it is user-friendly, has a large community of developers, and offers a wide range of plugins and themes.</p>\r\n\r\n<p>When designing your website, it&#39;s important to consider the user experience (UX). This includes making sure the website is easy to navigate, visually appealing, and user-friendly. A good UX design will increase the chances of visitors staying on your website and potentially converting into customers.</p>\r\n\r\n<p>Search engine optimization (SEO) is another important aspect of web development for small businesses. SEO is the process of making your website more search engine friendly. This includes optimizing your website&#39;s code, making sure your website is mobile-friendly, and creating high-quality content. By optimizing your website for search engines, you increase the chances of your website appearing on the first page of search engine results.</p>\r\n\r\n<p>When it comes to cost, web development for small businesses can range from a few hundred dollars to several thousand dollars. The cost will depend on the size and complexity of your website, as well as the resources and tools you use. However, it&#39;s important to remember that a website is an investment that can pay off in the long run.</p>\r\n\r\n<p>In conclusion, web development for small businesses is essential for building an online presence and growing your business. By understanding the basics of front-end and back-end development, choosing the right CMS, and considering the user experience and SEO, you can create a website that is tailored to your business needs and helps you reach a larger audience. With the right resources and tools, starting a web development project for your small business can be easy and cost-effective.</p>', 'http://localhost/track_order/storage/app/all_images/FvCqQV16tAFxISS6ETSzPmPQn0io1TINe97jDMzN.jpg', 1, 'published', '2023-01-15 09:17:20', '2023-01-22 07:38:56');

-- --------------------------------------------------------

--
-- Table structure for table `cat`
--

CREATE TABLE `cat` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cat`
--

INSERT INTO `cat` (`id`, `title`, `product_id`) VALUES
(1, 'Linkedin', 1),
(2, 'Marketing', 1);

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `main` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `devices`
--

CREATE TABLE `devices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `device_info` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`device_info`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `devices`
--

INSERT INTO `devices` (`id`, `file_name`, `device_info`, `created_at`, `updated_at`) VALUES
(1, 'abc.pdf', '{\"ip_address\":\"::1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/108.0.0.0 Safari\\/537.36\"}', '2023-01-16 23:48:31', '2023-01-16 23:48:31');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `path`, `created_at`, `updated_at`) VALUES
(1, 'all_images/HAcTUxBZsM1gVuE79A3wsuj5W9pUjN4mUgPZSMHc.png', '2023-01-13 03:09:35', '2023-01-13 03:09:35'),
(2, 'all_images/n7los5y8L0pIlrAcOGKLNkNcG1SqDli8f5OFo7Oe.png', '2023-01-13 03:09:35', '2023-01-13 03:09:35'),
(4, 'all_images/5T5q6Rlj8CfuwfpfFdJtaMFQxv91cgK7Y5YmMBHI.jpg', '2023-01-13 03:09:35', '2023-01-13 03:09:35'),
(5, 'all_images/FvCqQV16tAFxISS6ETSzPmPQn0io1TINe97jDMzN.jpg', '2023-01-13 03:09:35', '2023-01-13 03:09:35'),
(6, 'all_images/xiIF4zmvLeUc45kzroxwCcm2NCeFKHeHlqhUlZI7.jpg', '2023-01-15 08:07:46', '2023-01-15 08:07:46'),
(7, 'all_images/R4FZepENWwo57BiSdezfEgxozb3zVJI8lo5NFV4o.jpg', '2023-01-15 08:07:46', '2023-01-15 08:07:46'),
(8, 'all_images/guzLfRAjspFLDcAb2TVYqnyVDFOFOaMGkPaRaIs3.png', '2023-01-22 00:44:06', '2023-01-22 00:44:06'),
(9, 'all_images/VLj4kLIyKiUGl38l2OPfAJNhpaqoj0Cv5HR5WQS4.png', '2023-01-22 00:44:06', '2023-01-22 00:44:06'),
(10, 'all_images/mv1s8FXqr0kRcGOxll5JWQKLxuu2eBLTm4UryA3p.png', '2023-01-22 00:44:06', '2023-01-22 00:44:06'),
(11, 'all_images/vBb2l9d7uCZWUsavWkSRyQujoZsiLeJrd2TI6F4n.png', '2023-01-22 00:44:06', '2023-01-22 00:44:06'),
(12, 'all_images/KLq0U2qkJsTzOZsrmqTmbh1lgcNkxD7enmROW2NV.png', '2023-01-22 00:44:06', '2023-01-22 00:44:06'),
(13, 'all_images/oYsNaDK7MipLBqZRz8q9YQ3tVY82pVP3NZAcAaPa.png', '2023-01-22 00:44:06', '2023-01-22 00:44:06'),
(14, 'all_images/DwuAXbW67CvMtzX0PA5eQzuw7A8TTWvQB52hGNAU.png', '2023-01-22 00:44:06', '2023-01-22 00:44:06'),
(15, 'all_images/PkP1b4Vi94LHqzvihivNBvQuh2bL33XuofJbbjWT.png', '2023-01-22 00:44:06', '2023-01-22 00:44:06'),
(16, 'all_images/mZA6dTSAhgqmw3O44PRYVp0NyPEmeiq6hHHeMjMQ.png', '2023-01-22 00:44:06', '2023-01-22 00:44:06'),
(17, 'all_images/Frqc1e4SlrXU7hYUVhBzsxEXVG6hSzknXUJHD2vc.png', '2023-01-22 00:44:06', '2023-01-22 00:44:06'),
(18, 'all_images/Yms17heYV3I2S3ZC9tflng2utw0aAUP3MjhXCWWS.png', '2023-01-22 00:44:06', '2023-01-22 00:44:06'),
(19, 'all_images/gg4r2jrmZ2ZSL1599lVq3CHG98fVNcxVwnJuajWm.png', '2023-01-22 00:44:06', '2023-01-22 00:44:06'),
(20, 'all_images/Fg70REMo0RxrAQYlPKmbSeOFcupiABI3s9nS4JEw.png', '2023-01-22 00:44:06', '2023-01-22 00:44:06'),
(21, 'all_images/2qWekIUCfNrRcUEvZAvpUIbQ4v2Le0vNJv5IQ1Z2.png', '2023-01-22 01:15:05', '2023-01-22 01:15:05'),
(22, 'all_images/HxFaSvGeHFb1acVIbHfk5YF7r5BSU96Ke8zDJBJ5.png', '2023-01-22 01:18:10', '2023-01-22 01:18:10'),
(23, 'all_images/ZDyyYcjLOHhX1anypCHGfb1NgpNXIDana2BVI405.png', '2023-01-22 01:18:10', '2023-01-22 01:18:10'),
(24, 'all_images/1V1uQvZkGGeS3P1SO8hM0Wwg65T37qZo3yv8XJAR.png', '2023-01-22 01:18:10', '2023-01-22 01:18:10'),
(28, 'all_images/BQ1pxyq3EhOTBrKWTax6QtFweTiWct2e4CN5pWMh.png', '2023-01-22 02:03:00', '2023-01-22 02:03:00'),
(29, 'all_images/TheB5YhDfjAtOoYSo7LP2Dgh94z7xEVd5HJZePyK.png', '2023-01-22 02:03:00', '2023-01-22 02:03:00'),
(30, 'all_images/z0F3DvxloSRBFPubKP17FYztpNsHU5lsBBAh8pb7.png', '2023-01-22 02:03:00', '2023-01-22 02:03:00'),
(31, 'all_images/CBOev6bhwMK6bALVLQyAtokEHLQ89zbJfWxiUljC.png', '2023-01-24 12:36:40', '2023-01-24 12:36:40'),
(32, 'all_images/ycWIhehHu4nZymzWGlbaK9pgSTZ1oWLukPZmI9XY.png', '2023-01-24 12:36:40', '2023-01-24 12:36:40'),
(33, 'all_images/pJgdFVs4Pwf8PiswXg5fRpSa9Q7cNDs4Q89zMehf.png', '2023-01-24 12:36:40', '2023-01-24 12:36:40'),
(34, 'all_images/UsMU7tC76layHTrjqP2cCtsN6VotPsCy910Z5qfa.png', '2023-01-24 12:36:40', '2023-01-24 12:36:40'),
(36, 'all_images/G4HDHrJ6vUYhn425sdra4eTItIQ4TOYbzxC54Rec.png', '2023-01-24 13:26:27', '2023-01-24 13:26:27'),
(37, 'all_images/uEjSaSS2g8M7QRNV421bqxms7Kj9OxFd059FqSOQ.png', '2023-01-24 13:26:27', '2023-01-24 13:26:27'),
(38, 'all_images/4sEL3aE1tx2BdPgC7BYlLuXE4s23JOjri9HykPaB.png', '2023-01-24 13:28:41', '2023-01-24 13:28:41'),
(39, 'all_images/DpqsEILnPKOjczD0mJ5HicVvbBuYSMO4E5JDcoKo.png', '2023-01-28 05:30:28', '2023-01-28 05:30:28'),
(40, 'all_images/yjtrWU0fyRikSQqHaqKr5Q4b6dw2A2WPiIwo2B6U.jpg', '2023-01-28 05:30:51', '2023-01-28 05:30:51'),
(41, 'all_images/r7Dqoq6PQAJxo3GwHlgHFLuNnCo9kMK4fvAe0kKK.jpg', '2023-01-28 05:37:32', '2023-01-28 05:37:32'),
(42, 'all_images/JnOUMa2aU1QsRXWlFLuvdBlRsqoJb7dIdGpLG87Y.jpg', '2023-01-29 14:21:36', '2023-01-29 14:21:36'),
(43, 'all_images/TD5Qz9ttxudEIIWsLe7bSx7y0CIM06khBsVv1oK0.png', '2023-01-29 14:23:05', '2023-01-29 14:23:05'),
(44, 'all_images/TH3bmPxc283m3XAZxeM4jnSNkGMWycYynUHe0epl.png', '2023-01-29 14:25:35', '2023-01-29 14:25:35'),
(45, 'all_images/SbA12uX8zJfW3F1uSxjOsDJbb5tIaFTqjMm6s7qB.png', '2023-01-30 00:47:27', '2023-01-30 00:47:27');

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
(2, '2019_08_19_000000_create_failed_jobs_table', 1),
(3, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(4, '2022_07_21_075743_create_users_table', 1),
(5, '2022_07_21_075856_create_contact_us_table', 1),
(6, '2022_07_21_075918_create_order_table', 1),
(7, '2022_07_21_075935_create_products_details_table', 1),
(8, '2022_07_21_075935_create_products_table', 1),
(9, '2022_07_21_075935_create_service_details_table', 1),
(10, '2022_07_21_075935_create_services_table', 1),
(11, '2022_07_21_080007_create_order_details_table', 1),
(12, '2022_07_21_080027_create_notifications_table', 1),
(15, '2023_01_13_064607_create_images_table', 4),
(18, '2023_01_12_122957_create_blog_post_table', 5),
(19, '2023_01_13_113256_create_post_meta_table', 5),
(20, '2023_01_13_113353_create_seo_table', 5),
(21, '2023_01_16_115703_create_blog_categories_table', 6),
(22, '2023_01_17_042306_create_devices_table', 7);

-- --------------------------------------------------------

--
-- Table structure for table `notice_board`
--

CREATE TABLE `notice_board` (
  `id` int(11) NOT NULL,
  `desc` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `hr_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notice_board`
--

INSERT INTO `notice_board` (`id`, `desc`, `created_at`, `hr_id`) VALUES
(1, '.', '2023-01-09 12:56:40', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `hr_id` int(11) DEFAULT NULL,
  `roll_id` int(11) DEFAULT NULL,
  `roll_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seen` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'self',
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_option` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `screen_shoot` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_cost` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desc` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `answer` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_status` enum('paid','unpaid') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'paid',
  `order_status` enum('pending','close','open','completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id`, `order_id`, `user_id`, `created_by`, `product_name`, `order_type`, `payment_option`, `screen_shoot`, `document`, `total_cost`, `desc`, `answer`, `payment_status`, `order_status`, `created_at`, `updated_at`) VALUES
(3, 'Q_63d509812629c', 26, 'self', 'web and seo', 'services', NULL, NULL, NULL, NULL, 'adsds', NULL, 'unpaid', 'pending', '2022-12-23 06:39:45', '2023-01-28 06:39:45'),
(9, 'O_63d5447e53240', 26, 'admin', 'e-Books', 'product', 'EasyPaisa', '202301281551New Project (2).png', NULL, '$1.99', NULL, NULL, 'paid', 'completed', '2022-12-28 10:51:26', '2023-01-28 11:06:29'),
(10, 'O_63d54494e3102', 26, 'admin', 'Blog Script', 'product', 'UBL Omni', '202301281551New Project (2).png', NULL, '$22.99', NULL, NULL, 'paid', 'completed', '2023-01-26 19:00:00', '2023-01-28 11:06:21'),
(11, 'O_63d5d8ff5f1ac', 27, 'self', 'e-Books', 'product', 'EasyPaisa', '202301290225New Project (2).png', NULL, '$1.99', NULL, NULL, 'paid', 'pending', '2023-01-28 21:25:03', '2023-01-28 21:25:03'),
(12, 'O_63d5d94cb01df', 27, 'self', 'Blog Script', 'product', 'UBL Omni', '202301290226New Project (2).png', NULL, '$22.99', NULL, NULL, 'paid', 'pending', '2023-01-28 21:26:20', '2023-01-28 21:26:20'),
(13, 'O_63d5d9a7de36d', 27, 'self', 'e-Books', 'product', 'Payoneer', '202301290227New Project (2).png', NULL, '0', NULL, NULL, 'paid', 'pending', '2023-01-28 21:27:51', '2023-01-28 21:27:51'),
(14, 'Q_63d5d9f5d312b', 27, 'self', 'Need Support', 'services', NULL, NULL, NULL, NULL, 'Ready to take the next step with your project? Let us know the details of your project including the type of project, specific requirements, deadline, and budget. Our team will provide you with a personalized quote to help bring your project to life.', NULL, 'unpaid', 'pending', '2023-01-28 21:29:09', '2023-01-28 21:29:09'),
(15, 'Q_63d6d2232051d', 28, 'self', 'fsdfs', 'services', NULL, NULL, NULL, NULL, 'fsfsdffds', NULL, 'unpaid', 'pending', '2023-01-29 15:08:03', '2023-01-29 15:08:03'),
(16, 'O_63d9367e400c6', 28, 'admin', 'e-Books', 'product', 'EasyPaisa', '202301311540WhatsApp Image 2023-01-31 at 3.20.55 PM.jpeg', NULL, '$1.99', NULL, NULL, 'paid', 'pending', '2023-01-31 10:40:46', '2023-01-31 10:40:46'),
(17, 'Q_63d9369598bd4', 28, 'admin', 'dsds', 'services', NULL, NULL, NULL, NULL, 'Ready to take the next step with your project? Let us know the details of your project including the type of project, specific requirements, deadline, and budget. Our team will provide you with a personalized quote to help bring your project to life.', NULL, 'unpaid', 'pending', '2023-01-31 10:41:09', '2023-01-31 10:41:09'),
(18, 'O_63d9371fa03d3', 29, 'self', 'e-Books', 'product', 'EasyPaisa', '202301311543New Project (5).png', NULL, '$1.99', NULL, NULL, 'paid', 'pending', '2023-01-31 10:43:27', '2023-01-31 10:43:27'),
(19, 'Q_63d9373b1cc3e', 30, 'self', NULL, 'services', NULL, NULL, NULL, NULL, 'Ready to take the next step with your project? Let us know the details of your project including the type of project, specific requirements, deadline, and budget. Our team will provide you with a personalized quote to help bring your project to life.', NULL, 'unpaid', 'pending', '2023-01-31 10:43:55', '2023-01-31 10:43:55'),
(20, 'O_63ecccae32fe9', 31, 'self', 'e-Books', 'product', 'EasyPaisa', '2023021512141675020041.jpg', NULL, '$1.99', 'djhakfh jhdjkashkd hhdkashad', NULL, 'paid', 'pending', '2023-02-15 07:14:38', '2023-02-15 07:14:38'),
(21, 'O_63ecccf15d719', 31, 'self', 'e-Books', 'product', 'JazzCash', '2023021512151675020304.png', NULL, '$1.99', 'djhakfh jhdjkashkd hhdkashad', NULL, 'paid', 'pending', '2023-02-15 07:15:45', '2023-02-15 07:15:45');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `cost` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `joining_link` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `item_id`, `cost`, `qty`, `joining_link`, `created_at`, `updated_at`) VALUES
(1, '1', 1, '1', 1, 'http://localhost/younasdev/public/products_detials/202301281035Becoming a Web Designer.pdf', '2023-01-28 05:39:59', '2023-01-28 05:39:59'),
(2, '2', 1, '1', 1, 'http://localhost/younasdev/public/products_detials/202301281035Becoming a Web Designer.pdf', '2023-01-28 05:47:12', '2023-01-28 05:47:12'),
(3, '2', 3, '1', 1, 'http://localhost/younasdev/storage/app/all_images/G4HDHrJ6vUYhn425sdra4eTItIQ4TOYbzxC54Rec.png', '2023-01-28 05:47:12', '2023-01-28 05:47:12'),
(4, '5', 3, '25', 1, NULL, '2023-01-28 09:58:31', '2023-01-28 09:58:31'),
(5, '6', 2, '22.99', 1, NULL, '2023-01-28 10:39:23', '2023-01-28 10:39:23'),
(6, '7', 2, '22.99', 1, NULL, '2023-01-28 10:42:14', '2023-01-28 10:42:14'),
(7, '8', 2, '22.99', 1, NULL, '2023-01-28 10:42:43', '2023-01-28 10:42:43'),
(8, '9', 1, '1.99', 1, 'http://localhost/younasdev/public/products_detials/202301281035Becoming a Web Designer.pdf', '2023-01-28 10:51:26', '2023-01-28 10:51:26'),
(9, '10', 2, '22.99', 1, 'http://localhost/younasdev/public/products_detials/202301281038202301280517dazzle.zip', '2023-01-28 10:51:48', '2023-01-28 10:51:48'),
(10, '11', 1, '1.99', 1, NULL, '2023-01-28 21:25:03', '2023-01-28 21:25:03'),
(11, '12', 2, '22.99', 1, NULL, '2023-01-28 21:26:20', '2023-01-28 21:26:20'),
(12, '13', 1, '1.99', 1, NULL, '2023-01-28 21:27:51', '2023-01-28 21:27:51'),
(13, '16', 1, '1.99', 1, NULL, '2023-01-31 10:40:46', '2023-01-31 10:40:46'),
(14, '18', 1, '1.99', 1, NULL, '2023-01-31 10:43:27', '2023-01-31 10:43:27'),
(15, '20', 1, '1.99', 1, NULL, '2023-02-15 07:14:38', '2023-02-15 07:14:38'),
(16, '21', 1, '1.99', 1, NULL, '2023-02-15 07:15:45', '2023-02-15 07:15:45');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `post_meta`
--

CREATE TABLE `post_meta` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `blog_post_id` bigint(20) UNSIGNED NOT NULL,
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `post_meta`
--

INSERT INTO `post_meta` (`id`, `blog_post_id`, `meta_key`, `meta_value`, `created_at`, `updated_at`) VALUES
(4, 4, 'author', 'Younas dev', '2023-01-15 09:21:53', '2023-01-22 07:12:35'),
(5, 2, 'abc', 'abcds', '2023-01-15 09:25:55', '2023-01-15 09:25:55'),
(6, 4, 'date', '2022-01-22', '2023-01-22 07:14:16', '2023-01-22 07:14:16'),
(7, 4, 'category', 'web development', '2023-01-22 07:14:48', '2023-01-22 07:14:48');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desc` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `image`, `name`, `desc`, `status`, `website`, `created_at`, `updated_at`) VALUES
(1, 'http://localhost/younasdev/storage/app/all_images/G4HDHrJ6vUYhn425sdra4eTItIQ4TOYbzxC54Rec.png', 'e-Books', 'Improve your digital skills and increase your earning potential with our collection of e-books and Notion notes. Our topics include social media growth, cold email strategies, email templates, digital product creation, case studies, SEO, marketing, web development, remote job opportunities and personal branding. These resources are designed to provide you with the knowledge and tools to succeed in today\'s digital landscape. Start learning and earning today!', '1', 'www.abc.com', '2023-01-14 13:20:59', '2023-01-28 06:25:23'),
(2, 'http://localhost/younasdev/storage/app/all_images/uEjSaSS2g8M7QRNV421bqxms7Kj9OxFd059FqSOQ.png', 'Blog Script', 'Are you looking to start your own blog? Our Blog Script is a user-friendly platform that allows you to easily create and manage your own blog. With customizable templates, SEO optimization, and easy integration with social media, it\'s the perfect solution for bloggers of all levels. Whether you\'re a beginner or a pro, our Blog Script has everything you need to launch and grow your blog. So why wait? Click the link below to start your blogging journey today!', '1', 'www.abc.com', '2023-01-14 13:20:59', '2023-01-28 06:26:28');

-- --------------------------------------------------------

--
-- Table structure for table `products_detials`
--

CREATE TABLE `products_detials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cat_id` int(11) DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `source` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `product_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desc` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products_detials`
--

INSERT INTO `products_detials` (`id`, `product_id`, `cat_id`, `image`, `image_2`, `name`, `source`, `price`, `product_type`, `desc`, `status`, `created_at`, `updated_at`) VALUES
(1, '1', 1, 'http://localhost/younasdev/storage/app/all_images/SbA12uX8zJfW3F1uSxjOsDJbb5tIaFTqjMm6s7qB.png', 'http://localhost/younasdev/storage/app/all_images/TH3bmPxc283m3XAZxeM4jnSNkGMWycYynUHe0epl.png', 'Become A Web Designers', 'http://localhost/younasdev/public/products_detials/202301281035Becoming a Web Designer.pdf', '1.99', 'pdf', '<p><tt><small>The e-book &quot;Becoming a Web Designer: A Step-by-Step Guide to Learning and Landing Your Dream Job&quot; is a comprehensive guide to understanding the skills and knowledge required to become a successful web designer. Written by Younas, a web developer with 4 years of experience, this e-book provides all the resources you need to start your journey in the web design industry.</small></tt></p>\r\n\r\n<p><tt><small>One of the biggest benefits of this e-book is that it will save you time by providing a structured and easy-to-follow guide that covers everything from learning the fundamentals of web design to building a strong portfolio, networking, and landing your dream job. Additionally, the book is written in Urdu and Hindi, which makes it accessible to students who may not be fluent in English.</small></tt></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><tt><small><big>Outline of the book:</big></small></tt></h3>\r\n\r\n<ol>\r\n	<li><strong><tt><small>Introduction: Understanding What it Takes to Become a Web Designer</small></tt></strong></li>\r\n	<li><strong><tt><small>Learning the Fundamentals of Web Design: HTML, CSS, and JavaScript</small></tt></strong></li>\r\n	<li><strong><tt><small>Mastering Design Principles and Best Practices</small></tt></strong></li>\r\n	<li><strong><tt><small>Building a Strong Portfolio to Showcase Your Skills</small></tt></strong></li>\r\n	<li><strong><tt><small>Networking and Finding Job Opportunities</small></tt></strong></li>\r\n	<li><strong><tt><small>Preparing for Job Interviews and the Hiring Process</small></tt></strong></li>\r\n	<li><strong><tt><small>Continuing Education and Staying Up-to-Date with the Latest Trends and Technologies</small></tt></strong></li>\r\n	<li><strong><tt><small>Landing Your Dream Job and Succeeding in the Web Design Industry</small></tt></strong></li>\r\n	<li><strong><tt><small>Conclusion: Tips for Long-term Success as a Web Designer</small></tt></strong></li>\r\n</ol>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><small><tt>Introduction: Understanding What it Takes to Become a Web Designer:</tt></small></h3>\r\n\r\n<p><small>Understanding What it Takes to Become a Web Designer - This chapter provides an overview of the web design industry and the skills and knowledge required to become a successful web designer.</small></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><small><tt>Learning the Fundamentals of Web Design: HTML, CSS, and JavaScript:</tt></small></h3>\r\n\r\n<p><small>This chapter covers the basics of HTML, CSS, and JavaScript, which are the building blocks of web design.</small></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><small><tt>Mastering Design Principles and Best Practices:</tt></small></h3>\r\n\r\n<p><small>This chapter teaches the key design principles and best practices that are essential for creating visually appealing and user-friendly websites.</small></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><small><tt>Building a Strong Portfolio to Showcase Your Skills:</tt></small></h3>\r\n\r\n<p><small>This chapter provides tips and advice on how to create a portfolio that showcases your skills and attracts potential employers.</small></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><small><tt>Networking and Finding Job Opportunities:</tt></small></h3>\r\n\r\n<p><small>This chapter covers the importance of networking and provides strategies for finding job opportunities in the web design industry.</small></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><small><tt>Preparing for Job Interviews and the Hiring Process:</tt></small></h3>\r\n\r\n<p><small>This chapter covers the steps you need to take to prepare for job interviews and navigate the hiring process.</small></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><small><tt>Continuing Education and Staying Up-to-Date with the Latest Trends and Technologies:</tt></small></h3>\r\n\r\n<p><small>This chapter covers the importance of continuing education and staying up-to-date with the latest trends and technologies in the web design industry.</small></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><tt><small>Landing Your Dream Job and Succeeding in the Web Design Industry:</small></tt></h3>\r\n\r\n<p><small>This chapter provides tips and advice on how to land your dream job and succeed in the web design industry.</small></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><small><tt>Conclusion: Tips for Long-term Success as a Web Designer:</tt></small></h3>\r\n\r\n<p><small>This chapter provides a summary of the key takeaways from the book and offers tips for long-term success as a web designer.</small></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n<quillbot-extension-portal></quillbot-extension-portal>', '1', '2023-01-28 05:35:07', '2023-01-30 00:47:41'),
(2, '2', NULL, 'http://localhost/younasdev/storage/app/all_images/r7Dqoq6PQAJxo3GwHlgHFLuNnCo9kMK4fvAe0kKK.jpg', 'http://localhost/younasdev/storage/app/all_images/r7Dqoq6PQAJxo3GwHlgHFLuNnCo9kMK4fvAe0kKK.jpg', 'Blogging Website', 'http://localhost/younasdev/public/products_detials/202301281038202301280517dazzle.zip', '22.99', 'sourcecode', '<p>The e-book &quot;Becoming a Web Designer: A Step-by-Step Guide to Learning and Landing Your Dream Job&quot; is a comprehensive guide to understanding the skills and knowledge required to become a successful web designer. Written by Younas, a web developer with 4 years of experience, this e-book provides all the resources you need to start your journey in the web design industry.<br />\r\n<br />\r\nOne of the biggest benefits of this e-book is that it will save you time by providing a structured and easy-to-follow guide that covers everything from learning the fundamentals of web design to building a strong portfolio, networking, and landing your dream job. Additionally, the book is written in Urdu and Hindi, which makes it accessible to students who may not be fluent in English.</p>\r\n\r\n<p>Outline of the book:</p>\r\n\r\n<ul>\r\n	<li>Introduction: Understanding What it Takes to Become a Web Designer</li>\r\n	<li>Learning the Fundamentals of Web Design: HTML, CSS, and JavaScript</li>\r\n	<li>Mastering Design Principles and Best Practices</li>\r\n	<li>Building a Strong Portfolio to Showcase Your Skills</li>\r\n	<li>Networking and Finding Job Opportunities</li>\r\n	<li>Preparing for Job Interviews and the Hiring Process</li>\r\n	<li>Continuing Education and Staying Up-to-Date with the Latest Trends and Technologies</li>\r\n	<li>Landing Your Dream Job and Succeeding in the Web Design Industry</li>\r\n	<li>Conclusion: Tips for Long-term Success as a Web Designer</li>\r\n</ul>\r\n\r\n<p>Introduction: Understanding What it Takes to Become a Web Designer:</p>\r\n\r\n<p>Understanding What it Takes to Become a Web Designer - This chapter provides an overview of the web design industry and the skills and knowledge required to become a successful web designer.</p>\r\n\r\n<p>Learning the Fundamentals of Web Design: HTML, CSS, and JavaScript:</p>\r\n\r\n<p>This chapter covers the basics of HTML, CSS, and JavaScript, which are the building blocks of web design.</p>\r\n\r\n<p>Mastering Design Principles and Best Practices:</p>\r\n\r\n<p>This chapter teaches the key design principles and best practices that are essential for creating visually appealing and user-friendly websites.</p>\r\n\r\n<p>Building a Strong Portfolio to Showcase Your Skills:</p>\r\n\r\n<p>This chapter provides tips and advice on how to create a portfolio that showcases your skills and attracts potential employers.</p>\r\n\r\n<p>Networking and Finding Job Opportunities:</p>\r\n\r\n<p>This chapter covers the importance of networking and provides strategies for finding job opportunities in the web design industry.</p>\r\n\r\n<p>Preparing for Job Interviews and the Hiring Process:</p>\r\n\r\n<p>This chapter covers the steps you need to take to prepare for job interviews and navigate the hiring process.</p>\r\n\r\n<p>Continuing Education and Staying Up-to-Date with the Latest Trends and Technologies:</p>\r\n\r\n<p>This chapter covers the importance of continuing education and staying up-to-date with the latest trends and technologies in the web design industry.</p>\r\n\r\n<p>Landing Your Dream Job and Succeeding in the Web Design Industry:</p>\r\n\r\n<p>This chapter provides tips and advice on how to land your dream job and succeed in the web design industry.</p>\r\n\r\n<p>Conclusion: Tips for Long-term Success as a Web Designer:</p>\r\n\r\n<p>This chapter provides a summary of the key takeaways from the book and offers tips for long-term success as a web designer.</p>\r\n<quillbot-extension-portal></quillbot-extension-portal>', '1', '2023-01-28 05:38:22', '2023-01-28 05:38:22'),
(5, '1', 2, 'http://localhost/younasdev/storage/app/all_images/SbA12uX8zJfW3F1uSxjOsDJbb5tIaFTqjMm6s7qB.png', 'http://localhost/younasdev/storage/app/all_images/TH3bmPxc283m3XAZxeM4jnSNkGMWycYynUHe0epl.png', 'Best Content for linkedin', 'http://localhost/younasdev/public/products_detials/202301281035Becoming a Web Designer.pdf', '1.99', 'pdf', '<p><tt><small>The e-book &quot;Becoming a Web Designer: A Step-by-Step Guide to Learning and Landing Your Dream Job&quot; is a comprehensive guide to understanding the skills and knowledge required to become a successful web designer. Written by Younas, a web developer with 4 years of experience, this e-book provides all the resources you need to start your journey in the web design industry.</small></tt></p>\r\n\r\n<p><tt><small>One of the biggest benefits of this e-book is that it will save you time by providing a structured and easy-to-follow guide that covers everything from learning the fundamentals of web design to building a strong portfolio, networking, and landing your dream job. Additionally, the book is written in Urdu and Hindi, which makes it accessible to students who may not be fluent in English.</small></tt></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><tt><small><big>Outline of the book:</big></small></tt></h3>\r\n\r\n<ol>\r\n	<li><strong><tt><small>Introduction: Understanding What it Takes to Become a Web Designer</small></tt></strong></li>\r\n	<li><strong><tt><small>Learning the Fundamentals of Web Design: HTML, CSS, and JavaScript</small></tt></strong></li>\r\n	<li><strong><tt><small>Mastering Design Principles and Best Practices</small></tt></strong></li>\r\n	<li><strong><tt><small>Building a Strong Portfolio to Showcase Your Skills</small></tt></strong></li>\r\n	<li><strong><tt><small>Networking and Finding Job Opportunities</small></tt></strong></li>\r\n	<li><strong><tt><small>Preparing for Job Interviews and the Hiring Process</small></tt></strong></li>\r\n	<li><strong><tt><small>Continuing Education and Staying Up-to-Date with the Latest Trends and Technologies</small></tt></strong></li>\r\n	<li><strong><tt><small>Landing Your Dream Job and Succeeding in the Web Design Industry</small></tt></strong></li>\r\n	<li><strong><tt><small>Conclusion: Tips for Long-term Success as a Web Designer</small></tt></strong></li>\r\n</ol>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><small><tt>Introduction: Understanding What it Takes to Become a Web Designer:</tt></small></h3>\r\n\r\n<p><small>Understanding What it Takes to Become a Web Designer - This chapter provides an overview of the web design industry and the skills and knowledge required to become a successful web designer.</small></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><small><tt>Learning the Fundamentals of Web Design: HTML, CSS, and JavaScript:</tt></small></h3>\r\n\r\n<p><small>This chapter covers the basics of HTML, CSS, and JavaScript, which are the building blocks of web design.</small></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><small><tt>Mastering Design Principles and Best Practices:</tt></small></h3>\r\n\r\n<p><small>This chapter teaches the key design principles and best practices that are essential for creating visually appealing and user-friendly websites.</small></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><small><tt>Building a Strong Portfolio to Showcase Your Skills:</tt></small></h3>\r\n\r\n<p><small>This chapter provides tips and advice on how to create a portfolio that showcases your skills and attracts potential employers.</small></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><small><tt>Networking and Finding Job Opportunities:</tt></small></h3>\r\n\r\n<p><small>This chapter covers the importance of networking and provides strategies for finding job opportunities in the web design industry.</small></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><small><tt>Preparing for Job Interviews and the Hiring Process:</tt></small></h3>\r\n\r\n<p><small>This chapter covers the steps you need to take to prepare for job interviews and navigate the hiring process.</small></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><small><tt>Continuing Education and Staying Up-to-Date with the Latest Trends and Technologies:</tt></small></h3>\r\n\r\n<p><small>This chapter covers the importance of continuing education and staying up-to-date with the latest trends and technologies in the web design industry.</small></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><tt><small>Landing Your Dream Job and Succeeding in the Web Design Industry:</small></tt></h3>\r\n\r\n<p><small>This chapter provides tips and advice on how to land your dream job and succeed in the web design industry.</small></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h3><small><tt>Conclusion: Tips for Long-term Success as a Web Designer:</tt></small></h3>\r\n\r\n<p><small>This chapter provides a summary of the key takeaways from the book and offers tips for long-term success as a web designer.</small></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n<quillbot-extension-portal></quillbot-extension-portal>', '1', '2023-01-28 05:35:07', '2023-01-30 00:47:41');

-- --------------------------------------------------------

--
-- Table structure for table `seo`
--

CREATE TABLE `seo` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `blog_post_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `keywords` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `seo`
--

INSERT INTO `seo` (`id`, `blog_post_id`, `title`, `description`, `keywords`, `created_at`, `updated_at`) VALUES
(2, 4, 'Web Development for Small Businesses: A Beginner\'s Guide to Starting Your Online Presence', 'Learn how to get started with web development for small businesses. This guide will show you how to create a cost-effective, easy and user-friendly website that will help you build your online presence and grow your business.', 'web development, small businesses, start, guide, website, online presence, cost-effective, easy, simple, beginner-friendly, user-friendly, business website.', '2023-01-15 09:28:03', '2023-01-22 07:37:27'),
(3, 2, 'Optimize Your Website for Search Engines: A Guide to Web Development and SEO', 'Learn how to optimize your website for search engines with this guide to web development and SEO. Discover how to improve your online presence and search engine ranking by focusing on user experience, content creation, technical optimization, and backlinks.', 'web development, SEO, optimize, website, online presence, search engine ranking, user experience, content creation, technical optimization, backlinks', '2023-01-22 07:57:14', '2023-01-22 07:57:14');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desc` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `image`, `name`, `desc`, `status`, `website`, `created_at`, `updated_at`) VALUES
(1, 'http://localhost/track_order/storage/app/all_images/UsMU7tC76layHTrjqP2cCtsN6VotPsCy910Z5qfa.png', 'Website', 'Our web development services include the design, creation, and maintenance of websites. We can work with you to develop a website from scratch or update an existing one. Our team is proficient in a variety of programming languages and frameworks, including HTML, CSS, JavaScript, and PHP. We also have experience with content management systems such as WordPress and can assist with the integration of various features and functionalities.', '1', 'service/website', NULL, NULL),
(2, 'http://localhost/track_order/storage/app/all_images/ycWIhehHu4nZymzWGlbaK9pgSTZ1oWLukPZmI9XY.png', 'SEO', 'Our SEO (Search Engine Optimization) services help to improve the visibility and ranking of your website in search engines like Google. We can optimize your website\'s content, structure, and technical aspects to make it more attractive to search engines and improve its ranking in search results.\n', '1', 'service/SEO', NULL, NULL),
(3, 'http://localhost/track_order/storage/app/all_images/pJgdFVs4Pwf8PiswXg5fRpSa9Q7cNDs4Q89zMehf.png', 'Marketing', 'Our marketing services aim to help you promote your business and increase brand awareness. We offer a range of marketing strategies, including social media marketing, email marketing, and content marketing. We can also help you with market research and analysis to better understand your target audience and how to effectively reach them.', '1', 'service/marketing', NULL, NULL),
(4, 'http://localhost/track_order/storage/app/all_images/CBOev6bhwMK6bALVLQyAtokEHLQ89zbJfWxiUljC.png', 'Support', 'Our support services include assistance with technical issues and troubleshooting for your website or other online resources. We can also provide guidance and advice on how to best use and maintain your online assets. Our team is available to answer your questions and provide support as needed.', '1', 'service/support', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `service_details`
--

CREATE TABLE `service_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `service_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `desc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hr_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dc_password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `roll` enum('user','hr') COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` bigint(20) DEFAULT NULL,
  `alternate_phone` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `hr_id`, `name`, `email`, `profile_image`, `password`, `dc_password`, `roll`, `address`, `phone`, `alternate_phone`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Younas Dev', 'admin@admin.com', '202301311633Temp-1000x1000__3_-removebg-preview.gif', '$2y$10$znCnX5AkQTy2Vmr6tzxxvuVq20qP2E.hVXCSqRKXV.Tz9SjRAccrq', 'Apple2022', 'hr', 'kacha khuh abc', 923047222723, 923047222723, '2022-07-22 12:12:02', '2023-01-31 11:33:31'),
(7, 1, 'Asad', 'asad@gmail.com', '202210180758photo-1607990281513-2c110a25bd8c.jpg', '$2y$10$EcHUI/UgbnaRVmiBhwYUB.aH5ohTaJDxmBHNcVr9szdfjpjXPoRFC', '121212', 'user', 'pk. lahore, Lorem ipsum dolor sit amet, consectetur', 1111111111, 1111111111, '2022-07-26 14:50:21', '2023-01-18 10:42:23'),
(9, 1, 'Daniel', 'phpfiverrpk@gmail.com', 'Zoe-Laverne-profile-1 (2).jpg', '$2y$10$vTmevCy5bWSDu7d2ZSPUruvFq.Tn7ogxrvXRIT.hDGRKeZpuW7J0C', 'D0vO4W', 'user', 'fssdsds', 3232323, 323233, '2022-08-01 00:12:21', '2023-01-18 10:57:08'),
(26, NULL, 'johen', 'johen@gmail.com', '202301281228broker-agent-real-estate.jpg', '$2y$10$etM/4hUj5dfxdYJhC44puO5vU9FrICQtOkO0QxVAlKHH2ZSw97nda', 'fgbnAR', 'user', 'kacha khuh', 7291379273, 7291379273, '2023-01-28 05:39:59', '2023-01-28 07:28:40'),
(27, NULL, 'aj', 'aj@gmail.com', NULL, '$2y$10$keLVvqi2aee.7nLotYp6Q.LvuN6RJwIh.NuI9bEZFuYq4Bv8f.Jx.', 'HIcH0J', 'user', NULL, 344444444, NULL, '2023-01-28 21:25:03', '2023-01-28 21:25:03'),
(28, NULL, 'dsds', 'dssd@gmail.com', NULL, '$2y$10$2bbYcdUIYWUdy1g1krMtYOQpJQFRcMKuJCnygi81F9T6S51YxMopC', 'BkCJTE', 'user', NULL, 432432, NULL, '2023-01-29 15:08:03', '2023-01-29 15:08:03'),
(29, NULL, 'fafdafda', 'fdafafa@gmail.com', NULL, '$2y$10$S4QG7UxreBVc1fGOGM2//uSYL9Ptz3Y/UvcyntMcZu48QGpzJZ3B6', 'HhA5ZP', 'user', NULL, 923047222723, NULL, '2023-01-31 10:43:27', '2023-01-31 10:43:27'),
(30, NULL, 'rerewrw', 'dasdsadas@gmail.com', NULL, '$2y$10$SOD4XWaMy5zfXj/FEuxG1eAlN2G70ybM/OW16FLXqjbOkFlJSU3xm', 'nSPChz', 'user', NULL, 923047222723, NULL, '2023-01-31 10:43:55', '2023-01-31 10:43:55'),
(31, NULL, 'Younas Mahmood', 'hm.younas221@gmail.com', NULL, '$2y$10$3rU9vLYMGGTPL9Tdt2JjM.jtLedB1YB5SP6NyPI6eVQIyqG6Yqz6a', 'KvFuqs', 'user', NULL, 3047222723, NULL, '2023-02-15 07:14:38', '2023-02-15 07:14:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `blog_posts_slug_unique` (`slug`),
  ADD KEY `blog_posts_user_id_foreign` (`user_id`);

--
-- Indexes for table `cat`
--
ALTER TABLE `cat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notice_board`
--
ALTER TABLE `notice_board`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `post_meta`
--
ALTER TABLE `post_meta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_meta_blog_post_id_foreign` (`blog_post_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products_detials`
--
ALTER TABLE `products_detials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seo`
--
ALTER TABLE `seo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seo_blog_post_id_foreign` (`blog_post_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_details`
--
ALTER TABLE `service_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blog_categories`
--
ALTER TABLE `blog_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cat`
--
ALTER TABLE `cat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `devices`
--
ALTER TABLE `devices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `notice_board`
--
ALTER TABLE `notice_board`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post_meta`
--
ALTER TABLE `post_meta`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products_detials`
--
ALTER TABLE `products_detials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `seo`
--
ALTER TABLE `seo`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `service_details`
--
ALTER TABLE `service_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD CONSTRAINT `blog_posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `post_meta`
--
ALTER TABLE `post_meta`
  ADD CONSTRAINT `post_meta_blog_post_id_foreign` FOREIGN KEY (`blog_post_id`) REFERENCES `blog_posts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `seo`
--
ALTER TABLE `seo`
  ADD CONSTRAINT `seo_blog_post_id_foreign` FOREIGN KEY (`blog_post_id`) REFERENCES `blog_posts` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
