<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Models\MemberModule;
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
use Illuminate\Support\HtmlString;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;
    protected static ?string $navigationGroup = 'Manajemen Transaksi';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $label = 'Pembelian Modul';

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
   
                Forms\Components\Select::make('user_id')
                    ->relationship('user','name')
                    ->label('Diverifikasi Oleh')
                    ->hint('Kosongkan jika belum diverifikasi'),
                
                
                Forms\Components\Select::make('member_id')
                    ->label('Pengguna')
                    ->required()
                    ->relationship('member','name'),
                    Forms\Components\Placeholder::make('proof_of_payment_url')
                    ->label('Bukti Bayar')
                    ->content(function ($get){
                        if($get('proof_of_payment_url') == null){
                            return "Tidak ada Bukti Bayar";
                        }
                        $url = $get('proof_of_payment_url');
                        if(strpos($url, 'storage/') !== false){
                            $url = substr($url, 8);
                        }
                        return new HtmlString('
                        <div>
                            <a style="color:orange" href="'.asset('storage/'.$url).'" target="_blank" class="text-blue-500">Lihat Layar Penuh</a>
                        </div>
                        <div class="" style="
                            overflow-y: scroll;
                            height: 300px;
                            padding: 10px;
                            border-width: 2px;
                            border-color: rgba(var(--gray-500),var(--tw-border-opacity,1));
                            border-radius: 10px;
                            background-color: hsla(0,0%,100%,.05);
                        ">
                            <img src="'.asset('storage/'.$url).'" style="width: 100%;">
                        </div>
                  
                    
                        ');
                    }),
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
                Tables\Columns\ImageColumn::make('proof_of_payment_url')   
                    ->getStateUsing(function($record){
                        //if contains 'storage/' remove it
                        $proof_of_payment_url = $record->proof_of_payment_url;
                        if(strpos($proof_of_payment_url, 'storage/') !== false){
                            $proof_of_payment_url = substr($proof_of_payment_url, 8);
                        }
                        return $proof_of_payment_url;
                    })
                

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
                Tables\Actions\Action::make('Verifikasi')
                    ->color(fn (Transaction $record) => $record->user_id == null ? 'success' : 'disabled')
                    ->action(function(Transaction $record){
                        $record->user_id = auth()->id();
                        $record->save();
                        foreach($record->transaction_modules as $transaction_module){
                            if(MemberModule::where('member_id',$record->member_id)->where('module_id',$transaction_module->module_id)->count() == 0){
                                MemberModule::create([
                                    'member_id' => $record->member_id,
                                    'module_id' => $transaction_module->module_id,
                                    'is_active' => true
                                ]);
                            }
                        }
                    })
                    ->disabled(function(Transaction $record){
                        return $record->user_id != null;
                    })
                    ->requiresConfirmation()
                    ->modalHeading('Verifikasi Transaksi')
                    ->modalDescription('Apakah Anda yakin ingin memverifikasi transaksi ini?')
                    ->modalSubmitActionLabel('Verifikasi')
                    ->modalCancelActionLabel('Batal')
                    ->label(function(Transaction $record){
                        return $record->user_id == null ? 'Verifikasi' : 'Terverifikasi';
                    }),
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
