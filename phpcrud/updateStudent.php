<?php
include 'functions.php';

$pdo = pdo_connect_mysql();
$msg = '';

if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;

        $fnumber = isset($_POST['fnumber']) ? $_POST['fnumber'] : '';
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $lastName = isset($_POST['last_name']) ? $_POST['last_name'] : '';
        $course = isset($_POST['course']) ? $_POST['course'] : '';
        $studentGroup = isset($_POST['student_group']) ? $_POST['student_group'] : '';
        $address = isset($_POST['address']) ? $_POST['address'] : '';
        $phone = isset($_POST['phone_number']) ? $_POST['phone_number'] : '';

        $stmt = $pdo->prepare('UPDATE students SET id = ?, fnumber = ?, name = ?, last_name = ?, course = ?, student_group = ?, address = ?, phone_number = ? WHERE id = ?');
        $stmt->execute([$id,$fnumber, $name, $lastName, $course, $studentGroup, $address,$phone, $_GET['id']]);

        $msg = 'Updated Successfully!';
        header("Location: readStudents.php");
    }

    $stmt = $pdo->prepare('SELECT * FROM students WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$student) {
        exit('Student doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Update Student')?>

<div class="content update">
<h2>Update Student #<?=$student['id']?></h2>
<form action="updateStudent.php?id=<?=$student['id']?>" method="post">
    <label for="id">ID</label>
    <label for="fnumber">Fac.Number</label>
    <input type="text" class="input-box" name="id" placeholder="1" value="<?=$student['id']?>" id="id" readonly>
    <input type="text" name="fnumber" placeholder="17777" value="<?=$student['fnumber'] ?>" id="fnumber">
    <label for="name">Name</label>
    <label for="last_name">Last name</label>
    <input type="text" name="name" placeholder="John" value="<?=$student['name']?>" id="name">
    <input type="text" name="last_name" placeholder="Doe" value="<?=$student['last_name']?>" id="last_name">
    <label for="phone_number">Phone</label>
    <label for="address">Address</label>
    <input type="text" name="phone_number" placeholder="2025550143" value="<?=$student['phone_number']?>" id="phone_number">
    <input type="text" name="address" placeholder="Enter your address" value="<?=$student['address']?>" id="address">
    <label for="course">Course</label>
    <label for="student_group">Student Group</label>
    <input type="text" name="course" value="<?=$student['course']?>" id="course">
    <input type="text" name="student_group" value="<?=$student['student_group']?>" id="student_group">
    <input type="submit" value="Update">
</form>
<?php if ($msg): ?>
    <p><?=$msg?></p>
<?php endif; ?>
</div>

<?=template_footer()?>

