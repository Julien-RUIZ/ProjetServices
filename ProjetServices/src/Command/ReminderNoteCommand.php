<?php

namespace App\Command;

use App\Controller\Note\Reminder;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'ReminderNote',
    description: 'Note reminder with scheduled email sending',
)]
class ReminderNoteCommand extends Command
{
    public function __construct(private Reminder $reminder)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->reminder->ReminderOn();
        return Command::SUCCESS;
    }
}
