<?php
header('Content-Type: application/json');

// Prevent direct access to this file
if ($_SERVER['REQUEST_METHOD'] !== 'POST' && !isset($_GET['reference'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method'
    ]);
    exit;
}

// If checking payment status
if (isset($_GET['reference'])) {
    $reference = $_GET['reference'];
    
    // Simulate payment status check
    // In a real implementation, you would check against your payment provider's API
    $status = 'pending';
    if (strlen($reference) > 0) {
        // Randomly simulate completed payments for testing
        $status = (rand(0, 1) === 1) ? 'completed' : 'pending';
    }
    
    echo json_encode([
        'success' => true,
        'status' => $status,
        'reference' => $reference
    ]);
    exit;
}

// Handle payment initiation
try {
    // Get POST data
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!$data) {
        throw new Exception('Invalid JSON data');
    }
    
    // Validate required fields
    if (!isset($data['paymentMethod'])) {
        throw new Exception('Payment method is required');
    }
    
    if (!isset($data['amount']) || !is_numeric($data['amount'])) {
        throw new Exception('Valid amount is required');
    }
    
    if (!isset($data['reservationDetails'])) {
        throw new Exception('Reservation details are required');
    }
    
    // Generate a unique reference number
    $reference = 'PAY-' . strtoupper(uniqid());
    
    // Generate QR code URL (in a real implementation, this would come from your payment provider)
    $qrCode = 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=' . urlencode(json_encode([
        'reference' => $reference,
        'amount' => $data['amount'],
        'method' => $data['paymentMethod']
    ]));
    
    echo json_encode([
        'success' => true,
        'reference' => $reference,
        'qrCode' => $qrCode,
        'message' => 'Payment initiated successfully'
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}