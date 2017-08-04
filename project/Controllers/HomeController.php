<?php
/**
 * Created by PhpStorm.
 * User: V1acl
 * Date: 02.08.17
 * Time: 18:00
 */

namespace Controllers;

use App\Controller;
use App\Request;
use App\Request\TempFile;
use App\Router\RouteNotFoundException;
use App\View;
use Helpers\Image;
use Helpers\Pagination;
use Models\Task;
use Models\User;

/**
 * Class HomeController
 *
 * @package Controllers
 */
class HomeController extends Controller
{

    /**
     * HomeController constructor.
     */
    public function __construct() {
        View::share('user', User::current());
    }

    /**
     * Home
     *
     * @param Request $request
     * @param int $page
     * @param string|null $sorting
     * @return string
     */
    public function getIndex(Request $request, int $page = 1, string $sorting = null) {
        $page = $page < 1 ? 1 : $page;
        $order = $direction = $sort = '';
        if ($sorting) {
            list($order, $direction) = explode('-', $sorting);
            $direction = $direction === 'asc' ? 'asc' : 'desc';
            if (in_array($order, Task::getFields('tasks'), true)) {
                $sort = 'order by ' . $order . ' ' . $direction;
            }
        }
        $limit = 3;
        $tasks = Task::query('select SQL_CALC_FOUND_ROWS * from tasks ' . $sort . ' limit ? , ?', [($page - 1) * $limit, $limit]);
        $rows = Task::getFoundRows();
        $parsedUrl = parse_url($request->url());
        $query = array_key_exists('query', $parsedUrl) ? $parsedUrl['query'] : '';
        return (new View())->render(ROOTPATH . '/project/Views/home.php', [
            'title'       => 'Список задач',
            'description' => 'Стартовая страница - список задач с возможностью сортировки по имени пользователя, email и статусу. Вывод задач нужно сделать страницами по 3 штуки (с пагинацией). Видеть список задач и создавать новые может любой посетитель без регистрации. ',
            'tasks'       => $tasks,
            'pagination'  => Pagination::create($page, $limit, $rows),
            'order'       => $order,
            'direction'   => $direction,
            'query'       => $query !== '' ? '?' . $query : '',
            'canEdit'     => User::current()->id ? true : false,
        ]);
    }

    /**
     * Add task page
     *
     * @return string
     */
    public function getAdd() {
        return (new View())->render(ROOTPATH . '/project/Views/form.php', [
            'title' => 'Добавление задачи',
        ]);
    }

    /**
     * Add task processing
     *
     * @param string $userName
     * @param string $email
     * @param string $description
     * @param TempFile|null $image
     * @param int $status
     * @return \App\Response
     */
    public function postAdd(string $userName, string $email, string $description, TempFile $image = null, int $status = 0) {
        if ($image && !in_array($image->getType(), ['image/jpeg', 'image/gif', 'image/png'], true)) {
            $image = null;
        }
        $task = new Task([
            'image'       => $image ? $image->getName() : '',
            'user_name'   => $userName,
            'email'       => $email,
            'description' => $description,
            'status'      => User::isAuth() ? $status : Task::STATUS_NEW,
        ]);
        $task->save();
        if ($image) {
            $image->move($task->getImagePath());
            Image::resize($task->getImagePath(), Task::IMAGE_MAX_WIDTH, Task::IMAGE_MAX_HEIGHT);
        }
        return $this->redirect('/');
    }

    /**
     * Preview task html
     *
     * @param string $userName
     * @param string $email
     * @param string $description
     * @param TempFile|null $image
     * @param int $id
     * @param int $status
     * @return string
     */
    public function postPreview(string $userName, string $email, string $description, TempFile $image = null, int $id = null, int $status = Task::STATUS_NEW) {
        $path = '';
        $task = null;
        if ($image && !in_array($image->getType(), ['image/jpeg', 'image/gif', 'image/png'], true)) {
            $image = null;
        }
        if ($image) {
            $path = ROOTPATH . '/public/temp/' . basename($image->getPath());
            $image->move($path);
            Image::resize($path, Task::IMAGE_MAX_WIDTH, Task::IMAGE_MAX_HEIGHT);
        } elseif ($id) {
            $task = Task::getByPrimaryKey($id);
        }
        return (new View())->render(ROOTPATH . '/project/Views/parts/task.php', [
            'task' => new Task([
                'id'          => $id,
                'image'       => $image ? $image->getName() : ($task ? $task->image : ''),
                'user_name'   => $userName,
                'email'       => $email,
                'description' => $description,
                'temp_image'  => $path,
                'status'      => User::isAuth() ? $status : Task::STATUS_NEW,
            ]),
        ]);
    }

    /**
     * Edit task page
     *
     * @param int $id
     * @return string
     * @throws RouteNotFoundException
     */
    public function getEdit(int $id) {
        if (!User::isAuth()) {
            throw new RouteNotFoundException();
        }
        $task = Task::getByPrimaryKey($id);
        if (!$task) {
            throw new RouteNotFoundException();
        }
        return (new View())->render(ROOTPATH . '/project/Views/form.php', [
            'title' => 'Редактирование задачи',
            'task'  => $task,
        ]);
    }

    /**
     * Edit task processing
     *
     * @param int $id
     * @param string $userName
     * @param string $email
     * @param string $description
     * @param TempFile|null $image
     * @param int $status
     * @return \App\Response
     * @throws RouteNotFoundException
     */
    public function postEdit(int $id, string $userName, string $email, string $description, TempFile $image = null, int $status = 0) {
        if (!User::isAuth()) {
            throw new RouteNotFoundException();
        }
        $task = Task::getByPrimaryKey($id);
        if (!$task) {
            throw new RouteNotFoundException();
        }
        if ($image && !in_array($image->getType(), ['image/jpeg', 'image/gif', 'image/png'], true)) {
            $image = null;
        }
        if ($image) {
            $task->image = $image->getName();
        }
        $task->user_name = $userName;
        $task->email = $email;
        $task->description = $description;
        $task->status = $status;
        $task->save();
        if ($image) {
            $image->move($task->getImagePath());
            Image::resize($task->getImagePath(), Task::IMAGE_MAX_WIDTH, Task::IMAGE_MAX_HEIGHT);
        }
        return $this->redirect('/');
    }

}