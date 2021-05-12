<?php
include 'functions.php';

$pdo = pdo_connect_mysql();

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$records_per_page = 5;

$stmt = $pdo->prepare('SELECT * FROM students ORDER BY id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

$num_students = $pdo->query('SELECT COUNT(*) FROM students')->fetchColumn();
?>

<?=template_header('Read')?>

<div class="content read">
    <h2>Students</h2>
    <a href="addStudent.php" class="create-contact">Add Student</a>
    <table>
        <thead>
        <tr>
            <td>#</td>
            <td>FNumber</td>
            <td>Name</td>
            <td>Last Name</td>
            <td>Phone</td>
            <td>Course</td>
            <td>Student group</td>
            <td>Address</td>
            <td></td>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($students as $student): ?>
            <tr>
                <td><?=$student['id']?></td>
                <td><?=$student['fnumber']?></td>
                <td><?=$student['name']?></td>
                <td><?=$student['last_name']?></td>
                <td><?=$student['phone_number']?></td>
                <td><?=$student['course']?></td>
                <td><?=$student['student_group']?></td>
                <td><?=$student['address']?></td>
                <td class="actions">
                    <a href="updateStudent.php?id=<?=$student['id']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="deleteStudent.php?id=<?=$student['id']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                    <a href="studentInfo.php?id=<?=$student['id']?>" class="info"><i class="fas fa-info-circle fa-xs"></i></a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="readStudents.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
        <?php endif; ?>
        <?php if ($page*$records_per_page < $num_students): ?>
            <a href="readStudents.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
        <?php endif; ?>
    </div>
</div>

<?=template_footer()?>
