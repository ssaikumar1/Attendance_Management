<!-- app/Views/student_table.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Student Table</title>
</head>
<body>
    <form action="<?= base_url('StudentController/processStudents') ?>" method="post">
        <table border="1">
            <thead>
                <tr>
                    <th>Roll Number</th>
                    <th>Name</th>
                    <th>Sec</th>
                    <th>Sem</th>
                    <th>Checkbox</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student): ?>
                    <tr>
                        <td><?php echo $student->roll_number; ?></td>
                        <td><?php echo $student->name;?></td>
                        <td><?php echo $student->sec;?></td>
                        <td><?php echo $student->sem;?></td>
                        <td><input type="checkbox" name="students[]" value="<?php echo $student->roll_number;?>"></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
