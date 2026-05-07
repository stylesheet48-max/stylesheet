<?php
class WhatsAppService {
  public static function sendMessage(PDO $pdo, string $messageType, string $status='queued'): void {
    $stmt=$pdo->prepare('INSERT INTO bot_logs(platform,message_type,status) VALUES("whatsapp",?,?)');
    $stmt->execute([$messageType,$status]);
  }
}
