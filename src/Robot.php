<?php

namespace App;

class Robot
{
    protected int $strength;
    protected int $featureStrength;
    protected int $health;
    protected int $agility;
    protected int $experience;
    protected string $type;
    protected string $name;

    public function __construct(
        int    $initialStrength,
        int    $initialAgility,
        int    $initialHealth,
        int    $initialExperience,
        int    $initialFutureStrength,
        string $name,
        string $type
    )
    {
        $this->experience = $initialExperience;
        $this->agility = $initialAgility;
        $this->health = $initialHealth;
        $this->strength = $initialStrength;
        $this->featureStrength = $initialFutureStrength;
        $this->name = $name;
        $this->type = $type;
    }

    /**
     * Return basic strength value
     *
     * @return int
     */
    public function getStrength(): int
    {
        return $this->strength;
    }

    public function setStrength(int $strength): void
    {
        $this->strength = $strength;
    }

    public function getFeatureStrength(): int
    {
        return $this->featureStrength;
    }

    public function setHealth(int $health): void
    {
        $this->health = $health;
    }

    public function getHealth(): int
    {
        return $this->health;
    }

    public function setAgility(int $agility): void
    {
        $this->agility = $agility;
    }

    public function getAgility(): int
    {
        return $this->agility;
    }

    public function getExperience(): int
    {
        return $this->experience;
    }

    public function resetExperience(): void
    {
        $this->experience = 0;
    }

    public function increaseExperience(): void
    {
        $this->experience = ($this->experience < Settings::MAX_EXPERIENCE_VALUE)
            ? ++$this->experience
            : Settings::MAX_EXPERIENCE_VALUE;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }


    public function __toString()
    {
        return
            $this->name .
            $this->type .
            $this->experience .
            $this->featureStrength .
            $this->strength .
            $this->agility .
            $this->health;
    }
}