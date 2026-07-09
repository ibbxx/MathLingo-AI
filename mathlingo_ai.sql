-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 09, 2026 at 07:57 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mathlingo_ai`
--

-- --------------------------------------------------------

--
-- Table structure for table `achievements`
--

CREATE TABLE `achievements` (
  `id` bigint UNSIGNED NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `category` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Learning',
  `badge_icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#2563EB',
  `rarity` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'common',
  `requirement_type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requirement_value` int NOT NULL DEFAULT '1',
  `is_hidden` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `xp_reward` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ai_conversations`
--

CREATE TABLE `ai_conversations` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT 'New Conversation',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `ai_conversations`
--

INSERT INTO `ai_conversations` (`id`, `user_id`, `title`, `created_at`, `updated_at`) VALUES
(7, 2, 'Membaca notasi matematika dalam bahasa Inggris', '2026-06-27 17:24:52', '2026-06-27 17:24:58'),
(8, 2, 'Math Help for Basic Concepts', '2026-06-28 00:54:56', '2026-06-28 00:56:11'),
(10, 2, 'Membaca Notasi Matematika Bahasa Inggris', '2026-06-28 07:08:39', '2026-06-28 07:08:43'),
(11, 2, 'Membaca Notasi Matematika ∀x ∈ ℝ dalam Bahasa Inggris \n\nTer', '2026-06-28 22:27:43', '2026-06-28 22:30:35'),
(12, 2, 'Membaca Notasi Matematika ∀x ∈ ℝ', '2026-06-29 00:06:26', '2026-06-29 00:06:29'),
(13, 6, 'Decomposisi Matriks dalam Matematika', '2026-07-04 03:28:40', '2026-07-04 03:28:45'),
(14, 2, 'Perbedaan Theorem dan Lemma Matematika', '2026-07-07 22:26:59', '2026-07-07 22:27:08'),
(15, 2, 'Decomposisi Matriks dalam Matematika', '2026-07-08 04:02:41', '2026-07-08 04:03:08'),
(16, 2, 'Membaca Notasi Matematika', '2026-07-08 22:14:31', '2026-07-08 22:14:41');

-- --------------------------------------------------------

--
-- Table structure for table `ai_messages`
--

CREATE TABLE `ai_messages` (
  `id` bigint UNSIGNED NOT NULL,
  `conversation_id` bigint UNSIGNED NOT NULL,
  `role` enum('user','assistant','system') NOT NULL,
  `content` longtext NOT NULL,
  `tokens` int UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `ai_messages`
--

INSERT INTO `ai_messages` (`id`, `conversation_id`, `role`, `content`, `tokens`, `created_at`, `updated_at`) VALUES
(47, 7, 'user', 'Bagaimana cara membaca notasi \"∀x ∈ ℝ\" dalam Bahasa Inggris?', 0, '2026-06-27 17:24:53', '2026-06-27 17:24:53'),
(48, 7, 'assistant', 'Notasi \"∀x ∈ ℝ\" dibaca sebagai: \"**For all x in the set of real numbers**\" atau secara singkat \"**For all real x**\".\n\nDalam notasi ini:\n- **∀** (dibaca \"for all\") adalah simbol logika yang menunjukkan bahwa pernyataan yang mengikutinya berlaku untuk semua elemen dalam himpunan yang ditentukan.\n- **x** adalah variabel yang mewakili elemen dalam himpunan.\n- **∈** (dibaca \"is an element of\" atau \"belongs to\") menunjukkan keanggotaan dalam himpunan.\n- **ℝ** (dibaca \"the set of real numbers\" atau \"the reals\") adalah himpunan yang terdiri dari semua bilangan real, termasuk bilangan rasional dan irasional.\n\nJadi, notasi \"∀x ∈ ℝ\" digunakan dalam konteks matematika untuk membuat pernyataan yang berlaku untuk semua bilangan real. Contohnya, \"∀x ∈ ℝ, x² ≥ 0\" dibaca sebagai \"**For all real x, x squared is greater than or equal to zero**\".', 159, '2026-06-27 17:24:58', '2026-06-27 17:24:58'),
(49, 8, 'user', 'halo kawan, nama saya siapa', 0, '2026-06-28 00:54:57', '2026-06-28 00:54:57'),
(50, 8, 'assistant', 'Halo kawan! Saya tidak bisa mengenal nama Anda karena kita baru saja mulai berinteraksi. Namun, saya bisa memperkenalkan diri saya sebagai MathLingo AI Tutor, asisten pembelajaran matematika dan bahasa Inggris matematika. Saya di sini untuk membantu Anda memahami konsep matematika dan meningkatkan kemampuan bahasa Inggris Anda dalam konteks matematika.\n\nJika Anda ingin berbagi nama Anda, saya dengan senang hati akan menyambut Anda dan membantu Anda dengan pertanyaan atau topik matematika yang Anda inginkan!', 94, '2026-06-28 00:55:00', '2026-06-28 00:55:00'),
(51, 8, 'user', 'nama saya miftah', 0, '2026-06-28 00:55:11', '2026-06-28 00:55:11'),
(52, 8, 'assistant', 'Selamat datang, Miftah! Saya senang bertemu denganmu dan membantu kamu dalam memahami konsep matematika dan meningkatkan kemampuan bahasa Inggris matematika.\n\nSekarang, apa yang ingin kamu pelajari atau diskusikan hari ini? Apakah kamu memiliki pertanyaan tentang suatu topik matematika tertentu, atau mungkin ingin mempraktikkan soal-soal matematika? Saya di sini untuk membantu! \n\n> **Pilihlah salah satu opsi berikut:**\n1. **Pertanyaan matematika**: tanyakan tentang konsep matematika yang ingin kamu ketahui.\n2. **Soal matematika**: kerjakan soal matematika bersama saya.\n3. **Bahasa Inggris matematika**: pelajari istilah-istilah matematika dalam bahasa Inggris.\n\nPilihlah opsi yang kamu inginkan, Miftah!', 113, '2026-06-28 00:55:12', '2026-06-28 00:55:12'),
(55, 8, 'user', 'tips agar jago berbahasa ingris matematik', 0, '2026-06-28 00:55:46', '2026-06-28 00:55:46'),
(56, 8, 'assistant', 'Berikut beberapa tips untuk meningkatkan kemampuan berbahasa Inggris matematika:\n\n1. **Pelajari istilah-istilah matematika dalam bahasa Inggris**: Mulai dengan mempelajari istilah-istilah dasar matematika dalam bahasa Inggris, seperti **variable** (variabel), **function** (fungsi), **equation** (persamaan), dan **inequality** (ketidaksamaan).\n2. **Baca buku teks matematika dalam bahasa Inggris**: Membaca buku teks matematika dalam bahasa Inggris dapat membantu kamu memahami konsep matematika dan mempelajari istilah-istilah matematika dalam konteks yang benar.\n3. **Praktikkan dengan soal-soal matematika**: Kerjakan soal-soal matematika dalam bahasa Inggris untuk mempraktikkan kemampuan berbahasa Inggris matematika kamu.\n4. **Tonton video matematika dalam bahasa Inggris**: Menonton video matematika dalam bahasa Inggris dapat membantu kamu memahami konsep matematika dan mempelajari istilah-istilah matematika dalam konteks yang benar.\n5. **Berlatih dengan teman atau tutor**: Berlatih dengan teman atau tutor dapat membantu kamu mempraktikkan kemampuan berbahasa Inggris matematika kamu dan memperoleh umpan balik yang berguna.\n6. **Gunakan sumber daya online**: Ada banyak sumber daya online yang tersedia untuk membantu kamu meningkatkan kemampuan berbahasa Inggris matematika, seperti **Khan Academy**, **MIT OpenCourseWare**, dan **Mathway**.\n7. **Fokus pada struktur kalimat**: Berbahasa Inggris matematika memerlukan struktur kalimat yang benar, jadi pastikan kamu memahami bagaimana menyusun kalimat yang benar dan efektif.\n8. **Pelajari sinonim dan antonim**: Memahami sinonim dan antonim dapat membantu kamu memperluas kosakata matematika kamu dan meningkatkan kemampuan berbahasa Inggris matematika.\n\n> **Contoh istilah matematika dalam bahasa Inggris:**\n* **Algebra**: aljabar\n* **Geometry**: geometri\n* **Calculus**: kalkulus\n* **Statistics**: statistik\n* **Probability**: probabilitas\n\nDengan mengikuti tips di atas, kamu dapat meningkatkan kemampuan berbahasa Inggris matematika kamu dan menjadi lebih percaya diri dalam memahami konsep matematika dalam bahasa Inggris.\n\nApakah kamu memiliki pertanyaan tentang tips di atas, Miftah?', 325, '2026-06-28 00:55:48', '2026-06-28 00:55:48'),
(57, 8, 'user', 'buku apa yang bagus saya baca untuk belajar bahasa ingris matematika', 0, '2026-06-28 00:56:09', '2026-06-28 00:56:09'),
(58, 8, 'assistant', 'Berikut beberapa buku yang bagus untuk belajar bahasa Inggris matematika:\n\n1. **\"A First Course in Calculus\" oleh Michael Spivak**: Buku ini adalah salah satu buku teks matematika yang paling populer dan dapat membantu kamu memahami konsep kalkulus dalam bahasa Inggris.\n2. **\"Algebra\" oleh Michael Artin**: Buku ini adalah buku teks aljabar yang komprehensif dan dapat membantu kamu memahami konsep aljabar dalam bahasa Inggris.\n3. **\"Geometry: A Comprehensive Introduction\" oleh Dan Pedoe**: Buku ini adalah buku teks geometri yang komprehensif dan dapat membantu kamu memahami konsep geometri dalam bahasa Inggris.\n4. **\"Statistics: A Guide to the Unknown\" oleh Judith M. Tanur**: Buku ini adalah buku teks statistik yang dapat membantu kamu memahami konsep statistik dalam bahasa Inggris.\n5. **\"Mathematics: A Human Approach\" oleh Harold R. Jacobs**: Buku ini adalah buku teks matematika yang dapat membantu kamu memahami konsep matematika dalam bahasa Inggris dan juga memberikan contoh-contoh aplikasi matematika dalam kehidupan sehari-hari.\n6. **\"The Language of Mathematics\" oleh Sol Garfunkel dan David Mumford**: Buku ini adalah buku teks yang khusus membahas tentang bahasa Inggris matematika dan dapat membantu kamu memahami konsep matematika dalam bahasa Inggris.\n7. **\"Mathematical English\" oleh David E. Smith**: Buku ini adalah buku teks yang khusus membahas tentang bahasa Inggris matematika dan dapat membantu kamu memahami konsep matematika dalam bahasa Inggris.\n\n> **Buku online yang bagus:**\n* **\"Khan Academy\"**: Khan Academy memiliki banyak buku teks matematika online yang dapat membantu kamu memahami konsep matematika dalam bahasa Inggris.\n* **\"MIT OpenCourseWare\"**: MIT OpenCourseWare memiliki banyak buku teks matematika online yang dapat membantu kamu memahami konsep matematika dalam bahasa Inggris.\n* **\"Project Gutenberg\"**: Project Gutenberg memiliki banyak buku teks matematika online yang dapat membantu kamu memahami konsep matematika dalam bahasa Inggris.\n\nNamun, perlu diingat bahwa buku teks matematika dapat memiliki tingkat kesulitan yang berbeda-beda, jadi pastikan kamu memilih buku yang sesuai dengan tingkat kemampuan kamu.\n\nApakah kamu memiliki pertanyaan tentang buku-buku di atas, Miftah?', 392, '2026-06-28 00:56:11', '2026-06-28 00:56:11'),
(59, 10, 'user', 'Bagaimana cara membaca notasi \"∀x ∈ ℝ\" dalam Bahasa Inggris?', 0, '2026-06-28 07:08:40', '2026-06-28 07:08:40'),
(60, 10, 'assistant', 'Notasi \"∀x ∈ ℝ\" dibaca sebagai \"**for all x in the set of real numbers**\".\n\nDalam notasi ini:\n\n* \"∀\" disebut **universal quantifier**, yang berarti \"**for all**\" atau \"**untuk semua**\".\n* \"x\" adalah **variabel** yang merepresentasikan elemen dalam himpunan.\n* \"∈\" disebut **simbol keanggotaan**, yang berarti \"**is an element of**\" atau \"**merupakan elemen dari**\".\n* \"ℝ\" adalah **notasi untuk himpunan bilangan real**, yang disebut \"**set of real numbers**\" atau \"**himpunan bilangan riil**\".\n\nJadi, keseluruhan notasi \"∀x ∈ ℝ\" dapat dibaca sebagai \"**for all x that are real numbers**\" atau \"**untuk semua x yang merupakan bilangan riil**\".', 110, '2026-06-28 07:08:43', '2026-06-28 07:08:43'),
(61, 11, 'user', 'Bagaimana cara membaca notasi \"∀x ∈ ℝ\" dalam Bahasa Inggris?', 0, '2026-06-28 22:27:44', '2026-06-28 22:27:44'),
(62, 11, 'assistant', 'Notasi \"∀x ∈ ℝ\" dibaca sebagai: **\"for all x in the set of real numbers\"**.\n\nDalam Bahasa Inggris, kita dapat menerjemahkan notasi ini sebagai: **\"untuk semua x dalam himpunan bilangan riil\"**.\n\nSimbol \"∀\" disebut **\"universal quantifier\"** atau **\"kuantifier universal\"**, yang berarti \"untuk semua\" atau \"semua\".\n\nSedangkan \"∈\" disebut **\"element of\"** atau **\"anggota dari\"**, yang menunjukkan bahwa x adalah elemen dari himpunan ℝ (bilangan riil).\n\nJadi, notasi \"∀x ∈ ℝ\" secara keseluruhan berarti bahwa pernyataan atau persamaan yang mengikutinya berlaku untuk semua nilai x yang merupakan bilangan riil.', 104, '2026-06-28 22:27:50', '2026-06-28 22:27:50'),
(63, 11, 'user', 'bagaimana cara membaca 1/2 dalam bahasa ingris', 0, '2026-06-28 22:28:10', '2026-06-28 22:28:10'),
(64, 11, 'assistant', 'Dalam Bahasa Inggris, notasi \"1/2\" dibaca sebagai: **\"one half\"** atau **\"a half\"**.\n\nJika Anda ingin membacanya dalam bentuk kata-kata, Anda dapat mengatakan: **\"satu per dua\"**, tetapi cara yang lebih umum dan alami dalam Bahasa Inggris adalah dengan mengatakan **\"one half\"**.\n\nDalam konteks matematika, notasi \"1/2\" juga dapat dibaca sebagai **\"one over two\"**, tetapi **\"one half\"** adalah cara yang lebih umum dan singkat untuk membacanya.\n\nContoh lain:\n\n* 3/4 dibaca sebagai **\"three quarters\"**\n* 2/3 dibaca sebagai **\"two thirds\"**\n* 1/4 dibaca sebagai **\"one quarter\"**\n\nNamun, perlu diingat bahwa dalam Bahasa Inggris, notasi pecahan seperti \"1/2\" sering kali dibaca dalam bentuk kata-kata yang lebih umum dan alami, seperti **\"a half\"** atau **\"half\"**, tergantung pada konteks kalimat.', 137, '2026-06-28 22:28:13', '2026-06-28 22:28:13'),
(65, 11, 'user', 'akar 1/5 dalam bahasa ingris', 0, '2026-06-28 22:30:03', '2026-06-28 22:30:03'),
(66, 11, 'assistant', 'Dalam Bahasa Inggris, notasi \"akar 1/5\" dapat dibaca sebagai: **\"the square root of one fifth\"**.\n\nNamun, cara yang lebih umum dan singkat untuk membacanya adalah: **\"the square root of a fifth\"** atau **\"the square root of one over five\"**.\n\nDalam matematika, notasi \"akar 1/5\" dapat ditulis sebagai: √(1/5)\n\nJadi, cara membacanya adalah:\n\n* √(1/5) dibaca sebagai: **\"the square root of one fifth\"** atau **\"the square root of a fifth\"**\n\nContoh lain:\n\n* √(1/2) dibaca sebagai: **\"the square root of one half\"** atau **\"the square root of a half\"**\n* √(3/4) dibaca sebagai: **\"the square root of three quarters\"**\n* √(2/3) dibaca sebagai: **\"the square root of two thirds\"**\n\nPerlu diingat bahwa dalam Bahasa Inggris, notasi akar seperti √(1/5) sering kali dibaca dalam bentuk kata-kata yang lebih umum dan alami, tergantung pada konteks kalimat.', 157, '2026-06-28 22:30:06', '2026-06-28 22:30:06'),
(67, 11, 'user', 'dalam bahasa ingris 2 pangkat 5', 0, '2026-06-28 22:30:32', '2026-06-28 22:30:32'),
(68, 11, 'assistant', 'Dalam Bahasa Inggris, notasi \"2 pangkat 5\" dapat dibaca sebagai: **\"two to the power of five\"** atau **\"two raised to the power of five\"**.\n\nCara lain untuk membacanya adalah: **\"two to the fifth power\"** atau **\"two to the fifth\"**.\n\nDalam matematika, notasi \"2 pangkat 5\" dapat ditulis sebagai: 2^5\n\nJadi, cara membacanya adalah:\n\n* 2^5 dibaca sebagai: **\"two to the fifth power\"** atau **\"two to the power of five\"**\n\nContoh lain:\n\n* 3^4 dibaca sebagai: **\"three to the fourth power\"** atau **\"three to the power of four\"**\n* 4^3 dibaca sebagai: **\"four to the third power\"** atau **\"four to the power of three\"**\n* 5^2 dibaca sebagai: **\"five to the second power\"** atau **\"five to the power of two\"**\n\nPerlu diingat bahwa dalam Bahasa Inggris, notasi pangkat seperti 2^5 sering kali dibaca dalam bentuk kata-kata yang lebih umum dan alami, tergantung pada konteks kalimat.', 169, '2026-06-28 22:30:35', '2026-06-28 22:30:35'),
(69, 12, 'user', 'Bagaimana cara membaca notasi \"∀x ∈ ℝ\" dalam Bahasa Inggris?', 0, '2026-06-29 00:06:26', '2026-06-29 00:06:26'),
(70, 12, 'assistant', 'Notasi \"∀x ∈ ℝ\" dibaca sebagai \"**for all x in the set of real numbers**\" atau lebih singkat \"**for all real x**\". \n\nDalam konteks logika matematika, notasi ini digunakan untuk menyatakan bahwa suatu pernyataan atau kondisi berlaku untuk semua nilai x yang termasuk dalam himpunan bilangan real (ℝ). \n\nContoh penggunaan notasi ini dalam kalimat: \n> **For all x in the set of real numbers**, the equation x^2 + 1 ≥ 1 holds true. \n\nDalam konteks ini, notasi \"∀x ∈ ℝ\" menunjukkan bahwa persamaan x^2 + 1 ≥ 1 berlaku untuk semua nilai x yang merupakan bilangan real.', 107, '2026-06-29 00:06:29', '2026-06-29 00:06:29'),
(71, 13, 'user', 'Jelaskan kosakata dalam ekspresi \"matrix decomposition\"', 0, '2026-07-04 03:28:41', '2026-07-04 03:28:41'),
(72, 13, 'assistant', '**Matrix Decomposition** adalah sebuah istilah dalam matematika yang merujuk pada proses memecah atau mendekomposisi sebuah **matriks** (matrix) menjadi beberapa matriks yang lebih sederhana.\n\nBerikut adalah penjelasan kosakata dalam ekspresi \"matrix decomposition\":\n\n* **Matrix**: Matriks adalah sebuah struktur data yang terdiri dari baris dan kolom, yang digunakan untuk merepresentasikan sistem persamaan linier, transformasi geometrik, dan lain-lain.\n* **Decomposition**: Dekomposisi berarti memecah atau membagi sesuatu menjadi beberapa bagian yang lebih kecil dan lebih sederhana. Dalam konteks matriks, dekomposisi berarti memecah sebuah matriks menjadi beberapa matriks yang lebih sederhana, sehingga lebih mudah untuk dianalisis dan diolah.\n\nDalam konteks matematika, **matrix decomposition** digunakan untuk memecah sebuah matriks menjadi beberapa matriks yang lebih sederhana, sehingga lebih mudah untuk melakukan operasi matematika, seperti menghitung determinan, invers, atau melakukan transformasi geometrik.\n\nBeberapa contoh **matrix decomposition** yang umum digunakan adalah:\n\n1. **Eigen decomposition**: memecah sebuah matriks menjadi matriks eigenvektor dan eigenvalue.\n2. **LU decomposition**: memecah sebuah matriks menjadi matriks lower triangular (L) dan upper triangular (U).\n3. **Cholesky decomposition**: memecah sebuah matriks menjadi matriks lower triangular (L) dan transpose dari L.\n4. **QR decomposition**: memecah sebuah matriks menjadi matriks orthogonal (Q) dan upper triangular (R).\n\nDengan menggunakan **matrix decomposition**, kita dapat mempermudah analisis dan pengolahan data, serta meningkatkan efisiensi dalam melakukan operasi matematika.', 258, '2026-07-04 03:28:45', '2026-07-04 03:28:45'),
(73, 14, 'user', 'Apa bedanya \"theorem\" dan \"lemma\"?', 0, '2026-07-07 22:27:00', '2026-07-07 22:27:00'),
(74, 14, 'assistant', '**Teorema** (theorem) dan **lemma** adalah dua istilah yang digunakan dalam matematika untuk mengacu pada pernyataan yang telah dibuktikan. Namun, ada perbedaan antara keduanya:\n\n1. **Tujuan**: \n   - **Teorema** biasanya digunakan untuk mengacu pada pernyataan yang signifikan dan penting dalam suatu teori atau bidang studi. Teorema seringkali merupakan hasil akhir yang diinginkan dari suatu penyelidikan matematika.\n   - **Lemma**, di sisi lain, adalah pernyataan yang digunakan sebagai langkah atau tahap dalam membuktikan teorema yang lebih besar. Lemma seringkali digunakan sebagai \"bahan baku\" atau \"alat\" untuk membuktikan teorema lain yang lebih penting.\n\n2. **Pentingnya**: \n   - **Teorema** cenderung memiliki dampak yang lebih besar dan lebih signifikan dalam suatu bidang matematika. Mereka seringkali memberikan wawasan baru, memecahkan masalah yang sulit, atau membuka jalan bagi penelitian lebih lanjut.\n   - **Lemma** mungkin tidak memiliki dampak yang sama besarnya secara individual, tetapi mereka sangat penting dalam membangun landasan untuk membuktikan teorema yang lebih besar.\n\n3. **Nama dan Konvensi**: \n   - Nama \"lemma\" berasal dari bahasa Yunani \"λάμμα\" (lemma), yang berarti \"apa yang diambil\". Ini mencerminkan peran lemma sebagai \"bahan baku\" atau \"alat\" yang diambil atau digunakan untuk membuktikan sesuatu yang lebih besar.\n   - \"Teorema\" berasal dari bahasa Yunani \"θεωρέω\" (theoreo), yang berarti \"melihat\" atau \"mengamati\". Ini mencerminkan peran teorema sebagai sebuah pernyataan yang signifikan yang dapat dilihat atau dipahami setelah penyelidikan yang cermat.\n\nDalam prakteknya, perbedaan antara teorema dan lemma dapat kabur, dan beberapa matematikawan mungkin menggunakan istilah-istilah ini dengan cara yang sedikit berbeda. Namun, secara umum, teorema dianggap sebagai pernyataan yang lebih signifikan dan penting, sementara lemma digunakan sebagai langkah-langkah yang diperlukan untuk mencapai teorema tersebut.\n\n> Perlu diingat bahwa istilah \"korolarium\" (korolari) juga digunakan dalam matematika. Korolari adalah pernyataan yang dapat dibuktikan dengan mudah dari suatu teorema yang telah dibuktikan sebelumnya. Korolari seringkali dianggap sebagai \"konsekuensi langsung\" dari teorema yang lebih besar.', 374, '2026-07-07 22:27:08', '2026-07-07 22:27:08'),
(75, 15, 'user', 'Jelaskan kosakata dalam ekspresi \"matrix decomposition\"', 0, '2026-07-08 04:02:42', '2026-07-08 04:02:42'),
(76, 15, 'assistant', '**Matrix decomposition** adalah sebuah konsep dalam aljabar linear yang melibatkan penguraian sebuah matriks menjadi beberapa matriks yang lebih sederhana. Kosakata dalam ekspresi ini dapat diuraikan sebagai berikut:\n\n* **Matrix**: Matriks adalah sebuah tabel yang terdiri dari baris dan kolom, yang digunakan untuk mewakili sistem persamaan linear atau transformasi linear. Kata \"matrix\" berasal dari bahasa Latin \"matrix\", yang berarti \"rahim\" atau \"tempat kelahiran\", karena matriks dapat dianggap sebagai tempat kelahiran solusi dari sistem persamaan linear.\n* **Decomposition**: Decomposition adalah proses penguraian sebuah objek menjadi beberapa bagian yang lebih sederhana. Dalam konteks matriks, decomposition berarti menguraikan sebuah matriks menjadi beberapa matriks yang lebih sederhana, sehingga memudahkan perhitungan dan analisis.\n\nDalam konteks **matrix decomposition**, beberapa istilah lain yang terkait adalah:\n\n* **Eigen decomposition**: penguraian matriks menjadi matriks eigenvalue dan eigenvector.\n* **LU decomposition**: penguraian matriks menjadi matriks lower triangular dan upper triangular.\n* **QR decomposition**: penguraian matriks menjadi matriks orthogonal dan upper triangular.\n* **Singular Value Decomposition (SVD)**: penguraian matriks menjadi matriks orthogonal, matriks diagonal, dan matriks orthogonal lainnya.\n\nDengan memahami kosakata dalam ekspresi **matrix decomposition**, Anda dapat lebih mudah memahami konsep-konsep yang terkait dengan aljabar linear dan matriks.', 234, '2026-07-08 04:02:47', '2026-07-08 04:02:47'),
(77, 15, 'user', 'berikan saya kodingan untuk membuat flapybird', 0, '2026-07-08 04:03:06', '2026-07-08 04:03:06'),
(78, 15, 'assistant', 'Berikut adalah contoh kodingan untuk membuat game Flappy Bird menggunakan Python dan library Pygame:\n```python\nimport pygame\nimport sys\n\n# Konstanta\nSCREEN_WIDTH = 400\nSCREEN_HEIGHT = 600\nPIPE_WIDTH = 80\nPIPE_HEIGHT = 600\nBIRD_WIDTH = 40\nBIRD_HEIGHT = 40\nGRAVITY = 0.5\n\n# Warna\nWHITE = (255, 255, 255)\nBLACK = (0, 0, 0)\nRED = (255, 0, 0)\n\n# Pygame\npygame.init()\nscreen = pygame.display.set_mode((SCREEN_WIDTH, SCREEN_HEIGHT))\nclock = pygame.time.Clock()\n\n# Bird\nbird_x = SCREEN_WIDTH / 2\nbird_y = SCREEN_HEIGHT / 2\nbird_vy = 0\n\n# Pipe\npipe_x = SCREEN_WIDTH\npipe_y = SCREEN_HEIGHT / 2\npipe_gap = 150\n\n# Score\nscore = 0\n\n# Game Loop\nwhile True:\n    # Event\n    for event in pygame.event.get():\n        if event.type == pygame.QUIT:\n            pygame.quit()\n            sys.exit()\n        elif event.type == pygame.KEYDOWN:\n            if event.key == pygame.K_SPACE:\n                bird_vy = -10\n\n    # Update\n    bird_vy += GRAVITY\n    bird_y += bird_vy\n\n    if bird_y + BIRD_HEIGHT > SCREEN_HEIGHT:\n        bird_y = SCREEN_HEIGHT - BIRD_HEIGHT\n        bird_vy = 0\n\n    pipe_x -= 2\n    if pipe_x < -PIPE_WIDTH:\n        pipe_x = SCREEN_WIDTH\n        pipe_y = SCREEN_HEIGHT / 2\n        pipe_gap = 150\n\n    # Collision\n    if (bird_x + BIRD_WIDTH > pipe_x and\n            bird_x < pipe_x + PIPE_WIDTH and\n            (bird_y < pipe_y or bird_y + BIRD_HEIGHT > pipe_y + pipe_gap)):\n        print(\"Game Over!\")\n        pygame.quit()\n        sys.exit()\n\n    # Score\n    if pipe_x + PIPE_WIDTH / 2 < bird_x and pipe_x + PIPE_WIDTH / 2 > bird_x - 2:\n        score += 1\n\n    # Draw\n    screen.fill(WHITE)\n    pygame.draw.rect(screen, BLACK, (pipe_x, 0, PIPE_WIDTH, pipe_y))\n    pygame.draw.rect(screen, BLACK, (pipe_x, pipe_y + pipe_gap, PIPE_WIDTH, SCREEN_HEIGHT - pipe_y - pipe_gap))\n    pygame.draw.rect(screen, RED, (bird_x, bird_y, BIRD_WIDTH, BIRD_HEIGHT))\n    font = pygame.font.Font(None, 36)\n    text = font.render(str(score), True, BLACK)\n    screen.blit(text, (SCREEN_WIDTH / 2, 20))\n\n    # Update Display\n    pygame.display.flip()\n    clock.tick(60)\n```\nKodingan di atas membuat game Flappy Bird dengan fitur-fitur berikut:\n\n* Bird yang dapat diarahkan dengan menekan tombol spasi\n* Pipe yang bergerak ke kiri\n* Collision detection antara bird dan pipe\n* Score yang bertambah setiap kali bird melewati pipe\n* Game over jika bird menyentuh pipe atau tanah\n\nNamun, perlu diingat bahwa kodingan di atas masih sederhana dan dapat diperbaiki untuk membuat game yang lebih kompleks dan menarik.', 447, '2026-07-08 04:03:08', '2026-07-08 04:03:08'),
(79, 16, 'user', 'Bagaimana cara membaca notasi \"∀x ∈ ℝ\" dalam Bahasa Inggris?', 0, '2026-07-08 22:14:32', '2026-07-08 22:14:32'),
(80, 16, 'assistant', 'Notasi \"∀x ∈ ℝ\" dalam Bahasa Inggris dibaca sebagai \"**for all x in the set of real numbers**\" atau secara lebih singkat \"**for all real x**\" atau bahkan \"**for all x**\" jika konteksnya sudah jelas bahwa x adalah bilangan riil.\n\nDalam notasi ini:\n- **∀** (dibaca \"for all\") adalah simbol yang digunakan untuk menyatakan quantifier universal, yang berarti pernyataan yang mengikutinya berlaku untuk semua elemen dalam himpunan yang ditentukan.\n- **x** adalah variabel yang mewakili elemen dalam himpunan.\n- **∈** (dibaca \"is an element of\" atau \"in\") menunjukkan keanggotaan dalam suatu himpunan.\n- **ℝ** (dibaca \"the set of real numbers\" atau \"real numbers\") adalah notasi untuk himpunan semua bilangan riil.\n\nContoh penggunaan notasi ini dalam kalimat: \"**∀x ∈ ℝ, x^2 ≥ 0**\" dibaca sebagai \"**For all x in the set of real numbers, x squared is greater than or equal to zero**\". Ini berarti bahwa untuk setiap bilangan riil x, kuadrat dari x selalu lebih besar atau sama dengan nol.', 196, '2026-07-08 22:14:41', '2026-07-08 22:14:41');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `certificates`
--

