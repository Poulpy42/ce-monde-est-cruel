<?php

namespace Hackathon\PlayerIA;

use Hackathon\Game\Result;
use function Sodium\library_version_major;

/**
 * Class RishiPlayers
 * @package Hackathon\PlayerIA
 * @author Louise DELDUC
 * @description Selon les statistiques, le choix de commencer par pierre est plus fréquent. Sachant cela, des étudiants
 * voudront commencer par papier. Donc je commence par sciseaux.
 * Le reste de la fonction est découpée en trois parties (sans compter la déclaration des variables).
 * Egalité : je joue l'action qui gagne sur celle que les deux joueurs viennent de faire
 * Je gagne : je joue l'action qui gagne sur l'action qui gagne sur celle qui m'a permis de gagner
 * Je perds : si une action est jouée plus souvent que les deux autres par l'adversaire, je joue celle qui l'a contre
 * Sinon : voire cas où je gagne
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
