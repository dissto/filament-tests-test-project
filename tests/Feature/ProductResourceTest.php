<?php

uses()->group('filament-tests');

use App\Models\Shop\Product;
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
    livewire(\App\Filament\Clusters\Products\Resources\ProductResource\Pages\ListProducts::class)
        ->assertSuccessful();
})->group('index',  'page',  'resource');

it('can list records on the index page', function () {
    $records = Product::factory(3)->create();

    livewire(\App\Filament\Clusters\Products\Resources\ProductResource\Pages\ListProducts::class)
        ->assertCanSeeTableRecords($records);
})->group('index',  'page',  'resource');

it('can list records on the index page with pagination', function () {
    $records = Product::factory(20)->create();

    livewire(\App\Filament\Clusters\Products\Resources\ProductResource\Pages\ListProducts::class)
        ->call('gotoPage', 2)
        ->assertCanSeeTableRecords($records->skip(10));
})->group('index',  'page',  'resource');

it('has header actions on the index page', function (string $action) {
    livewire(\App\Filament\Clusters\Products\Resources\ProductResource\Pages\ListProducts::class)
        ->assertActionExists($action);
})->with(['create'])->group('action',  'index',  'page',  'resource');

it('can render header actions on the index page', function (string $action) {
    livewire(\App\Filament\Clusters\Products\Resources\ProductResource\Pages\ListProducts::class)
        ->assertActionVisible($action);
})->with(['create'])->group('action',  'index',  'page',  'resource');

it('has table action', function (string $action) {
    livewire(\App\Filament\Clusters\Products\Resources\ProductResource\Pages\ListProducts::class)
        ->assertTableActionExists($action);
})->with(["edit"])->group('action',  'index',  'page',  'resource',  'table');

it('has column', function (string $column) {
    livewire(\App\Filament\Clusters\Products\Resources\ProductResource\Pages\ListProducts::class)
        ->assertTableColumnExists($column);
})->with(['product-image', 'name', 'brand.name', 'is_visible', 'price', 'sku', 'qty', 'security_stock', 'published_at'])->group('column',  'index',  'page',  'resource',  'table');

it('can render column', function (string $column) {
    livewire(\App\Filament\Clusters\Products\Resources\ProductResource\Pages\ListProducts::class)
        ->assertCanRenderTableColumn($column);
})->with(['product-image', 'name', 'brand.name', 'is_visible', 'price', 'sku', 'qty'])->group('column',  'index',  'page',  'resource',  'table');

it('cannot render column', function (string $column) {
    livewire(\App\Filament\Clusters\Products\Resources\ProductResource\Pages\ListProducts::class)
        ->assertCanNotRenderTableColumn($column);
})->with(['security_stock', 'published_at'])->group('column',  'index',  'page',  'resource',  'table');

it('can sort column', function (string $column) {
    $records = Product::factory(3)->create();

    livewire(\App\Filament\Clusters\Products\Resources\ProductResource\Pages\ListProducts::class)
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
})->with(['name', 'brand.name', 'is_visible', 'price', 'sku', 'qty', 'security_stock', 'published_at'])->group('column',  'index',  'page',  'resource',  'table');

