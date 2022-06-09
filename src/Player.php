<?php

namespace App;

/**
 * Basic class for game player
 */
abstract class Player
{

    /**
     * Player's army - set of robots
     *
     * @var array
     *
     */
    protected array $army;

    /**
     * Maximum robots numbers in the army
     *
     * @var int
     *
     */
    protected int $armySize;

    /**
     * Object for output information
     *
     * @var Output
     *
     */
    protected Output $output;

    /**
     *  Object for get commands from keyboard
     *
     * @var KeyboardInput
     *
     */
    protected KeyboardInput $input;


    public function __construct(array $initRobotsStock, Output $output, KeyboardInput $input)
    {
        $this->input = $input;
        $this->output = $output;
        $this->army = $this->createArmy($initRobotsStock);
    }


    /**
     * Method for doing attack
     *
     *
     */
    abstract public function attack(): void;

    abstract public function changeRobot(array &$robotsStock): void;


    /**
     * Army getter
     *
     * @return array
     *
     */
    public function getArmy(): array
    {
        return $this->army;
    }


    /**
     * Create player's army
     *
     * @param array $initRobotsStock
     * @return array
     *
     */
    public function createArmy(array $initRobotsStock): array
    {
        shuffle($initRobotsStock);
        return array_slice($initRobotsStock, 0, $this->armySize);

    }

    protected function removeRobot(int $robotIndex): void
    {
        if (isset($this->army[$robotIndex])) {
            unset($this->army[$robotIndex]);
        }

    }

    public function reduceRobotHealth(int $robotIndex, int $healthValue): void
    {
        if (isset($this->army[$robotIndex])) {
            $robot = $this->army[$robotIndex];
            $robot->setHealth($healthValue);
        }
    }

    /**
     * Calculate attack strength
     *
     * @param Robot $attackRobot Attacker
     * @param Robot $targetRobot Target
     * @return int
     */
    protected function calculateAttackStrength(Robot $attackRobot, Robot $targetRobot): int
    {

        // Feature увеличивает силу атаки
        // ловкость уменьшает силу атаки
        $strength = ($attackRobot->getStrength() + $attackRobot->getFeatureStrength()) - $targetRobot->getAgility();
        $attackType = $attackRobot->getType();
        $targetType = $targetRobot->getType();

        if (($attackType === 'Cooper' && $targetType === 'Paper') ||
            ($attackType === 'Wood' && $targetType === 'Paper') ||
            ($attackType === 'Steel' && $targetType === 'Plastic')
        ) {
            $strength += 2;
        }

        if (($attackType === 'Cooper' && $targetType === 'Plastic') ||
            ($attackType === 'Wood' && $targetType === 'Plastic') ||
            ($attackType === 'Stone' && $targetType === 'Cooper')
        ) {
            ++$strength;
        }

        return $strength;
    }

}