<?php

namespace App\Services\TickTick;

use GuzzleHttp\Cookie\CookieJar;
use Zttp\Zttp;

class TaskApi
{
    protected function getAuthCookies() : CookieJar
    {
        return Zttp::post('https://api.ticktick.com/api/v2/user/signon?wc=true&remember=true', config('services.ticktick'))->cookies();
    }

    public function all() : array
    {

        $response = Zttp::withCookies($this->getAuthCookies())->get('https://api.ticktick.com/api/v2/batch/check/0')->json();

        return collect($response['syncTaskBean']['update'])->map(function ($task) use($response) {
            return [
                'title' => $task['title'],
                'project' => $this->getProjectName($task['projectId'], $response),
                'dueDate' => $task['dueDate'] ?? null,
            ];
        })->toArray();
    }

    protected function getProjectName(string $id, array $response) : ?string
    {
        return optional(collect($response['projectProfiles'])->first(function($project) use($id) {
            return $id === $project['id'];
        }))['name'];
    }
}
