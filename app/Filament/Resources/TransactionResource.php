<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Models\Module;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $label = 'Transaksi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label('Nama Transaksi')
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->label('Deskripsi')
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('proof_of_payment_url')
                    ->label('Bukti Bayar'),
                Forms\Components\Select::make('user_id')
                    ->relationship('user','name')
                    ->label('Admin Penanggung Jawab'),
                
                Forms\Components\Select::make('member_id')
                    ->label('Pengguna')
                    ->required()
                    ->relationship('member','name'),
                Repeater::make('transaction_modules')
                    ->label('Modul yang Ditransaksikan')
                    ->relationship('transaction_modules')
                    ->schema([
                        Forms\Components\Select::make('module_id')
                            ->relationship('module','name')
                            ->label('Modul')
                            ->live()
                            ->required(),
                        Placeholder::make('Harga')
                            ->label('Harga')
                            ->content(function ($get){
                                if($get('module_id') == null){
                                    return "Pilih Modul terlebih dahulu";
                                }
                               $price = Module::find($get('module_id'))->price;
                               $priceIDR = number_format($price, 0, ',', '.');
                                return "Rp. $priceIDR";
                            })
                            ->columnSpan(2),
                    ])
                    ->columnSpanFull()
                    ->mutateRelationshipDataBeforeCreateUsing(function(array $data):array {
                        $module = Module::find($data['module_id']);
                        $data['price'] = $module->price;
                        return $data;
                    })
                    ->required( )
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('proof_of_payment_url')
                    ->label('Bukti Bayar'),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Diverifikasi Oleh')
                    ->searchable(),
                Tables\Columns\TextColumn::make('member.name')
                    ->label('Pengguna')
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_price')
                    ->label('Total Harga')
                    ->getStateUsing(function($record){
                        $totalPrice = 0;
                        foreach($record->transaction_modules as $transaction_module){
                            $totalPrice += $transaction_module->price;
                        }
                        $totalPriceIDR  = number_format($totalPrice, 0, ',', '.');
                        return "Rp. $totalPriceIDR";
                    })
         
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Transaksi')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Terakhir Diubah')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
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
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}
