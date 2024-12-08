CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100),
    last_name VARCHAR(100),
    username VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE job_posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    date_posted TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    applicant_id INT NOT NULL,
    job_post_id INT NOT NULL,
    resume VARCHAR(255) NOT NULL,
    status ENUM('PENDING', 'ACCEPTED', 'REJECTED') DEFAULT 'PENDING',
    date_submitted TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (applicant_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (job_post_id) REFERENCES job_posts(id) ON DELETE CASCADE ON UPDATE CASCADE
);

ALTER TABLE users ADD COLUMN role VARCHAR(20) DEFAULT 'Applicant';

INSERT INTO users (first_name, last_name, username, email, password, role) VALUES
('Jude', 'Santos', 'JudeSantos', 'jude.santos@gmail.com', 'HR', 'HR'),
('Ivan', 'Dequito', 'IvanDequito', 'ivan.dequito@gmail.com', 'HR', 'HR'),
('Jaysyon', 'Garcia', 'JaysyonGarcia', 'jaysyon.garcia@gmail.com', 'HR', 'HR'),
('Marko', 'Pascual', 'MarkoPascual', 'marko.pascual@gmail.com', 'HR', 'HR'),
('Steven', 'Go', 'StevenGo', 'steven.go@gmail.com', 'HR', 'HR');


INSERT INTO job_posts (title, description) VALUES 
('Game Developer', 'We are looking for an experienced game developer to join our team.'),
('Game Designer', 'Looking for a creative individual to design engaging game experiences.');

ALTER TABLE applications ADD COLUMN name VARCHAR(255) NOT NULL AFTER applicant_id;
