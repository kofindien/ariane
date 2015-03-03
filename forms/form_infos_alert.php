<div><strong></strong></div>

    <div class="control-group">
        <label class="control-label" for="lservice"></label>
        <div class="controls">
            <input name="lservice" type="hidden" readonly class="input-large" id="lservice" value="Alertes voyages">
            <input name="ids" id="ids" type="hidden" value="3">
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="vol"></label>
        <div class="controls">
            <input name="vol" type="hidden" readonly class="input-large" id="vol" value="<?= trim($_SESSION['vol']); ?>">
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="ddepart"></label>
        <div class="controls">
            <input name="ddepart" type="hidden" readonly class="input-large" id="ddepart" value="<?= trim($_SESSION['ddepart']); ?>">
        </div>
    </div>

    <div class="control-group warning">
        <label class="control-label" for="nheure"> <span class="rouge"></span></label>

        <div class="controls">
     <span id="sprytextfield1">
     <input name="Heurevol" type="hidden" required class="span1" id="heure" value="<?= $_SESSION['Heurevol'] ; ?>" />
     </span>
            <span class="help-inline"></span><span id="sprytextfield2">
     <input name="Minuitevol" type="hidden" required class="span1" id="minute" value="<?= $_SESSION['Minuitevol'] ; ?>"/>
     </span>
            <span class="help-inline"></span>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="cout"></label>
        <div class="controls">
            <div class="input-append">
                <input type="hidden" id="cout" name="montant" class="input-small" style="text-align:right" value="<?= $_SESSION['montant'] ; ?>" readonly="readonly">
            </div>
        </div>
    </div>