CREATE TABLE `certificates` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `course_id` bigint UNSIGNED NOT NULL,
  `certificate_number` varchar(255) NOT NULL,
  `total_lessons` int UNSIGNED NOT NULL DEFAULT '0',
  `total_xp_earned` int UNSIGNED NOT NULL DEFAULT '0',
  `quiz_score_percent` tinyint UNSIGNED DEFAULT NULL,
  `issued_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `certificates`
--

INSERT INTO `certificates` (`id`, `user_id`, `course_id`, `certificate_number`, `total_lessons`, `total_xp_earned`, `quiz_score_percent`, `issued_at`, `created_at`, `updated_at`) VALUES
(1, 2, 4, 'MLA-2026-TVUQQR', 1, 10, NULL, '2026-07-07 23:03:04', '2026-07-07 23:03:04', '2026-07-07 23:03:04');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` bigint UNSIGNED NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `short_description` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'General Mathematics',
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '#2563EB',
  `thumbnail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `difficulty` enum('beginner','intermediate','advanced') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'beginner',
  `total_lessons` int NOT NULL DEFAULT '0',
  `total_xp` int NOT NULL DEFAULT '0',
  `estimated_minutes` int NOT NULL DEFAULT '0',
  `language` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'English',
  `students_count` int NOT NULL DEFAULT '0',
  `rating` decimal(3,2) NOT NULL DEFAULT '0.00',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `sort_order` int NOT NULL DEFAULT '0',
  `status` enum('draft','published','archived') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `slug`, `title`, `description`, `short_description`, `category`, `icon`, `color`, `thumbnail`, `difficulty`, `total_lessons`, `total_xp`, `estimated_minutes`, `language`, `students_count`, `rating`, `is_active`, `is_featured`, `sort_order`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'mathematics-in-english', 'Mathematics In English', 'uji coba', 'uji', 'General Mathematics', '📚', '#F59E0B', NULL, 'beginner', 0, 10, 60, 'English', 0, 0.00, 1, 0, 1, 'published', '2026-06-28 01:59:28', '2026-07-07 22:35:39', '2026-07-07 22:35:39'),
(2, 'bahasa-inggris', 'Bahasa Inggris', NULL, 'Learn english', 'Geometry', '📚', '#2563EB', 'course-thumbnails/HCJ1bPzl4fXwb6vuX8av4cZkH2KNFX4PVeyKxgXI.png', 'intermediate', 0, 0, 2, 'English', 0, 0.00, 1, 1, 2, 'published', '2026-07-02 19:04:17', '2026-07-07 22:35:45', '2026-07-07 22:35:45'),
(3, 'test', 'TEST', NULL, NULL, 'Statistics', '📚', '#2563EB', NULL, 'advanced', 0, 6, 10, 'English', 0, 0.00, 1, 1, 3, 'published', '2026-07-02 19:55:28', '2026-07-04 06:30:07', '2026-07-04 06:30:07'),
(4, 'mathematics', 'Mathematics', 'This course is designed to help students improve their Mathematical English proficiency by learning mathematical vocabulary, expressions, and concepts commonly used in classrooms, textbooks, and international assessments.\r\n\r\nStudents will study mathematical terms, understand their meanings through contextual examples, complete interactive quizzes, and receive personalized assistance from the AI Tutor throughout the learning process.\r\n\r\nBy completing this course, students will be able to understand mathematical instructions, solve problems written in English, and communicate mathematical ideas more confidently.', 'Learn essential mathematical vocabulary, expressions, and concepts in English through interactive lessons, vocabulary practice, quizzes, and AI-assisted learning.', 'General Mathematics', '📚', '#2563EB', NULL, 'beginner', 0, 300, 180, 'English', 0, 0.00, 1, 0, 1, 'published', '2026-07-07 22:40:47', '2026-07-08 08:05:34', NULL),
(5, 'vedw', 'VEDW', NULL, NULL, 'General Mathematics', '📚', '#2563EB', NULL, 'intermediate', 0, 0, 0, 'English', 0, 0.00, 0, 0, 2, 'draft', '2026-07-08 08:06:31', '2026-07-08 08:06:36', '2026-07-08 08:06:36'),
(6, 'kursus-1', 'kursus 1', NULL, NULL, 'Linear Algebra', '📚', '#2563EB', NULL, 'beginner', 0, 0, 0, 'English', 0, 0.00, 1, 0, 2, 'published', '2026-07-08 08:14:33', '2026-07-08 08:16:44', '2026-07-08 08:16:44'),
(7, 'vsdvv', 'vSDVv', NULL, NULL, 'Algebra', '📚', '#2563EB', NULL, 'beginner', 0, 0, 0, 'English', 0, 0.00, 1, 0, 3, 'published', '2026-07-08 08:14:51', '2026-07-08 08:16:48', '2026-07-08 08:16:48'),
(8, 'arvaervea-rqvaaaere', 'arvaervea rqvaaaere', NULL, NULL, 'Algebra', '📚', '#2563EB', NULL, 'intermediate', 0, 0, 0, 'English', 0, 0.00, 1, 0, 4, 'published', '2026-07-08 08:15:05', '2026-07-08 08:16:52', '2026-07-08 08:16:52'),
(9, 'varqaev-raverva', 'varqaev raverva', NULL, NULL, 'Algebra', '📚', '#2563EB', NULL, 'beginner', 0, 0, 0, 'English', 0, 0.00, 1, 0, 5, 'published', '2026-07-08 08:15:19', '2026-07-08 08:16:57', '2026-07-08 08:16:57');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE `lessons` (
  `id` bigint UNSIGNED NOT NULL,
  `course_id` bigint UNSIGNED NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `lesson_type` enum('vocabulary','reading','grammar','practice','quiz') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'vocabulary',
  `xp_reward` int NOT NULL DEFAULT '10',
  `duration_minutes` int NOT NULL DEFAULT '10',
  `sort_order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`id`, `course_id`, `slug`, `title`, `description`, `image`, `content`, `lesson_type`, `xp_reward`, `duration_minutes`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(7, 4, 'intruductio-to-mathematical-english', 'Intruductio to mathematical english', 'Learn the basic concepts, vocabulary, and common expressions used in Mathematical English.', 'lesson-images/vU2ecURXanHfxtJxffRs6aIo6q4oP4mnrnG3wAF7.jpg', '<p data-start=\"1102\" data-end=\"1243\" class=\"PDq2pG_selectionAnchorContainer\"><img src=\"http://127.0.0.1:8000/storage/lesson-content-images/VrZnSG3Yin30UlXViUKk0uueRUo3c6gBqvnNt5fM.jpg\" alt=\"Gambar pelajaran\"></p><p><br></p><p data-start=\"1102\" data-end=\"1243\" class=\"PDq2pG_selectionAnchorContainer\">Mathematical English is the language used to communicate mathematical ideas, solve problems, and understand mathematical concepts in English.<span aria-hidden=\"true\" class=\"PDq2pG_selectionAnchor\"></span></p>\r\n<p data-start=\"1245\" data-end=\"1289\">Learning Mathematical English will help you:</p>\r\n<ul data-start=\"1291\" data-end=\"1476\">\r\n<li data-section-id=\"3d6miz\" data-start=\"1291\" data-end=\"1340\">\r\nUnderstand international mathematics textbooks.\r\n</li>\r\n<li data-section-id=\"rfaxgb\" data-start=\"1341\" data-end=\"1389\">\r\nSolve mathematics problems written in English.\r\n</li>\r\n<li data-section-id=\"1w7zspg\" data-start=\"1390\" data-end=\"1434\">\r\nImprove mathematical communication skills.\r\n</li>\r\n<li data-section-id=\"1k7bw4e\" data-start=\"1435\" data-end=\"1476\">\r\nPrepare for international examinations.</li></ul><div><table><thead><tr><th>English</th><th>Indonesian</th></tr></thead><tbody><tr><td>Addition</td><td>Penjumlahan</td></tr><tr><td>Subtraction</td><td>Pengurangan</td></tr><tr><td>Multiplication</td><td>Perkalian</td></tr><tr><td>Division</td><td>Pembagian</td></tr><tr><td>Equation</td><td>Persamaan</td></tr><tr><td>Variable</td><td>Variabel</td></tr></tbody></table></div><br><div><h3 data-section-id=\"16zgw4u\" data-start=\"1734\" data-end=\"1745\" class=\"PDq2pG_selectionAnchorContainer\">Example<span aria-hidden=\"true\" class=\"PDq2pG_selectionAnchor\"></span></h3>\r\n<p data-start=\"1747\" data-end=\"1755\" class=\"PDq2pG_selectionAnchorContainer\">English:<span aria-hidden=\"true\" class=\"PDq2pG_selectionAnchor\"></span></p><p data-start=\"1747\" data-end=\"1755\" class=\"\">\r\n</p><blockquote data-start=\"1757\" data-end=\"1784\">\r\n<p data-start=\"1759\" data-end=\"1784\" class=\"\">Find the sum of 8 and 12.</p></blockquote><p data-start=\"1786\" data-end=\"1794\" class=\"PDq2pG_selectionAnchorContainer\">Meaning:<span aria-hidden=\"true\" class=\"PDq2pG_selectionAnchor\"></span></p><p data-start=\"1747\" data-end=\"1755\" class=\"\">\r\n</p><blockquote data-start=\"1796\" data-end=\"1839\">\r\n<p data-start=\"1798\" data-end=\"1839\">Tentukan hasil penjumlahan dari 8 dan 12.<br></p></blockquote></div>', 'reading', 10, 15, 1, 1, '2026-07-07 22:45:02', '2026-07-08 08:22:35'),
