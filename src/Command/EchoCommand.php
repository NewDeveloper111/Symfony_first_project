<?php

namespace App\Command;

//use Symfony\Component\Serializer\Encoder\JsonDecode;
use App\Service\ConsoleController;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'article:all')]
class EchoCommand extends Command
{
    
    public function __construct(private ConsoleController $controller)
    {
        parent::__construct();
    }
    
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $articles = $this->controller->getAllArticles();
        $output->writeln('Articles successfully generated!');
        $decodedArticles = json_decode($articles->getContent());
        dump($decodedArticles[0]);//echo '<pre>';echo '</pre>';
        //$decoder = new JsonDecode();
        //var_dump($decoder->decode($articles->getContent(), 'json'));
        return Command::SUCCESS;

        // или вернуть это, если во время выполнения возникла ошибка
        // (эквивалентно возвращению int(1))
        // return Command::FAILURE;

        // или вернуть это, чтобы указать на неправильное использование команды, например, невалидные опции
        // или отсутствующие аргументы (равноценно возвращению int(2))
        // return Command::INVALID
    }
}