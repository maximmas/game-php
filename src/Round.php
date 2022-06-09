<?php

namespace App;

use App\HumanPlayer;


/**
 * Round moves handler class
 *
 */
class Round
{


    /**
     * Array of player robots
     *
     * @var array
     */
    private array $playerArmy;

    /**
     * Array of computer robots
     *
     * @var array
     *
     */
    private array $computerArmy;


    /**
     *  Unused robots left on stock after armies creation
     *
     * Free robots can be used with exchange action
     *
     * @var array
     *
     */
    private array $robotsStock;


    public function __construct(
        private int            $roundNumber,
        array                  $robotsStock,
        private HumanPlayer    $human,
        private ComputerPlayer $computer,
        private Output         $output,
        private KeyboardInput  $input
    )
    {
        $this->roundNumber = $roundNumber;
        $this->robotsStock = $robotsStock;
        $this->human = $human;
        $this->computer = $computer;
        $this->output = $output;
        $this->input = $input;
    }

    public function run()
    {
        echo "Round #" . $this->roundNumber . PHP_EOL;
        $this->makeMove(Settings::MOVE_FIRST);
        return true;
    }

    private function makeMove(string $turn): void
    {

        if (!count($this->computer->getArmy())) {
            system('clear');
            echo "VICTORY !\n";
            echo "Computer army is beaten !\n";
            echo "Player won!\n";
            $this->endRound();
        }

        if (!count($this->human->getArmy())) {
            system('clear');
            echo "DEFEAT !\n";
            echo "Player army is beaten !\n";
            echo "Computer won!\n";
            $this->endRound();
        }

        $moveResult = ($turn === 'player') ? $this->humanMove() : $this->computerMove();
    }

    private function humanMove(): void
    {

        echo "Press 'a' to make a move \n";
        $input = $this->input->getInput(['a']);

        system('clear');
        echo "/***** Player turn now *****/ \n";
        echo "\n";

        echo "Player's robots:\n";
        $this->output->displayArmyInfo($this->human->getArmy());
        $this->output->displaySeparator();
        echo "Computer's robots:\n";
        $this->output->displayArmyInfo($this->computer->getArmy());
        $this->output->displaySeparator();

        echo "Choose your action:\n";
        echo "Press '1' for attack \n";
        echo "Press '2' for change robot \n";
        echo "Press '3' for upgrade robot \n";

        $input = $this->input->getInput(['1', '2', '3']);

        match ($input) {
            '1' => $this->human->attack(),
            '2' => $this->human->changeRobot($this->robotsStock),
            '3' => $this->human->upgrade()
        };

//        $this->makeMove('computer');
        $this->makeMove('player');
    }

    private function computerMove(): void
    {
        echo "Press 'a' to make a move \n";
        $this->input->getInput(['a']);

        system('clear');

        echo "/***** Computer turn now *****/ \n";
        echo "\n";
        echo "Computer's robots:\n";
        $this->output->displayArmyInfo($this->computer->getArmy());
        $this->output->displaySeparator();
        echo "Player's robots:\n";
        $this->output->displayArmyInfo($this->human->getArmy());
        $this->output->displaySeparator();

        $input = random_int(1, 2);

        match ($input) {
            1 => $this->computer->attack(),
            2 => $this->computer->changeRobot($this->robotsStock)
        };

        $this->makeMove('player');
    }

    private function endRound()
    {
        echo "Round " . $this->roundNumber . " end";
        exit();
    }

}