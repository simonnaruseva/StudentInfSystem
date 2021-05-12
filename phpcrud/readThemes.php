<?php
include 'functions.php';

$pdo = pdo_connect_mysql();
$msg = '';

if (isset($_GET['id'])) {
    $stmt = $pdo->prepare('
        SELECT
            t.question,
            s.subject
        FROM
            test_questions AS t 
        INNER JOIN subjects s ON t.subject_id = s.id
        WHERE subject_id = ?
        GROUP BY
            t.question,
            s.subject ');

    $stmt->execute([$_GET['id']]);
    $themes = $stmt->fetchAll(PDO::FETCH_ASSOC);


    $statement = $pdo->prepare('
        SELECT
            s.subject
        FROM
            test_questions AS t 
        INNER JOIN subjects s ON t.subject_id = s.id
        WHERE subject_id = ?
        GROUP BY
            s.subject ');

    $statement->execute([$_GET['id']]);
    $subject = $statement->fetch(PDO::FETCH_ASSOC);
    if (!$themes) {
        exit('Themes doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Read Themes')?>
<div class="content check">
    <h2><?=$subject['subject']?></h2>
    <table>
        <thead>
        <tr>
            <td>THEMES</td>
            <td></td>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($themes as $theme): ?>
        <tr>
            <td><?=$theme['question']?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
        <?php if ($msg): ?>
            <p><?=$msg?></p>
        <?php endif; ?>

        <?=template_footer()?>

