<?php

uses()->group('filament-tests');

use App\Models\Shop\Customer;
use App\Models\User;

use Filament\Tables\Actions\{
    DeleteAction,
    DeleteBulkAction,
    RestoreAction,
    ReplicateAction,
    RestoreBulkAction,
    ForceDeleteAction,
    ForceDeleteBulkAction
};

use function Pest\Laravel\{actingAs};
use function Pest\Livewire\livewire;

beforeEach(function () {
    actingAs(User::factory()->create());
});

it('can register', function () {
    //
})->group('auth',  'page',  'registration')->todo();

it('can reset the password', function () {
    //
})->group('auth',  'page',  'password-reset')->todo();

it('can login', function () {
    //
})->group('auth',  'login',  'page')->todo();

it('can logout', function () {
    //
})->group('auth',  'logout',  'page')->todo();

it('can render the index page', function () {
    livewire(\App\Filament\Resources\Shop\CustomerResource\Pages\ListCustomers::class)
        ->assertSuccessful();
})->group('index',  'page',  'resource');

it('can list records on the index page', function () {
    $records = Customer::factory(3)->create();

    livewire(\App\Filament\Resources\Shop\CustomerResource\Pages\ListCustomers::class)
        ->assertCanSeeTableRecords($records);
})->group('index',  'page',  'resource');

it('can list records on the index page with pagination', function () {
    $records = Customer::factory(20)->create();

    livewire(\App\Filament\Resources\Shop\CustomerResource\Pages\ListCustomers::class)
        ->call('gotoPage', 2)
        ->assertCanSeeTableRecords($records->skip(10));
})->group('index',  'page',  'resource');

it('cannot display trashed records by default', function () {
    $records = Customer::factory(3)->create();

    $trashedRecords = Customer::factory(6)
        ->trashed()
        ->create();

    livewire(\App\Filament\Resources\Shop\CustomerResource\Pages\ListCustomers::class)
        ->assertCanSeeTableRecords($records)
        ->assertCanNotSeeTableRecords($trashedRecords)
        ->assertCountTableRecords(3);
})->group('index',  'page',  'resource');

it('has header actions on the index page', function (string $action) {
    livewire(\App\Filament\Resources\Shop\CustomerResource\Pages\ListCustomers::class)
        ->assertActionExists($action);
})->with(['create'])->group('action',  'index',  'page',  'resource');

it('can render header actions on the index page', function (string $action) {
    livewire(\App\Filament\Resources\Shop\CustomerResource\Pages\ListCustomers::class)
        ->assertActionVisible($action);
})->with(['create'])->group('action',  'index',  'page',  'resource');

it('has table action', function (string $action) {
    livewire(\App\Filament\Resources\Shop\CustomerResource\Pages\ListCustomers::class)
        ->assertTableActionExists($action);
})->with(["edit"])->group('action',  'index',  'page',  'resource',  'table');

it('has column', function (string $column) {
    livewire(\App\Filament\Resources\Shop\CustomerResource\Pages\ListCustomers::class)
        ->assertTableColumnExists($column);
})->with(['name', 'email', 'country', 'phone'])->group('column',  'index',  'page',  'resource',  'table');

it('can render column', function (string $column) {
    livewire(\App\Filament\Resources\Shop\CustomerResource\Pages\ListCustomers::class)
        ->assertCanRenderTableColumn($column);
})->with(['name', 'email', 'country', 'phone'])->group('column',  'index',  'page',  'resource',  'table');

it('can sort column', function (string $column) {
    $records = Customer::factory(3)->create();

    livewire(\App\Filament\Resources\Shop\CustomerResource\Pages\ListCustomers::class)
        ->sortTable($column)
        ->assertCanSeeTableRecords(
            $records->sortBy(fn ($record) => data_get($record, $column))->values()->all(),
            inOrder: true
        )
        ->sortTable($column, 'desc')
       ->assertCanSeeTableRecords(
           $records->sortByDesc(fn ($record) => data_get($record, $column))->values()->all(),
           inOrder: true
       );
})->with(['name', 'email', 'phone'])->group('column',  'index',  'page',  'resource',  'table');

