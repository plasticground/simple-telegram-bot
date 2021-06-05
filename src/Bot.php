<?php


namespace Plasticground\SimpleTelegramBot;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Class Bot
 *
 * @property string $name
 * @property string $token
 * @property string $additionalUri
 * @property-read  Collection|Command[] $commands
 * @package Plasticground\SimpleTelegramBot
 */
class Bot extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'token',
        'description'
    ];

    public function commands()
    {
        return $this->belongsToMany(Command::class);
    }

    /**
     * @return string
     */
    public function getAdditionalUriAttribute()
    {
        return "/{$this->token}/";
    }

    /**
     * @param Command $command
     * @param array $params
     * @return \Exception|\Illuminate\Http\Client\Response|\Throwable
     */
    public function send(Command $command, array $params = [])
    {
        $params = empty($params) ? [] : $command->filledParameters;

        try {
            $response = Http::post(
                config('simple-telegram-bot.base_uri') . $this->additionalUri . $command->name,
                $params
            );
        } catch (\Throwable $e) {
            $response = $e;
            Log::error('Telegram bot error', ['error' => $e->getMessage()]);
        }

        return $response;
    }
}
