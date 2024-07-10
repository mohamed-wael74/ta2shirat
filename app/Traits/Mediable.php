<?php

namespace App\Traits;

use App\Models\Media;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait Mediable
{
    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function medium(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediable');
    }

    public function getMainMediumAttribute()
    {
        return $this->media()->isMain()->first();
    }

    public function getFirstMediumAttribute()
    {
        return $this->media()->where('order', 1)->first();
    }

    public function uploadMedium(UploadedFile $medium, string $path): string
    {
        return $medium->store($path);
    }

    function deleteMedium(Media $medium): bool
    {
        if (! Storage::exists($medium->path)) {
            return false;
        }
        Storage::delete($medium->path);
        $medium->delete();

        return true;
    }

    public function deleteMedia(Collection $media): void
    {
        $media->each(function (Media $medium) {
            $this->deleteMedium($medium);
        });
    }

    public function deleteAllMedia(): void
    {
        $this->deleteMedia($this->media()->get());
    }

    public function updateMedium(UploadedFile $medium, Media $oldMedium, string $path): string
    {
        $this->deleteMedium($oldMedium);

        return $this->uploadMedium($medium, $path);
    }
}
