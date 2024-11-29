<?php
require_once(__DIR__ . '/../dbconnection.php');

class Venue
{
    public $id;
    public $name;
    public $description;
    public $location;
    public $price;
    public $capacity;
    public $amenities;

    public $rules;
    public $tag;
    public $entrance;
    public $cleaning;
    public $host_id = 2;
    public $status = 1;
    public $availability = 1;
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
            $sql = 'INSERT INTO venues (name, description, location, price, capacity, amenities, rules, entrance, cleaning, venue_tag, time_inout, host_id, status_id, availability_id) 
                VALUES (:name, :description, :location, :price, :capacity, :amenities, :rules, :entrance, :cleaning, :venue_tag, :time_inout, :host_id, :status_id, :availability_id)';
            $stmt = $conn->prepare($sql);

            // Bind parameters
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':description', $this->description);
            $stmt->bindParam(':location', $this->location);
            $stmt->bindParam(':price', $this->price);
            $stmt->bindParam(':capacity', $this->capacity);
            $stmt->bindParam(':amenities', $this->amenities);
            $stmt->bindParam(':rules', $this->rules);
            $stmt->bindParam(':entrance', $this->entrance);
            $stmt->bindParam(':cleaning', $this->cleaning);
            $stmt->bindParam(':venue_tag', $this->tag);
            $stmt->bindParam(':time_inout', $this->check_inout);
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
    function getAllVenues($status = '', $host_id = '', $bookmarks = [])
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
            GROUP_CONCAT(vi.image_url) AS image_urls
            FROM venues v 
            JOIN venue_tag_sub vtg ON v.venue_tag = vtg.id
            JOIN venue_status_sub vss ON v.status_id = vss.id 
            JOIN venue_availability_sub vas ON v.availability_id = vas.id 
            JOIN venue_images vi ON v.id = vi.venue_id";

            // Initialize an array for conditions and parameters
            $conditions = [];
            $params = [];

            // Add conditions if parameters are provided
            if ($status) {
                $conditions[] = "v.status_id LIKE :status";
                $params[':status'] = "%$status%";
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

            // Start building the SQL query
            $sql = "SELECT 
            v.id AS venue_id,
            v.name AS venue_name,
            v.description AS venue_description,
            v.location AS venue_location,
            v.*, 
            vt.tag_name AS tag,
            vss.name AS status, 
            vas.name AS availability, 
            GROUP_CONCAT(vi.image_url) AS image_urls
            FROM venues v 
            JOIN venue_tag_sub vt ON v.venue_tag = vt.id
            JOIN venue_status_sub vss ON v.status_id = vss.id 
            JOIN venue_availability_sub vas ON v.availability_id = vas.id 
            JOIN venue_images vi ON v.id = vi.venue_id 
            WHERE v.id = :venue_id;";
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

    function bookVenue($booking_start_date, $booking_end_date, $booking_start_time, $booking_end_time, $booking_duration, $booking_status_id, $booking_participants, $booking_grand_total, $booking_guest_id, $booking_venue_id, $booking_payment_method, $booking_payment_reference, $booking_payment_status_id, $booking_discount_name = null, $booking_discount_card = null, $booking_discount_value = null)
    {
        try {
            $conn = $this->db->connect();

            $sql = "INSERT INTO bookings (booking_start_date, booking_end_date, booking_start_time, booking_end_time, booking_duration, booking_status_id, booking_participants, booking_grand_total, booking_guest_id, booking_venue_id, booking_payment_method, booking_payment_reference, booking_payment_status_id) VALUES (:booking_start_date, :booking_end_date, :booking_start_time, :booking_end_time, :booking_duration, :booking_status_id, :booking_participants, :booking_grand_total, :booking_guest_id, :booking_venue_id, :booking_payment_method, :booking_payment_reference, :booking_payment_status_id)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':booking_start_date', $booking_start_date);
            $stmt->bindParam(':booking_end_date', $booking_end_date);
            $stmt->bindParam(':booking_start_time', $booking_start_time);
            $stmt->bindParam(':booking_end_time', $booking_end_time);
            $stmt->bindParam(':booking_duration', $booking_duration);
            $stmt->bindParam(':booking_status_id', $booking_status_id);
            $stmt->bindParam(':booking_participants', $booking_participants);
            $stmt->bindParam(':booking_grand_total', $booking_grand_total);
            $stmt->bindParam(':booking_guest_id', $booking_guest_id);
            $stmt->bindParam(':booking_venue_id', $booking_venue_id);
            $stmt->bindParam(':booking_payment_method', $booking_payment_method);
            $stmt->bindParam(':booking_payment_reference', $booking_payment_reference);
            $stmt->bindParam(':booking_payment_status_id', $booking_payment_status_id);

            if ($stmt->execute()) {
                $lastInsertedBookingId = $conn->lastInsertId();
                if ($booking_discount_name && $booking_discount_card && $booking_discount_value) {
                    $discountSql = "INSERT INTO booking_discount (booking_id, booking_discount_name, booking_discount_card, booking_discount_value) VALUES (:booking_id, :booking_discount_name, :booking_discount_card, :booking_discount_value)";
                    $discountStmt = $conn->prepare($discountSql);
                    $discountStmt->bindParam(':booking_id', $lastInsertedBookingId);
                    $discountStmt->bindParam(':booking_discount_name', $booking_discount_name);
                    $discountStmt->bindParam(':booking_discount_card', $booking_discount_card);
                    $discountStmt->bindParam(':booking_discount_value', $booking_discount_value);

                    if (!$discountStmt->execute()) {
                        return ['status' => 'error', 'message' => 'Failed to add discount for the booking'];
                    }
                }
                return ['status' => 'success', 'message' => 'Booking added successfully'];
            } else {
                return ['status' => 'error', 'message' => 'Failed to add booking'];
            }
        } catch (PDOException $e) {
            // Log error and return failure message
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
    //     $conn = $this->db->connect();
    //     $sql = "SELECT id FROM discounts WHERE discount_code = :discount_code;";
    //     $stmt = $conn->prepare($sql);
    //     $stmt->bindParam(':discount_code', $name);
    //     $stmt->execute();
    //     return $stmt->fetch(PDO::FETCH_ASSOC);
    // }
}

$venueObj = new Venue();

// var_dump($venueObj->getAllVenues('', 3));