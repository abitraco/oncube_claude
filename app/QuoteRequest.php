<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuoteRequest extends Model
{
    protected $fillable = [
        'company_email',
        'company_name',
        'phone',
        'contact_name',
        'product_url',
        'inquiry_type',
        'quantity',
        'message',
        'attachment',
        'privacy_agreed',
        'locale',
        'status',
        'quote_template',
        'quote_data',
        'quote_pdf',
        'quote_sent_at',
        'admin_notes'
    ];

    protected $casts = [
        'privacy_agreed' => 'boolean',
        'quote_sent_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Get quote data as array
    public function getQuoteDataAttribute($value)
    {
        return $value ? json_decode($value, true) : null;
    }

    // Set quote data from array
    public function setQuoteDataAttribute($value)
    {
        $this->attributes['quote_data'] = $value ? json_encode($value) : null;
    }

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_QUOTE_SENT = 'quote_sent';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    // Get status label
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            self::STATUS_PENDING => '대기중',
            self::STATUS_QUOTE_SENT => '견적서 발송됨',
            self::STATUS_COMPLETED => '완료',
            self::STATUS_CANCELLED => '취소',
            default => $this->status,
        };
    }
}
