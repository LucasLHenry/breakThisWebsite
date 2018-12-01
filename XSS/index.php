<!DOCTYPE html>
  <html>
    <head>
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width,intital-scale=1.0" />
      <title>Try out XSS</title>
      <script type="text/javascript" src="jquery.min.js"></script>
      <link rel="stylesheet" type="text/css" href="styles.css" />
      <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    </head>
    <body>
        <div id="page-header-div">
            <div id="page-title-div">
                <h1 id="title-h1">Practice XSS</h1>
                <p id="title-p">Different websites will have different levels of security, and here we have four input boxes
                  that employ different levels of security:<br> easy, medium, hard, and literally impossible. When you write something in the
                  box and hit enter, the text you wrote will be displayed back (or maybe not!)
                </p>
            </div>
        </div>
        <div id="page-body">
            <div id="easy-container" class="XSS-div">
                <h2 id="easy-title" class="mode-title">EASY MODE</h4>
                <form action="<?php $_PHP_SELF ?>" method="POST">
                    <textarea class="XSS-input" type="text" name="easy-mode" rows="6"></textarea>
                    <br>
                    <input type="submit" value="XSS me!"/>
                </form>
                <div class="output">
                    <p id="before-php-p">Your writing:</p>
                    <?php
                        if (isset($_POST["easy-mode"])) {
                            echo $_POST["easy-mode"];
                        }
                    ?>
                </div>
            </div>
            <div id="medium-container" class="XSS-div">
                <h2 id="medium-title" class="mode-title">MEDIUM MODE</h4>
                <form action="<?php $_PHP_SELF ?>" method="POST">
                    <textarea class="XSS-input" type="text" name="medium-mode" rows="6"></textarea>
                    <br>
                    <input type="submit" value="XSS me!"/>
                </form>
                <div class="output">
                    <p id="before-php-p">Your writing:</p>
                    <?php
                        $messages = array("Not gonna fly, Buckaroo! Ya got caught!", "Good try, but no cigar.", 
                        "You thought you could get past THIS security?!", "Not gonna happen. Better luck next time!");
                        if (isset($_POST["medium-mode"])) {
                            $input = $_POST["medium-mode"];
                            if (preg_match("/<script/i", $input)) {
                                $rand = rand(0, count($messages)-1);
                                if (rand(0, 100) === 0) echo "<script>window.location.replace('../hacked.html');</script>";
                                else echo $messages[$rand];
                            } else {
                                echo $input;
                            }
                        }
                    ?>
                </div>
            </div>
            <div id="hard-container" class="XSS-div">
                <h2 id="hard-title" class="mode-title">HARD MODE</h4>
                <form action="<?php $_PHP_SELF ?>" method="POST">
                    <textarea class="XSS-input" type="text" name="hard-mode" rows="6"></textarea>
                    <br>
                    <input type="submit" value="XSS me!"/>
                </form>
                <div class="output">
                    <p id="before-php-p">Your writing:</p>
                    <?php
                        $messages = array("Not gonna fly, Buckaroo! Ya got caught!", "Good try, but no cigar.", 
                        "You thought you could get past THIS security?!", "Not gonna happen. Better luck next time!");
                        if (isset($_POST["hard-mode"])) {
                            $input = $_POST["hard-mode"];
                            $notAllowed = array("/<script/i", "/javascript:/i", "/\sonclick\s*=/i", "/\sonerror\s*=/i"); // regex
                            $caught = false;
                            for ($i = 0; $i < count($notAllowed); $i++) {
                                if (preg_match($notAllowed[$i], $input)) {
                                    $caught = true;
                                    break;
                                }
                            }
                            if ($caught) {
                                $rand = rand(0, count($messages)-1);
                                if (rand(0, 100) === 0) echo "<script>window.location.replace('../hacked.html');</script>";
                                else echo $messages[$rand];
                            } else {
                                echo $input;
                            }
                        }
                    ?>
                </div>
            </div>
            <div id="literally-impossible-container" class="XSS-div">
                <h2 id="literally-impossible-title" class="mode-title">LITERALLY IMPOSSIBLE MODE</h4>
                <form action="<?php $_PHP_SELF ?>" method="POST">
                    <textarea class="XSS-input" type="text" name="literally-impossible-mode" rows="6"></textarea>
                    <br>
                    <input type="submit" value="XSS me!"/>
                </form>
                <div class="output">
                    <p id="before-php-p">Your writing:</p>
                    <?php
                        $messages = array("It really just doesn't work", "You're never going to do it", "It's impossible",
                          "No matter how many things you try, it won't work", "Trust me, you're going to keep on failing");
                        if (isset($_POST["literally-impossible-mode"])) {
                            $input = $_POST["literally-impossible-mode"];
                            $input = str_replace("<", "&lt", $input);
                            $input = str_replace(">", "&gt", $input);
                            echo $input . "<br>" . $messages[rand(0, count($messages) - 1)];
                        }
                    ?>
                </div>
            </div>
        </div>
    </body>
    <!-- To prevent having to do prg -->
    <script> 
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>
  </html>
