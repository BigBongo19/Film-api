<?php

class Film {
    public $id;
    public $titel;
    public $speelduur;
    public $kijkwijze;
    public $genre;

    public function setID($id){
        $this->id = $id;
    }

    public function getID(){
        return $this->id;
    }

    public function setTitel($titel){
        $this->titel = $titel;
    }

    public function getTitel(){
        return $this->titel;
    }

    public function setSpeelduur($speelduur){
        $this->id = $speelduur;
    }

    public function getSpeelduur(){
        return $this->speelduur;
    }

    public function setKijkwijze($kijkwijze){
        $this->id = $kijkwijze;
    }

    public function getKijkwijze(){
        return $this->kijkwijze;
    }

    public function setGenre($genre){
        $this->id = $genre;
    }

    public function getGenre(){
        return $this->genre;
    }

}
