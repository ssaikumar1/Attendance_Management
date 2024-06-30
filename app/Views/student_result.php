<!-- app/Views/student_result.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Checked and Unchecked Students</title>
</head>
<body>
    <h2>Absent Students Table:</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Roll Number</th>
                <th>Name</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($checkedStudents as $student): ?>
                <tr>
                    <td><?= $student->roll_number; ?></td>
                    <td><?= $student->name;?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <h2>Present Students Table:</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Roll Number</th>
                <th>Name</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($uncheckedStudents as $student): ?>
                <tr>
                    <td><?= $student->roll_number; ?></td>
                    <td><?= $student->name; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
