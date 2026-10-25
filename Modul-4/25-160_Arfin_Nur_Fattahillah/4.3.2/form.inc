<form action="processData_form.php" method="POST">

    <label>Surname:</label><br>
    <input
        type="text"
        name="surname"
        value="<?php echo htmlspecialchars($_POST['surname'] ?? ''); ?>"
    >
    <br><br>

    <label>Email address:</label><br>
    <input
        type="text"
        name="email"
        value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
    >
    <br><br>

    <label>Password:</label><br>
    <input type="password" name="password">
    <br><br>

    <input type="submit" value="Submit">
    <input type="reset" value="Reset">

</form>