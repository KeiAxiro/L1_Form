<?php

// error_reporting(E_ALL ^ E_NOTICE);
require("../func.php");

$result = null;
$dataInput_T = null;
$datastrsorted = null;
$n = null;
$nmodus = null;
$fiValue = null;
$fixi = null;
$datasum = null;

$sfixi = null;
$sfi = null;

$row = isset($_COOKIE['row_k']) ? $_COOKIE['row_k'] : 1;

$DataTabel;
$modus = null;

$modus_i = null;



if (isset($_GET['submit_T'])) {
    $dataInput_T = $_GET['datainput'];
    $data_T = validateAndConvertToIntegerArray($dataInput_T);
    if (is_string($data_T)) {
        $result = $data_T;
    } else {
        sort($data_T);
        $n = count($data_T);

        $modus = findModusTunggal($data_T);
        $nmodus = count($modus);
    }
}

if (!isset($_COOKIE['row_k'])) {
    setcookie('row_k', '1', time() + (86400 * 30), "/");
}



if (isset($_GET['add'])) {

    $row++;
    setcookie('row_k', $row, time() + (86400 * 30), "/");
}
if (isset($_GET['reset'])) {
    $row = 1;
    setcookie('row', 1, time() + (86400 * 30), "/");
    setcookie('row_k', $row, time() + (86400 * 30), "/");
}
if (isset($_GET['delete'])) {
    if ($row != 1) {
        $row--;
        setcookie('row_k', $row, time() + (86400 * 30), "/");
    }
}


if (isset($_GET['submit_k'])) {
    $row = $_COOKIE['row_k'];

    for ($i = 0; $i < $row; $i++) {
        $aValue = isset($_GET['a' . $i]) ? $_GET['a' . $i] : null;
        $bValue = isset($_GET['b' . $i]) ? $_GET['b' . $i] : null;
        $fValue = isset($_GET['f' . $i]) ? $_GET['f' . $i] : null;
        $fiValue = isset($_GET['f' . $i]) ? (float)$_GET['f' . $i] : null;
        $xiValue = ((float)$bValue + (float)$aValue) / 2;
        $fixi = ((float)$fiValue * (float)$xiValue);


        if ($aValue !== null && $bValue !== null && $fValue !== null) {
            $DataTabel[] = [
                'a' => (float)$aValue,
                'b' => (float)$bValue,
                'f' => (float)$fValue,
                'fi' => (float)$fValue,
                'xi' => (float)$xiValue,
                'fixi' => (float)$fixi,
            ];

            $sfixi += $fixi;
            $sfi += $fiValue;
        }
    }
    if ($aValue < $bValue) {

        $result = $sfixi / $sfi;
    } else {
        $result = "\color{Red}\\text{Data yang kamu masukan tidak valid!}";
    }
}

if (isset($_GET['submit_kt'])) {
    $row = $_COOKIE['row_k'];

    for ($i = 0; $i < $row; $i++) {
        $xiValue = isset($_GET['nt' . $i]) ? $_GET['nt' . $i] : null;
        $fValue = isset($_GET['ft' . $i]) ? (float)$_GET['ft' . $i] : null;

        if ($xiValue !== null && $fValue !== null) {
            $DataTabel[] = [
                'nt' => (float)$xiValue,
                'ft' => (float)$fValue,

            ];
        }
        $nmodus = count($DataTabel);
        $modus_i = hitungModus($DataTabel);
    }
    // if (!empty($xiValue)) {

    //     $result = $sfixi / $sfi;
    // } else {
    //     $result = "\color{Red}\\text{Data yang kamu masukan tidak valid!}";
    // }
}


?>

<!doctype html>
<html lang="en">

<head>
    <title>Modus</title>
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
    <link rel="stylesheet" href="style.css">

</head>

