CREATE DATABASE solskov_jensen_dk_db;
use solskov_jensen_dk_db;
CREATE USER 'solskov_jensen_dk'@'localhost' IDENTIFIED BY 'JKQ1TGTK';
GRANT ALL PRIVILEGES ON solskov_jensen_dk_db.* TO 'solskov_jensen_dk'@'%';
GRANT ALL PRIVILEGES ON solskov_jensen_dk_db.* TO 'solskov_jensen_dk'@'localhost';
FLUSH privileges;

CREATE table checkout (
    checkout_id int(11) primary key not null AUTO_increment,
    product_name varchar(128) not null,
    product_price int(11) not null,
    product_amount varchar(128) not null
);

CREATE table products (
    product_id int(11) primary key not null AUTO_increment,
    product_name varchar(128) not null,
    product_price int(11) not null,
    product_type varchar(128) not null
);

CREATE TABLE zoobuy (
  user_id int(11) NOT NULL AUTO_INCREMENT,
  user_name varchar(128) NOT NULL,
  user_email varchar(128) NOT NULL,
  user_product varchar(128) NOT NULL,
  user_prize varchar(128) NOT NULL,
  user_dato datetime NOT NULL,
  PRIMARY KEY (user_id)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

CREATE TABLE zoouser (
  user_id int(11) NOT NULL AUTO_INCREMENT,
  user_name varchar(128) NOT NULL,
  user_email varchar(128) NOT NULL,
  user_password varchar(128) NOT NULL,
  PRIMARY KEY (user_id)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

CREATE TABLE `order` (
  `orderID` int(11) NOT NULL AUTO_INCREMENT,
  `customerID` int(11) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `clientsecret` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `payment_intent_id` varchar(100) NOT NULL,
  PRIMARY KEY (`orderID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;