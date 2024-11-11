<?php
header('Content-Type: application/json');

require "../app/init.php";


// Ambil data JSON dari request
$request = json_decode(file_get_contents('php://input'), true);
$voucherCode = $request['code_voucher'] ?? '';
$courseId = $request['course_id'] ?? '';
// Harga awal course (contoh nilai default)
if (!$courseId && !$voucherCode) {
    echo json_encode(['success' => false, 'message' => 'Kode voucher tidak valid.']);
}

$sqlCourse = mysqli_query($con, "SELECT * FROM `courses`  WHERE `id`='$courseId'");
$course = mysqli_fetch_assoc($sqlCourse);

if ($voucherCode) {
    // Query untuk mendapatkan data voucher berdasarkan kode
    $query = "SELECT * FROM vouchers WHERE code = '$voucherCode' LIMIT 1";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0 && mysqli_num_rows($sqlCourse) > 0) {
        $voucher = mysqli_fetch_assoc($result);
        $coursePrice = $course['price'];

        $discountPercentage = $voucher['discount_percentage'];
        $discountAmount = $coursePrice * ($discountPercentage / 100);
        $discountedPrice = $coursePrice - $discountAmount;

        // Kirim data sukses dengan informasi harga setelah diskon
        echo json_encode([
            'success' => true,
            'discounted_price' => number_format($discountedPrice, 0, ',', '.'),
            'discount_percentage' => $discountPercentage,
            'original_price' => number_format($coursePrice, 0, ',', '.')
        ]);
    } else {
        // Jika voucher tidak valid
        echo json_encode(['success' => false, 'message' => 'Kode voucher tidak valid.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Kode voucher tidak boleh kosong.']);
}
