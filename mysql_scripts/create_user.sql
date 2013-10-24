CREATE DEFINER=`root`@`localhost` PROCEDURE `create_user`(IN `_email` VARCHAR(128), IN `_password` VARCHAR(128), IN `_firstname` VARCHAR(128), IN `_lastname` VARCHAR(128))
    MODIFIES SQL DATA
INSERT INTO cn_users(
            email,
            password,
            firstname,
            lastname
            )
            
            VALUES(
                _email,
                _password,
                _firstname,
                _lastname
            )