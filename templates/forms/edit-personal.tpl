<div id="divForm">
	<form id="editPersonalForm" name="editPersonalForm" method="post">
		<fieldset>
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">* Nombre Completo:</div>
                <input class="smallInput medium" name="name" id="name" type="text" value="{$post.name}" size="50"/>
				<hr />
            </div>		
            <div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Tel&eacute;fono:</div>
                <input class="smallInput medium" name="phone" id="phone" type="text" value="{$post.phone}" size="50"/>            	<hr />
			</div>


            <div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Extension:</div>
                <input class="smallInput medium" name="ext" id="ext" type="text" value="{$post.ext}" size="50"/>            	<hr />
			</div>

      <div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Telefono Celular:</div>
                <input class="smallInput medium" name="celphone" id="celphone" type="text" value="{$post.celphone}" size="50"/>            	<hr />
			</div>      
            <div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Correo electr&oacute;nico:</div>
                <input class="smallInput medium" name="email" id="email" type="text" value="{$post.email}" size="50"/>
                <hr />
			</div>

      <div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left"># de Equipo:</div>
                <input class="smallInput medium" name="skype" id="skype" type="text" value="{$post.skype}" size="50"/>            	<hr />
			</div>

      <div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Clave Aspel:</div>
                <input class="smallInput medium" name="aspel" id="aspel" type="text" value="{$post.aspel}" size="50"/>            	<hr />
			</div>

      <div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Puesto de Trabajo:</div>
                <input class="smallInput medium" name="puesto" id="puesto" type="text" value="{$post.puesto}" size="50"/>            	<hr />
			</div>

      <div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Horario de Trabajo:</div>
                <input class="smallInput medium" name="horario" id="horario" type="text" value="{$post.horario}" size="50"/>            	<hr />
			</div>

      <div class="formLine" style="width:100%; text-align:left">
      	<div style="width:30%;float:left">Fecha Ingreso:</div>
				<div style="float:left">
                <input class="smallInput small" name="fechaIngreso" id="fechaIngreso" type="text" value="{$post.fechaIngreso}" size="50" maxlength="10" readonly="readonly"/> 
                </div>
                <div style="float:left; padding-left:5px">
                	<a href="javascript:void(0)" onclick="NewCal('fechaIngreso','ddmmyyyy')">
                	<img src="{$WEB_ROOT}/images/cal.gif" border="0" align="left" />
                    </a>
                </div>            	<hr />
			</div>

      <div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Grupo de Trabajo:</div>
                <input class="smallInput medium" name="grupo" id="grupo" type="text" value="{$post.grupo}" size="50"/>            	<hr />
			</div>

      <div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Clave Computadora</div>
                <input class="smallInput medium" name="computadora" id="computadora" type="text" value="{$post.computadora}" size="50"/>            	<hr />
			</div>      
            <div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Usuario:</div>
                <input class="smallInput medium" name="username" id="username" type="text" value="{$post.username}" size="50"/>            	<hr />
			</div>
            <div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Contrase&ntilde;a:</div>
                <input class="smallInput medium" name="passwd" id="passwd" type="text" value="{$post.passwd}" size="50"/>            	<hr />
			</div>   

          <div class="formLine" style="width:100%; text-align:left">
             <div style="width:30%;float:left">Tipo de Usuario:</div>
             <select name="tipoPersonal" id="tipoPersonal" class="smallInput medium" onchange="ToggleReporta()">
              	<option value="Auxiliar" {if $post.tipoPersonal == "Auxiliar"} selected="selected" {/if}>Auxiliar</option>
              	<option value="Contador" {if $post.tipoPersonal == "Contador"} selected="selected" {/if}>Contador</option>
              	<option value="Supervisor" {if $post.tipoPersonal == "Supervisor"} selected="selected" {/if}>Supervisor</option>
              	<option value="Gerente" {if $post.tipoPersonal == "Gerente"} selected="selected" {/if}>Gerente</option>
              	<option value="Socio" {if $post.tipoPersonal == "Socio"} selected="selected" {/if}>Socio</option>
              	<option value="Asistente" {if $post.tipoPersonal == "Asistente"} selected="selected" {/if}>Asistente</option>
                
             </select>
             <hr />       
          </div>
      
          <div class="formLine" style="width:100%; text-align:left"  id="departamentoDiv">
             <div style="width:30%;float:left">Departamento:</div>
             <select name="departamentoId" id="departamentoId"  class="smallInput medium">
              	<option value="0">Seleccione...</option>
             	{foreach from=$departamentos item=departamento}
              	<option value="{$departamento.departamentoId}" {if $departamento.departamentoId == $post.departamentoId} selected="selected"{/if}>{$departamento.departamento}</option>
              {/foreach}
             </select>
             <hr />       
          </div>	  

          <div class="formLine" style="width:100%; text-align:left;"  id="">
             <div style="width:30%;float:left">Jefe Inmediato:</div>
             <select name="jefeInmediato" id="jefeInmediato"  class="smallInput medium">
              	<option value="0">Seleccione...</option>
             	{foreach from=$personal item=contador}
              	<option value="{$contador.personalId}" {if $contador.personalId == $post.jefeInmediato} selected="selected"{/if}>{$contador.name}</option>
              {/foreach}
             </select>
             <hr />       
          </div>
	  
          {*}<div class="formLine" style="width:100%; text-align:left; {if $post.tipoPersonal == "Auxiliar"}display:block{else}display:none{/if}"  id="jefeContadorDiv">
             <div style="width:30%;float:left">Reporta a Contador:</div>
             <select name="jefeContador" id="jefeContador"  class="smallInput medium">
              	<option value="0">Seleccione...</option>
             	{foreach from=$contadores item=contador}
              	<option value="{$contador.personalId}" {if $contador.personalId == $post.jefeContador} selected="selected"{/if}>{$contador.name}</option>
              {/foreach}
             </select>
             <hr />       
          </div>


          <div class="formLine" style="width:100%; text-align:left; {if $post.tipoPersonal == "Auxiliar" || $post.tipoPersonal == "Contador"} display:block{else}display:none {/if}"  id="jefeSupervisorDiv">
             <div style="width:30%;float:left">Reporta a Supervisor:</div>
             <select name="jefeSupervisor" id="jefeSupervisor" class="smallInput medium">
              	<option value="0">Seleccione...</option>
             	{foreach from=$supervisores item=supervisor}
              	<option value="{$supervisor.personalId}" {if $supervisor.personalId == $post.jefeSupervisor} selected="selected"{/if}>{$supervisor.name}</option>
              {/foreach}
             </select>
             <hr />       
          </div>

          <div class="formLine" style="width:100%; text-align:left; {if $post.tipoPersonal == "Auxiliar" || $post.tipoPersonal == "Contador" || $post.tipoPersonal == "Supervisor"} display:block {else} display:none{/if}"  id="jefeGerenteDiv">
             <div style="width:30%;float:left">Reporta a Gerente:</div>
             <select name="jefeGerente" id="jefeGerente" class="smallInput medium">
              	<option value="0">Seleccione...</option>
             	{foreach from=$gerentes item=gerente}
              	<option value="{$gerente.personalId}" {if $gerente.personalId == $post.jefeGerente} selected="selected"{/if}>{$gerente.name}</option>
              {/foreach}
             </select>
             <hr />       
          </div>

          <div class="formLine" style="width:100%; text-align:left; {if $post.tipoPersonal == "Auxiliar" || $post.tipoPersonal == "Contador" || $post.tipoPersonal == "Supervisor" || $post.tipoPersonal == "Gerente"}  display:block{else} display:none{/if}"  id="jefeSocioDiv">
             <div style="width:30%;float:left">Reporta a Socio:</div>
             <select name="jefeSocio" id="jefeSocio"  class="smallInput medium">
              	<option value="0">Seleccione...</option>
             	{foreach from=$socios item=socio}
              	<option value="{$socio.personalId}" {if $socio.personalId == $post.jefeSocio} selected="selected"{/if}>{$socio.name}</option>
              {/foreach}
             </select>
             <hr />       
          </div>
{*}
             <div class="formLine" style="width:100%; text-align:left">
                <div style="width:30%;float:left">Activo:</div><input name="active" id="active" type="checkbox" {if $post.active}checked{/if} value="1"/>
                <hr />       
              </div>

			<div style="clear:both"></div>
			* Campos requeridos
            <div class="formLine" style="text-align:center; margin-left:300px">            
                <a class="button_grey" id="editPersonal"><span>Actualizar</span></a>           
            </div>			
			<input type="hidden" id="type" name="type" value="saveEditPersonal"/>
			<input type="hidden" id="personalId" name="personalId" value="{$post.personalId}"/>
		</fieldset>
	</form>
</div>
