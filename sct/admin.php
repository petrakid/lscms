<?php
if(!isset($_SESSION['isLoggedIn'])) {
     die;
}
?>

<ul class="nav nav-tabs nav-justified md-tabs indigo" id="adminTabs" role="tablist">
<li class="nav-item">
<a class="nav-link active" id="main-1" data-toggle="tab" href="#main-1" role="tab" aria-controls="main-1" aria-selected="true">Main Settings</a>
</li>
<li class="nav-item">
<a class="nav-link" id="org-2" data-toggle="tab" href="#org-2" role="tab" aria-controls="org-2" aria-selected="false">Organization</a>
</li>
<li class="nav-item">
<a class="nav-link" id="features-3" data-toggle="tab" href="#features-3" role="tab" aria-controls="features-3" aria-selected="false">Features</a>
</li>
<li class="nav-item">
<a class="nav-link" id="misc-4" data-toggle="tab" href="#misc-4" role="tab" aria-controls="misc-4" aria-selected="false">Misc</a>
</li>
</ul>

<div class="tab-content card pt-5" id="adminTabs">
  <div class="tab-pane fade show active" id="main-1" role="tabpanel" aria-labelledby="main-1-tab">


  </div>
  <div class="tab-pane fade" id="org-2" role="tabpanel" aria-labelledby="org-2-tab">


  </div>
  <div class="tab-pane fade" id="features-3" role="tabpanel" aria-labelledby="features-3-tab">


  </div>
  <div class="tab-pane fade" id="misc-4" role="tabpanel" aria-labelledby="misc-4-tab">


  </div>  
</div>