it('can search column on the index page', function (string $column) {
    $records = Customer::factory(3)->create();

    $search = data_get($records->first(), $column);

    livewire(\App\Filament\Resources\Shop\CustomerResource\Pages\ListCustomers::class)
        ->searchTable($search instanceof BackedEnum ? $search->value : $search)
        ->assertCanSeeTableRecords($records->filter(fn ($record) => data_get($record, $column) == $search));
})->with(['name', 'email', 'phone'])->group('column',  'index',  'page',  'resource',  'table');
it('can individually search on the index page by column', function (string $column) {
    $records = Customer::factory(3)->create();

    $search = data_get($records->first(), $column);

    livewire(\App\Filament\Resources\Shop\CustomerResource\Pages\ListCustomers::class)
        ->searchTable($search instanceof BackedEnum ? $search->value : $search)
        ->assertCanSeeTableRecords($records->filter(fn ($record) => data_get($record, $column) == $search));
})->with(['name', 'email'])->group('column',  'index',  'page',  'resource',  'table');
it('can reset table filters', function () {
    $records = Customer::factory(3)->create();

    livewire(\App\Filament\Resources\Shop\CustomerResource\Pages\ListCustomers::class)
        ->resetTableFilters()
        ->assertCanSeeTableRecords($records);
})->group('filter',  'index',  'page',  'resource',  'table');

it('can add a table filter', function () {
    //
})->group('filter',  'index',  'page',  'resource',  'table')->todo();

it('can remove a table filter', function () {
    //
})->group('filter',  'index',  'page',  'resource',  'table')->todo();

it('can render footer widgets on the index page', function () {
    //
})->group('index',  'page',  'resource',  'widget')->todo();

it('can render header widgets on the index page', function () {
    //
})->group('index',  'page',  'resource',  'widget')->todo();

it('can render the create page', function () {
    livewire(\App\Filament\Resources\Shop\CustomerResource\Pages\CreateCustomer::class)
        ->assertSuccessful();
})->group('create',  'page',  'resource');

it('can render action on the create page', function () {
    //
})->group('action',  'create',  'page',  'resource')->todo();

it('can render footer widgets on the create page', function () {
    //
})->group('create',  'page',  'resource',  'widget')->todo();

it('can render header widgets on the create page', function () {
    //
})->group('create',  'page',  'resource',  'widget')->todo();

it('has a field on create form', function (string $field) {
    livewire(\App\Filament\Resources\Shop\CustomerResource\Pages\CreateCustomer::class)
        ->assertFormFieldExists($field);
})->with(['name', 'email', 'phone', 'birthday'])->group('create',  'field',  'form',  'page',  'resource');

it('can validate input on create form', function () {
    //
})->group('create',  'field',  'form',  'page',  'resource')->todo();

it('has create form', function () {
    livewire(\App\Filament\Resources\Shop\CustomerResource\Pages\CreateCustomer::class)
        ->assertFormExists();
})->group('create',  'form',  'page',  'resource');

it('can render form on the create page', function () {
    //
})->group('create',  'form',  'page',  'resource')->todo();

it('can validate create form input', function () {
    //
})->group('create',  'form',  'page',  'resource')->todo();

it('can render the edit page', function () {
    $record = Customer::factory()->create();

    livewire(\App\Filament\Resources\Shop\CustomerResource\Pages\EditCustomer::class, ['record' => $record->getRouteKey()])
        ->assertSuccessful();
})->group('edit',  'page',  'resource');

it('can render action on the edit page', function () {
    //
})->group('action',  'edit',  'page',  'resource')->todo();

it('can render form on the edit page', function () {
    //
})->group('edit',  'form',  'page',  'resource')->todo();

it('can render footer widgets on the edit page', function () {
    //
})->group('edit',  'page',  'resource',  'widget')->todo();

