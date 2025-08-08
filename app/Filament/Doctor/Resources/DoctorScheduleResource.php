<?php

namespace App\Filament\Doctor\Resources;

use App\Filament\Doctor\Resources\DoctorScheduleResource\Pages;
use App\Filament\Doctor\Resources\DoctorScheduleResource\RelationManagers;
use App\Models\DoctorSchedule;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DoctorScheduleResource extends Resource
{
    protected static ?string $model = DoctorSchedule::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\Select::make('doctor_id')
                //     ->relationship('doctor', 'doctor_id')
                //     ->getOptionLabelFromRecordUsing(fn($record) => $record->user->name)
                //     ->searchable()
                //     ->preload()
                //     ->required(),
                Forms\Components\Select::make('available_day')
                    ->options([
                        1 => 'Saturday',
                        2 => 'Sunday',
                        3 => 'Monday',
                        4 => 'Tuesday',
                        5 => 'Wednesday',
                        6 => 'Thursday',
                        7 => 'Friday',
                    ])
                    ->required(),
                Forms\Components\TimePicker::make('from')
                    ->required(),
                Forms\Components\TimePicker::make('to')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
               Tables\Columns\TextColumn::make('doctor.user.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('available_day')
                    ->formatStateUsing(function ($state) {
                        $days = [
                            1 => 'Saturday',
                            2 => 'Sunday',
                            3 => 'Monday',
                            4 => 'Tuesday',
                            5 => 'Wednesday',
                            6 => 'Thursday',
                            7 => 'Friday',
                        ];

                        return $days[$state] ?? '-';
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('from'),
                Tables\Columns\TextColumn::make('to'),
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
            'index' => Pages\ListDoctorSchedules::route('/'),
            'create' => Pages\CreateDoctorSchedule::route('/create'),
            'view' => Pages\ViewDoctorSchedule::route('/{record}'),
            'edit' => Pages\EditDoctorSchedule::route('/{record}/edit'),
        ];
    }
}
