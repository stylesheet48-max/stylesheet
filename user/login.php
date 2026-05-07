<?php require_once __DIR__.'/../config.php';
$msg='';
if($_SERVER['REQUEST_METHOD']==='POST'){
$email=filter_var(clean_input($_POST['email']??''),FILTER_VALIDATE_EMAIL);$password=clean_input($_POST['password']??'');
if($email&&$password){$st=$pdo->prepare('SELECT * FROM users WHERE email=? LIMIT 1');$st->execute([$email]);$u=$st->fetch();if($u&&password_verify($password,$u['password'])){$_SESSION['user_id']=$u['id'];header('Location: /user/index.php');exit;} $msg='Invalid credentials';}
}
include __DIR__.'/../header.php'; ?>
<main class="max-w-md mx-auto p-4"><h1 class="text-2xl font-bold mb-4">Login</h1><form method="post" class="space-y-3 bg-white p-4 rounded-xl shadow"><input name="email" type="email" required placeholder="Email" class="w-full border p-3 rounded-lg"><input name="password" type="password" required placeholder="Password" class="w-full border p-3 rounded-lg"><button class="w-full bg-indigo-600 text-white py-3 rounded-lg">Sign in</button><p class="text-red-500"><?=$msg?></p><a class="text-sm text-indigo-600" href="/user/register.php">Create account</a></form></main>
<?php include __DIR__.'/../bottom.php'; ?>
