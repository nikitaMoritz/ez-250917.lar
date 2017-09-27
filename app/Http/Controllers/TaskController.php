<?php

namespace App\Http\Controllers;
use App\Repositories\TaskRepository;
use Illuminate\Http\Request;
use App\Http\Requests;

class TaskController extends Controller {
    protected $tasks;

    /**
     * Создание нового экземпляра контроллера.
     *
     * @return void
     */
    public function __construct(TaskRepository $tasks) {
        $this->middleware('auth');
        $this->tasks=$tasks;
    }

    /**
     * Отображение списка всех задач пользователя.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request) {
        $tasks = $request->user()->tasks()->get();
        return view('tasks.index',[
            'tasks'=>$tasks,
            ]);
    }

    /**
     * Создание новой задачи.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);

        $request->user()->tasks()->create([
            'name' => $request->name,
        ]);

        return redirect('/tasks');
    }

}
