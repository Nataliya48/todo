<?php require_once __DIR__.'/header.php'; ?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="/tasks">На главную</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
</nav>
<hr>
<?php if (isset($message)): ?>
    <div class="alert alert-primary" role="alert">
        <?= $message; ?>
    </div>
<?php endif; ?>
<form method="post">
    <div class="input-group flex-nowrap">
        <div class="input-group-prepend">
            <span class="input-group-text" id="addon-wrapping">Имя пользователя</span>
        </div>
        <input type="text" class="form-control" placeholder="Имя пользователя" aria-label="Имя пользователя"
               aria-describedby="addon-wrapping" name="login" required>
    </div>
    <br>
    <div class="input-group flex-nowrap">
        <div class="input-group-prepend">
            <span class="input-group-text" id="addon-wrapping">Пароль</span>
        </div>
        <input type="password" class="form-control" placeholder="Пароль" aria-label="Пароль"
               aria-describedby="addon-wrapping" name="password" required>
    </div>
    <br>
    <input type="submit" value="Войти" class="btn btn-primary">
</form>

<?php require_once __DIR__.'/footer.php'; ?>
