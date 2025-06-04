<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiswaResource\Pages;
use App\Filament\Resources\SiswaResource\RelationManagers;
use App\Models\Siswa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Collection;
use Filament\Notifications\Notification;

class SiswaResource extends Resource
{
    protected static ?string $model = Siswa::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationGroup = 'User Management';
    protected static ?string $navigationLabel = 'Data Siswa';


public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(50),
                Forms\Components\TextInput::make('nis')
                    ->required()
                    ->maxLength(5)
                    ->unique(
                        table: 'siswas',
                        column: 'nis',
                        ignoreRecord: true
                    )
                    ->validationMessages([
                        'unique' => 'NIS ini sudah digunkan!.',
                    ]),
                Forms\Components\Select::make('gender')
                    ->label('Jenis Kelamin')
                    ->options([
                        'L' => 'Laki-laki',
                        'P' => 'Perempuan',
                        ])
                    ->required(),
                Forms\Components\Textarea::make('alamat')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('kontak')
                    ->required()
                    ->maxLength(16)
                    ->afterStateHydrated(function (Forms\Components\TextInput $component, $state) {
                        if ($state && str_starts_with($state, '0')) {
                            $component->state('+62' . substr($state, 1));
                        } elseif ($state && !str_starts_with($state, '+62')) {
                            $component->state('+62' . ltrim($state, '+'));
                        }
                    })
                    ->dehydrateStateUsing(function ($state) {
                    $state = trim($state);
                    if (str_starts_with($state, '0')) {
                        return '+62' . substr($state, 1);
                    } elseif (!str_starts_with($state, '+62')) {
                        return '+62' . ltrim($state, '+');
                    }
                    return $state;
                    })
                    ->helperText('Format: +62XXXXXXXXXX'),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(30)
                    ->unique(
                        table: 'siswas',
                        column: 'email',
                        ignoreRecord: true
                    )
                    ->validationMessages([
                        'unique' => 'Email telah digunakan, gunakan email lain!',
                    ]),
                Forms\Components\Toggle::make('status_lapor_pkl')
                    ->required()
                    ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nis')
                    ->label('NIS')
                    ->searchable(),
                Tables\Columns\TextColumn::make('gender')
                    ->label('Gender')
                    ->formatStateUsing(function ($record) {
                        return $record->getFormattedGender();
                    }),
                Tables\Columns\TextColumn::make('kontak')
                    ->label('Kontak')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                Tables\Columns\IconColumn::make('status_lapor_pkl')
                    ->label('Status Lapor PKL')
                    ->boolean()
                    ->icon(fn ($state) => $state ? 'heroicon-o-face-smile' : 'heroicon-o-face-frown')
                    ->color(fn ($state) => $state ? 'success' : 'danger'),
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
                Tables\Actions\ViewAction::make(),
            ])
            
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->action(function (Collection $records) {
                            $cannotDelete = [];
                            $canDelete = [];
                            
                            foreach ($records as $record) {
                                if ($record->status_lapor_pkl || $record->pkls()->exists()) {
                                    $cannotDelete[] = $record->nama;
                                } else {
                                    $canDelete[] = $record;
                                }
                            }
                            
                            // Delete yang bisa dihapus
                            if (count($canDelete) > 0) {
                                foreach ($canDelete as $record) {
                                    $record->delete();
                                }
                                
                                Notification::make()
                                    ->title('Berhasil menghapus ' . count($canDelete) . ' siswa')
                                    ->success()
                                    ->send();
                            }
                            
                            // Notifikasi untuk yang tidak bisa dihapus
                            if (count($cannotDelete) > 0) {
                                Notification::make()
                                    ->title('Beberapa siswa tidak dapat dihapus')
                                    ->body('Siswa berikut memiliki data PKL: ' . implode(', ', $cannotDelete))
                                    ->warning()
                                    ->send();
                            }
                        })
                        ->deselectRecordsAfterCompletion(),
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
            'index' => Pages\ListSiswas::route('/'),
            'create' => Pages\CreateSiswa::route('/create'),
            'edit' => Pages\EditSiswa::route('/{record}/edit'),
        ];
    }
}
