<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AssetResource\Pages;
use App\Models\Asset;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AssetResource extends Resource
{
    protected static ?string $model = Asset::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    protected static ?string $navigationLabel = 'Daftar Aset';

    protected static ?string $modelLabel = 'Daftar Aset';

    protected static ?int $navigationSort = 1;
    protected static ?string $slug = 'daftar-aset';

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Infolists\Components\Section::make('Informasi Aset')
                ->schema([
                    Infolists\Components\TextEntry::make('code')->label('Kode Aset'),
                    Infolists\Components\TextEntry::make('name')->label('Nama Aset'),
                    Infolists\Components\TextEntry::make('category')->label('Kategori')->placeholder('-'),
                    Infolists\Components\TextEntry::make('unit')->label('Satuan'),
                    Infolists\Components\TextEntry::make('qty')
                        ->label('Stok Saat Ini')
                        ->badge()
                        ->color(fn(int $state) => $state > 0 ? 'success' : 'danger'),
                    Infolists\Components\IconEntry::make('has_serial_number')
                        ->label('Memiliki Serial Number?')
                        ->boolean(),
                    Infolists\Components\TextEntry::make('description')
                        ->label('Keterangan')
                        ->placeholder('-')
                        ->columnSpanFull(),
                ])
                ->columns(2),

            Infolists\Components\Section::make('Daftar Serial Number')
                ->schema([
                    Infolists\Components\RepeatableEntry::make('serialNumbers')
                        ->label('')
                        ->schema([
                            Infolists\Components\TextEntry::make('serial_number')->label('Serial Number'),
                            Infolists\Components\TextEntry::make('status')
                                ->label('Status')
                                ->badge()
                                ->color(fn(string $state) => $state === 'in' ? 'success' : 'danger')
                                ->formatStateUsing(fn(string $state) => $state === 'in' ? 'Tersedia' : 'Keluar'),
                        ])
                        ->columns(2),
                ])
                ->visible(fn($record) => $record->has_serial_number)
                ->collapsible(),
        ]);
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('code')
                ->label('Kode Aset')
                ->required()
                ->unique(ignoreRecord: true)
                ->maxLength(50),

            Forms\Components\TextInput::make('name')
                ->label('Nama Aset')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('category')
                ->label('Kategori')
                ->maxLength(255),

            Forms\Components\TextInput::make('unit')
                ->label('Satuan')
                ->default('unit')
                ->required(),

            Forms\Components\Toggle::make('has_serial_number')
                ->label('Aset ini memiliki Serial Number?')
                ->helperText('Jika aktif, setiap transaksi masuk/keluar WAJIB mengisi Serial Number per unit.')
                ->disabled(fn(?Asset $record) => $record !== null) // kunci setelah aset punya histori transaksi
                ->default(false),

            Forms\Components\TextInput::make('qty')
                ->label('Stok Saat Ini')
                ->numeric()
                ->default(0)
                ->disabled() // qty HANYA berubah via Aset Masuk / Aset Keluar
                ->dehydrated(fn(?Asset $record) => $record === null) // simpan 0 saat create, abaikan saat edit
                ->helperText('Stok otomatis berubah lewat menu Aset Masuk / Aset Keluar.'),

            Forms\Components\Textarea::make('description')
                ->label('Keterangan')
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')->label('Kode')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('name')->label('Nama Aset')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('category')->label('Kategori')->searchable(),
                Tables\Columns\IconColumn::make('has_serial_number')->label('SN?')->boolean(),
                Tables\Columns\TextColumn::make('qty')->label('Stok')->sortable()->badge()
                    ->color(fn(int $state) => $state > 0 ? 'success' : 'danger'),
                Tables\Columns\TextColumn::make('unit')->label('Satuan'),
                Tables\Columns\TextColumn::make('updated_at')->label('Update Terakhir')->dateTime('d/m/Y H:i')->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('has_serial_number')->label('Punya SN'),
            ])
            ->headerActions([
                Tables\Actions\Action::make('cetak_laporan')
                    ->label('Cetak Laporan')
                    ->icon('heroicon-o-printer')
                    ->color('gray')
                    ->url(fn() => route('laporan.asset'))
                    ->openUrlInNewTab(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('Lihat'),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn() => auth()->user()->isPimpinan()), // hanya Pimpinan
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(fn() => auth()->user()->isPimpinan()),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAssets::route('/'),
            'create' => Pages\CreateAsset::route('/create'),
            'edit' => Pages\EditAsset::route('/{record}/edit'),
            'view' => Pages\ViewAsset::route('/{record}'),
        ];
    }

    // Batasi delete di level Resource (dobel proteksi selain di tombol)
    public static function canDelete($record): bool
    {
        return auth()->user()->isPimpinan();
    }
}
