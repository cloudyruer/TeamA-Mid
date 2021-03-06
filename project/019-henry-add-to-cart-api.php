<?php
/*
 * 新增, 修改, 移除
 */

session_start();

if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = [];
}


$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
$qty = isset($_GET['qty']) ? intval($_GET['qty']) : 0;
$price = isset($_GET['price']) ? intval($_GET['price']) : 0;


if (!empty($sid)) {
  if (!empty($qty)) {
    // 新增或修改
    if (!isset($_SESSION['cart'][$sid])) {
      $_SESSION['cart'][$sid] = [$qty, $price];
    } else {
      $_SESSION['cart'][$sid] += [$qty, $price];
    }
  } else {
    // 移除
    unset($_SESSION['cart'][$sid]);
  }
}
header('Content-Type: application/json');
echo json_encode($_SESSION['cart']);
