<table class="table">
        <thead>
          <tr>
            <th>#</th>
            <th>Pseudo</th>
            <th>Email</th>
            <th>Type</th>
            <th>Last Connexion</th>
          </tr>
        </thead>
        <tbody>
        <?php
            $req = User::get_standard_query();
            $res = db_ask($req);
            for ($i=0; $i < count($res); $i++) {
                $user = User::get_from_array($res[$i]);
        ?>
          <tr id="row-id-<?php echo $user->id ?>" class="objects-row" style="cursor: pointer;" onclick="onSelectRow(<?php echo $user->id ?>);">
            <td><?php echo $user->id ?></td>
            <td><?php echo $user->pseudo ?></td>
            <td><?php echo $user->mail ?></td>
            <td><?php echo $user->type ?></td>
            <td><?php echo $user->last_connected ?></td>
          </tr>
       <?php } ?>
        </tbody>
</table>