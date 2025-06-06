<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GuruResource\Pages;
use App\Filament\Resources\GuruResource\RelationManagers;
use App\Models\Guru;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Filament\Notifications\Notification;

class GuruResource extends Resource
{
    protected static ?string $model = Guru::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationGroup = 'User Management';
    protected static ?string $navigationLabel = 'Data Guru';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(50),
                Forms\Components\TextInput::make('nip')
                    ->required()
                    ->maxLength(18)
                    ->unique(
                        table: 'gurus',
                        column: 'nip',
                        ignoreRecord: true,
                    )
                    ->validationMessages([
                        'unique' => 'NIP ini sudah digunkan!.',
                    ]),
                Forms\Components\Select::make('gender')
                    ->label('Gender')
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
                        table: 'gurus',
                        column: 'email',
                        ignoreRecord: true,
                    )
                    ->validationMessages([
                        'unique' => 'Email ini sudah digunkan!.',
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nip')
                    ->label('NIP')
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
                                    ->title('Berhasil menghapus ' . count($canDelete) . ' guru')
                                    ->success()
                                    ->send();
                            }
                            
                            // Notifikasi untuk yang tidak bisa dihapus
                            if (count($cannotDelete) > 0) {
                                Notification::make()
                                    ->title('Beberapa guru tidak dapat dihapus')
                                    ->body('Guru berikut memiliki data PKL: ' . implode(', ', $cannotDelete))
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
            'index' => Pages\ListGurus::route('/'),
            'create' => Pages\CreateGuru::route('/create'),
            'edit' => Pages\EditGuru::route('/{record}/edit'),
        ];
    }
}
