<?php

// Mengimport file Todo yang ada di folder objek agar bisa dijalankan di file ini
include_once 'Objects/Todo.php';

//Objek todo di inisialisasi
$todo = new Todo();

/*Sebuah Switch untuk menangkap aksi Post, Edit, Delete, Dan submit 
 beserta dengan tindakan yang dikehendaki untuk setiap kondisi*/
if(isset($_POST['save']))
{
    $taskTitle = $_POST['task_title'];
    $todo->setTitle($taskTitle);
    $todo->add();
    
}else if(isset($_POST['complete']))
{
    $taskId = $_POST['complete'];
    $todo->setId($taskId);
    $todo->complete();
    
}else if(isset($_POST['delete']))
{
    $taskId = $_POST['delete'];
    $todo->setId($taskId);
    $todo->remove();
}else if(isset($_POST['edit']))
{
    $taskId = $_POST['edit'];
    header("Location: edit.php?edit_id=$taskId");
}else

?>

<!-- HTML untuk tampilan halaman -->

<!DOCTYPE html >
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title></title>
    <link href="main.css" rel="stylesheet" media="screen">

</head>

<body>

<div class="navbar navbar-default navbar-static-top" role="navigation">
</div>
<div id="content">
    <form method="post">
        <h3>Tambah Tugas</h3>
        <input type='text' name='task_title' class='form-control' required>
        <button type="submit" class="btn" name="save">
            Submit
        </button>
    </form>
</div>
<ul>
    <?php
    // Metode pemanggilan isi database
    $todo->getAll();
    ?>
</ul>
