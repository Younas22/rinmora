<?php
// app/Models/User.php

namespace App\Models;

use App\Models\System\AdminActivityLog;
use App\Models\System\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // User Types Constants
    const TYPE_USER = 'user';
    const TYPE_ADMIN = 'admin';
    const TYPE_AGENT = 'agent';

    protected $fillable = [
        'user_type',
        'first_name',
        'last_name',
        'email',
        'phone',
        'profile_image',
        'date_of_birth',
        'gender',
        'customer_tier',
        'status',
        'password',
        'address',
        'city',
        'state',
        'zip_code',
        'country',
        'total_bookings',
        'total_spent',
        'average_spending',
        'last_activity',
        'employee_id',
        'hire_date',
        'department',
        'commission_rate',
        'total_sales',
        'total_commission',
        'email_notifications',
        'sms_notifications',
        'marketing_emails',
        'internal_notes',
        'role_id',
        'bio',
        'social_website',
        'social_linkedin',
        'social_twitter',
        'social_instagram',
        'notification_preferences',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'date_of_birth' => 'date',
        'hire_date' => 'date',
        'last_activity' => 'datetime',
        'total_spent' => 'decimal:2',
        'average_spending' => 'decimal:2',
        'commission_rate' => 'decimal:2',
        'total_commission' => 'decimal:2',
        'email_notifications' => 'boolean',
        'sms_notifications' => 'boolean',
        'marketing_emails' => 'boolean',
        'notification_preferences' => 'array',
    ];

    // Accessors
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getInitialsAttribute()
    {
        return strtoupper(substr($this->first_name, 0, 1) . substr($this->last_name, 0, 1));
    }

    public function getProfileImageUrlAttribute()
    {
        return $this->profile_image
            ? asset('storage/' . $this->profile_image)
            : 'https://placehold.co/400';
    }

    public function getAvatarUrlAttribute(): ?string
    {
        return $this->profile_image ? Storage::disk('public_uploads')->url($this->profile_image) : null;
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function adminActivityLogs()
    {
        return $this->hasMany(AdminActivityLog::class, 'user_id');
    }

    // User Type Scopes
    public function scopeCustomers($query)
    {
        return $query->where('user_type', self::TYPE_USER);
    }

    public function scopeAdmins($query)
    {
        return $query->where('user_type', self::TYPE_ADMIN);
    }

    public function scopeAgents($query)
    {
        return $query->where('user_type', self::TYPE_AGENT);
    }

    public function scopeStaff($query)
    {
        return $query->whereIn('user_type', [self::TYPE_ADMIN, self::TYPE_AGENT]);
    }

    // Other Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByTier($query, $tier)
    {
        return $query->where('customer_tier', $tier);
    }

    public function scopeVip($query)
    {
        return $query->where('status', 'vip');
    }

    // User Type Check Methods
    public function isCustomer()
    {
        return $this->user_type === self::TYPE_USER;
    }

    public function isAdmin()
    {
        return $this->user_type === self::TYPE_ADMIN;
    }

    public function isAgent()
    {
        return $this->user_type === self::TYPE_AGENT;
    }

    public function isStaff()
    {
        return in_array($this->user_type, [self::TYPE_ADMIN, self::TYPE_AGENT]);
    }

    // app/Models/User.php
    public function blogPosts()
    {
        return $this->hasMany(BlogPost::class, 'author_id');
    }

    public function orders()
    {
        return $this->hasMany(\App\Models\Sales\Order::class, 'user_id');
    }

    public function addresses()
    {
        return $this->hasMany(\App\Models\Customers\Address::class, 'user_id');
    }

    public function wishlist()
    {
        return $this->hasMany(\App\Models\Customers\Wishlist::class, 'user_id');
    }

    public function rewardPoints()
    {
        return $this->hasOne(\App\Models\Customers\RewardPoint::class, 'user_id');
    }

    public function getLastLoginLabelAttribute(): string
    {
        if (!$this->last_activity) {
            return 'Never';
        }

        $days = $this->last_activity->diffInDays(now());

        return match (true) {
            $this->last_activity->isToday() => 'Today',
            $this->last_activity->isYesterday() => 'Yesterday',
            default => $days.' days ago',
        };
    }

    // Methods
    public function updateBookingStats($newBookingAmount = 0)
    {
        if ($this->isCustomer()) {
            $this->increment('total_bookings');
            $this->increment('total_spent', $newBookingAmount);
            
            // Update average spending
            $this->average_spending = $this->total_spent / $this->total_bookings;
            $this->last_activity = now();
            $this->save();
        }
    }

    public function updateAgentSales($saleAmount = 0)
    {
        if ($this->isAgent() && $this->commission_rate) {
            $this->increment('total_sales');
            $commission = $saleAmount * ($this->commission_rate / 100);
            $this->increment('total_commission', $commission);
            $this->save();
        }
    }

    public function getStatusBadgeClass()
    {
        return match($this->status) {
            'active' => 'status-active',
            'inactive' => 'status-inactive',
            'suspended' => 'status-suspended',
            'vip' => 'status-vip',
            default => 'status-active'
        };
    }

    public function getTierBadgeClass()
    {
        return match($this->customer_tier) {
            'bronze' => 'tier-bronze',
            'silver' => 'tier-silver',
            'gold' => 'tier-gold',
            'platinum' => 'tier-platinum',
            default => 'tier-bronze'
        };
    }

    public function getUserTypeBadgeClass()
    {
        return match($this->user_type) {
            'admin' => 'badge bg-danger',
            'agent' => 'badge bg-warning',
            'user' => 'badge bg-primary',
            default => 'badge bg-secondary'
        };
    }

    public function getUserTypeLabel()
    {
        return match($this->user_type) {
            'admin' => 'Administrator',
            'agent' => 'Agent',
            'user' => 'Customer',
            default => 'Unknown'
        };
    }
}