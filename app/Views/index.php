<!DOCTYPE html>
<html>
<head>
    <title>Student Table</title>
</head>
<body>
    <form action="<?= site_url('student/processForm') ?>" method="post">
        <table border="1">
            <tr>
                <th>Roll Number</th>
                <th>Name</th>
                <th>Select</th>
            </tr>
            <?php foreach ($students as $student): ?>
                <tr>
                    <td><?= $student['roll_number'] ?></td>
                    <td><?= $student['name'] ?></td>
                    <td><input type="checkbox" name="selected_students[]" value="<?= $student['roll_number'] ?>"></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
