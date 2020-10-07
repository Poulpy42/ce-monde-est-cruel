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
        if ($nbRound == 0)
            return parent::scissorsChoice();

        $mylastscore = $this->result->getLastScoreFor($this->mySide);
        $opponentlastscore = $this->result->getLastScoreFor($this->opponentSide);
        $mylastaction = $this->result->getLastChoiceFor($this->mySide);
        $opponentlastaction = $this->result->getLastChoiceFor($this->mySide);

        if ($mylastscore == $opponentlastscore) {
            if ($mylastaction == 'rock')
                return parent::paperChoice();
            elseif ($mylastaction == 'paper')
                return parent::scissorsChoice();
            return parent::rockChoice();
        }
        elseif ($mylastscore > $opponentlastscore) {
            if ($mylastaction == 'rock')
                return parent::scissorsChoice();
            elseif ($mylastaction == 'paper')
                return parent::rockChoice();
            return $this->paperChoice();
        }
        else {
            $otherstats = $this->result->getStatsFor($this->opponentSide);
            if ($otherstats['rock'] > $otherstats['paper'] && $otherstats['rock'] > $otherstats['scissors'])
                return parent::paperChoice();
            elseif ($otherstats['paper'] > $otherstats['rock'] && $otherstats['paper'] > $otherstats['scissors'])
                return parent::scissorsChoice();
            elseif ($otherstats['scissors'] > $otherstats['paper'] && $otherstats['scissors'] > $otherstats['rock'])
                return parent::rockChoice();
            elseif ($opponentlastaction == 'scissors')
                return parent::paperChoice();
            elseif ($opponentlastaction == 'rock')
                return parent::scissorsChoice();
            return parent::rockChoice();
        }
    }
};