it('can render header widgets on the edit page', function () {
    //
})->group('edit',  'page',  'resource',  'widget')->todo();

it('has a field on edit form', function (string $field) {
    $record = Customer::factory()->create();

    livewire(\App\Filament\Resources\Shop\CustomerResource\Pages\EditCustomer::class, ['record' => $record->getRouteKey()])
        ->assertFormFieldExists($field);
})->with(['name', 'email', 'phone', 'birthday'])->group('edit',  'field',  'form',  'page',  'resource');

it('can validate input on edit form', function () {
    //
})->group('edit',  'field',  'form',  'page',  'resource')->todo();

it('has edit form', function () {
    $record = Customer::factory()->create();

    livewire(\App\Filament\Resources\Shop\CustomerResource\Pages\EditCustomer::class, ['record' => $record->getRouteKey()])
        ->assertFormExists();
})->group('edit',  'form',  'page',  'resource');

it('can validate edit form input', function () {
    //
})->group('edit',  'form',  'page',  'resource')->todo();

it('can fill the form on the edit page', function () {
    //
})->group('edit',  'form',  'page',  'resource')->todo();

it('can render action on the view page', function () {
    //
})->group('action',  'page',  'resource',  'view')->todo();

it('can render form on the view page', function () {
    //
})->group('form',  'page',  'resource',  'view')->todo();

it('can render infolist on the view page', function () {
    //
})->group('infolist',  'page',  'resource',  'view')->todo();

it('has action on infolist', function () {
    //
})->group('action',  'infolist',  'page',  'resource',  'view')->todo();

it('can render infolist entry on the view page', function () {
    //
})->group('entry',  'infolist',  'page',  'resource',  'view')->todo();

it('can render footer widgets on the view page', function () {
    //
})->group('page',  'resource',  'view',  'widget')->todo();

it('can render header widgets on the view page', function () {
    //
})->group('page',  'resource',  'view',  'widget')->todo();

it('can render the addresses relation manager on the edit page', function () {
    $ownerRecord = Customer::factory()
        ->hasAddresses(3)
        ->create();

    livewire(App\Filament\Resources\Shop\CustomerResource\RelationManagers\AddressesRelationManager::class, [
        'ownerRecord' => $ownerRecord,
        'pageClass' => \App\Filament\Resources\Shop\CustomerResource\Pages\EditCustomer::class
    ])
        ->assertSuccessful();
})->group('edit',  'page',  'relation-manager',  'resource');

it('can list records on the addresses relation manager on the edit page', function () {
    $ownerRecord = Customer::factory()
        ->hasAddresses(3)
        ->create();

    livewire(App\Filament\Resources\Shop\CustomerResource\RelationManagers\AddressesRelationManager::class, [
        'ownerRecord' => $ownerRecord,
        'pageClass' => \App\Filament\Resources\Shop\CustomerResource\Pages\EditCustomer::class
    ])
        ->assertCanSeeTableRecords($ownerRecord->addresses);
})->group('edit',  'page',  'relation-manager',  'resource');

it('cannot display trashed records by default on the edit page on addresses relation manager', function () {
    //
})->group('edit',  'page',  'relation-manager',  'resource')->todo();

it('has header actions on the edit page on addresses relation manager', function () {
    //
})->group('edit',  'header-action',  'page',  'relation-manager',  'resource')->todo();

it('cannot render header actions on the edit page on addresses relation manager', function () {
    //
})->group('edit',  'header-action',  'page',  'relation-manager',  'resource')->todo();

it('can render header actions on the edit page on addresses relation manager', function () {
    //
})->group('edit',  'header-action',  'page',  'relation-manager',  'resource')->todo();

it('can delete records on the edit page on addresses relation manager', function () {
    //
})->group('action',  'edit',  'page',  'relation-manager',  'resource',  'table')->todo();

it('can force delete records on the edit page on addresses relation manager', function () {
    //
})->group('action',  'edit',  'page',  'relation-manager',  'resource',  'table')->todo();

