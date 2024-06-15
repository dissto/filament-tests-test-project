<?php

uses()->group('filament-tests');

use App\Models\Blog\Author;
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
    livewire(\App\Filament\Resources\Blog\AuthorResource\Pages\ManageAuthors::class)
        ->assertSuccessful();
})->group('index',  'page',  'resource');

it('can list records on the index page', function () {
    $records = Author::factory(3)->create();

    livewire(\App\Filament\Resources\Blog\AuthorResource\Pages\ManageAuthors::class)
        ->assertCanSeeTableRecords($records);
})->group('index',  'page',  'resource');

it('can list records on the index page with pagination', function () {
    $records = Author::factory(20)->create();

    livewire(\App\Filament\Resources\Blog\AuthorResource\Pages\ManageAuthors::class)
        ->call('gotoPage', 2)
        ->assertCanSeeTableRecords($records->skip(10));
})->group('index',  'page',  'resource');

it('has header actions on the index page', function (string $action) {
    livewire(\App\Filament\Resources\Blog\AuthorResource\Pages\ManageAuthors::class)
        ->assertActionExists($action);
})->with(['export', 'create'])->group('action',  'index',  'page',  'resource');

it('can render header actions on the index page', function (string $action) {
    livewire(\App\Filament\Resources\Blog\AuthorResource\Pages\ManageAuthors::class)
        ->assertActionVisible($action);
})->with(['export', 'create'])->group('action',  'index',  'page',  'resource');

it('has table action', function (string $action) {
    livewire(\App\Filament\Resources\Blog\AuthorResource\Pages\ManageAuthors::class)
        ->assertTableActionExists($action);
})->with(["edit","delete"])->group('action',  'index',  'page',  'resource',  'table');

it('can delete records', function () {
    $record = Author::factory()->create();

    livewire(\App\Filament\Resources\Blog\AuthorResource\Pages\ManageAuthors::class)
        ->callTableAction(DeleteAction::class, $record);

    $this->assertModelMissing($record);
})->group('action',  'index',  'page',  'resource',  'table');

it('has column', function (string $column) {
    livewire(\App\Filament\Resources\Blog\AuthorResource\Pages\ManageAuthors::class)
        ->assertTableColumnExists($column);
})->with(['name', 'email', 'github_handle', 'twitter_handle'])->group('column',  'index',  'page',  'resource',  'table');

it('can render column', function (string $column) {
    livewire(\App\Filament\Resources\Blog\AuthorResource\Pages\ManageAuthors::class)
        ->assertCanRenderTableColumn($column);
})->with(['name', 'email', 'github_handle', 'twitter_handle'])->group('column',  'index',  'page',  'resource',  'table');

it('can sort column', function (string $column) {
    $records = Author::factory(3)->create();

    livewire(\App\Filament\Resources\Blog\AuthorResource\Pages\ManageAuthors::class)
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
})->with(['name', 'email'])->group('column',  'index',  'page',  'resource',  'table');

it('can search column on the index page', function (string $column) {
    $records = Author::factory(3)->create();

    $search = data_get($records->first(), $column);

    livewire(\App\Filament\Resources\Blog\AuthorResource\Pages\ManageAuthors::class)
        ->searchTable($search instanceof BackedEnum ? $search->value : $search)
        ->assertCanSeeTableRecords($records->filter(fn ($record) => data_get($record, $column) == $search));
})->with(['name', 'email'])->group('column',  'index',  'page',  'resource',  'table');
it('can render footer widgets on the index page', function () {
    //
})->group('index',  'page',  'resource',  'widget')->todo();

it('can render header widgets on the index page', function () {
    //
})->group('index',  'page',  'resource',  'widget')->todo();

it('can render action on the create page', function () {
    //
})->group('action',  'create',  'page',  'resource')->todo();

it('can render footer widgets on the create page', function () {
    //
})->group('create',  'page',  'resource',  'widget')->todo();

it('can render header widgets on the create page', function () {
    //
})->group('create',  'page',  'resource',  'widget')->todo();

it('can validate input on create form', function () {
    //
})->group('create',  'field',  'form',  'page',  'resource')->todo();

it('can render form on the create page', function () {
    //
})->group('create',  'form',  'page',  'resource')->todo();

it('can validate create form input', function () {
    //
})->group('create',  'form',  'page',  'resource')->todo();

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

it('can validate input on edit form', function () {
    //
})->group('edit',  'field',  'form',  'page',  'resource')->todo();

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

