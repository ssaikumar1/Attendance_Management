<!DOCTYPE html>
<html>
<head>
    <title>Result Page</title>
</head>
<body>
    <h1>Selected Students</h1>
    <table border="1">
        <tr>
            <th>Roll Number</th>
            <th>Name</th>
        </tr>
        <?php foreach ($selected_students as $student): ?>
            <tr>
                <td><?= $student['roll_number'] ?></td>
                <td><?= $student['name'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    
    <h1>Unselected Students</h1>
    <table border="1">
        <tr>
            <th>Roll Number</th>
            <th>Name</th>
        </tr>
        <?php foreach ($unselected_students as $unselected_student): ?>
            <tr>
                <td><?= $unselected_student['roll_number'] ?></td>
                <td><?= $unselected_student['name'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
