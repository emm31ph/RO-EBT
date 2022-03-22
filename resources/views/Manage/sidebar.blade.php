   <div style="padding:10px">
       <ul class="list-group ">
           <li class="list-group-item"><small><a href="{{ route('manage.role.index') }}">Roles
                   </a></small></li>

           @if (Auth::user()->hasPermission(['release-import']))
               <li class="list-group-item"><small><a href="{{ route('manage.permission.index') }}">Permissions</a></small>
           @endif
           </li>
           <li class="list-group-item"><small><a href="{{ route('report.index') }}">Report</a></small></li>
            
           
           
       </ul>
   </div>
