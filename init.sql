CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    password VARCHAR(255),
    credit_card VARCHAR(16),
    ssn VARCHAR(11)
);

INSERT INTO users (username, password, credit_card, ssn) VALUES
    ('admin', 'supersecret123', '4532123456789012', '123-45-6789'),
    ('john_doe', 'password123', '4532987654321098', '987-65-4321'),
    ('jane_smith', 'qwerty789', '4532456789012345', '456-78-9012'),
    ('superadmin', 'adminpass999', '4532111122223333', '111-22-3333'),
    ('user_admin', 'userpass123', '4532444455556666', '444-55-6666'),
    ('regular_user', 'regular123', '4532777788889999', '777-88-9999');