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

            $info = "Name: $name | ";
            $info .= "Type: $type | ";
            $info .= "Strength: $strength | ";
            $info .= "Feature: $feature | ";
            $info .= "Agility: $agility | ";
            $info .= "Health: $health | ";
            $info .= "Experience: $exp";
            echo "ID: " . ++$index . " | " . $info . "\n";
        }
    }


    public function displayAttackStats(
        int $attackerID,
        int $targetID,
        int $attackDamage,
        int $targetHealth,
        int $newHealth
    ): void
    {

        $stats = "Attack statistics:\n";
        $stats .= "Attacker ID: " . $attackerID . PHP_EOL;
        $stats .= "Target ID: " . $targetID . PHP_EOL;
        $stats .= "Attacker strength: $attackDamage ";
        $stats .= " | Target health: " . $targetHealth;
        $stats .= " | New target health: " . $newHealth . PHP_EOL;
        echo $stats;

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