<?php


namespace Plasticground\SimpleTelegramBot;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CommandParameter
 *
 * @property string $name
 * @property array $types
 * @property string $description
 * @property mixed $value
 * @property-read Collection|Command[] $commands
 * @package Plasticground\SimpleTelegramBot
 */
class CommandParameter extends Model
{
    const TELEGRAM_PARAM_TYPE_BOOLEAN = 'boolean';
    const TELEGRAM_PARAM_TYPE_INTEGER = 'integer';
    const TELEGRAM_PARAM_TYPE_FLOAT = 'float';
    const TELEGRAM_PARAM_TYPE_STRING = 'string';
    const TELEGRAM_PARAM_TYPE_ARRAY = 'array';
    const TELEGRAM_PARAM_TYPE_OBJECT = 'object';

    protected $fillable = [
        'name',
        'types',
        'description'
    ];

    protected $casts = [
        'types' => 'array'
    ];

    protected $attributes = [
        'value' => null
    ];

    public function commands()
    {
        return $this->belongsToMany(Command::class);
    }
}
