<?php

namespace Hackathon\PlayerIA;

use Hackathon\Game\Result;
use function Sodium\library_version_major;

/**
 * Class RishiPlayers
 * @package Hackathon\PlayerIA
 * @author DELDUC Louise
 */
class RishiPlayer extends Player
{
    protected $mySide;
    protected $opponentSide;
    protected $result;

    public function getChoice()
    {
        $nbRound = $this->result->getNbRound();
        $opponent_choices = $this->result->getChoicesFor($this->opponentSide);
        $nb_scissors = 0;
        $nb_rocks = 0;
        $nb_papers = 0;

        foreach ($opponent_choices as &$choice) {
            if ($choice == 'rock')
                $nb_rocks += 1;
            elseif ($choice == 'paper')
                $nb_papers += 1;
            else
                $nb_scissors += 1;
        }

        if ($nb_papers > $nb_scissors && $nb_papers > $nb_rocks)
            return parent::paperChoice();
        elseif ($nb_rocks > $nb_papers && $nb_rocks > $nb_scissors)
            return parent::rockChoice();
        else
            return parent::scissorsChoice();
    }
};
