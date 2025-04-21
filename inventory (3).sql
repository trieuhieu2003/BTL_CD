-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 21, 2025 lúc 06:53 AM
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
-- Cơ sở dữ liệu: `inventory`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_product`
--

CREATE TABLE `order_product` (
  `id` int(11) NOT NULL,
  `supplier` int(11) NOT NULL,
  `product` int(11) NOT NULL,
  `quantity_ordered` int(11) NOT NULL,
  `quantity_received` int(11) DEFAULT NULL,
  `quantity_remaining` int(11) DEFAULT NULL,
  `batch` int(20) NOT NULL,
  `status` varchar(20) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order_product`
--

INSERT INTO `order_product` (`id`, `supplier`, `product`, `quantity_ordered`, `quantity_received`, `quantity_remaining`, `batch`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(6, 8, 20, 12, 6, 6, 1743777251, 'incomplete', 6, '2025-04-04 16:34:11', '2025-04-04 16:34:11'),
(7, 7, 19, 122, NULL, NULL, 1743777315, 'pending', 6, '2025-04-04 16:35:15', '2025-04-04 16:35:15'),
(8, 8, 20, 44444, 0, 44444, 1743782138, 'complete', 6, '2025-04-04 17:55:38', '2025-04-04 17:55:38'),
(9, 7, 19, 12312, 12312, 0, 1743783733, 'complete', 6, '2025-04-04 18:22:13', '2025-04-04 18:22:13'),
(10, 7, 20, 12312321, 212121, 12100200, 1743822603, 'incomplete', 6, '2025-04-05 05:10:03', '2025-04-05 05:10:03'),
(11, 7, 20, 12, NULL, NULL, 1745211149, 'pending', 6, '2025-04-21 06:52:29', '2025-04-21 06:52:29');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_product_history`
--

CREATE TABLE `order_product_history` (
  `id` int(11) NOT NULL,
  `order_product_id` int(11) NOT NULL,
  `qty_received` int(11) NOT NULL,
  `date_received` int(11) NOT NULL,
  `date_updated` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(191) NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  `img` varchar(100) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `product_name`, `description`, `img`, `created_by`, `created_at`, `updated_at`, `stock`) VALUES
(16, 'SỮA MILO', 'SỮA', 'product-1743775875.jpg', 6, '2025-04-04 16:11:15', '2025-04-04 16:11:15', 0),
(17, 'MÌ HẢO HẢO', 'MÌ TÔM', 'product-1743776014.jpg', 6, '2025-04-04 16:13:34', '2025-04-04 16:13:34', 0),
(18, 'BỘT GIẶT OMO', 'BỘT GIẶT', 'product-1743776045.png', 6, '2025-04-04 16:14:05', '2025-04-04 16:14:05', 0),
(19, 'TƯƠNG ỚT CHISU', 'tương ới', 'product-1743776102.webp', 6, '2025-04-04 16:15:02', '2025-04-04 16:15:02', 0),
(20, 'NƯỚC MẮM NAM NGƯ', 'NƯỚC MẮM 11', 'product-1743776215.webp', 6, '2025-04-04 16:16:55', '2025-04-04 16:16:55', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `productsuppliers`
--

CREATE TABLE `productsuppliers` (
  `id` int(11) NOT NULL,
  `supplier` int(11) NOT NULL,
  `product` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `productsuppliers`
--

INSERT INTO `productsuppliers` (`id`, `supplier`, `product`, `updated_at`, `created_at`) VALUES
(17, 5, 14, '2025-04-03 11:02:34', '2025-04-03 11:02:34'),
(18, 6, 15, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(19, 5, 16, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(20, 7, 17, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(21, 8, 18, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(22, 7, 19, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(24, 7, 20, '2025-04-04 18:04:35', '2025-04-04 18:04:35');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL,
  `supplier_name` varchar(191) NOT NULL,
  `supplier_location` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `suppliers`
--

INSERT INTO `suppliers` (`id`, `supplier_name`, `supplier_location`, `email`, `created_by`, `created_at`, `updated_at`) VALUES
(5, 'tandep', 'NinhBinh', 'dotrungtan31@gmail.com', 2, '2025-03-19 04:00:20', '2025-03-19 04:00:20'),
(7, 'Minh Hiếu ', 'Quốc Oai', 'hieu123@gmail.com', 6, '2025-04-04 16:12:04', '2025-04-04 16:12:04'),
(8, 'Văn Đức', 'Gia Lâm', 'ducdzai123@gmail.com', 6, '2025-04-04 16:12:44', '2025-04-04 16:12:44');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `password` varchar(300) NOT NULL,
  `email` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `permissions` varchar(5000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `password`, `email`, `created_at`, `updated_at`, `permissions`) VALUES
(2, 'Chi', 'Vu', 'linhchi', 'linhchi@gmail.com', '2025-02-25 17:49:13', '0000-00-00 00:00:00', 'dashboard_view,product_view,supplier_view'),
(3, 'Dat', 'tien', '123', 'tiendat@gmail.com', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'product_view,supplier_view,user_view,po_view,report_view,dashboard_view'),
(4, 'ha', 'hung', '234', 'hungha@gmail.com', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'dashboard_view'),
(6, 'ha', 'hung', 'hihi', 'huy@gmail.com', '2025-03-18 04:25:26', '0000-00-00 00:00:00', 'dashboard_view,report_view,po_view,product_view,supplier_view,user_view,product_create,product_edit,po_create,po_edit,product_delete,supplier_edit,supplier_create,supplier_delete,pos,user_edit,user_create,user_delete');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `order_product`
--
ALTER TABLE `order_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_supplier_ibfk_1` (`supplier`),
  ADD KEY `product_supplier_ibfk_2` (`product`),
  ADD KEY `product_supplier_ibfk_3` (`created_by`);

--
-- Chỉ mục cho bảng `order_product_history`
--
ALTER TABLE `order_product_history`
  ADD KEY `order_product_history_ibfk_1` (`order_product_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user` (`created_by`);

--
-- Chỉ mục cho bảng `productsuppliers`
--
ALTER TABLE `productsuppliers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product` (`product`),
  ADD KEY `supplier` (`supplier`);

--
-- Chỉ mục cho bảng `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_created_by` (`created_by`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `order_product`
--
ALTER TABLE `order_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT cho bảng `productsuppliers`
--
ALTER TABLE `productsuppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `order_product`
--
ALTER TABLE `order_product`
  ADD CONSTRAINT `order_product_ibfk_1` FOREIGN KEY (`supplier`) REFERENCES `suppliers` (`id`),
  ADD CONSTRAINT `order_product_ibfk_2` FOREIGN KEY (`product`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `order_product_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `order_product_history`
--
ALTER TABLE `order_product_history`
  ADD CONSTRAINT `order_product_history_ibfk_1` FOREIGN KEY (`order_product_id`) REFERENCES `order_product` (`id`);

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `suppliers`
--
ALTER TABLE `suppliers`
  ADD CONSTRAINT `fk_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
