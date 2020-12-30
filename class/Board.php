<?php

    /**
     * Class Board
     * Author Fredrik Skoglind, 2020
     */
    class Board {
        const BRICK_RESET = 0;
        const BRICK_X = 1;
        const BRICK_O = -1;
        
        const EMPTY_BOARD = [ [ 0, 0, 0 ], [ 0, 0, 0 ], [ 0, 0, 0 ] ];

        private $bricks = self::EMPTY_BOARD;

        public function resetBoard() {
            $this->bricks = self::EMPTY_BOARD;
        }

        public function getBoard() : array {
            return $this->bricks;
        }

        public function setBoard( array $board ) {
            if( $this->isValidBoard( $board ) ) {
                $this->bricks = $board;
            }
        }

        public function setBrick( int $y, int $x, int $brickType = self::BRICK_RESET ) : bool {
            if( !$this->isBrickSet( $y, $x ) ) {
                switch( $brickType ) {
                    case self::BRICK_X:
                    case self::BRICK_O:
                    case self::BRICK_RESET:
                        $this->bricks[$y][$x] = $brickType;
                        break;
                    default:
                        throw new Exception('Wrong brick type');
                }
                return true;
            } else {
                return false;
            }
        }

        public function isValidBoard( $board ) : bool {
            if( !is_null($board) && is_array( $board ) && count( $board ) == 3 ) {
                if( is_array( $board[0] ) && count( $board[0] ) == 3 &&
                    is_array( $board[1] ) && count( $board[1] ) == 3 &&
                    is_array( $board[2] ) && count( $board[2] ) == 3 ) {
                    return true;
                }
            }
            return false;
        }

        public function isBrickSet( int $y, int $x ) : bool {
            if( $this->bricks[$y][$x] != self::BRICK_RESET ) {
                return true;
            } return false;
        }

        public function isBoardFull() : bool {
            for( $y = 0; $y < 3; $y++ ) {
                for( $x = 0; $x < 3; $x++ ) {
                    if( $this->bricks[$y][$x] == self::BRICK_RESET ) {
                        return false;
                    }
                }
            }
            return true;
        }

        public function nextBrickType() : int {
            $cntX = 0; $cntO = 0;

            for( $y = 0; $y < 3; $y++ ) {
                for( $x = 0; $x < 3; $x++ ) {
                    switch( $this->bricks[$y][$x] ) {
                        case self::BRICK_X: $cntX++; break;
                        case self::BRICK_O: $cntO++; break;
                    }
                }
            }
        
            return $cntX > $cntO ? self::BRICK_O : self::BRICK_X;
        }

        public function getWinner() : int {
            $arrX = [ self::BRICK_X, self::BRICK_X, self::BRICK_X ];
            $arrO = [ self::BRICK_O, self::BRICK_O, self::BRICK_O ];

            // Check horizontal lines, 3 options
            for( $i = 0; $i < 3; $i++ ) {
                if( $this->bricks[$i] == $arrX ) { return self::BRICK_X; }
                if( $this->bricks[$i] == $arrO ) { return self::BRICK_O; }
            }

            // Check vertical lines, 3 options
            for( $i = 0; $i < 3; $i++ ) {
                if( [ $this->bricks[0][$i], $this->bricks[1][$i], $this->bricks[2][$i] ] == $arrX ) { return self::BRICK_X; }
                if( [ $this->bricks[0][$i], $this->bricks[1][$i], $this->bricks[2][$i] ] == $arrO ) { return self::BRICK_O; }
            }

            // Check diagonal [left -> right]
            if( [ $this->bricks[0][0], $this->bricks[1][1], $this->bricks[2][2] ] == $arrX ) { return self::BRICK_X; }
            if( [ $this->bricks[0][0], $this->bricks[1][1], $this->bricks[2][2] ] == $arrO ) { return self::BRICK_O; }

            // Check diagonal [right -> left]
            if( [ $this->bricks[0][2], $this->bricks[1][1], $this->bricks[2][0] ] == $arrX ) { return self::BRICK_X; }
            if( [ $this->bricks[0][2], $this->bricks[1][1], $this->bricks[2][0] ] == $arrO ) { return self::BRICK_O; }

            return self::BRICK_RESET;
        }
    }

?>