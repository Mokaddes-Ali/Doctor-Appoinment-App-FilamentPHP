<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DoctorResource\Pages;
use App\Filament\Resources\DoctorResource\RelationManagers;
use App\Models\Doctor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DoctorResource extends Resource
{
    protected static ?string $model = Doctor::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                ->relationship('user', 'name',function($query){
                        $query->where('role', 'doctor');
                    })
                ->searchable()
                ->preload()
                ->required()
                 ->createOptionForm([
           Forms\Components\TextInput::make('name')
            ->required()
            ->maxLength(255),
          Forms\Components\TextInput::make('email')
              ->email()
            ->required()
            ->unique(\App\Models\User::class, 'email'),
         Forms\Components\TextInput::make('password')
            ->password()
            ->required()
            ->minLength(6),
              Forms\Components\Select::make('role')->options([
                    'admin' => 'Admin',
                    'patient' => 'Patient',
                    'doctor' => 'Doctor'
                ])
                    ->required(),
                 ]),
                Forms\Components\Select::make('speciality_id')
                    ->relationship('speciality', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->createOptionForm([
                         Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('description')
                    ->maxLength(255),
                Forms\Components\Toggle::make('status')
                    ->required()
        ]),
                Forms\Components\Textarea::make('bio')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('experience')
                    ->numeric(),
                Forms\Components\Toggle::make('is_featured'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('speciality_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('experience')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_featured')
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
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListDoctors::route('/'),
            'create' => Pages\CreateDoctor::route('/create'),
            'view' => Pages\ViewDoctor::route('/{record}'),
            'edit' => Pages\EditDoctor::route('/{record}/edit'),
        ];
    }
}
