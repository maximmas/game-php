<?php

namespace App;

class ComputerPlayer extends Player
{

    private HumanPlayer $human;

    public function __construct(array $initRobotsStock, Output $output, KeyboardInput $input)
    {
        $this->armySize = Settings::MAX_COMPUTER_ARMY_SIZE;
        parent::__construct($initRobotsStock, $output, $input);
    }


    /**
     * Set opponent player instance
     *
     * @param ComputerPlayer $computer
     * @return void
     *
     */
    public function setOpponent(HumanPlayer $human): void
    {
        $this->human = $human;
    }


    public function attack(): void
    {

        echo "Action: Computer decided to attack\n";

        $compRobotIndex = $this->getRandomIndex($this->army);
        $compRobotID = $compRobotIndex + 1;
        $attackRobot = $this->army[$compRobotIndex];

        $targetArmy = $this->human->getArmy();
        $targetRobotIndex = $this->getRandomIndex($targetArmy);
        $targetRobotID = $targetRobotIndex + 1;
        $targetRobot = $targetArmy[$targetRobotIndex];

        $attackDamage = $this->calculateAttackStrength($attackRobot, $targetRobot);

        $targetHealth = $targetRobot->getHealth();
        $reducedTargetHealth = $targetHealth - $attackDamage;
        $newHealth = ($reducedTargetHealth <= 0) ? 0 : $reducedTargetHealth;

        $this->output->displaySeparator();
        $this->output->displayAttackStats($compRobotID, $targetRobotID, $attackDamage, $targetHealth, $newHealth);

        if (!$newHealth) {
            echo "Player's robot #" . $targetRobotID . " destroyed !\n";
            $this->human->removeRobot($targetRobotIndex);
            $attackRobot->increaseExperience();
        } else {
            echo "Player's robot #" . $targetRobotID . " damaged \n";
            $targetRobot->setHealth($reducedTargetHealth);
            $this->human->reduceRobotHealth($targetRobotIndex, $reducedTargetHealth);
        }
    }


    public function changeRobot(array &$robotsStock): void
    {

        echo "Action: Computer decided to exchange robot\n";
        echo "Free robots:\n";
        $this->output->displayArmyInfo($robotsStock);
        $this->output->displaySeparator();

        // выбираем случайного свободного робота
        $inRobotIndex = $this->getRandomIndex($robotsStock);
        $inRobotID = $inRobotIndex + 1;
        $inRobot = $robotsStock[$inRobotIndex];

        // выбираем случайного робота компьютера
        $outRobotIndex = $this->getRandomIndex($this->army);
        $outRobotID = $outRobotIndex + 1;
        $outRobot = $this->army[$outRobotIndex];

        echo "Replacement in computer army:\n";
        echo "Robot #{$outRobotID} " . $outRobot->getName() . " out\n";
        echo "Robot #{$inRobotID} " . $inRobot->getName() . " in\n";

        $outRobot->resetExperience();
        $this->army[$outRobotIndex] = $inRobot;
        $robotsStock[$inRobotIndex] = $outRobot;

        echo "New computer army state:\n";
        $this->output->displayArmyInfo($this->army);

        echo "New free robots state:\n";
        $this->output->displayArmyInfo($robotsStock);
    }

    private function getRandomIndex(array $arr): int
    {
        $indexes = array_keys($arr);
        shuffle($indexes);
        return $indexes[0];
    }

}