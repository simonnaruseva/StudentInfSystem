<?php
include 'functions.php';

$pdo = pdo_connect_mysql();
$msg = '';

if (isset($_GET['id'])) {
    $stmt = $pdo->prepare('SELECT * FROM students WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$student) {
        exit('Student doesn\'t exist with that ID!');
    }

    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            $stmt = $pdo->prepare('DELETE FROM students WHERE id = ?');
            $stmt->execute([$_GET['id']]);
            $msg = 'You have deleted the student!';
        } else {
            header('Location: readStudents.php');
            exit;
        }
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Delete')?>

<div class="content delete">
    <h2>Delete Student #<?=$student['id']?></h2>
    <?php if ($msg): ?>
        <p><?=$msg?></p>
    <?php else: ?>
        <p>Are you sure you want to delete student #<?=$student['id']?>?</p>
        <div class="yesno">
            <a href="deleteStudent.php?id=<?=$student['id']?>&confirm=yes">Yes</a>
            <a href="deleteStudent.php?id=<?=$student['id']?>&confirm=no">No</a>
        </div>
    <?php endif; ?>
</div>

<?=template_footer()?>
