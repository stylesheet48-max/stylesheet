<?php
require_once __DIR__.'/../config.php';
if(!isset($_SESSION['admin_id'])){header('Location: /admin/login.php');exit;}
$stats=[
  'sales'=>(float)($pdo->query('SELECT COALESCE(SUM(total_price),0) t FROM orders')->fetch()['t']??0),
  'orders'=>(int)($pdo->query('SELECT COUNT(*) c FROM orders WHERE order_status!="Delivered"')->fetch()['c']??0),
  'customers'=>(int)($pdo->query('SELECT COUNT(*) c FROM users')->fetch()['c']??0),
  'low_stock'=>(int)($pdo->query('SELECT COUNT(*) c FROM products WHERE stock < 5')->fetch()['c']??0),
  'bot_logs'=>(int)($pdo->query('SELECT COUNT(*) c FROM bot_logs')->fetch()['c']??0)
];
?><!doctype html><html><head><meta name="viewport" content="width=device-width,initial-scale=1"><script src="https://cdn.tailwindcss.com"></script></head><body class="bg-slate-100 p-4"><h1 class="text-2xl font-bold mb-4">Admin Dashboard</h1><div class="grid grid-cols-2 gap-3"><?php foreach($stats as $k=>$v): ?><div class="bg-white rounded-xl p-4 shadow"><div class="text-xs text-slate-500 uppercase"><?=$k?></div><div class="text-xl font-bold"><?=$v?></div></div><?php endforeach; ?></div><div class="mt-5 flex gap-3"><a href="/admin/manage_products.php" class="bg-indigo-600 text-white px-4 py-2 rounded">Manage Products</a><a href="/admin/bot_settings.php" class="bg-slate-800 text-white px-4 py-2 rounded">Bot Settings</a></div></body></html>