(12, 4, 'yaa', 'yaa', NULL, NULL, '<img src=\"http://127.0.0.1:8000/storage/lesson-content-images/gBsLKZ1HpnT8BPDowClW1gJ3M4t4yNlIE5Sf91be.jpg\" alt=\"Gambar pelajaran\"><p><br></p><br><table>\r\n<thead><tr><th>Kolom 1</th><th>Kolom 2</th><th>Kolom 3</th></tr></thead>\r\n<tbody>\r\n<tr><td>Data 1</td><td>Data 2</td><td>Data 3</td></tr>\r\n<tr><td>Data 4</td><td>Data 5</td><td>Data 6</td></tr>\r\n</tbody>\r\n</table><p><br></p><p><br></p><p><br></p>', 'reading', 10, 10, 1, 1, '2026-07-08 22:21:40', '2026-07-08 22:21:40');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('09b01ce3-c124-492b-a4cd-2a20bf00f5fd', 'App\\Notifications\\NewCourseAvailable', 'App\\Models\\User', 2, '{\"icon\":\"book\",\"color\":\"#2563EB\",\"title\":\"Kursus baru tersedia\",\"message\":\"Kursus \\\"vSDVv\\\" baru saja dipublikasikan. Yuk mulai belajar!\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/courses\\/vsdvv\"}', NULL, '2026-07-08 08:14:51', '2026-07-08 08:14:51'),
('0b557d36-b9dc-4cff-90ee-8af6de69b59a', 'App\\Notifications\\NewCourseAvailable', 'App\\Models\\User', 9, '{\"icon\":\"book\",\"color\":\"#2563EB\",\"title\":\"Kursus baru tersedia\",\"message\":\"Kursus \\\"varqaev raverva\\\" baru saja dipublikasikan. Yuk mulai belajar!\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/courses\\/varqaev-raverva\"}', NULL, '2026-07-08 08:15:19', '2026-07-08 08:15:19'),
('0f88625a-20f0-4f42-8710-437a4c91b89d', 'App\\Notifications\\CertificateIssued', 'App\\Models\\User', 2, '{\"icon\":\"award\",\"color\":\"#F59E0B\",\"title\":\"Selamat! Kursus selesai \\ud83c\\udf89\",\"message\":\"Kamu berhasil menyelesaikan \\\"Mathematics\\\" dan mendapatkan sertifikat.\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/certificates\\/1\"}', NULL, '2026-07-07 23:03:04', '2026-07-07 23:03:04'),
('1332fac4-ff8c-4cd8-a4fe-17d40562b598', 'App\\Notifications\\NewCourseAvailable', 'App\\Models\\User', 8, '{\"icon\":\"book\",\"color\":\"#2563EB\",\"title\":\"Kursus baru tersedia\",\"message\":\"Kursus \\\"varqaev raverva\\\" baru saja dipublikasikan. Yuk mulai belajar!\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/courses\\/varqaev-raverva\"}', NULL, '2026-07-08 08:15:19', '2026-07-08 08:15:19'),
('13a3abb0-1d67-45d7-a9fa-425382d573fc', 'App\\Notifications\\NewCourseAvailable', 'App\\Models\\User', 2, '{\"icon\":\"book\",\"color\":\"#2563EB\",\"title\":\"Kursus baru tersedia\",\"message\":\"Kursus \\\"varqaev raverva\\\" baru saja dipublikasikan. Yuk mulai belajar!\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/courses\\/varqaev-raverva\"}', NULL, '2026-07-08 08:15:19', '2026-07-08 08:15:19'),
('188ea8d2-e41e-4c8d-89cd-d386b89ea93c', 'App\\Notifications\\NewCourseAvailable', 'App\\Models\\User', 7, '{\"icon\":\"book\",\"color\":\"#2563EB\",\"title\":\"Kursus baru tersedia\",\"message\":\"Kursus \\\"varqaev raverva\\\" baru saja dipublikasikan. Yuk mulai belajar!\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/courses\\/varqaev-raverva\"}', NULL, '2026-07-08 08:15:19', '2026-07-08 08:15:19'),
('1c8cce3c-33cd-456c-8b43-7cd3ff0a0871', 'App\\Notifications\\NewCourseAvailable', 'App\\Models\\User', 8, '{\"icon\":\"book\",\"color\":\"#2563EB\",\"title\":\"Kursus baru tersedia\",\"message\":\"Kursus \\\"Mathematics\\\" baru saja dipublikasikan. Yuk mulai belajar!\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/courses\\/mathematics\"}', NULL, '2026-07-07 22:40:50', '2026-07-07 22:40:50'),
('24183876-6040-44f6-bbb7-0924eea5bf57', 'App\\Notifications\\NewCourseAvailable', 'App\\Models\\User', 2, '{\"icon\":\"book\",\"color\":\"#2563EB\",\"title\":\"Kursus baru tersedia\",\"message\":\"Kursus \\\"kursus 1\\\" baru saja dipublikasikan. Yuk mulai belajar!\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/courses\\/kursus-1\"}', NULL, '2026-07-08 08:14:37', '2026-07-08 08:14:37'),
('38b83407-39c6-45b3-8387-d21ffb7e8b30', 'App\\Notifications\\NewCourseAvailable', 'App\\Models\\User', 7, '{\"icon\":\"book\",\"color\":\"#2563EB\",\"title\":\"Kursus baru tersedia\",\"message\":\"Kursus \\\"arvaervea rqvaaaere\\\" baru saja dipublikasikan. Yuk mulai belajar!\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/courses\\/arvaervea-rqvaaaere\"}', NULL, '2026-07-08 08:15:05', '2026-07-08 08:15:05'),
('486f6fd8-5f09-4070-a5cf-727510675fca', 'App\\Notifications\\NewCourseAvailable', 'App\\Models\\User', 9, '{\"icon\":\"book\",\"color\":\"#2563EB\",\"title\":\"Kursus baru tersedia\",\"message\":\"Kursus \\\"vSDVv\\\" baru saja dipublikasikan. Yuk mulai belajar!\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/courses\\/vsdvv\"}', NULL, '2026-07-08 08:14:51', '2026-07-08 08:14:51'),
('48fdde7e-963c-4603-8e5b-c439d374d819', 'App\\Notifications\\NewCourseAvailable', 'App\\Models\\User', 6, '{\"icon\":\"book\",\"color\":\"#2563EB\",\"title\":\"Kursus baru tersedia\",\"message\":\"Kursus \\\"Mathematics\\\" baru saja dipublikasikan. Yuk mulai belajar!\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/courses\\/mathematics\"}', NULL, '2026-07-07 22:40:50', '2026-07-07 22:40:50'),
('4a8ea4fb-6be3-4c11-8637-8737a1aca1b0', 'App\\Notifications\\NewCourseAvailable', 'App\\Models\\User', 7, '{\"icon\":\"book\",\"color\":\"#2563EB\",\"title\":\"Kursus baru tersedia\",\"message\":\"Kursus \\\"vSDVv\\\" baru saja dipublikasikan. Yuk mulai belajar!\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/courses\\/vsdvv\"}', NULL, '2026-07-08 08:14:51', '2026-07-08 08:14:51'),
('5f39c5d9-2d80-429e-9a09-3ad3e0f81f78', 'App\\Notifications\\NewCourseAvailable', 'App\\Models\\User', 2, '{\"icon\":\"book\",\"color\":\"#2563EB\",\"title\":\"Kursus baru tersedia\",\"message\":\"Kursus \\\"arvaervea rqvaaaere\\\" baru saja dipublikasikan. Yuk mulai belajar!\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/courses\\/arvaervea-rqvaaaere\"}', NULL, '2026-07-08 08:15:05', '2026-07-08 08:15:05'),
('653e9bad-cc19-4ca2-a62f-be78b6f648bc', 'App\\Notifications\\NewCourseAvailable', 'App\\Models\\User', 2, '{\"icon\":\"book\",\"color\":\"#2563EB\",\"title\":\"Kursus baru tersedia\",\"message\":\"Kursus \\\"Mathematics\\\" baru saja dipublikasikan. Yuk mulai belajar!\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/courses\\/mathematics\"}', NULL, '2026-07-07 22:40:50', '2026-07-07 22:40:50'),
('9e669dde-9a77-432f-86b5-e80103a057e2', 'App\\Notifications\\NewCourseAvailable', 'App\\Models\\User', 6, '{\"icon\":\"book\",\"color\":\"#2563EB\",\"title\":\"Kursus baru tersedia\",\"message\":\"Kursus \\\"vSDVv\\\" baru saja dipublikasikan. Yuk mulai belajar!\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/courses\\/vsdvv\"}', NULL, '2026-07-08 08:14:51', '2026-07-08 08:14:51'),
('bb7ddc8c-338c-422a-807c-e2d9f2c37514', 'App\\Notifications\\NewCourseAvailable', 'App\\Models\\User', 6, '{\"icon\":\"book\",\"color\":\"#2563EB\",\"title\":\"Kursus baru tersedia\",\"message\":\"Kursus \\\"kursus 1\\\" baru saja dipublikasikan. Yuk mulai belajar!\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/courses\\/kursus-1\"}', NULL, '2026-07-08 08:14:37', '2026-07-08 08:14:37'),
('c9c0ab68-aa06-493f-bdf9-3160b7bddfc2', 'App\\Notifications\\NewCourseAvailable', 'App\\Models\\User', 7, '{\"icon\":\"book\",\"color\":\"#2563EB\",\"title\":\"Kursus baru tersedia\",\"message\":\"Kursus \\\"Mathematics\\\" baru saja dipublikasikan. Yuk mulai belajar!\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/courses\\/mathematics\"}', NULL, '2026-07-07 22:40:50', '2026-07-07 22:40:50'),
('cd2b8349-8031-4cae-bb48-ba32ce42a794', 'App\\Notifications\\NewCourseAvailable', 'App\\Models\\User', 6, '{\"icon\":\"book\",\"color\":\"#2563EB\",\"title\":\"Kursus baru tersedia\",\"message\":\"Kursus \\\"arvaervea rqvaaaere\\\" baru saja dipublikasikan. Yuk mulai belajar!\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/courses\\/arvaervea-rqvaaaere\"}', NULL, '2026-07-08 08:15:05', '2026-07-08 08:15:05'),
('e2861c2b-9ca8-4961-9927-db794368ed14', 'App\\Notifications\\NewCourseAvailable', 'App\\Models\\User', 9, '{\"icon\":\"book\",\"color\":\"#2563EB\",\"title\":\"Kursus baru tersedia\",\"message\":\"Kursus \\\"Mathematics\\\" baru saja dipublikasikan. Yuk mulai belajar!\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/courses\\/mathematics\"}', NULL, '2026-07-07 22:40:50', '2026-07-07 22:40:50'),
('e5a24c32-86f1-465c-9f9d-e187225192b2', 'App\\Notifications\\NewCourseAvailable', 'App\\Models\\User', 8, '{\"icon\":\"book\",\"color\":\"#2563EB\",\"title\":\"Kursus baru tersedia\",\"message\":\"Kursus \\\"vSDVv\\\" baru saja dipublikasikan. Yuk mulai belajar!\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/courses\\/vsdvv\"}', NULL, '2026-07-08 08:14:51', '2026-07-08 08:14:51'),
('e5aa34f3-f554-4add-884c-2ef754e8f6a7', 'App\\Notifications\\NewCourseAvailable', 'App\\Models\\User', 9, '{\"icon\":\"book\",\"color\":\"#2563EB\",\"title\":\"Kursus baru tersedia\",\"message\":\"Kursus \\\"arvaervea rqvaaaere\\\" baru saja dipublikasikan. Yuk mulai belajar!\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/courses\\/arvaervea-rqvaaaere\"}', NULL, '2026-07-08 08:15:05', '2026-07-08 08:15:05'),
('e5c3e193-8e74-4a78-abf2-535235d19e36', 'App\\Notifications\\NewCourseAvailable', 'App\\Models\\User', 9, '{\"icon\":\"book\",\"color\":\"#2563EB\",\"title\":\"Kursus baru tersedia\",\"message\":\"Kursus \\\"kursus 1\\\" baru saja dipublikasikan. Yuk mulai belajar!\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/courses\\/kursus-1\"}', NULL, '2026-07-08 08:14:37', '2026-07-08 08:14:37'),
('ee4068f7-2539-4004-818e-6713226b949d', 'App\\Notifications\\NewCourseAvailable', 'App\\Models\\User', 6, '{\"icon\":\"book\",\"color\":\"#2563EB\",\"title\":\"Kursus baru tersedia\",\"message\":\"Kursus \\\"varqaev raverva\\\" baru saja dipublikasikan. Yuk mulai belajar!\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/courses\\/varqaev-raverva\"}', NULL, '2026-07-08 08:15:19', '2026-07-08 08:15:19'),
('f423faba-e21a-4114-b036-1cbbc0e2e799', 'App\\Notifications\\NewCourseAvailable', 'App\\Models\\User', 7, '{\"icon\":\"book\",\"color\":\"#2563EB\",\"title\":\"Kursus baru tersedia\",\"message\":\"Kursus \\\"kursus 1\\\" baru saja dipublikasikan. Yuk mulai belajar!\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/courses\\/kursus-1\"}', NULL, '2026-07-08 08:14:37', '2026-07-08 08:14:37'),
('f4f99328-ec3a-46a0-95cf-d7c414528623', 'App\\Notifications\\NewCourseAvailable', 'App\\Models\\User', 8, '{\"icon\":\"book\",\"color\":\"#2563EB\",\"title\":\"Kursus baru tersedia\",\"message\":\"Kursus \\\"kursus 1\\\" baru saja dipublikasikan. Yuk mulai belajar!\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/courses\\/kursus-1\"}', NULL, '2026-07-08 08:14:37', '2026-07-08 08:14:37'),
('fc9514fe-09bb-49db-b287-7fd3749d0b06', 'App\\Notifications\\NewCourseAvailable', 'App\\Models\\User', 8, '{\"icon\":\"book\",\"color\":\"#2563EB\",\"title\":\"Kursus baru tersedia\",\"message\":\"Kursus \\\"arvaervea rqvaaaere\\\" baru saja dipublikasikan. Yuk mulai belajar!\",\"url\":\"http:\\/\\/127.0.0.1:8000\\/courses\\/arvaervea-rqvaaaere\"}', NULL, '2026-07-08 08:15:05', '2026-07-08 08:15:05');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `id` bigint UNSIGNED NOT NULL,
  `lesson_id` bigint UNSIGNED NOT NULL,
  `question` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `question_type` enum('multiple_choice','essay','word_arrange') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `options` json DEFAULT NULL,
  `correct_answer` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `explanation` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `xp_reward` int NOT NULL DEFAULT '5',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `time_limit_seconds` int NOT NULL DEFAULT '30'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`id`, `lesson_id`, `question`, `question_type`, `image`, `options`, `correct_answer`, `explanation`, `xp_reward`, `sort_order`, `created_at`, `updated_at`, `is_active`, `time_limit_seconds`) VALUES
