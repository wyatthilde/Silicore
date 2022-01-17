<?php
/* * *****************************************************************************************************************************************
 * File Name: itServerStatus.php
 * Project: Silicore
 * Description:
 * Notes:
 * =========================================================================================================================================
 * Change Log ([MM/DD/YYYY]|[Developer]|[Task Ticket] - [Description])
 * =========================================================================================================================================
 * 04/03/2019|nolliff|KACE:xxxxx - Initial creation
 *
 * **************************************************************************************************************************************** */


//======================================================================================== BEGIN PHP
$permissionLevel = $userPermissionsArray['vista']['granbury']['it'];
//echo $permissionLevel;
//========================================================================================== END PHP
?>
<meta http-equiv="refresh" content="3600" >
<style>
  .main-card
  {
    width:75%;
    margin: 0 auto; /* Added */
    float: none; /* Added */
    margin-bottom: 10px; /* Added */
  }
  .main-header
  {
    /*border-color: #007bff*/ 
  }
  .color-button
  {
    padding:.1rem
  }
</style>
  <div id="last-update"></div>
  <br>
<div class="container">

  <div class="card-columns"
       <!--granbury-->
       <div class="card main-card" id='granbury-card'>
      <div class='card-header main-header'><h5 class="card-title">Granbury</h5></div>
      <div class="card-body collapse">
        <div class="card-deck">
          <div class="card network-card">
            <div class="card-header network-header">
              <h6 class="card-title text-center">Network</h6>
            </div>
            <div class="card-body">
              <div class='server-att'>
                <h6 class="card-title text-center">AT&T</h6>
                <p class="card-text text-center att-p" data-toggle="tooltip" data-placement="right"><span><i class="fas fa-ethernet text-success att-icon"></i></span></p>
              </div>
              <p class="card-text text-center"><span><i class="fas fa-arrow-down "></i></span></p>
              <div class='server-gateway'>
                <h6 class="card-title text-center">Local Gateway</h6>
                <p class="card-text text-center gateway-p" data-toggle="tooltip" data-placement="right"><span><i id='gateway-icon' class="fas fa-ethernet text-success gateway-icon"></i></span></p>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-header server-header">
              <h6 class="card-title text-center ">Servers</h6>
            </div>
            <div class="card-body">
              <h6 class="card-title text-center server-name"></h6>
              <p class="card-text text-center server-p" data-toggle="tooltip" data-placement="right" ><span><i class="fas fa-server text-success server-icon"></i></span></p>
            </div>
          </div>
        </div>
        <button type="button" class="alert-btn btn btn-success">Alerts On</button>
      </div>
    </div>
    <!--58 acres-->
    <div class="card main-card" id='58_acres-card'>
      <div class='card-header main-header'><h5 class="card-title">58 Acres</h5></div>
      <div class="card-body collapse">
        <div class="card-deck">
          <div class="card network-card">
            <div class="card-header network-header">
              <h6 class="card-title text-center">Network</h6>
            </div>
            <div class="card-body">
              <div class='server-att'>
                <h6 class="card-title text-center">AT&T</h6>
                <p class="card-text text-center att-p" data-toggle="tooltip" data-placement="right"><span><i class="fas fa-ethernet text-success att-icon"></i></span></p>
              </div>
              <p class="card-text text-center"><span><i class="fas fa-arrow-down "></i></span></p>
              <div class='server-gateway'>
                <h6 class="card-title text-center">Local Gateway</h6>
                <p class="card-text text-center gateway-p" data-toggle="tooltip" data-placement="right"><span><i id='gateway-icon' class="fas fa-ethernet text-success gateway-icon"></i></span></p>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-header server-header">
              <h6 class="card-title text-center ">Servers</h6>
            </div>
            <div class="card-body">
              <h6 class="card-title text-center server-name"></h6>
              <p class="card-text text-center server-p" data-toggle="tooltip" data-placement="right" ><span><i class="fas fa-server text-success server-icon"></i></span></p>
            </div>
          </div>
        </div>
        <button type="button" class="alert-btn btn btn-success">Alerts On</button>
      </div>
    </div>
    <!--tolar-->
    <div class="card main-card" id='tolar-card'>
      <div class='card-header main-header'><h5 class="card-title">Tolar</h5></div>
      <div class="card-body collapse">
        <div class="card-deck">
          <div class="card network-card">
            <div class="card-header network-header">
              <h6 class="card-title text-center">Network</h6>
            </div>
            <div class="card-body">
              <div class='server-att'>
                <h6 class="card-title text-center">AT&T</h6>
                <p class="card-text text-center att-p" data-toggle="tooltip" data-placement="right"><span><i class="fas fa-ethernet text-success att-icon"></i></span></p>
              </div>
              <p class="card-text text-center"><span><i class="fas fa-arrow-down "></i></span></p>
              <div class='server-gateway'>
                <h6 class="card-title text-center">Local Gateway</h6>
                <p class="card-text text-center gateway-p" data-toggle="tooltip" data-placement="right"><span><i id='gateway-icon' class="fas fa-ethernet text-success gateway-icon"></i></span></p>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-header server-header">
              <h6 class="card-title text-center ">Servers</h6>
            </div>
            <div class="card-body">
              <h6 class="card-title text-center server-name"></h6>
              <p class="card-text text-center server-p" data-toggle="tooltip" data-placement="right" ><span><i class="fas fa-server text-success server-icon"></i></span></p>
            </div>
          </div>
        </div>
        <button type="button" class="alert-btn btn btn-success">Alerts On</button>
      </div>
    </div>
    <!--kermit-->
    <div class="card main-card" id='kermit-card'>
      <div class='card-header main-header'><h5 class="card-title">Kermit</h5></div>
      <div class="card-body collapse">
        <div class="card-deck">
          <div class="card network-card">
            <div class="card-header network-header">
              <h6 class="card-title text-center">Network</h6>
            </div>
            <div class="card-body">
              <div class='server-att'>
                <h6 class="card-title text-center">AT&T</h6>
                <p class="card-text text-center att-p" data-toggle="tooltip" data-placement="right"><span><i class="fas fa-ethernet text-success att-icon"></i></span></p>
              </div>
              <p class="card-text text-center"><span><i class="fas fa-arrow-down "></i></span></p>
              <div class='server-gateway'>
                <h6 class="card-title text-center">Local Gateway</h6>
                <p class="card-text text-center gateway-p" data-toggle="tooltip" data-placement="right"><span><i id='gateway-icon' class="fas fa-ethernet text-success gateway-icon"></i></span></p>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-header server-header">
              <h6 class="card-title text-center ">Servers</h6>
            </div>
            <div class="card-body">
              <h6 class="card-title text-center server-name"></h6>
              <p class="card-text text-center server-p" data-toggle="tooltip" data-placement="right" ><span><i class="fas fa-server text-success server-icon"></i></span></p>
            </div>
          </div>
        </div>
        <button type="button" class="alert-btn btn btn-success">Alerts On</button>
      </div>
    </div>
    <!--kermit rail-->
    <div class="card main-card" id='kermit_rail-card'>
      <div class='card-header main-header'><h5 class="card-title">Kermit Rail</h5></div>
      <div class="card-body collapse">
        <div class="card-deck">
          <div class="card network-card">
            <div class="card-header network-header">
              <h6 class="card-title text-center">Network</h6>
            </div>
            <div class="card-body">
              <div class='server-att'>
                <h6 class="card-title text-center">AT&T</h6>
                <p class="card-text text-center att-p" data-toggle="tooltip" data-placement="right"><span><i class="fas fa-ethernet text-success att-icon"></i></span></p>
              </div>
              <p class="card-text text-center"><span><i class="fas fa-arrow-down "></i></span></p>
              <div class='server-gateway'>
                <h6 class="card-title text-center">Local Gateway</h6>
                <p class="card-text text-center gateway-p" data-toggle="tooltip" data-placement="right"><span><i id='gateway-icon' class="fas fa-ethernet text-success gateway-icon"></i></span></p>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-header server-header">
              <h6 class="card-title text-center ">Servers</h6>
            </div>
            <div class="card-body">
              <h6 class="card-title text-center server-name"></h6>
              <p class="card-text text-center server-p" data-toggle="tooltip" data-placement="right" ><span><i class="fas fa-server text-success server-icon"></i></span></p>
            </div>
          </div>
        </div>
        <button type="button" class="alert-btn btn btn-success">Alerts On</button>
      </div>
    </div>
    <!--big lake-->
    <div class="card main-card" id='big_lake-card'>
      <div class='card-header main-header'><h5 class="card-title">Big Lake</h5></div>
      <div class="card-body collapse">
        <div class="card-deck">
          <div class="card network-card">
            <div class="card-header network-header">
              <h6 class="card-title text-center">Network</h6>
            </div>
            <div class="card-body">
              <div class='server-att'>
                <h6 class="card-title text-center">AT&T</h6>
                <p class="card-text text-center att-p" data-toggle="tooltip" data-placement="right"><span><i class="fas fa-ethernet text-success att-icon"></i></span></p>
              </div>
              <p class="card-text text-center"><span><i class="fas fa-arrow-down "></i></span></p>
              <div class='server-gateway'>
                <h6 class="card-title text-center">Local Gateway</h6>
                <p class="card-text text-center gateway-p" data-toggle="tooltip" data-placement="right"><span><i id='gateway-icon' class="fas fa-ethernet text-success gateway-icon"></i></span></p>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-header server-header">
              <h6 class="card-title text-center ">Servers</h6>
            </div>
            <div class="card-body">
              <h6 class="card-title text-center server-name"></h6>
              <p class="card-text text-center server-p" data-toggle="tooltip" data-placement="right" ><span><i class="fas fa-server text-success server-icon"></i></span></p>
            </div>
          </div>
        </div>
        <button type="button" class="alert-btn btn btn-success">Alerts On</button>
      </div>
    </div>
    <!--cleburn-->
    <div class="card main-card" id='cleburne-card'>
      <div class='card-header main-header'><h5 class="card-title">Cleburne</h5></div>
      <div class="card-body collapse">
        <div class="card-deck">
          <div class="card network-card">
            <div class="card-header network-header">
              <h6 class="card-title text-center">Network</h6>
            </div>
            <div class="card-body">
              <div class='server-att'>
                <h6 class="card-title text-center">AT&T</h6>
                <p class="card-text text-center att-p" data-toggle="tooltip" data-placement="right"><span><i class="fas fa-ethernet text-success att-icon"></i></span></p>
              </div>
              <p class="card-text text-center"><span><i class="fas fa-arrow-down "></i></span></p>
              <div class='server-gateway'>
                <h6 class="card-title text-center">Local Gateway</h6>
                <p class="card-text text-center gateway-p" data-toggle="tooltip" data-placement="right"><span><i id='gateway-icon' class="fas fa-ethernet text-success gateway-icon"></i></span></p>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-header server-header">
              <h6 class="card-title text-center ">Servers</h6>
            </div>
            <div class="card-body">
              <h6 class="card-title text-center server-name"></h6>
              <p class="card-text text-center server-p" data-toggle="tooltip" data-placement="right" ><span><i class="fas fa-server text-success server-icon"></i></span></p>
            </div>
          </div>
        </div>
        <button type="button" class="alert-btn btn btn-success">Alerts On</button>
      </div>
    </div>
    <!--dilley-->
    <div class="card main-card" id='dilley-card'>
      <div class='card-header main-header'><h5 class="card-title">Dilley</h5></div>
      <div class="card-body collapse">
        <div class="card-deck">
          <div class="card network-card">
            <div class="card-header network-header">
              <h6 class="card-title text-center">Network</h6>
            </div>
            <div class="card-body">
              <div class='server-att'>
                <h6 class="card-title text-center">AT&T</h6>
                <p class="card-text text-center att-p" data-toggle="tooltip" data-placement="right"><span><i class="fas fa-ethernet text-success att-icon"></i></span></p>
              </div>
              <p class="card-text text-center"><span><i class="fas fa-arrow-down "></i></span></p>
              <div class='server-gateway'>
                <h6 class="card-title text-center">Local Gateway</h6>
                <p class="card-text text-center gateway-p" data-toggle="tooltip" data-placement="right"><span><i id='gateway-icon' class="fas fa-ethernet text-success gateway-icon"></i></span></p>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-header server-header">
              <h6 class="card-title text-center ">Servers</h6>
            </div>
            <div class="card-body">
              <h6 class="card-title text-center server-name"></h6>
              <p class="card-text text-center server-p" data-toggle="tooltip" data-placement="right" ><span><i class="fas fa-server text-success server-icon"></i></span></p>
            </div>
          </div>
        </div>
        <button type="button" class="alert-btn btn btn-success">Alerts On</button>
      </div>
    </div>
    <!--enid-->
    <div class="card main-card" id='enid-card'>
      <div class='card-header main-header'><h5 class="card-title">Enid</h5></div>
      <div class="card-body collapse">
        <div class="card-deck">
          <div class="card network-card">
            <div class="card-header network-header">
              <h6 class="card-title text-center">Network</h6>
            </div>
            <div class="card-body">
              <div class='server-att'>
                <h6 class="card-title text-center">AT&T</h6>
                <p class="card-text text-center att-p" data-toggle="tooltip" data-placement="right"><span><i class="fas fa-ethernet text-success att-icon"></i></span></p>
              </div>
              <p class="card-text text-center"><span><i class="fas fa-arrow-down "></i></span></p>
              <div class='server-gateway'>
                <h6 class="card-title text-center">Local Gateway</h6>
                <p class="card-text text-center gateway-p" data-toggle="tooltip" data-placement="right"><span><i id='gateway-icon' class="fas fa-ethernet text-success gateway-icon"></i></span></p>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-header server-header">
              <h6 class="card-title text-center ">Servers</h6>
            </div>
            <div class="card-body">
              <h6 class="card-title text-center server-name"></h6>
              <p class="card-text text-center server-p" data-toggle="tooltip" data-placement="right" ><span><i class="fas fa-server text-success server-icon"></i></span></p>
            </div>
          </div>
        </div>
        <button type="button" class="alert-btn btn btn-success">Alerts On</button>
      </div>
    </div>
    <!--fort stockton-->
    <div class="card main-card" id='fort_stockton-card'>
      <div class='card-header main-header'><h5 class="card-title">Fort Stockton</h5></div>
      <div class="card-body collapse">
        <div class="card-deck">
          <div class="card network-card">
            <div class="card-header network-header">
              <h6 class="card-title text-center">Network</h6>
            </div>
            <div class="card-body">
              <div class='server-att'>
                <h6 class="card-title text-center">AT&T</h6>
                <p class="card-text text-center att-p" data-toggle="tooltip" data-placement="right"><span><i class="fas fa-ethernet text-success att-icon"></i></span></p>
              </div>
              <p class="card-text text-center"><span><i class="fas fa-arrow-down "></i></span></p>
              <div class='server-gateway'>
                <h6 class="card-title text-center">Local Gateway</h6>
                <p class="card-text text-center gateway-p" data-toggle="tooltip" data-placement="right"><span><i id='gateway-icon' class="fas fa-ethernet text-success gateway-icon"></i></span></p>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-header server-header">
              <h6 class="card-title text-center ">Servers</h6>
            </div>
            <div class="card-body">
              <h6 class="card-title text-center server-name"></h6>
              <p class="card-text text-center server-p" data-toggle="tooltip" data-placement="right" ><span><i class="fas fa-server text-success server-icon"></i></span></p>
            </div>
          </div>
        </div>
        <button type="button" class="alert-btn btn btn-success">Alerts On</button>
      </div>
    </div>
    <!--north fwt-->
    <div class="card main-card" id='north_fwt-card'>
      <div class='card-header main-header'><h5 class="card-title">North FWT</h5></div>
      <div class="card-body collapse">
        <div class="card-deck">
          <div class="card network-card">
            <div class="card-header network-header">
              <h6 class="card-title text-center">Network</h6>
            </div>
            <div class="card-body">
              <div class='server-att'>
                <h6 class="card-title text-center">AT&T</h6>
                <p class="card-text text-center att-p" data-toggle="tooltip" data-placement="right"><span><i class="fas fa-ethernet text-success att-icon"></i></span></p>
              </div>
              <p class="card-text text-center"><span><i class="fas fa-arrow-down "></i></span></p>
              <div class='server-gateway'>
                <h6 class="card-title text-center">Local Gateway</h6>
                <p class="card-text text-center gateway-p" data-toggle="tooltip" data-placement="right"><span><i id='gateway-icon' class="fas fa-ethernet text-success gateway-icon"></i></span></p>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-header server-header">
              <h6 class="card-title text-center ">Servers</h6>
            </div>
            <div class="card-body">
              <h6 class="card-title text-center server-name"></h6>
              <p class="card-text text-center server-p" data-toggle="tooltip" data-placement="right" ><span><i class="fas fa-server text-success server-icon"></i></span></p>
            </div>
          </div>
        </div>
        <button type="button" class="alert-btn btn btn-success">Alerts On</button>
      </div>
    </div>
    <!--south fwt-->
    <div class="card main-card" id='south_fwt-card'>
      <div class='card-header main-header'><h5 class="card-title">South FWT</h5></div>
      <div class="card-body collapse">
        <div class="card-deck">
          <div class="card network-card">
            <div class="card-header network-header">
              <h6 class="card-title text-center">Network</h6>
            </div>
            <div class="card-body">
              <div class='server-att'>
                <h6 class="card-title text-center">AT&T</h6>
                <p class="card-text text-center att-p" data-toggle="tooltip" data-placement="right"><span><i class="fas fa-ethernet text-success att-icon"></i></span></p>
              </div>
              <p class="card-text text-center"><span><i class="fas fa-arrow-down "></i></span></p>
              <div class='server-gateway'>
                <h6 class="card-title text-center">Local Gateway</h6>
                <p class="card-text text-center gateway-p" data-toggle="tooltip" data-placement="right"><span><i id='gateway-icon' class="fas fa-ethernet text-success gateway-icon"></i></span></p>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-header server-header">
              <h6 class="card-title text-center ">Servers</h6>
            </div>
            <div class="card-body">
              <h6 class="card-title text-center server-name"></h6>
              <p class="card-text text-center server-p" data-toggle="tooltip" data-placement="right" ><span><i class="fas fa-server text-success server-icon"></i></span></p>
            </div>
          </div>
        </div>
        <button type="button" class="alert-btn btn btn-success">Alerts On</button>
      </div>
    </div>
    <!--gonzalez-->
    <div class="card main-card" id='gonzalez-card'>
      <div class='card-header main-header'><h5 class="card-title">Gonzalez</h5></div>
      <div class="card-body collapse">
        <div class="card-deck">
          <div class="card network-card">
            <div class="card-header network-header">
              <h6 class="card-title text-center">Network</h6>
            </div>
            <div class="card-body">
              <div class='server-att'>
                <h6 class="card-title text-center">AT&T</h6>
                <p class="card-text text-center att-p" data-toggle="tooltip" data-placement="right"><span><i class="fas fa-ethernet text-success att-icon"></i></span></p>
              </div>
              <p class="card-text text-center"><span><i class="fas fa-arrow-down "></i></span></p>
              <div class='server-gateway'>
                <h6 class="card-title text-center">Local Gateway</h6>
                <p class="card-text text-center gateway-p" data-toggle="tooltip" data-placement="right"><span><i id='gateway-icon' class="fas fa-ethernet text-success gateway-icon"></i></span></p>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-header server-header">
              <h6 class="card-title text-center ">Servers</h6>
            </div>
            <div class="card-body">
              <h6 class="card-title text-center server-name"></h6>
              <p class="card-text text-center server-p" data-toggle="tooltip" data-placement="right" ><span><i class="fas fa-server text-success server-icon"></i></span></p>
            </div>
          </div>
        </div>
        <button type="button" class="alert-btn btn btn-success">Alerts On</button>
      </div>
    </div>
    <!--pecos-->
    <div class="card main-card" id='pecos-card'>
      <div class='card-header main-header'><h5 class="card-title">Pecos</h5></div>
      <div class="card-body collapse">
        <div class="card-deck">
          <div class="card network-card">
            <div class="card-header network-header">
              <h6 class="card-title text-center">Network</h6>
            </div>
            <div class="card-body">
              <div class='server-att'>
                <h6 class="card-title text-center">AT&T</h6>
                <p class="card-text text-center att-p" data-toggle="tooltip" data-placement="right"><span><i class="fas fa-ethernet text-success att-icon"></i></span></p>
              </div>
              <p class="card-text text-center"><span><i class="fas fa-arrow-down "></i></span></p>
              <div class='server-gateway'>
                <h6 class="card-title text-center">Local Gateway</h6>
                <p class="card-text text-center gateway-p" data-toggle="tooltip" data-placement="right"><span><i id='gateway-icon' class="fas fa-ethernet text-success gateway-icon"></i></span></p>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-header server-header">
              <h6 class="card-title text-center ">Servers</h6>
            </div>
            <div class="card-body">
              <h6 class="card-title text-center server-name"></h6>
              <p class="card-text text-center server-p" data-toggle="tooltip" data-placement="right" ><span><i class="fas fa-server text-success server-icon"></i></span></p>
            </div>
          </div>
        </div>
        <button type="button" class="alert-btn btn btn-success">Alerts On</button>
      </div>
    </div>
    <!--pecos west-->
    <div class="card main-card" id='pecos_west-card'>
      <div class='card-header main-header'><h5 class="card-title">Pecos West</h5></div>
      <div class="card-body collapse">
        <div class="card-deck">
          <div class="card network-card">
            <div class="card-header network-header">
              <h6 class="card-title text-center">Network</h6>
            </div>
            <div class="card-body">
              <div class='server-att'>
                <h6 class="card-title text-center">AT&T</h6>
                <p class="card-text text-center att-p" data-toggle="tooltip" data-placement="right"><span><i class="fas fa-ethernet text-success att-icon"></i></span></p>
              </div>
              <p class="card-text text-center"><span><i class="fas fa-arrow-down "></i></span></p>
              <div class='server-gateway'>
                <h6 class="card-title text-center">Local Gateway</h6>
                <p class="card-text text-center gateway-p" data-toggle="tooltip" data-placement="right"><span><i id='gateway-icon' class="fas fa-ethernet text-success gateway-icon"></i></span></p>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-header server-header">
              <h6 class="card-title text-center ">Servers</h6>
            </div>
            <div class="card-body">
              <h6 class="card-title text-center server-name"></h6>
              <p class="card-text text-center server-p" data-toggle="tooltip" data-placement="right" ><span><i class="fas fa-server text-success server-icon"></i></span></p>
            </div>
          </div>
        </div>
        <button type="button" class="alert-btn btn btn-success">Alerts On</button>
      </div>
    </div>
    <!--barnhart-->
    <div class="card main-card" id='barnhart-card'>
      <div class='card-header main-header'><h5 class="card-title">Barnhart</h5></div>
      <div class="card-body collapse">
        <div class="card-deck">
          <div class="card network-card">
            <div class="card-header network-header">
              <h6 class="card-title text-center">Network</h6>
            </div>
            <div class="card-body">
              <div class='server-att'>
                <h6 class="card-title text-center">AT&T</h6>
                <p class="card-text text-center att-p" data-toggle="tooltip" data-placement="right"><span><i class="fas fa-ethernet text-success att-icon"></i></span></p>
              </div>
              <p class="card-text text-center"><span><i class="fas fa-arrow-down "></i></span></p>
              <div class='server-gateway'>
                <h6 class="card-title text-center">Local Gateway</h6>
                <p class="card-text text-center gateway-p" data-toggle="tooltip" data-placement="right"><span><i id='gateway-icon' class="fas fa-ethernet text-success gateway-icon"></i></span></p>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-header server-header">
              <h6 class="card-title text-center ">Servers</h6>
            </div>
            <div class="card-body">
              <h6 class="card-title text-center server-name"></h6>
              <p class="card-text text-center server-p" data-toggle="tooltip" data-placement="right" ><span><i class="fas fa-server text-success server-icon"></i></span></p>
            </div>
          </div>
        </div>
        <button type="button"class="alert-btn btn btn-success">Alerts On</button>
        <input type='hidden' class='alert-hidden'>
      </div>
    </div>
    
    <!--<div id="add-test"></div>-->
  </div>
