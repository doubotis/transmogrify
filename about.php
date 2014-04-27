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
                <h2>About</h2>
            </div>
            <div>
                <h4>Where are you?</h4>
                <p>
                    You are on the <strong>Transmogrify!</strong> website, allowing you to test your World of Warcraft transmogrifications for free.
                </p>
                <div style="margin-bottom: 25px;"></div>
                <h4>Open Source Project</h4>
                <p>
                    The entire project and all basis data of items are open-source. Are called "basis data of items" all information that could be gathered
                    from the World of Warcraft Battle.net API. Open-source project files could be found on GitHub (work in progress).
                </p>
                <div style="margin-bottom: 25px;"></div>
                <h4>F.A.Q.</h4>
                <p>
                    <ul class="list-group">
                        <li class="list-group-item">
                            <strong>I cannot find all items available in the game. Why?</strong><br/>
                            The World of Warcraft database of objects is very huge, so it's take time to us to gather all interesting data. Be patient,
                            the rest of items will be available soon! If you want to help us to get all these data, <a href="">you can help us</a>!
                        </li>
                        <li class="list-group-item">
                            <strong>The Model Viewer doesn't work in smartphones and tablets.</strong><br/>
                            The Model Viewer works with Flash. A lot of mobile devices doesn't support this kind of technology.
                        </li>
                        <li class="list-group-item">
                            <strong>From where the Model Viewer come?</strong><br/>
                            It is the <a href="http://www.wowhead.com">WoWHead</a> Model Viewer.
                        </li>
                    </ul>
                </p>
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
