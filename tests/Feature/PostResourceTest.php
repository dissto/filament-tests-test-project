<?php

uses()->group('filament-tests');

use App\Models\Blog\Post;
use App\Models\User;
use Filament\Tables\Actions\DeleteAction;

use function Pest\Laravel\{actingAs};
use function Pest\Livewire\livewire;

beforeEach(function () {
    actingAs(User::factory()->create());
});

it('can register', function () {
    //
})->group('auth', 'page', 'registration')->todo();

it('can reset the password', function () {
    //
})->group('auth', 'page', 'password-reset')->todo();

it('can login', function () {
    //
})->group('auth', 'login', 'page')->todo();

it('can logout', function () {
    //
})->group('auth', 'logout', 'page')->todo();

it('can render the index page', function () {
    livewire(\App\Filament\Resources\Blog\PostResource\Pages\ListPosts::class)
        ->assertSuccessful();
})->group('index', 'page', 'resource');

it('can list records on the index page', function () {
    $records = Post::factory(3)->create();

    livewire(\App\Filament\Resources\Blog\PostResource\Pages\ListPosts::class)
        ->assertCanSeeTableRecords($records);
})->group('index', 'page', 'resource');

it('can list records on the index page with pagination', function () {
    $records = Post::factory(20)->create();

    livewire(\App\Filament\Resources\Blog\PostResource\Pages\ListPosts::class)
        ->call('gotoPage', 2)
        ->assertCanSeeTableRecords($records->skip(10));
})->group('index', 'page', 'resource');

it('has header actions on the index page', function (string $action) {
    livewire(\App\Filament\Resources\Blog\PostResource\Pages\ListPosts::class)
        ->assertActionExists($action);
})->with(['create'])->group('action', 'index', 'page', 'resource');

it('can render header actions on the index page', function (string $action) {
    livewire(\App\Filament\Resources\Blog\PostResource\Pages\ListPosts::class)
        ->assertActionVisible($action);
})->with(['create'])->group('action', 'index', 'page', 'resource');

it('has table action', function (string $action) {
    livewire(\App\Filament\Resources\Blog\PostResource\Pages\ListPosts::class)
        ->assertTableActionExists($action);
})->with(['view', 'edit', 'delete'])->group('action', 'index', 'page', 'resource', 'table');

it('can delete records', function () {
    $record = Post::factory()->create();

    livewire(\App\Filament\Resources\Blog\PostResource\Pages\ListPosts::class)
        ->callTableAction(DeleteAction::class, $record);

    $this->assertModelMissing($record);
})->group('action', 'index', 'page', 'resource', 'table');

it('has column', function (string $column) {
    livewire(\App\Filament\Resources\Blog\PostResource\Pages\ListPosts::class)
        ->assertTableColumnExists($column);
})->with(['image', 'title', 'slug', 'author.name', 'status', 'category.name', 'published_at', 'comments.customer.name'])->group('column', 'index', 'page', 'resource', 'table');

it('can render column', function (string $column) {
    livewire(\App\Filament\Resources\Blog\PostResource\Pages\ListPosts::class)
        ->assertCanRenderTableColumn($column);
})->with(['image', 'title', 'author.name', 'status', 'published_at', 'comments.customer.name'])->group('column', 'index', 'page', 'resource', 'table');

it('cannot render column', function (string $column) {
    livewire(\App\Filament\Resources\Blog\PostResource\Pages\ListPosts::class)
        ->assertCanNotRenderTableColumn($column);
})->with(['slug', 'category.name'])->group('column', 'index', 'page', 'resource', 'table');

it('can sort column', function (string $column) {
    $records = Post::factory(3)->create();

    livewire(\App\Filament\Resources\Blog\PostResource\Pages\ListPosts::class)
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
})->with(['title', 'slug', 'author.name', 'category.name'])->group('column', 'index', 'page', 'resource', 'table');

it('can search column on the index page', function (string $column) {
    $records = Post::factory(3)->create();

    $search = data_get($records->first(), $column);

    livewire(\App\Filament\Resources\Blog\PostResource\Pages\ListPosts::class)
        ->searchTable($search instanceof BackedEnum ? $search->value : $search)
        ->assertCanSeeTableRecords($records->filter(fn ($record) => data_get($record, $column) == $search));
})->with(['title', 'slug', 'author.name', 'category.name'])->group('column', 'index', 'page', 'resource', 'table');
it('can reset table filters', function () {
    $records = Post::factory(3)->create();

    livewire(\App\Filament\Resources\Blog\PostResource\Pages\ListPosts::class)
        ->resetTableFilters()
        ->assertCanSeeTableRecords($records);
})->group('filter', 'index', 'page', 'resource', 'table');

it('can add a table filter', function () {
    //
})->group('filter', 'index', 'page', 'resource', 'table')->todo();

it('can remove a table filter', function () {
    //
})->group('filter', 'index', 'page', 'resource', 'table')->todo();

it('can render footer widgets on the index page', function () {
    //
})->group('index', 'page', 'resource', 'widget')->todo();

