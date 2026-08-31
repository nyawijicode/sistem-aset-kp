<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AssetOutResource\Pages;
use App\Models\Asset;
use App\Models\AssetOut;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AssetOutResource extends Resource
{
    protected static ?string $model = AssetOut::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-up-tray';

    protected static ?string $navigationLabel = 'Aset Keluar';

    protected static ?string $modelLabel = 'Aset Keluar';

    protected static ?int $navigationSort = 3;
    protected static ?string $slug = 'aset-keluar';

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Infolists\Components\Section::make('Detail Aset Keluar')
                ->schema([
                    Infolists\Components\TextEntry::make('date')
                        ->label('Tanggal Keluar')
                        ->date('d/m/Y'),
                    Infolists\Components\TextEntry::make('asset.code')
                        ->label('Kode Aset'),
                    Infolists\Components\TextEntry::make('asset.name')
                        ->label('Nama Aset'),
                    Infolists\Components\TextEntry::make('qty')
                        ->label('Jumlah Keluar')
                        ->badge()
                        ->color('danger'),
                    Infolists\Components\TextEntry::make('recipient')
                        ->label('Penerima / Tujuan')
                        ->placeholder('-'),
                    Infolists\Components\TextEntry::make('creator.name')
                        ->label('Diinput oleh'),
                    Infolists\Components\TextEntry::make('notes')
                        ->label('Catatan')
                        ->placeholder('-')
                        ->columnSpanFull(),
                ])
                ->columns(2),

            Infolists\Components\Section::make('Serial Number yang Keluar')
                ->schema([
                    Infolists\Components\RepeatableEntry::make('serialNumbers')
                        ->label('')
                        ->schema([
                            Infolists\Components\TextEntry::make('serial_number')->label('Serial Number'),
                        ])
                        ->columns(1),
                ])
                ->visible(fn($record) => $record->serialNumbers()->count() > 0)
                ->collapsible(),
        ]);
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('asset_id')
                ->label('Aset')
                ->relationship('asset', 'name')
                ->getOptionLabelFromRecordUsing(fn(Asset $record) => "{$record->code} — {$record->name} (stok: {$record->qty})")
                ->searchable(['code', 'name'])
                ->preload()
                ->required()
                ->live()
                ->disabled(fn(?AssetOut $record) => $record !== null)
                ->afterStateUpdated(fn(Set $set) => $set('serial_number_ids', [])),

            Forms\Components\DatePicker::make('date')
                ->label('Tanggal Keluar')
                ->required()
                ->default(now()),

            Forms\Components\TextInput::make('recipient')
                ->label('Penerima / Tujuan')
                ->maxLength(255),

            Forms\Components\Select::make('serial_number_ids')
                ->label('Pilih Serial Number yang keluar')
                ->multiple()
                ->options(function (Get $get) {
                    $assetId = $get('asset_id');
                    if (! $assetId) {
                        return [];
                    }

                    $asset = Asset::find($assetId);
                    if (! $asset) {
                        return [];
                    }

                    return $asset->serialNumbers()
                        ->where(function ($q) {
                            $q->where('status', 'in');
                        })
                        ->orWhere('asset_out_id', request()->route('record')) // tampilkan juga SN yg sudah terpilih saat edit
                        ->pluck('serial_number', 'id');
                })
                ->searchable()
                ->live()
                ->afterStateUpdated(fn(Set $set, ?array $state) => $set('qty', count($state ?? [])))
                ->visible(fn(Get $get) => static::assetHasSerial($get('asset_id')))
                ->helperText('Hanya SN dengan status "tersedia" yang muncul.'),

            Forms\Components\TextInput::make('qty')
                ->label('Jumlah Keluar')
                ->numeric()
                ->minValue(1)
                ->required()
                ->live()
                ->disabled(fn(Get $get) => static::assetHasSerial($get('asset_id')))
                ->dehydrated(true)
                ->helperText(fn(Get $get) => static::assetHasSerial($get('asset_id'))
                    ? 'Otomatis mengikuti jumlah SN yang dipilih.'
                    : 'Tidak boleh melebihi stok yang tersedia.'),

            Forms\Components\Textarea::make('notes')
                ->label('Catatan')
                ->columnSpanFull(),
        ]);
    }

    protected static function assetHasSerial(?int $assetId): bool
    {
        if (! $assetId) {
            return false;
        }

        return (bool) Asset::find($assetId)?->has_serial_number;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date')->label('Tanggal')->date('d/m/Y')->sortable(),
                Tables\Columns\TextColumn::make('asset.code')->label('Kode Aset')->searchable(),
                Tables\Columns\TextColumn::make('asset.name')->label('Nama Aset')->searchable(),
                Tables\Columns\TextColumn::make('qty')->label('Qty')->badge()->color('danger'),
                Tables\Columns\TextColumn::make('recipient')->label('Penerima'),
                Tables\Columns\TextColumn::make('creator.name')->label('Diinput oleh'),
            ])
            ->headerActions([
                Tables\Actions\Action::make('cetak_laporan')
                    ->label('Cetak Laporan')
                    ->icon('heroicon-o-printer')
                    ->color('gray')
                    ->url(fn() => route('laporan.asset-out'))
                    ->openUrlInNewTab(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('Lihat'),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn() => auth()->user()->isPimpinan()),
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
            'index' => Pages\ListAssetOuts::route('/'),
            'create' => Pages\CreateAssetOut::route('/create'),
            'edit' => Pages\EditAssetOut::route('/{record}/edit'),
            'view' => Pages\ViewAssetOut::route('/{record}'),
        ];
    }

    public static function canDelete($record): bool
    {
        return auth()->user()->isPimpinan();
    }
}
