<?php
/**
 * Created by PhpStorm.
 * User: V1acl
 * Date: 03.08.17
 * Time: 2:59
 *
 * @var \Models\Task $task
 * @var bool $canEdit
 */
?>
<?php if ($task->hasImage()): ?>
    <img src="<?php echo $task->getImageUrl(); ?>" class="img-responsive">
<?php endif; ?>
<h2><?php echo htmlspecialchars($task->user_name); ?></h2>
<?php if ($canEdit): ?>
    <p><a class="btn btn-xs btn-default" href="/edit/<?php echo $task->id; ?>/" role="button">Редактировать</a></p>
<?php endif; ?>
<p><?php echo htmlspecialchars($task->description); ?></p>
<?php if ((int)$task->status === \Models\Task::STATUS_SUCCESS): ?>
    <span class="label label-success">Выполнена</span>
<?php else: ?>
    <span class="label label-default">Новая</span>
<?php endif; ?>