it('can search column on the index page', function (string $column) {
    $records = Product::factory(3)->create();

    $search = data_get($records->first(), $column);

    livewire(\App\Filament\Clusters\Products\Resources\ProductResource\Pages\ListProducts::class)
        ->searchTable($search instanceof BackedEnum ? $search->value : $search)
        ->assertCanSeeTableRecords($records->filter(fn ($record) => data_get($record, $column) == $search));
})->with(['name', 'brand.name', 'price', 'sku', 'qty', 'security_stock'])->group('column',  'index',  'page',  'resource',  'table');
it('can reset table filters', function () {
    $records = Product::factory(3)->create();

    livewire(\App\Filament\Clusters\Products\Resources\ProductResource\Pages\ListProducts::class)
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
    livewire(\App\Filament\Clusters\Products\Resources\ProductResource\Pages\CreateProduct::class)
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

it('has a disabled field on create form', function (string $field) {
    livewire(\App\Filament\Clusters\Products\Resources\ProductResource\Pages\CreateProduct::class)
        ->assertFormFieldIsDisabled($field);
})->with(['slug'])->group('create',  'field',  'form',  'page',  'resource');

it('has a field on create form', function (string $field) {
    livewire(\App\Filament\Clusters\Products\Resources\ProductResource\Pages\CreateProduct::class)
        ->assertFormFieldExists($field);
})->with(['name', 'slug', 'description', 'media', 'price', 'old_price', 'cost', 'sku', 'barcode', 'qty', 'security_stock', 'backorder', 'requires_shipping', 'is_visible', 'published_at', 'shop_brand_id', 'categories'])->group('create',  'field',  'form',  'page',  'resource');

it('can validate input on create form', function () {
    //
})->group('create',  'field',  'form',  'page',  'resource')->todo();

it('has create form', function () {
    livewire(\App\Filament\Clusters\Products\Resources\ProductResource\Pages\CreateProduct::class)
        ->assertFormExists();
})->group('create',  'form',  'page',  'resource');

it('can render form on the create page', function () {
    //
})->group('create',  'form',  'page',  'resource')->todo();

it('can validate create form input', function () {
    //
})->group('create',  'form',  'page',  'resource')->todo();

it('can render the edit page', function () {
    $record = Product::factory()->create();

    livewire(\App\Filament\Clusters\Products\Resources\ProductResource\Pages\EditProduct::class, ['record' => $record->getRouteKey()])
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

it('has a disabled field on edit form', function (string $field) {
    $record = Product::factory()->create();

    livewire(\App\Filament\Clusters\Products\Resources\ProductResource\Pages\EditProduct::class, ['record' => $record->getRouteKey()])
        ->assertFormFieldIsDisabled($field);
})->with(['slug'])->group('edit',  'field',  'form',  'page',  'resource');

it('has a field on edit form', function (string $field) {
    $record = Product::factory()->create();

    livewire(\App\Filament\Clusters\Products\Resources\ProductResource\Pages\EditProduct::class, ['record' => $record->getRouteKey()])
        ->assertFormFieldExists($field);
})->with(['name', 'slug', 'description', 'media', 'price', 'old_price', 'cost', 'sku', 'barcode', 'qty', 'security_stock', 'backorder', 'requires_shipping', 'is_visible', 'published_at', 'shop_brand_id', 'categories'])->group('edit',  'field',  'form',  'page',  'resource');

it('can validate input on edit form', function () {
    //
})->group('edit',  'field',  'form',  'page',  'resource')->todo();

it('has edit form', function () {
    $record = Product::factory()->create();

    livewire(\App\Filament\Clusters\Products\Resources\ProductResource\Pages\EditProduct::class, ['record' => $record->getRouteKey()])
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

it('can render the comments relation manager on the edit page', function () {
    $ownerRecord = Product::factory()
        ->hasComments(3)
        ->create();

    livewire(App\Filament\Clusters\Products\Resources\ProductResource\RelationManagers\CommentsRelationManager::class, [
        'ownerRecord' => $ownerRecord,
        'pageClass' => \App\Filament\Clusters\Products\Resources\ProductResource\Pages\EditProduct::class
    ])
        ->assertSuccessful();
})->group('edit',  'page',  'relation-manager',  'resource');

it('can list records on the comments relation manager on the edit page', function () {
    $ownerRecord = Product::factory()
        ->hasComments(3)
        ->create();

    livewire(App\Filament\Clusters\Products\Resources\ProductResource\RelationManagers\CommentsRelationManager::class, [
        'ownerRecord' => $ownerRecord,
        'pageClass' => \App\Filament\Clusters\Products\Resources\ProductResource\Pages\EditProduct::class
    ])
        ->assertCanSeeTableRecords($ownerRecord->comments);
})->group('edit',  'page',  'relation-manager',  'resource');

it('cannot display trashed records by default on the edit page on comments relation manager', function () {
    //
})->group('edit',  'page',  'relation-manager',  'resource')->todo();

it('has header actions on the edit page on comments relation manager', function () {
    //
})->group('edit',  'header-action',  'page',  'relation-manager',  'resource')->todo();

it('cannot render header actions on the edit page on comments relation manager', function () {
    //
})->group('edit',  'header-action',  'page',  'relation-manager',  'resource')->todo();

it('can render header actions on the edit page on comments relation manager', function () {
    //
})->group('edit',  'header-action',  'page',  'relation-manager',  'resource')->todo();

it('can delete records on the edit page on comments relation manager', function () {
    //
})->group('action',  'edit',  'page',  'relation-manager',  'resource',  'table')->todo();

it('can force delete records on the edit page on comments relation manager', function () {
    //
})->group('action',  'edit',  'page',  'relation-manager',  'resource',  'table')->todo();

it('can soft delete records on the edit page on comments relation manager', function () {
    //
})->group('action',  'edit',  'page',  'relation-manager',  'resource',  'table')->todo();

it('has action on the edit page on comments relation manager', function () {
    //
})->group('action',  'edit',  'page',  'relation-manager',  'resource',  'table')->todo();

it('cannot render action on the edit page on comments relation manager', function () {
    //
})->group('action',  'edit',  'page',  'relation-manager',  'resource',  'table')->todo();

it('can replicate records on the edit page on comments relation manager', function () {
    //
})->group('action',  'edit',  'page',  'relation-manager',  'resource',  'table')->todo();

it('can restore records on the edit page on comments relation manager', function () {
    //
})->group('action',  'edit',  'page',  'relation-manager',  'resource',  'table')->todo();

it('has the correct URL for table action on the edit page on comments relation manager', function () {
    //
})->group('action',  'edit',  'page',  'relation-manager',  'resource',  'table')->todo();

it('has the correct URL and opens in a new tab for table action on the edit page on comments relation manager', function () {
    //
})->group('action',  'edit',  'page',  'relation-manager',  'resource',  'table')->todo();

it('can render action on the edit page on comments relation manager', function () {
    //
})->group('action',  'edit',  'page',  'relation-manager',  'resource',  'table')->todo();

it('can bulk delete records on the edit page on comments relation manager', function () {
    //
})->group('bulk-action',  'edit',  'page',  'relation-manager',  'resource',  'table')->todo();

it('can bulk force delete records on the edit page on comments relation manager', function () {
    //
})->group('bulk-action',  'edit',  'page',  'relation-manager',  'resource',  'table')->todo();

it('can bulk (soft) delete records on the edit page on comments relation manager', function () {
    //
})->group('bulk-action',  'edit',  'page',  'relation-manager',  'resource',  'table')->todo();

it('has table bulk action on the edit page on comments relation manager', function () {
    //
})->group('bulk-action',  'edit',  'page',  'relation-manager',  'resource',  'table')->todo();

it('can bulk restore records on the edit page on comments relation manager', function () {
    //
})->group('bulk-action',  'edit',  'page',  'relation-manager',  'resource',  'table')->todo();

it('has column on the comments relation manager on the edit page', function (string $column) {
    $ownerRecord = Product::factory()
        ->hasComments(3)
        ->create();

    livewire(App\Filament\Clusters\Products\Resources\ProductResource\RelationManagers\CommentsRelationManager::class, [
        'ownerRecord' => $ownerRecord,
        'pageClass' => \App\Filament\Clusters\Products\Resources\ProductResource\Pages\EditProduct::class
        ])
        ->assertTableColumnExists($column);
})->with(['title', 'customer.name', 'is_visible'])->group('column',  'edit',  'page',  'relation-manager',  'resource',  'table');

it('can search column on the comments relation manager on the edit page', function (string $column) {
    $ownerRecord = Product::factory()
        ->hasComments(3)
        ->create();

    $search = data_get($ownerRecord->comments->first(), $column);

    livewire(App\Filament\Clusters\Products\Resources\ProductResource\RelationManagers\CommentsRelationManager::class, [
        'ownerRecord' => $ownerRecord,
        'pageClass' => \App\Filament\Clusters\Products\Resources\ProductResource\Pages\EditProduct::class
    ])
    ->searchTable($search instanceof BackedEnum ? $search->value : $search)
    ->assertCanSeeTableRecords($ownerRecord->comments->filter(fn ($record) => data_get($record, $column) == $search));
})->with(['title', 'customer.name'])->group('column',  'edit',  'page',  'relation-manager',  'resource',  'table');

it('can sort column on the comments relation manager on the edit page', function (string $column) {
    $ownerRecord = Product::factory()
        ->hasComments(3)
        ->create();

    livewire(App\Filament\Clusters\Products\Resources\ProductResource\RelationManagers\CommentsRelationManager::class, [
        'ownerRecord' => $ownerRecord,
        'pageClass' => \App\Filament\Clusters\Products\Resources\ProductResource\Pages\EditProduct::class
    ])
    ->sortTable($column)
    ->assertCanSeeTableRecords(
        $ownerRecord->comments->sortBy(fn ($record) => data_get($record, $column))->values()->all(),
        inOrder: true
    )
    ->sortTable($column, 'desc')
    ->assertCanSeeTableRecords(
        $ownerRecord->comments->sortByDesc(fn ($record) => data_get($record, $column))->values()->all(),
        inOrder: true
    );
})->with(['title', 'customer.name', 'is_visible'])->group('column',  'edit',  'page',  'relation-manager',  'resource',  'table');

it('cannot display trashed records by default on the view page on comments relation manager', function () {
    //
})->group('page',  'relation-manager',  'resource',  'view')->todo();

it('has header actions on the view page on comments relation manager', function () {
    //
})->group('header-action',  'page',  'relation-manager',  'resource',  'view')->todo();

it('cannot render header actions on the view page on comments relation manager', function () {
    //
})->group('header-action',  'page',  'relation-manager',  'resource',  'view')->todo();

it('can render header actions on the view page on comments relation manager', function () {
    //
})->group('header-action',  'page',  'relation-manager',  'resource',  'view')->todo();

it('can delete records on the view page on comments relation manager', function () {
    //
})->group('action',  'page',  'relation-manager',  'resource',  'table',  'view')->todo();

it('can force delete records on the view page on comments relation manager', function () {
    //
})->group('action',  'page',  'relation-manager',  'resource',  'table',  'view')->todo();

it('can soft delete records on the view page on comments relation manager', function () {
    //
})->group('action',  'page',  'relation-manager',  'resource',  'table',  'view')->todo();

it('has action on the view page on comments relation manager', function () {
    //
})->group('action',  'page',  'relation-manager',  'resource',  'table',  'view')->todo();

it('cannot render action on the view page on comments relation manager', function () {
    //
})->group('action',  'page',  'relation-manager',  'resource',  'table',  'view')->todo();

it('can replicate records on the view page on comments relation manager', function () {
    //
})->group('action',  'page',  'relation-manager',  'resource',  'table',  'view')->todo();

it('can restore records on the view page on comments relation manager', function () {
    //
})->group('action',  'page',  'relation-manager',  'resource',  'table',  'view')->todo();

it('has the correct URL for table action on the view page on comments relation manager', function () {
    //
})->group('action',  'page',  'relation-manager',  'resource',  'table',  'view')->todo();

it('has the correct URL and opens in a new tab for table action on the view page on comments relation manager', function () {
    //
})->group('action',  'page',  'relation-manager',  'resource',  'table',  'view')->todo();

it('can render action on the view page on comments relation manager', function () {
    //
})->group('action',  'page',  'relation-manager',  'resource',  'table',  'view')->todo();

it('can bulk delete records on the view page on comments relation manager', function () {
    //
})->group('bulk-action',  'page',  'relation-manager',  'resource',  'table',  'view')->todo();

it('can bulk force delete records on the view page on comments relation manager', function () {
    //
})->group('bulk-action',  'page',  'relation-manager',  'resource',  'table',  'view')->todo();

it('can bulk (soft) delete records on the view page on comments relation manager', function () {
    //
})->group('bulk-action',  'page',  'relation-manager',  'resource',  'table',  'view')->todo();

it('has table bulk action on the view page on comments relation manager', function () {
    //
})->group('bulk-action',  'page',  'relation-manager',  'resource',  'table',  'view')->todo();

it('can bulk restore records on the view page on comments relation manager', function () {
    //
})->group('bulk-action',  'page',  'relation-manager',  'resource',  'table',  'view')->todo();

