<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Activity extends Model
{
    protected $fillable = [
        'title', 'description', 'activity_date', 'activity_time', 'remind_before',
    ];

    protected function casts(): array
    {
        return ['activity_date' => 'date'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function remindLabel(): string
    {
        return match (true) {
            $this->remind_before == 0    => 'on time',
            $this->remind_before >= 1440 => '1 day before',
            $this->remind_before >= 60   => ($this->remind_before / 60) . ' hr before',
            default                      => $this->remind_before . ' min before',
        };
    }
}