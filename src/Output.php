<?php

namespace App;

class Output
{

    /**
     * Output string with current player or computer army state
     *
     * Army state is a list of active robots with their parameters
     *
     * @param array $army array of robots
     * @return void
     */
    public function displayArmyInfo(array $army): void
    {

        foreach ($army as $index => $robot) {

            if (strlen($robot->getName()) < 6) {
                $name = $robot->getName() . str_repeat(" ", 6 - strlen($robot->getName()));
            } else {
                $name = $robot->getName();
            }

            if (strlen($robot->getType()) < 7) {
                $type = $robot->getType() . str_repeat(" ", 7 - strlen($robot->getType()));
            } else {
                $type = $robot->getType();
            }

            $strength = (strlen((string)$robot->getStrength()) < 2)
                ? $robot->getStrength() . " "
                : $robot->getStrength();
            $feature = (strlen((string)$robot->getFeatureStrength()) < 2)
                ? $robot->getFeatureStrength() . " "
                : $robot->getFeatureStrength();
            $agility = (strlen((string)$robot->getAgility()) < 2)
                ? $robot->getAgility() . " "
                : $robot->getAgility();
            $health = (strlen((string)$robot->getHealth()) < 2)
                ? $robot->getHealth() . " "
                : $robot->getHealth();
            $exp = (strlen((string)$robot->getExperience()) < 2)
                ? $robot->getExperience() . " "
                : $robot->getExperience();

            $msg = "Name: $name | ";
            $msg .= "Type: $type | ";
            $msg .= "Strength: $strength | ";
            $msg .= "Feature: $feature | ";
            $msg .= "Agility: $agility | ";
            $msg .= "Health: $health | ";
            $msg .= "Experience: $exp";
            echo "ID: " . ++$index . " | " . $msg . "\n";
        }
    }


    /**
     * Display result of attack
     *
     *
     * @param int $attackerID
     * @param int $targetID
     * @param int $attackDamage
     * @param int $targetHealth
     * @param int $newHealth
     * @return void
     *
     */
    public function displayAttackStats(
        int $attackerID,
        int $targetID,
        int $attackDamage,
        int $targetHealth,
        int $newHealth
    ): void
    {

        $msg = "Attack statistics:\n";
        $msg .= "Attacker ID: " . $attackerID . PHP_EOL;
        $msg .= "Target ID: " . $targetID . PHP_EOL;
        $msg .= "Attacker strength: $attackDamage ";
        $msg .= " | Target health: " . $targetHealth;
        $msg .= " | New target health: " . $newHealth . PHP_EOL;
        echo $msg;

    }


    /**
     * Display result of round
     *
     * @param array $results Round results: round number, winner, moves number
     * @return void
     *
     */
    public function displayRoundResult(array $results): void
    {

        list($winner, $round, $moves) = $results;

        $msg = "######## Round " . $round . " end ########\n";

        if ($winner === 'player') {
            $msg .= "VICTORY !\n";
            $msg .= "Computer army is beaten !\n";
            $msg .= "Player won!\n";
        } else {
            $msg .= "DEFEAT !\n";
            $msg .= "Player army is beaten !\n";
            $msg .= "Computer won!\n";
        }

        $msg .= "Total moves: " . $moves . PHP_EOL;

        echo $msg;
    }


    /**
     * Output separator line
     *
     * @return void
     */
    public function displaySeparator()
    {
        echo "----------------------------------\n";
    }
}