</div>



<!-- Color Modal -->
<div class="modal fade" id="legendModal" tabindex="-1" role="dialog" aria-labelledby="legendModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="legendModalLabel">Color Legend</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <button class='btn btn-success'>  </button>The server, switch, or circuit has no issues 
        <br>
        <button class='btn btn-warning'>  </button>The server has alerts off or a service is unreachable
        <br>
        <button class='btn btn-danger'>  </button>The some element of the network or server is unreachable
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



<script>
  $(function () {
    $('.main-header').on('click', function () {
      $(this).next('.card-body').toggleClass('collapse');
    });
    $('.alert-btn').on('click', function () {
      var siteId = $(this).attr('value');
      var status = $(this).data('alert');
      var newStat;
      if (status == 1)
      {
        newStat = 0;
        $(this).html('Alerts Off').addClass('btn-danger');
      } else
      {
        newStat = 1;
        $(this).html('Alerts On').removeClass('btn-danger');
      }
      $(this).data('alert', newStat);
      $.ajax({
        url: '../../Includes/IT/network_sites_alert_switch.php',
        type: 'POST',
        data:
                {
                  siteId: siteId,
                  newStat: newStat
                },
        success: function () {

        }
      });
    });

    site_info();
      window.setInterval( function() {
    site_info();
      }, 1000)
//    setInterval(function(){ alert("Hello"); }, 3000);
//    var cardId = 'test_name'
    
//    $('#add-test').append('<div class="card main-card" id="'+ cardId +'-card"><div class="card-header main-header"><h5 class="card-title"></h5></div><div class="card-body collapse"><div class="card-deck"><div class="card network-card"><div class="card-header network-header"><h6 class="card-title text-center">Network</h6></div><div class="card-body"><div class="server-att"><h6 class="card-title text-center">AT&T</h6><p class="card-text text-center att-p" data-toggle="tooltip" data-placement="right"><span><i class="fas fa-ethernet text-success att-icon"></i></span></p></div><p class="card-text text-center"><span><i class="fas fa-arrow-down "></i></span></p><div class="server-gateway"><h6 class="card-title text-center">Local Gateway</h6><p class="card-text text-center gateway-p" data-toggle="tooltip" data-placement="right"><span><i id="gateway-icon" class="fas fa-ethernet text-success gateway-icon"></i></span></p></div></div></div><div class="card"><div class="card-header server-header"><h6 class="card-title text-center ">Servers</h6></div><div class="card-body"><h6 class="card-title text-center server-name"></h6><p class="card-text text-center server-p" data-toggle="tooltip" data-placement="right" ><span><i class="fas fa-server text-success server-icon"></i></span></p></div></div></div><button type="button"class="alert-btn btn btn-success">Alerts On</button></div></div>');
  })

  function site_info() {
    var permission = <?php echo($permissionLevel); ?>;
    $.ajax({
      url: '../../Includes/IT/network_sites_get.php',
      dataType: 'json',
      success: function (data) {
//         console.log(data)
        $.each(data, function (index) {
//           console.log(data[index].site_name)
          $('#' + data[index].site_name + '-card .server-name').html(data[index].server_name);
          $('#' + data[index].site_name + '-card .att-p').prop('title', 'IP Address: ' + data[index].att_ip + "\nCircut ID: " + data[index].att_circuit);
          $('#' + data[index].site_name + '-card .gateway-p').prop('title', data[index].gateway_ip);
          $('#' + data[index].site_name + '-card .server-p').prop('title', data[index].rtx_ip);
          $('#' + data[index].site_name + '-card .alert-btn').prop('value', data[index].id).data('alert', data[index].alerts_on)

          if (permission < 4)
          {
            $('#' + data[index].site_name + '-card .alert-btn').remove();
          }
          if (data[index].att_status != 1)
          {
            $('#' + data[index].site_name + '-card .att-icon').addClass('text-danger');
            $('#' + data[index].site_name + '-card .gateway-icon').addClass('text-warning');
            $('#' + data[index].site_name + '-card .server-icon').addClass('text-warning');
          } else
          {
            $('#' + data[index].site_name + '-card .att-icon').removeClass('text-danger');
            $('#' + data[index].site_name + '-card .gateway-icon').removeClass('text-warning');
            $('#' + data[index].site_name + '-card .server-icon').removeClass('text-warning');
          }

          if (data[index].gateway_status != 1)
          {
            $('#' + data[index].site_name + '-card .gateway-icon').addClass('text-danger');
            $('#' + data[index].site_name + '-card .server-icon').addClass('text-warning');
          } else
          {
            $('#' + data[index].site_name + '-card .gateway-icon').removeClass('text-danger');
            $('#' + data[index].site_name + '-card .server-icon').removeClass('text-warning');
          }
          if (data[index].rtx_status != 1)
          {
            $('#' + data[index].site_name + '-card .server-icon').addClass('text-danger');
            $('#' + data[index].site_name + '-card .server-header').addClass('bg-danger');
          } else
          {
            $('#' + data[index].site_name + '-card .server-icon').removeClass('text-danger');
            $('#' + data[index].site_name + '-card .server-header').removeClass('bg-danger');
          }
          if (data[index].att_status != 1 || data[index].gateway_status != 1)
          {
            $('#' + data[index].site_name + '-card .network-header').addClass('bg-danger');
          } else
          {
            $('#' + data[index].site_name + '-card .network-header').removeClass('bg-danger');
          }
          if (data[index].att_status != 1 || data[index].gateway_status != 1 || data[index].rtx_status != 1)
          {
            $('#' + data[index].site_name + '-card .main-header').addClass('bg-danger');
          } else
          {
            $('#' + data[index].site_name + '-card .main-header').removeClass('bg-danger');
          }
          if (data[index].att_ip == 0)
          {
            $('#' + data[index].site_name + '-card .network-card').hide();
          }
          if (data[index].alerts_on == 0)
          {
            $('#' + data[index].site_name + '-card .alert-btn').html('Alerts Off').addClass('btn-danger');
            $('#' + data[index].site_name + '-card .main-header').removeClass('bg-danger').addClass('bg-warning');
          }
          $('#last-update').html('LAST UPDATED: ' + data[index].last_update + '<button type="button" class="color-button float-right btn btn-info" data-toggle="modal" data-target="#legendModal">Color Legend</button>')
        });
      },
      complete: function () {
        $('[data-toggle="tooltip"]').tooltip()
      },
      cache: false
    });
  }




</script>