it('can soft delete records on the edit page on addresses relation manager', function () {
    //
})->group('action',  'edit',  'page',  'relation-manager',  'resource',  'table')->todo();

it('has action on the edit page on addresses relation manager', function () {
    //
})->group('action',  'edit',  'page',  'relation-manager',  'resource',  'table')->todo();

it('cannot render action on the edit page on addresses relation manager', function () {
    //
})->group('action',  'edit',  'page',  'relation-manager',  'resource',  'table')->todo();

it('can replicate records on the edit page on addresses relation manager', function () {
    //
})->group('action',  'edit',  'page',  'relation-manager',  'resource',  'table')->todo();

it('can restore records on the edit page on addresses relation manager', function () {
    //
})->group('action',  'edit',  'page',  'relation-manager',  'resource',  'table')->todo();

it('has the correct URL for table action on the edit page on addresses relation manager', function () {
    //
})->group('action',  'edit',  'page',  'relation-manager',  'resource',  'table')->todo();

it('has the correct URL and opens in a new tab for table action on the edit page on addresses relation manager', function () {
    //
})->group('action',  'edit',  'page',  'relation-manager',  'resource',  'table')->todo();

it('can render action on the edit page on addresses relation manager', function () {
    //
})->group('action',  'edit',  'page',  'relation-manager',  'resource',  'table')->todo();

it('can bulk delete records on the edit page on addresses relation manager', function () {
    //
})->group('bulk-action',  'edit',  'page',  'relation-manager',  'resource',  'table')->todo();

it('can bulk force delete records on the edit page on addresses relation manager', function () {
    //
})->group('bulk-action',  'edit',  'page',  'relation-manager',  'resource',  'table')->todo();

it('can bulk (soft) delete records on the edit page on addresses relation manager', function () {
    //
})->group('bulk-action',  'edit',  'page',  'relation-manager',  'resource',  'table')->todo();

it('has table bulk action on the edit page on addresses relation manager', function () {
    //
})->group('bulk-action',  'edit',  'page',  'relation-manager',  'resource',  'table')->todo();

it('can bulk restore records on the edit page on addresses relation manager', function () {
    //
})->group('bulk-action',  'edit',  'page',  'relation-manager',  'resource',  'table')->todo();

it('has column on the addresses relation manager on the edit page', function (string $column) {
    $ownerRecord = Customer::factory()
        ->hasAddresses(3)
        ->create();

    livewire(App\Filament\Resources\Shop\CustomerResource\RelationManagers\AddressesRelationManager::class, [
        'ownerRecord' => $ownerRecord,
        'pageClass' => \App\Filament\Resources\Shop\CustomerResource\Pages\EditCustomer::class
        ])
        ->assertTableColumnExists($column);
})->with(['street', 'zip', 'city', 'country'])->group('column',  'edit',  'page',  'relation-manager',  'resource',  'table');

it('cannot display trashed records by default on the view page on addresses relation manager', function () {
    //
})->group('page',  'relation-manager',  'resource',  'view')->todo();

it('has header actions on the view page on addresses relation manager', function () {
    //
})->group('header-action',  'page',  'relation-manager',  'resource',  'view')->todo();

it('cannot render header actions on the view page on addresses relation manager', function () {
    //
})->group('header-action',  'page',  'relation-manager',  'resource',  'view')->todo();

it('can render header actions on the view page on addresses relation manager', function () {
    //
})->group('header-action',  'page',  'relation-manager',  'resource',  'view')->todo();

it('can delete records on the view page on addresses relation manager', function () {
    //
})->group('action',  'page',  'relation-manager',  'resource',  'table',  'view')->todo();

it('can force delete records on the view page on addresses relation manager', function () {
    //
})->group('action',  'page',  'relation-manager',  'resource',  'table',  'view')->todo();

it('can soft delete records on the view page on addresses relation manager', function () {
    //
})->group('action',  'page',  'relation-manager',  'resource',  'table',  'view')->todo();

