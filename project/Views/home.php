<?php
/**
 * Created by PhpStorm.
 * User: V1acl
 * Date: 02.08.17
 * Time: 21:39
 *
 * @var \App\View $this
 * @var \App\DB\Collection|\Models\Task[] $tasks
 * @var bool $canEdit
 * @var \Helpers\Pagination $pagination
 * @var string $query
 * @var string $order
 * @var string $direction
 */
$this->layout(ROOTPATH . '/project/Views/layout.php');
?>

<!-- Example row of columns -->
<div class="row">
    <nav class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand">Сортировка</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="/<?php echo $pagination->getPage(); ?>?sorting=user_name-<?php if ($order === 'user_name' && $direction === 'desc'): ?>asc<?php else: ?>desc<?php endif; ?>">
                            Имя пользователя
                            <?php if ($order === 'user_name' && $direction === 'asc'): ?>
                                &downarrow;
                            <?php elseif ($order === 'user_name' && $direction === 'desc'): ?>
                                &uparrow;
                            <?php endif; ?>
                        </a>
                    </li>
                    <li>
                        <a href="/<?php echo $pagination->getPage(); ?>?sorting=email-<?php if ($order === 'email' && $direction === 'desc'): ?>asc<?php else: ?>desc<?php endif; ?>">
                            Email
                            <?php if ($order === 'email' && $direction === 'asc'): ?>
                                &downarrow;
                            <?php elseif ($order === 'email' && $direction === 'desc'): ?>
                                &uparrow;
                            <?php endif; ?>
                        </a>
                    </li>
                    <li>
                        <a href="/<?php echo $pagination->getPage(); ?>?sorting=status-<?php if ($order === 'status' && $direction === 'desc'): ?>asc<?php else: ?>desc<?php endif; ?>">
                            Статус
                            <?php if ($order === 'status' && $direction === 'asc'): ?>
                                &downarrow;
                            <?php elseif ($order === 'status' && $direction === 'desc'): ?>
                                &uparrow;
                            <?php endif; ?>
                        </a>
                    </li>
                </ul>
                <div class="navbar-right">
                    <a href="/add/" type="button" class="btn btn-default navbar-btn">Создать задачу</a>
                </div>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>

    <?php foreach ($tasks as $task): ?>
        <div class="col-md-4">
            <?php echo $this->render(ROOTPATH . '/project/Views/parts/task.php', compact('task', 'canEdit')); ?>
        </div>
    <?php endforeach; ?>

    <div class="clearfix"></div>

    <?php if ($pagination->count() > 1): ?>
        <ul class="pagination">
            <li class="<?php if (!$pagination->getPrev() || $pagination->getPrev()->isDisabled()): ?>disabled<?php endif; ?>">
                <a <?php if ($pagination->getPrev() && !$pagination->getPrev()->isDisabled()): ?>href="/<?php echo $pagination->getPrev()->getNum(); ?>/<?php echo $query; ?>"<?php endif; ?>>&laquo;</a>
            </li>
            <?php foreach ($pagination as $item): ?>
                <li class="<?php if ($item->isActive()): ?>active<?php endif; ?> <?php if ($item->isDisabled()): ?>disabled<?php endif; ?>">
                    <?php if ($item->isDisabled()): ?>
                        <a>...</a>
                    <?php else: ?>
                        <a <?php if (!$item->isActive()): ?>href="/<?php echo $item->getNum(); ?>/<?php echo $query; ?>"<?php endif; ?>>
                            <?php echo $item->getNum(); ?>
                        </a>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
            <li class="<?php if (!$pagination->getNext() || $pagination->getNext()->isDisabled()): ?>disabled<?php endif; ?>">
                <a <?php if ($pagination->getNext() && !$pagination->getNext()->isDisabled()): ?>href="/<?php echo $pagination->getNext()->getNum(); ?>/<?php echo $query; ?>"<?php endif; ?>>&raquo;</a>
            </li>
        </ul>
    <?php endif; ?>
</div>
