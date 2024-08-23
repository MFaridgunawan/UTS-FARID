<?php
session_start();

class ToDoList {
    private $items = [];

    public function __construct() {
        if (!isset($_SESSION["tugas"])) {
            $_SESSION["tugas"] = [];
        }
        $this->items = $_SESSION["tugas"];
    }

    public function tambahTugas($tugas) {
        if (!empty($tugas)) {
            $this->items[] = $tugas;
            $_SESSION["tugas"] = $this->items;
        }
    }

    public function hapusTugas($index) {
        if (isset($this->items[$index])) {
            unset($this->items[$index]);
            $this->items = array_values($this->items);
            $_SESSION["tugas"] = $this->items;
        }
    }

    public function getTugas() {
        return $this->items;
    }
}

$toDoList = new ToDoList();

if (isset($_POST["action"])) {
    $action = $_POST["action"];

    if ($action == "tambah" && isset($_POST["tugas"])) {
        $tugas = trim($_POST["tugas"]);
        $toDoList->tambahTugas($tugas);
    } elseif ($action == "hapus" && isset($_POST["index"])) {
        $index = (int)$_POST["index"];
        $toDoList->hapusTugas($index);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To Do List</title>
</head>
<body>
    <h1>To-Do List</h1>
    <form method="POST">
        <input type="hidden" name="action" value="tambah">
        <input type="text" name="tugas">
        <button>Tambah tugas</button>
    </form>
    <table>
        <?php foreach ($toDoList->getTugas() as $index => $tugas): ?>
        <tr>
            <td><?=htmlspecialchars($tugas); ?></td>
            <td>
                <form method="POST">
                    <input type="hidden" name="action" value="hapus">
                    <input type="hidden" name="index" value="<?=$index?>">
                    <button>Hapus</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    
    <p><a href="Home.php">Home</a></p>
</body>
</html>