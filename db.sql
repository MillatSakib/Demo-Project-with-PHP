CREATE DATABASE `Canteen_Management_System`;

USE `Canteen_Management_System`;

CREATE TABLE
    Customers (
        customer_id INT PRIMARY KEY AUTO_INCREMENT,
        customer_name VARCHAR(255) NOT NULL,
        email VARCHAR(255) UNIQUE,
        phone_number VARCHAR(20) UNIQUE,
        address TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

CREATE TABLE
    Employees (
        employee_id INT PRIMARY KEY AUTO_INCREMENT,
        employee_name VARCHAR(255) NOT NULL,
        email VARCHAR(255) UNIQUE,
        phone_number VARCHAR(20) UNIQUE,
        position VARCHAR(100),
        salary DECIMAL(10, 2),
        hire_date DATE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

CREATE TABLE
    Suppliers (
        supplier_id INT PRIMARY KEY AUTO_INCREMENT,
        supplier_name VARCHAR(255) NOT NULL,
        contact_person VARCHAR(255),
        phone_number VARCHAR(20),
        email VARCHAR(255),
        address TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

CREATE TABLE
    Categories (
        category_id INT PRIMARY KEY AUTO_INCREMENT,
        category_name VARCHAR(100) UNIQUE NOT NULL,
        description TEXT
    );

CREATE TABLE
    Products (
        product_id INT PRIMARY KEY AUTO_INCREMENT,
        product_name VARCHAR(255) NOT NULL,
        description TEXT,
        price DECIMAL(10, 2) NOT NULL,
        category_id INT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (category_id) REFERENCES Categories (category_id)
    );

CREATE TABLE
    Inventory (
        inventory_id INT PRIMARY KEY AUTO_INCREMENT,
        product_id INT UNIQUE NOT NULL,
        stock_quantity INT NOT NULL,
        last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (product_id) REFERENCES Products (product_id)
    );

CREATE TABLE
    Orders (
        order_id INT PRIMARY KEY AUTO_INCREMENT,
        customer_id INT,
        employee_id INT,
        order_date DATETIME NOT NULL,
        total_amount DECIMAL(10, 2),
        order_status ENUM ('pending', 'completed', 'cancelled') NOT NULL,
        FOREIGN KEY (customer_id) REFERENCES Customers (customer_id),
        FOREIGN KEY (employee_id) REFERENCES Employees (employee_id)
    );

CREATE TABLE
    Order_Items (
        order_item_id INT PRIMARY KEY AUTO_INCREMENT,
        order_id INT NOT NULL,
        product_id INT NOT NULL,
        quantity INT NOT NULL,
        unit_price DECIMAL(10, 2) NOT NULL,
        FOREIGN KEY (order_id) REFERENCES Orders (order_id),
        FOREIGN KEY (product_id) REFERENCES Products (product_id)
    );

CREATE TABLE
    Sales (
        sales_id INT PRIMARY KEY AUTO_INCREMENT,
        order_id INT UNIQUE NOT NULL,
        sales_date DATETIME NOT NULL,
        total_amount DECIMAL(10, 2) NOT NULL,
        payment_method VARCHAR(50),
        FOREIGN KEY (order_id) REFERENCES Orders (order_id)
    );

CREATE TABLE
    Payments (
        payment_id INT PRIMARY KEY AUTO_INCREMENT,
        sales_id INT NOT NULL,
        amount DECIMAL(10, 2) NOT NULL,
        payment_date DATETIME NOT NULL,
        method VARCHAR(50),
        FOREIGN KEY (sales_id) REFERENCES Sales (sales_id)
    );

CREATE TABLE
    Shifts (
        shift_id INT PRIMARY KEY AUTO_INCREMENT,
        employee_id INT NOT NULL,
        shift_date DATE NOT NULL,
        start_time TIME NOT NULL,
        end_time TIME NOT NULL,
        FOREIGN KEY (employee_id) REFERENCES Employees (employee_id)
    );

CREATE TABLE
    Salaries (
        salary_id INT PRIMARY KEY AUTO_INCREMENT,
        employee_id INT NOT NULL,
        amount DECIMAL(10, 2) NOT NULL,
        payment_date DATE NOT NULL,
        FOREIGN KEY (employee_id) REFERENCES Employees (employee_id)
    );

CREATE TABLE
    Menus (
        menu_id INT PRIMARY KEY AUTO_INCREMENT,
        menu_name VARCHAR(255) NOT NULL,
        start_date DATE NOT NULL,
        end_date DATE NOT NULL,
        description TEXT
    );

CREATE TABLE
    Menu_Items (
        menu_item_id INT PRIMARY KEY AUTO_INCREMENT,
        menu_id INT NOT NULL,
        product_id INT NOT NULL,
        FOREIGN KEY (menu_id) REFERENCES Menus (menu_id),
        FOREIGN KEY (product_id) REFERENCES Products (product_id)
    );

CREATE TABLE
    Feedback (
        feedback_id INT PRIMARY KEY AUTO_INCREMENT,
        customer_id INT,
        rating INT CHECK (
            rating >= 1
            AND rating <= 5
        ),
        comment TEXT,
        feedback_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (customer_id) REFERENCES Customers (customer_id)
    );

CREATE TABLE
    Expenses (
        expense_id INT PRIMARY KEY AUTO_INCREMENT,
        description TEXT NOT NULL,
        amount DECIMAL(10, 2) NOT NULL,
        expense_date DATE NOT NULL,
        category VARCHAR(100)
    );

CREATE TABLE
    Returns (
        return_id INT PRIMARY KEY AUTO_INCREMENT,
        sales_id INT,
        product_id INT,
        quantity INT,
        reason TEXT,
        return_date DATE,
        FOREIGN KEY (sales_id) REFERENCES Sales (sales_id),
        FOREIGN KEY (product_id) REFERENCES Products (product_id)
    );

CREATE TABLE
    Supply_Orders (
        supply_order_id INT PRIMARY KEY AUTO_INCREMENT,
        supplier_id INT,
        order_date DATE,
        delivery_date DATE,
        total_amount DECIMAL(10, 2),
        status ENUM ('pending', 'delivered', 'cancelled'),
        FOREIGN KEY (supplier_id) REFERENCES Suppliers (supplier_id)
    );

CREATE TABLE
    Canteen_Info (
        canteen_info_id INT PRIMARY KEY AUTO_INCREMENT,
        canteen_name VARCHAR(255),
        location TEXT,
        opening_time TIME,
        closing_time TIME,
        contact_email VARCHAR(255)
    );

INSERT INTO
    Customers (customer_name, email, phone_number, address)
VALUES
    (
        'Akash Ahmed',
        'akash.ahmed@example.com',
        '01711223344',
        'Mirpur, Dhaka'
    ),
    (
        'Bithi Khan',
        'bithi.khan@example.com',
        '01811223344',
        'Gulshan, Dhaka'
    ),
    (
        'Tanim Islam',
        'tanim.islam@example.com',
        '01911223344',
        'Uttara, Dhaka'
    ),
    (
        'Sadia Rahman',
        'sadia.rahman@example.com',
        '01611223344',
        'Dhanmondi, Dhaka'
    ),
    (
        'Rajib Hossain',
        'rajib.hossain@example.com',
        '01511223344',
        'Banani, Dhaka'
    ),
    (
        'Mitu Akhtar',
        'mitu.akhtar@example.com',
        '01411223344',
        'Motijheel, Dhaka'
    ),
    (
        'Nurul Amin',
        'nurul.amin@example.com',
        '01311223344',
        'Mohammadpur, Dhaka'
    );

INSERT INTO
    Employees (
        employee_name,
        email,
        phone_number,
        position,
        salary,
        hire_date
    )
VALUES
    (
        'Fahim Hossain',
        'fahim.hossain@canteen.com',
        '01512345678',
        'Manager',
        35000.00,
        '2023-01-15'
    ),
    (
        'Jannat Sultana',
        'jannat.sultana@canteen.com',
        '01612345678',
        'Cashier',
        18000.00,
        '2023-03-20'
    ),
    (
        'Kamal Mia',
        'kamal.mia@canteen.com',
        '01712345678',
        'Cook',
        22000.00,
        '2022-05-10'
    ),
    (
        'Shabana Begum',
        'shabana.b@canteen.com',
        '01812345678',
        'Assistant Cook',
        20000.00,
        '2023-08-01'
    ),
    (
        'Rifat Ahmed',
        'rifat.ahmed@canteen.com',
        '01912345678',
        'Waiter',
        15000.00,
        '2024-02-10'
    );

INSERT INTO
    Suppliers (
        supplier_name,
        contact_person,
        phone_number,
        email,
        address
    )
VALUES
    (
        'Fresh Foods Ltd.',
        'Mr. Alam',
        '01898765432',
        'info@freshfoods.com',
        'Tejgaon, Dhaka'
    ),
    (
        'Dairy Delights',
        'Ms. Soma',
        '01998765432',
        'contact@dairydelights.com',
        'Mohakhali, Dhaka'
    ),
    (
        'Spice World',
        'Mr. Rahim',
        '01798765432',
        'sales@spiceworld.com',
        'Karwan Bazar, Dhaka'
    );

INSERT INTO
    Categories (category_name, description)
VALUES
    ('Breakfast', 'Morning meal items'),
    ('Lunch', 'Main course meals'),
    ('Snacks', 'Light meal and fast food'),
    ('Beverages', 'Hot and cold drinks'),
    ('Desserts', 'Sweet items and puddings');

INSERT INTO
    Products (product_name, description, price, category_id)
VALUES
    ('Paratha', 'Plain paratha with dal', 25.00, 1),
    (
        'Chicken Biryani',
        'Spicy chicken biryani',
        150.00,
        2
    ),
    ('Samosa', 'Potato-filled fried pastry', 15.00, 3),
    ('Coffee', 'Hot black coffee', 30.00, 4),
    ('Tea', 'Hot milk tea', 20.00, 4),
    (
        'Chicken Sandwich',
        'Grilled chicken sandwich with cheese',
        80.00,
        3
    ),
    ('Plain Water', 'Bottled mineral water', 15.00, 4),
    ('Roshogolla', 'Sweet syrupy dumpling', 20.00, 5);

INSERT INTO
    Inventory (product_id, stock_quantity)
VALUES
    (1, 100),
    (2, 50),
    (3, 200),
    (4, 80),
    (5, 120),
    (6, 60),
    (7, 150),
    (8, 75);

INSERT INTO
    Orders (
        customer_id,
        employee_id,
        order_date,
        total_amount,
        order_status
    )
VALUES
    (1, 2, '2024-05-01 10:00:00', 55.00, 'completed'),
    (2, 2, '2024-05-01 12:30:00', 150.00, 'completed'),
    (3, 1, '2024-05-02 09:45:00', 70.00, 'completed'),
    (4, 3, '2024-05-02 11:15:00', 30.00, 'pending'),
    (5, 2, '2024-05-02 13:00:00', 160.00, 'completed'),
    (6, 3, '2024-05-03 10:30:00', 25.00, 'completed'),
    (7, 1, '2024-05-03 14:00:00', 180.00, 'pending');

INSERT INTO
    Order_Items (order_id, product_id, quantity, unit_price)
VALUES
    (1, 1, 1, 25.00),
    (1, 5, 1, 20.00),
    (1, 7, 1, 15.00),
    (2, 2, 1, 150.00),
    (3, 1, 2, 25.00),
    (3, 3, 1, 15.00),
    (4, 4, 1, 30.00),
    (5, 2, 1, 150.00),
    (5, 7, 1, 15.00),
    (6, 1, 1, 25.00),
    (7, 6, 2, 80.00),
    (7, 4, 1, 30.00);

INSERT INTO
    Sales (
        order_id,
        sales_date,
        total_amount,
        payment_method
    )
VALUES
    (1, '2024-05-01 10:05:00', 55.00, 'Cash'),
    (2, '2024-05-01 12:35:00', 150.00, 'Card'),
    (3, '2024-05-02 09:50:00', 70.00, 'Cash'),
    (5, '2024-05-02 13:05:00', 160.00, 'Card'),
    (6, '2024-05-03 10:35:00', 25.00, 'Cash');

INSERT INTO
    Payments (sales_id, amount, payment_date, method)
VALUES
    (1, 55.00, '2024-05-01 10:05:00', 'Cash'),
    (2, 150.00, '2024-05-01 12:35:00', 'Card'),
    (3, 70.00, '2024-05-02 09:50:00', 'Cash'),
    (4, 160.00, '2024-05-02 13:05:00', 'Card'),
    (5, 25.00, '2024-05-03 10:35:00', 'Cash');

INSERT INTO
    Shifts (employee_id, shift_date, start_time, end_time)
VALUES
    (1, '2024-05-01', '09:00:00', '17:00:00'),
    (2, '2024-05-01', '10:00:00', '18:00:00'),
    (3, '2024-05-02', '08:00:00', '16:00:00'),
    (1, '2024-05-02', '10:00:00', '18:00:00'),
    (2, '2024-05-03', '09:00:00', '17:00:00');

INSERT INTO
    Salaries (employee_id, amount, payment_date)
VALUES
    (1, 35000.00, '2024-04-30'),
    (2, 18000.00, '2024-04-30'),
    (3, 22000.00, '2024-04-30'),
    (4, 20000.00, '2024-04-30'),
    (5, 15000.00, '2024-04-30');

INSERT INTO
    Menus (menu_name, start_date, end_date, description)
VALUES
    (
        'Ramadan Special',
        '2024-03-10',
        '2024-04-10',
        'Special items for Ramadan'
    ),
    (
        'Winter Warmers',
        '2023-12-01',
        '2024-02-28',
        'Hot beverages and soups'
    ),
    (
        'Student Combo',
        '2024-05-01',
        '2024-05-31',
        'Affordable combo meals for students'
    );

INSERT INTO
    Menu_Items (menu_id, product_id)
VALUES
    (1, 1),
    (1, 3),
    (2, 4),
    (2, 5),
    (3, 1),
    (3, 3),
    (3, 7);

INSERT INTO
    Feedback (customer_id, rating, comment)
VALUES
    (1, 5, 'Great food and fast service!'),
    (2, 4, 'Biryani was a little too spicy.'),
    (3, 5, 'Good value for money.'),
    (4, 3, 'Service was a bit slow today.');

INSERT INTO
    Expenses (description, amount, expense_date, category)
VALUES
    (
        'Rent for May 2024',
        15000.00,
        '2024-05-01',
        'Rent'
    ),
    (
        'Electricity bill',
        2500.00,
        '2024-05-05',
        'Utilities'
    ),
    (
        'Groceries purchase',
        12000.00,
        '2024-05-02',
        'Supplies'
    );

INSERT INTO
    Returns (
        sales_id,
        product_id,
        quantity,
        reason,
        return_date
    )
VALUES
    (1, 5, 1, 'Wrong order item', '2024-05-01'),
    (3, 3, 1, 'Item was cold', '2024-05-02');

INSERT INTO
    Supply_Orders (
        supplier_id,
        order_date,
        delivery_date,
        total_amount,
        status
    )
VALUES
    (
        1,
        '2024-04-28',
        '2024-04-30',
        5000.00,
        'delivered'
    ),
    (2, '2024-05-01', '2024-05-03', 3000.00, 'pending'),
    (3, '2024-05-01', '2024-05-04', 8000.00, 'pending');

INSERT INTO
    Canteen_Info (
        canteen_name,
        location,
        opening_time,
        closing_time,
        contact_email
    )
VALUES
    (
        'Main Campus Canteen',
        'NX_Bulding',
        '09:00:00',
        '21:00:00',
        'contact@canteen.com'
    );

CREATE TABLE
    customer_audit_log (
        log_id INT PRIMARY KEY AUTO_INCREMENT,
        customer_id INT,
        action VARCHAR(50),
        log_date DATETIME
    );