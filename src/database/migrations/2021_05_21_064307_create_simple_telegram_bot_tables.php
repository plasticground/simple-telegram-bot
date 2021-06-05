<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Plasticground\SimpleTelegramBot\Command;
use Plasticground\SimpleTelegramBot\CommandParameter;

class CreateSimpleTelegramBotTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bots', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('token');
            $table->text('description');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('commands', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->timestamps();
        });

        Schema::create('command_parameters', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->jsonb('types');
            $table->text('description');
            $table->timestamps();
        });

        Schema::create('bot_command', function (Blueprint $table) {
            $table->unsignedBigInteger('bot_id');
            $table->unsignedBigInteger('command_id');
        });

        Schema::create('command_command_parameter', function (Blueprint $table) {
            $table->unsignedBigInteger('command_id');
            $table->unsignedBigInteger('command_parameter_id');
            $table->boolean('required');
        });

        //$this->createCommands();
    }

    private function createCommands()
    {
        $parameters = [
            [
                'name' => 'url',
                'types' => [CommandParameter::TELEGRAM_PARAM_TYPE_STRING],
                'description' => 'HTTPS url to send updates to. Use an empty string to remove webhook integration',
                'required' => 1
            ],
            [
                'name' => 'certificate',
                'types' => [CommandParameter::TELEGRAM_PARAM_TYPE_OBJECT],
                'description' => 'Upload your public key certificate so that the root certificate in use can be checked. See our self-signed guide for details.',
                'required' => 0
            ],
            [
                'name' => 'ip_address',
                'types' => [CommandParameter::TELEGRAM_PARAM_TYPE_STRING],
                'description' => 'The fixed IP address which will be used to send webhook requests instead of the IP address resolved through DNS',
                'required' => 0
            ],
            [
                'name' => 'max_connections',
                'types' => [CommandParameter::TELEGRAM_PARAM_TYPE_INTEGER],
                'description' => 'Maximum allowed number of simultaneous HTTPS connections to the webhook for update delivery, 1-100. Defaults to 40. Use lower values to limit the load on your bot\'s server, and higher values to increase your bot\'s throughput.',
                'required' => 0
            ],
            [
                'name' => 'allowed_updates',
                'types' => [CommandParameter::TELEGRAM_PARAM_TYPE_ARRAY],
                'description' => 'A JSON-serialized list of the update types you want your bot to receive. For example, specify [“message”, “edited_channel_post”, “callback_query”] to only receive updates of these types. See Update for a complete list of available update types. Specify an empty list to receive all update types except chat_member (default). If not specified, the previous setting will be used. Please note that this parameter doesn\'t affect updates created before the call to the setWebhook, so unwanted updates may be received for a short period of time.',
                'required' => 0
            ],
            [
                'name' => 'drop_pending_updates',
                'types' => [CommandParameter::TELEGRAM_PARAM_TYPE_BOOLEAN],
                'description' => 'Pass True to drop all pending updates',
                'required' => 0
            ],
            [
                'name' => 'chat_id',
                'types' => [CommandParameter::TELEGRAM_PARAM_TYPE_INTEGER, CommandParameter::TELEGRAM_PARAM_TYPE_STRING],
                'description' => 'Unique identifier for the target chat or username of the target channel (in the format @channelusername)',
                'required' => 1
            ],
            [
                'name' => 'text',
                'types' => [CommandParameter::TELEGRAM_PARAM_TYPE_STRING],
                'description' => 'Text of the message to be sent, 1-4096 characters after entities parsing',
                'required' => 1
            ],
            [
                'name' => 'parse_mode',
                'types' => [CommandParameter::TELEGRAM_PARAM_TYPE_STRING],
                'description' => 'Mode for parsing entities in the message text. See formatting options for more details.',
                'required' => 0
            ],
            [
                'name' => 'entities',
                'types' => [CommandParameter::TELEGRAM_PARAM_TYPE_ARRAY],
                'description' => 'List of special entities that appear in message text, which can be specified instead of parse_mode',
                'required' => 0
            ],
            [
                'name' => 'disable_web_page_preview',
                'types' => [CommandParameter::TELEGRAM_PARAM_TYPE_BOOLEAN],
                'description' => 'Disables link previews for links in this message',
                'required' => 0
            ],
            [
                'name' => 'disable_notification',
                'types' => [CommandParameter::TELEGRAM_PARAM_TYPE_BOOLEAN],
                'description' => 'Sends the message silently. Users will receive a notification with no sound.',
                'required' => 0
            ],
            [
                'name' => 'reply_to_message_id',
                'types' => [CommandParameter::TELEGRAM_PARAM_TYPE_INTEGER],
                'description' => 'If the message is a reply, ID of the original message',
                'required' => 0
            ],
             [
                 'name' => 'allow_sending_without_reply',
                'types' => [CommandParameter::TELEGRAM_PARAM_TYPE_INTEGER],
                'description' => 'Pass True, if the message should be sent even if the specified replied-to message is not found',
                'required' => 0
            ],
            [
                'name' => 'reply_markup',
                'types' => [CommandParameter::TELEGRAM_PARAM_TYPE_OBJECT],
                'description' => 'Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove reply keyboard or to force a reply from the user.',
                'required' => 0
            ],
        ];

        $commands = [
            ['name' => 'getMe', 'description' => 'https://core.telegram.org/bots/api#getme'],
            [
                'name' => 'setWebhook',
                'description' => 'https://core.telegram.org/bots/api#setwebhook',
                'parameters' => [
                    'url',
                    'certificate',
                    'ip_address',
                    'max_connections',
                    'allowed_updates',
                    'drop_pending_updates'
                ]
            ],
            [
                'name' => 'deleteWebhook',
                'description' => 'https://core.telegram.org/bots/api#deletewebhook',
                'parameters' => [
                    'drop_pending_updates'
                ]
            ],
            [
                'name' => 'getWebhookInfo',
                'description' => 'https://core.telegram.org/bots/api#webhookinfo',
            ],
            [
                'name' => 'sendMessage',
                'description' => 'https://core.telegram.org/bots/api#sendmessage',
                'parameters' => [
                    'chat_id',
                    'text',
                    'parse_mode',
                    'entities',
                    'disable_web_page_preview',
                    'disable_notification',
                    'reply_to_message_id',
                    'allow_sending_without_reply',
                    'reply_markup',
                ]
            ],
        ];

        $createdParameters = [];

        foreach ($parameters as $parameter) {
            $newParam = new CommandParameter($parameter);
            $newParam->save();

            $createdParameters[$newParam->id] = ['required' => $parameter['required']];
        }

        foreach ($commands as $command) {
            $newCmd = new Command($command);
            $newCmd->save();

            if (isset($command['parameters'])) {
                $newCmd->parameters()->sync($createdParameters);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bots');
        Schema::dropIfExists('commands');
        Schema::dropIfExists('bot_command');
        Schema::dropIfExists('command_parameters');
        Schema::dropIfExists('command_command_parameter');
    }
}
