<?= modules::run('Sections/Menu/HeaderBasico'); ?> 
<div class="box-row" >
    <div class="box-cell">
        <div class="box-inner padding col-md-6 col-centered"> 
            <div class="panel panel-default " style="margin-top: -10px">
                <div class="panel-heading p teal-900 back-imss">
                    <span style="font-size: 15px;font-weight: 500">
                        <strong>HORA CERO</strong><br>
                    </span>
                    <div style="position: relative">
                        <div style="position: absolute;right: 0px;top: -24px;">
                            <i class="pointer pantalla-completa accion-windows fa fa-arrows-alt fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="panel-body b-b b-light">
                    
                    <div class="row" style="margin: calc(20%) 0px 0px 0px">
                        <div class="col-sm-12">
                            <div class="md-form-group text-center" style="margin-top: -15px;text-transform: uppercase;font-size: 35px">
                                <b>Hospital de Traumatología</b>
                            </div> 
                            <div class="md-form-group text-center" style="margin-top: -40px;text-transform: uppercase;font-size: 1.5em">
                                <b>“Dr. Victorio de la Fuente Narváez”</b><br><br>
                            </div> 
                        </div>
                        <div class="col-md-12">
                            
                            <center>
                                <style>
                                    .agregar-horacero-paciente i{ color: white;}.agregar-horacero-paciente i:hover{color: white;}
                                </style>
                                <a  md-ink-ripple="" class="agregar-horacero-paciente-movil md-btn md-fab m-b back-imss waves-effect " style="width: 460px;height: 460px;padding: 120px">
                                    <i class="fa fa-user-plus fa-5x" style="font-size: 200px!important"></i>
                                </a>
                            </center>
                        </div>
                        <div class="col-md-12">
                            <div class="md-form-group text-center" style="margin-top:calc(10%);margin-bottom: calc(10%);font-size: 18px">
                                Av. Colector 15 S/N esq. Av. Instituto Politécnico Nacional, Col. Magdalena de las Salinas. Del. Gustavo a. Madero
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="FullScreen" value="Si">
<?= modules::run('Sections/Menu/FooterBasico'); ?>
<script src="<?= base_url('assets/js/Horacero.js?').md5(microtime())?>" type="text/javascript"></script>