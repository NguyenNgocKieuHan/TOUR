-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th9 06, 2024 lúc 03:17 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `tour`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bookings`
--

CREATE TABLE `bookings` (
  `BOOKINGID` int(11) NOT NULL,
  `USERID` int(11) NOT NULL,
  `TOURID` int(11) NOT NULL,
  `BOOKINGDATE` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `NUMOFPEOPLE` int(11) NOT NULL,
  `TOTALPRICE` decimal(10,0) NOT NULL,
  `STATUS` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chatbotconversions`
--

CREATE TABLE `chatbotconversions` (
  `CHATID` int(11) NOT NULL,
  `USERID` int(11) NOT NULL,
  `MESAGE` text NOT NULL,
  `BOTRESPONSE` text NOT NULL,
  `CONVERSATIONTIME` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chatbotlogs`
--

CREATE TABLE `chatbotlogs` (
  `LOGID` int(11) NOT NULL,
  `USERID` int(11) NOT NULL,
  `ACTION` varchar(255) NOT NULL,
  `DETAILS` text NOT NULL,
  `LOGDATE` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `city`
--

CREATE TABLE `city` (
  `CITYID` int(11) NOT NULL,
  `CITYNAME` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `city`
--

INSERT INTO `city` (`CITYID`, `CITYNAME`) VALUES
(1, 'Cần Thơ');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contact`
--

CREATE TABLE `contact` (
  `CONTACTID` int(11) NOT NULL,
  `USERID` int(11) NOT NULL,
  `MESAGE` text NOT NULL,
  `CONTACTDATE` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `destination`
--

CREATE TABLE `destination` (
  `DESTINATIONID` int(11) NOT NULL,
  `DISTRICTID` int(11) NOT NULL,
  `TOURID` int(11) NOT NULL,
  `DESTINATIONNAME` varchar(255) NOT NULL,
  `IMAGE` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `district`
--

CREATE TABLE `district` (
  `DISTRICTID` int(11) NOT NULL,
  `CITYID` int(11) NOT NULL,
  `DISTRICTNAME` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `district`
--

INSERT INTO `district` (`DISTRICTID`, `CITYID`, `DISTRICTNAME`) VALUES
(1, 1, 'Ninh Kiều'),
(2, 1, 'Cái Răng'),
(3, 1, 'Phong Điền'),
(4, 1, 'Thốt Nốt'),
(5, 1, 'Bình Thủy');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `faqs`
--

CREATE TABLE `faqs` (
  `FAQID` int(11) NOT NULL,
  `LOGID` int(11) NOT NULL,
  `QUESTION` text NOT NULL,
  `ANSWER` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reviews`
--

CREATE TABLE `reviews` (
  `REVIEWID` int(11) NOT NULL,
  `USERID` int(11) NOT NULL,
  `TOURID` int(11) NOT NULL,
  `RATING` int(11) NOT NULL,
  `COMMENT` text NOT NULL,
  `POSTDATE` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tour`
--

CREATE TABLE `tour` (
  `TOURID` int(11) NOT NULL,
  `TOURTYPEID` int(11) NOT NULL,
  `TOURNAME` varchar(255) NOT NULL,
  `DESCRIPTION` text NOT NULL,
  `PRICE` varchar(10) NOT NULL,
  `TIME` varchar(255) NOT NULL,
  `IMAGE` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tourtype`
--

CREATE TABLE `tourtype` (
  `TOURTYPEID` int(11) NOT NULL,
  `TOURTYPENAME` varchar(255) NOT NULL,
  `DESCRIPTION` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tourtype`
--

INSERT INTO `tourtype` (`TOURTYPEID`, `TOURTYPENAME`, `DESCRIPTION`) VALUES
(1, 'Tour du lịch sông nước', 'Thưởng ngoạn cảnh đẹp sông nước, trải nghiệm cuộc sống người dân miền Tây'),
(2, 'Tour du lịch văn hóa - lịch sử', 'Tham quan các điểm di tích và các ngôi chùa nổi tiếng'),
(3, 'Tour du lịch sinh thái-ẩm thực', ' Khám phá vườn trái cây, khu du lịch, thưởng thức các món ăn đặc sản miền Tây, tham gia vào các hoạt động chế biến món ăn truyền thống.'),
(4, 'Tour làng nghề', ' Tham quan các làng nghề truyền thống như làm bánh tráng, làm hủ tiếu, làm lúa giống,Trải nghiệm cuộc sống nông thôn, tham gia vào các hoạt động nông nghiệp như bắt cá, trồng lúa, thu hoạch trái cây.\r\n');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `USERID` int(11) NOT NULL,
  `NAME` varchar(255) NOT NULL,
  `EMAIL` varchar(255) NOT NULL,
  `SDT` varchar(10) NOT NULL,
  `PASSWORD` varchar(255) NOT NULL,
  `USERTYPE` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`USERID`, `NAME`, `EMAIL`, `SDT`, `PASSWORD`, `USERTYPE`) VALUES
(1, 'Nguyễn Ngọc Kiều Hân', 'hanb2003783@student.ctu.edu.vn', '0987654321', '$2y$10$5ACFEwJRdh5DZMhQ2FFnee/YLnnLkMP.6/a01uDseG4V2xKN85Gte', 'Quản trị viên'),
(2, 'Nguyễn Ngọc Kiều Hân', 'han@gmail.com', '0567839027', '$2y$10$kgAScCLH.dtZVnrpn2CAp.qv0eyfa351Ek6.t2IzCExAl4158Jr3S', 'Khách Hàng');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`BOOKINGID`),
  ADD KEY `FK_SE_CHON` (`USERID`),
  ADD KEY `FK_SE_DUOC` (`TOURID`);

--
-- Chỉ mục cho bảng `chatbotconversions`
--
ALTER TABLE `chatbotconversions`
  ADD PRIMARY KEY (`CHATID`),
  ADD KEY `FK_SE` (`USERID`);

--
-- Chỉ mục cho bảng `chatbotlogs`
--
ALTER TABLE `chatbotlogs`
  ADD PRIMARY KEY (`LOGID`),
  ADD KEY `FK_SE_XEM` (`USERID`);

--
-- Chỉ mục cho bảng `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`CITYID`);

--
-- Chỉ mục cho bảng `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`CONTACTID`),
  ADD KEY `FK_CO_THE` (`USERID`);

--
-- Chỉ mục cho bảng `destination`
--
ALTER TABLE `destination`
  ADD PRIMARY KEY (`DESTINATIONID`),
  ADD KEY `FK_CHON` (`TOURID`),
  ADD KEY `FK_SE_CO` (`DISTRICTID`);

--
-- Chỉ mục cho bảng `district`
--
ALTER TABLE `district`
  ADD PRIMARY KEY (`DISTRICTID`),
  ADD KEY `FK_BAO_GOM` (`CITYID`);

--
-- Chỉ mục cho bảng `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`FAQID`),
  ADD KEY `FK_SE_DUOC_HUAN_LUYEN` (`LOGID`);

--
-- Chỉ mục cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`REVIEWID`),
  ADD KEY `FK_CO_QUYEN` (`USERID`),
  ADD KEY `FK_TRONG` (`TOURID`);

--
-- Chỉ mục cho bảng `tour`
--
ALTER TABLE `tour`
  ADD PRIMARY KEY (`TOURID`),
  ADD KEY `FK_THUOC` (`TOURTYPEID`);

--
-- Chỉ mục cho bảng `tourtype`
--
ALTER TABLE `tourtype`
  ADD PRIMARY KEY (`TOURTYPEID`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`USERID`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `USERID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `FK_SE_CHON` FOREIGN KEY (`USERID`) REFERENCES `users` (`USERID`),
  ADD CONSTRAINT `FK_SE_DUOC` FOREIGN KEY (`TOURID`) REFERENCES `tour` (`TOURID`);

--
-- Các ràng buộc cho bảng `chatbotconversions`
--
ALTER TABLE `chatbotconversions`
  ADD CONSTRAINT `FK_SE` FOREIGN KEY (`USERID`) REFERENCES `users` (`USERID`);

--
-- Các ràng buộc cho bảng `chatbotlogs`
--
ALTER TABLE `chatbotlogs`
  ADD CONSTRAINT `FK_SE_XEM` FOREIGN KEY (`USERID`) REFERENCES `users` (`USERID`);

--
-- Các ràng buộc cho bảng `contact`
--
ALTER TABLE `contact`
  ADD CONSTRAINT `FK_CO_THE` FOREIGN KEY (`USERID`) REFERENCES `users` (`USERID`);

--
-- Các ràng buộc cho bảng `destination`
--
ALTER TABLE `destination`
  ADD CONSTRAINT `FK_CHON` FOREIGN KEY (`TOURID`) REFERENCES `tour` (`TOURID`),
  ADD CONSTRAINT `FK_SE_CO` FOREIGN KEY (`DISTRICTID`) REFERENCES `district` (`DISTRICTID`);

--
-- Các ràng buộc cho bảng `district`
--
ALTER TABLE `district`
  ADD CONSTRAINT `FK_BAO_GOM` FOREIGN KEY (`CITYID`) REFERENCES `city` (`CITYID`);

--
-- Các ràng buộc cho bảng `faqs`
--
ALTER TABLE `faqs`
  ADD CONSTRAINT `FK_SE_DUOC_HUAN_LUYEN` FOREIGN KEY (`LOGID`) REFERENCES `chatbotlogs` (`LOGID`);

--
-- Các ràng buộc cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `FK_CO_QUYEN` FOREIGN KEY (`USERID`) REFERENCES `users` (`USERID`),
  ADD CONSTRAINT `FK_TRONG` FOREIGN KEY (`TOURID`) REFERENCES `tour` (`TOURID`);

--
-- Các ràng buộc cho bảng `tour`
--
ALTER TABLE `tour`
  ADD CONSTRAINT `FK_THUOC` FOREIGN KEY (`TOURTYPEID`) REFERENCES `tourtype` (`TOURTYPEID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
