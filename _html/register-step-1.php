<div class="well well-lg" style="padding: 50px;">
    <form class="form" role="form" accept-charset="uf-8" method="POST" action="/transmogrify/_code/action-base.php?req=register">
        <div class="row" style="margin-bottom: 30px;">
            <h4>Credentials</h4>
            <p>In order to allow registering you, we need some information about the credentials you want to use.</p>
            <p></p>
        </div>
        <div class="row">
            <div class="col-lg-3" style="position: relative; top: 7px;">
                Enter your pseudo:
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                  <input type="text"  name="pseudo" placeholder="Pseudo" class="form-control" value="<?php echo oldPOSTValues("pseudo"); ?>">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3" style="position: relative; top: 7px;">
                Enter your e-mail:
            </div>
            <div class="col-lg-6">
                <div class="form-group input-group">
                  <span class="input-group-addon">@</span>
                  <input type="text"  name="email" placeholder="Email" class="form-control" value="<?php echo oldPOSTValues("email"); ?>">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3" style="position: relative; top: 7px;">
                Enter your password:
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                  <input type="password"  name="password" placeholder="Password" class="form-control">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3" style="position: relative; top: 7px;">
                Retape your password:
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                  <input name="retape-password" type="password" placeholder="Retape your password" class="form-control">
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-success">Register</button>
        <button type="reset" class="btn btn-default">Reset to defaults</button>
    </form>
</div>