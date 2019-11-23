<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LdapScan extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'started_at',
        'completed_at',
        'success',
        'message',
        'synchronized',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'started_at',
        'completed_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['success' => 'boolean'];

    /**
     * Get the last unprocessed scan.
     *
     * @return static|null
     */
    public static function lastUnprocessed()
    {
        return static::oldest()->whereHas('entries', function ($query) {
            $query->whereProcessed(false);
        })->first();
    }

    /**
     * The belongsTo domain relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function domain()
    {
        return $this->belongsTo(LdapDomain::class, 'domain_id');
    }

    /**
     * The hasMany entries relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function entries()
    {
        return $this->hasMany(LdapScanEntry::class, 'scan_id');
    }

    /**
     * Begin querying root scan entries.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function rootEntries()
    {
        return $this->entries()->roots();
    }

    /**
     * Get the duration of the scan.
     *
     * @return string|null
     */
    public function getDurationAttribute()
    {
        if ($this->started_at && $this->completed_at) {
            return $this->started_at->longAbsoluteDiffForHumans($this->completed_at);
        }
    }
}
