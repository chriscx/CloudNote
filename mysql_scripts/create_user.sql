CREATE DEFINER=`root`@`localhost` PROCEDURE `create_user`(IN `_email` VARCHAR(128), IN `_password` VARCHAR(128), IN `_firstname` VARCHAR(128), IN `_lastname` VARCHAR(128))
    MODIFIES SQL DATA
    
    IF(NOT EXISTS(SELECT * FROM cn_users u WHERE u.email = _email)) THEN
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
                    );
        RETURN 1;
    ELSE RETURN 0;
    END IF
    