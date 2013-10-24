IF(NOT EXISTS(SELECT * FROM cn_users))
    BEGIN
        CREATE TABLE cn_users (
            id_user INT NOT NULL,
            email VARCHAR(128) NOT NULL,
            password VARCHAR(128) NOT NULL,
            firstname VARCHAR(128) NOT NULL,
            lastname VARCHAR(128) NOT NULL,
            PRIMARY KEY(id_user)
        )
    END
   
IF(NOT EXISTS(SELECT * FROM cn_notes))
    BEGIN
        CREATE TABLE cn_notes (
            id_note INT NOT NULL,
            id_user INT NOT NULL,
            content LONGTEXT,
            PRIMARY KEY(id_note)
        )
    END
       