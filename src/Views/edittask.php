<?php use App\Models\Task;

require_once __DIR__.'/header.php'; ?>

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


<div class="container">
    <div class="box">
        <form method="post">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="state" id="exampleRadios1"
                       value="0" <?= $task->getState() == Task::STATE_INCOMPLETE ? 'checked' : ''; ?>>
                <label class="form-check-label" for="exampleRadios1">
                    Не выполнено
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="state" id="exampleRadios2"
                       value="1" <?= $task->getState() == Task::STATE_COMPLETE ? 'checked' : ''; ?>>
                <label class="form-check-label" for="exampleRadios2">
                    Выполнено
                </label>
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Имя пользователя</span>
                </div>
                <input type="text" class="form-control" placeholder="Имя пользователя" aria-label="Имя пользователя"
                       aria-describedby="basic-addon1" name="username"
                       value="<?= htmlspecialchars($task->getUsername()); ?>" required>
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">E-mail пользователя</span>
                </div>
                <input type="email" class="form-control" placeholder="E-mail пользователя"
                       aria-label="E-mail пользователя" aria-describedby="basic-addon1" name="email"
                       value="<?= htmlspecialchars($task->getEmail()); ?>" required>
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Текст задачи</span>
                </div>
                <input type="text" class="form-control" placeholder="Текст задачи" aria-label="Текст задачи"
                       aria-describedby="basic-addon1" name="text" value="<?= htmlspecialchars($task->getText()); ?>"
                       required>
            </div>

            <input type="submit" value="Сохранить" class="btn btn-primary">
        </form>
    </div>
</div>

<?php require_once __DIR__.'/footer.php'; ?>
