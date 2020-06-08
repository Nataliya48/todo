<?php use App\Models\Task;

require_once __DIR__.'/header.php'; ?>


<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <?= $orderBy == null ? '<b>' : ''; ?>
    <a class="navbar-brand" href="/tasks">Список задач</a>
    <?= $orderBy == null ? '</b>' : ''; ?>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="/tasks/create">Создать новую задачу</a>
            </li>
            <li class="nav-item">
                <?php if ($this->authService->isLoggedIn()): ?>
                    <a class="nav-link" href="/admin/logout">Выйти</a>
                <?php else: ?>
                    <a class="nav-link" href="/admin/login">Авторизоваться</a>
                <?php endif; ?>
            </li>
        </ul>
    </div>
</nav>
<nav class="nav flex-column">
    <?= ($orderBy == 'username' && $direction == 'asc') ? '<b>' : ''; ?>
    <a class="nav-link active" href="/tasks?sorting=username&direction=asc">
        Сортировать по пользователям по возрастанию
    </a>
    <?= ($orderBy == 'username' && $direction == 'asc') ? '</b>' : ''; ?>

    <?= ($orderBy == 'username' && $direction == 'desc') ? '<b>' : ''; ?>
    <a class="nav-link active" href="/tasks?sorting=username&direction=desc">
        Сортировать по пользователям по убыванию
    </a>
    <?= ($orderBy == 'username' && $direction == 'desc') ? '</b>' : ''; ?>

    <?= ($orderBy == 'email' && $direction == 'asc') ? '<b>' : ''; ?>
    <a class="nav-link active" href="/tasks?sorting=email&direction=asc">
        Сортировать по email по возрастанию
    </a>
    <?= ($orderBy == 'email' && $direction == 'asc') ? '</b>' : ''; ?>

    <?= ($orderBy == 'email' && $direction == 'desc') ? '<b>' : ''; ?>
    <a class="nav-link active" href="/tasks?sorting=email&direction=desc">
        Сортировать по email по убыванию
    </a>
    <?= ($orderBy == 'email' && $direction == 'desc') ? '</b>' : ''; ?>

    <?= ($orderBy == 'state' && $direction == 'asc') ? '<b>' : ''; ?>
    <a class="nav-link active" href="/tasks?sorting=state&direction=asc">
        Сортировать по статусу по возрастанию
    </a>
    <?= ($orderBy == 'state' && $direction == 'asc') ? '</b>' : ''; ?>

    <?= ($orderBy == 'state' && $direction == 'desc') ? '<b>' : ''; ?>
    <a class="nav-link active" href="/tasks?sorting=state&direction=desc">
        Сортировать по статусу по убыванию
    </a>
    <?= ($orderBy == 'state' && $direction == 'desc') ? '</b>' : ''; ?>
</nav>

<?php foreach ($tasks as $task): ?>
    <div class="card">

        <div class="card-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    Статус:
                    <b><?= $task->getState() == Task::STATE_COMPLETE ? 'Выполнено' : 'Не выполнено'; ?></b>
                </li>
                <li class="list-group-item">
                    Имя пользователя:
                    <b><?= htmlspecialchars($task->getUsername()); ?></b>
                </li>
                <li class="list-group-item">
                    E-mail пользователя:
                    <b><?= htmlspecialchars($task->getEmail()); ?></b>
                </li>
                <li class="list-group-item">
                    Текст задачи:
                    <b><?= htmlspecialchars($task->getText()); ?></b>
                </li>
                <li class="list-group-item">
                    <b><?= $task->getEdited() == true ? 'Отредактировано администратором' : ''; ?></b>
                </li>
                <?php if ($this->authService->isLoggedIn()): ?>
                    <a href="/tasks/edit/<?= $task->getId(); ?>" class="btn btn-info">
                        Редактировать
                    </a>
                <?php endif; ?>
            </ul>
        </div>
    </div>
    <br>
<?php endforeach; ?>

<nav>
    <ul class="pagination">
        <?php foreach ($links as $key => $link): ?>
            <li class="page-item <?= $link['current'] ? 'active' : ''; ?>">
                <a class="page-link" href="<?= $link['url']; ?>">
                    <?= $key + 1; ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>

<?php require_once __DIR__.'/footer.php'; ?>
