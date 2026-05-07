<?php
class TelegramService {
  public static function sendMessage(PDO $pdo, string $messageType, string $status='queued'): void {
    $stmt=$pdo->prepare('INSERT INTO bot_logs(platform,message_type,status) VALUES("telegram",?,?)');
    $stmt->execute([$messageType,$status]);
  }
}
