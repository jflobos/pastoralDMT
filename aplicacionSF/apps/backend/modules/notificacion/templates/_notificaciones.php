<li <?php if($notificaciones->count()>0){ echo 'class="dropdown"';}  ?> style="text-align:left;" id="notifications">
    <a href="#notifications" class="dropdown-toggle" data-toggle="dropdown"><?php echo $notificaciones_nuevas_count?><i class="icon-envelope icon-white"></i></a>
    <ul class="dropdown-menu">
      <?php 
        if($notificaciones_nuevas_count>0){
            echo '<li class="nav-header">Notificaciones Nuevas</li>';
        }
        $bool = 0;
        foreach($notificaciones as $notificacion)
        {
          if($bool == 0 && $notificacion->getLeido()==1)
          {
              echo '<li class="divider"></li>';
              echo '<li class="nav-header">Notificaciones Viejas</li>';
              $bool = 1;
          }
            echo '<li class="divider"></li>';
            echo '<li>';
              echo '<a href="'.url_for('notificacion/show').'?notificacion_id='.$notificacion->getId().'">';
              echo $notificacion->getAsunto().'</br><span style="color:orange;font-size:90%;">'.$notificacion->getEnviado().'</span>'; 
              echo '</a>';
            echo '</li>';
        }
            echo '<li class="divider"></li>';
            echo '<li>';
              echo '<a href="'.url_for('notificacion/index').'" class="nav-header" >';
              echo 'Todas las notificaciones';
              echo '</a>';
            echo '</li>';
      ?>
    </ul>
</li>
