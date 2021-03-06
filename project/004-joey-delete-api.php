<?php
// NOTE fake delete
include __DIR__ . '/partials/init.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$output = [
    'success' => false,
    'error' => '沒有給id',
    'id' => $id,
];

if (!empty($id)) {
    $sql = "UPDATE `geo_info` SET `valid`=0 WHERE id=$id";
    $stmt = $pdo->query($sql);

    if ($stmt->rowCount() == 1) {
        $output['success'] = true;
        $output['error'] = '';
    } else {
        $output['error'] = '沒有這筆資料 或 該筆資料已於用戶端刪除';
    }
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
