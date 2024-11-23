<?php
header('Content-Type: application/json');

// Create uploads directory if it doesn't exist
$uploadsDir = __DIR__ . '/qr-codes';
if (!file_exists($uploadsDir)) {
    mkdir($uploadsDir, 0755, true);
}

// Check if this is a status check request
if (isset($_GET['reference'])) {
    // Simulate payment status check
    // In a real implementation, you would check with GCash/Maya API
    $status = rand(0, 1) > 0.7 ? 'completed' : 'pending'; // 30% chance of completion for demo
    echo json_encode([
        'status' => $status,
        'reference' => $_GET['reference']
    ]);
    exit;
}

// Handle new payment request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Get JSON data from request body
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);
        
        if (!$data) {
            throw new Exception('Invalid request data');
        }

        $paymentMethod = $data['paymentMethod'];
        $amount = $data['amount'];
        $discountType = $data['reservationDetails']['discountType'] ?? '';
        $discountAmount = 0;

        // Apply discount if valid
        if ($discountType === 'senior_pwd' && 
            !empty($data['reservationDetails']['seniorPwdId']) &&
            !empty($data['reservationDetails']['seniorPwdName']) &&
            !empty($data['reservationDetails']['seniorPwdIdPhoto'])) {
            
            // Handle ID photo upload
            $uploadDir = __DIR__ . '/uploads/id-photos/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // Save ID information
            $idInfo = [
                'name' => $data['reservationDetails']['seniorPwdName'],
                'id_number' => $data['reservationDetails']['seniorPwdId'],
                'photo_path' => $uploadDir . basename($data['reservationDetails']['seniorPwdIdPhoto'])
            ];
            
            $discountAmount = $amount * 0.20; // 20% discount
        } elseif ($discountType === 'coupon' && $data['reservationDetails']['couponCode'] === 'SAVE10') {
            $discountAmount = $amount * 0.10; // 10% discount
        }

        $finalAmount = $amount - $discountAmount;
        
        // Generate a unique reference number
        $reference = uniqid('PAY-', true);
        
        // Generate QR code (in a real implementation, this would come from GCash/Maya)
        // For demo, we'll create a simple QR code using a placeholder service
        $qrCodeUrl = "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=" . 
                     urlencode("Payment Reference: $reference\nAmount: ₱$finalAmount");
        
        echo json_encode([
            'success' => true,
            'reference' => $reference,
            'qrCode' => $qrCodeUrl,
            'amount' => $finalAmount,
            'discount' => $discountAmount
        ]);
        
    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
    exit;
}

// Invalid request method
http_response_code(405);
echo json_encode([
    'success' => false,
    'message' => 'Method not allowed'
]);