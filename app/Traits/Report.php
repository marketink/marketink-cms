<?php

namespace App\Traits;

use Carbon\Carbon;

trait Report
{
    public function monthlyCount($sub = 6, ?array $wheres = null)
    {
        $model = $this->model;
        if ($wheres) {
            foreach ($wheres as $where) {
                $model = $model->where($where[0], $where[1], $where[2]);
            }
        }

        return $model
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as total")
            ->where('created_at', '>=', Carbon::now()->subMonths($sub))
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get()
            ->map(function ($row) {
                $row->month = siteSetting()['dateFunction']($row->month . '-01')->format('F');//->format('Y/m');
                return $row;
            });
    }

    public function totalCount(?array $wheres = null)
    {
        $model = $this->model;
        if ($wheres) {
            foreach ($wheres as $where) {
                $model = $model->where($where[0], $where[1], $where[2]);
            }
        }
        return $model->count();
    }


}
