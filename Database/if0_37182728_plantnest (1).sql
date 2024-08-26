-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql207.byetcluster.com
-- Generation Time: Aug 26, 2024 at 01:37 PM
-- Server version: 10.6.19-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_37182728_plantnest`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `password`, `image`) VALUES
(1, 'Admin', 'admin@gmail.com', '123456', 'foggperfume.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `pro_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `price`, `quantity`, `pro_id`, `user_id`) VALUES
(13, 300, 5, 9, 6),
(14, 350, 1, 16, 6);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `name`, `description`, `image`, `status`) VALUES
(5, 'Plantsw', 'Plants enhance any space with their vibrant colors and lush foliage. They purify the air, reduce stress, and bring a touch of nature indoors, fostering well-being.', 'plantscatimg.jpg', 1),
(6, 'Accessories', 'Plant accessories elevate your green space, including stylish pots, sturdy stands, and decorative trays. These enhance plant displays, ensure proper growth, and add charm to your dÃ©cor.', 'plantsaccessoriesimg.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `feedbacks`
--

CREATE TABLE `feedbacks` (
  `feedback_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `feedback` varchar(1200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedbacks`
--

INSERT INTO `feedbacks` (`feedback_id`, `name`, `email`, `feedback`) VALUES
(1, 'Irfan', 'irfan@gmail.com', 'This is irfan feedback'),
(2, 'example', 'example@demo.com', 'This is example feedback\r\n'),
(3, 'fariha', 'farihafari594@gmail.com', 'good\r\n'),
(4, 'ahmed', 'ahmed@gmail.com', 'This website is good');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Pending',
  `order_date` datetime NOT NULL,
  `pro_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `price`, `quantity`, `status`, `order_date`, `pro_id`, `user_id`) VALUES
(15, 250, 1, 'Approved', '2024-08-26 07:14:56', 11, 6),
(16, 350, 1, 'Pending', '2024-08-26 07:14:56', 15, 6),
(17, 800, 12, 'Ontheway', '2024-08-26 07:14:56', 18, 6),
(18, 100, 15, 'Delivered', '2024-08-26 07:15:26', 13, 6),
(19, 300, 3, 'Rejected', '2024-08-26 07:15:53', 9, 6),
(20, 350, 5, 'Pending', '2024-08-26 07:19:15', 16, 6),
(21, 120, 3, 'Cancelled', '2024-08-26 07:19:15', 14, 6),
(22, 200, 1, 'Cancelled', '2024-08-26 07:20:18', 20, 6),
(23, 300, 1, 'Delivered', '2024-08-26 08:09:06', 9, 8),
(24, 350, 1, 'Rejected', '2024-08-26 08:09:06', 15, 8),
(25, 300, 6, 'Pending', '2024-08-26 08:35:45', 9, 6);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `short_info` varchar(255) NOT NULL,
  `description` varchar(1200) NOT NULL,
  `availibility` varchar(255) NOT NULL DEFAULT 'In Stock',
  `image` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `cat_id` int(11) NOT NULL,
  `subcat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `name`, `price`, `short_info`, `description`, `availibility`, `image`, `status`, `cat_id`, `subcat_id`) VALUES
(9, 'Sunflower', '300', 'Sunflowers (Helianthus annuus) are tall annuals with large, bright yellow blooms that track the sun and produce edible seeds.', 'Sunflowers (Helianthus annuus) are bright, tall annual plants known for their large, daisy-like flowers with vibrant yellow petals and a central disk that contains seeds. They typically grow 6 to 10 feet tall, though some varieties can be even taller. Sunflowers are known for their heliotropic behavior, meaning their flower heads track the sun\'s movement across the sky. ', 'In Stock', '9.jpeg', 1, 5, 8),
(10, 'Hibiscus', '150', 'Hibiscus is a tropical plant known for its large, vibrant flowers in colors like red, pink, and yellow. It\'s often used for ornamental purposes and thrives in warm climates with plenty of sunlight.', 'Hibiscus is a vibrant, tropical plant known for its large, showy flowers that come in a range of colors, including red, pink, orange, and yellow. The plant features broad, glossy green leaves and can grow as a shrub, bush, or small tree, depending on the variety. Hibiscus thrives in warm climates with plenty of sunlight and well-drained soil, making it ideal for tropical and subtropical gardens. In cooler regions, it can be grown indoors. ', 'Out Of Stock', '10.jpg', 1, 5, 8),
(11, 'Roses', '250', 'Roses (Rosa) are classic flowering shrubs renowned for their beautiful and fragrant blooms. They come in a wide range of colors, including red, pink, white, yellow, and orange, and are often associated with love and romance.', 'Roses thrive in well-drained soil and require ample sunlight, ideally receiving at least six hours of direct sun per day. They need regular watering and benefit from occasional feeding with a balanced fertilizer. Pruning is essential to maintain their shape, encourage new growth, and remove dead or diseased wood. While they are relatively hardy, roses can be susceptible to pests and diseases, so monitoring and proper care are crucial. Roses are widely used in gardens, as cut flowers, and in various cultural and ceremonial contexts.', 'In Stock', 'roseproduct.jpg', 1, 5, 8),
(12, 'Ferns', '100', ' Ferns are ancient, non-flowering plants known for their delicate, feathery foliage. They reproduce via spores rather than seeds and thrive in moist, shaded environments. ', 'Ferns prefer indirect light and high humidity, making them ideal for indoor settings or shaded garden areas. They generally require well-drained, rich soil and consistent moisture to thrive. While ferns are low-maintenance, they should be protected from direct sunlight and extreme temperatures. They are popular in both indoor and outdoor gardening for their lush, green appearance and ability to add a touch of elegance to various landscapes.', 'Out Of Stock', 'fernsproduct.jpg', 1, 5, 9),
(13, 'Moneyplant', '100', 'The Money Plant, commonly known as Pothos (Epipremnum aureum), is a popular indoor plant appreciated for its low-maintenance care and attractive foliage. ', 'Money Plants are versatile and can thrive in various lighting conditions, from low light to bright, indirect light. They prefer well-drained soil and should be watered when the top inch of soil feels dry. Pothos can grow as a trailing vine or be trained to climb with the help of a support structure. It\'s an ideal choice for beginners due to its resilience and adaptability.', 'In Stock', 'moneyplantproduct.jpg', 1, 5, 10),
(14, 'Aloe vera', '120', ' Aloe vera is a succulent plant renowned for its soothing gel-filled leaves and ease of care. It features thick, fleshy leaves with serrated edges that contain a clear, gel-like substance known for its skin-healing properties. ', '\r\nAloe vera is a succulent plant renowned for its soothing gel-filled leaves and ease of care. It features thick, fleshy leaves with serrated edges that contain a clear, gel-like substance known for its skin-healing properties. Aloe vera thrives in bright, indirect sunlight and requires well-drained soil to prevent root rot. It\'s drought-tolerant and should be watered infrequently, allowing the soil to dry out between waterings. In addition to its use in skincare for treating burns, cuts, and moisturization, Aloe vera is often grown as an ornamental plant due to its striking appearance and minimal maintenance needs.', 'In Stock', 'aloveraproduct', 1, 5, 10),
(15, 'Neem', '350', 'Neem (Azadirachta indica) is a versatile, fast-growing tree native to the Indian subcontinent and known for its numerous medicinal and practical uses. ', 'Neem is also renowned in traditional medicine for its antibacterial, antifungal, and anti-inflammatory properties. Various parts of the tree, including the leaves, bark, seeds, and oil, are used in treatments for skin conditions, dental care, and overall health. Neem trees are hardy and can grow in a variety of soil types, thriving in tropical and subtropical climates.', 'In Stock', 'neemproduct', 1, 5, 11),
(16, 'Ceramin pots', '350', 'Ceramic pots are popular for their aesthetic appeal and durability. Made from clay and fired at high temperatures, they come in various shapes, sizes, and finishes, including glazed and unglazed options. ', 'Ceramic pots are popular for their aesthetic appeal and durability. Made from clay and fired at high temperatures, they come in various shapes, sizes, and finishes, including glazed and unglazed options. These pots are known for their elegant appearance and can enhance both indoor and outdoor spaces. They offer good durability and can insulate plant roots from temperature fluctuations. Unglazed ceramic pots provide better air and moisture flow, aiding in root health. However, they can be heavy and may require proper drainage to prevent waterlogging.', 'In Stock', 'ceramicpot.jpg', 1, 6, 12),
(17, 'Clay Pots', '150', 'Clay pots are traditional and versatile containers for plants, valued for their natural look and breathability. ', 'Clay pots are traditional and versatile containers for plants, valued for their natural look and breathability. Made from fired clay, they come in various sizes and shapes and are often unglazed, allowing air and moisture to flow through the porous material. This feature helps prevent root rot by promoting better drainage and reducing waterlogging. Clay pots also offer good thermal insulation, which can help protect plant roots from temperature extremes. However, they can be heavy and may dry out soil more quickly due to their porous nature. Additionally, they may crack in freezing temperatures if not properly cared for.', 'Out Of Stock', 'claypotprodcut.jpg', 1, 6, 12),
(18, 'Compost', '800', 'Compost is a nutrient-rich, organic material created through the decomposition of plant and animal matter. ', 'Compost is a nutrient-rich, organic material created through the decomposition of plant and animal matter. It is commonly used as a natural fertilizer and soil amendment to improve soil structure, fertility, and moisture retention. Composting involves combining green materials (like vegetable scraps and grass clippings) with brown materials (like dried leaves and cardboard), along with water and air, to create an environment where microorganisms break down the organic matter. The resulting compost is dark, crumbly, and has a pleasant earthy smell. It enriches soil with essential nutrients, supports beneficial microorganisms, and enhances plant growth while reducing waste and recycling organic materials.', 'In Stock', 'oraganicwayorganicfertilizer.jpg', 1, 6, 13),
(19, 'Cocopeat', '600', 'Cocopeat, also known as coir pith, is a sustainable, organic growing medium derived from the fibrous husks of coconuts.', 'Cocopeat, also known as coir pith, is a sustainable, organic growing medium derived from the fibrous husks of coconuts. It excels in water retention and aeration, making it an excellent choice for gardening and hydroponics. Cocopeat holds moisture effectively while allowing excess water to drain, helping to prevent root rot. Its fibrous texture ensures good air circulation around plant roots. As a renewable resource, cocopeat offers an eco-friendly alternative to peat moss, which is harvested from non-renewable sources. It typically has a neutral to slightly acidic pH, suitable for a wide range of plants, and can be used alone or mixed with other growing mediums.', 'In Stock', 'cocopeatproduct.jpg', 1, 6, 13),
(20, 'Shovel', '200', 'A gardening shovel is a versatile tool designed for digging, planting, and moving soil or other materials in the garden.', '\r\nA gardening shovel is a versatile tool designed for digging, planting, and moving soil or other materials in the garden. It typically features a broad, flat blade with a slightly curved edge, making it ideal for tasks such as digging holes, turning soil, and lifting plants. The handle is usually long and sturdy, often made of wood or metal, and ergonomically designed for comfort and ease of use. Some gardening shovels have additional features like pointed tips for breaking through tough soil or scoops for transporting loose materials. This essential tool is crucial for various gardening tasks, from preparing garden beds to transplanting seedlings.', 'In Stock', 'gardeningshovelproduct.jpeg', 1, 6, 14);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `review` varchar(1200) NOT NULL,
  `rating` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `pro_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`review_id`, `review`, `rating`, `order_id`, `pro_id`, `user_id`) VALUES
(7, 'This is good', 3, 18, 13, 6),
(8, 'This is good', 3, 18, 13, 6),
(9, 'This is good', 3, 18, 13, 6),
(10, 'This is good', 3, 18, 13, 6);

-- --------------------------------------------------------

--
-- Table structure for table `subcategories`
--

CREATE TABLE `subcategories` (
  `subcategory_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `cat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subcategories`
--

INSERT INTO `subcategories` (`subcategory_id`, `name`, `description`, `image`, `status`, `cat_id`) VALUES
(8, 'Flowering Plants', 'Flowering plants brighten any space with vibrant blooms and delightful fragrances. They add color, beauty, and charm to gardens and interiors, creating a lively and refreshing atmosphere.', 'floweringplantssubcategory.jpg', 1, 5),
(9, 'Non Flowering Plants', 'Non-flowering plants, also known as non-angiosperms, are a diverse group of plants that reproduce without the production of flowers. Instead of using flowers to attract pollinators, they rely on other methods for reproduction.', 'nonfloweringsubcateogryimg.jpg', 1, 5),
(10, 'Indoor Plants', 'Indoor plants are versatile and popular additions to indoor spaces, offering aesthetic appeal, improved air quality, and a touch of nature to various environments.', 'indoorplantssubcatimg.jpeg', 1, 5),
(11, 'Outdoor plants', 'Outdoor plants are essential for gardens, landscapes, and natural settings. They provide beauty, habitat, and ecological benefits.', 'outdoorplantssubcatimg.jpg', 1, 5),
(12, 'Pots', 'Plant pots, also known as plant containers or planters, are essential for growing and displaying plants. They come in a variety of materials, sizes, and styles, each suited to different needs and preferences. ', 'potscatimg.jpeg', 1, 6),
(13, 'Organic Ferilizer', 'Organic fertilizers are derived from natural sources and are used to enrich the soil and provide essential nutrients to plants. They are often favored for their environmental benefits and ability to improve soil health over time. ', 'fertilizersubcatimg.jpg', 1, 6),
(14, 'Gardening Tools', 'Gardening tools are essential for maintaining and cultivating a garden, helping gardeners perform various tasks with efficiency and ease. ', 'gardeningtoolssubcateogryimg.jpg', 1, 6);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(1000) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `address`, `image`) VALUES
(5, 'a', 'a@gmail.com', '123', '123', 'cjimage.jpeg'),
(6, 'Irfan', 'irfan@gmail.com', '12345', '123 street abc city', 'user3.jpg'),
(7, 'Bilal', 'bilal@gmail.com', '12345', '1234 street xyz city ', 'user2.jpg'),
(8, 'fariha', 'farihafari594@gmail.com', '123', 'karachi', 'contact-bg.jpg'),
(9, 'Example', 'demo@gmail.com', '123456', '123 city example zxy', 'mechanicalwatch.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `wishlist_id` int(11) NOT NULL,
  `pro_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`wishlist_id`, `pro_id`, `user_id`) VALUES
(29, 10, 6),
(36, 12, 6),
(38, 16, 6);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `cart_pro_id` (`pro_id`),
  ADD KEY `cart_user_id` (`user_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD PRIMARY KEY (`feedback_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `order_pro_id` (`pro_id`),
  ADD KEY `order_user_id` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `pro_subcat_id` (`subcat_id`),
  ADD KEY `pro_cat_id` (`cat_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `review_order_id` (`order_id`),
  ADD KEY `review_pro_id` (`pro_id`),
  ADD KEY `review_user_id` (`user_id`);

--
-- Indexes for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`subcategory_id`),
  ADD KEY `cat_id` (`cat_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`wishlist_id`),
  ADD KEY `product_id` (`pro_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `feedbacks`
--
ALTER TABLE `feedbacks`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `subcategory_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `wishlist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_pro_id` FOREIGN KEY (`pro_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `order_pro_id` FOREIGN KEY (`pro_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `pro_cat_id` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pro_subcat_id` FOREIGN KEY (`subcat_id`) REFERENCES `subcategories` (`subcategory_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `review_order_id` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `review_pro_id` FOREIGN KEY (`pro_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `review_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD CONSTRAINT `cat_id` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `product_id` FOREIGN KEY (`pro_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
