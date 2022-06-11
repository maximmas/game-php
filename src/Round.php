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
     *  Unused robots left on stock after armies creation
     *
     *  Free robots can be used with exchange action
     *
     * @var array
     *
     */
    private array $robotsStock;


    /**
     * Counter of moves in the round
     *
     * @var int
     */
    private int $movesCounter;


    public function __construct(
        private int            $roundNumber,
        array                  $robotsStock,
        private HumanPlayer    $human,
        private ComputerPlayer $computer,
        private Output         $output,
        private KeyboardInput  $input
    )
    {
        $this->robotsStock = $robotsStock;
        $this->movesCounter = 0;
    }


    /**
     * Start game round
     *
     * @return array round results
     */
    public function run(): array
    {
        echo "Round #" . $this->roundNumber . " starts! \n";
        $roundWinner = $this->makeMove(Settings::MOVE_FIRST);

        return [$roundWinner, $this->roundNumber, $this->movesCounter];
    }


    /**
     * Switch move between human and computer
     *
     * @param string $turn whose move 'human'|'computer'
     * @return string round winner 'human'|'computer'
     *
     */
    private function makeMove(string $turn): string
    {

        $winner = '';

        if (!count($this->computer->getArmy())) {
            $winner = 'player';
        } elseif (!count($this->human->getArmy())) {
            $winner = 'computer';
        } else {
            ++$this->movesCounter;
            ($turn === 'player') ? $this->humanMove() : $this->computerMove();
        }

        return $winner;
    }


    /**
     * Human player move handler
     *
     * @return void
     *
     */
    private function humanMove(): void
    {

        echo "Press 'a' to make a move \n";
        $this->input->getInput(['a']);

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
            '3' => $this->human->upgrade(),
            default => '',
        };

        $this->makeMove('computer');

    }


    /**
     *  Computer player move handler
     *
     * @return void
     * @throws \Exception
     *
     *
     */
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
            2 => $this->computer->changeRobot($this->robotsStock),
        };

        $this->makeMove('player');
    }

}