<body data-bs-theme="dark">
    <header>
        <!-- place navbar here -->
        <?php
        include("../navbar.php");
        ?>
    </header>
    <main>

        <div class="container-fluid pt-2" id="wrapper">

            <h1 class="mb-4">Modus</h1>

            <div class="border border-primary rounded">

                <div class="collapse mt-3" id="C_MT">
                    <div class="card card-body">
                        <h3>Modus Data Tunggal</h3>
                        <div class="row rounded">
                            <form action="" method="get" class="col-md col-lg-4 border-end">
                                <h4 class="mt-1">Input</h4>

                                <div class="mb-3">
                                    <label for="" class="form-label">Data:</label>
                                    <input
                                        required
                                        type="text"
                                        class="form-control form-control-sm"
                                        name="datainput"
                                        id="datainput"
                                        aria-describedby="helpId"
                                        value="<?= $dataInput_T = ($dataInput_T ==  null) ? null : $dataInput_T  ?>"
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
                                <div class="border border-primary rounded p-2 bg-primary bg-gradient" style="--bs-bg-opacity: .5; ">

                                    <p>Data : <?= $dataInput_T = ($dataInput_T ==  null) ? null : $dataInput_T  ?></p>
                                    <p>
                                        $$
                                        \text{Data Sort: }
                                        \begin{array}{|c|c|}
                                        \hline
                                        <?php
                                        for ($i = 0; $i < $n; $i++) {
                                            $isModus = in_array($data_T[$i], $modus); // cek kntl per array //234

                                            if ($i == $n - 1) { // akhir 
                                                if ($isModus) {
                                                    echo '\bbox[orange, 8px]{\color{Black}' . $data_T[$i] . '}';
                                                } else {
                                                    echo '\bbox[#ff483b, 8px]{\color{black}' . $data_T[$i] . '}';
                                                }
                                            } else { // gak akhir
                                                if ($isModus) {
                                                    echo '\bbox[orange, 8px]{\color{Black}' . $data_T[$i] . '} & ';
                                                } else {
                                                    echo '\bbox[#ff483b, 8px]{\color{Black}' . $data_T[$i] . '} & ';
                                                }
                                            }
                                        }

                                        ?>\\
                                        \hline
                                        \end{array}
                                        $$
                                    </p>

                                    $$
                                    \text{Modusnya Adalah: <?php for ($i = 0; $i < $nmodus; $i++) {
                                                                if ($i == $nmodus - 1) {
                                                                    if ($nmodus == 1) {
                                                                        echo "" . $modus[$i];
                                                                    } else {
                                                                        echo "dan " . $modus[$i];
                                                                    }
                                                                } else {
                                                                    echo $modus[$i] . ", ";
                                                                }
                                                            } ?>}
                                    $$

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-inline-flex gap-1 mt-2 p-2 pb-3">
                    <a id="toggle_MT" class="btn btn-primary" data-bs-toggle="collapse" href="#C_MT" role="button" aria-expanded="false" aria-controls="C_MT">
                        Modus Data Tunggal
                    </a>
                </div>

            </div>

            <!----------------------------------------------------------------------------------------------------------------------------------->

            <br>

            <div class="collapse mt-3" id="C_MKT">
                <div class="card card-body">
                    <h3>
                        Modus Data Tabel

                    </h3>
                    <div class="row rounded">
                        <form action="" method="get" class="col-md col-lg-4 border-end">
                            <h4 class="mt-1">Input</h4>

                            <div class="mb-3">
                                <div
                                    class="table-responsive mt-1">
                                    <table
                                        class="table border">
                                        <thead>

                                            <tr>
                                                <th scope="col">Nilai</th>
                                                <th scope="col">Frekuensi</th>
                                                <th style="width:97px;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            for ($i = 0; $i < $row; $i++) :
                                            ?>
                                                <tr class="">
                                                    <td scope="row">

                                                        <input
                                                            type="number"
                                                            class="form-control form-control-sm"
                                                            name="nt<?= $i ?>"
                                                            id="nt<?= $i ?>"
                                                            value="<?= $va = isset($_GET['nt' . $i]) ? $_GET['nt' . $i] : ""  ?>"
                                                            placeholder="" />

                                                    </td>
                                                    <td>
                                                        <input

                                                            type="number"
                                                            class="form-control form-control-sm"
                                                            name="ft<?= $i ?>"
                                                            id="ft<?= $i ?>"
                                                            value="<?= $va = isset($_GET['ft' . $i]) ? $_GET['ft' . $i] : ""  ?>"
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
                                                <td>
                                                    <Label for="delete" class="form-label">Delete</Label>
                                                    <input
                                                        name="delete"
                                                        id="delete"
                                                        class="btn btn-danger"
                                                        type="submit"
                                                        value="<?= $rowv = $row == 1 ? 1 : $row - 1 ?>" />

                                                </td>
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
                                name="submit_kt"
                                class="btn btn-warning mb-3">
                                Submit
                            </button>


                        </form>

                        <div class="col border-start">
                            <h3 class="mt-1">Output</h3>
                            <div class="border border-warning rounded bg-warning bg-gradient row mx-1" style="--bs-bg-opacity: .45;">
                                <div
                                    class=" col-md  rounded" id="outkon" style="color:white;">
                                    <?php
                                    if (!empty($DataTabel)) {
                                    ?>
                                        $$
                                        \begin{array}{|c|c|}
                                        \hline
                                        \text{Nilai} & Frekuensi \\

                                        <?php
                                        for ($i = 0; $i < $nmodus; $i++) {
                                            $isModus = in_array($DataTabel[$i]['ft'], $modus_i);
                                            if ($isModus) {


                                        ?>
                                                \hline
                                                <?= $DataTabel[$i]['nt'] ?> & <?= $DataTabel[$i]['ft'] ?> & \displaystyle \gets modus \\
                                                \hline
                                            <?php
                                            } else {
                                            ?>
                                                \hline
                                                <?= $DataTabel[$i]['nt'] ?> & <?= $DataTabel[$i]['ft'] ?> \\
                                                \hline
                                        <?php
                                            }
                                        }
                                        ?>

                                        \hline
                                        \end{array}
                                        $$
                                    <?php
                                        var_dump($modus_i);
                                    }
                                    ?>
                                </div>

                                <div class="col bg-warning rounded" style="color:black; --bs-bg-opacity: .74;" id="outkon">

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <p class="d-inline-flex gap-1 mt-2">
                <a id="toggleKDTK" class="btn btn-warning" data-bs-toggle="collapse" href="#C_MKT" role="button" aria-expanded="false" aria-controls="C_MKT">
                    Modus Data Kelompok
                </a>
            </p>


            <!----------------------------------------------------------------------------------------------------------------------------------->

            <br>

            <div class="collapse mt-3" id="C_MK">
                <div class="card card-body">
                    <h3>
                        Modus Data Kelompok

                    </h3>
                    <div class="row rounded">
                        <form action="" method="get" class="col-md col-lg-4 border-end">
                            <h4 class="mt-1">Input</h4>

                            <div class="mb-3">
                                <div
                                    class="table-responsive mt-1">
                                    <table
                                        style="width: 12rem;"
                                        class="table border">
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
                                                    <Label for="delete" class="form-label">Delete</Label>
                                                    <input
                                                        name="delete"
                                                        id="delete"
                                                        class="btn btn-danger"
                                                        type="submit"
                                                        value="<?= $rowv = $row == 1 ? 1 : $row - 1 ?>" />

                                                </td>
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
                            <span class="<?= $kon = isset($_GET['submit_k']) ? 'visually-hidden' : '' ?>">Input data terlebih dahulu</span>
                            <div class=" border border-success rounded bg-success bg-gradient row mx-1" style="--bs-bg-opacity: .5;">
                                <div
                                    class=" <?= $kon = !isset($_GET['submit_k']) ? 'visually-hidden' : '' ?> col-md  rounded" id="outkon">
                                    $$
                                    \begin{array}{|c|c|c|c|c|}
                                    \hline
                                    \text{Interval} & f_i & x_i & f_i.x_i & \sum f_i \\
                                    \hline
                                    <?php
                                    if (!empty($DataTabel)) :
                                        foreach ($DataTabel as $njir) :
                                    ?>
                                            <?= $njir['a'] ?>-<?= $njir['b'] ?> & <?= $njir['f'] ?> & <?= $njir['xi'] ?> &<?= $njir['f'] ?> \times<?= $njir['xi'] ?> = <?= $njir['fixi'] ?> & <?= $njir['fi'] ?> \\
                                            \hline
                                    <?php endforeach;
                                    endif; ?>
                                    \end{array}
                                    $$
                                </div>

                                <div class="col bg-success rounded text-white" style="--bs-bg-opacity: .74;" id="outkon">
                                    <span>$$
                                        \large\boxed{\displaystyle \bar{x}= \frac{\sum f_i . x_i}{\sum f_i}}
                                        $$
                                    </span>
                                    <span class=" <?= $kon = !isset($_GET['submit_k']) ? 'visually-hidden' : '' ?>">
                                        $$\displaystyle\sum f_i =
                                        <?php

                                        if (!empty($DataTabel)) :
                                            $i = 0;
                                            $lenghtData = count($DataTabel);
                                            foreach ($DataTabel as $njir) {
                                                if (++$i == $lenghtData) {
                                                    echo $njir['f'] . '';
                                                } else {
                                                    echo $njir['f'] . '+';
                                                }
                                            }
                                            echo '=' . $fiValue;
                                        endif;
                                        ?>
                                        $$
                                    </span>
                                    <p>
                                        $$

                                        \begin{array}{rcl}
                                        \displaystyle\sum f_i.x_i & = &


                                        <?php
                                        if (!empty($DataTabel)) :
                                            $i = 0;
                                            $lenghtData = count($DataTabel);
                                            foreach ($DataTabel as $njir) {
                                                if (++$i == $lenghtData) {
                                                    echo $njir['fixi'] . '';
                                                } else {
                                                    echo $njir['fixi'] . '+';
                                                }
                                            }
                                        endif;
                                        ?>
                                        \\& = & <?= $sfixi ?>\\
                                        \end{array}
                                        $$


                                        \begin{array}{rcl}
                                        \large\bar{x} & = & \displaystyle\frac{\displaystyle\sum f_i.x_i}{\sum f_i} \\
                                        \\
                                        & = & \large\displaystyle\frac{ <?= $sfixi ?>}{ <?= $sfi ?>} \\
                                        \\
                                        & = & \large<?= $result ?>

                                        \end{array}
                                    </p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <p class="d-inline-flex gap-1 mt-2">
                <a id="toggleKDK" class="btn btn-success" data-bs-toggle="collapse" href="#C_MK" role="button" aria-expanded="false" aria-controls="C_MK">
                    Modus Data Kelompok
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
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
    <script>
        var kdt = document.getElementById('toggle_MT');
        const bsCollapse = new bootstrap.Collapse('#C_MT', {
            toggle: <?= $kondisiCMT = $dataInput_T != null ? 'true' : 'false' ?>
        })
        const bssCollapse = new bootstrap.Collapse('#C_MK', {
            toggle: <?= $kondisiCMK = isset($_GET['a0']) ? 'true' : 'false' ?>
        })
        const bsssCollapse = new bootstrap.Collapse('#C_MKT', {
            toggle: <?= $kondisiCMKT = isset($_GET['nt0']) ? 'true' : 'false' ?>
        })
    </script>
</body>

</html>