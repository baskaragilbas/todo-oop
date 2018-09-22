<?php

// Mengimport file Todo yang ada di folder objek agar bisa dijalankan di file ini
include_once  'Objects/Todo.php';

//Inisialisasi objek Todo
$todo = new Todo();

//Sebuah Switch untuk menangkap aksi Edit
if(isset($_GET['edit_id']))
{
    $id = $_GET['edit_id'];
    extract($todo->get($id));
}

//Sebuah Switch untuk menangkap aksi submit 

if(isset($_POST['save']))
{
    $taskId = $id;
    $taskTitle = $_POST['task_title'];
    $taskCompleted = $_POST['completed'];
    $todo->setTitle($taskTitle);
    $todo->setId($taskId);
    $todo->setCompleted($taskCompleted);
    if($todo->edit())
    {
        header("Location: index.php");
    }
}?>

<!-- Html untuk halaman edit -->


<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title></title>
    <link href="main.css" rel="stylesheet" media="screen">

</head>

<body>

<div class="navbar navbar-default navbar-static-top" role="navigation">
    <div class="container">
        <div class="">
            <a class="" href="index.php">&lt&ltKembali</a>
        </div>

    </div>
</div>
<div id="content">
    <form method="post">
        <h3>Edit Tugas</h3>
        <input type='text' name='task_title' value="<?php echo $title; ?>" class='form-control' required>
        <h3>Selesai ?</h3>
        <?php
        if ($completed == 1){
            echo "<input type='radio' name='completed' value='1'  checked /> Sudah <br/>";
            echo "<input type='radio' name='completed' value='0' /> Belum <br/>";
        }else{
            echo "<input type='radio' name='completed' value='1'  /> Sudah<br/>";
            echo "<input type='radio' name='completed' value='0' checked/> Belum <br/>";
        }
        ?>
        <button type="submit" id="<?php echo $id; ?>" class="btn" name="save">
            Perbarui
        </button>
    </form>
</div>







