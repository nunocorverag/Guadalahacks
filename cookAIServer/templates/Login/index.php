<?php
// Display error messages if any
if (!empty($error)) {
    echo '<div class="error-message">' . h($error) . '</div>';
}
?>

<form method="post" action="<?= $this->Url->build(['controller' => 'Login', 'action' => 'index']) ?>">
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
    </div>
    <button type="submit">Login</button>
</form>