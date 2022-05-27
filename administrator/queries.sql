
-- index.php
-- Τα έσοδα ανά ημέρα των τελευταίων 5 κερδοφόρων ημερών
SELECT *
FROM(
SELECT DATE_FORMAT(order_date, '%M %d, %Y') AS odate, SUM(total) AS incomeFromThisDay
FROM orders 
GROUP BY odate
ORDER BY odate DESC
LIMIT 5) temp
ORDER BY temp.odate ASC;

-- add_product.php
-- προσθήκη καινούριου προϊόντος
INSERT INTO products (name, OEM, price, path_the_img_file, entry_date, description, category) VALUES 
('', '', , '', NOW(), '', '');

INSERT INTO products (name, OEM, price, path_the_img_file, entry_date, description, category) 
VALUES ('tade', 'ALCATEL', 120, 'https://www.e-shop.gr/images/TEL/TEL.091715.jpg', NOW(), 'Καλό', 'smartphone');

-- customers.php
--1-- Οι πελάτες: Πρώτος ο παλιότερος, εγγεγραμμένος πιο παλιά
SELECT customers.customer_id AS cid, customers.first_name, customers.last_name, customers.email, 
	DATE_FORMAT(customers.registration_date, '%M %d, %Y') AS registration_date,
	SUM(total) AS incomeFromThisCustomer, COUNT(*) AS numberOfOrders
FROM customers JOIN orders ON customers.customer_id=orders.customer_id
GROUP BY customers.customer_id
ORDER BY registration_date ASC;

--2-- Οι πελάτες: Πρώτος αυτός που μας έχει φέρει τα περισσότερα κέρδη
SELECT customers.customer_id AS cid, customers.first_name, customers.last_name, customers.email, 
	DATE_FORMAT(customers.registration_date, '%M %d, %Y') AS registration_date,
	SUM(total) AS incomeFromThisCustomer, COUNT(*) AS numberOfOrders
FROM customers JOIN orders ON customers.customer_id=orders.customer_id
GROUP BY customers.customer_id
ORDER BY incomeFromThisCustomer DESC;

--3-- Οι πελάτες: Πρώτος αυτός που μας έχει πραγματοποιήσει τις περισσότερες παραγγελίες
SELECT customers.customer_id AS cid, customers.first_name, customers.last_name, customers.email, 
	DATE_FORMAT(customers.registration_date, '%M %d, %Y') AS registration_date,
	SUM(total) AS incomeFromThisCustomer, COUNT(*) AS numberOfOrders
FROM customers JOIN orders ON customers.customer_id=orders.customer_id
GROUP BY customers.customer_id
ORDER BY numberOfOrders DESC;

-- orders.php
-- Orders: Πρώτα η πιο πρόσφατη παραγγελία
SELECT order_id AS oid, customers.customer_id, CONCAT_WS(' ',first_name,last_name) AS name, total, status, order_date,
	shipping_method, billing_method
FROM orders JOIN customers ON orders.customer_id=customers.customer_id
ORDER BY order_date DESC;

-- order.php
-- Τα στοιχεία δεδομένης παραγγελίας
SELECT o.order_id AS oid, oc.product_id AS pid, oc.quantity AS q, oc.price, p.name, 
	p.price AS pricePerPiece, p.path_the_img_file AS img
FROM orders AS o JOIN orders_contents AS oc ON o.order_id=oc.order_id 
	JOIN products AS p ON p.product_id=oc.product_id
WHERE o.order_id=12
ORDER BY oc.product_id ASC;

-- products.php
--1-- Πωλήσεις ανά κατηγορία
SELECT products.category, SUM(orders_contents.quantity) AS piecesSoldFromTheCategory
FROM products JOIN orders_contents ON products.product_id=orders_contents.product_id
GROUP BY products.category;

--2-- Προϊόντα: Πρώτα το πιο καινούριο, οργανωμένα ανά κατηγορίες, με τις πωληθείσες ποσότητες
SELECT products.product_id AS pid, products.name, products.OEM, products.price, products.category, 
	products.entry_date,  SUM(orders_contents.quantity) AS piecesSold
FROM products JOIN orders_contents ON products.product_id= orders_contents.product_id
GROUP BY orders_contents.product_id
ORDER BY products.category, products.entry_date DESC, piecesSold DESC;

--3-- Προϊόντα: Πρώτα το πιο παλιό, οργανωμένα ανά κατηγορίες, τα προϊόντα που δεν παρουσίασαν πωλήσεις
SELECT products.product_id AS pid, products.name, products.OEM, products.price, products.category, 
	products.entry_date,  0 AS piecesSold
FROM products 
WHERE products.product_id NOT IN (
SELECT products.product_id 
FROM products JOIN orders_contents ON products.product_id= orders_contents.product_id
GROUP BY orders_contents.product_id
)
ORDER BY products.category, products.entry_date;

--4-- Προϊόντα: Απλή προβολή, πρώτα το πιο καινούριο, οργανωμένα ανά κατηγορίες
SELECT products.product_id AS pid, products.name, products.OEM, products.price, products.category, 
	products.entry_date, path_the_img_file AS img
FROM products
ORDER BY products.category, products.entry_date DESC;
