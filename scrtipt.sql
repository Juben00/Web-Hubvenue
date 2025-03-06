CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    booking_start_datetime DATE,
    booking_end_datetime DATE,
    booking_participants INT,
    booking_venue_price DECIMAL(10,2),
    booking_entrance DECIMAL(10,2),
    booking_cleaning DECIMAL(10,2),
    booking_service_fee DECIMAL(10,2),
    booking_duration INT,
    booking_grand_total DECIMAL(10,2),
    booking_dp_amount DECIMAL(10,2),
    booking_balance DECIMAL(10,2),
    booking_dp_id INT,
    booking_coupon VARCHAR(50),
    booking_discount_id INT,
    booking_status_id INT,
    booking_guest_id INT,
    booking_venue_id INT,
    booking_payment_method INT,
    booking_payment_reference VARCHAR(255),
    booking_payment_status_id INT,
    booking_request TEXT NULL,
    booking_cancellation_reason TEXT NULL,  
    booking_checkin_link TEXT NOT NULL,
    booking_checkout_link TEXT NOT NULL,
    booking_checkin_status booking_checkin_status ENUM('Pending', 'Checked-In', 'No-Show') 
DEFAULT 'Pending' NOT NULL,
    booking_checkout_status ENUM('Pending', 'Checked-Out') DEFAULT 'Pending' NOT NULL,
    booking_checkin_date DATE NOT NULL,
    booking_checkout_date DATE NOT NULL,
    booking_created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    booking_updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    FOREIGN KEY (booking_guest_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (booking_venue_id) REFERENCES venues(id) ON DELETE CASCADE,
    FOREIGN KEY (booking_discount_id) REFERENCES booking_discount_sub(id),
    FOREIGN KEY (booking_status_id) REFERENCES bookings_status_sub(id) ON DELETE SET NULL,
    FOREIGN KEY (booking_payment_method) REFERENCES payment_method_sub(id),
    FOREIGN KEY (booking_payment_status_id) REFERENCES payment_status_sub(id)
);

CREATE TABLE payment_method_sub (
    id INT AUTO_INCREMENT PRIMARY KEY,
    payment_method_name VARCHAR(50)
);

INSERT INTO payment_method_sub (payment_method_name) VALUES 
('G-cash'), 
('PayMaya');

CREATE TABLE bookings_status_sub (
    id INT PRIMARY KEY,
    booking_status_name VARCHAR(50)
);

INSERT INTO bookings_status_sub (id, booking_status_name) VALUES
(1, 'Pending'),
(2, 'Confirmed'),
(3, 'Cancelled'),
(4, 'Completed');

CREATE TABLE payment_status_sub (
    id INT AUTO_INCREMENT PRIMARY KEY,
    payment_status_name VARCHAR(50)
);

INSERT INTO payment_status_sub (payment_status_name) VALUES 
('Pending'), 
('Paid'), 
('Failed');

CREATE TABLE booking_discount_sub (
    id INT AUTO_INCREMENT PRIMARY KEY,
    booking_discount_name VARCHAR(50),
    booking_discount_card TEXT,
    booking_discount_value DECIMAL(10,2)
)


CREATE TABLE bookmarks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    userId INT,
    venueId INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (userId) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (venueId) REFERENCES venues(id) ON DELETE CASCADE
);

CREATE TABLE ratings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    userId INT,
    venueId INT,
    rating DECIMAL(2,1),
    review TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (userId) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (venueId) REFERENCES venues(id) ON DELETE CASCADE
);

