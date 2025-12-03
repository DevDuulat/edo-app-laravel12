<?php

namespace App\Traits;

trait HasStatusLifecycle
{
    public function markArchived(): bool
    {
        return $this->update(['status' => 2]);
    }

    public function markActive(): bool
    {
        return $this->update(['status' => 1]);
    }

    public function markTrashed(): bool
    {
        return $this->update(['status' => 3]);
    }

    public function forceRemove(): bool
    {
        return $this->delete();
    }

    // Статические скопы
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeArchived($query)
    {
        return $query->where('status', 2);
    }

    public function scopeTrashedCustom($query)
    {
        return $query->where('status', 0);
    }
}
