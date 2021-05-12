<?php
include 'functions.php';

$pdo = pdo_connect_mysql();
$msg = '';

if (isset($_GET['id'])) {
    $stmt = $pdo->prepare('
    SELECT
        a.answer,
        t.question,
        s.subject,
        a.exam_date,
        g.grade,
        a.student_id
    FROM
        student_answers AS a 
    INNER JOIN test_questions t ON a.test_question_id = t.id
    INNER JOIN subjects s ON a.subject_id = s.id
    LEFT JOIN grades g ON g.student_answer_id = a.id
    WHERE student_id = ?
    GROUP BY 
        a.answer,
        t.question,
        g.grade ');

    $stmt->execute([$_GET['id']]);
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$students) {
        exit('Student doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>

<?= template_header('Read') ?>
<div class="content read">
    <h2>Student Info</h2>
    <table>
        <thead>
        <tr>
            <td>Student answer</td>
            <td>Theme</td>
            <td>Subject</td>
            <td>Exam Date</td>
            <td>Grade</td>
            <td></td>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($students as $student): ?>
            <tr>
                <td><?= $student['answer'] ?></td>
                <td><?= $student['question'] ?></td>
                <td><?= $student['subject'] ?></td>
                <td><?= $student['exam_date'] ?></td>
                <td><?= $student['grade'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        <?php if ($msg): ?>
            <p><?= $msg ?></p>
        <?php endif; ?>

        <?= template_footer() ?>
