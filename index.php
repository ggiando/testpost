<?php
require_once "php/Database.php";

$conn = new Database("localhost", "acquario");
$conn = $conn->getConnection();

$sale = array();

$query = "SELECT id, nome FROM sale";

try {
    $statement = $conn->query($query);
    $sale = $statement->fetchAll(\PDO::FETCH_ASSOC);
} catch (\PDOException $e) {
    exit($e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://www.w3schools.com/lib/w3.js"></script>
    <style>
        table,
        th,
        td {
            border: 1px solid;
            width: 100%;
            border-collapse: collapse;
        }
    </style>
</head>

<body>
    <!--<form action="php/index.php" method="post">-->
    <form id="formsubmit" style="margin-top: 20px; margin-bottom:40px;">
        <div>
            <label for="sala">Sala</label>
            <select name="sala" id="sala">
                <option value="">Seleziona la sala</option>
                <?php
                foreach ($sale as $sala) {
                    echo "<option value='{$sala["id"]}'>{$sala["nome"]}</option>";
                }
                ?>
            </select>
        </div>
        <div>
            <label for="dataini">Data iniziale</label>
            <input type="date" name="dataini" id="dataini" />
            <label for="datafin">Data finale</label>
            <input type="date" name="datafin" id="datafin" />
        </div>
        <div><button type="submit">Submit</button></div>
    </form>


    <div id="risultati">
        <table id="tablerisultati" style="display:none;">
            <tr>
                <th>id vasca</th>
                <th>nome vasca</th>
                <th>id sensore</th>
                <th>tipo sensore</th>
                <th>misura</th>
            </tr>
            <tr w3-repeat="valori">
                <td>{{idvasca}}</td>
                <td>{{nomevasca}}</td>
                <td>{{idsensore}}</td>
                <td>{{tiposensore}}</td>
                <td>{{valoremisura}}</td>
            </tr>
        </table>
    </div>


    <script>
        $("#formsubmit").submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "php/index.php/range",
                dataType: "application/json",
                contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                // contentType: "application/json",
                data: {
                    "sala": $("#sala").val(),
                    "inizio": $("#dataini").val(),
                    "fine": $("#datafin").val()
                },
                success: function(obj, textstatus) {
                    // console.log(obj);
                    if (obj) {
                        $("#tablerisultati").show();
                        w3.displayObject("tablerisultati", JSON.parse(obj));
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.log(xhr);
                    console.log("Exception:  " + thrownError);
                }
            });
        });
    </script>
</body>

</html>