<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;

class AuditService
{
    /**
     * Log a create action
     */
    public static function logCreate(Model $model, ?string $description = null): AuditLog
    {
        return AuditLog::log(
            'create',
            $model,
            null,
            $model->toArray(),
            $description ?? self::generateDescription('created', $model)
        );
    }

    /**
     * Log an update action
     */
    public static function logUpdate(Model $model, array $oldValues, ?string $description = null): AuditLog
    {
        // Only log changed values
        $changes = array_diff_assoc($model->toArray(), $oldValues);
        $oldChanges = array_intersect_key($oldValues, $changes);

        return AuditLog::log(
            'update',
            $model,
            $oldChanges,
            $changes,
            $description ?? self::generateDescription('updated', $model)
        );
    }

    /**
     * Log a delete action
     */
    public static function logDelete(Model $model, ?string $description = null): AuditLog
    {
        return AuditLog::log(
            'delete',
            $model,
            $model->toArray(),
            null,
            $description ?? self::generateDescription('deleted', $model)
        );
    }

    /**
     * Log user login
     */
    public static function logLogin(Model $user): AuditLog
    {
        return AuditLog::log(
            'login',
            $user,
            null,
            null,
            "User {$user->name} logged in"
        );
    }

    /**
     * Log user logout
     */
    public static function logLogout(Model $user): AuditLog
    {
        return AuditLog::log(
            'logout',
            $user,
            null,
            null,
            "User {$user->name} logged out"
        );
    }

    /**
     * Log order placed
     */
    public static function logOrderPlaced(Model $order): AuditLog
    {
        return AuditLog::log(
            'order_placed',
            $order,
            null,
            ['total' => $order->total, 'items_count' => $order->items->count()],
            "Order {$order->order_code} placed with total " . number_format($order->total, 0, ',', '.') . '₫'
        );
    }

    /**
     * Log order status change
     */
    public static function logOrderStatusChange(Model $order, string $oldStatus, string $newStatus): AuditLog
    {
        return AuditLog::log(
            'order_status_changed',
            $order,
            ['status' => $oldStatus],
            ['status' => $newStatus],
            "Order {$order->order_code} status changed from {$oldStatus} to {$newStatus}"
        );
    }

    /**
     * Log payment status change
     */
    public static function logPaymentStatusChange(Model $order, string $oldStatus, string $newStatus): AuditLog
    {
        return AuditLog::log(
            'payment_status_changed',
            $order,
            ['payment_status' => $oldStatus],
            ['payment_status' => $newStatus],
            "Order {$order->order_code} payment status changed from {$oldStatus} to {$newStatus}"
        );
    }

    /**
     * Generate description automatically
     */
    protected static function generateDescription(string $action, Model $model): string
    {
        $modelName = class_basename($model);
        $identifier = $model->name ?? $model->title ?? $model->order_code ?? "#{$model->id}";

        return "{$modelName} '{$identifier}' was {$action}";
    }
}
