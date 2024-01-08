----------------------------------------------------------------------------------------------------
-- Techonologies i use on this CRUD project are: --
1.php,
2.mysql (xampp),
3.html, css 
5.and bootstrap the latest version.

To try this on ur machine just follow this:

__ Import the 'car_table.sql' on database folder and name the database 'car_db'. __


_________________________________ Table Schema ____________________________________

        CREATE DATABASE `car_db`;
        
        CREATE TABLE `car_db`.`car_table` (
            car_id INT AUTO_INCREMENT PRIMARY KEY,
            car_name VARCHAR(255) NOT NULL,
            car_brand VARCHAR(255) NOT NULL,
            car_type VARCHAR(255) NOT NULL,
            car_color VARCHAR(255) NOT NULL,
            car_price INT NOT NULL,
            car_color VARCHAR(255) NOT NULL,
        );
____________________________________________________________________________________


NOTE: the unlink function on delete.php is very important because it deleted also the photo of car on uploads folder 
      if the photo (eg. supra.jpg) is not existed on the folder but existed on database (eg. uploads/supra.jpg) you need to
      manually delete it on database (This will not give an error);


If you encounter such as empty photo on main just delete all the data on table and photos on uploads and use this code to 
start the id on 1 again:
________ ALTER TABLE `car_table` AUTO_INCREMENT = 1; ________ or  ____ ALTER TABLE `car_db`.`car_table` AUTO_INCREMENT = 1;
