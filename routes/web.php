<?php

use App\Livewire\Customers\CreateCustomer;
use App\Livewire\Customers\EditCustomers;
use App\Livewire\Customers\ListCustomers;
use App\Livewire\Items\CreateItem;
use App\Livewire\Items\EditInventory;
use App\Livewire\Items\CreateInventory;
use App\Livewire\Items\EditItem;
use App\Livewire\Items\ListInventories;
use App\Livewire\Items\ListItems;
use App\Livewire\Management\CreatePaymentMethod;
use App\Livewire\Management\CreateUser;
use App\Livewire\Management\EditPaymentMethods;
use App\Livewire\Management\EditUsers;
use App\Livewire\Management\ListPaymentMethods;
use App\Livewire\Management\ListUsers;
use App\Livewire\POS;
use App\Livewire\Sales\ListSales;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    Route::get('settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});

Route::get('/sales/{sale}/receipt', function (\App\Models\Sale $sale) {
    $sale->load(['saleItems.item', 'customer', 'paymentMethod']);
    return view('pdf', ['records' => collect([$sale])]);
})->name('sales.receipt');

Route::middleware(['auth'])->group(function () {
    
    Route::get('/Manage-users', ListUsers::class)->name('users.index');
    Route::get('/Edit-users/{record}', EditUsers::class)->name('user.update');
    Route::get('/Create-users', CreateUser::class)->name('users.create');
    
    Route::get('/manage-items', ListItems::class)->name('items.index');
    Route::get('/Edit-item/{record}', EditItem::class)->name('item.update');
    Route::get('/Create-item', CreateItem::class)->name('items.create');
    
    Route::get('/manage-inventories', ListInventories::class)->name('inventories.index');
    Route::get('/Edit-inventory/{record}', EditInventory::class)->name('inventory.update');
    Route::get('/Create-inventory', CreateInventory::class)->name('inventories.create');
    
    Route::get('/manage-sales', ListSales::class)->name('sales.index');

    Route::get('/manage-customers', ListCustomers::class)->name('customers.index');
    Route::get('/edit-customer/{record}', EditCustomers::class)->name('customer.update');
    Route::get('/Create-customer', CreateCustomer::class)->name('customers.create');
    
    Route::get('/manage-payment-methods', ListPaymentMethods::class)->name('payment.method.index');
    Route::get('/edit-payment-method/{record}',EditPaymentMethods::class)->name('payment-method.update');
    Route::get('/Create-payment-method',CreatePaymentMethod::class)->name('payment-method.create');

    Route::get('/pos',POS::class)->name('pos');
});

require __DIR__.'/auth.php';
