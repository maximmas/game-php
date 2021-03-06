<?php
/*
 * 'Robot Wars' game entrance point
 *
 *
 * */

use App\Robot;
use App\Round;
use App\Settings;

require_once dirname(__DIR__) . '/vendor/autoload.php';

system('clear');
main();

/**
 * Game entry point
 *
 * @return void
 * @throws Exception
 */
function main()
{
    echo("Press 's' key to start and 'q' to exit\n");
    $input = new \App\KeyboardInput();
    $output = new \App\Output();

    if ($input->getInput(['s', 'q']) === 's') {
        echo "Lets start the game, Player !\n";

        for ($i = 1; $i < Settings::TOTAL_ROUNDS + 1; $i++) {

            $robotsStock = createRobots();

            $human = new \App\HumanPlayer($robotsStock, $output, $input);
            $humanArmy = $human->getArmy();
            $robotsStock = array_diff($robotsStock, $humanArmy);

            $computer = new \App\ComputerPlayer($robotsStock, $output, $input);
            $computerArmy = $computer->getArmy();
            $robotsStock = array_diff($robotsStock, $computerArmy);

            $computer->setOpponent($human);
            $human->setOpponent($computer);

            $round = new Round($i, $robotsStock, $human, $computer, $output, $input);
            $roundResults = $round->run();

            $output->displaySeparator();
            $output->displayRoundResult($roundResults);

            unset($round, $robotsStock, $computer, $human);

            $output->displaySeparator();
            echo "Press 's' for the next round and 'q' for exit \n";

            if($input->getInput(['s','q']) === 'q') {
                die('Bye!\n');
            }

        }

    }
    exit();
}


/**
 * Create stock of robots for further using in the game
 *
 * @return array
 * @throws \Exception
 */
function createRobots(): array
{

    $robots = [];
    $types = Settings::MATERIALS;

    for ($i = 0; $i < 15; $i++) {

        shuffle($types);
        $robots[] = new Robot(
            random_int(Settings::MIN_STRENGTH_VALUE, Settings::MAX_STRENGTH_VALUE),
            random_int(Settings::MIN_AGILITY_VALUE, Settings::MAX_AGILITY_VALUE),
            random_int(Settings::MIN_HEALTH_VALUE, Settings::MAX_HEALTH_VALUE),
            Settings::MIN_EXPERIENCE_VALUE,
            random_int(Settings::MIN_FEATURE_STRENGTH_VALUE, Settings::MAX_FEATURE_STRENGTH_VALUE),
            getUniqueName($robots),
            $types[0]
        );
    }
    return $robots;
}


/**
 * Choose unused name for robot
 *
 * Each robot in the army must have a unique name
 *
 * @param array $robots
 * @return string
 *
 */
function getUniqueName(array $robots): string
{

    $allNames = Settings::NAMES;

    if (!count($robots)) {
        return $allNames[0];
    }

    $usedNames = array_map(fn($robot) => $robot->getName(), $robots);
    $freeNames = array_diff($allNames, $usedNames);

    shuffle($freeNames);
    return $freeNames[0];
}