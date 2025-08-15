<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\FinancialTransaction
 *
 * @property int $id
 * @property string $transaction_id
 * @property string $type
 * @property string $category
 * @property string $amount
 * @property string $description
 * @property string|null $reference
 * @property string $account
 * @property string $transaction_date
 * @property string $status
 * @property string|null $payment_method
 * @property int|null $employee_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Employee|null $employee
 * @property string $formatted_amount
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialTransaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialTransaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialTransaction whereAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialTransaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialTransaction whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialTransaction whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialTransaction whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialTransaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialTransaction wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialTransaction whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialTransaction whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialTransaction whereTransactionDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialTransaction whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialTransaction whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialTransaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialTransaction income()
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialTransaction expense()
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialTransaction completed()
 * @method static \Database\Factories\FinancialTransactionFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class FinancialTransaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'transaction_id',
        'type',
        'category',
        'amount',
        'description',
        'reference',
        'account',
        'transaction_date',
        'status',
        'payment_method',
        'employee_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'transaction_date' => 'date',
    ];

    /**
     * Get the formatted amount with currency.
     *
     * @return string
     */
    public function getFormattedAmountAttribute(): string
    {
        return '$' . number_format((float) $this->amount, 2);
    }

    /**
     * Get the employee who recorded the transaction.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Scope a query to only include income transactions.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIncome($query)
    {
        return $query->where('type', 'income');
    }

    /**
     * Scope a query to only include expense transactions.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeExpense($query)
    {
        return $query->where('type', 'expense');
    }

    /**
     * Scope a query to only include completed transactions.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}