<?php

namespace App\Helpers;

use App\Task;

class TaskHelper
{
    /**
     * Show the task list
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    static public function taskList($tasks)
    {
        $str = '';
        if (count($tasks) > 0) {
            $str .= '<ul>';
            foreach ($tasks as $task):
                $str .= "<li>{$task['title']} ({$task['points']})</li>";
                $childTasks = Task::where('parent_id', $task['id'])->get()->all();
                if (count($childTasks) > 0) {
                    $str .= self::taskList($childTasks);
                }
            endforeach;
            $str .= '</ul>';
        }
        return $str;
    }
}