it('can render header widgets on the index page', function () {
    //
})->group('index', 'page', 'resource', 'widget')->todo();

it('can render the create page', function () {
    livewire(\App\Filament\Resources\Blog\PostResource\Pages\CreatePost::class)
        ->assertSuccessful();
})->group('create', 'page', 'resource');

it('can render action on the create page', function () {
    //
})->group('action', 'create', 'page', 'resource')->todo();

it('can render footer widgets on the create page', function () {
    //
})->group('create', 'page', 'resource', 'widget')->todo();

it('can render header widgets on the create page', function () {
    //
})->group('create', 'page', 'resource', 'widget')->todo();

it('has a disabled field on create form', function (string $field) {
    livewire(\App\Filament\Resources\Blog\PostResource\Pages\CreatePost::class)
        ->assertFormFieldIsDisabled($field);
})->with(['slug'])->group('create', 'field', 'form', 'page', 'resource');

it('has a field on create form', function (string $field) {
    livewire(\App\Filament\Resources\Blog\PostResource\Pages\CreatePost::class)
        ->assertFormFieldExists($field);
})->with(['title', 'slug', 'content', 'blog_author_id', 'blog_category_id', 'published_at', 'tags', 'image'])->group('create', 'field', 'form', 'page', 'resource');

it('can validate input on create form', function () {
    //
})->group('create', 'field', 'form', 'page', 'resource')->todo();

it('has create form', function () {
    livewire(\App\Filament\Resources\Blog\PostResource\Pages\CreatePost::class)
        ->assertFormExists();
})->group('create', 'form', 'page', 'resource');

it('can render form on the create page', function () {
    //
})->group('create', 'form', 'page', 'resource')->todo();

it('can validate create form input', function () {
    //
})->group('create', 'form', 'page', 'resource')->todo();

it('can render the edit page', function () {
    $record = Post::factory()->create();

    livewire(\App\Filament\Resources\Blog\PostResource\Pages\EditPost::class, ['record' => $record->getRouteKey()])
        ->assertSuccessful();
})->group('edit', 'page', 'resource');

it('can render action on the edit page', function () {
    //
})->group('action', 'edit', 'page', 'resource')->todo();

it('can render form on the edit page', function () {
    //
})->group('edit', 'form', 'page', 'resource')->todo();

it('can render footer widgets on the edit page', function () {
    //
})->group('edit', 'page', 'resource', 'widget')->todo();

it('can render header widgets on the edit page', function () {
    //
})->group('edit', 'page', 'resource', 'widget')->todo();

it('has a disabled field on edit form', function (string $field) {
    $record = Post::factory()->create();

    livewire(\App\Filament\Resources\Blog\PostResource\Pages\EditPost::class, ['record' => $record->getRouteKey()])
        ->assertFormFieldIsDisabled($field);
})->with(['slug'])->group('edit', 'field', 'form', 'page', 'resource');

it('has a field on edit form', function (string $field) {
    $record = Post::factory()->create();

    livewire(\App\Filament\Resources\Blog\PostResource\Pages\EditPost::class, ['record' => $record->getRouteKey()])
        ->assertFormFieldExists($field);
})->with(['title', 'slug', 'content', 'blog_author_id', 'blog_category_id', 'published_at', 'tags', 'image'])->group('edit', 'field', 'form', 'page', 'resource');

it('can validate input on edit form', function () {
    //
})->group('edit', 'field', 'form', 'page', 'resource')->todo();

it('has edit form', function () {
    $record = Post::factory()->create();

    livewire(\App\Filament\Resources\Blog\PostResource\Pages\EditPost::class, ['record' => $record->getRouteKey()])
        ->assertFormExists();
})->group('edit', 'form', 'page', 'resource');

it('can validate edit form input', function () {
    //
})->group('edit', 'form', 'page', 'resource')->todo();

it('can fill the form on the edit page', function () {
    //
})->group('edit', 'form', 'page', 'resource')->todo();

it('can render the view page', function () {
    $record = Post::factory()->create();

    livewire(\App\Filament\Resources\Blog\PostResource\Pages\ViewPost::class, ['record' => $record->getRouteKey()])
        ->assertSuccessful();
})->group('page', 'resource', 'view');

it('can render action on the view page', function () {
    //
})->group('action', 'page', 'resource', 'view')->todo();

it('can render form on the view page', function () {
    //
})->group('form', 'page', 'resource', 'view')->todo();

it('can render infolist on the view page', function () {
    //
})->group('infolist', 'page', 'resource', 'view')->todo();

it('has action on infolist', function () {
    //
})->group('action', 'infolist', 'page', 'resource', 'view')->todo();

it('can render infolist entry on the view page', function () {
    //
})->group('entry', 'infolist', 'page', 'resource', 'view')->todo();

it('can render footer widgets on the view page', function () {
    //
})->group('page', 'resource', 'view', 'widget')->todo();

it('can render header widgets on the view page', function () {
    //
})->group('page', 'resource', 'view', 'widget')->todo();
