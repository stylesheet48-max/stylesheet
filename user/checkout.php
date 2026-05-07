<?php require_once __DIR__.'/../config.php'; if(!isset($_SESSION['user_id'])){header('Location:/user/login.php');exit;} include __DIR__.'/../header.php';
if($_SERVER['REQUEST_METHOD']==='POST'){ $addr=clean_input($_POST['address']??'');$payment=clean_input($_POST['payment_method']??'COD');
$uid=$_SESSION['user_id'];$items=$pdo->prepare('SELECT c.quantity,p.id,p.price FROM cart c JOIN products p ON p.id=c.product_id WHERE c.user_id=?');$items->execute([$uid]);$rows=$items->fetchAll();$total=0;foreach($rows as $r){$total+=$r['price']*$r['quantity'];}
$pdo->prepare('UPDATE users SET address=? WHERE id=?')->execute([$addr,$uid]);$pdo->prepare('INSERT INTO orders(user_id,total_price,payment_status,order_status,tracking_id,created_at) VALUES(?,?,?,"Ordered",?,NOW())')->execute([$uid,$total,$payment==='COD'?'pending':'paid',uniqid('TRK')]);$oid=$pdo->lastInsertId();$oi=$pdo->prepare('INSERT INTO order_items(order_id,product_id,quantity,price) VALUES(?,?,?,?)');foreach($rows as $r){$oi->execute([$oid,$r['id'],$r['quantity'],$r['price']]);}$pdo->prepare('DELETE FROM cart WHERE user_id=?')->execute([$uid]);
require_once __DIR__.'/../app/Services/TelegramService.php';
require_once __DIR__.'/../app/Services/WhatsAppService.php';
TelegramService::sendMessage($pdo,'order_confirmation','sent');
WhatsAppService::sendMessage($pdo,'order_confirmation','sent');
header('Location:/user/orders.php');exit; }
?>
<main class="max-w-xl mx-auto p-4"><h1 class="text-xl font-bold">Checkout</h1><form method="post" class="space-y-3 bg-white p-4 rounded-lg"><textarea name="address" required class="w-full border p-3 rounded" placeholder="Shipping address"></textarea><select name="payment_method" class="w-full border p-3 rounded"><option>COD</option><option>UPI</option><option>Card</option></select><button class="w-full bg-indigo-600 text-white py-3 rounded">Place Order</button></form></main>
<?php include __DIR__.'/../bottom.php'; ?>
