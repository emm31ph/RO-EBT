 {{-- <ul class="list-group ">
     @permission(['release-read'])
     <li class="list-group-item"><a href="{{ route('ro.index') }}">Dasboard
             </a></li>
     @endpermission
     @if (Auth::user()->hasPermission(['release-import']))
     <li class="list-group-item"><a href="{{ route('release.import') }}">Import</a>
         @endif
     </li>
     @permission(['release-release order list'])
     <li class="list-group-item"><a href="{{ route('release.list') }}">Release Order
                 List</a></li>
     @endpermission
     @permission(['release-delivery list'])
     <li class="list-group-item"><a href="{{ route('release.delivery') }}">Delivered List</a>
     </li>

     @endpermission


 </ul> --}}
 <div class="sidenav">
     @permission(['release-read'])
     <a href="{{ route('ro.index') }}">Dasboard</a>
     @endpermission

     @if (Auth::user()->hasPermission(['release-import']))
     <a href="{{ route('release.import') }}">Import</a>
     @endif

     @permission(['release-release order list'])
     <button class="dropdown-btn text-primary">Release Order
         <i class="fa fa-caret-down"></i>
     </button>
     <div class="dropdown-container"> 
         <a href="{{ route('release.listUnprocess') }}" >Unprocess</a>
         <a href="{{ route('release.listProcess') }}">Process</a>
     </div>
     @endpermission
     @permission(['release-delivery list'])
     <a href="{{ route('release.delivery') }}">Delivered List</a>
     @endpermission
 </div>

 @push('js1')
  <script>
  

//* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
var dropdown = document.getElementsByClassName("dropdown-btn");
var i;

for (i = 0; i < dropdown.length; i++) {
  dropdown[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var dropdownContent = this.nextElementSibling;
    if (dropdownContent.style.display === "block") {
      dropdownContent.style.display = "none";
    } else {
      dropdownContent.style.display = "block";
    }
  });
}
  </script>
 @endpush