<?php

function _generateFooter($jaar){
//    $footer = "<footer><div class='container-fluid'><div class='row'><div class='col border'>";
//    $footer = "<h4 class='text-center'>&copy;  $jaar</h4></div></div></div><footer>";

    $footer = "<!-- Footer -->
<footer class=\"page-footer font-small blue pt-4\">

  <!-- Footer Links -->
  <div class=\"container-fluid text-center text-md-center\">

    <!-- Grid row -->
    <div class=\"row bg-transparent\">

      <!-- Grid column -->
      <div class=\"col-md-6 mt-md-0 mt-3\">

        <!-- Content -->
        <h5 class=\"text-uppercase\">Over ons</h5>
        <p>Here you can use rows and columns to organize your footer content.</p>

      </div>
      <!-- Grid column -->

      <hr class=\"clearfix w-100 d-md-none pb-3\">

      <!-- Grid column -->
      <div class=\"col-md-3 mb-md-0 mb-3\">

        <!-- Links -->
        <h5 class=\"text-uppercase\">Links</h5>

        <ul class=\"list-unstyled\">
          <li>
            <a href=\"#!\">Link 1</a>
          </li>
          <li>
            <a href=\"#!\">Link 2</a>
          </li>
          <li>
            <a href=\"#!\">Link 3</a>
          </li>
          <li>
            <a href=\"#!\">Link 4</a>
          </li>
        </ul>

      </div>
      <!-- Grid column -->

      <!-- Grid column -->
      <div class=\"col-md-3 mb-md-0 mb-3\">

        <!-- Links -->
        <h5 class=\"text-uppercase\">Links</h5>

        <ul class=\"list-unstyled\">
          <li>
            <a href=\"#!\">Link 1</a>
          </li>
          <li>
            <a href=\"#!\">Link 2</a>
          </li>
          <li>
            <a href=\"#!\">Link 3</a>
          </li>
          <li>
            <a href=\"#!\">Link 4</a>
          </li>
        </ul>

      </div>
      <!-- Grid column -->

    </div>
    <!-- Grid row -->

  </div>
  <!-- Footer Links -->

  <!-- Copyright -->
  <div class=\"footer-copyright text-center py-3\">©  $jaar Copyright:
    <a href=\"https://iproject12.icasites.com/\"> Eenmaal Andermaal</a>
  </div>
  <!-- Copyright -->

</footer>";


    return $footer;
}

