<?php 
    
    session_start();

    // Front functions
    function replaceWithChr( int $k ) {
        switch( $k ) {
            case Board::BRICK_X: return 'X'; break;
            case Board::BRICK_O: return 'O'; break;
            default: return '&nbsp;';
        }
    }

    // Load class files
    require_once( 'class/Board.php' );
    require_once( 'class/TicTacToe.php' );

    // Input
    $reset  = isset($_GET['reset']) ? (int)$_GET['reset'] : 0;    
    $inputX = isset($_GET['x']) ? (int)$_GET['x'] : -1;
    $inputY = isset($_GET['y']) ? (int)$_GET['y'] : -1;

    // Initiate game
    $ttt = new TicTacToe();

    // Handle user input
    if( $reset > 0 ) { $ttt->resetGame(); }
    if( $inputX > -1 && $inputX < 3 && $inputY > -1 && $inputY < 3 ) {
        $ttt->addBrick( $inputY, $inputX );
    }

    // Get board
    $game = $ttt->getGame();
?>
<!DOCTYPE html>
<html lang="sv">
    <head>
        <meta charset="utf-8">
        <title> Tic Tac Toe </title>
        <meta author="Fredrik Skoglind, 2020">
    </head>
    <body>

        <h1>Tic Tac Toe</h1>

        <table border=1 cellspacing=0 cellpadding=10>
            <?php if( $ttt->getWinner() != Board::BRICK_RESET ): ?>
                <tr>
                    <td colspan=3>
                        WINNER: <?php echo replaceWithChr($ttt->getWinner()) ?>
                    </td>
                </tr>
            <?php endif; ?>
            <?php for( $y = 0; $y < 3; $y++ ): ?>
                <tr>
                    <?php for( $x = 0; $x < 3; $x++ ): ?>
                        <td style="cursor: pointer;" onclick="location.href='?x=<?php echo $x; ?>&amp;y=<?php echo $y; ?>'"> <?php echo replaceWithChr($game[$y][$x]) ?> </td>
                    <?php endfor; ?>
                </tr>
            <?php endfor; ?>
            <tr>
                <td colspan=3 style="cursor: pointer;" onclick="location.href='?reset=1'">
                    RESET GAME
                </td>
            </tr>
        </table>

    </body>
</html>