it('has action on the view page on addresses relation manager', function () {
    //
})->group('action',  'page',  'relation-manager',  'resource',  'table',  'view')->todo();

it('cannot render action on the view page on addresses relation manager', function () {
    //
})->group('action',  'page',  'relation-manager',  'resource',  'table',  'view')->todo();

it('can replicate records on the view page on addresses relation manager', function () {
    //
})->group('action',  'page',  'relation-manager',  'resource',  'table',  'view')->todo();

it('can restore records on the view page on addresses relation manager', function () {
    //
})->group('action',  'page',  'relation-manager',  'resource',  'table',  'view')->todo();

it('has the correct URL for table action on the view page on addresses relation manager', function () {
    //
})->group('action',  'page',  'relation-manager',  'resource',  'table',  'view')->todo();

it('has the correct URL and opens in a new tab for table action on the view page on addresses relation manager', function () {
    //
})->group('action',  'page',  'relation-manager',  'resource',  'table',  'view')->todo();

it('can render action on the view page on addresses relation manager', function () {
    //
})->group('action',  'page',  'relation-manager',  'resource',  'table',  'view')->todo();

it('can bulk delete records on the view page on addresses relation manager', function () {
    //
})->group('bulk-action',  'page',  'relation-manager',  'resource',  'table',  'view')->todo();

it('can bulk force delete records on the view page on addresses relation manager', function () {
    //
})->group('bulk-action',  'page',  'relation-manager',  'resource',  'table',  'view')->todo();

it('can bulk (soft) delete records on the view page on addresses relation manager', function () {
    //
})->group('bulk-action',  'page',  'relation-manager',  'resource',  'table',  'view')->todo();

it('has table bulk action on the view page on addresses relation manager', function () {
    //
})->group('bulk-action',  'page',  'relation-manager',  'resource',  'table',  'view')->todo();

it('can bulk restore records on the view page on addresses relation manager', function () {
    //
})->group('bulk-action',  'page',  'relation-manager',  'resource',  'table',  'view')->todo();

it('can render the payments relation manager on the edit page', function () {
    $ownerRecord = Customer::factory()
        ->hasPayments(3)
        ->create();

    livewire(App\Filament\Resources\Shop\CustomerResource\RelationManagers\PaymentsRelationManager::class, [
        'ownerRecord' => $ownerRecord,
        'pageClass' => \App\Filament\Resources\Shop\CustomerResource\Pages\EditCustomer::class
    ])
        ->assertSuccessful();
})->group('edit',  'page',  'relation-manager',  'resource');

it('can list records on the payments relation manager on the edit page', function () {
    $ownerRecord = Customer::factory()
        ->hasPayments(3)
        ->create();

    livewire(App\Filament\Resources\Shop\CustomerResource\RelationManagers\PaymentsRelationManager::class, [
        'ownerRecord' => $ownerRecord,
        'pageClass' => \App\Filament\Resources\Shop\CustomerResource\Pages\EditCustomer::class
    ])
        ->assertCanSeeTableRecords($ownerRecord->payments);
})->group('edit',  'page',  'relation-manager',  'resource');

it('cannot display trashed records by default on the edit page on payments relation manager', function () {
    //
})->group('edit',  'page',  'relation-manager',  'resource')->todo();

it('has header actions on the edit page on payments relation manager', function () {
    //
})->group('edit',  'header-action',  'page',  'relation-manager',  'resource')->todo();

it('cannot render header actions on the edit page on payments relation manager', function () {
    //
})->group('edit',  'header-action',  'page',  'relation-manager',  'resource')->todo();

it('can render header actions on the edit page on payments relation manager', function () {
    //
})->group('edit',  'header-action',  'page',  'relation-manager',  'resource')->todo();

it('can delete records on the edit page on payments relation manager', function () {
    //
})->group('action',  'edit',  'page',  'relation-manager',  'resource',  'table')->todo();

