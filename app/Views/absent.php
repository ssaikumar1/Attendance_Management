<!DOCTYPE html>
<html>
<head>
    <title>Absent List</title>
</head>
<body>
    <h2>Absent List</h2>
    <table border="1">
        <tr>
            <th>Roll Number</th>
            
        </tr>
        <?php foreach ($results as $row): ?>
            <tr>
                <td><?= $row['roll_number']; ?></td>
                
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