(9, 7, 'What does the word \"Addition\" mean?', 'multiple_choice', 'quiz-images/dn102OkbUuflxs0dvMWH29ZjPlotQrn0UP4sCyfh.jpg', '[\"Penjumlahan\", \"Pengurangan\", \"Perkalian\"]', 'Penjumlahan', NULL, 10, 1, '2026-07-07 22:57:11', '2026-07-08 08:08:22', 1, 30),
(10, 7, 'Choose the correct English sentence for the expression:  5 + 3 = 8', 'word_arrange', NULL, '[\"Five\", \"plus\", \"three\", \"equals\", \"eight\"]', '[\"Five\",\"plus\",\"three\",\"equals\",\"eight\"]', 'The symbol (+) is read as \"plus.\"', 10, 2, '2026-07-07 23:01:01', '2026-07-07 23:01:01', 1, 30),
(11, 7, 'bdhvsb', 'word_arrange', NULL, '[\"halo\", \"nama\", \"saya\", \"acca\"]', '[\"halo\",\"nama\",\"saya\",\"acca\"]', NULL, 10, 3, '2026-07-08 22:24:35', '2026-07-08 22:24:35', 1, 30);

-- --------------------------------------------------------

--
-- Table structure for table `quiz_attempts`
--

CREATE TABLE `quiz_attempts` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `lesson_id` bigint UNSIGNED NOT NULL,
  `quiz_id` bigint UNSIGNED NOT NULL,
  `is_correct` tinyint(1) DEFAULT NULL,
  `xp_earned` int DEFAULT '0',
  `attempt_count` int DEFAULT '1',
  `answered_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `quiz_attempts`
--

INSERT INTO `quiz_attempts` (`id`, `user_id`, `lesson_id`, `quiz_id`, `is_correct`, `xp_earned`, `attempt_count`, `answered_at`, `created_at`, `updated_at`) VALUES
(1, 6, 1, 5, 1, 10, 6, '2026-07-05 08:31:08', '2026-07-04 05:41:48', '2026-07-05 08:31:08'),
(2, 6, 1, 6, 0, 10, 6, '2026-07-05 08:31:13', '2026-07-04 05:42:07', '2026-07-05 08:31:13'),
(3, 6, 1, 7, 0, 0, 2, '2026-07-04 06:25:46', '2026-07-04 05:45:49', '2026-07-04 06:25:46'),
(4, 6, 1, 8, 1, 10, 5, '2026-07-04 06:26:03', '2026-07-04 05:46:18', '2026-07-04 06:26:03'),
(5, 6, 1, 3, 1, 10, 6, '2026-07-05 08:31:02', '2026-07-04 05:57:21', '2026-07-05 08:31:02'),
(6, 6, 4, 4, 1, 10, 4, '2026-07-05 09:15:34', '2026-07-05 08:50:35', '2026-07-05 09:15:34'),
(7, 6, 4, 2, 0, 0, 4, '2026-07-05 09:15:39', '2026-07-05 08:50:43', '2026-07-05 09:15:39'),
(8, 3, 4, 4, 1, 10, 1, '2026-07-05 09:08:24', '2026-07-05 09:08:24', '2026-07-05 09:08:24'),
(9, 3, 4, 2, 0, 0, 1, '2026-07-05 09:08:32', '2026-07-05 09:08:32', '2026-07-05 09:08:32'),
(10, 2, 4, 4, 1, 10, 1, '2026-07-07 22:26:48', '2026-07-07 22:26:48', '2026-07-07 22:26:48'),
(11, 2, 4, 2, 0, 0, 1, '2026-07-07 22:26:52', '2026-07-07 22:26:52', '2026-07-07 22:26:52'),
(12, 2, 7, 9, 1, 10, 1, '2026-07-08 22:13:06', '2026-07-08 22:13:06', '2026-07-08 22:13:06'),
(13, 2, 7, 10, 1, 10, 1, '2026-07-08 22:13:42', '2026-07-08 22:13:42', '2026-07-08 22:13:42');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('qx3UWn42osWChNXJZH6rSct0F8h2ktwET4QikfKd', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJxamdFbzdmY2xTZjhEVlJJTHppckp5WEw3NHl0TjR1ajRKb29FYmtUIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2FkbWluXC92b2NhYnVsYXJ5Iiwicm91dGUiOiJhZG1pbi52b2NhYnVsYXJ5LmluZGV4In0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjozfQ==', 1783580764);

-- --------------------------------------------------------

--
-- Table structure for table `student_profiles`
--

CREATE TABLE `student_profiles` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `educational_level` enum('junior_high','senior_high','undergraduate','teacher') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'senior_high',
  `learning_goal` enum('vocabulary','problem_solving','olympiad','international_exams') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'vocabulary',
  `xp_total` int NOT NULL DEFAULT '0',
  `xp_today` int NOT NULL DEFAULT '0',
  `streak_days` int NOT NULL DEFAULT '0',
  `streak_last_activity` date DEFAULT NULL,
  `league` enum('bronze','silver','gold','platinum','diamond','obsidian') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'bronze',
  `current_level` int NOT NULL DEFAULT '1',
  `gems` int NOT NULL DEFAULT '0',
  `hearts` int NOT NULL DEFAULT '5',
  `hearts_max` int NOT NULL DEFAULT '5',
  `avatar_url` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `country` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_profiles`
