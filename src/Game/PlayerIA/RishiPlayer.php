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
            return parent::paperChoice();

        $mylastscore = $this->result->getLastScoreFor($this->mySide);
        $opponentlastscore = $this->result->getLastScoreFor($this->opponentSide);
        $mylastaction = $this->result->getLastChoiceFor($this->mySide);
        $opponentlastaction = $this->result->getLastChoiceFor($this->mySide);

        //i won
        if ($mylastscore == $opponentlastscore) {
            if ($mylastaction == 'rock')
                return parent::paperChoice();
            elseif ($mylastaction == 'paper')
                return parent::scissorsChoice();
            return parent::rockChoice();
        }
        //ex equo
        elseif ($mylastscore > $opponentlastscore) {
            if ($mylastaction == 'rock')
                return parent::scissorsChoice();
            elseif ($mylastaction == 'paper')
                return parent::rockChoice();
            return $this->paperChoice();
        }
        //i lost
        else {
            return $opponentlastaction;
        }
       // $otherlast = $this->result->getLastChoiceFor($this->opponentSide);

        //$otherstats = $this->result->getStatsFor($this->opponentSide);
        //print_r($otherstats);
    }
};
