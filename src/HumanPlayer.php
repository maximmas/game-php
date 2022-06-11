<?php

namespace App;

class HumanPlayer extends Player
{

    private ComputerPlayer $computer;

    public function __construct(array $initRobotsStock, Output $output, KeyboardInput $input)
    {
        $this->armySize = Settings::MAX_HUMAN_ARMY_SIZE;
        parent::__construct($initRobotsStock, $output, $input);
    }


    /**
     * Set opponent player instance
     *
     * @param ComputerPlayer $computer
     * @return void
     *
     */
    public function setOpponent(ComputerPlayer $computer): void
    {
        $this->computer = $computer;
    }

    public function attack(): void
    {
        echo "----------------------------------\n";
        echo "Go fighting!\n";

        $playerArmyKeys = array_keys($this->army);
        $allowedKeys = array_map(fn($value): string => (string)++$value, $playerArmyKeys);

        echo "Choose player robot ID to attack: ";
        echo implode(',', $allowedKeys) . PHP_EOL;
        $playerRobotID = (int)$this->input->getInput($allowedKeys);
        $playerRobotIndex = $playerRobotID - 1;
        $attackRobot = $this->army[$playerRobotIndex];
        echo "Player robot #{$playerRobotID} " . $attackRobot->getName() . " ready to attack\n";

        echo "Choose target - computer's robot ID: ";

        $targetArmy = $this->computer->getArmy();
        $compArmyKeys = array_keys($targetArmy);
        $allowedKeys = array_map(
            fn($value): string => (string)++$value,
            $compArmyKeys
        );

        echo implode(',', $allowedKeys) . PHP_EOL;
        $targetRobotID = (int)$this->input->getInput($allowedKeys);
        $targetRobotIndex = $targetRobotID - 1;
        $targetRobot = $targetArmy[$targetRobotIndex];

        echo "Computer robot #{$targetRobotID} " . $targetRobot->getName() . " ready to defend\n";

        echo "Attack starts ...\n";
        sleep(1);
        system('clear');
        echo "######## Good shoot! ######## \n";
        echo "\n";

        $targetHealth = $targetRobot->getHealth();

        $attackDamage = $this->calculateAttackStrength($attackRobot, $targetRobot);

        $reducedTargetHealth = $targetHealth - $attackDamage;
        $newHealth = ($reducedTargetHealth <= 0) ? 0 : $reducedTargetHealth;

        $this->output->displayAttackStats(
            $playerRobotID,
            $targetRobotID,
            $attackDamage,
            $targetHealth,
            $newHealth
        );

        if (!$newHealth) {
            echo "Computer's robot #" . $targetRobotID . " destroyed !\n";
            echo "\n";
            $this->computer->removeRobot($targetRobotIndex);
            $attackRobot->increaseExperience();
        } else {
            echo "Computer's robot #" . $targetRobotID . " damaged \n";
            echo "\n";
            $this->computer->reduceRobotHealth($targetRobotIndex, $reducedTargetHealth);
        }
    }


    public function changeRobot(array &$robotsStock): void
    {
        echo "Free robots to exchange:\n";

        $this->output->displayArmyInfo($robotsStock);
        $this->output->displaySeparator();

        $freeRobotsKeys = array_keys($robotsStock);
        $allowedKeys = array_map(fn($value): string => (string)++$value, $freeRobotsKeys);

        echo "Choose free robot ID to get into your army: ";
        echo implode(',', $allowedKeys) . PHP_EOL;
        $inRobotID = (int)$this->input->getInput($allowedKeys);
        $inRobotIndex = $inRobotID - 1;
        $inRobot = $robotsStock[$inRobotIndex];

        echo "Choose player robot ID to exchange: \n";
        $playerArmyKeys = array_keys($this->army);
        $allowedKeys = array_map(fn($value): string => (string)++$value, $playerArmyKeys);
        echo implode(',', $allowedKeys) . PHP_EOL;

        $outRobotID = (int)$this->input->getInput($allowedKeys);
        $outRobotIndex = $outRobotID - 1;
        $outRobot = $this->army[$outRobotIndex];

        echo "Replacement in player army:\n";
        echo "Robot #{$outRobotID} " . $outRobot->getName() . " out\n";
        echo "Robot #{$inRobotID} " . $inRobot->getName() . " in\n";

        $outRobot->resetExperience();
        $this->army[$outRobotIndex] = $inRobot;
        $robotsStock[$inRobotIndex] = $outRobot;

        echo "New player army state:\n";
        $this->output->displayArmyInfo($this->army);

        echo "New free robots state:\n";
        $this->output->displayArmyInfo($robotsStock);
    }


    public function upgrade(): void
    {

        $robotsToUpgrade = array_filter(
            $this->army,
            fn($robot): bool => $robot->getExperience() >= Settings::MAX_EXPERIENCE_VALUE
        );

        if (!count($robotsToUpgrade)) {
            echo "You don't have robots to upgrade yet \n";
        }

        $upgradeKeys = array_keys($robotsToUpgrade);
        $allowedKeys = array_map(fn($value): string => (string)++$value, $upgradeKeys);
        echo "Choose player robot ID to upgrade: ";
        echo implode(',', $allowedKeys) . PHP_EOL;
        $upgradeRobotID = (int)$this->input->getInput($allowedKeys);
        $upgradeRobotIndex = $upgradeRobotID - 1;
        $upgradeRobot = $this->army[$upgradeRobotIndex];
        echo "Player robot #{$upgradeRobotID} " . $upgradeRobot->getName() . " ready to upgrade\n";
        echo "Upgrade starts...\n";
        sleep(1);
        $upgradeRobot->resetExperience();

        $health = $upgradeRobot->getHealth();
        $strength = $upgradeRobot->getStrength();
        $agility = $upgradeRobot->getAgility();

        $upgradeRobot->setHealth($health + 2);
        $upgradeRobot->setStrength($strength + 1);
        $upgradeRobot->setAgility($agility + 2);

        $this->output->displaySeparator();
        echo "Player robot #{$upgradeRobotID} " . $upgradeRobot->getName() . "  upgraded\n";
        echo "Strength increased from $strength to " . $upgradeRobot->getStrength() . PHP_EOL;
        echo "Agility increased from $agility to " . $upgradeRobot->getAgility() . PHP_EOL;
        echo "Health increased from $health to " . $upgradeRobot->getHealth() . PHP_EOL;
        $this->output->displaySeparator();

    }


}