--

INSERT INTO `student_profiles` (`id`, `user_id`, `educational_level`, `learning_goal`, `xp_total`, `xp_today`, `streak_days`, `streak_last_activity`, `league`, `current_level`, `gems`, `hearts`, `hearts_max`, `avatar_url`, `bio`, `country`, `created_at`, `updated_at`) VALUES
(2, 2, 'senior_high', 'vocabulary', 30, 30, 0, NULL, 'bronze', 1, 0, 5, 5, 'avatars/ZNaYgaNNOriWi7QqLVahKeByYW87GtPApZ1Hul3o.jpg', 'bio', NULL, '2026-06-27 17:40:01', '2026-07-08 22:13:42'),
(3, 3, 'senior_high', 'vocabulary', 10, 10, 0, NULL, 'bronze', 1, 0, 5, 5, NULL, NULL, NULL, '2026-06-27 19:44:41', '2026-07-05 09:08:24'),
(4, 4, 'senior_high', 'vocabulary', 0, 0, 0, NULL, 'bronze', 1, 0, 5, 5, NULL, NULL, NULL, '2026-06-27 22:53:06', '2026-06-27 22:53:06'),
(5, 5, 'senior_high', 'vocabulary', 0, 0, 0, NULL, 'bronze', 1, 0, 5, 5, NULL, NULL, NULL, '2026-06-27 22:54:20', '2026-06-27 22:54:20'),
(6, 6, 'senior_high', 'vocabulary', 10, 10, 0, NULL, 'bronze', 1, 0, 5, 5, NULL, NULL, NULL, '2026-06-29 04:31:36', '2026-07-05 08:50:35'),
(7, 7, 'senior_high', 'vocabulary', 0, 0, 0, NULL, 'bronze', 1, 0, 5, 5, NULL, NULL, NULL, '2026-07-01 22:14:04', '2026-07-01 22:14:04'),
(8, 8, 'senior_high', 'vocabulary', 0, 0, 0, NULL, 'bronze', 1, 0, 5, 5, NULL, NULL, NULL, '2026-07-02 21:33:32', '2026-07-02 21:33:32'),
(9, 9, 'senior_high', 'vocabulary', 0, 0, 0, NULL, 'bronze', 1, 0, 5, 5, NULL, NULL, NULL, '2026-07-04 10:18:14', '2026-07-04 10:18:14');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','student') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'student',
  `status` enum('active','inactive','suspended') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `role`, `status`, `phone`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'miftah Nurrazzaq', 'Miftah', 'miftahnurrazzaq01@gmail.com', 'student', 'active', '0882021973462', NULL, '$2y$12$v5891GUfyi10yzet.GnDOey8XruSJyuFUEl2o2.FitUN410mI0yEu', 'xkjNFocpJKp3IVLqARDcZSMb6VicSZtrLeCdSj0e3U2fKMthEAX8wv3r5h7M', '2026-06-25 03:14:06', '2026-06-27 09:21:02'),
