<select class="smallInput" name="status" id="status" onchange="checkStatus()">
<option value="">Seleccione</option>
<option value="firmado" {if $info.status == "firmado"}selected{/if}>Firmado</option>
<option value="proceso" {if $info.status == "proceso"}selected{/if}>Proceso</option>
<option value="cancelado" {if $info.status == "cancelado"}selected{/if}>Cancelado</option>
</select>