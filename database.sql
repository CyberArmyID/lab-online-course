-- Tabel users (hanya untuk member)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    avatar VARCHAR(255),
    bio TEXT,
    point INT default 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
-- Tabel users (hanya untuk member)
CREATE TABLE user_tokens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    token VARCHAR(255) NOT NULL
);

-- Tabel admins (khusus untuk data admin)
CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel courses
CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    thumbnail VARCHAR(255) NOT NULL,
    description TEXT,
    point INT DEFAULT 0,
    price DECIMAL(10, 2) NOT NULL,
    status ENUM('draft', 'publish') DEFAULT 'draft',  -- Status kursus
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel modules
CREATE TABLE modules (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

-- Tabel materials
CREATE TABLE materials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    module_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (module_id) REFERENCES modules(id) ON DELETE CASCADE
);

-- Tabel vouchers
CREATE TABLE vouchers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(50) UNIQUE NOT NULL,
    discount_percentage DECIMAL(5, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel purchases
CREATE TABLE purchases (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    course_id INT NOT NULL,
    status ENUM('pending', 'confirmed', 'canceled') DEFAULT 'pending',
    voucher_code VARCHAR(50) NULL,
    total_price DECIMAL(10, 2),
    bank VARCHAR(200),
    bank_account_name VARCHAR(200),
    bank_account_number VARCHAR(200),
    payment_proof VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

-- Tabel user_courses
CREATE TABLE user_courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    course_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

-- Tabel rewards
CREATE TABLE rewards (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    points INT NOT NULL,
    reward_item VARCHAR(255),
    status ENUM('process', 'redeemed') DEFAULT 'process',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Tabel reward_items
CREATE TABLE reward_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    required_points INT NOT NULL,
    stock INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel reward_redemptions (penukaran reward)
CREATE TABLE reward_redemptions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    reward_item_id INT NOT NULL,
    points_used INT NOT NULL,
    status ENUM('process', 'redeemed') DEFAULT 'process',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (reward_item_id) REFERENCES reward_items(id) ON DELETE CASCADE
);


-- Data Dummy untuk Tabel users
INSERT INTO users (name, email, password, avatar, bio, created_at, updated_at)
VALUES
    ('John Doe', 'john.doe@example.com', SHA1('password123'), 'default-avatars.jpg', 'Software developer and tech enthusiast.', NOW(), NOW()),
    ('Jane Smith', 'jane.smith@example.com', SHA1('password123'), 'default-avatars.jpg', 'Marketing specialist and business consultant.', NOW(), NOW()),
    ('Koji Xenpai', 'koji@gmail.com', SHA1('password'), 'default-avatars.jpg', 'Graphic designer with a passion for UI/UX.', NOW(), NOW());

-- Data Dummy untuk Tabel admins
INSERT INTO admins (name, email, password, created_at, updated_at)
VALUES
    ('Admin One', 'admin1@example.com', SHA1('admin123'), NOW(), NOW()),
    ('Koji Xenpai', 'koji@xenpai.com', SHA1('kojio'), NOW(), NOW());

-- Data Dummy untuk Tabel courses
INSERT INTO courses (title, thumbnail,point, description, price, status, created_at, updated_at)
VALUES
    ('Introduction to Web Development', 'https://picsum.photos/seed/webdev/600/400', 100,'Learn the basics of web development including HTML, CSS, and JavaScript.', 100000.00, 'publish', NOW(), NOW()),
    ('Advanced Python Programming', 'https://picsum.photos/seed/python/600/400', 250,'Master Python programming for data science, machine learning, and automation.', 150000.00, 'publish', NOW(), NOW()),
    ('Digital Marketing 101', 'https://picsum.photos/seed/marketing/600/400', 100,'Learn how to use digital marketing tools and strategies to grow your business.', 75000.00, 'draft', NOW(), NOW());

-- Data Dummy untuk Tabel modules
INSERT INTO modules (course_id, title, created_at, updated_at)
VALUES
    (1, 'HTML Basics', NOW(), NOW()),
    (1, 'CSS Styling', NOW(), NOW()),
    (1, 'JavaScript Introduction', NOW(), NOW()),
    (2, 'Introduction to Python', NOW(), NOW()),
    (2, 'Advanced Python Libraries', NOW(), NOW()),
    (3, 'SEO Optimization', NOW(), NOW()),
    (3, 'Social Media Marketing', NOW(), NOW());

-- Data Dummy untuk Tabel materials
INSERT INTO materials (module_id, title, content, created_at, updated_at)
VALUES
    (1, 'HTML Syntax', 'Learn the basic syntax of HTML tags and structure.', NOW(), NOW()),
    (2, 'CSS Selectors', 'Explore various CSS selectors to style HTML elements.', NOW(), NOW()),
    (3, 'JavaScript Variables', 'Learn how to define variables and use them in JavaScript.', NOW(), NOW()),
    (4, 'Python Basics', 'Introduction to Python syntax and variables.', NOW(), NOW()),
    (5, 'NumPy Library', 'Advanced Python libraries for scientific computing.', NOW(), NOW()),
    (6, 'SEO Basics', 'Learn the fundamentals of SEO and keyword optimization.', NOW(), NOW()),
    (7, 'Facebook Marketing', 'Learn strategies for marketing your business on Facebook.', NOW(), NOW());

-- Data Dummy untuk Tabel purchases
INSERT INTO purchases (user_id, course_id, status, voucher_code, total_price, payment_proof, created_at, updated_at)
VALUES
    (1, 1, 'confirmed', 'DISCOUNT10', 90.00, 'https://images.unsplash.com/photo-1517430816045-7e6b4b0a92b6', NOW(), NOW()),
    (2, 2, 'pending', 'SUMMER20', 120.00, 'https://images.unsplash.com/photo-1606112215374-c39410d7d6fa', NOW(), NOW()),
    (3, 3, 'confirmed', 'WELCOME5', 71.25, 'https://images.unsplash.com/photo-1603982158644-b78ff5b93b3f', NOW(), NOW());

-- Data Dummy untuk Tabel user_courses
INSERT INTO user_courses (user_id, course_id, created_at, updated_at)
VALUES
    (1, 1, NOW(), NOW()),
    (2, 2, NOW(), NOW()),
    (2, 1, NOW(), NOW());

-- Data Dummy untuk Tabel rewards
INSERT INTO rewards (user_id, points, reward_item, status, created_at, updated_at)
VALUES
    (1, 100, 'Gift Card', 'process', NOW(), NOW()),
    (2, 50, 'Discount Coupon', 'process', NOW(), NOW()),
    (3, 200, 'Amazon Voucher', 'process', NOW(), NOW());

-- Data Dummy untuk Tabel reward_items
INSERT INTO reward_items (name, required_points, stock, created_at, updated_at)
VALUES
    ('Gift Card', 50, 10, NOW(), NOW()),
    ('Discount Coupon', 30, 15, NOW(), NOW()),
    ('Amazon Voucher', 200, 5, NOW(), NOW());
 
-- Data Dummy untuk Tabel voucher_codes
INSERT INTO vouchers (code, discount_percentage, created_at, updated_at)
VALUES
    ('DISCOUNT10', 10, NOW(), NOW()),
    ('SUMMER20', 20, NOW(), NOW()),
    ('WELCOME5', 5, NOW(), NOW());

-- Data Dummy untuk Tabel reward_redemptions
INSERT INTO reward_redemptions (user_id, reward_item_id, points_used,status)
VALUES
    (1, 1, 50,'process'),
    (2, 2, 30,'process'),
    (3, 3, 200,'process');

