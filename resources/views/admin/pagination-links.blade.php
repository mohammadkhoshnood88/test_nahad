
@if ($paginator->hasPages())

<nav>
     <ul class="pagination">
         <li wire:click="previousPage" class="page-item pagination-prev disabled"><a class="page-link" href="#"><i class="zwicon-arrow-left"></i></a></li>
         <li class="page-item active"><a class="page-link" href="#">1 </a></li>
         <li class="page-item"><a class="page-link" href="#">2 </a></li>
         <li class="page-item"><a class="page-link" href="#">3 </a></li>
         <li class="page-item"><a class="page-link" href="#">4 </a></li>
         <li class="page-item"><a class="page-link" href="#">5 </a></li>
         <li class="page-item"><a class="page-link" href="#">6 </a></li>
         <li wire:click="nextPage" class="page-item pagination-next"><a class="page-link" href="#"><i class="zwicon-arrow-right"></i></a></li>
     </ul>
 </nav>

@endif