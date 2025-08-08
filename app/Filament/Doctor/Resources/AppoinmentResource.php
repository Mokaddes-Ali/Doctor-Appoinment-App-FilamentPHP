<?php

namespace App\Filament\Doctor\Resources;

use App\Filament\Doctor\Resources\AppoinmentResource\Pages;
use App\Filament\Doctor\Resources\AppoinmentResource\RelationManagers;
use App\Models\Appoinment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AppoinmentResource extends Resource
{
    protected static ?string $model = Appoinment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('doctor_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('patient_id')
                    ->required()
                    ->numeric(),
                Forms\Components\DatePicker::make('appoinment_date')
                    ->required(),
                Forms\Components\TextInput::make('appoinment_time')
                    ->required(),
                Forms\Components\TextInput::make('status')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('doctor_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('patient_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('appoinment_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('appoinment_time'),
                Tables\Columns\TextColumn::make('status'),
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
            'index' => Pages\ListAppoinments::route('/'),
            'create' => Pages\CreateAppoinment::route('/create'),
            'view' => Pages\ViewAppoinment::route('/{record}'),
            'edit' => Pages\EditAppoinment::route('/{record}/edit'),
        ];
    }
}
