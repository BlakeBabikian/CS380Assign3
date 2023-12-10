<!-- Table structure and styling-->
<!doctype html>
<html>
    <head>
        <style>
            table  {border:1px solid green; border-collapse:collapse;
                margin-right: auto; margin-left: auto;
                font-size:20px; }
            th, td {border:1px solid green; padding:5px;}
            th {color:green;}
            h2 {text-align:center;color:blue;}
        </style>
    </head>
    <body>
            <pre>
                <table>
                    <!-- Table headers-->
                    <tr><th>Incident ID</th><th>Product Code</th><th>Title</th><th>Description</th></tr>

                    <?php
                        // Keeps track of number of incidents
                        $n = 0;
                        $pdo = null;
                        require '../model/database.php';
                        try {


                        //Might have to change database name
                        $statement = "USE bbabikian;";
                        $stmt = $pdo->query($statement);

                        // Perform SQL query to see what's in table
                        $query = "SELECT incidentID, productCode, title, description FROM incidents WHERE isnull(dateClosed) ;";
                        $stmt = $pdo->query($query);

                        }
                        catch(PDOException $e){echo $e->getMessage(); exit();}

                        //loop over result set. Print field values for each record
                        while ($line = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            $n += 1;
                            //inner loop. Print each field value for a record
                            foreach ($line as $field_value) {
                                echo "<td>$field_value</td>"  ;
                            }
                            echo "</tr>";
                        }
                    ?>
                </table>
                <?php
                    echo "<p>There are $n open incidents reported in the database</p>";
                ?>
            </pre>
    </body>
</html>

