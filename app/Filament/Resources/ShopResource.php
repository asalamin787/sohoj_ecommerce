<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShopResource\Pages;
use App\Filament\Resources\ShopResource\RelationManagers;
use App\Models\Shop;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class ShopResource extends Resource
{
    protected static ?string $model = Shop::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationLabel = 'Shops';

    protected static ?string $navigationGroup = 'Business';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Shop Details')
                ->icon('heroicon-o-shopping-bag')
                ->description('Basic information about the shop')
                ->schema([
                    Forms\Components\Grid::make(2)
                        ->schema([
                            TextInput::make('name')
                                ->label('Shop Name')
                                ->required()
                                ->maxLength(255)
                                ->placeholder('Enter shop name')
                                ->reactive()
                                ->afterStateUpdated(fn(string $state, callable $set) => $set('slug', Str::slug($state))),
                            Select::make('user_id')
                                ->label('Owner')
                                ->relationship('user', 'name')
                                ->searchable()
                                ->required(),
                            TextInput::make('slug')
                                ->label('Slug')
                                ->nullable()
                                ->unique(Shop::class, 'slug', ignoreRecord: true)
                                ->maxLength(255)
                                ->placeholder('Auto-generated from name'),
                            TextInput::make('email')
                                ->label('Email')
                                ->email()
                                ->required()
                                ->maxLength(255)
                                ->placeholder('shop@email.com'),
                            TextInput::make('phone')
                                ->label('Phone')
                                ->required()
                                ->maxLength(20)
                                ->placeholder('e.g. +8801XXXXXXXXX'),
                        ]),
                ]),
            Forms\Components\Section::make('Media')
                ->icon('heroicon-o-photo')
                ->description('Shop logo and banner')
                ->schema([
                    Forms\Components\Grid::make(2)
                        ->schema([
                            FileUpload::make('logo')
                                ->label('Logo')
                                ->image()
                                ->directory('shops/logos')
                                ->imagePreviewHeight('80')
                                ->nullable(),
                            FileUpload::make('banner')
                                ->label('Banner')
                                ->image()
                                ->directory('shops/banners')
                                ->imagePreviewHeight('80')
                                ->nullable(),
                        ]),
                ]),
            Forms\Components\Section::make('Descriptions')
                ->icon('heroicon-o-document-text')
                ->description('Detailed and short descriptions')
                ->schema([
                    Textarea::make('description')
                        ->label('Description')
                        ->required()
                        ->rows(3)
                        ->placeholder('Full shop description'),
                    Textarea::make('short_description')
                        ->label('Short Description')
                        ->required()
                        ->rows(2)
                        ->placeholder('Short summary for listings'),
                    TagsInput::make('tags')
                        ->label('Tags')
                        ->required()
                        ->placeholder('Add tags'),
                    RichEditor::make('terms')
                        ->label('Terms & Conditions')
                        ->nullable(),
                ]),
            Forms\Components\Section::make('Company Information')
                ->icon('heroicon-o-building-office')
                ->description('Legal and company details')
                ->schema([
                    Forms\Components\Grid::make(2)
                        ->schema([
                            TextInput::make('company_name')
                                ->label('Company Name')
                                ->required()
                                ->maxLength(255),
                            TextInput::make('company_registration')
                                ->label('Registration No.')
                                ->required()
                                ->maxLength(255),
                        ]),
                ]),
            Forms\Components\Section::make('Location')
                ->icon('heroicon-o-map-pin')
                ->description('Shop address details')
                ->schema([
                    Forms\Components\Grid::make(2)
                        ->schema([
                            TextInput::make('city')
                                ->label('City')
                                ->required()
                                ->maxLength(100),
                            TextInput::make('state')
                                ->label('State')
                                ->required()
                                ->maxLength(100),
                            TextInput::make('post_code')
                                ->label('Post Code')
                                ->nullable()
                                ->maxLength(20),
                            TextInput::make('country')
                                ->label('Country')
                                ->required()
                                ->maxLength(100),
                        ]),
                ]),
            Forms\Components\Section::make('Status')
                ->icon('heroicon-o-check-circle')
                ->description('Shop activation status')
                ->schema([
                    Toggle::make('status')
                        ->label('Active')
                        ->default(false)
                        ->helperText('Toggle to activate or deactivate this shop.'),
                ]),
        ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')
                    ->label('Logo')
                    ->circular()
                    ->size(48)
                    ->toggleable(),
                ImageColumn::make('banner')
                    ->label('Banner')
                    ->size(64)
                    ->toggleable(),
                TextColumn::make('name')
                    ->label('Shop Name')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('primary')
                    ->toggleable(),
                TextColumn::make('user.name')
                    ->label('Owner')
                    ->icon('heroicon-o-user')
                    ->toggleable(),
                TextColumn::make('slug')
                    ->label('Slug')
                    ->toggleable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->icon('heroicon-o-envelope')
                    ->toggleable(),
                TextColumn::make('phone')
                    ->label('Phone')
                    ->icon('heroicon-o-phone')
                    ->toggleable(),
                TextColumn::make('company_name')
                    ->label('Company Name')
                    ->toggleable(),
                TextColumn::make('company_registration')
                    ->label('Registration No.')
                    ->toggleable(),
                TextColumn::make('city')
                    ->label('City')
                    ->toggleable(),
                TextColumn::make('state')
                    ->label('State')
                    ->toggleable(),
                TextColumn::make('post_code')
                    ->label('Post Code')
                    ->toggleable(),
                TextColumn::make('country')
                    ->label('Country')
                    ->badge()
                    ->color('success')
                    ->toggleable(),
                TagsColumn::make('tags')
                    ->label('Tags')
                    ->toggleable(),
                BooleanColumn::make('status')
                    ->label('Active')
                    ->icon('heroicon-o-check-circle')
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->date('F j, Y')
                    ->icon('heroicon-o-calendar-days')
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('active')
                    ->label('Active Shops')
                    ->query(fn(Builder $query): Builder => $query->where('status', true)),
                Tables\Filters\Filter::make('inactive')
                    ->label('Inactive Shops')
                    ->query(fn(Builder $query): Builder => $query->where('status', false)),
                Tables\Filters\Filter::make('created_at')
                    ->label('Created Date')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')->label('From'),
                        Forms\Components\DatePicker::make('created_until')->label('Until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['created_from'], fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date))
                            ->when($data['created_until'], fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date));
                    }),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->label('Edit')
                        ->icon('heroicon-o-pencil-square'),
                    Tables\Actions\DeleteAction::make()
                        ->label('Delete')
                        ->icon('heroicon-o-trash'),
                    Tables\Actions\Action::make('toggleStatus')
                        ->label(fn ($record) => $record->status ? 'Deactivate' : 'Activate')
                        ->icon(fn ($record) => $record->status ? 'heroicon-o-x-circle' : 'heroicon-o-check-circle')
                        ->color(fn ($record) => $record->status ? 'danger' : 'success')
                        ->action(function ($record) {
                            $record->status = $record->status ? 0 : 1;
                            $record->save();
                        })
                        ->requiresConfirmation(),
                ])->iconButton(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListShops::route('/'),
            'create' => Pages\CreateShop::route('/create'),
            'edit' => Pages\EditShop::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::$model::count();
    }
}
