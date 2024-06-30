<!-- app/Views/student_table.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Student Table</title>
</head>
<body>
    <form action="<?= base_url('StudentController/processStudents2') ?>" method="post">
        <table border="1">
            <thead>
                <tr>
                    <th>Roll Number</th>
                    <th>Name</th>
                    <th>Checkbox</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student): ?>
                    <tr>
                        <td><?php echo $student->roll_number; ?></td>
                        <td><?php echo $student->name;?></td>
                        <td><input type="checkbox" name="students[]" value="<?php echo $student->roll_number;?>"
                        <?php if(in_array($student->roll_number,$checked_students)){ echo 'checked'; } ?>
                        ></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
