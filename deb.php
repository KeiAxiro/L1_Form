<?php
$row = !isset($_GET['add']) ? $_COOKIE['row']    : $_GET['add'];

if (isset($_GET['add'])) {
    $row++;
}

if (isset($_GET['submit'])) {
    $row = $_COOKIE['row'];
}
setcookie('row', $row,  time() + (86400 * 30), "/");
echo $row;
echo "<br>";
echo $_COOKIE['row'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="" method="get">
        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>a</th>
                    <th>b</th>
                    <th>f</th>
                </tr>
            </thead>


            <tbody>
                <?php for ($i = 0; $i < $row; $i++) : ?>
                    <tr>
                        <td>
                            <input type="number" value="<?= $va = isset($_GET['a' . $i]) ? $_GET['a' . $i] : ""  ?>" name="a<?= $i ?>" id="a<?= $i ?>">
                        </td>
                        <td>
                            <input type="number" value="<?= $va = isset($_GET['b' . $i]) ? $_GET['b' . $i] : ""  ?>" name="b<?= $i ?>" id="b<?= $i ?>">
                        </td>
                        <td>
                            <input type="number" value="<?= $va = isset($_GET['f' . $i]) ? $_GET['f' . $i] : ""  ?>" name="f<?= $i ?>" id="f<?= $i ?>">
                        </td>
                    </tr>
                <?php endfor; ?>
                <tr>
                    <td>
                        <label for="add">tambah: </label>
                        <input type="submit" value="<?= $rowv = $row == null ? 1 : $row ?>" name="add">
                    </td>
                </tr>
            </tbody>
        </table>
        <input type="submit" value="Submit" name="submit_k">
    </form>

</body>

</html>