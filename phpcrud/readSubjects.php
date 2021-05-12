<?php
include 'functions.php';

$pdo = pdo_connect_mysql();

$stmt = $pdo->prepare('SELECT * FROM subjects ORDER BY id');
$stmt->execute();
$subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>


<?=template_header('Read Subjects')?>


<div class="content read-info">
    <h2>специалност “СЧЕТОВОДСТВО И КОНТРОЛ”</h2>
    <table>
        <thead>
        <tr>
            <td>SUBJECTS</td>
            <td></td>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($subjects as $subject): ?>
            <tr>
                <td><?=$subject['subject']?></td>
                <td class="actions">
                    <a href="readThemes.php?id=<?=$subject['id']?>" class="info"><i class="fas fa-book"></i></a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>


<?=template_footer()?>