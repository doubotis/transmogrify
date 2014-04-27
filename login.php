<!DOCTYPE html>
<?php include_once dirname(__FILE__) . '/_code/web.php'; ?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Transmogrify!</title>
        <?php include_once dirname(__FILE__) . '/_html/head.php'; ?>
    </head>
    <body class="main-site" role="document">
        <?php include_once dirname(__FILE__) . '/_html/body-navbar.php'; ?>
        <div class="container" role="main">
            <div class="page-header">
                <h2>Sign in</h2>
            </div>
            <?php
                printErrorMessagesFromSession();
            ?>
            <div class="well well-lg" style="padding: 50px;">
                <form class="form" role="form" accept-charset="uf-8" method="POST" action="/transmogrify/_code/auth.php?req=login">
                    <div class="row" style="margin-bottom: 30px;">
                        <h4>Please authenticate</h4>
                        <p>Please use your credentials to login to the site.</p>
                        <p></p>
                    </div>
                    <div class="row">
                        <div class="col-xs-4" style="position: relative; top: 7px;">
                            Enter your e-mail:
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group input-group">
                              <span class="input-group-addon">@</span>
                              <input type="text"  name="email" placeholder="Email" class="form-control" value="<?php echo oldPOSTValues("email"); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4" style="position: relative; top: 7px;">
                            Enter your password:
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group">
                              <input type="password"  name="password" placeholder="Password" class="form-control">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Sign in</button>
                    <button type="reset" class="btn btn-default">Reset to defaults</button>
                    <a href="/transmogrify/register.php" class="btn btn-default">Register</a>
                </form>
            </div>
            
            <div class="footer">
            
            </div>
        </div>
        
        <div id="dialog-choose-item-box" class="dialog-box">
            <iframe src="_code/pagelets/choose-item.php" class="dialog-content" id="dialog-choose-item-content" frameborder="0" width="630" height="500"></iframe>
        </div>
        
        <script>
            function checkRegister()
            {
                
            }
        </script>
        
        <script type="text/javascript" src="http://static.wowhead.com/widgets/power.js"></script><script>var wowhead_tooltips = { "colorlinks": false, "iconizelinks": false, "renamelinks": false }</script>
    </body>
</html>
