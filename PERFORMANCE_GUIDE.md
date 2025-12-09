# Performance Optimization Guide

## Quick Reference for Developers

This guide provides quick tips and best practices for maintaining optimal performance in the UITech Store application.

## Database Query Optimization

### ✅ DO: Use Eager Loading

```php
// Good - prevents N+1 queries
$products = Product::with(['category', 'images', 'specs'])->get();

// Good - with constraints
$products = Product::with([
    'images' => function($query) {
        $query->where('is_primary', true)->limit(1);
    }
])->get();

// Bad - causes N+1 queries
$products = Product::all();
foreach ($products as $product) {
    echo $product->category->name; // separate query for each product
}
```

### ✅ DO: Select Only Needed Columns

```php
// Good - reduces data transfer
$products = Product::select('id', 'name', 'price', 'category_id')
    ->with('category:id,name')
    ->get();

// Bad - loads all columns
$products = Product::with('category')->get();
```

### ✅ DO: Use Aggregate Queries

```php
// Good - single query
Product::withCount('reviews')
    ->withAvg('reviews', 'rating')
    ->get();

// Bad - multiple queries
foreach ($products as $product) {
    $count = $product->reviews()->count();
    $avg = $product->reviews()->avg('rating');
}
```

### ✅ DO: Use Database Indexes

Indexes are already added for common queries. When adding new filtering:

```php
// If you add filtering by a new column, add an index in migration:
Schema::table('products', function (Blueprint $table) {
    $table->index('new_column');
});
```

### ❌ DON'T: Use Computed Attributes in Lists

```php
// Bad - causes N+1 queries
public function getFullNameAttribute() {
    return $this->first_name . ' ' . $this->last_name;
}

// Good - use select raw or accessor checks
public function getFullNameAttribute() {
    // Check if already computed
    if (isset($this->attributes['full_name'])) {
        return $this->attributes['full_name'];
    }
    return $this->first_name . ' ' . $this->last_name;
}

// Better - compute in query
User::selectRaw("CONCAT(first_name, ' ', last_name) as full_name")->get();
```

## Caching Strategies

### ✅ DO: Cache Static or Rarely-Changed Data

```php
// Good - categories cached for 1 hour
$categories = Category::getRootWithChildrenCached();

// Bad - query every time
$categories = Category::root()->with('children')->get();
```

### ✅ DO: Clear Cache When Data Changes

```php
// Already implemented in Category model
protected static function boot()
{
    parent::boot();
    
    static::saved(function () {
        cache()->forget('categories_root_with_children');
    });
}
```

### Common Cache Keys in This Application

- `categories_root_with_children` - Root categories with children (1 hour TTL)

## Controller Optimization

### ✅ DO: Combine Similar Queries

```php
// Good - single query with aggregates
$stats = Order::selectRaw('
    COUNT(*) as total_orders,
    SUM(total) as total_revenue,
    COUNT(CASE WHEN status = "pending" THEN 1 END) as pending_orders
')->first();

// Bad - multiple queries
$totalOrders = Order::count();
$totalRevenue = Order::sum('total');
$pendingOrders = Order::where('status', 'pending')->count();
```

### ✅ DO: Use Group By Instead of Loops

```php
// Good - single query
$counts = Product::select('category_id', DB::raw('COUNT(*) as count'))
    ->groupBy('category_id')
    ->pluck('count', 'category_id');

// Bad - loop with queries
foreach ($categories as $category) {
    $count = Product::where('category_id', $category->id)->count();
}
```

## Frontend Optimization

### ✅ DO: Limit Initial Data Load

```php
// Good - paginate and limit relationships
$products = Product::with([
    'images' => fn($q) => $q->limit(1)
])->paginate(12);

// Bad - load everything
$products = Product::with('images', 'reviews', 'specs')->get();
```

### ✅ DO: Use AJAX for Dynamic Content

The product filter already uses AJAX to avoid full page reloads. Follow this pattern for other dynamic features.

## Common Performance Anti-Patterns to Avoid

### ❌ DON'T: Query in Loops

