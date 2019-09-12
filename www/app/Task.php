<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_id',
        'user_id',
        'title',
        'points',
        'is_done'
    ];

    public function children()
    {
        return $this->hasMany('App\Task', 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->hasOne('App\Task', 'id', 'parent_id');
    }

    /**
     * Update Points recursively
     *
     * @param $parentId
     * @return bool
     */
    static public function updatePoints($parentId)
    {
        if (empty($parentId)) {
            return;
        }
        $points = Task::where('parent_id', $parentId)->sum('points');
        $task = Task::where('id', $parentId)->first();
        $task->points = $points;
        $task->save();

        if (!empty($task->parent_id)) {
            self::updatePoints($task->parent_id);
        } else {
            return true;
        }
    }

    /**
     * Update Points recursively
     *
     * @param $parentId
     * @return bool
     */
    static public function updateDone($taskId, $done = 0, $parentId = null)
    {
        if (empty($taskId)) {
            return;
        }

        if (!empty($done)) {
            Task::where('parent_id', $taskId)->update([
                'is_done' => $done
            ]);
            $tasks = Task::where('parent_id', $taskId)->get()->toArray();
            foreach ($tasks as $task) {
                self::updateDone($task['id'], $done, $parentId);
            }
        } else {
            if (!empty($parentId)) {
                Task::where('id', $parentId)->update([
                    'is_done' => $done
                ]);
                $task = Task::where('id', $parentId)->first();
                $task->is_done = $done;
                $task->save();
                self::updateDone($taskId, $done, $task->parent_id);
            }

        }


    }
}
