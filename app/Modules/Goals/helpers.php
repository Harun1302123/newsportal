<?php

use App\Modules\Goals\Models\Goal;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Modules\Targets\Models\Target;
use App\Modules\ManualDataEntry\Models\MefBenchmarkRecord;
use App\Modules\ManualDataEntry\Models\MefGoalMaximumScoreRecord;

function goals()
{
    return Cache::rememberForever('goals', function()
    {
        return Goal::query()->with('targets')->whereStatus(1)->get();
    });
}

function totalTargetWithoutGoal12()
{
    return Cache::rememberForever('totalTargetWithoutGoal12', function()
    {
        return Target::query()->whereNot('goal_id', 12)->whereStatus(1)->count();
    });
}

function implementationStatus()
{
    return [
        'NI' => 'Not Implemented', // score = 0
        'PI' => 'Partially Implemented', // score = 0.5
        'FI' => 'Fully Implemented', // score = 1
    ];
}

function implementationStatusInfo($status)
{
    if ($status == 'FI') {
        return 'Fully Implemented';
    } elseif ($status == 'PI') {
        return 'Partially Implemented';
    }else{
        return 'Not Implemented';
    }
}

function goal12Status()
{
    return [
        'yes' => 'Yes', // score = 1
        'no' => 'No', // score = -1
    ];
}

function goal12StatusInfo($status)
{
    if ($status == 'yes') {
        return 'Yes';
    }else{
        return 'No';
    }
}

function collectionWiseCountTarget($collectionDetails, $conditionColumn, $except_id)
{
    return $collectionDetails->where("$conditionColumn", "!=", $except_id)->count();
}

function collectionWiseSumScore($collectionDetails, $conditionColumn, $except_id, $operator="!=")
{
    return $collectionDetails->where("$conditionColumn", "$operator", $except_id)->sum('score');
}

function getBenchmarkData( $year, $quarter_id, $column = null )
{
    if (!$quarter_id || !$year) {
        return null;
    }
    $item = MefBenchmarkRecord::query()
        ->whereJsonContains('quarter_ids', $quarter_id)
        ->where('year', $year)
        ->where('mef_process_status_id', 1) // submitted
        ->first();
    
    // log data
    Log::error(json_encode($item));
    Log::error(" $year, $quarter_id, $column ");
    
    if (!$item) {
        return null;
    }
    if ($column) {
        if ($column == 'indicator_set_a') {
            return $item->indicator_set_a;
        } else if ($column == 'without_goal_12') {
            return $item->without_goal_12;
        } else if ($column == 'goal_12') {
            return $item->goal_12;
        }else{
            return null;
        }
    }else{
        return $item;
    }

}

function getMaximumScoreData( $year, $quarter_id, $column = null )
{
    if (!$quarter_id || !$year) {
        return null;
    }
    $item = MefGoalMaximumScoreRecord::query()
        ->where('mef_quarter_id', $quarter_id)
        ->where('year', $year)
        ->where('mef_process_status_id', 1) // submitted
        ->first();
    if (!$item) {
        return null;
    }
    if ($column) {
        if ($column == 'without_goal_12') {
            return $item->without_goal_12;
        } else if ($column == 'goal_12') {
            return $item->goal_12;
        }else{
            return null;
        }
    }else{
        return $item;
    }

}
