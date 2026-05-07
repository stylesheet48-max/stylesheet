<?php
require_once __DIR__.'/../../config.php';
require_once __DIR__.'/../Services/TelegramService.php';
require_once __DIR__.'/../Services/WhatsAppService.php';
if(isset($_SESSION['user_id'])){
  TelegramService::sendMessage($pdo,'order_confirmation');
  WhatsAppService::sendMessage($pdo,'order_confirmation');
}
header('Location: /user/orders.php');