(3, 'Admin1', NULL, 'admin1mathlinggo@gmail.com', 'admin', 'active', NULL, NULL, '$2y$12$xFEp9Ct78TcO2tAwfU1HcOr9qVNdzy21Gv58aoRwlrDDbfa9Nehy2', 'siYwy1iNncqsGDe3gYf87rrC6xtElEhjIuxQUVDmLwsiw3gxGDpPSFrRYfFO', '2026-06-27 19:44:41', '2026-06-27 19:44:41'),
(4, 'admin2', NULL, 'admin2mathlinggo@gmail.com', 'admin', 'active', NULL, NULL, '$2y$12$W.zWH6/PW6wFlV3gwIEvleUWwHXPdS53TmIXGitl61C78hkipacB2', NULL, '2026-06-27 22:53:06', '2026-06-27 22:53:06'),
(5, 'admin3', NULL, 'admin3mathlinggo@gmail.com', 'admin', 'active', NULL, NULL, '$2y$12$CPF2KjtX8Tl1WgjkuSxi1uIfJ5PnumGQOHyEgIccnBCj.CYc0ZnDi', NULL, '2026-06-27 22:54:20', '2026-06-27 22:54:20'),
(6, 'Azizah', NULL, 'azizah@gmail.com', 'student', 'active', NULL, NULL, '$2y$12$shyP8QI2BmJu5aRXfsSwOOF2DDez1frJ56HapyBxI.pnnqk4TDpfG', 'IiuhA6uezY3Xlms5OHhuI6fWyXavqtRmV4uqLDtkUQ1rCDLSxrmz2FWoaJnm', '2026-06-29 04:31:36', '2026-06-29 04:31:36'),
(7, 'guru', NULL, 'guruku@gmail.com', 'student', 'active', NULL, NULL, '$2y$12$Dem66/cxCpm/6GD7MmWAKefpqlEcPhY8.5oJRRQUYBnYzoqMFalii', NULL, '2026-07-01 22:14:04', '2026-07-01 22:14:04'),
(8, 'Lathifa', NULL, 'tifa@gmail.com', 'student', 'active', NULL, NULL, '$2y$12$aQvyoMWT8hjb7JnJKDlILezThDWtL./QIypqPOyWA.UQ.Ovgb7X9W', NULL, '2026-07-02 21:33:32', '2026-07-02 21:33:32'),
(9, 'Aesca', NULL, 'aes@gmail.com', 'student', 'active', NULL, NULL, '$2y$12$1/.x9B.uTvXIAqqPKIOp0OPr6jwrG5fLpUtQZC4o.y9G/Cs7Pjs3m', NULL, '2026-07-04 10:18:14', '2026-07-08 22:16:18');

