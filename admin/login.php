<?php
require_once __DIR__.'/../config.php';
$error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
  $username=clean_input($_POST['username']??'');
  $password=clean_input($_POST['password']??'');
  $stmt=$pdo->prepare('SELECT * FROM admin WHERE username=? LIMIT 1');
  $stmt->execute([$username]);
  $admin=$stmt->fetch();
  if($admin && password_verify($password,$admin['password'])){
    $_SESSION['admin_id']=$admin['id'];
    header('Location: /admin/index.php');
    exit;
  }
  $error='Invalid admin credentials';
}
?>
<!doctype html><html><head><meta name="viewport" content="width=device-width,initial-scale=1"><script src="https://cdn.tailwindcss.com"></script></head><body class="bg-slate-900 text-white min-h-screen flex items-center justify-center p-4"><form method="post" class="w-full max-w-sm bg-slate-800 rounded-xl p-5 space-y-3"><h1 class="text-xl font-bold">Admin Login</h1><input name="username" class="w-full p-3 rounded bg-slate-700" placeholder="Username" required><input type="password" name="password" class="w-full p-3 rounded bg-slate-700" placeholder="Password" required><button class="w-full bg-indigo-600 rounded p-3">Login</button><p class="text-rose-400 text-sm"><?=$error?></p></form></body></html>
