<?php require_once __DIR__.'/../../config.php';
if(!isset($_SESSION['user_id'])){header('Location: /user/login.php');exit;}
$uid=$_SESSION['user_id'];$pid=(int)($_POST['product_id']??0);$action=clean_input($_POST['action']??'');
if($action==='add'||$action==='buy'){ $st=$pdo->prepare('SELECT id,quantity FROM cart WHERE user_id=? AND product_id=?');$st->execute([$uid,$pid]);$row=$st->fetch(); if($row){$pdo->prepare('UPDATE cart SET quantity=quantity+1 WHERE id=?')->execute([$row['id']]);} else {$pdo->prepare('INSERT INTO cart(user_id,product_id,quantity) VALUES(?,?,1)')->execute([$uid,$pid]);}}
if($action==='inc'||$action==='dec'){ $cid=(int)$_POST['cart_id'];$op=$action==='inc'?'+':'-';$pdo->prepare("UPDATE cart SET quantity=GREATEST(1,quantity{$op}1) WHERE id=? AND user_id=?")->execute([$cid,$uid]); }
if($action==='remove'){ $cid=(int)$_POST['cart_id'];$pdo->prepare('DELETE FROM cart WHERE id=? AND user_id=?')->execute([$cid,$uid]); }
header('Location: '.($action==='buy'?'/user/checkout.php':'/user/cart.php'));