```php
// Bad
foreach ($orders as $order) {
    $order->total = $order->items()->sum('price');
    $order->save();
}

// Good
Order::query()->each(function ($order) {
    $total = $order->items->sum('price');
    $order->update(['total' => $total]);
});
```

### ❌ DON'T: Load Unnecessary Relationships

```php
// Bad - loading everything
$product = Product::with('category', 'images', 'reviews', 'specs', 'orderItems')->find($id);

// Good - load only what's needed
$product = Product::with('category:id,name', 'images')->find($id);
```

### ❌ DON'T: Use whereHas Without Need

```php
// Bad - slow query
$products = Product::whereHas('category', function($q) {
    $q->where('name', 'CPU');
})->get();

// Good - direct join is faster
$products = Product::join('categories', 'products.category_id', '=', 'categories.id')
    ->where('categories.name', 'CPU')
    ->select('products.*')
    ->get();

// Better - if you have category_id already
$category = Category::where('name', 'CPU')->first();
$products = Product::where('category_id', $category->id)->get();
```

## Monitoring Performance

### Using Laravel Telescope (Development)

```bash
composer require laravel/telescope --dev
php artisan telescope:install
php artisan migrate
```

Then visit `/telescope` to monitor queries, requests, and performance.

### Using Laravel Debugbar (Development)

```bash
composer require barryvdh/laravel-debugbar --dev
```

Shows query count, execution time, and memory usage at the bottom of each page.

### Database Query Logging

Enable query logging in development:

```php
// In AppServiceProvider or a middleware
DB::listen(function ($query) {
    if ($query->time > 100) { // Log slow queries (>100ms)
        Log::warning('Slow query', [
            'sql' => $query->sql,
            'time' => $query->time,
            'bindings' => $query->bindings
        ]);
    }
});
```

## Performance Checklist for New Features

When adding new features, verify:

- [ ] Are you using eager loading for relationships?
- [ ] Are you selecting only necessary columns?
- [ ] Are new filterable columns indexed?
- [ ] Are you avoiding queries in loops?
- [ ] Are you using appropriate caching?
- [ ] Have you tested with realistic data volumes?
- [ ] Are computed attributes checking for pre-loaded values?
- [ ] Is pagination used for large datasets?

## Testing Performance

### Load Testing

```bash
# Install Apache Bench
sudo apt-get install apache2-utils

# Test product listing page
ab -n 1000 -c 10 http://localhost:8000/products

# Test with authentication
ab -n 1000 -c 10 -C "laravel_session=your-session-token" http://localhost:8000/cart
```

### Benchmarking Queries

```php
use Illuminate\Support\Benchmark;

$result = Benchmark::measure([
    'eager' => fn () => Product::with('category')->get(),
    'lazy' => fn () => Product::all(),
], iterations: 100);

// Returns: ['eager' => 0.123, 'lazy' => 1.456]
```

## Database Maintenance

### Analyzing Tables

```sql
-- Check index usage
SHOW INDEX FROM products;

-- Analyze table statistics
ANALYZE TABLE products;

-- Check table size
SELECT 
    table_name,
    ROUND(((data_length + index_length) / 1024 / 1024), 2) AS "Size (MB)"
FROM information_schema.TABLES
WHERE table_schema = "uitech"
ORDER BY (data_length + index_length) DESC;
```

### Regular Maintenance Tasks

```bash
# Optimize database tables
php artisan db:optimize

# Clear expired cache
php artisan cache:clear

# Clear view cache
php artisan view:clear

# Clear compiled class files
php artisan optimize:clear
```

## Further Reading

- [Laravel Performance](https://laravel.com/docs/10.x/performance)
- [Database Indexing Best Practices](https://use-the-index-luke.com/)
- [N+1 Query Problem](https://laraveldaily.com/post/eloquent-n1-query-problem-and-how-to-avoid-it)
- [Laravel Query Optimization](https://laravel-news.com/laravel-query-optimization)

## Need Help?

If you're unsure about query performance:
1. Use Laravel Telescope/Debugbar to monitor query count
2. Check the execution time of queries
3. Review this guide and PERFORMANCE_IMPROVEMENTS.md
4. Test with production-like data volumes
5. Profile before and after optimizations
