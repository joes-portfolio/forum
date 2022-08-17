<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphMany;

trait RecordsActivity
{
    protected static function bootRecordsActivity(): void
    {
        if (! auth()->check()) {
            return;
        }

        foreach (self::getRecordActivityForEvents() as $event) {
            static::$event(fn (self $model) => $model->recordActivity($event));
        }
    }

    protected static function getRecordActivityForEvents(): array
    {
        return ['created'];
    }

    public function activity(): MorphMany
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    protected function recordActivity(string $event): void
    {
        $this->activity()->create([
            'user_id' => auth()->id(),
            'type' => $this->getActivityType($event),
        ]);
    }

    protected function getActivityType(string $event): string
    {
        $type = str(class_basename($this))->lower();

        return "{$event}_{$type}";
    }
}
