<?php

namespace App\Filament\Resources\StaffResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class AttendanceRelationManager extends RelationManager
{
    protected static string $relationship = 'attendance';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('date')
                    ->required()
                    ->default(now()),
                Forms\Components\TimePicker::make('clock_in')
                    ->required(),
                Forms\Components\TimePicker::make('clock_out'),
                Forms\Components\TextInput::make('hours_worked')
                    ->numeric()
                    ->step(0.25),
                Forms\Components\TextInput::make('total_pay')
                    ->numeric()
                    ->prefix('$'),
                Forms\Components\Textarea::make('notes'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('date')
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('clock_in')
                    ->time(),
                Tables\Columns\TextColumn::make('clock_out')
                    ->time(),
                Tables\Columns\TextColumn::make('hours_worked')
                    ->suffix(' hrs'),
                Tables\Columns\TextColumn::make('total_pay')
                    ->money('USD'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('date', 'desc');
    }
}