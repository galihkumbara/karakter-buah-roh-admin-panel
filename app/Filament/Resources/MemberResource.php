<?php

namespace App\Filament\Resources;

use App\Filament\Exports\MemberExporter;
use App\Filament\Resources\MemberResource\Pages;
use App\Filament\Resources\MemberResource\RelationManagers;
use App\Filament\Resources\MemberResource\RelationManagers\ModulesRelationManager;
use App\Http\Controllers\ExportController;
use App\Models\Member;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;
use Spatie\EloquentSortable\SortableTrait;
class MemberResource extends Resource
{
    
    protected static ?string $model = Member::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $label = 'Pengguna';
    protected static ?string $navigationGroup = 'Institusi & Pengguna';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label('Nama Pengguna')
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->label('Email')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('password')
                    
                    ->password()
                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('profile_picture_url')
                    ->label('Foto Profil'),
                Forms\Components\DateTimePicker::make('birthdate')
                    ->label('Tanggal Lahir'),
                Forms\Components\RichEditor::make('address')
                    ->columnSpanFull(),
                Forms\Components\Select::make('institution_id')
                    ->label('Institusi')
                    ->relationship('institution', 'name'),
                Forms\Components\Select::make('education_id')
                    ->relationship('education', 'name')
                    ->label('Pendidikan Terakhir'),
                Forms\Components\Select::make('religion_id')
                    ->label('Agama')
                    ->relationship('religion', 'name'),
                Forms\Components\Select::make('ethnic_id')
                    ->label('Suku Bangsa')
                    ->relationship('ethnic', 'name'),
                    
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Pengguna')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
 
                Tables\Columns\TextColumn::make('birthdate')
                    ->date()
                    ->label('Tanggal Lahir')
                    ->sortable(),
                Tables\Columns\TextColumn::make('institution.name')
                    ->searchable()
                    ->label('Institusi'),
                Tables\Columns\TextColumn::make('education.name')
                    ->searchable()
                    ->label('Pendidikan Terakhir'),
                Tables\Columns\TextColumn::make('religion.name')
                    ->label('Agama')
                    ->searchable(),
                 
                Tables\Columns\TextColumn::make('ethnic.name')
                    ->label('Suku Bangsa')
                    ->searchable(),
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
                SelectFilter::make('Institusi')->relationship('institution', 'name'),
                SelectFilter::make('Pendidikan Terakhir')->relationship('education', 'name'),
                SelectFilter::make('Agama')->relationship('religion', 'name'),
                SelectFilter::make('Suku')->relationship('ethnic', 'name')
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('Export')
                        ->action(fn(Collection $records) => ExportController::exportModulesData($records)) 
                    
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ModulesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMembers::route('/'),
            'create' => Pages\CreateMember::route('/create'),
            'edit' => Pages\EditMember::route('/{record}/edit'),
        ];
    }
}
