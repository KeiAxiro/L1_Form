<?php
$result = null;
$n1sort = null;
$n = null;
$i = null;
$n1 = null;

$i_k = null;

$DataTabel;


if (!isset($_COOKIE['row_k'])) {
    setcookie('row_k', '1', time() + (86400 * 30), "/");
}

$row = !isset($_GET['add']) ? $_COOKIE['row_k'] : $_GET['add'];

if (isset($_GET['add'])) {
    $i_k = $_GET['kuartil_k'];
    $row++;
}
if (isset($_GET['reset'])) {
    $row = 1;
    setcookie('row', 1, time() + (86400 * 30), "/");
}
setcookie('row_k', $row, time() + (86400 * 30), "/");

if (isset($_GET['submit_k'])) {
    $row = $_COOKIE['row_k'];
    for ($i = 0; $i < $row; $i++) {
        $aValue = isset($_GET['a' . $i]) ? $_GET['a' . $i] : null;
        $bValue = isset($_GET['b' . $i]) ? $_GET['b' . $i] : null;
        $fValue = isset($_GET['f' . $i]) ? $_GET['f' . $i] : null;
        if ($i == 0) {
            $fkValue = isset($_GET['f' . $i]) ? $_GET['f' . $i] : null;
        } else {
            $fkValue = isset($_GET['f' . $i]) ? (int)$_GET['f' . $i - 1] + (int)$_GET['f' . $i] : null;
        }

        if ($aValue !== null && $bValue !== null && $fValue !== null) {
            $DataTabel[] = [
                'a' => (int)$aValue,
                'b' => (int)$bValue,
                'f' => (int)$fValue,
                'fk' => (int)$fkValue
            ];
        }
    }
    var_dump($DataTabel);
}

if (isset($_GET['submit_T'])) {

    $n1 = $_GET['n1'];
    $i = $_GET['kuartil'];
    $dataTunggal = validateAndConvertToIntegerArray($n1);
    if (is_string($dataTunggal)) {
        $result = $dataTunggal;
    } else {

        sort($dataTunggal);
        $n1sort = intArrayToStr($dataTunggal);

        $n = sizeof($dataTunggal);
        $a = ($n + 1) / 4;

        $x = $i * $a;
        $xa = ceil($x);
        $xb = floor($x);

        $result = $dataTunggal[$xb - 1] + (($x - $xb) * ($dataTunggal[$xa - 1] - $dataTunggal[$xb - 1]));
    }
}

function intArrayToStr($input)
{
    $dataStr = null;
    for ($i = 0; $i < sizeof($input); $i++) {
        if ($i < sizeof($input) - 1) {
            $dataStr .= "$input[$i],";
        } else {
            $dataStr .= "$input[$i]";
        }
    }
    return $dataStr;
}