-- --------------------------------------------------------

--
-- Table structure for table `user_achievements`
--

CREATE TABLE `user_achievements` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `achievement_id` bigint UNSIGNED NOT NULL,
  `earned_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_favorites`
--

CREATE TABLE `user_favorites` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `course_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_progress`
--

CREATE TABLE `user_progress` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `course_id` bigint UNSIGNED NOT NULL,
  `lesson_id` bigint UNSIGNED DEFAULT NULL,
  `status` enum('not_started','in_progress','completed') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'not_started',
  `score` int DEFAULT NULL,
  `xp_earned` int NOT NULL DEFAULT '0',
  `attempts` int NOT NULL DEFAULT '0',
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_progress`
--

INSERT INTO `user_progress` (`id`, `user_id`, `course_id`, `lesson_id`, `status`, `score`, `xp_earned`, `attempts`, `completed_at`, `created_at`, `updated_at`) VALUES
(1, 2, 1, NULL, 'completed', NULL, 10, 1, '2026-06-28 07:07:07', '2026-06-28 07:06:59', '2026-06-28 07:07:07'),
(2, 2, 1, NULL, 'completed', NULL, 10, 1, '2026-06-28 07:07:29', '2026-06-28 07:07:11', '2026-06-28 07:07:29'),
(3, 2, 1, NULL, 'completed', NULL, 10, 1, '2026-07-07 22:28:56', '2026-06-28 21:52:53', '2026-07-07 22:28:56'),
(4, 3, 1, NULL, 'in_progress', NULL, 0, 1, NULL, '2026-06-28 23:51:24', '2026-06-28 23:51:24'),
(5, 6, 1, NULL, 'completed', NULL, 10, 1, '2026-07-02 19:57:59', '2026-07-02 18:54:17', '2026-07-02 19:57:59'),
(6, 6, 1, NULL, 'completed', NULL, 10, 1, '2026-07-02 20:36:51', '2026-07-02 20:36:42', '2026-07-02 20:36:51'),
(7, 6, 1, NULL, 'completed', NULL, 10, 1, '2026-07-02 20:37:04', '2026-07-02 20:37:01', '2026-07-02 20:37:04'),
(8, 6, 1, NULL, 'completed', NULL, 10, 1, '2026-07-04 03:35:47', '2026-07-04 03:35:40', '2026-07-04 03:35:47'),
(9, 9, 1, NULL, 'in_progress', NULL, 0, 1, NULL, '2026-07-04 10:50:57', '2026-07-04 10:50:57'),
(10, 6, 1, NULL, 'in_progress', NULL, 0, 1, NULL, '2026-07-05 09:15:03', '2026-07-05 09:15:03'),
(11, 2, 1, NULL, 'completed', NULL, 10, 1, '2026-07-07 22:29:39', '2026-07-07 22:29:06', '2026-07-07 22:29:39'),
(12, 2, 1, NULL, 'in_progress', NULL, 0, 1, NULL, '2026-07-07 22:30:05', '2026-07-07 22:30:05'),
(13, 2, 1, NULL, 'completed', NULL, 10, 1, '2026-07-07 22:30:23', '2026-07-07 22:30:15', '2026-07-07 22:30:23'),
(14, 2, 4, 7, 'completed', NULL, 10, 1, '2026-07-07 23:03:04', '2026-07-07 23:02:12', '2026-07-07 23:03:04'),
(15, 2, 4, NULL, 'completed', NULL, 0, 0, '2026-07-08 08:18:53', '2026-07-07 23:03:04', '2026-07-08 08:18:53'),
(16, 2, 4, NULL, 'completed', NULL, 10, 1, '2026-07-08 08:18:30', '2026-07-08 08:18:27', '2026-07-08 08:18:30'),
(17, 2, 4, NULL, 'completed', NULL, 10, 1, '2026-07-08 08:18:52', '2026-07-08 08:18:36', '2026-07-08 08:18:52'),
(18, 2, 4, NULL, 'completed', NULL, 10, 1, '2026-07-08 08:18:44', '2026-07-08 08:18:42', '2026-07-08 08:18:44');

-- --------------------------------------------------------

--
-- Table structure for table `vocabularies`
--

CREATE TABLE `vocabularies` (
  `id` bigint UNSIGNED NOT NULL,
  `lesson_id` bigint UNSIGNED NOT NULL,
  `term` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `english_word` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `indonesian_meaning` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pronunciation` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `example_sentence` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `example_translation` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `audio` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `difficulty` enum('beginner','intermediate','advanced') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'beginner',
  `audio_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mathematical_meaning` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `example` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `translation` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `formula` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vocabularies`
--

INSERT INTO `vocabularies` (`id`, `lesson_id`, `term`, `english_word`, `indonesian_meaning`, `pronunciation`, `example_sentence`, `example_translation`, `image`, `audio`, `sort_order`, `is_active`, `created_at`, `updated_at`, `difficulty`, `audio_path`, `mathematical_meaning`, `example`, `translation`, `formula`) VALUES
(4, 7, 'Addition', NULL, NULL, NULL, 'Five plus three equals eight.', NULL, 'vocabulary-images/0yAgkXzmzZ89nbzkWEWQLs97XzJUMY1F87jgALJu.jpg', NULL, 1, 1, '2026-07-07 22:53:06', '2026-07-08 08:07:58', 'beginner', NULL, 'Addition is the mathematical operation of combining two or more numbers to obtain their total.', '5 + 3 = 8', 'Penjumlahan', 'a + b = c');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `achievements`
--
ALTER TABLE `achievements`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `ai_conversations`
--
ALTER TABLE `ai_conversations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `ai_messages`
--
ALTER TABLE `ai_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `conversation_id` (`conversation_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `certificates`
--
ALTER TABLE `certificates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `certificate_number` (`certificate_number`),
  ADD UNIQUE KEY `certificates_user_id_course_id_unique` (`user_id`,`course_id`),
  ADD KEY `certificates_course_id_foreign` (`course_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `courses_slug_unique` (`slug`),
  ADD KEY `idx_courses_deleted_at` (`deleted_at`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  ADD KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lessons_course_slug_unique` (`course_id`,`slug`),
  ADD KEY `lessons_course_id_foreign` (`course_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quizzes_lesson_id_foreign` (`lesson_id`);

--
-- Indexes for table `quiz_attempts`
--
ALTER TABLE `quiz_attempts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_quiz` (`user_id`,`quiz_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `student_profiles`
--
ALTER TABLE `student_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_profiles_user_id_unique` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `idx_users_status` (`status`),
  ADD KEY `idx_users_role` (`role`),
  ADD KEY `idx_users_created_at` (`created_at`);

--
-- Indexes for table `user_achievements`
--
ALTER TABLE `user_achievements`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_achievement_unique` (`user_id`,`achievement_id`),
  ADD KEY `user_achievements_user_id_idx` (`user_id`),
  ADD KEY `user_achievements_achievement_id_idx` (`achievement_id`);

--
-- Indexes for table `user_favorites`
--
ALTER TABLE `user_favorites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_favorite` (`user_id`,`course_id`),
  ADD KEY `fk_favorite_course` (`course_id`);

--
-- Indexes for table `user_progress`
--
ALTER TABLE `user_progress`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_progress_user_course_lesson_unique` (`user_id`,`course_id`,`lesson_id`),
  ADD KEY `user_progress_course_id_foreign` (`course_id`),
  ADD KEY `user_progress_lesson_id_foreign` (`lesson_id`);

--
-- Indexes for table `vocabularies`
--
ALTER TABLE `vocabularies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vocabularies_lesson_id_index` (`lesson_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `achievements`
--
ALTER TABLE `achievements`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ai_conversations`
--
ALTER TABLE `ai_conversations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `ai_messages`
--
ALTER TABLE `ai_messages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `certificates`
--
ALTER TABLE `certificates`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `quiz_attempts`
--
ALTER TABLE `quiz_attempts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `student_profiles`
--
ALTER TABLE `student_profiles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user_achievements`
--
ALTER TABLE `user_achievements`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_favorites`
--
ALTER TABLE `user_favorites`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_progress`
--
ALTER TABLE `user_progress`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `vocabularies`
--
ALTER TABLE `vocabularies`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ai_conversations`
--
ALTER TABLE `ai_conversations`
  ADD CONSTRAINT `ai_conversations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ai_messages`
--
ALTER TABLE `ai_messages`
  ADD CONSTRAINT `ai_messages_conversation_id_foreign` FOREIGN KEY (`conversation_id`) REFERENCES `ai_conversations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `certificates`
--
ALTER TABLE `certificates`
  ADD CONSTRAINT `certificates_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `certificates_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lessons`
--
ALTER TABLE `lessons`
  ADD CONSTRAINT `lessons_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD CONSTRAINT `quizzes_lesson_id_foreign` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `student_profiles`
--
ALTER TABLE `student_profiles`
  ADD CONSTRAINT `student_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_achievements`
--
ALTER TABLE `user_achievements`
  ADD CONSTRAINT `fk_user_achievement_achievement` FOREIGN KEY (`achievement_id`) REFERENCES `achievements` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_user_achievement_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_favorites`
--
ALTER TABLE `user_favorites`
  ADD CONSTRAINT `fk_favorite_course` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_favorite_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_progress`
--
ALTER TABLE `user_progress`
  ADD CONSTRAINT `user_progress_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_progress_lesson_id_foreign` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `user_progress_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `vocabularies`
--
ALTER TABLE `vocabularies`
  ADD CONSTRAINT `vocabularies_lesson_fk` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
