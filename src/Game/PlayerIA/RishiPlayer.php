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
        $mylast = $this->result->getLastChoiceFor($this->mySide);
        if ($mylast == 'rock')
            return parent::paperChoice();
        elseif ($mylast == 'paper')
            return parent::scissorsChoice();
        else
            return parent::rockChoice();
    }
};
