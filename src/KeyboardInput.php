<?php

namespace App;


/**
 *  Class for getting keyboard input
 *
 */
class KeyboardInput
{


    private string $wrongInputMessage = "Wrong input, try again \n";

    /**
     * Keyboard input listener
     *
     * @param array $expectedCommands Array of string values with expected keys
     * @return string
     */
    public function getInput(array $expectedCommands): string
    {

        $isUserInputListen = true;
        $input = '';
        $res = fopen("php://stdin", "r");

        do {
            $input = rtrim(fgets($res));
            $isUserInputListen = !in_array($input, $expectedCommands, true);
            if (in_array($input, $expectedCommands, true)) {
                $isUserInputListen = false;
            } else {
                echo $this->wrongInputMessage;
            }
        } while ($isUserInputListen);
        fclose($res);
        return $input;
    }


}