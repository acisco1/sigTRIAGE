<?= modules::run('Sections/Menu/index'); ?> 
<div class="box-row">
    <div class="box-cell">
        <div class="box-inner padding col-md-6 col-centered"> 
            <div class="panel panel-default " style="margin-top: -20px">
                <div class="panel-heading p teal-900 back-imss">
                    <span style="font-size: 15px;font-weight: 500;text-align: center!important">
                        <strong>INGRESO HOSPITALARIO</strong><br>
                    </span>
                    <!--  BOTON DE AGREGAR EL PACIENTE -->
                    <a  md-ink-ripple="" class="agregar-horacero-paciente md-btn md-fab m-b tip green waves-effect pull-right" data-original-title="Generar Registro">
                        <i class="mdi-social-person-add i-24"></i>
                    </a>
                </div>
                <div class="panel-body b-b b-light">
                    
                    <div class="row" style="margin-top: 0px">
                        <div class="col-sm-12">
                            <div class="md-form-group text-center" style="margin-top: -15px;text-transform: uppercase;font-size: 25px">
                                <b>Hospital de Especialidades del CMN siglo xxi</b>
                            </div> 
                            <div class="md-form-group text-center" style="margin-top: -40px;text-transform: uppercase;font-size: 1.2em">
                                <b>“Dr. Bernardo Sépulveda Gutiérrez”</b><br>
                            </div> 
                            <div class="md-form-group text-center " style="margin-top: 0px;text-transform: uppercase;font-size: 1.2em">
                                <button class="btn btn-primary btn-continuar-horacero" style="display: none"><i class="mdi-navigation-arrow-forward i-24"></i>Continuar</button>
                            </div> 
                            <div class="md-form-group text-center" style="margin-top:calc(10%)">
                                Av. Cuauhtémoc 330, Col. Doctores Del. Cuauhtémoc
                            </div> 

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?= modules::run('Sections/Menu/footer'); ?>
<script src="<?= base_url('assets/js/ConsultaExterna.js?').md5(microtime())?>" type="text/javascript"></script>