it('can force delete records on the edit page on payments relation manager', function () {
    //
})->group('action',  'edit',  'page',  'relation-manager',  'resource',  'table')->todo();

it('can soft delete records on the edit page on payments relation manager', function () {
    //
})->group('action',  'edit',  'page',  'relation-manager',  'resource',  'table')->todo();

it('has action on the edit page on payments relation manager', function () {
    //
})->group('action',  'edit',  'page',  'relation-manager',  'resource',  'table')->todo();

it('cannot render action on the edit page on payments relation manager', function () {
    //
})->group('action',  'edit',  'page',  'relation-manager',  'resource',  'table')->todo();

it('can replicate records on the edit page on payments relation manager', function () {
    //
})->group('action',  'edit',  'page',  'relation-manager',  'resource',  'table')->todo();

it('can restore records on the edit page on payments relation manager', function () {
    //
})->group('action',  'edit',  'page',  'relation-manager',  'resource',  'table')->todo();

it('has the correct URL for table action on the edit page on payments relation manager', function () {
    //
})->group('action',  'edit',  'page',  'relation-manager',  'resource',  'table')->todo();

it('has the correct URL and opens in a new tab for table action on the edit page on payments relation manager', function () {
    //
})->group('action',  'edit',  'page',  'relation-manager',  'resource',  'table')->todo();

it('can render action on the edit page on payments relation manager', function () {
    //
})->group('action',  'edit',  'page',  'relation-manager',  'resource',  'table')->todo();

it('can bulk delete records on the edit page on payments relation manager', function () {
    //
})->group('bulk-action',  'edit',  'page',  'relation-manager',  'resource',  'table')->todo();

it('can bulk force delete records on the edit page on payments relation manager', function () {
    //
})->group('bulk-action',  'edit',  'page',  'relation-manager',  'resource',  'table')->todo();

it('can bulk (soft) delete records on the edit page on payments relation manager', function () {
    //
})->group('bulk-action',  'edit',  'page',  'relation-manager',  'resource',  'table')->todo();

it('has table bulk action on the edit page on payments relation manager', function () {
    //
})->group('bulk-action',  'edit',  'page',  'relation-manager',  'resource',  'table')->todo();

it('can bulk restore records on the edit page on payments relation manager', function () {
    //
})->group('bulk-action',  'edit',  'page',  'relation-manager',  'resource',  'table')->todo();

it('has column on the payments relation manager on the edit page', function (string $column) {
    $ownerRecord = Customer::factory()
        ->hasPayments(3)
        ->create();

    livewire(App\Filament\Resources\Shop\CustomerResource\RelationManagers\PaymentsRelationManager::class, [
        'ownerRecord' => $ownerRecord,
        'pageClass' => \App\Filament\Resources\Shop\CustomerResource\Pages\EditCustomer::class
        ])
        ->assertTableColumnExists($column);
})->with(['order.number', 'reference', 'amount', 'provider', 'method'])->group('column',  'edit',  'page',  'relation-manager',  'resource',  'table');

it('can search column on the payments relation manager on the edit page', function (string $column) {
    $ownerRecord = Customer::factory()
        ->hasPayments(3)
        ->create();

    $search = data_get($ownerRecord->payments->first(), $column);

    livewire(App\Filament\Resources\Shop\CustomerResource\RelationManagers\PaymentsRelationManager::class, [
        'ownerRecord' => $ownerRecord,
        'pageClass' => \App\Filament\Resources\Shop\CustomerResource\Pages\EditCustomer::class
    ])
    ->searchTable($search instanceof BackedEnum ? $search->value : $search)
    ->assertCanSeeTableRecords($ownerRecord->payments->filter(fn ($record) => data_get($record, $column) == $search));
})->with(['order.number', 'reference'])->group('column',  'edit',  'page',  'relation-manager',  'resource',  'table');

