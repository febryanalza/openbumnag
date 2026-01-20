<?php

namespace App\Filament\Resources\Catalogs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CatalogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('featured_image')
                    ->label('Gambar')
                    ->disk('public')
                    ->square()
                    ->size(60),
                
                TextColumn::make('name')
                    ->label('Nama Produk')
                    ->searchable()
                    ->sortable()
                    ->limit(40)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 40) {
                            return null;
                        }
                        return $state;
                    }),
                
                TextColumn::make('bumnagProfile.name')
                    ->label('Unit Usaha')
                    ->sortable()
                    ->badge()
                    ->color('success')
                    ->searchable(),
                
                TextColumn::make('category')
                    ->label('Kategori')
                    ->sortable()
                    ->badge()
                    ->color('info')
                    ->searchable(),
                
                TextColumn::make('price')
                    ->label('Harga')
                    ->money('IDR')
                    ->sortable()
                    ->getStateUsing(fn ($record) => $record->price ?? null)
                    ->placeholder('Hubungi Kami'),
                
                TextColumn::make('unit')
                    ->label('Satuan')
                    ->searchable()
                    ->toggleable(),
                
                TextColumn::make('stock')
                    ->label('Stok')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color(fn ($state) => match (true) {
                        $state === 0 => 'danger',
                        $state < 10 => 'warning',
                        default => 'success',
                    }),
                
                IconColumn::make('is_available')
                    ->label('Tersedia')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                
                IconColumn::make('is_featured')
                    ->label('Unggulan')
                    ->boolean()
                    ->trueIcon('heroicon-o-star')
                    ->falseIcon('heroicon-o-star')
                    ->trueColor('warning')
                    ->falseColor('gray'),
                
                TextColumn::make('view_count')
                    ->label('Dilihat')
                    ->numeric()
                    ->sortable()
                    ->toggleable()
                    ->icon('heroicon-o-eye'),
                
                TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                TextColumn::make('updated_at')
                    ->label('Diupdate')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('bumnag_profile_id')
                    ->label('Unit Usaha')
                    ->relationship('bumnagProfile', 'name')
                    ->searchable()
                    ->preload(),
                
                SelectFilter::make('category')
                    ->label('Kategori')
                    ->options([
                        'Makanan & Minuman' => 'Makanan & Minuman',
                        'Pertanian' => 'Pertanian',
                        'Perikanan' => 'Perikanan',
                        'Peternakan' => 'Peternakan',
                        'Kerajinan' => 'Kerajinan',
                        'Jasa' => 'Jasa',
                        'Lainnya' => 'Lainnya',
                    ])
                    ->native(false),
                
                Filter::make('is_available')
                    ->label('Tersedia')
                    ->query(fn (Builder $query): Builder => $query->where('is_available', true)),
                
                Filter::make('is_featured')
                    ->label('Unggulan')
                    ->query(fn (Builder $query): Builder => $query->where('is_featured', true)),
                
                Filter::make('out_of_stock')
                    ->label('Stok Habis')
                    ->query(fn (Builder $query): Builder => $query->where('stock', 0)),
                
                Filter::make('low_stock')
                    ->label('Stok Menipis')
                    ->query(fn (Builder $query): Builder => $query->where('stock', '>', 0)->where('stock', '<', 10)),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
