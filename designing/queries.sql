
-- εισαγωγή εγγραφής στον πίνακα products
INSERT INTO products (name, OEM, price, path_the_img_file, entry_date, description, category) VALUES 
('', '', , '', NOW(), '', '');

-- mysqli_connect.php
-- Εξασφάλισε την ορθή εμφάνιση των ελληνικών χαρακτήρων
SET NAMES 'utf8';
SET CHARACTER SET 'utf8';

-- index.php
--1-- εύρεση των 5 καινούριων προϊόντων μας
SELECT product_id AS pid, name, price, path_the_img_file AS img, entry_date 
FROM products 
ORDER BY entry_date DESC
LIMIT 5;

--2-- εύρεση των 5 προϊόντων μας με τις περισσότερες πωλήσεις
SELECT p.product_id AS pid, sold, name, price, path_the_img_file AS img, entry_date 
FROM products, (
	SELECT product_id, SUM(quantity) AS sold
	FROM orders_contents
	GROUP BY product_id
	ORDER BY sold DESC
	LIMIT 5) AS p
WHERE products.product_id=p.product_id
ORDER BY sold DESC, entry_date ASC;
	
-- folder: site

-- account_page.php
-- εμφάνιση των δύο πιο πρόσφατων παραγγελιών δεδομένου χρήστη
SELECT order_id AS oid, DATE_FORMAT(order_date, '%M %d, %Y') AS order_date
FROM orders
WHERE customer_id=13 -- user: dai19172@uom.edu.gr
ORDER BY order_date DESC, order_id DESC
LIMIT 2;

-- orders_page.php
--1-- εύρεση των περιεχομένων δεδομένης παραγγελίας 
SELECT o.order_id AS oid, oc.product_id AS pid, oc.quantity AS q, oc.price, p.name, 
	p.price AS pricePerPiece, p.path_the_img_file AS img
FROM orders AS o JOIN orders_contents AS oc ON o.order_id=oc.order_id 
	JOIN products AS p ON p.product_id=oc.product_id
WHERE o.order_id=4
ORDER BY oc.product_id ASC;

--2-- εύρεση των παραγγελιών συγκεκριμένου πελάτη
SELECT order_id AS oid, total, status, shipping_method, billing_method, DATE_FORMAT(order_date, '%M %d, %Y') AS order_date
FROM orders
WHERE customer_id=13;

-- product.php
-- παίρνω όλες τις πληροφορίες ενός προϊόντος
SELECT product_id AS pid, name, OEM, price, path_the_img_file AS img, description, category, DATE_FORMAT(entry_date, '%M %d, %Y') AS entry_date 
FROM products
WHERE product_id=16;

-- login_functions.inc.php
-- εύρεση συγκεκριμένου χρήστη
SELECT customer_id, first_name, last_name, email
FROM customers 
WHERE email='dai19172@uom.edu.gr' AND pass=SHA1('1');
				
-- add_cart.php
-- εύρεση τιμής δεδομένου προϊόντος για προσθήκη στο καλάθι
SELECT price 
FROM products 
WHERE product_id = 1;
				
-- basket.php
-- εύρεση των στοιχείων των προϊόντων που βρίσκονται στο καλάθι για προβολή του  
SELECT product_id, name, path_the_img_file AS img
FROM products
WHERE product_id IN (1,4,5);

-- checkout.php
-- προσθήκη παραγγελίας κατά το checkout
INSERT INTO orders (customer_id, total, order_date, status, shipping_method, billing_method) 
VALUES (13, 123, NOW(), 'Καταχωρημένη', 'Από το κατάστημα', 'Στο κατάστημα');

-- register.php
--1-- έλεγχος αν υπάρχουν εγγραφές του πίνακα customers με τα εισαγόμενα στοιχεία για εξασφάλιση μοναδικότητας
-- 		των χρηστών
SELECT customer_id, customers.email, customers.pass
FROM customers
WHERE customers.email = 'dai19172@uom' OR customers.pass = SHA1('123455');

--2-- εισαγωγή χρήστη στη βάση
INSERT INTO customers (first_name, last_name, email, pass, registration_date) 
VALUES ('tade', 'papaterpos', 'dai19172@uom', SHA1('123455'), NOW() );
					
--
-- αλλαγή κατάστασης της παραγγελίας 
UPDATE orders 
SET status='Ολοκληρωμένη'
WHERE order_id=9;

-- view_products.php
--1-- προβολή των προϊόντων ομαδοποιημένα κατά κατηγορία και έπειτα από το πιο πρόσφατο στο παλιότερο
SELECT product_id AS pid, name, OEM, price, path_the_img_file AS img, description, category, entry_date 
FROM products 
ORDER BY category, entry_date DESC;

--2-- προϊόντα συγκεκριμένης κατηγορίας
SELECT product_id AS pid, name, OEM, price, path_the_img_file AS img, description, category, entry_date 
FROM products
WHERE category = 'HDD'
ORDER BY category, OEM, entry_date DESC;

--3-- συλλογή των κατηγοριών των προϊόντων ώστε να ελεγχθεί αν ανήκει το αλφαριθμητικό της αναζήτησης εδώ
SELECT category
FROM products
GROUP BY category;

--4-- συλλογή των κατασκευαστών των προϊόντων ώστε να ελεγχθεί αν ανήκει το αλφαριθμητικό της αναζήτησης εδώ
SELECT OEM
FROM products
GROUP BY OEM;

--5-- συλλογή προϊόντων με βάση το αλφαριθμητικό της αναζήτησης που θα είναι ή κατηγορία ή κατασκευαστής
SELECT product_id AS pid, name, OEM, price, path_the_img_file AS img, description, category, DATE_FORMAT(entry_date, '%M %d, %Y') AS entry_date 
FROM products
WHERE category = 'laptop' || OEM = 'laptop'
ORDER BY category, OEM, entry_date DESC;

--6-- συλλογή προϊόντων συγκεκριμένου κατασκευαστή από μια λίστα προϊόντων
SELECT product_id AS pid, name, OEM, price, path_the_img_file AS img, description, category, DATE_FORMAT(entry_date, '%M %d, %Y') AS entry_date 
FROM products
WHERE OEM = 'HP' AND product_id IN (1,2,3,4,6,8)
ORDER BY category, OEM, entry_date DESC;
	
--7-- συλλογή κατασκευαστών συγκεκριμένης κατηγορίας προϊόντων
SELECT OEM
FROM products
WHERE category='external_HDD' 
GROUP BY OEM;
