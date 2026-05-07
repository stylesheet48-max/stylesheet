<?php
require_once __DIR__.'/../config.php';
if(!isset($_SESSION['admin_id'])){header('Location: /admin/login.php');exit;}
if($_SERVER['REQUEST_METHOD']==='POST'){
  $action=clean_input($_POST['action']??'');
  if($action==='add'){
    $name=clean_input($_POST['name']??'');$price=(float)($_POST['price']??0);$stock=(int)($_POST['stock']??0);$cat=(int)($_POST['category_id']??0);
    $image='/assets/images/placeholder.png';
    if(!empty($_FILES['image']['name'])){
      $target='/uploads/products/'.time().'_'.basename($_FILES['image']['name']);
      $dest=__DIR__.'/../assets'.$target;
      if(move_uploaded_file($_FILES['image']['tmp_name'],$dest)) $image='/assets'.$target;
    }
    $pdo->prepare('INSERT INTO products(category_id,name,description,price,old_price,stock,image_url) VALUES(?,?,?,?,?,?,?)')->execute([$cat,$name,clean_input($_POST['description']??''),$price,(float)($_POST['old_price']??0),$stock,$image]);
  }
  if($action==='delete'){$pdo->prepare('DELETE FROM products WHERE id=?')->execute([(int)$_POST['id']]);}
  header('Location: /admin/manage_products.php'); exit;
}
$cats=$pdo->query('SELECT id,name FROM categories WHERE status=1')->fetchAll();
$products=$pdo->query('SELECT p.*,c.name category FROM products p LEFT JOIN categories c ON c.id=p.category_id ORDER BY p.id DESC')->fetchAll();
?><!doctype html><html><head><meta name="viewport" content="width=device-width,initial-scale=1"><script src="https://cdn.tailwindcss.com"></script></head><body class="p-4 bg-slate-50"><h1 class="text-xl font-bold mb-3">Manage Products</h1><form method="post" enctype="multipart/form-data" class="grid gap-2 bg-white p-3 rounded-xl shadow mb-4"><input type="hidden" name="action" value="add"><input name="name" required class="border p-2 rounded" placeholder="Name"><textarea name="description" class="border p-2 rounded" placeholder="Description"></textarea><div class="grid grid-cols-3 gap-2"><input name="price" type="number" step="0.01" class="border p-2 rounded" placeholder="Price"><input name="old_price" type="number" step="0.01" class="border p-2 rounded" placeholder="Old Price"><input name="stock" type="number" class="border p-2 rounded" placeholder="Stock"></div><select name="category_id" class="border p-2 rounded"><?php foreach($cats as $c): ?><option value="<?=$c['id']?>"><?=clean_input($c['name'])?></option><?php endforeach; ?></select><input type="file" name="image" class="border p-2 rounded"><button class="bg-indigo-600 text-white p-2 rounded">Add Product</button></form><?php foreach($products as $p): ?><div class="bg-white p-3 rounded mb-2 flex justify-between"><div><?=clean_input($p['name'])?> (<?=$p['stock']?>)</div><form method="post"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?=$p['id']?>"><button class="text-red-600">Delete</button></form></div><?php endforeach; ?></body></html>
