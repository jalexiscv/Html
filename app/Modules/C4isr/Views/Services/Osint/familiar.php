<div class="container mt-5">
    <form>
        <h2>Datos Básicos</h2>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="cedula">Cédula</label>
                <input type="text" class="form-control" id="cedula" name="cedula"
                       value="<?php echo $vector['Persona']['DatoBasico']['cedula']; ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label for="nropersona">Nro. Persona</label>
                <input type="text" class="form-control" id="nropersona" name="nropersona"
                       value="<?php echo $vector['Persona']['DatoBasico']['nropersona']; ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label for="nacionalidad">Nacionalidad</label>
                <input type="text" class="form-control" id="nacionalidad" name="nacionalidad"
                       value="<?php echo $vector['Persona']['DatoBasico']['nacionalidad']; ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label for="nombreprimero">Primer Nombre</label>
                <input type="text" class="form-control" id="nombreprimero" name="nombreprimero"
                       value="<?php echo $vector['Persona']['DatoBasico']['nombreprimero']; ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label for="nombresegundo">Segundo Nombre</label>
                <input type="text" class="form-control" id="nombresegundo" name="nombresegundo"
                       value="<?php echo $vector['Persona']['DatoBasico']['nombresegundo']; ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label for="apellidoprimero">Primer Apellido</label>
                <input type="text" class="form-control" id="apellidoprimero" name="apellidoprimero"
                       value="<?php echo $vector['Persona']['DatoBasico']['apellidoprimero']; ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label for="apellidosegundo">Segundo Apellido</label>
                <input type="text" class="form-control" id="apellidosegundo" name="apellidosegundo"
                       value="<?php echo $vector['Persona']['DatoBasico']['apellidosegundo']; ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label for="fechanacimiento">Fecha de Nacimiento</label>
                <input type="text" class="form-control" id="fechanacimiento" name="fechanacimiento"
                       value="<?php echo $vector['Persona']['DatoBasico']['fechanacimiento']; ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label for="sexo">Sexo</label>
                <input type="text" class="form-control" id="sexo" name="sexo"
                       value="<?php echo $vector['Persona']['DatoBasico']['sexo']; ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label for="estadocivil">Estado Civil</label>
                <input type="text" class="form-control" id="estadocivil" name="estadocivil"
                       value="<?php echo $vector['Persona']['DatoBasico']['estadocivil']; ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label for="fechadefuncion">Fecha de Defunción</label>
                <input type="text" class="form-control" id="fechadefuncion" name="fechadefuncion"
                       value="<?php echo $vector['Persona']['DatoBasico']['fechadefuncion']; ?>">
            </div>
        </div>

        <h2>Datos Físicos</h2>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="peso">Peso</label>
                <input type="text" class="form-control" id="peso" name="peso"
                       value="<?php echo $vector['Persona']['DatoFisico']['peso']; ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label for="talla">Talla</label>
                <input type="text" class="form-control" id="talla" name="talla"
                       value="<?php echo $vector['Persona']['DatoFisico']['talla']; ?>">
            </div>
        </div>

        <h2>Datos Fisionómicos</h2>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="gruposanguineo">Grupo Sanguíneo</label>
                <input type="text" class="form-control" id="gruposanguineo" name="gruposanguineo"
                       value="<?php echo $vector['Persona']['DatoFisionomico']['gruposanguineo']; ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label for="colorpiel">Color de Piel</label>
                <input type="text" class="form-control" id="colorpiel" name="colorpiel"
                       value="<?php echo $vector['Persona']['DatoFisionomico']['colorpiel']; ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label for="colorojos">Color de Ojos</label>
                <input type="text" class="form-control" id="colorojos" name="colorojos"
                       value="<?php echo $vector['Persona']['DatoFisionomico']['colorojos']; ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label for="colorcabello">Color de Cabello</label>
                <input type="text" class="form-control" id="colorcabello" name="colorcabello"
                       value="<?php echo $vector['Persona']['DatoFisionomico']['colorcabello']; ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label for="estatura">Estatura</label>
                <input type="text" class="form-control" id="estatura" name="estatura"
                       value="<?php echo $vector['Persona']['DatoFisionomico']['estatura']; ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label for="senaparticular">Seña Particular</label>
                <input type="text" class="form-control" id="senaparticular" name="senaparticular"
                       value="<?php echo $vector['Persona']['DatoFisionomico']['senaparticular']; ?>">
            </div>
        </div>

        <h2>Partida de Nacimiento</h2>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="registro">Registro</label>
                <input type="text" class="form-control" id="registro" name="registro"
                       value="<?php echo $vector['Persona']['PartidaNacimiento']['registro']; ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label for="ano">Año</label>
                <input type="text" class="form-control" id="ano" name="ano"
                       value="<?php echo $vector['Persona']['PartidaNacimiento']['ano']; ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label for="acta">Acta</label>
                <input type="text" class="form-control" id="acta" name="acta"
                       value="<?php echo $vector['Persona']['PartidaNacimiento']['acta']; ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label for="folio">Folio</label>
                <input type="text" class="form-control" id="folio" name="folio"
                       value="<?php echo $vector['Persona']['PartidaNacimiento']['folio']; ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label for="libro">Libro</label>
                <input type="text" class="form-control" id="libro" name="libro"
                       value="<?php echo $vector['Persona']['PartidaNacimiento']['libro']; ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label for="img">Imagen</label>
                <input type="text" class="form-control" id="img" name="img"
                       value="<?php echo $vector['Persona']['PartidaNacimiento']['img']; ?>">
            </div>
        </div>
    </form>
</div>