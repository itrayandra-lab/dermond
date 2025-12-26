# Authentication

Sistem autentikasi Dermond menggunakan dual guard untuk memisahkan customer dan admin.

## Overview

Project ini menggunakan **satu User model** dengan **dua authentication guards**:

| Guard | Purpose | Middleware | Target Role |
| ----- | ------- | ---------- | ----------- |
| `web` | Customer area | `customer.auth` | `user` |
| `admin` | Admin panel | `admin.auth` | `admin`, `content_manager` |

## User Roles

| Role | Access |
| ---- | ------ |
| `user` | Customer: shopping, checkout, order history, profile |
| `admin` | Full admin panel access |
| `content_manager` | Limited admin: articles, sliders (no order/product management) |

## User Model

File: `app/Models/User.php`

```php
class User extends Authenticatable
{
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
    ];

    // Helper methods
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isContentManager(): bool
    {
        return $this->role === 'content_manager';
    }

    public function hasRole(array|string $roles): bool
    {
        return in_array($this->role, (array) $roles, true);
    }
}
```

## Middleware

### AdminAuth

File: `app/Http/Middleware/AdminAuth.php`

```php
class AdminAuth
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        Auth::shouldUse('admin');

        if (! Auth::guard('admin')->check()) {
            return redirect()->route('login');
        }

        $user = Auth::guard('admin')->user();
        $allowedRoles = ! empty($roles) ? $roles : ['admin', 'content_manager'];

        if (! in_array($user->role, $allowedRoles, true)) {
            Auth::guard('admin')->logout();
            return redirect()->route('login')->with('error', 'Unauthorized access.');
        }

        return $next($request);
    }
}
```

Middleware ini:
- Set guard ke `admin`
- Cek user sudah login
- Validasi role (default: admin atau content_manager)
- Support custom roles via parameter: `admin.auth:admin` (hanya admin)

### CustomerAuth

File: `app/Http/Middleware/CustomerAuth.php`

```php
class CustomerAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        Auth::shouldUse('web');

        if (! Auth::guard('web')->check()) {
            return redirect()->route('login');
        }

        if (Auth::guard('web')->user()->role !== 'user') {
            Auth::guard('web')->logout();
            return redirect()->route('login')->with('error', 'Unauthorized access.');
        }

        return $next($request);
    }
}
```

Middleware ini:
- Set guard ke `web`
- Cek user sudah login
- Validasi role harus `user` (customer)

## Route Protection

### Admin Routes

```php
// routes/web.php
Route::middleware(['admin.auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', ProductController::class);
    Route::resource('orders', OrderController::class);
    // ...
});

// Admin-only routes (exclude content_manager)
Route::middleware(['admin.auth:admin'])->prefix('admin')->group(function () {
    Route::resource('users', UserController::class);
});
```

### Customer Routes

```php
Route::middleware(['customer.auth'])->prefix('account')->name('account.')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::resource('addresses', AddressController::class);
});

Route::middleware(['customer.auth'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
});
```

## Login Flow

### Single Login Page

Project menggunakan satu halaman login (`/login`) untuk semua user:

```php
// LoginController
public function login(LoginRequest $request)
{
    $credentials = $request->validated();

    // Try admin guard first
    if (Auth::guard('admin')->attempt($credentials)) {
        $user = Auth::guard('admin')->user();
        if (in_array($user->role, ['admin', 'content_manager'])) {
            return redirect()->route('admin.dashboard');
        }
    }

    // Try web guard for customers
    if (Auth::guard('web')->attempt($credentials)) {
        return redirect()->intended('/account');
    }

    return back()->withErrors(['email' => 'Invalid credentials']);
}
```

### Logout

```php
public function logout(Request $request)
{
    Auth::guard('admin')->logout();
    Auth::guard('web')->logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');
}
```

## Guard Configuration

File: `config/auth.php`

```php
'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],
    'admin' => [
        'driver' => 'session',
        'provider' => 'users',
    ],
],

'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => App\Models\User::class,
    ],
],
```

Kedua guards menggunakan provider yang sama (`users`) karena menggunakan satu User model.

## Blade Directives

### Check Auth Status

```blade
{{-- Check if logged in as customer --}}
@auth('web')
    <p>Welcome, {{ auth('web')->user()->name }}</p>
@endauth

{{-- Check if logged in as admin --}}
@auth('admin')
    <p>Admin: {{ auth('admin')->user()->name }}</p>
@endauth

{{-- Guest check --}}
@guest
    <a href="{{ route('login') }}">Login</a>
@endguest
```

### Check Role in Admin Views

```blade
{{-- Show only for admin role --}}
@if(auth('admin')->user()->isAdmin())
    <a href="{{ route('admin.users.index') }}">Manage Users</a>
@endif

{{-- Using hasRole --}}
@if(auth('admin')->user()->hasRole(['admin', 'content_manager']))
    <a href="{{ route('admin.articles.index') }}">Manage Articles</a>
@endif
```

## Default Accounts

Setelah menjalankan seeder:

| Role | Email | Password |
| ---- | ----- | -------- |
| Admin | admin@dermond.local | password |
| Customer | customer@dermond.local | password |

## Next Steps

- [Architecture](architecture.md) - Overview struktur project
- [Orders](orders.md) - Order management untuk admin
- [Cart & Checkout](cart-checkout.md) - Customer shopping flow
