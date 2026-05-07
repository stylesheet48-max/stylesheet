<?php require_once __DIR__.'/../config.php';
if($_SERVER['REQUEST_METHOD']==='POST'){
$n=clean_input($_POST['full_name']??'');$e=filter_var(clean_input($_POST['email']??''),FILTER_VALIDATE_EMAIL);$p=clean_input($_POST['password']??'');$ph=clean_input($_POST['phone']??'');
if($n&&$e&&$p){$st=$pdo->prepare('INSERT INTO users(full_name,email,password,phone,created_at) VALUES(?,?,?,?,NOW())');$st->execute([$n,$e,password_hash($p,PASSWORD_DEFAULT),$ph]);header('Location: /user/login.php');exit;}
}
include __DIR__.'/../header.php'; ?>
<main class="max-w-md mx-auto p-4"><h1 class="text-2xl font-bold mb-4">Register</h1><form method="post" class="space-y-3 bg-white p-4 rounded-xl shadow"><input name="full_name" required placeholder="Full Name" class="w-full border p-3 rounded-lg"><input name="email" type="email" required placeholder="Email" class="w-full border p-3 rounded-lg"><input name="phone" placeholder="Phone" class="w-full border p-3 rounded-lg"><input name="password" type="password" required placeholder="Password" class="w-full border p-3 rounded-lg"><button class="w-full bg-indigo-600 text-white py-3 rounded-lg">Create account</button></form></main>
<?php include __DIR__.'/../bottom.php'; ?>
