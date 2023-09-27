-- --------------------------------------------------------
-- Table structure for table `catgories`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

-- Sample data 

INSERT INTO `categories` (`id`, `name`, `description`) VALUES
(1, 'Starters', 'Starters'),
(2, 'Seafood', 'Seafood'),
(3, 'BBQ', 'BBQ Items'),
(4, 'Pasta', 'Pasta'),
(5, 'Sandwiches', 'Sandwiches Types'),
(6, 'Desserts', 'Desserts'),
(7, 'Softdrink', 'Softdrinks'),
(8, 'Bier', 'Bier'),
(9, 'Cocktail', 'Cocktails');

-- --------------------------------------------------------
-- Table structure for table `orders`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `table_num` int(20) NOT NULL,
  `total_amount` float NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;



-- --------------------------------------------------------
-- Table structure for table `order_items`
-- --------------------------------------------------------


CREATE TABLE `order_items` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `order_id` int(30) NOT NULL,
  `product_id` int(30) NOT NULL,
  `qty` int(30) NOT NULL,
  `price` float NOT NULL,
  `amount` float NOT NULL,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

-- --------------------------------------------------------
-- Table structure for table `products`
-- --------------------------------------------------------
CREATE TABLE `products` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `category_id` int(30) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `price` float NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0=Unavailable,1=Available',
   PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

-- Sample data 

INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `price`, `status`) VALUES
(1, 1, 'Mix Salat', 'Mix salat with seasonal vegetable and fried cheese', 12, 1),
(2, 1, 'Tomato Soup', 'Homemade soup', 7, 1),
(3, 1, 'Cherry Tomato', 'Fresh tomato salat with mozarella', 10, 1),
(4, 1, 'Kubi Soup ', 'Special soup from vegetable and redwine', 8, 1),
(5, 2, 'Shrimp', 'Grilled shrimp plate with baked potato', 20, 1),
(6, 2, 'Oyster', 'Big plate with 10 oysters',30 , 1),
(7, 2, 'Mix Plate', 'Different kinds of seafood', 80, 1),
(8, 3, 'Ny Strip', 'New York Strip', 20, 1),
(9, 3, 'Ribeye', '300g Ribeye steak with baked potato', 19, 1),
(10, 3, 'Mignon', '300g Filet Mignon steak with baked potato', 80, 1),
(11, 4, 'Bolognaise', 'with parmesan cheese', 15, 1),
(12, 4, 'Carbonara', 'bacon, creame and parmesan cheese', 15, 1),
(13, 4, 'Pesto', 'Pesto sauce, olives and parmesan cheese', 13, 1),
(14, 5, 'Club SW', 'Chicken, bacon, tomato and salat', 10, 1),
(15, 5, 'Steak SW', 'steak, rucola, mushrooms and truffle mayonaise', 13, 1),
(16, 6, 'Eiscream', '3 Scoops of vanila, chocolate and strawberry eiscream', 5, 1),
(17, 6, 'Tiramisu', 'with or without alkohol', 5, 1),
(18, 7, 'Cola', '0.3 cola', 3, 1),
(19, 7, 'Fanta', '0.3 fanta', 3, 1),
(20, 7, 'Sprite', '0.3 sprite', 3, 1),
(21, 7, 'Water', '0.3 water', 3, 1),
(22, 8, 'Tapbier', '0.5 bier', 5, 1),
(23, 8, 'X Bier', '0.5 Bottle X', 5, 1),
(24, 9, 'Mojito', 'Mojito', 6, 1),
(25, 9, 'Whitewine', 'Whitewine', 6, 1),
(26, 9, 'Panacolada', 'Panacolada', 7, 1);

-- --------------------------------------------------------
-- Table structure for table `users`
-- --------------------------------------------------------
CREATE TABLE `users` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 3 COMMENT '1=Admin,2=Staff',
   PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

-- Sample data 
INSERT INTO `users` (`id`, `name`, `username`, `password`, `type`) VALUES
(1, 'admin', 'admin@gmail.com', 'cd92a26534dba48cd785cdcc0b3e6bd1', 1);

-- --------------------------------------------------------
-- Table structure for table `finanz`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `sales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `month_data` int(10) NOT NULL,
  `year_data` int(10) NOT NULL,
  `status` tinyint(1) NOT NULL,
  'amount' float NOT NULL,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

