<?php

namespace App;


abstract class Settings
{
    /*
     * How many rounds in the game
     *
     * */
    public const TOTAL_ROUNDS = 1;

    public const MAX_HUMAN_ARMY_SIZE = 6;
    public const MAX_COMPUTER_ARMY_SIZE = 4;

    // кто ходит первый
//    public const MOVE_FIRST = 'computer';
    public const MOVE_FIRST = 'player';

    public const MIN_STRENGTH_VALUE = 1;
//    public const MAX_STRENGTH_VALUE = 5;
    public const MAX_STRENGTH_VALUE = 10;

    public const MIN_HEALTH_VALUE = 3;
    public const MAX_HEALTH_VALUE = 12;

    public const MIN_EXPERIENCE_VALUE = 0;

    // максимальное значение, после которого робота можно апгрейдить
    public const MAX_EXPERIENCE_VALUE = 2;

    public const MIN_AGILITY_VALUE = 0;
    public const MAX_AGILITY_VALUE = 4; // max agility = max strength - 1

    public const MIN_FEATURE_STRENGTH_VALUE = 0;
    public const MAX_FEATURE_STRENGTH_VALUE = 3;

    public const NAMES = [
        'Amber',
        'Bob',
        'Cris',
        'Dan',
        'Ethan',
        'Frank',
        'Grunt',
        'Ivy',
        'John',
        'Kyle',
        'Luke',
        'Candy',
        'Vit',
        'Queen',
        'Rambo',
        'Tor',
        'Yankee',
        'Ulisse',
        'Isis',
        'Omar',
        'Pierce',
        'Sam',
        'Matt',
        'Stan',
        'R2D2',
        'Duff'
    ];

    public const MATERIALS = ['Plastic', 'Cooper', 'Paper', 'Wood', 'Stone', 'Steel'];

}