function validateAndConvertToIntegerArray($input)
{

    $input = trim($input);

    if (empty($input)) {
        return "Input tidak boleh kosong.";
    }

    if (!preg_match('/^\d+(,\d+)*$/', $input)) {
        return "Input tidak valid. Hanya angka yang dipisahkan dengan koma yang diizinkan.";
    }

    $stringArray = explode(',', $input);

    $integerArray = array_map('intval', $stringArray);

    return $integerArray;
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous" />

    <style>
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
</head>

<body>
    <header>
        <!-- place navbar here -->

        <?php
        include 'navbar.php'
        ?>
    </header>
    <main>



        <div class="container">


            <div class="collapse mt-3" id="C_KDT">
                <div class="card card-body">
                    <h3>Kuartil Data Tunggal</h3>
                    <div class="row rounded">
                        <form action="" method="get" class="col border-end">
                            <h4 class="mt-1">Input</h4>
                            <div
                                class="btn-group"
                                role="group"
                                aria-label="Basic checkbox toggle button group">
                                <input
                                    type="radio"
                                    class="btn-check"
                                    name="kuartil"
                                    id="btncheck1"
                                    value="1"
                                    <?php
                                    if ($i != null and $i == 1) {
                                        echo "checked";
                                    }
                                    ?>
                                    autocomplete="off" />
                                <label
                                    class="btn btn-outline-primary"
                                    for="btncheck1">Kuartil 1</label>

                                <input
                                    type="radio"
                                    class="btn-check"
                                    name="kuartil"
                                    id="btncheck2"
                                    value="2"
                                    <?php
                                    if ($i != null and $i == 2) {
                                        echo "checked";
                                    } elseif ($i == null) {
                                        echo "checked";
                                    }
                                    ?>
                                    autocomplete="off" />
                                <label
                                    class="btn btn-outline-primary"
                                    for="btncheck2">Kuartil 2</label>

                                <input
                                    type="radio"
                                    class="btn-check"
                                    name="kuartil"
                                    id="btncheck3"
                                    value="3"
                                    <?php
                                    if ($i != null and $i == 3) {
                                        echo "checked";
                                    }
                                    ?>
                                    autocomplete="off" />
                                <label
                                    class="btn btn-outline-primary"
                                    for="btncheck3">Kuartil 3</label>
                            </div>

                            <div class="mb-3">
                                <label for="" class="form-label">Data:</label>
                                <input
                                    required
                                    type="text"
                                    class="form-control form-control-sm"
                                    name="n1"
                                    id="n1"
                                    aria-describedby="helpId"
                                    value="<?= $n1 = ($n1 ==  null) ? null : $n1  ?>"
                                    placeholder="1,2,3,4,5" />
                                <small id="helpId" class="form-text text-muted">Example: 2,1,12,2,3,4,5,6,7,8,9,10,11,....</small>


                            </div>

                            <button
                                type="submit"
                                name="submit_T"
                                class="btn btn-primary mb-3">
                                Submit
                            </button>


                        </form>

                        <div class="col border-start">
                            <h3 class="mt-1">Output</h3>
                            <div class="border border-primary rounded p-2 bg-primary bg-gradient" style="--bs-bg-opacity: .5;">
                                <span>Data : <?= $n1 = ($n1 ==  null) ? null : $n1  ?></span>
                                <br>
                                <span>Data Sort : <?= $n1sort ?></span>
                                <br>
                                <span>n : <?= $n ?></span>
                                <br>
                                <span>Result : <?= $result ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <p class="d-inline-flex gap-1 mt-2">
                <a id="toggleKDT" class="btn btn-primary" data-bs-toggle="collapse" href="#C_KDT" role="button" aria-expanded="false" aria-controls="C_KDT">
                    Kuartil Data Tunggal
                </a>
            </p>



            <!----------------------------------------------------------------------------------------------------------------------------------->

            <br>

            <div class="collapse mt-3" id="C_KDK">
                <div class="card card-body">
                    <h3>
                        Kuartil Data Kelompok

                    </h3>
                    <div class="row rounded">
                        <form action="" method="get" class="col border-end">
                            <h4 class="mt-1">Input</h4>

                            <div class="mb-3">


                                <div
                                    class="btn-group"
                                    role="group"
                                    aria-label="Basic checkbox toggle button group">
                                    <input
                                        type="radio"
                                        class="btn-check "
                                        name="kuartil_k"
                                        id="btncheck1_k"
                                        value="1"
                                        <?php
                                        if ($i_k != null and $i_k == 1) {
                                            echo "checked";
                                        }
                                        ?>
                                        autocomplete="off" />
                                    <label
                                        class="btn btn-outline-success"
                                        for="btncheck1_k">Kuartil 1</label>

                                    <input
                                        type="radio"
                                        class="btn-check"
                                        name="kuartil_k"
                                        id="btncheck2_k"
                                        value="2"
                                        <?php
                                        if ($i_k != null and $i_k == 2) {
                                            echo "checked";
                                        } elseif ($i_k == null) {
                                            echo "checked";
                                        }
                                        ?>
                                        autocomplete="off" />
                                    <label
                                        class="btn btn-outline-success"
                                        for="btncheck2_k">Kuartil 2</label>

                                    <input
                                        type="radio"
                                        class="btn-check"
                                        name="kuartil_k"
                                        id="btncheck3_k"
                                        value="3"
                                        <?php
                                        if ($i_k != null and $i_k == 3) {
                                            echo "checked";
                                        }
                                        ?>
                                        autocomplete="off" />
                                    <label
                                        class="btn btn-outline-success"
                                        for="btncheck3_k">Kuartil 3</label>
                                </div>

                                <div
                                    class="table-responsive mt-1">
                                    <table
                                        style="width: 12rem;"
                                        class="table table-success">
                                        <thead>

                                            <tr>
                                                <th scope="col" style="width: 55px;">a</th>
                                                <th scope="col" style="width: 8px;"></th>
                                                <th scope="col" style="width: 100px;">b</th>
                                                <th scope="col">F</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            for ($i = 0; $i < $row; $i++) :
                                            ?>
                                                <tr class="">
                                                    <td scope="row">

                                                        <input
                                                            style="width: 40px;"
                                                            type="number"
                                                            class="form-control form-control-sm"
                                                            name="a<?= $i ?>"
                                                            id="a<?= $i ?>"
                                                            value="<?= $va = isset($_GET['a' . $i]) ? $_GET['a' . $i] : ""  ?>"
                                                            placeholder="" />

                                                    </td>
                                                    <td>-</td>
                                                    <td>
                                                        <input
                                                            style="width: 40px;"
                                                            type="number"
                                                            class="form-control form-control-sm"
                                                            name="b<?= $i ?>"
                                                            id="b<?= $i ?>"
                                                            value="<?= $va = isset($_GET['b' . $i]) ? $_GET['b' . $i] : ""  ?>"
                                                            placeholder="" />
                                                    </td>
                                                    <td>
                                                        <input
                                                            style="width: 40px;"
                                                            type="number"
                                                            class="form-control form-control-sm"
                                                            name="f<?= $i ?>"
                                                            id="f<?= $i ?>"
                                                            value="<?= $va = isset($_GET['f' . $i]) ? $_GET['f' . $i] : ""  ?>"
                                                            placeholder="" />
                                                    </td>
                                                </tr>
                                            <?php endfor; ?>
                                            <tr>
                                                <td>
                                                    <Label for="add" class="form-label">Add</Label>
                                                    <input
                                                        name="add"
                                                        id="add"
                                                        class="btn btn-success"
                                                        type="submit"
                                                        value="<?= $rowv = $row == null ? 1 : $row ?>" />

                                                </td>
                                                <td></td>
                                                <td>
                                                    <Label for="reset" class="form-label">Reset</Label>
                                                    <input
                                                        name="reset"
                                                        id="reset"
                                                        class="btn btn-danger"
                                                        type="submit"
                                                        value="1" />

                                                </td>

                                            </tr>

                                        </tbody>
                                    </table>
                                </div>


                            </div>

                            <button
                                type="submit"
                                name="submit_k"
                                class="btn btn-success mb-3">
                                Submit
                            </button>


                        </form>

                        <div class="col border-start">
                            <h3 class="mt-1">Output</h3>
                            <div class="border border-success rounded pt-2 bg-success bg-gradient row mx-1" style="--bs-bg-opacity: .5;">
                                <div
                                    class=" col  rounded mt-2" style="width: 200px;">
                                    <table
                                        class="table table-success table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="width: 55px;">a</th>
                                                <th scope="col" style="width: 8px;"></th>
                                                <th scope="col" style="width: 55px;">b</th>
                                                <th scope="col" style="width: 55px;">f</th>
                                                <th scope="col" style="width: 55px;">fk</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (!empty($DataTabel)) :
                                                foreach ($DataTabel as $njir) :
                                            ?>
                                                    <tr class="">
                                                        <td><span><?= $njir['a'] ?></span></td>
                                                        <td>-</td>
                                                        <td><span><?= $njir['b'] ?></span></td>
                                                        <td><span><?= $njir['f'] ?></span></td>
                                                        <td><span><?= $njir['fk'] ?></span></td>


                                                    </tr>

                                            <?php endforeach;
                                            endif; ?>

                                        </tbody>
                                    </table>
                                </div>

                                <div class="col ms-2 mt-2 mb-3 me-3 bg-success rounded text-white" style="--bs-bg-opacity: .74;">
                                    hai
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <p class="d-inline-flex gap-1 mt-2">
                <a id="toggleKDK" class="btn btn-success" data-bs-toggle="collapse" href="#C_KDK" role="button" aria-expanded="false" aria-controls="C_KDK">
                    Kuartil Data Kelompok
                </a>
            </p>



        </div>
    </main>
    <footer>
        <!-- place footer here -->
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>

    <script>
        var kdt = document.getElementById('toggleKDT');
        const bsCollapse = new bootstrap.Collapse('#C_KDT', {
            toggle: <?= $kondisiCKDT = $n1 != null ? 'true' : 'false' ?>
        })
        const bssCollapse = new bootstrap.Collapse('#C_KDK', {
            toggle: <?= $kondisiCKDK = isset($_GET['kuartil_k']) ? 'true' : 'false' ?>
        })
    </script>
</body>

</html>