<?php

// Mengimport file Todo yang ada di folder objek agar bisa dijalankan di file ini

include_once  $_SERVER['DOCUMENT_ROOT'].'/Todo/Config/Database.php';

// Deklarasi objek todo merupakan child dari objek database
class Todo extends Database{
 
    
    private $table_name = "tbltodo";
    protected $title = null;
    protected $id = null;
    protected $completed = false;
    protected $created = null;

    


// Membentuk koneksi database
    public function __construct(){
        parent::getConnection();
    }

    public function import(){
        parent::getCSV();
    }


// Dibawah ini merupakan fungsi untuk memasukan elemen-element dari tabel
    /**
     * @param mixed $title
     */
    public function setTitle($title){
        $this->title = $title;
    }

    
    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    
    /**
     * @param boolean $completed
     */
    public function setCompleted($completed){
        $this->completed = $completed;
    }

//Fungsi menambahkan entry pada tabel
    public function add(){
        try{
            $stmt = $this->conn->prepare("INSERT INTO tbltodo(title) VALUES(:title)");
            $stmt->bindparam(":title",$this->title);
            $stmt->execute();
            return true;
        }catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }


//Fungsi pencarian entry pada tabel berdasarkan id
    public function get($id){
        $stmt = $this->conn->prepare("SELECT * FROM tbltodo WHERE id=:id");
        $stmt->execute(array(":id"=>$id));
        $editRow=$stmt->fetch(PDO::FETCH_ASSOC);
        return $editRow;
    }

//Fungsi menghapus entry pada tabel
    public function remove(){
        $stmt = $this->conn->prepare("DELETE FROM tbltodo WHERE id=:id");
        $stmt->bindparam(":id",$this->id);
        $stmt->execute();
        return true;
    }

//Fungsi menampilkan semua entry pada tabel
   function getAll(){
        $stmt = $this->conn->prepare("SELECT * FROM tbltodo ORDER BY id DESC ");
        $stmt->execute();
        if($stmt->rowCount() >0){
            //Query di outputkan menjadi array asosiasi
            while ($row=$stmt->fetch(PDO::FETCH_ASSOC)){
                ?>
                <li>
                    <h1> <?php print($row['title']); ?> </h1>
                    <form method="post">
                        <?php
                        if ($row['completed'] == 1){
                            echo 'Status : Sudah Dikerjakan<br>';    
                        }
                        else{
                            echo 'Status : Belum Dikerjakan<br>';
                            echo "<button type='submit' value={$row['id']} class='button' name='complete'> Selesai </button>";
                        }
                        ?>
                        <button type="submit" value= <?php print($row['id']); ?> class="button" name="edit"> Edit </button>
                        <button type="submit" value= <?php print($row['id']); ?> class="delete-button" name="delete"> Hapus </button>
                    </form>
                </li>
            <?php
            }
        }else {
            echo "<h1> Tidak ada Kegiatan :(</h1>";
        }
    }

//Fungsi memberikan status selesai pada entry tabel yang sesuai dengan idnya
    public function complete(){
        try{
            $stmt = $this->conn->prepare("UPDATE tbltodo SET completed='1'
                                        WHERE id=:id ");
            $stmt->bindparam(":id",$this->id);
            $stmt->execute();
            return true;
        }catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }

    }

//Fungsi mengubah entry pada tabel
    public function edit(){
        try{
            $stmt = $this->conn->prepare("UPDATE tbltodo SET completed=:completed,
                                        title =:title WHERE id=:id ");
            $stmt->bindparam(":id",$this->id);
            $stmt->bindparam(":title",$this->title);
            $stmt->bindparam(":completed",$this->completed);
            $stmt->execute();
            return true;
        }catch(PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }

 
}
?>