it('can sort column on the payments relation manager on the edit page', function (string $column) {
    $ownerRecord = Customer::factory()
        ->hasPayments(3)
        ->create();

    livewire(App\Filament\Resources\Shop\CustomerResource\RelationManagers\PaymentsRelationManager::class, [
        'ownerRecord' => $ownerRecord,
        'pageClass' => \App\Filament\Resources\Shop\CustomerResource\Pages\EditCustomer::class
    ])
    ->sortTable($column)
    ->assertCanSeeTableRecords(
        $ownerRecord->payments->sortBy(fn ($record) => data_get($record, $column))->values()->all(),
        inOrder: true
    )
    ->sortTable($column, 'desc')
    ->assertCanSeeTableRecords(
        $ownerRecord->payments->sortByDesc(fn ($record) => data_get($record, $column))->values()->all(),
        inOrder: true
    );
})->with(['order.number', 'amount', 'provider', 'method'])->group('column',  'edit',  'page',  'relation-manager',  'resource',  'table');

it('cannot display trashed records by default on the view page on payments relation manager', function () {
    //
})->group('page',  'relation-manager',  'resource',  'view')->todo();

it('has header actions on the view page on payments relation manager', function () {
    //
})->group('header-action',  'page',  'relation-manager',  'resource',  'view')->todo();

it('cannot render header actions on the view page on payments relation manager', function () {
    //
})->group('header-action',  'page',  'relation-manager',  'resource',  'view')->todo();

it('can render header actions on the view page on payments relation manager', function () {
    //
})->group('header-action',  'page',  'relation-manager',  'resource',  'view')->todo();

it('can delete records on the view page on payments relation manager', function () {
    //
})->group('action',  'page',  'relation-manager',  'resource',  'table',  'view')->todo();

it('can force delete records on the view page on payments relation manager', function () {
    //
})->group('action',  'page',  'relation-manager',  'resource',  'table',  'view')->todo();

it('can soft delete records on the view page on payments relation manager', function () {
    //
})->group('action',  'page',  'relation-manager',  'resource',  'table',  'view')->todo();

it('has action on the view page on payments relation manager', function () {
    //
})->group('action',  'page',  'relation-manager',  'resource',  'table',  'view')->todo();

it('cannot render action on the view page on payments relation manager', function () {
    //
})->group('action',  'page',  'relation-manager',  'resource',  'table',  'view')->todo();

it('can replicate records on the view page on payments relation manager', function () {
    //
})->group('action',  'page',  'relation-manager',  'resource',  'table',  'view')->todo();

it('can restore records on the view page on payments relation manager', function () {
    //
})->group('action',  'page',  'relation-manager',  'resource',  'table',  'view')->todo();

it('has the correct URL for table action on the view page on payments relation manager', function () {
    //
})->group('action',  'page',  'relation-manager',  'resource',  'table',  'view')->todo();

it('has the correct URL and opens in a new tab for table action on the view page on payments relation manager', function () {
    //
})->group('action',  'page',  'relation-manager',  'resource',  'table',  'view')->todo();

it('can render action on the view page on payments relation manager', function () {
    //
})->group('action',  'page',  'relation-manager',  'resource',  'table',  'view')->todo();

it('can bulk delete records on the view page on payments relation manager', function () {
    //
})->group('bulk-action',  'page',  'relation-manager',  'resource',  'table',  'view')->todo();

it('can bulk force delete records on the view page on payments relation manager', function () {
    //
})->group('bulk-action',  'page',  'relation-manager',  'resource',  'table',  'view')->todo();

it('can bulk (soft) delete records on the view page on payments relation manager', function () {
    //
})->group('bulk-action',  'page',  'relation-manager',  'resource',  'table',  'view')->todo();

it('has table bulk action on the view page on payments relation manager', function () {
    //
})->group('bulk-action',  'page',  'relation-manager',  'resource',  'table',  'view')->todo();

it('can bulk restore records on the view page on payments relation manager', function () {
    //
})->group('bulk-action',  'page',  'relation-manager',  'resource',  'table',  'view')->todo();

