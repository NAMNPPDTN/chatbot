<?php
namespace Dtn\Chatbot\Controller\Botchat;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use OpenAI;

class Botchat extends Action
{
    protected $jsonFactory;
    protected $botman;
    protected $openai;

    public function __construct(Context $context, JsonFactory $jsonFactory)
    {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
        $this->openai = OpenAI::client('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');
        $config = [
            'web' => [
                'matchingData' => [
                    'driver' => 'web',
                ],
            ],
        ];
        DriverManager::loadDriver(\BotMan\Drivers\Web\WebDriver::class);
        $this->botman = BotManFactory::create($config);
        $botman = $this->botman;
        $openai = $this->openai;
        $botman->hears('.*', function (BotMan $bot) use ($openai) {
            $userInput = $bot->getMessage()->getText();
            $response = $openai->completions()->create([
                'model' => 'gpt-3.5-turbo-instruct',
                'prompt' => $userInput,
                'max_tokens' => 150,
            ]);

            $botResponse = $response->choices[0]->text;

            $bot->reply($botResponse);
        });
        $this->botman->listen();
    }

    public function execute()
    {
        // Your function logic here
        $responseData = [
            'message' => 'Your function was called successfully.'
        ];

        // Return JSON response
        $result = $this->jsonFactory->create();
        $result->setData($responseData);
        return $result;
    }
}
