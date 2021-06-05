<?php


namespace Plasticground\SimpleTelegramBot;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

/**
 * Class Command
 *
 * @property string $name
 * @property string $description
 * @property array $filledParameters
 * @property-read Collection|Bot[] $bots
 * @property-read Collection|CommandParameter[] $parameters
 * @package Plasticground\SimpleTelegramBot
 */
class Command extends Model
{
    protected $fillable = [
        'name',
        'description'
    ];

    protected $attributes = [
        'filledParameters' => []
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function bots()
    {
        return $this->belongsToMany(Bot::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function parameters()
    {
        return $this->belongsToMany(CommandParameter::class);
    }

    /**
     * @param array $paramsAndValues
     * @return $this
     */
    public function fillParameters(array $paramsAndValues = [])
    {
        $params = $this->parameters->pluck('name', 'value')->all();
        $this->filledParameters = array_merge($params, Arr::only($paramsAndValues, array_keys($params)));

        return $this;
    }
}
