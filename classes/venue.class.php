<?php
require_once '../dbconnection.php';

class Venue
{
    public $id;
    public $name;
    public $description;
    public $location;
    public $price;
    public $capacity;
    public $amenities;
    public $host_id = 1;
    public $status = 1;
    public $availability = 1;
    public $image_url;

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

            // Insert venue information (without images)
            $sql = 'INSERT INTO venues (name, description, location, price, capacity, amenities, host_id, status_id, availability_id) 
                VALUES (:name, :description, :location, :price, :capacity, :amenities, :host_id, :status_id, :availability_id)';
            $stmt = $conn->prepare($sql);

            // Bind parameters
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':description', $this->description);
            $stmt->bindParam(':location', $this->location);
            $stmt->bindParam(':price', $this->price);
            $stmt->bindParam(':capacity', $this->capacity);
            $stmt->bindParam(':amenities', $this->amenities);
            $stmt->bindParam(':host_id', $this->host_id);
            $stmt->bindParam(':status_id', $this->status);
            $stmt->bindParam(':availability_id', $this->availability);

            // Execute venue insertion
            if ($stmt->execute()) {
                // Get the last inserted ID for the venue
                $last_inserted_venue = $conn->lastInsertId();

                // Loop through each image and insert them
                $images = json_decode($this->image_url); // Decode the JSON into an array of image URLs
                foreach ($images as $image_url) {
                    // Insert image URL into the venue_images table
                    $imageSql = "INSERT INTO venue_images (venue_id, image_url) VALUES (:venue_id, :image_url)";
                    $imageStmt = $conn->prepare($imageSql);
                    $imageStmt->bindParam(':venue_id', $last_inserted_venue);
                    $imageStmt->bindParam(':image_url', $image_url);

                    // Execute image insertion
                    if (!$imageStmt->execute()) {
                        // If any image fails to insert, return error
                        return ['status' => 'error', 'message' => 'Failed to add images for the venue'];
                    }
                }

                return ['status' => 'success', 'message' => 'Venue and images added successfully'];
            } else {
                return ['status' => 'error', 'message' => 'Failed to add venue'];
            }
        } catch (PDOException $e) {
            // Log error and return failure message
            error_log("Database error: " . $e->getMessage());
            return ['status' => 'error', 'message' => 'An error occurred while adding the venue'];
        }
    }
}
