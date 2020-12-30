<?php

    /**
     * Class TicTacToe
     * Author Fredrik Skoglind, 2020
     */
    class TicTacToe {
        const SESSION_SAVE = 'TTT_GAME_BOARD';

        public function __construct() {
            $this->board = new Board();
            if( $this->hasSavedGame() ) {
                $this->loadGame();
            }
        }

        public function hasSavedGame() : bool {
            $saveState = isset($_SESSION[ self::SESSION_SAVE ]) ? $_SESSION[ self::SESSION_SAVE ] : null;
            if( $this->board->isValidBoard( $saveState ) ) { return true; }
            return false;
        }

        public function loadGame() {
            $saveState = isset($_SESSION[ self::SESSION_SAVE ]) ? $_SESSION[ self::SESSION_SAVE ] : null;
            $this->board->setBoard( $saveState );
        }

        public function saveGame() {
            $_SESSION[ self::SESSION_SAVE ] = $this->board->getBoard();
        }

        public function resetGame() {
            unset($_SESSION[ self::SESSION_SAVE ]);
            $this->board->resetBoard();
            $this->saveGame();
        }

        public function addBrick( int $y, int $x ) {
            if( $this->getWinner() == Board::BRICK_RESET ) {
                $this->board->setBrick( $y, $x, $this->board->nextBrickType() );
                $this->saveGame();
            }
        }

        public function getWinner() : int {
            return $this->board->getWinner();
        }

        public function getGame() : array {
            return $this->board->getBoard();
        }
    }

?>