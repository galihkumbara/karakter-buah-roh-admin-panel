<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ModuleResource\Pages;
use App\Filament\Resources\ModuleResource\RelationManagers;
use App\Filament\Resources\ModuleResource\RelationManagers\CharactersRelationManager;
use App\Models\Module;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Guava\FilamentNestedResources\Ancestor;
use Guava\FilamentNestedResources\Concerns\NestedResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

use function Filament\Support\format_money;

class ModuleResource extends Resource
{
    use NestedResource;
    protected static ?string $model = Module::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $label = 'Modul';
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label('Nama Modul')
                    ->maxLength(255),
                Forms\Components\Select::make('is_active')
                    ->label('Status')
                    ->options([
                        1 => 'Aktif',
                        0 => 'Tidak Aktif',
                    ]),
                Forms\Components\ColorPicker::make('color')
                    ->required()
                    ->label('Warna')
                    ->default('#000000'),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->label('Harga')
                    ->prefix('Rp'),
            ]);
    }

    
    public static function getAncestor(): ?Ancestor
    {
        return null;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->label('Nama Modul'),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->alignCenter()
                    ->label('Status'),
                Tables\Columns\ColorColumn::make('color')
                    ->label('Warna')
                    ->alignCenter()
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->money()
                    ->formatStateUsing(function ($state) {
                        return Str::replace('IDR', 'Rp', format_money($state, 'IDR'));
                    })
                    ->label('Harga')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Terakhir Diubah')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Filter::make('Aktif')->query(fn (Builder $query) => $query->where('is_active', true)),
                
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->reorderable('order_number')
            ->defaultSort('order_number');
    }

    public static function getRelations(): array
    {
        return [
            CharactersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListModules::route('/'),
            'create' => Pages\CreateModule::route('/create'),
            'edit' => Pages\EditModule::route('/{record}/edit'),
            'characters.create' => Pages\CreateModulesCharacter::route('/{record}/albums/create'),
        ];
    }
}
