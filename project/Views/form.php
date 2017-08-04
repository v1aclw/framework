<?php
/**
 * Created by PhpStorm.
 * User: V1acl
 * Date: 03.08.17
 * Time: 0:36
 *
 * @var \App\View $this
 * @var null|\Models\Task $task
 * @var \Models\User $user
 */

$this->layout(ROOTPATH . '/project/Views/layout.php');
?>

<form class="form-horizontal" id="form" role="form" action="<?php if ($task): ?>/edit/<?php echo $task->id; ?><?php else: ?>/add/<?php endif; ?>" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="userName" class="col-sm-2 control-label">Имя пользователя</label>
        <div class="col-sm-10">
            <input value="<?php echo $task ? htmlspecialchars($task->user_name) : ''; ?>" type="text" class="form-control" name="userName" id="userName" placeholder="Имя пользователя" required>
        </div>
    </div>
    <div class="form-group">
        <label for="email" class="col-sm-2 control-label">Email</label>
        <div class="col-sm-10">
            <input value="<?php echo $task ? htmlspecialchars($task->email) : ''; ?>" type="email" class="form-control" name="email" id="email" placeholder="Email" required>
        </div>
    </div>
    <div class="form-group">
        <label for="description" class="col-sm-2 control-label">Текст задачи</label>
        <div class="col-sm-10">
            <textarea id="description" name="description" class="form-control" rows="3" required><?php echo $task ? htmlspecialchars($task->description) : ''; ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <label for="image" class="col-sm-2 control-label">Изображение</label>
        <div class="col-sm-10">
            <?php if ($task && $task->hasImage()): ?>
                <img src="<?php echo $task->getImageUrl(); ?>" class="img-responsive">
            <?php endif; ?>
            <br>
            <input type="file" id="image" name="image">
        </div>
    </div>
    <?php if ($user->id): ?>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">
                    <label>
                        <input name="status" value="<?php echo \Models\Task::STATUS_SUCCESS; ?>" type="checkbox" <?php if ($task && (int)$task->status === \Models\Task::STATUS_SUCCESS): ?>checked="checked"<?php endif; ?>> Выполнено
                    </label>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">
                <?php if ($task): ?>
                    Сохранить
                <?php else: ?>
                    Создать
                <?php endif; ?>
            </button>
            <button type="button" id="preview" class="btn btn-default">Предварительный просмотр</button>
        </div>
    </div>
</form>

<div id="previewWrap" class="col-md-4"></div>

<script type="text/javascript">
    $(function () {
        var id = <?php echo $task ? $task->id : 0; ?>;

        $(document).on('click', '#preview', function () {
            $.ajax({
                url     : "/preview" + (id ? '/' + id : ''),
                method  : 'post',
                data    : new FormData($("#form")[0]),
                mimeType:"multipart/form-data",
                contentType: false,
                cache: false,
                processData:false,
                success : function (response) {
                    $("#previewWrap").html(response);
                }
            });
            return false;
        });

    });
</script>

<div class="clearfix"></div>

