<?php
require_once(__DIR__ . '/../dbconnection.php');

// session_start();
class Venue
{
    public $id;
    public $name;
    public $description;
    public $address;
    public $location;
    public $amenities;
    public $rules;
    public $pricing_type;
    public $price;

    public $min_attendees;
    public $max_attendees;
    public $min_time;
    public $max_time;

    public $opening_time;
    public $closing_time;
    public $entrance;
    public $cleaning;

    public $imageThumbnail;

    public $tag;
    public $host_id;
    public $status = 1;
    public $availability = 1;

    public $downPayment = 3;
    public $image_url;

    public $check_inout;

    protected $db;

    function __construct()
    {
        $this->db = new Database();
    }

    public function addVenue()
    {
        try {
            // Establish database connection
            $conn = $this->db->connect();

            // Begin transaction
            $conn->beginTransaction();

            // Insert venue information

            $sql = 'INSERT INTO venues (name, description, address, location, amenities, rules, pricing_type, price, min_attendees, max_attendees, min_time, max_time, opening_time, closing_time, entrance, cleaning, down_payment_id, venue_tag, thumbnail, host_id, status_id, availability_id) VALUES (:name, :description, :address, :location, :amenities, :rules, :pricing_type, :price, :min_attendees, :max_attendees, :min_time, :max_time, :opening_time, :closing_time, :entrance, :cleaning, :down_payment_id, :venue_tag, :thumbnail, :host_id, :status_id, :availability_id)';

            $stmt = $conn->prepare($sql);

            // Bind parameters
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':description', $this->description);
            $stmt->bindParam(':location', $this->location);
            $stmt->bindParam(':address', $this->address);
            $stmt->bindParam(':amenities', $this->amenities);
            $stmt->bindParam(':rules', $this->rules);
            $stmt->bindParam(':pricing_type', $this->pricing_type);
            $stmt->bindParam(':price', $this->price);
            $stmt->bindParam(':min_attendees', $this->min_attendees);
            $stmt->bindParam(':max_attendees', $this->max_attendees);
            $stmt->bindParam(':min_time', $this->min_time);
            $stmt->bindParam(':max_time', $this->max_time);
            $stmt->bindParam(':opening_time', $this->opening_time);
            $stmt->bindParam(':closing_time', $this->closing_time);
            $stmt->bindParam(':entrance', $this->entrance);
            $stmt->bindParam(':cleaning', $this->cleaning);
            $stmt->bindParam(':down_payment_id', $this->downPayment);
            $stmt->bindParam(':venue_tag', $this->tag);
            $stmt->bindParam(':thumbnail', $this->imageThumbnail);
            $stmt->bindParam(':host_id', $this->host_id);
            $stmt->bindParam(':status_id', $this->status);
            $stmt->bindParam(':availability_id', $this->availability);


            // Execute venue insertion
            if ($stmt->execute()) {
                // Get the last inserted ID for the venue
                $lastInsertedVenue = $conn->lastInsertId();

                // Insert images if available
                $images = json_decode($this->image_url);
                if ($images) {
                    $imageSql = "INSERT INTO venue_images (venue_id, image_url) VALUES (:venue_id, :image_url)";
                    $imageStmt = $conn->prepare($imageSql);

                    foreach ($images as $image_url) {
                        $imageStmt->bindParam(':venue_id', $lastInsertedVenue);
                        $imageStmt->bindParam(':image_url', $image_url);

                        // Execute image insertion
                        if (!$imageStmt->execute()) {
                            // If any image fails to insert, return error
                            return ['status' => 'error', 'message' => 'Failed to add images for the venue'];
                        }
                    }
                }
                $conn->commit();
                return ['status' => 'success', 'message' => 'Venue and images added successfully'];
            } else {
                $conn->rollBack();
                return ['status' => 'error', 'message' => 'Failed to add venue'];
            }

        } catch (PDOException $e) {
            // Log error and return failure message
            $conn->rollBack();
            $errmess = "Database error: " . $e->getMessage();
            error_log($errmess);  // Log the error message
            return ['status' => 'error', 'message' => $e->getMessage()];  // Return the error message
        }

    }
    function getAllVenues($status = '', $availability = '', $host_id = '', $bookmarks = [])
    {
        try {
            // Establish database connection
            $conn = $this->db->connect();

            // Start building the SQL query
            $sql = "SELECT 
            v.id AS venue_id,
            vtg.tag_name AS venue_tag_name,
            v.*, 
            vss.name AS status, 
            vas.name AS availability, 
            GROUP_CONCAT(vi.image_url) AS image_urls,
            AVG(r.rating) AS rating, 
            COUNT(DISTINCT r.id) AS total_reviews
            FROM venues v 
            JOIN venue_tag_sub vtg ON v.venue_tag = vtg.id
            JOIN venue_status_sub vss ON v.status_id = vss.id 
            JOIN venue_availability_sub vas ON v.availability_id = vas.id 
            JOIN venue_images vi ON v.id = vi.venue_id 
            LEFT JOIN reviews r ON v.id = r.venue_id";

            // Initialize an array for conditions and parameters
            $conditions = [];
            $params = [];

            // Add conditions if parameters are provided
            if ($status) {
                $conditions[] = "v.status_id LIKE :status";
                $params[':status'] = "%$status%";
            }

            if ($availability) {
                $conditions[] = "v.availability_id LIKE :availability";
                $params[':availability'] = "%$availability%";
            }

            if ($host_id) {
                $conditions[] = "v.host_id = :host_id";
                $params[':host_id'] = $host_id;
            }

            // Add WHERE clause if conditions are present
            if (!empty($conditions)) {
                $sql .= " WHERE " . implode(' AND ', $conditions);
            }

            // Add GROUP BY clause
            $sql .= " GROUP BY v.id, vss.name, vas.name";

            // Prepare and execute the statement with parameters
            $stmt = $conn->prepare($sql);
            $stmt->execute($params);
            $venues = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Process the images (split the comma-separated string into an array)
            foreach ($venues as &$venue) {
                if (!empty($venue['image_urls'])) {
                    $venue['image_urls'] = explode(',', $venue['image_urls']); // Convert image URLs to an array
                }
                // Check if the venue is bookmarked
                $venue['bookmarked'] = in_array($venue['venue_id'], $bookmarks);
            }

            return $venues;

        } catch (PDOException $e) {
            // Log error and return failure message
            error_log("Database error: " . $e->getMessage());
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
    function getSingleVenue($venue_id = '')
    {
        try {
            // Establish database connection
            $conn = $this->db->connect();

            $sql = "SELECT 
                v.id AS venue_id, 
                v.name AS venue_name, 
                v.description AS venue_description, 
                v.location AS venue_location, 
                v.*, 
                vt.tag_name AS tag, 
                vss.name AS status, 
                vas.name AS availability, 
                AVG(r.rating) AS rating, 
                COUNT(DISTINCT r.id) AS total_reviews,
                GROUP_CONCAT(DISTINCT vi.image_url) AS image_urls
            FROM 
                venues v
            JOIN 
                venue_tag_sub vt ON v.venue_tag = vt.id
            JOIN 
                venue_status_sub vss ON v.status_id = vss.id
            JOIN 
                venue_availability_sub vas ON v.availability_id = vas.id
            JOIN 
                venue_images vi ON v.id = vi.venue_id
            LEFT JOIN 
                reviews r ON v.id = r.venue_id
            WHERE 
                v.id = :venue_id
            GROUP BY 
                v.id, vt.tag_name, vss.name, vas.name;
        ";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':venue_id', $venue_id);
            $stmt->execute();
            $venues = $stmt->fetch(PDO::FETCH_ASSOC);

            // Process the images (split the comma-separated string into an array)
            if (!empty($venues['image_urls'])) {
                $venues['image_urls'] = explode(',', $venues['image_urls']); // Convert image URLs to an array
            }

            return $venues;

        } catch (PDOException $e) {
            // Log error and return failure message
            error_log("Database error: " . $e->getMessage());
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
    function getRatings($venue_id)
    {
        try {
            $conn = $this->db->connect();
            $sql = "SELECT 
                AVG(rating) AS average,
                COUNT(rating) AS total,
                SUM(CASE WHEN rating = 5 THEN 1 ELSE 0 END) AS rating_5,
                SUM(CASE WHEN rating = 4 THEN 1 ELSE 0 END) AS rating_4,
                SUM(CASE WHEN rating = 3 THEN 1 ELSE 0 END) AS rating_3,
                SUM(CASE WHEN rating = 2 THEN 1 ELSE 0 END) AS rating_2,
                SUM(CASE WHEN rating = 1 THEN 1 ELSE 0 END) AS rating_1
            FROM reviews WHERE venue_id = :venue_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':venue_id', $venue_id);
            $stmt->execute();
            $ratings = $stmt->fetch(PDO::FETCH_ASSOC);
            return $ratings;
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
    function getReview($venue_id)
    {
        try {
            $conn = $this->db->connect();
            $sql = "SELECT 
                r.id,
                r.review,
                r.rating,
                r.created_at AS date,
                u.id AS user_id,
                CONCAT(u.firstname, ' ', u.lastname) AS user_name,
                u.profile_pic AS profile_pic
            FROM reviews r
            JOIN users u ON r.user_id = u.id
            WHERE r.venue_id = :venue_id
            ORDER BY date DESC;";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':venue_id', $venue_id);
            $stmt->execute();
            $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $reviews;
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }


    function approveVenue($venue_id)
    {
        try {
            // Establish database connection
            $conn = $this->db->connect();

            // Update the venue status to approved
            $sql = "UPDATE venues SET status_id = 2 WHERE id = :venue_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':venue_id', $venue_id);

            // Execute the update and check if any rows were affected
            if ($stmt->execute()) {
                if ($stmt->rowCount() > 0) {
                    return ['status' => 'success', 'message' => 'Venue approved successfully'];
                } else {
                    return ['status' => 'error', 'message' => 'Venue ID not found or status already set to approved'];
                }
            } else {
                return ['status' => 'error', 'message' => 'Failed to approve venue'];
            }

        } catch (PDOException $e) {
            // Log error and return failure message
            error_log("Database error: " . $e->getMessage());
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    function declineVenue($venue_id)
    {
        try {
            // Establish database connection
            $conn = $this->db->connect();

            // Update the venue status to declined
            $sql = "UPDATE venues SET status_id = 3 WHERE id = :venue_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':venue_id', $venue_id);

            // Execute the update and check if any rows were affected
            if ($stmt->execute()) {
                if ($stmt->rowCount() > 0) {
                    return ['status' => 'success', 'message' => 'Venue declined successfully'];
                } else {
                    return ['status' => 'error', 'message' => 'Venue ID not found or status already set to declined'];
                }
            } else {
                return ['status' => 'error', 'message' => 'Failed to decline venue'];
            }

        } catch (PDOException $e) {
            // Log error and return failure message
            error_log("Database error: " . $e->getMessage());
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    function bookVenue(
        $booking_start_datetime,
        $booking_end_datetime,
        $booking_participants,
        $booking_venue_price,
        $booking_entrance,
        $booking_cleaning,
        $booking_service_fee,
        $booking_duration,
        $booking_grand_total,
        $booking_dp_amount,
        $booking_balance,
        $booking_dp_id,
        $booking_coupon_id,
        $booking_discount_id = null,
        $booking_status_id,
        $booking_guest_id,
        $booking_venue_id,
        $booking_payment_method,
        $booking_payment_reference,
        $booking_payment_status_id,
        $booking_request
    ) {
        try {
            $conn = $this->db->connect();
<<<<<<< HEAD
            
            // Debug logging
            error_log("Booking parameters:");
            error_log("booking_discount_id: " . print_r($booking_discount_id, true));
            error_log("booking_coupon_id: " . print_r($booking_coupon_id, true));
            
            $sql = "INSERT INTO bookings (
                booking_start_date,
                booking_end_date,
                booking_participants,
                booking_venue_price,
                booking_entrance,
                booking_cleaning,
                booking_service_fee,
                booking_duration,
                booking_grand_total,
                booking_dp_amount,
                booking_balance,
                booking_dp_id,
                booking_coupon_id,
                booking_discount_id,
                booking_status_id,
                booking_guest_id,
                booking_venue_id,
                booking_payment_method,
                booking_payment_reference,
                booking_payment_status_id,
                booking_request
            ) VALUES (
                :booking_start_date,
                :booking_end_date,
                :booking_participants,
                :booking_venue_price,
                :booking_entrance,
                :booking_cleaning,
                :booking_service_fee,
                :booking_duration,
                :booking_grand_total,
                :booking_dp_amount,
                :booking_balance,
                :booking_dp_id,
                :booking_coupon_id,
                :booking_discount_id,
                :booking_status_id,
                :booking_guest_id,
                :booking_venue_id,
                :booking_payment_method,
                :booking_payment_reference,
                :booking_payment_status_id,
                :booking_request
            )";
            
            error_log("SQL Query: " . $sql);
            
=======

            $sql = "INSERT INTO bookings (booking_start_datetime, booking_end_datetime, booking_participants, booking_venue_price, booking_entrance, booking_cleaning, booking_service_fee, booking_duration, booking_grand_total, booking_dp_amount, booking_balance, booking_dp_id, booking_coupon_id, booking_discount_id, booking_status_id, booking_guest_id, booking_venue_id, booking_payment_method, booking_payment_reference, booking_payment_status_id, booking_request) 
                VALUES (:booking_start_datetime, :booking_end_datetime, :booking_participants, :booking_venue_price, :booking_entrance, :booking_cleaning, :booking_service_fee, :booking_duration, :booking_grand_total, :booking_dp_amount, :booking_balance, :booking_dp_id, :booking_coupon_id, :booking_discount_id, :booking_status_id, :booking_guest_id, :booking_venue_id, :booking_payment_method, :booking_payment_reference, :booking_payment_status_id, :booking_request)";
>>>>>>> 020c245a9c87e4846bd0efff377368df8af14a2b
            $stmt = $conn->prepare($sql);

            // Bind the parameters
            $stmt->bindParam(':booking_start_datetime', $booking_start_datetime);
            $stmt->bindParam(':booking_end_datetime', $booking_end_datetime);
            $stmt->bindParam(':booking_participants', $booking_participants);
            $stmt->bindParam(':booking_venue_price', $booking_venue_price);
            $stmt->bindParam(':booking_entrance', $booking_entrance);
            $stmt->bindParam(':booking_cleaning', $booking_cleaning);
            $stmt->bindParam(':booking_service_fee', $booking_service_fee);
            $stmt->bindParam(':booking_duration', $booking_duration);
            $stmt->bindParam(':booking_grand_total', $booking_grand_total);
            $stmt->bindParam(':booking_dp_amount', $booking_dp_amount);
            $stmt->bindParam(':booking_balance', $booking_balance);
            $stmt->bindParam(':booking_dp_id', $booking_dp_id);
            $stmt->bindParam(':booking_coupon_id', $booking_coupon_id);
            if ($booking_discount_id === null) {
                $stmt->bindValue(':booking_discount_id', null, PDO::PARAM_NULL);
            } else {
                $stmt->bindParam(':booking_discount_id', $booking_discount_id, PDO::PARAM_INT);
            }
            $stmt->bindParam(':booking_status_id', $booking_status_id);
            $stmt->bindParam(':booking_guest_id', $booking_guest_id);
            $stmt->bindParam(':booking_venue_id', $booking_venue_id);
            $stmt->bindParam(':booking_payment_method', $booking_payment_method);
            $stmt->bindParam(':booking_payment_reference', $booking_payment_reference);
            $stmt->bindParam(':booking_payment_status_id', $booking_payment_status_id);
            $stmt->bindParam(':booking_request', $booking_request);


            if ($stmt->execute()) {
                $bookingId = $conn->lastInsertId();

                $checkInLink = "http://localhost/hubvenue/api/checkInBooking.api.php?booking_id=" . $bookingId;
                $checkOutLink = "http://localhost/hubvenue/api/checkOutBooking.api.php?booking_id=" . $bookingId;

                // Update the check_in_link column with the generated link
                $updateSql = "UPDATE bookings 
              SET booking_checkin_link = :booking_checkin_link, 
                  booking_checkout_link = :booking_checkout_link 
              WHERE id = :booking_id";
                $updateStmt = $conn->prepare($updateSql);
                $updateStmt->bindParam(':booking_checkin_link', $checkInLink);
                $updateStmt->bindParam(':booking_checkout_link', $checkOutLink);
                $updateStmt->bindParam(':booking_id', $bookingId);
                $updateStmt->execute();


                return ['status' => 'success', 'message' => 'Booking added successfully'];
            } else {
                return ['status' => 'error', 'message' => 'Failed to add booking'];
            }
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }


    function getBookings()
    {
        try {
            $conn = $this->db->connect();
            $sql = "SELECT 
                    b.id AS booking_id,
                    b.booking_start_datetime,
                    b.booking_end_datetime,
                    b.booking_duration,
                    b.booking_participants,
                    b.booking_venue_price,
                    b.booking_grand_total,
                    b.booking_discount,
                    b.booking_payment_method,
                    b.booking_payment_reference,
                    b.booking_service_fee,
                    b.booking_status_id,
                    b.booking_cancellation_reason,
                    b.booking_created_at,

                    u.id AS guest_id,
                    CONCAT(u.firstname, ' ', u.middlename, ' ', u.lastname) AS guest_name,
                    u.contact_number AS guest_contact_number,
                    u.email AS guest_email,
                    u.address AS guest_address,

                    v.id AS venue_id,
                    v.name AS venue_name,
                    v.location AS venue_location,
                    v.price AS venue_price,
                    v.rules AS venue_rules,

                    d.discount_value AS discount_value


                FROM 
                    discounts d
                JOIN
                    bookings b ON d.discount_code = b.booking_discount
                JOIN 
                    users u ON b.booking_guest_id = u.id
                JOIN 
                    venues v ON b.booking_venue_id = v.id

                ORDER BY b.booking_created_at DESC;
                ";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $bookings;
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function getAllDiscounts()
    {
        $query = "SELECT * FROM discounts";
        $result = $this->db->connect()->query($query);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    // public function getIdDiscount($name = "")
    // {
    //     $conn = $->db->connect();
    //     $sql = "SELECT id FROM discounts WHERE discount_code = :discount_code;";
    //     $stmt = $conn->prepare($sql);
    //     $stmt->bindParam(':discount_code', $name);
    //     $stmt->execute();
    //     return $stmt->fetch(PDO::FETCH_ASSOC);
    // }

    public function approveReservation($booking_id)
    {
        try {
            $conn = $this->db->connect();
            $sql = "UPDATE bookings SET booking_status_id = 2, booking_payment_status_id = 2 WHERE id = :booking_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':booking_id', $booking_id);

            if ($stmt->execute()) {
                return ['status' => 'success', 'message' => 'Reservation approved successfully'];
            } else {
                return ['status' => 'error', 'message' => 'Failed to approve reservation'];
            }
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function rejectReservation($booking_id)
    {
        try {
            $conn = $this->db->connect();
            $sql = "UPDATE bookings SET booking_status_id = 4 WHERE id = :booking_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':booking_id', $booking_id);

            if ($stmt->execute()) {
                return ['status' => 'success', 'message' => 'Reservation rejected successfully'];
            } else {
                return ['status' => 'error', 'message' => 'Failed to reject reservation'];
            }
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function cancelReservation($booking_id)
    {
        try {
            $conn = $this->db->connect();
            $sql = "UPDATE bookings SET booking_status_id = 3 WHERE id = :booking_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':booking_id', $booking_id);

            if ($stmt->execute()) {
                return ['status' => 'success', 'message' => 'Reservation cancelled successfully'];
            } else {
                return ['status' => 'error', 'message' => 'Failed to cancel reservation'];
            }
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function getBookedDates($venue_id)
    {
        try {
            $conn = $this->db->connect();
            $STATUS_1 = 1;
            $STATUS_2 = 2;
            $sql = "SELECT booking_start_datetime AS startdate, booking_end_datetime AS enddate 
            FROM bookings 
            WHERE booking_venue_id = :venue_id
            AND booking_status_id = :status1 OR booking_status_id = :status2
            GROUP BY id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':venue_id', $venue_id);
            $stmt->bindParam(':status1', $STATUS_1);
            $stmt->bindParam(':status2', $STATUS_2);

            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    // for host
    public function getAllBookings($userId = null, $status = null)
    {
        try {
            $conn = $this->db->connect();

            $sql = "SELECT 
    b.id AS booking_id,
    b.booking_start_datetime,
    b.booking_end_datetime,
    b.booking_duration,
    b.booking_participants,
    b.booking_venue_price,
    b.booking_grand_total,
    b.booking_discount_id,
    b.booking_participants,
    b.booking_duration,
    b.booking_dp_amount,
    b.booking_entrance,
    b.booking_coupon_id,
    b.booking_cleaning,
    b.booking_balance,
    b.booking_request,
    b.booking_payment_reference,
    b.booking_service_fee,
    b.booking_status_id,
    b.booking_cancellation_reason,
    b.booking_created_at,

    u.id AS guest_id,
    CONCAT(u.firstname, ' ', COALESCE(u.middlename, '.'), ' ', u.lastname) AS guest_name,
    u.contact_number AS guest_contact_number,
    u.email AS guest_email,
    u.address AS guest_address,
    u.sex_id AS guest_sex,
    u.birthdate AS guest_birthdate,
    u.created_at AS guest_created_at,

    v.id AS venue_id,
    v.name AS venue_name,
    v.address AS venue_location,
    v.price AS venue_price,
    v.rules AS venue_rules,
    v.amenities AS venue_amenities,
    v.thumbnail,
    v.availability_id AS venue_availability_id,
    v.host_id AS host_id,

    p.payment_method_name AS payment_method_name,

    d.discount_value AS discount_value,
    d.discount_code AS discount_code,

    md.userId AS is_discounted,

    vt.tag_name AS venue_tag_name,

    GROUP_CONCAT(COALESCE(vi.image_url, '')) AS image_urls
FROM 
    bookings b
LEFT JOIN 
    payment_method_sub p ON b.booking_payment_method = p.id
LEFT JOIN 
    mandatory_discount md ON b.booking_guest_id = md.userId
LEFT JOIN
    discounts d ON d.id = b.booking_coupon_id
LEFT JOIN 
    users u ON b.booking_guest_id = u.id
LEFT JOIN 
    venues v ON b.booking_venue_id = v.id
LEFT JOIN
    venue_tag_sub vt ON v.venue_tag = vt.id
LEFT JOIN 
    venue_images vi ON v.id = vi.venue_id
";

            // Filter conditions
            $conditions = [];
            $params = [];

            if ($userId) {
                $conditions[] = "host_id = :userId";
                $params[':userId'] = $userId;
            }
            if ($status) {
                $conditions[] = "b.booking_status_id LIKE :status";
                $params[':status'] = "%$status%";
            }

            // Append conditions to query
            if (!empty($conditions)) {
                $sql .= " WHERE " . implode(" AND ", $conditions);
            }

            // Add GROUP BY clause
            $sql .= " GROUP BY b.id";

            // Add ORDER BY clause
            $sql .= " ORDER BY b.booking_created_at DESC";

            // Prepare and execute the statement
            $stmt = $conn->prepare($sql);
            $stmt->execute($params);

            // Fetch and return results
            $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $bookings;
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    // for guest
    public function guestgetAllBookings($userId = null, $status = null)
    {
        try {
            $conn = $this->db->connect();

            $sql = "SELECT 
    b.id AS booking_id,
    b.booking_start_datetime,
    b.booking_end_datetime,
    b.booking_duration,
    b.booking_participants,
    b.booking_venue_price,
    b.booking_grand_total,
    b.booking_participants,
    b.booking_duration,
    b.booking_dp_amount,
    b.booking_entrance,
    b.booking_cleaning,
    b.booking_balance,
    b.booking_payment_reference,
    b.booking_service_fee,
    b.booking_status_id,
    b.booking_cancellation_reason,
    b.booking_created_at,

    u.id AS host_id,
    CONCAT(u.firstname, ' ', COALESCE(u.middlename, ''), ' ', u.lastname) AS host_name,
    u.contact_number AS host_contact_number,
    u.email AS host_email,
    u.address AS host_address,

    v.id AS venue_id,
    v.name AS venue_name,
    v.address AS venue_location,
    v.price AS venue_price,
    v.rules AS venue_rules,
    v.amenities AS venue_amenities,
    v.thumbnail,
    v.availability_id AS venue_availability_id,

    p.payment_method_name AS payment_method_name,

    md.discount_value AS mandatory_discount_value,

    d.discount_value AS discount_value,

    vt.tag_name AS venue_tag_name,

    GROUP_CONCAT(COALESCE(vi.image_url, '')) AS image_urls
FROM 
    bookings b
LEFT JOIN 
    mandatory_discount md ON b.booking_discount_id = md.id
LEFT JOIN 
    payment_method_sub p ON b.booking_payment_method = p.id
LEFT JOIN
    discounts d ON d.id = b.booking_coupon_id
LEFT JOIN 
    venues v ON b.booking_venue_id = v.id
LEFT JOIN 
    users u ON v.host_id = u.id
LEFT JOIN
    venue_tag_sub vt ON v.venue_tag = vt.id
LEFT JOIN 
    venue_images vi ON v.id = vi.venue_id
";

            // Filter conditions
            $conditions = [];
            $params = [];

            if ($userId) {
                $conditions[] = "b.booking_guest_id = :userId";
                $params[':userId'] = $userId;
            }
            if ($status) {
                $conditions[] = "b.booking_status_id LIKE :status";
                $params[':status'] = "%$status%";
            }

            // Append conditions to query
            if (!empty($conditions)) {
                $sql .= " WHERE " . implode(" AND ", $conditions);
            }

            // Add GROUP BY clause
            $sql .= " GROUP BY b.id";

            // Add ORDER BY clause
            $sql .= " ORDER BY b.booking_created_at DESC";

            // Prepare and execute the statement
            $stmt = $conn->prepare($sql);
            $stmt->execute($params);

            // Fetch and return results
            $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $bookings;
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
    function cancelBooking($bookingId, $reason)
    {
        try {
            $conn = $this->db->connect();
            $sql = "UPDATE bookings SET booking_status_id = 3, booking_cancellation_reason = :reason WHERE id = :booking_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':booking_id', $bookingId);
            $stmt->bindParam(':reason', $reason);

            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }

    function getBookingsByHost($host_id, $booking_status)
    {
        try {
            $conn = $this->db->connect();
            $sql = "SELECT 
                u.firstname AS guest_firstname,
                u.birthdate AS guest_birthdate,
                u.lastname AS guest_lastname, 
                u.address AS guest_address,
                u.created_at AS guest_created_at,
                u.email AS guest_email,
                u.sex_id AS guest_sex_id,
                v.*, 
                b.*, 
                b.id AS booking_id, 
                IF(md.userId IS NOT NULL, 1, 0) AS is_discounted, 
                GROUP_CONCAT(vi.image_url) AS image_urls
            FROM 
                venues AS v
            JOIN 
                users AS u
            JOIN 
                bookings AS b 
                ON v.id = b.booking_venue_id 
            LEFT JOIN 
                venue_images AS vi
                ON v.id = vi.venue_id
            LEFT JOIN 
                mandatory_discount AS md
                ON b.booking_guest_id = md.userId
            WHERE 
                v.host_id = :host_id 
                AND b.booking_status_id = :booking_status 
                AND b.booking_guest_id = u.id
            GROUP BY 
                b.id;
            ";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':host_id', $host_id, PDO::PARAM_INT);
            $stmt->bindParam(':booking_status', $booking_status, PDO::PARAM_INT);
            $stmt->execute();
            $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $bookings;
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    function getBookingByVenue($venue_id, $booking_status)
    {
        try {
            $conn = $this->db->connect();
            $sql = "SELECT 
                COUNT(b.id) OVER() AS booking_count, 
                b.*, 
                u.*, 
                v.* ,

                p.payment_method_name AS payment_method_name
            FROM bookings b
            LEFT JOIN 
                payment_method_sub p ON b.booking_payment_method = p.id
            JOIN users u ON b.booking_guest_id = u.id
            JOIN venues v ON b.booking_venue_id = v.id
            WHERE b.booking_venue_id = :venue_id AND b.booking_status_id = :status
            GROUP BY b.booking_created_at DESC LIMIT 3;
        ";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':venue_id', $venue_id);
            $stmt->bindParam(':status', $booking_status);
            $stmt->execute();
            $booking = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all rows since multiple bookings may exist
            return $booking;
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    function updateVenue(
        $venueId,
        $venueName,
        $venueDescription,
        $venueAddress,
        $venueLocation,
        $venueAmenities,
        $venueRules,
        $venuePricingType,
        $venuePrice,
        $venueMinHead,
        $venueMaxHead,
        $venueMinTime,
        $venueMaxTime,
        $venueOpeningTime = null,
        $venueClosingTime = null,
        $venueEntrance,
        $venueCleaning,
        $venueDownpayment,
        $venueType,
        $venueThumbnail,
        $venueAvailability,
        $venueImgs,
        $discountValue,
        $discountType,
        $discountCode,
        $discountDate,
        $discountsToDelete
    ) {
        try {
            $conn = $this->db->connect();

            // Begin transaction
            $conn->beginTransaction();

            // Update venue details in `venues` table
            $sql = "UPDATE venues 
            SET 
                name = :name, 
                description = :description,
                address = :address, 
                location = :location, 
                amenities = :amenities, 
                rules = :rules, 
                pricing_type = :pricing_type,
                price = :price, 
                min_attendees = :min_attendees,
                max_attendees = :max_attendees,
                min_time = :min_time,
                max_time = :max_time,
                opening_time = :opening_time,
                closing_time = :closing_time,
                entrance = :entrance, 
                cleaning = :cleaning, 
                down_payment_id = :down_payment_id, 
                venue_tag = :venue_tag, 
                thumbnail = :thumbnail, 
                availability_id = :availability_id 
            WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':name', $venueName);
            $stmt->bindParam(':description', $venueDescription);
            $stmt->bindParam(':address', $venueAddress);
            $stmt->bindParam(':location', $venueLocation);
            $stmt->bindParam(':amenities', $venueAmenities);
            $stmt->bindParam(':rules', $venueRules);
            $stmt->bindParam(':pricing_type', $venuePricingType);
            $stmt->bindParam(':price', $venuePrice);
            $stmt->bindParam(':min_attendees', $venueMinHead);
            $stmt->bindParam(':max_attendees', $venueMaxHead);
            $stmt->bindParam(':min_time', $venueMinTime);
            $stmt->bindParam(':max_time', $venueMaxTime);
            $stmt->bindValue(':opening_time', $venueOpeningTime, is_null($venueOpeningTime) ? PDO::PARAM_NULL : PDO::PARAM_STR);
            $stmt->bindValue(':closing_time', $venueClosingTime, is_null($venueClosingTime) ? PDO::PARAM_NULL : PDO::PARAM_STR);
            $stmt->bindParam(':entrance', $venueEntrance);
            $stmt->bindParam(':cleaning', $venueCleaning);
            $stmt->bindParam(':down_payment_id', $venueDownpayment);
            $stmt->bindParam(':venue_tag', $venueType);
            $stmt->bindParam(':thumbnail', $venueThumbnail);
            $stmt->bindParam(':availability_id', $venueAvailability);
            $stmt->bindParam(':id', $venueId);
            $stmt->execute();

            // Insert new images into `venue_images`
            if (!empty($venueImgs)) {
                $sqldel = "DELETE FROM venue_images WHERE venue_id = :id";
                $stmt = $conn->prepare($sqldel);
                $stmt->bindParam(':id', $venueId);
                $stmt->execute();

                $sql = "INSERT INTO venue_images (venue_id, image_url) VALUES (:venue_id, :image_url)";
                $stmt = $conn->prepare($sql);
                foreach ($venueImgs as $image) {
                    $stmt->bindParam(':venue_id', $venueId);
                    $stmt->bindParam(':image_url', $image);
                    $stmt->execute();
                }
            }

            // Insert discount if applicable
            if (!empty($discountValue) && !empty($discountType) && !empty($discountCode) && !empty($discountDate)) {
                $sql = "INSERT INTO discounts (venue_id, discount_value, discount_type, discount_code, expiration_date) 
                    VALUES (:venue_id, :discount_value, :discount_type, :discount_code, :expiration_date)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':venue_id', $venueId);
                $stmt->bindParam(':discount_value', $discountValue);
                $stmt->bindParam(':discount_type', $discountType);
                $stmt->bindParam(':discount_code', $discountCode);
                $stmt->bindParam(':expiration_date', $discountDate);
                $stmt->execute();
            }

            if (!empty($discountsToDelete)) {
                $sql = "DELETE FROM discounts WHERE id = :id";
                $stmt = $conn->prepare($sql);
                foreach ($discountsToDelete as $discountId) {
                    $stmt->bindParam(':id', $discountId);
                    $stmt->execute();
                }
            }

            // Commit transaction
            $conn->commit();

            return ['status' => 'success', 'message' => 'Venue updated successfully.'];
        } catch (PDOException $e) {
            // Rollback transaction on error
            $conn->rollBack();
            error_log("Database error: " . $e->getMessage());
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }


    function rateHost($user_id, $host_id, $rating, $review)
    {
        try {
            $conn = $this->db->connect();
            $sql = "INSERT INTO host_reviews (user_id, host_id, rating, review) VALUES (:user_id, :host_id, :rating, :review)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':host_id', $host_id);
            $stmt->bindParam(':rating', $rating);
            $stmt->bindParam(':review', $review);
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }

    function getHostRatings($host_id)
    {
        try {
            $conn = $this->db->connect();
            $sql = "SELECT 
                AVG(rating) AS average,
                COUNT(rating) AS total,
                SUM(CASE WHEN rating = 5 THEN 1 ELSE 0 END) AS rating_5,
                SUM(CASE WHEN rating = 4 THEN 1 ELSE 0 END) AS rating_4,
                SUM(CASE WHEN rating = 3 THEN 1 ELSE 0 END) AS rating_3,
                SUM(CASE WHEN rating = 2 THEN 1 ELSE 0 END) AS rating_2,
                SUM(CASE WHEN rating = 1 THEN 1 ELSE 0 END) AS rating_1
            FROM host_reviews WHERE host_id = :host_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':host_id', $host_id);
            $stmt->execute();
            $ratings = $stmt->fetch(PDO::FETCH_ASSOC);
            return $ratings;
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    function getHostReviews($host_id)
    {
        try {
            $conn = $this->db->connect();
            $sql = "SELECT 
                r.id,
                r.review,
                r.rating,
                r.created_at AS date,
                u.id AS user_id,
                CONCAT(u.firstname, ' ', u.lastname) AS user_name,
                u.profile_pic AS profile_pic
            FROM host_reviews r
            JOIN users u ON r.user_id = u.id
            WHERE r.host_id = :host_id
            ORDER BY date DESC;";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':host_id', $host_id);
            $stmt->execute();
            $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $reviews;
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    function getDownpayment($venueId)
    {
        try {
            $conn = $this->db->connect();
            $sql = "SELECT downpayment_sub.* FROM downpayment_sub
            JOIN venues ON downpayment_sub.id = venues.down_payment_id
            WHERE venues.id = :venue_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':venue_id', $venueId);
            $stmt->execute();
            $downpayment = $stmt->fetch();
            return $downpayment;
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }


    function markBookingAsCheckedIn($bookingId, $guestId)
    {
        try {
            $conn = $this->db->connect();

            $sql = "UPDATE bookings SET check_in_status = 'Checked-in', check_in_date = NOW()
                WHERE id = :booking_id AND booking_guest_id = :guest_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':booking_id', $bookingId, PDO::PARAM_INT);
            $stmt->bindParam(':guest_id', $guestId, PDO::PARAM_INT);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return ['status' => 'success', 'message' => 'Booking marked as attended successfully'];
            } else {
                return ['status' => 'error', 'message' => 'No matching booking found or already checked-in'];
            }
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    function markBookingAsCheckedOut($bookingId, $guestId)
    {
        try {
            $conn = $this->db->connect();

            $sql = "UPDATE bookings SET check_out_status = 'Checked-Out', check_out_date = NOW(), booking_status_id = 4, booking_cancellation_reason = NULL
                WHERE id = :booking_id AND booking_guest_id = :guest_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':booking_id', $bookingId, PDO::PARAM_INT);
            $stmt->bindParam(':guest_id', $guestId, PDO::PARAM_INT);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return ['status' => 'success', 'message' => 'Booking marked as checked-out successfully'];
            } else {
                return ['status' => 'error', 'message' => 'No matching booking found or already checked-out'];
            }
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    function markNoShow($bookingId)
    {
        try {
            $conn = $this->db->connect();

            $sql = "UPDATE bookings SET check_in_status = 'No-Show', check_in_date = NOW(), check_out_status = NULL, check_out_date = NULL, booking_status_id = 3, booking_cancellation_reason = 'Guest did not show up for the booking -host' WHERE id = :booking_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':booking_id', $bookingId, PDO::PARAM_INT);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    private function getVenueRevenueData($venueId)
    {
        try {
            $sql = "SELECT 
                    DATE_FORMAT(booking_start_datetime, '%Y-%m') as month,
                    SUM(booking_grand_total) as revenue
                    FROM bookings
                    WHERE booking_venue_id = ?
                    AND booking_status_id IN (2,4)
                    GROUP BY DATE_FORMAT(booking_start_datetime, '%Y-%m')
                    ORDER BY month DESC
                    LIMIT 12";

            $conn = $this->db->connect();
            $stmt = $conn->prepare($sql);
            $stmt->execute([$venueId]);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $labels = [];
            $values = [];
            foreach ($data as $row) {
                $labels[] = date('M Y', strtotime($row['month'] . '-01'));
                $values[] = floatval($row['revenue']);
            }

            return [
                'labels' => array_reverse($labels),
                'values' => array_reverse($values)
            ];
        } catch (Exception $e) {
            error_log($e->getMessage());
            return ['labels' => [], 'values' => []];
        }
    }

    public function getTimeBasedStats($venueId)
    {
        try {
            $conn = $this->db->connect();

            // Today's stats
            $todayStats = $conn->prepare("
                SELECT 
                    COUNT(*) as bookings,
                    COALESCE(SUM(booking_grand_total), 0) as revenue,
                    COALESCE(AVG(booking_participants), 0) as avg_guests
                FROM bookings 
                WHERE booking_venue_id = ? 
                AND DATE(booking_created_at) = CURDATE()
                AND booking_status_id IN (2,4)
            ");
            $todayStats->execute([$venueId]);
            $today = $todayStats->fetch(PDO::FETCH_ASSOC);

            // This week's stats
            $weekStats = $conn->prepare("
                SELECT 
                    COUNT(*) as bookings,
                    COALESCE(SUM(booking_grand_total), 0) as revenue,
                    COALESCE(AVG(booking_participants), 0) as avg_guests
                FROM bookings 
                WHERE booking_venue_id = ? 
                AND YEARWEEK(booking_created_at) = YEARWEEK(CURDATE())
                AND booking_status_id IN (2,4)
            ");
            $weekStats->execute([$venueId]);
            $week = $weekStats->fetch(PDO::FETCH_ASSOC);

            // This month's stats
            $monthStats = $conn->prepare("
                SELECT 
                    COUNT(*) as bookings,
                    COALESCE(SUM(booking_grand_total), 0) as revenue,
                    COALESCE(AVG(booking_participants), 0) as avg_guests
                FROM bookings 
                WHERE booking_venue_id = ? 
                AND MONTH(booking_created_at) = MONTH(CURDATE())
                AND YEAR(booking_created_at) = YEAR(CURDATE())
                AND booking_status_id IN (2,4)
            ");
            $monthStats->execute([$venueId]);
            $month = $monthStats->fetch(PDO::FETCH_ASSOC);

            // This year's stats
            $yearStats = $conn->prepare("
                SELECT 
                    COUNT(*) as bookings,
                    COALESCE(SUM(booking_grand_total), 0) as revenue,
                    COALESCE(AVG(booking_participants), 0) as avg_guests
                FROM bookings 
                WHERE booking_venue_id = ? 
                AND YEAR(booking_created_at) = YEAR(CURDATE())
                AND booking_status_id IN (2,4)
            ");
            $yearStats->execute([$venueId]);
            $year = $yearStats->fetch(PDO::FETCH_ASSOC);

            return [
                'today' => [
                    'bookings' => (int) $today['bookings'],
                    'revenue' => (float) $today['revenue'],
                    'avg_guests' => round($today['avg_guests'], 1)
                ],
                'week' => [
                    'bookings' => (int) $week['bookings'],
                    'revenue' => (float) $week['revenue'],
                    'avg_guests' => round($week['avg_guests'], 1)
                ],
                'month' => [
                    'bookings' => (int) $month['bookings'],
                    'revenue' => (float) $month['revenue'],
                    'avg_guests' => round($month['avg_guests'], 1)
                ],
                'year' => [
                    'bookings' => (int) $year['bookings'],
                    'revenue' => (float) $year['revenue'],
                    'avg_guests' => round($year['avg_guests'], 1)
                ]
            ];
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [
                'today' => ['bookings' => 0, 'revenue' => 0, 'avg_guests' => 0],
                'week' => ['bookings' => 0, 'revenue' => 0, 'avg_guests' => 0],
                'month' => ['bookings' => 0, 'revenue' => 0, 'avg_guests' => 0],
                'year' => ['bookings' => 0, 'revenue' => 0, 'avg_guests' => 0]
            ];
        }
    }

    public function getAllVenuesWithStats($hostId)
    {
        try {
            $sql = "SELECT 
                    v.*,
                    vt.tag_name as venue_tag_name,
                    GROUP_CONCAT(vi.image_url) as image_urls,
                    
                    -- Booking counts
                    COUNT(DISTINCT b.id) as total_bookings,
                    SUM(CASE WHEN b.booking_status_id = 1 THEN 1 ELSE 0 END) as pending_bookings,
                    SUM(CASE WHEN b.booking_status_id = 2 THEN 1 ELSE 0 END) as confirmed_bookings,
                    SUM(CASE WHEN b.booking_status_id = 3 THEN 1 ELSE 0 END) as cancelled_bookings,
                    SUM(CASE WHEN b.booking_status_id = 4 THEN 1 ELSE 0 END) as completed_bookings,
                    
                    -- Revenue
                    COALESCE(SUM(b.booking_grand_total), 0) as total_revenue,
                    
                    -- Average rating
                    COALESCE(AVG(r.rating), 0) as average_rating,
                    
                    -- Average duration
                    COALESCE(AVG(b.booking_duration), 0) as average_duration,
                    
                    -- Total guests
                    COALESCE(SUM(b.booking_participants), 0) as total_guests,
                    
                    -- Occupancy rate (completed + confirmed bookings / total days since venue creation * 100)
                    (COUNT(CASE WHEN b.booking_status_id IN (2,4) THEN 1 END) * 100.0 / 
                        GREATEST(DATEDIFF(CURRENT_DATE, v.created_at), 1)) as occupancy_rate
                    
                    FROM venues v
                    LEFT JOIN venue_tag_sub vt ON v.venue_tag = vt.id
                    LEFT JOIN venue_images vi ON v.id = vi.venue_id
                    LEFT JOIN bookings b ON v.id = b.booking_venue_id
                    LEFT JOIN reviews r ON v.id = r.venue_id
                    WHERE v.host_id = ?
                    GROUP BY v.id";

            $conn = $this->db->connect();
            $stmt = $conn->prepare($sql);
            $stmt->execute([$hostId]);
            $venues = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($venues as &$venue) {
                $venue['image_urls'] = $venue['image_urls'] ? explode(',', $venue['image_urls']) : [];
                $venue['revenue_data'] = $this->getVenueRevenueData($venue['id']);
                $venue['recent_reviews'] = $this->getVenueRecentReviews($venue['id']);
                $venue['popular_month'] = $this->getVenuePopularMonth($venue['id']);
                $venue['time_based_stats'] = $this->getTimeBasedStats($venue['id']);
            }

            return $venues;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    private function getVenueRecentReviews($venueId)
    {
        try {
            $sql = "SELECT 
                    r.*,
                    CONCAT(u.firstname, ' ', u.lastname) as guest_name,
                    DATE_FORMAT(r.created_at, '%M %d, %Y') as date
                    FROM reviews r
                    JOIN users u ON r.user_id = u.id
                    WHERE r.venue_id = ?
                    ORDER BY r.created_at DESC
                    LIMIT 5";

            $conn = $this->db->connect();
            $stmt = $conn->prepare($sql);
            $stmt->execute([$venueId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    private function getVenuePopularMonth($venueId)
    {
        try {
            $sql = "SELECT 
                    DATE_FORMAT(booking_start_datetime, '%M') as month,
                    COUNT(*) as booking_count
                    FROM bookings
                    WHERE booking_venue_id = ?
                    AND booking_status_id IN (2,4)
                    GROUP BY DATE_FORMAT(booking_start_datetime, '%M')
                    ORDER BY booking_count DESC
                    LIMIT 1";

            $conn = $this->db->connect();
            $stmt = $conn->prepare($sql);
            $stmt->execute([$venueId]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result ? $result['month'] : 'N/A';
        } catch (Exception $e) {
            error_log($e->getMessage());
            return 'N/A';
        }
    }

    public function getVenuesByHost($hostId)
    {
        try {
            $sql = "SELECT v.*, GROUP_CONCAT(vi.image_url) as image_urls 
                    FROM venues v 
                    LEFT JOIN venue_images vi ON v.id = vi.venue_id 
                    WHERE v.host_id = :host_id
                    GROUP BY v.id";
            $stmt = $this->db->connect()->prepare($sql);
            $stmt->bindParam(':host_id', $hostId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return [];
        }
    }

    public function getVenueStatistics($venueId)
    {
        try {
            $sql = "SELECT 
                    COUNT(*) as total_bookings,
                    COALESCE(AVG(r.rating), 0) as average_rating,
                    COALESCE(SUM(b.booking_grand_total), 0) as total_revenue,
                    (COUNT(CASE WHEN b.booking_status_id IN (2,4) THEN 1 END) * 100.0 / NULLIF(COUNT(*), 0)) as occupancy_rate
                    FROM bookings b
                    LEFT JOIN reviews r ON b.booking_venue_id = r.venue_id
                    WHERE b.booking_venue_id = :venue_id";

            $stmt = $this->db->connect()->prepare($sql);
            $stmt->bindParam(':venue_id', $venueId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return [
                'total_bookings' => 0,
                'average_rating' => 0,
                'total_revenue' => 0,
                'occupancy_rate' => 0
            ];
        }
    }

    public function getBookingCountByStatus($venueId, $statusId)
    {
        try {
            $sql = "SELECT COUNT(*) as count FROM bookings 
                    WHERE booking_venue_id = :venue_id AND booking_status_id = :status_id";
            $stmt = $this->db->connect()->prepare($sql);
            $stmt->bindParam(':venue_id', $venueId, PDO::PARAM_INT);
            $stmt->bindParam(':status_id', $statusId, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'];
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return 0;
        }
    }

    public function getBookingsByGuest($guestId)
    {
        try {
            $query = "
                SELECT DISTINCT
                    b.id as booking_id,
                    b.booking_start_datetime,
                    b.booking_end_datetime,
                    b.booking_status_id,
                    b.booking_participants,
                    b.booking_venue_price,
                    b.booking_grand_total,
                    b.booking_guest_id,
                    v.id as venue_id,
                    v.name,
                    v.host_id,
                    h.firstname as host_firstname,
                    h.lastname as host_lastname,
                    h.profile_pic as host_profile_pic,
                    h.id as host_id,
                    g.firstname as guest_firstname,
                    g.lastname as guest_lastname,
                    g.profile_pic as guest_profile_pic,
                    g.id as guest_id
                FROM bookings b
                JOIN venues v ON b.booking_venue_id = v.id
                JOIN users h ON v.host_id = h.id
                JOIN users g ON b.booking_guest_id = g.id
                WHERE b.booking_guest_id = :guest_id
                AND b.booking_status_id IN (1, 2, 3, 4)
                ORDER BY b.booking_created_at DESC
            ";

            $stmt = $this->db->connect()->prepare($query);
            $stmt->bindParam(':guest_id', $guestId, PDO::PARAM_INT);
            $stmt->execute();

            $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Ensure host_id and guest_id are correctly set
            foreach ($bookings as &$booking) {
                $booking['host_id'];  // This is the venue owner
                $booking['guest_id'] = $booking['booking_guest_id'];  // This is the person who made the booking
            }

            return $bookings;

        } catch (PDOException $e) {
            error_log("Error in getBookingsByGuest: " . $e->getMessage());
            return [];
        }
    }

    function getBookedDatesByVenue($month, $year, $venueID)
    {
        try {
            $sql = "SELECT b.booking_start_datetime, b.booking_end_datetime FROM bookings b JOIN venues v ON b.booking_venue_id = v.id WHERE (MONTH(booking_start_datetime) = :month OR MONTH(b.booking_end_datetime) = :month) AND (YEAR(b.booking_start_datetime) = :year OR YEAR(b.booking_end_datetime) = :year) AND v.id = venueID;";
            $conn = $this->db->connect();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':month', $month);
            $stmt->bindParam(':year', $year);
            $stmt->bindParam(':venueID', $venueID);
            $stmt->execute();
            $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (count($bookings) > 0) {
                return $bookings;
            } else {
                return [];
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    function getbookingInfo($venueID)
    {
        try {
            $sql = "SELECT * FROM bookings b JOIN venues v ON b.booking_venue_id = v.id WHERE v.id = :venueID;";
            $conn = $this->db->connect();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':venueID', $venueID);
            $stmt->execute();
            $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (count($bookings) > 0) {
                return $bookings;
            } else {
                return [];
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    function getRemainingBookings($venueID)
    {
        try {
            $sql = "SELECT COUNT(*) as remaining_bookings FROM bookings WHERE booking_venue_id = :venueID AND booking_status_id = 2 AND booking_start_datetime > NOW();";
            $conn = $this->db->connect();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':venueID', $venueID);
            $stmt->execute();
            $bookings = $stmt->fetch(PDO::FETCH_ASSOC);
            return $bookings['remaining_bookings'];
        } catch (Exception $e) {
            error_log($e->getMessage());
            return 0;
        }
    }

    function deleteVenue($venueID, $user)
    {
        try {
            $sql = "SELECT v.host_id FROM venues v WHERE v.id = :venueID;";
            $conn = $this->db->connect();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':venueID', $venueID);
            $stmt->execute();
            $venue = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$venue) {
                return ['status' => 'error', 'message' => 'Venue not found.'];
            }

            if ($venue['host_id'] == $user) {
                $sql = "DELETE FROM venues WHERE id = :venueID;";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':venueID', $venueID);
                $stmt->execute();
                return ['status' => 'success', 'message' => 'Venue deleted successfully.'];
            } else {
                return ['status' => 'error', 'message' => 'You do not have permission to delete this venue.'];
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            return ['status' => 'error', 'message' => 'An error occurred while deleting the venue.'];
        }
    }

    function getDiscountsByVenue($venueID)
    {
        try {
            $sql = "SELECT * FROM discounts WHERE venue_id = :venueID;";
            $conn = $this->db->connect();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':venueID', $venueID);
            $stmt->execute();
            $discounts = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (count($discounts) > 0) {
                return $discounts;
            } else {
                return [];
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    function getIdOfCoupon($couponCode)
    {
        try {
            $sql = "SELECT id FROM discounts WHERE discount_code = :couponCode;";
            $conn = $this->db->connect();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':couponCode', $couponCode);
            $stmt->execute();
            $coupon = $stmt->fetchColumn();
            if ($coupon) {
                return $coupon;
            } else {
                return null;
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            return 0;
        }
    }

    function getAllVenueImages()
    {
        try {
            $sql = "SELECT image_url FROM venue_images";
            $conn = $this->db->connect();
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $images = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($images > 1) {
                return $images;
            } else {
                return [];
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function updateBookingCheckIn($booking_id)
    {
        try {
            $sql = "UPDATE bookings 
                    SET booking_checkin_status = 'Checked-In',
                        booking_checkin_date = CURRENT_DATE
                    WHERE id = ?";
            $conn = $this->db->connect();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam("i", $booking_id);

            return $stmt->execute();
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function updateBookingCheckOut($booking_id)
    {
        try {
            $sql = "UPDATE bookings 
                    SET booking_checkout_status = 'Checked-Out',
                        booking_checkout_date = CURRENT_DATE,
                        booking_status_id = 4
                    WHERE id = ?";
            $conn = $this->db->connect();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam("i", $booking_id);

            return $stmt->execute();
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function updateBookingNoShow($booking_id)
    {
        try {
            $sql = "UPDATE bookings 
                    SET booking_checkin_status = 'No-Show'
                    WHERE id = ?";
            $conn = $this->db->connect();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam("i", $booking_id);

            return $stmt->execute();
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function addBookingCharge($booking_id, $item, $description, $cost)
    {
        try {
            $sql = "INSERT INTO booking_charges (booking_id, item, description, cost)
                    VALUES (?, ?, ?, ?)";
            $conn = $this->db->connect();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam("issd", $booking_id, $item, $description, $cost);

            return $stmt->execute();
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function getBookingCharges($booking_id)
    {
        try {
            if (!$booking_id) {
                return [];
            }

            $conn = $this->db->connect();
            $sql = "SELECT * FROM booking_charges WHERE booking_id = :booking_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':booking_id', $booking_id);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Error getting booking charges: " . $e->getMessage());
            return [];
        }
    }

    public function getPaymentMethodName($payment_method_id)
    {
        try {
            $sql = "SELECT payment_method_name 
                    FROM payment_method_sub 
                    WHERE id = ?";
            $conn = $this->db->connect();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam("i", $payment_method_id);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            return $row ? $row['payment_method_name'] : 'Unknown';
        } catch (Exception $e) {
            error_log($e->getMessage());
            return 'Unknown';
        }
    }

    public function getPaymentStatusName($payment_status_id)
    {
        try {
            if (!$payment_status_id) {
                return 'Unknown';
            }

            $conn = $this->db->connect();

            $sql = "SELECT payment_status_name FROM payment_status_sub WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $payment_status_id);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['payment_status_name'] : 'Unknown';

        } catch (PDOException $e) {
            error_log("Error getting payment status name: " . $e->getMessage());
            return 'Unknown';
        }
    }

    public function getAdminBookings($type = 'all')
    {
        try {
            $conn = $this->db->connect();

            $sql = "SELECT 
                    b.*,
                    b.id AS booking_id,
                    b.booking_start_datetime,
                    b.booking_end_datetime,
                    b.booking_duration,
                    b.booking_participants,
                    b.booking_venue_price AS booking_original_price,
                    b.booking_grand_total,
                    b.booking_payment_method,
                    b.booking_payment_reference,
                    b.booking_service_fee,
                    b.booking_status_id,
                    b.booking_payment_status_id,
                    b.booking_cancellation_reason,
                    b.booking_created_at,
                    b.booking_checkin_status,
                    b.booking_checkout_status,
                    b.booking_checkin_date,
                    b.booking_checkout_date,

                    u.id AS guest_id,
                    CONCAT(u.firstname, ' ', u.middlename, ' ', u.lastname) AS guest_name,
                    u.contact_number AS guest_contact_number,
                    u.email AS guest_email,

                    v.name AS venue_name,
                    v.address AS venue_location,

                    COALESCE(d.discount_value, 0) AS discount_value,
                    COALESCE(d.discount_code, 'N/A') AS discount_code,
                    
                    pm.payment_method_name
                FROM 
                    bookings b
                    LEFT JOIN users u ON b.booking_guest_id = u.id
                    LEFT JOIN venues v ON b.booking_venue_id = v.id
                    LEFT JOIN discounts d ON b.booking_coupon_id = d.id
                    LEFT JOIN payment_method_sub pm ON b.booking_payment_method = pm.id
                WHERE 1=1";

            switch ($type) {
                case 'approved':
                    $sql .= " AND b.booking_status_id = 2";
                    break;
                case 'cancelled':
                    $sql .= " AND b.booking_status_id = 3";
                    break;
                case 'rejected':
                    $sql .= " AND b.booking_status_id = 0";
                    break;
                case 'completed':
                    $sql .= " AND b.booking_status_id = 4";
                // case 'checkin':
                //     $sql .= " AND b.booking_status_id = 2 AND b.booking_checkin_status = 'Pending'";
                //     break;
                // case 'checkout':
                //     $sql .= " AND b.booking_status_id = 2 AND b.booking_checkin_status = 'Checked-In' AND b.booking_checkout_status = 'Pending'";
                //     break;
            }

            $sql .= " ORDER BY b.booking_created_at DESC";

            $stmt = $conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Error getting admin bookings: " . $e->getMessage());
            return [];
        }
    }

<<<<<<< HEAD
    public function getDashboardStats($host_id) {
        try {
            $conn = $this->db->connect();
            
            // Get total reservations
            $totalSql = "SELECT COUNT(*) as total FROM bookings b 
                        JOIN venues v ON b.booking_venue_id = v.id 
                        WHERE v.host_id = :host_id";
            $stmt = $conn->prepare($totalSql);
            $stmt->execute([':host_id' => $host_id]);
            $total = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

            // Get current month reservations
            $currentMonthSql = "SELECT COUNT(*) as count FROM bookings b 
                              JOIN venues v ON b.booking_venue_id = v.id 
                              WHERE v.host_id = :host_id 
                              AND MONTH(b.booking_created_at) = MONTH(CURRENT_DATE()) 
                              AND YEAR(b.booking_created_at) = YEAR(CURRENT_DATE())";
            $stmt = $conn->prepare($currentMonthSql);
            $stmt->execute([':host_id' => $host_id]);
            $currentMonth = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

            // Get upcoming reservations (next 7 days)
            $upcomingSql = "SELECT COUNT(*) as count FROM bookings b 
                          JOIN venues v ON b.booking_venue_id = v.id 
                          WHERE v.host_id = :host_id 
                          AND b.booking_start_date BETWEEN CURRENT_DATE() AND DATE_ADD(CURRENT_DATE(), INTERVAL 7 DAY)
                          AND b.booking_status_id = 2"; // Confirmed status
            $stmt = $conn->prepare($upcomingSql);
            $stmt->execute([':host_id' => $host_id]);
            $upcoming = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

            // Get pending requests
            $pendingSql = "SELECT COUNT(*) as count FROM bookings b 
                         JOIN venues v ON b.booking_venue_id = v.id 
                         WHERE v.host_id = :host_id 
                         AND b.booking_status_id = 1"; // Pending status
            $stmt = $conn->prepare($pendingSql);
            $stmt->execute([':host_id' => $host_id]);
            $pending = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

            // Get current month revenue
            $revenueSql = "SELECT COALESCE(SUM(b.booking_grand_total), 0) as revenue 
                          FROM bookings b 
                          JOIN venues v ON b.booking_venue_id = v.id 
                          WHERE v.host_id = :host_id 
                          AND MONTH(b.booking_created_at) = MONTH(CURRENT_DATE()) 
                          AND YEAR(b.booking_created_at) = YEAR(CURRENT_DATE())
                          AND b.booking_status_id IN (2, 4)"; // Confirmed or Completed bookings
            $stmt = $conn->prepare($revenueSql);
            $stmt->execute([':host_id' => $host_id]);
            $revenue = $stmt->fetch(PDO::FETCH_ASSOC)['revenue'];

            // Get total revenue
            $totalRevenueSql = "SELECT COALESCE(SUM(b.booking_grand_total), 0) as total_revenue 
                               FROM bookings b 
                               JOIN venues v ON b.booking_venue_id = v.id 
                               WHERE v.host_id = :host_id 
                               AND b.booking_status_id IN (2, 4)"; // Confirmed or Completed bookings
            $stmt = $conn->prepare($totalRevenueSql);
            $stmt->execute([':host_id' => $host_id]);
            $totalRevenue = $stmt->fetch(PDO::FETCH_ASSOC)['total_revenue'];

            // Get average rating
            $ratingsSql = "SELECT COALESCE(AVG(r.rating), 0) as avg_rating 
                          FROM reviews r 
                          JOIN venues v ON r.venue_id = v.id 
                          WHERE v.host_id = :host_id";
            $stmt = $conn->prepare($ratingsSql);
            $stmt->execute([':host_id' => $host_id]);
            $avgRating = $stmt->fetch(PDO::FETCH_ASSOC)['avg_rating'];

            // Calculate occupancy rate
            $occupancySql = "SELECT 
                            COUNT(CASE WHEN b.booking_status_id IN (2,4) THEN 1 END) * 100.0 / 
                            GREATEST(DATEDIFF(CURRENT_DATE, MIN(v.created_at)), 1) as occupancy_rate
                            FROM venues v 
                            LEFT JOIN bookings b ON v.id = b.booking_venue_id
                            WHERE v.host_id = :host_id";
            $stmt = $conn->prepare($occupancySql);
            $stmt->execute([':host_id' => $host_id]);
            $occupancyRate = $stmt->fetch(PDO::FETCH_ASSOC)['occupancy_rate'];

            return [
                'total_reservations' => $total,
                'current_month_reservations' => $currentMonth,
                'upcoming_reservations' => $upcoming,
                'pending_requests' => $pending,
                'current_month_revenue' => $revenue,
                'total_revenue' => $totalRevenue,
                'average_rating' => round($avgRating, 1),
                'occupancy_rate' => round($occupancyRate, 1)
            ];

        } catch (PDOException $e) {
            error_log("Database error in getDashboardStats: " . $e->getMessage());
            return [
                'total_reservations' => 0,
                'current_month_reservations' => 0,
                'upcoming_reservations' => 0,
                'pending_requests' => 0,
                'current_month_revenue' => 0,
                'total_revenue' => 0,
                'average_rating' => 0,
                'occupancy_rate' => 0
            ];
        }
    }

    public function getMonthlyRevenue($host_id) {
        try {
            $conn = $this->db->connect();
            
            // Get monthly revenue for the last 12 months
            $sql = "SELECT 
                    DATE_FORMAT(b.booking_created_at, '%Y-%m') as month,
                    COALESCE(SUM(b.booking_grand_total), 0) as revenue
                FROM bookings b
                JOIN venues v ON b.booking_venue_id = v.id
                WHERE v.host_id = :host_id
                AND b.booking_status_id IN (2, 4) -- Confirmed or Completed bookings
                AND b.booking_created_at >= DATE_SUB(CURRENT_DATE(), INTERVAL 12 MONTH)
                GROUP BY DATE_FORMAT(b.booking_created_at, '%Y-%m')
                ORDER BY month ASC";
                
            $stmt = $conn->prepare($sql);
            $stmt->execute([':host_id' => $host_id]);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Database error in getMonthlyRevenue: " . $e->getMessage());
            return [];
        }
    }

    public function getBookingStatusStats($host_id) {
        try {
            $conn = $this->db->connect();
            
            $sql = "SELECT 
                    CASE 
                        WHEN b.booking_status_id = 1 THEN 'Pending'
                        WHEN b.booking_status_id = 2 THEN 'Confirmed'
                        WHEN b.booking_status_id = 3 THEN 'Cancelled'
                        WHEN b.booking_status_id = 4 THEN 'Completed'
                        ELSE 'Unknown'
                    END as status,
                    COUNT(*) as count
                FROM bookings b
                JOIN venues v ON b.booking_venue_id = v.id
                WHERE v.host_id = :host_id
                GROUP BY b.booking_status_id
                ORDER BY b.booking_status_id";
                
            $stmt = $conn->prepare($sql);
            $stmt->execute([':host_id' => $host_id]);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Database error in getBookingStatusStats: " . $e->getMessage());
            return [];
        }
    }

    public function getVenueCalendarEvents($host_id) {
        try {
            $conn = $this->db->connect();
            
            $sql = "SELECT 
                    b.id,
                    b.booking_start_date as start,
                    b.booking_end_date as end,
                    CONCAT(u.firstname, ' ', u.lastname) as guest_name,
                    v.name as venue_name,
                    b.booking_participants as participants,
                    b.booking_grand_total as total_amount,
                    b.booking_request as special_requests,
                    u.contact_number as guest_contact,
                    u.email as guest_email,
                    u.profile_pic,
                    u.firstname,
                    CASE 
                        WHEN b.booking_status_id = 1 THEN '#FCD34D' -- Pending (Yellow)
                        WHEN b.booking_status_id = 2 THEN '#34D399' -- Confirmed (Green)
                        WHEN b.booking_status_id = 3 THEN '#F87171' -- Cancelled (Red)
                        WHEN b.booking_status_id = 4 THEN '#60A5FA' -- Completed (Blue)
                        ELSE '#9CA3AF' -- Unknown (Gray)
                    END as backgroundColor,
                    CASE 
                        WHEN b.booking_status_id = 1 THEN '#C4A000' -- Darker Yellow for border
                        WHEN b.booking_status_id = 2 THEN '#2B9D6A' -- Darker Green for border
                        WHEN b.booking_status_id = 3 THEN '#C53030' -- Darker Red for border
                        WHEN b.booking_status_id = 4 THEN '#3182CE' -- Darker Blue for border
                        ELSE '#718096' -- Darker Gray for border
                    END as borderColor,
                    b.booking_status_id,
                    CASE 
                        WHEN b.booking_status_id = 1 THEN 'Pending'
                        WHEN b.booking_status_id = 2 THEN 'Confirmed'
                        WHEN b.booking_status_id = 3 THEN 'Cancelled'
                        WHEN b.booking_status_id = 4 THEN 'Completed'
                        ELSE 'Unknown'
                    END as status
                FROM bookings b
                JOIN venues v ON b.booking_venue_id = v.id
                JOIN users u ON b.booking_guest_id = u.id
                WHERE v.host_id = :host_id
                AND b.booking_start_date >= DATE_SUB(CURRENT_DATE(), INTERVAL 1 MONTH)
                AND b.booking_end_date <= DATE_ADD(CURRENT_DATE(), INTERVAL 6 MONTH)
                ORDER BY b.booking_start_date ASC";
                
            $stmt = $conn->prepare($sql);
            $stmt->execute([':host_id' => $host_id]);
            
            $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Format events for FullCalendar
            foreach ($events as &$event) {
                // Create a descriptive title
                $event['title'] = "{$event['venue_name']} - {$event['guest_name']}";
                
                // Set event display properties
                $event['allDay'] = false; // Allow time-based display
                $event['editable'] = false; // Prevent drag-and-drop by default
                
                // Handle profile picture
                $profile_pic = '';
                if ($event['profile_pic'] === null || $event['profile_pic'] === '') {
                    $profile_pic = ['type' => 'placeholder', 'content' => strtoupper(substr($event['firstname'], 0, 1))];
                } else {
                    $profile_pic = ['type' => 'image', 'content' => $event['profile_pic']];
                }
                
                // Add extended properties for the tooltip/modal
                $event['extendedProps'] = [
                    'venue_name' => $event['venue_name'],
                    'guest_name' => $event['guest_name'],
                    'guest_contact' => $event['guest_contact'],
                    'guest_email' => $event['guest_email'],
                    'participants' => $event['participants'],
                    'total_amount' => number_format($event['total_amount'], 2),
                    'special_requests' => $event['special_requests'],
                    'status' => $event['status'],
                    'profile_pic' => $profile_pic
                ];
                
                // Clean up the event object
                unset(
                    $event['venue_name'],
                    $event['guest_name'],
                    $event['guest_contact'],
                    $event['guest_email'],
                    $event['participants'],
                    $event['total_amount'],
                    $event['special_requests'],
                    $event['status'],
                    $event['profile_pic'],
                    $event['firstname']
                );
            }
            
            return $events;
            
        } catch (PDOException $e) {
            error_log("Database error in getVenueCalendarEvents: " . $e->getMessage());
            return [];
        }
    }

    public function getVenueBookings($venue_id, $status_id = null, $limit = null) {
        try {
            $conn = $this->db->connect();
            
            $sql = "SELECT 
                    b.*,
                    u.firstname,
                    u.lastname,
                    u.email,
                    u.contact_number,
                    CASE 
                        WHEN u.profile_pic IS NULL OR u.profile_pic = '' 
                        THEN UPPER(LEFT(u.firstname, 1))
                        ELSE u.profile_pic 
                    END as profile_pic,
                    v.name as venue_name,
                    v.price as venue_price,
                    bss.booking_status_name as status_name,
                    pms.payment_method_name,
                    pss.payment_status_name,
                    d.discount_code,
                    d.discount_type,
                    d.discount_value,
                    md.discount_type as mandatory_discount_type,
                    md.discount_value as mandatory_discount_value
                FROM bookings b
                JOIN users u ON b.booking_guest_id = u.id
                JOIN venues v ON b.booking_venue_id = v.id
                JOIN bookings_status_sub bss ON b.booking_status_id = bss.id
                LEFT JOIN payment_method_sub pms ON b.booking_payment_method = pms.id
                LEFT JOIN payment_status_sub pss ON b.booking_payment_status_id = pss.id
                LEFT JOIN discounts d ON b.booking_coupon_id = d.id
                LEFT JOIN mandatory_discount md ON b.booking_discount_id = md.id
                WHERE b.booking_venue_id = :venue_id";

            if ($status_id !== null) {
                $sql .= " AND b.booking_status_id = :status_id";
            }

            $sql .= " ORDER BY b.booking_created_at DESC";

            if ($limit !== null) {
                $sql .= " LIMIT :limit";
            }

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':venue_id', $venue_id);
            
            if ($status_id !== null) {
                $stmt->bindParam(':status_id', $status_id);
            }
            
            if ($limit !== null) {
                $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            }

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in getVenueBookings: " . $e->getMessage());
            return [];
        }
    }

=======
    public function getClosedDateTime($venueId)
    {
        try {
            $sql = "SELECT closing_time, opening_time FROM venues WHERE id = :venue_id";
            $conn = $this->db->connect();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':venue_id', $venueId);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return null;
        }
    }


>>>>>>> 020c245a9c87e4846bd0efff377368df8af14a2b
}

$venueObj = new Venue();