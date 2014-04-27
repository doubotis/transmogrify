<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                      <span class="sr-only">Toggle navigation</span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Transmogrify!</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <?php
                            include_once dirname(__FILE__) . '/../_code/utils/util.php';
                            $link = curPageURL();
                            $link = str_replace("http://www.psyko-foundation.fr/transmogrify/", "", $link);
                            $subClass = "";
                            if (startsWith($link, "index.php")) { $subClass = "active"; } else { $subClass = ""; }
                        ?>
                        <li class="<?php echo $subClass ?>"><a href="/transmogrify/index.php">Home</a></li>
                        <?php
                            if (startsWith($link, "sets.php")) { $subClass = "active"; } else { $subClass = ""; }
                        ?>
                        <li class="<?php echo $subClass ?>"><a href="/transmogrify/sets.php">Sets</a></li>
                        <?php
                            if (startsWith($link, "about.php")) { $subClass = "active"; } else { $subClass = ""; }
                        ?>
                        <li class="<?php echo $subClass ?>"><a href="/transmogrify/about.php">About</a></li>
                    </ul>
                    <?php
                        if (userIsConnected() == false) {
                    ?>
                    <form class="navbar-form navbar-right" role="form" accept-charset="uf-8" method="POST" action="/transmogrify/_code/auth.php?req=login">
                        <div class="form-group">
                          <input type="text" placeholder="Email" name="email" class="form-control" style="width: 180px;">
                        </div>
                        <div class="form-group">
                          <input type="password" placeholder="Password" name="password" class="form-control" style="width: 100px;">
                        </div>
                        <button type="submit" class="btn btn-primary">Sign in</button>
                        <a href="/transmogrify/register.php" class="btn btn-default">Register</a>
                    </form>
                    <?php } else { ?>
                    <div class="navbar-form navbar-right" role="form">
                        <a href="/transmogrify/profile.php" class="btn btn-default">See your Profile</a>
                        <a href="/transmogrify/_code/auth.php?req=logout" class="btn btn-danger">Sign out</a>
                    </div>
                    <?php } ?>
                </div><!--/.nav-collapse -->
                
            </div>
        </div>