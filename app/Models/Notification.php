<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int|null $user_id
 * @property string $type
 * @property string $notifiable_type
 * @property int $notifiable_id
 * @property string $recipient_email
 * @property string $subject
 * @property string $body
 * @property string $channel
 * @property \Carbon\Carbon|null $sent_at
 * @property \Carbon\Carbon|null $read_at
 * @property array|null $data
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Notification extends Model
{
    protected $fillable = [
        'user_id', 'type', 'notifiable_type', 'notifiable_id',
        'recipient_email', 'subject', 'body', 'channel',
        'sent_at', 'read_at', 'data',
    ];

    protected $casts = [
        'data' => 'array',
        'sent_at' => 'datetime',
        'read_at' => 'datetime',
    ];

    public function notifiable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function markAsSent()
    {
        $this->update(['sent_at' => now()]);
    }

    public function markAsRead()
    {
        $this->update(['read_at' => now()]);
    }

    public function isPending()
    {
        return is_null($this->sent_at);
    }
}
