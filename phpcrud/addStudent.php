<?php
include 'functions.php';

$pdo = pdo_connect_mysql();
$msg = '';

if (!empty($_POST)) {
    $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;

    $fnumber = isset($_POST['fnumber']) ? $_POST['fnumber'] : '';
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $lastName = isset($_POST['last_name']) ? $_POST['last_name'] : '';
    $course = isset($_POST['course']) ? $_POST['course'] : '';
    $studentGroup = isset($_POST['student_group']) ? $_POST['student_group'] : '';
    $address = isset($_POST['address']) ? $_POST['address'] : '';
    $phone = isset($_POST['phone_number']) ? $_POST['phone_number'] : '';

    $stmt = $pdo->prepare('INSERT INTO students VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$id,$fnumber, $name, $lastName, $course, $studentGroup, $address,$phone]);

    $msg = 'Created Successfully!';
    header("Location: readStudents.php");
}
?>

<?=template_header('Create')?>

<div class="content add">
	<h2>Add Student</h2>
    <form action="addStudent.php" method="post">
        <label for="id">ID</label>
        <label for="fnumber">Fac.Number</label>
        <input type="text" class="input-box" name="id"  placeholder="26" value="auto" id="id" readonly>
        <input type="text" name="fnumber" placeholder="17777" id="fnumber">
        <label for="name">Name</label>
        <label for="last_name">Last name</label>
        <input type="text" name="name" placeholder="John" id="name">
        <input type="text" name="last_name" placeholder="Doe" id="last_name">
        <label for="phone_number">Phone</label>
        <label for="address">Address</label>
        <input type="text" name="phone_number" placeholder="2025550143" id="phone_number">
        <input type="text" name="address" placeholder="Enter your address" id="address">
        <label for="course">Course</label>
        <label for="student_group">Student Group</label>
        <input type="text" name="course" id="course">
        <input type="text" name="student_group" id="student_group">

        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>
