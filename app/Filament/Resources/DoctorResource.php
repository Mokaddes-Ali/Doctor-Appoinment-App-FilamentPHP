<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Doctor;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\DoctorResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\DoctorResource\RelationManagers;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class DoctorResource extends Resource
{
    protected static ?string $model = Doctor::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Doctor Information')
                    ->description('Fill in the doctor information and settings')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label('User')
                            ->relationship('user', 'name', function ($query) {
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
                                    'doctor' => 'Doctor',
                                ])->required(),
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
                                    ->required(),
                            ]),

                        Forms\Components\Textarea::make('bio')
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('experience')
                            ->numeric(),
                    ])->columns(2)
                    ->columnSpan(2),

                // — featured image
                Section::make('Doctor Profile nad Status')
                    ->schema([
                        Forms\Components\Toggle::make('is_featured')
                            ->label('Featured'),

                        Forms\Components\FileUpload::make('image')
                            ->label('Profile Image')
                            ->disk('public')
                            ->directory('doctors')
                            ->image()
                            ->getUploadedFileNameForStorageUsing(function (TemporaryUploadedFile $file) {
                            return rand(100000, 999999) . '.' . $file->getClientOriginalExtension();
                             })
                            ->previewable(true),



                    ])
                    ->columnSpan(1),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\ImageColumn::make('image')
                    ->label('Profile Image')
                    ->disk('public')
                    ->circular()
                    ->height(50)
                    ->width(50),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Doctor Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('speciality.name')
                    ->label('Speciality')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('experience')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Featured')
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
