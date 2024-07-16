<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContentResource\Pages;
use App\Filament\Resources\ContentResource\RelationManagers;
use App\Models\Content;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContentResource extends Resource
{
    protected static ?string $model = Content::class;
    protected static ?string $navigationGroup = 'Manajemen Konten';

    protected static ?string $label = 'Artikel/Video';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->label('Judul')
                    ->maxLength(255),
                Forms\Components\RichEditor::make('content')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('writer')
                    ->label('Penulis')
                    ->maxLength(255),
                Forms\Components\Select::make('is_active')
                    ->label('Status')
                    ->options([
                        1 => 'Aktif',
                        0 => 'Tidak Aktif',
                    ])  
                    ->required(),
                    Forms\Components\Select::make('always_show')
                    ->label('Selalu Tampil')
                    ->options([
                        1 => 'Ya',
                        0 => 'Tidak',
                    ])
                    ->default(0)
                    ->live()
                    ->required(),
                Forms\Components\DateTimePicker::make('start_date')
                    ->label('Jadwal Mulai')
                    ->hidden(function (Get $get){
                        return $get('always_show') == 1;
                    })
                    ->required(function (Get $get){
                        return $get('always_show') == 0;
                    }),
                Forms\Components\DateTimePicker::make('end_date')
                    ->label('Jadwal Selesai')
                    ->hidden(function (Get $get){
                        return $get('always_show') == 1;
                    })
                    ->required(function (Get $get){
                        return $get('always_show') == 0;
                    }),
                Forms\Components\TextInput::make('media_url')
                    ->label('URL Media')
                    ->url()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('writer')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('start_date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\IconColumn::make('always_show')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListContents::route('/'),
            'create' => Pages\CreateContent::route('/create'),
            'edit' => Pages\EditContent::route('/{record}/edit'),
        ];
    }
}
